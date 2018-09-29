<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Zend\Permissions\Acl\Acl as AclCore;
use \Zend\Permissions\Acl\Role\GenericRole as AclRole;
use \Zend\Permissions\Acl\Resource\GenericResource as AclResource;

/**
 *
 */
class Acl extends CI_Config
{

    // Set the instance variable
    var $CI;

    /**
     * The ACL Object
     *
     * @var \Zend\Permissions\Acl\Acl
     */
    private $acl;

    private $identity;

    function __construct() {

        parent::__construct();

        $CI =& get_instance();

        $this->identity = $CI->session->all_userdata();

        // set GUEST role
        $role = ROLE_GUEST;

        if (!isset($this->identity['role'])) {
            $values = array('user_id'=>null,
                            'logged_in'=>FALSE,
                            'role' => $role, // role_name
                            'url' => isset($this->config['roles'][$role]['url'])?$this->config['roles'][$role]['url']:""
            );
            $CI->session->set_userdata($values);
        }

        $acl = new AclCore();

        // Set the default ACL
        $this->initAcl($acl, $modules = []);

        $this->acl = $acl;
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $resource
     * @param string $grant
     * @param int $company_id  what company user is working.
     * @return bool
     * @internal param string $role
     */
    public function isAllowed($resource = null, $grant = GRANT_READ, $company_id = null) {
        $module = "";
        if ($resource == null) {
            $resource = $this->getResourceName();
        }

        $CI = &get_instance();
        if ($CI->input->is_cli_request())
		{
			$role = ROLE_CRON;
		}
        elseif (isset($this->identity['role']))
		{
			$role = $this->identity['role'];
		}
        else
		{
			$role = ROLE_GUEST;
		}

        $resources = $this->config['acl'];

        try {
            $isAllowed = false;
            if (isset($resources[$resource])) {
                $module = isset($resources[$resource]['module'])?$resources[$resource]['module']:"";
                $isAllowed = $this->getAcl()->isAllowed($role, $resource, $grant);
            } else {
                $pos = strrpos($resource, "/");
                if ($pos) {
                    $parts = substr($resource, 0, $pos);
                    $resource = $parts.'/*';
                    if (isset($resources[$resource])) {
                        $module = isset($resources[$resource]['module'])?$resources[$resource]['module']:"";
                        $isAllowed = $this->getAcl()->isAllowed($role, $resource, $grant);
                    }
                } else {
                    $resource = $company_id.":".$resource;
                    $isAllowed = $this->getAcl()->isAllowed($role, $resource, $grant);
                }
            }
            if ($isAllowed && !empty($module)) {
                $resource = $module;
                $isAllowed = $this->getAcl()->isAllowed($role, $resource, GRANT_READ);
            }
        } catch (\Exception $e) {
            $isAllowed = false;
        }

        if ($role == ROLE_CRON)
		{
			echo 'Debug: cron access to '.$resource.': '.($isAllowed?'Access allowed':'Access denied')."\n";
		}

        return $isAllowed;
    }

    public function getResourceData($resource = null) {
        $result = [];
        if ($resource == null) {
            $module = $this->dispatcher->getModuleName();
            $controller = $this->dispatcher->getControllerName();
            $resource = $controller."/".$this->dispatcher->getActionName();
            $resource = empty($module)?$resource:($module."/".$resource);
        }
        $resources = $this->config->acl->toArray();
        if (isset($resources[$resource])) {
            $result = $resources[$resource];
        } else {
            $pos = strrpos($resource, "/");
            if ($pos) {
                $parts = substr($resource, 0, $pos);
                $resource = $parts.'/*';
                if (isset($resources[$resource])) {
                    $result = $resources[$resource];
                }
            }
        }
        return $result;
    }

    /**
     * Returns the ACL list
     *
     * @return \Zend\Permissions\Acl\Acl
     */
    public function getAcl()
    {
        //apcu_clear_cache();

        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // Check if the ACL is in APC
//        if (function_exists('apcu_fetch')) {
//            $acl = apcu_fetch('MIS-fmp-acl');
//            if (is_object($acl)) {
//                $this->acl = $acl;
//                return $acl;
//            }
//        }

         $this->rebuild();

//        // Check if the ACL is already generated
//        if (!file_exists(CACHE_DIR . $this->filePath)) {
//            $this->acl = $this->rebuild();
//            return $this->acl;
//        }
//
//        // Get the ACL from the data file
//        $data = file_get_contents(CACHE_DIR . $this->filePath);
//        $this->acl = unserialize($data);

        // Store the ACL in APC

//        if (function_exists('apcu_store')) {
//            apcu_store('MIS-fmp-acl', $this->acl);
//        }

        return $this->acl;
    }

    public function getRolesByResource($resource = null, $grant = GRANT_READ, $company_id = null) {
        $roles = [];
        foreach ($this->acl->getRoles() as $role) {
            if ($this->isAllowed($resource, $grant, $company_id)) {
                $roles[] = $role;
            }
        }
        return $roles;
    }

    /**
     * Rebuilds the access list into a file
     *
     * @return \Zend\Permissions\Acl\Acl
     */
    public function rebuild()
    {
        //$acl = new AclMemory();
        $acl = new AclCore();

        $identity = $this->auth->getIdentity();
        $modules = isset($identity['modules'][EMPTY_COMPANY_ID])?$identity['modules'][EMPTY_COMPANY_ID]:[];

        // Registerт ACL for super roles. Each super role has access to all resources of all companies.
        $this->initAcl($acl, null, $modules);

        // Register ACL for empty company. I create it to avoid access user to resources of other company
        // Any user without company will have role and access to resources of empty company
        // Please note that super admin can be exist!


        $this->initAcl($acl, EMPTY_COMPANY_ID, $modules);


        if (isset($identity)) {
            foreach ($identity['companies'] as $company_id => $role_id) {
                $this->initAcl($acl, $company_id, $identity['modules'][$company_id]);
            }
        }

//        if (touch(CACHE_DIR . $this->filePath) && is_writable(CACHE_DIR . $this->filePath)) {
//
//            file_put_contents(CACHE_DIR . $this->filePath, serialize($acl));
//
//            // Store the ACL in APC
//            if (function_exists('apcu_store')) {
//                apcu_store('MIS-fmp-acl', $acl);
//            }
//        } else {
//            $this->flash->error(
//                'The user does not have write permissions to create the ACL list at ' . CACHE_DIR . $this->filePath
//            );
//        }

        $this->acl = $acl;
    }

    private function initAcl(AclCore $acl, $modules = []) {

        // Get the instance
        $CI =& get_instance();

        $roles = $CI->config->item('roles');
        foreach ($roles as $role => $params) {
            $parentRole = isset($params['parent'])?$params['parent']:null;
            $acl->addRole(new AclRole($role), $parentRole);
        }

        $resources = $CI->config->item('acl');
        $moduleList = array_keys((array)$CI->config->item('module'));
        foreach ($resources as $resource => $grant) {
            $acl->addResource(new AclResource($resource));
        }

        foreach ($resources as $resource => $grant) {
            if (isset($grant['allow'])) {
                foreach ($grant['allow'] as $role => $grants) {
                    foreach ($grants as $g) {
                        // if this is company and resource is module
                        if (in_array($resource, $moduleList)) {
                            // not provide privileges if this module doesn't belong to company.
                            if (in_array($resource, $modules)) {
                                // provide privileges in case company purchased the module
								if (isset($grant['assert']) && class_exists($grant['assert'])) {
									$acl->allow($role, $resource, $g, new $grant['assert']());
								} else {
									$acl->allow($role, $resource, $g);
								}
                            }
                        } else {
							if (isset($grant['assert']) && class_exists($grant['assert'])) {
								$acl->allow($role, $resource, $g, new $grant['assert']());
							} else {
								$acl->allow($role, $resource, $g);
							}
                        }
                    }
                }
            }
            if (isset($grant['deny'])) {
                foreach ($grant['deny'] as $role => $grants) {
                    foreach ($grants as $g) {
                        if (in_array($resource, $moduleList)) {
                            if (in_array($resource, $modules)) {
                                $acl->deny($role, $resource, $g);
                            }
                        } else {
                            $acl->deny($role, $resource, $g);
                        }
                    }
                }
            }
        }
    }

    public function isSuperRole($role) {
        $superRoles = $this->config->superRoles->toArray();
        return in_array($role, $superRoles);
    }

    public function getResourceName() {

        $CI =& get_instance();

        $module = null;
        $controller = $CI->router->fetch_class();
        $resource = $controller."/".$CI->router->fetch_method();
        return empty($module)?$resource:($module."/".$resource);
    }

}
