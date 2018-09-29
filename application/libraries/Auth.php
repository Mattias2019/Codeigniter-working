<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * Manages Authentication/Identity Management
 */
class Auth {

    private $_user;
    private $_company;

    function __construct() {
    }

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolan
     */
    public function check($credentials) {

        // Check if the user exist
        $user = User::findFirstByUserEmail($credentials['user_email']);
        if ($user == false) {
            $this->registerUserThrottling(0);
            throw new AuthException('Wrong email/password combination');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->getPassword())) {
            $this->registerUserThrottling($user->getUserId());
            throw new AuthException('Wrong email/password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($user);

        // Regasdfister the successful login
        $this->saveSuccessLogin($user);

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnviroment($user);
        }

        // Save user's data to session
        $this->initSession($user);
        return $user;
    }

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolan
     */
    public function check_id($credentials) {

        // Check if the user exist
        // $a = $this->config->module->toArray();

        $u = 'MIS\Models\User';
        $su = 'MIS\Store\Models\SubsUser';

        $user = User::query()
            ->join($su, $u . ".user_id = " . $su . ".user_id")
            ->andWhere($su . ".customer_id = :id:", ['id' => $credentials['user_email']])
            ->execute();

        if ($user->count() <= 0) {
            $this->registerUserThrottling(0);
            throw new AuthException('Wrong Customer Id/Password combination');
        }

        $user = $user->getFirst();

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->getPassword())) {
            $this->registerUserThrottling($user->getUserId());
            throw new AuthException('Wrong Customer Id/Password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($user);

        // Regasdfister the successful login
        $this->saveSuccessLogin($user);

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnviroment($user);
        }

        // Save user's data to session
        $this->initSession($user);
        return $user;
    }

    public function initSession($user) {

        $CI =& get_instance();

        $role = $user->role_name;

        // Prepare array before save to session.
        $identity = array(
            'id' => $user->id,
            'name' => $user->user_name,
            'role_id' => $user->role_id,
            'role_name' => $user->role_name,
            'email' => $user->email,
            'url' => isset($this->config['roles'][$role]['url'])?$this->config['roles'][$role]['url']:"",
            'companies' => [],
            'modules' => []
        );

        // Store to session data about user and his companies
        $CI->session->set('auth-identity', $identity);

        $this->session->set('auth-identity', $identity);
        $this->acl->rebuild();
    }
    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param \MIS\Models\User $user
     */
    public function saveSuccessLogin($user) {
        $successLogin = new SuccessLogin();
        $successLogin->setUserId($user->getUserId());
        $successLogin->setIpAddress($this->request->getClientAddress());
        $successLogin->setUserAgent($this->request->getUserAgent());
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            throw new AuthException($messages[0]);
        }
    }

    /**
     * Implements login throttling
     * Reduces the efectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId) {
        $failedLogin = new FailedLogin();
        $failedLogin->setUserId($userId == 0?null:$userId);
        $failedLogin->setIpAddress($this->request->getClientAddress());
        $failedLogin->setAttempted(time());
        $failedLogin->save();

        $attempts = FailedLogin::count(array(
            'ip_address = ?0 AND attempted >= ?1',
            'bind' => array(
                $this->request->getClientAddress(),
                time() - 3600 * 6
            )
        ));

        switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param \MIS\Models\User $user
     */
    public function createRememberEnviroment(User $user) {
        $userAgent = $this->request->getUserAgent();
        $token = md5($user->getUserEmail() . $user->getPassword() . $userAgent);

        $remember = new RememberToken();
        $remember->setUserId($user->getUserId());
        $remember->setToken($token);
        $remember->setUserAgent($userAgent);

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->getUserId(), $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return \Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = User::findFirstByUserId($userId);
        if ($user) {

            $userAgent = $this->request->getUserAgent();
            $token = md5($user->getUserEmail() . $user->getPassword() . $userAgent);

            if ($cookieToken == $token) {

                $remember = RememberToken::findFirst(array(
                    'user_id = ?0 AND token = ?1',
                    'bind' => array(
                        $user->getUserId(),
                        $token
                    )
                ));
                if ($remember) {

                    // Check if the cookie has not expired
                    if ((time() - (86400 * 8)) < $remember->getCreatedAt()) {

                        // Check if the user was flagged
                        $this->checkUserFlags($user);

                        // Register identity
                        $this->initSession($user);

                        // Register the successful login
                        $this->saveSuccessLogin($user);

                        return $this->response->redirect('user');
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

        return $this->response->redirect('auth/index');
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param \MIS\Models\User $user
     */
    public function checkUserFlags(User $user)
    {
//        if ($user->getActive() != YES) {
//            throw new AuthException('The user is inactive');
//        }

        if ($user->getBanned() != NO) {
            throw new AuthException('The user is banned');
        }

        if ($user->getSuspended() != NO) {
            throw new AuthException('The user is suspended');
        }
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        $identity = $this->session->get('auth-identity');
        if (!isset($identity)) {
            $identity = array(
                'user_id' => 0,
                'role_id' => ROLE_GUEST,
                'locale' => 'en',
                'timezone' => 'Europe/London',
                'url' => '/'
            );

//            $GUEST = ROLE_GUEST;
//            foreach ($this->config->module as $module => $data) {
//                if (isset($this->config->acl->$module) &&
//                    isset($this->config->acl->$module->allow->$GUEST)) {
//                    $guest = $this->config->acl->$module->allow->$GUEST->toArray();
//                    if (count($guest) > 0) {
//                        $identity['modules'][EMPTY_COMPANY_ID][] = $module;
//                    }
//                }
//            }

            $this->session->set('auth-identity', $identity);
        }
        return $identity;
    }

    public function selectCompany($company_id) {
        $identity = $this->session->get('auth-identity');
        if (isset($identity['companies'][$company_id])) {
            $identity['company_id'] = $company_id;
            $identity['role_id'] = $identity['companies'][$company_id];
            $r = explode(':', $identity['role_id']);
            $r = count($r) > 1?$r[1]:$r[0];
            $identity['url'] = $this->config->roles->$r->url;
            $this->session->set('auth-identity', $identity);
            $userCompany = UserCompany::findFirst([
                'user_id = :user_id: and company_id = :company_id:',
                'bind' => ['user_id' => $this->getUser()->getUserId(),
                    'company_id' => $company_id]]);
            if ($userCompany instanceof UserCompany) {
                $userCompany->save();
            }
        }
    }


    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->getIdentity();
        return $identity['name'];
    }
    
    /**
     * Returns the current role
     *
     * @return int
     */
    public function getRoleId() {
        $identity = $this->getIdentity();
        $r = explode(':', $identity['role_id']);
        return count($r) > 1?$r[1]:$r[0];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth-identity');
        $this->session->remove('cart');
        $this->session->destroy();
        if (function_exists('apcu_clear_cache')) {
            apcu_clear_cache();
        }
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     */
    public function authUserById($id)
    {
        $user = User::findFirstByUserId($id);
        if ($user == false) {
            throw new AuthException('The user does not exist');
        }
        $this->checkUserFlags($user);
        $this->initSession($user);
    }

    /**
     * Get the entity related to user in the active identity
     *
     * @return \MIS\Models\User
     */
    public function getUser()
    {
        $identity = $this->getIdentity();
        if (isset($identity['id'])) {
            if (!($this->_user instanceof User) || $this->_user->getUserId() != $identity['id']) {
                $this->_user = User::findFirstByUserId($identity['id']);
                if ($this->_user == false) {
                    return false;
                }
            }
            return $this->_user;
        }

        return false;
    }
    
    public function getCompany() {
        $identity = $this->getIdentity();
        if (isset($identity['company_id'])) {
            if (!($this->_company instanceof User) || $this->_company->getCompanyId() != $identity['company_id']) {
                $this->_company = Company::findFirstByCompanyId($identity['company_id']);
                if ($this->_company == false) {
                    return false;
                }
            }
            return $this->_company;
        }

        return false;
    }

//    public function isModule($moduleId) {
//        $identity = $this->session->get('auth-identity');
//        $companyId = $identity['company_id'];
//        $modules = $identity['modules'];
//        return isset($modules[$companyId]) && in_array($moduleId, $modules[$companyId]);
//    }
}
