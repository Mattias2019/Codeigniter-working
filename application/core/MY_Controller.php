<?php

class MY_Controller extends \CI_Controller {

    private $acl;
    private $identity;

	public $outputData;
	public $logged_in_user;

    // Constructor
    function __construct()
    {
        parent::__construct();

        // Libraries
        $this->load->library('session');
		$this->load->library('settings');

		//Get Config Details From Db
		$this->settings->db_config_fetch();

        // Models
        $this->load->model('common_model');
		$this->load->model('user_model');

        $this->identity = $this->session->all_userdata();

        $resource = $this->getResourceName();
        $module = null;

        // Language
		load_lang('enduser/common');

		$this->outputData = $this->common_model->get_head();
		$this->logged_in_user = $this->common_model->get_logged_in_user();
		$this->outputData['logged_in_user']	= $this->logged_in_user;
        $this->outputData['js_init'] = "";

		// Load CSS/JS
		$this->add_css([
			'application/fonts/font-awesome-4.7.0/css/font-awesome.min.css',
			'application/fonts/lato/css/fonts.css',
			'application/css/css/tmpl-css/simple-line-icons.min.css',
			'application/css/css/tmpl-css/components.min.css',
			'application/css/css/tmpl-css/plugins.min.css',
			'application/css/css/tmpl-css/layout.min.css',
			'application/css/css/tmpl-css/default.min.css',
			'application/css/css/tmpl-css/custom.min.css',
			'application/css/css/common.css',
			'application/css/css/toastr.min.css',
			'application/css/style.css?v='.time(),
            'application/css/admin/admin.css'
		]);

		$this->add_js([
//			'application/js/tmpl-js/jquery.min.js',
			'application/views/chatigniter/css/jquery-ui.js',
			'application/js/bootstrap_tooltip_fixer.js',
			'application/js/tmpl-js/bootstrap.min.js',
			'application/js/tmpl-js/js.cookie.min.js',
			'application/js/tmpl-js/jquery.slimscroll.min.js',
			'application/js/tmpl-js/moment.min.js',
			'application/js/tmpl-js/counterup/jquery.counterup.js',
			'application/js/tmpl-js/counterup/jquery.counterup.min.js',
			'application/js/tmpl-js/counterup/jquery.waypoints.min.js',
			'application/js/tmpl-js/app.min.js',
			'application/js/tmpl-js/quick-sidebar.min.js',
            'application/js/tmpl-js/quick-nav.min.js',
			'application/js/jquery.flexisel.js',
			'application/js/jquery.watermarkinput.js',
			'application/js/toastr.min.js',
			'application/js/size-text.js',
			'application/js/notifications.js',
			'application/js/jquery.blockui.min.js',
			'application/js/main.js',
            'application/js/bootbox.min.js',
		]);

		if (isset($this->logged_in_user->id))
		{
			$this->add_css([
				'application/views/chatigniter/css/chat.css',
				'application/plugins/shoutbox/jquery.feedback_me.css',
                'application/css/css/jquery.rateyo.min.css'
			]);

			$this->add_js([
				'application/views/chatigniter/css/main.js',
				'application/views/chatigniter/css/chatigniter.js',
				'application/plugins/shoutbox/jquery.feedback_me.js',
				'application/js/jquery.rateyo.min.js',
				'application/js/chat.js',
				'application/js/header.js'
			]);

			if (!$this->input->is_ajax_request())
			{
				$this->load_sidebar_data();
			}
		}

		// Check access
        $acl = new Acl();

        if (!$acl->isAllowed($resource, GRANT_READ)) {

            if ($this->input->is_ajax_request()) {
                /* restrict access to ajax request */
                $success_msg = t('You don\'t have access to resource : '.$resource);
                echo response(['message' => $success_msg], true);
                die();
            } else {
                if ($this->identity['user_id'] == 0) {

                    /*Flash*/
                    $success_msg = t('You don\'t have access to resource : '.$resource);
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/

                    redirect('home/index');
                } else {

                    /*Flash*/
                    $success_msg = t('You don\'t have access to resource : '.$resource);
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/
                    redirect('information');
                }
            }
            return false;
        }
        return true;
    }

	/**
	 * Load dynamic data for sidebar
	 */
    private function load_sidebar_data()
	{
		$this->load->model('cancel_model');
		$this->load->model('messages_model');
		$this->load->model('notification_model');
		$this->load->model('project_model');
		$this->load->model('quote_model');
		$this->load->model('finance_model');

		$this->outputData['unread_notifications'] = $this->notification_model->get_latest($this->logged_in_user->id, TRUE);
		$this->outputData['unread_notifications_amount'] = count($this->notification_model->get_latest($this->logged_in_user->id, TRUE));

		$this->outputData['count_new_projects'] = $this->project_model->get_new_projects_count($this->logged_in_user->id);
		$this->outputData['count_tender_projects'] = $this->project_model->get_tender_projects_count($this->logged_in_user->id);
		$this->outputData['count_quote_requests'] = $this->project_model->get_requested_projects_count($this->logged_in_user->id);
		$this->outputData['count_active_projects'] = $this->project_model->get_active_projects_count($this->logged_in_user->id);
		//$this->outputData['count_won_quotes'] = $this->project_model->get_won_quotes_count($this->logged_in_user->id);
		//$this->outputData['count_pending_quotes'] = $this->project_model->get_pending_quotes_count($this->logged_in_user->id);
		$this->outputData['count_disputes'] = $this->cancel_model->get_user_cases_count($this->logged_in_user->id);
		$this->outputData['count_unread_messages'] = $this->messages_model->get_inbox_unread_count($this->logged_in_user->id);
		$this->outputData['team_online'] = $this->user_model->get_contacts($this->logged_in_user->id, FALSE);

//		$this->outputData['user_projects'] = $this->project_model->get_user_projects($this->logged_in_user->id);
		$this->outputData['user_projects'] = $this->project_model->get_active_projects($this->logged_in_user->id);

		// Workflow
		if (!empty($_SESSION['workflow_id'])) {
			$res = $this->get_workflow($_SESSION['workflow_id']);
			$_SESSION['workflow'] = $res['view'];
		}
	}

	/**
	 * @param array $css
	 */
	protected function add_css($css = [])
	{
        if (! is_array($css)) {
            $css = [$css];
        }

        foreach($css as $k => $v) {
            $file = getcwd() . DIRECTORY_SEPARATOR . $v;
            if (file_exists($file)) {
                $css[$k] = $v . '?' . filemtime($file);
            }
        }

		if (array_key_exists('css', $this->outputData))
		{
			if (is_array($css))
			{
				$this->outputData['css'] = array_merge($this->outputData['css'], $css);
			}
			else
			{
				$this->outputData['css'][] = $css;
			}
		}
		else
		{
			if (is_array($css))
			{
				$this->outputData['css'] = $css;
			}
			else
			{
				$this->outputData['css'] = [$css];
			}
		}
	}

	/**
	 * @param array $js
	 */
	protected function add_js($js = [])
	{
	    if (! is_array($js)) {
	        $js = [$js];
        }

        foreach($js as $k => $v) {
	        $file = getcwd() . DIRECTORY_SEPARATOR . $v;
	        if (file_exists($file)) {
	            $js[$k] = $v . '?' . filemtime($file);
            }
        }

		if (array_key_exists('js', $this->outputData))
		{
			if (is_array($js))
			{
				$this->outputData['js'] = array_merge($this->outputData['js'], $js);
			}
			else
			{
				$this->outputData['js'][] = $js;
			}
		}
		else
		{
			if (is_array($js))
			{
				$this->outputData['js'] = $js;
			}
			else
			{
				$this->outputData['js'] = [$js];
			}
		}
	}

    protected function init_js($init) {
        if (!empty ($init)) {
            $script = "";
            $init = is_array($init)?$init:array($init);
            foreach ($init as $value) {
                $script .= "try{" . $value . "}catch(e){alert('Machinery Marketplace JS INIT ERROR: '+e)}\n";
            }
            $script = "jQuery(function () { $script });";
            $this->outputData['js_init'] = $script;
        }
    }

    private function getResourceName() {


		$directory = $this->router->fetch_directory();
        $controller = $this->router->fetch_class();
        $resource = $controller."/".$this->router->fetch_method();
        return $directory.$resource;
    }

    public function isAllowed($grant = GRANT_READ, $company_id = null) {
        $resource = $this->getResourceName();
        return $this->acl->isAllowed($resource, $grant, $company_id);
    }

    public function allowRead($resource = null, $company_id = null) {
        $resource = $resource == null?$this->getResourceName():$resource;
        return $this->acl->isAllowed($resource, GRANT_READ, $company_id);
    }

    public function allowWrite($resource = null, $company_id = null) {
        $resource = $resource == null?$this->getResourceName():$resource;
        return $this->acl->isAllowed($resource, GRANT_WRITE, $company_id);
    }

    public function allowExecute($resource = null, $company_id = null) {
        $resource = $resource == null?$this->getResourceName():$resource;
        return $this->acl->isAllowed($resource, GRANT_EXECUTE, $company_id);
    }

    public function accessRead($company_id = null, $resource = null) {
        if (!$this->allowRead($resource, $company_id)) {
            $this->response->redirect('index/error404');
        }
    }

    public function accessWrite($company_id = null, $resource = null) {
        if (!$this->allowWrite($resource, $company_id)) {
            $this->response->redirect('index/error404');
        }
    }

    public function accessExecute($company_id = null, $resource = null) {
        if (!$this->allowExecute($resource, $company_id)) {
            $this->response->redirect('index/error404');
        }
    }

    public function accessUser($user_id, $grant = GRANT_READ, $resource = null) {
        $items = UserCompany::findByUserId($user_id);
        foreach ($items as $item) {
            if (!$this->acl->isAllowed($resource, $grant, $item->getComapanyId())) {
                $this->response->redirect('index/error404');
            }
        }
        return true;
    }

    /*
 * include CSS files to web page.
 */
    private function include_css($url_file, $browser = "") {
        if (file_exists(getcwd()."/".$url_file)) {
            $timestamp = filemtime(getcwd()."/".$url_file);
            switch($browser) {
                case "IE" :
                    $this->assets->collection('css_IE')->addCss($url_file.'?'.$timestamp);
                    break;
                default:
                    $this->assets->collection('css')->addCss($url_file.'?'.$timestamp);
                    break;
            }
        }
    }

    /*
   * include Java Script files to web page.
     * Don't use LIBS as mobule name
   */
    public function css($fileName) {
        if (!empty($fileName)) {
            $files = is_array($fileName)?$fileName:array($fileName);
            foreach ($files as $file) {
                $parts = pathinfo($file);
                $ext = empty($parts["extension"])?"css":$parts["extension"];
                $dir = isset($parts["dirname"]) && $parts["dirname"] != "."?$parts["dirname"]."/":"";
                $moduleDir = "";
                if (strpos($dir, 'libs') === false){
                    $module = $this->router->getModuleName();
                    if (!empty($module)) {
                        $moduleDir = $module."/";
                        if (isset($this->config->module->$module->template)) {
                            $template = $this->config->module->$module->template;
                            $file = PUBLIC_DIR.'css/'.$module."/".$template."/".$parts["filename"].".".$ext;
                            if (file_exists($file)) {
                                $moduleDir = $module."/".$template."/";
                            }
                        }
                    }
                }
                $dir = strlen($dir) > 0 && $dir[0] == '/'?$dir:"css/".$moduleDir.$dir;
                $this->include_css($dir.$parts["filename"].".".$ext);     // Include base CSS file
                $this->include_css($dir.$parts["filename"].".ie.".$ext, "IE");  // Include base CSS file for IE.
            }
        }
    }

    /*
    * include Java Script files to web page.
     * Don't use LIBS as mobule name
    */
    public function js($fileName) {

        if (!empty($fileName)) {
                $files = is_array($fileName) ? $fileName : array($fileName);
                foreach ($files as $file) {
                    if ( (strpos($file,'http') !== false) || (strpos($file,'https') !== false) ) {
                        $this->assets->collection('js')->addJs($file);
                    }else {
                        $parts = pathinfo($file);
                        $ext = empty($parts["extension"]) ? "js" : $parts["extension"];
                        $dir = isset($parts["dirname"]) && $parts["dirname"] != "." ? $parts["dirname"] . "/" : "";
                        $moduleDir = "";
                        if (strpos($dir, 'libs') === false) {
                            $module = $this->router->getModuleName();
                            if (!empty($module)) {
                                $moduleDir = $module."/";
                                if (isset($this->config->module->$module->template)) {
                                    $template = $this->config->module->$module->template;
                                    $file = PUBLIC_DIR.'js/'.$module."/".$template."/".$parts["filename"].".".$ext;
                                    if (file_exists($file)) {
                                        $moduleDir = $module."/".$template."/";
                                    }
                                }
                            }
                        }
                        $dir = strlen($dir) > 0 && $dir[0] == '/' ? $dir : "js/" . $moduleDir . $dir;
                        $file = $dir . $parts["filename"] . "." . $ext;
                        if (file_exists(getcwd() . "/" . $file)) {
                            $timestamp = filemtime(getcwd() . "/" . $file);
                            $this->assets->collection('js')->addJs($file.'?'.$timestamp);
                        }
                    }
                }
            }
    }

    /*
     * initialization of Java Script files
     */
//    public function init($init) {
//        if (!empty ($init)) {
//            $script = "";
//            $init = is_array($init)?$init:array($init);
//            foreach ($init as $value) {
//                $script .= trim($value).";";
//            }
//            if (strlen($script) > 0) {
//                $script = "jQuery(function () { try { $script } catch(e){ alert('MIS JS INIT ERROR: ' + e) }; });\n";
//                $this->assets->collection('script')->addInlineJs($script);
//            }
//        }
//    }

    public function options($options) {
        if (isset($options["strings"])) {
            throw new \Exception('You can use "strings" key in options array. Please use another name.');
        }
        if (!empty ($options) && is_array($options)){
            $this->_options = array_merge($this->_options, $options);
        }
    }

    public function strings($strings) {
        if (!empty ($strings) && is_array($strings)){
            $this->_strings = array_merge($this->_strings, $strings);
        }
    }

    public function result($data = array()) {
        if ($this->request->isAjax()) {
            $this->view->disable();
            $result = Result::get($data);
            if (ob_get_contents()) ob_end_clean();
            echo(json_encode($result));
        } else {
            foreach ($data as $key => $value) {
                $this->view->$key = $value;
            }
            $module = $this->dispatcher->getModuleName();
            if (!empty($module) && isset($this->config->module->$module->template)) {
                $template = $this->config->module->$module->template;
                $controller = $this->dispatcher->getControllerName();
                $action = $this->dispatcher->getActionName();
                $file = $this->config->module->$module->viewsDir."/".$controller."/".$template."/".$action.".volt";
                if (file_exists($file)) {
                    $this->view->pick($controller."/".$template."/".$action);
                }
            }
        }
    }

    /**
     *
     * @var array User
     */
    public function getUser() {
        if (!($this->_user instanceof User)) {
            $this->_user = $this->auth->getUser();
        }
        return $this->_user;
    }

    public function getRole() { return $this->auth->getRoleId(); }

    public function getDefaultUrl() {
        $identity = $this->auth->getIdentity();
        return isset($identity['url'])?$identity['url']:'/';
    }

    /**
     *
     * @var array Company
     */
    public function getCompany() {
        if (!($this->_company instanceof Company)) {
            $this->_company = $this->auth->getCompany();
        }
        return $this->_company;
    }

    private function setResourceParameters() {

        $paths = $this->config->save_filters;

        if (in_array($this->router->getRewriteUri(), $paths->toArray())) {

            $resource_parameters = [];
            //get any parameters that are already in the session
            if ($this->session->has('resource_parameters')) {
                $resource_parameters = $this->session->get('resource_parameters');
            }
            //get all data posted by the user
            $post = $this->request->getPost();

            //if user sends no parameters - restore what is saved
            //if user sends parameters - overwrite saved with new ones
            if (!$post) {
                if (isset($resource_parameters[$this->router->getControllerName()][$this->router->getActionName()])) {
                    $post = $resource_parameters[$this->router->getControllerName()][$this->router->getActionName()];
                }
            } else {
                $resource_parameters[$this->router->getControllerName()][$this->router->getActionName()] = $post;
            }
            //save the result to the session, $_POST array and $_REQUEST array
            $this->session->set('resource_parameters', $resource_parameters);
            $_POST = $post;
            foreach ($post as $post_key => $post_val) {
                $_REQUEST[$post_key] = $post_val;
            }
        }
    }

	/**
	 * @param $id
	 * @return object|string
	 */
	protected function get_workflow($id) {

		$project = $this->project_model->get_project_by_id($id);
		if (empty($project)) {
			echo response('Project does not exist', TRUE);
		}
		$project['quotes'] = $this->quote_model->get_placed_quotes($id);
		$project['lowest_quote'] = 0;
		foreach ($project['quotes'] as $quote) {
			if ($project['lowest_quote'] == 0 || $project['lowest_quote'] > $quote['amount']) {
				$project['lowest_quote'] = $quote['amount'];
			}
		}
		$project['payment'] = $this->finance_model->get_project_payment($id);
		$project['review'] = $this->project_model->get_project_review($id, $this->logged_in_user->id);
		if (isEntrepreneur()) {
			$project['review_other'] = $this->project_model->get_project_review($id, $project['employee_id']);
		} else {
			$project['review_other'] = $this->project_model->get_project_review($id, $project['creator_id']);
		}
		$project['cases'] = $this->cancel_model->get_project_cases($id);

		$project['current_milestone'] = 1;
		foreach ($project['milestones'] as $milestone) {
			if ($milestone['status'] == 1) {
				$project['current_milestone']++;
			}
		}
		if ($project['current_milestone'] > count($project['milestones'])) {
			$project['current_milestone'] = count($project['milestones']);
		}

		// Calculate stages
		$stages = [
			['class_bg' => 'breadcrumb-complete', 'class_border' => '', 'url' => site_url('search/machinery')],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
			['class_bg' => '', 'class_border' => '', 'url' => '#'],
		];

		// Start
		if (empty($project['quotes'])) {
			$stage = 1;
			$stages[1]['class_bg'] = 'breadcrumb-active';
			$stages[1]['url'] = site_url('project/create?id='.$project['id']);
			if (isEntrepreneur()) {
				if ($project['enddate'] > 0 && $project['enddate'] < get_est_time()) {
					$stages[1]['class_border'] = 'breadcrumb-overdue';
				} else {
					$stages[1]['class_border'] = 'breadcrumb-progress';
				}
				$stages[1]['url'] = site_url('project/create?id='.$project['id']);
			} elseif (isProvider()) {
				$stages[1]['class_border'] = 'breadcrumb-action';
				$stages[1]['url'] = site_url('project/quote?id='.$project['id']);
			}
		}
		// Quote
		elseif (not_yet_active($project['job_status'])) {
			$stage = 2;
			$stages[1]['class_bg'] = 'breadcrumb-complete';
			$stages[1]['url'] = site_url('project/view?id='.$project['id']);
			$stages[2]['class_bg'] = 'breadcrumb-active';
			if (isEntrepreneur()) {
				if ($project['enddate'] > 0 && $project['enddate'] < get_est_time()) {
					$stages[2]['class_border'] = 'breadcrumb-overdue';
				} else {
					$stages[2]['class_border'] = 'breadcrumb-progress';
				}
				$stages[2]['url'] = site_url('project/tender?id='.$project['id']);
			} elseif (isProvider()) {
				$quote = $this->quote_model->get_latest_quote_id($project['id'], $this->logged_in_user->id);
				if ($quote == NULL || $quote == -1) {
					if ($project['enddate'] > 0 && $project['enddate'] < get_est_time()) {
						$stages[2]['class_border'] = 'breadcrumb-overdue';
					} else {
						$stages[2]['class_border'] = 'breadcrumb-progress';
					}
				} else {
					$stages[2]['class_border'] = 'breadcrumb-action';
				}
				if ($project['job_status'] == Project_model::PROJECT_STATUS_PLACED) {
					$stages[2]['url'] = site_url('project/project_list/2');
				} else {
					$stages[2]['url'] = site_url('search/tender?id='.$project['id']);
				}
			}
		}
		// Project
		elseif ($project['job_status'] == Project_model::PROJECT_STATUS_ACTIVE) {
			$stage = 3;
			$stages[1]['class_bg'] = 'breadcrumb-complete';
			$stages[1]['url'] = site_url('project/view?id='.$project['id']);
			$stages[2]['class_bg'] = 'breadcrumb-complete';
			if (isEntrepreneur()) {
				$stages[2]['url'] = site_url('project/tender?id='.$project['id']);
			} elseif (isProvider()) {
				$stages[2]['url'] = site_url('search/tender?id='.$project['id']);
			}
			$stages[3]['class_bg'] = 'breadcrumb-active';
			$stages[3]['class_border'] = 'breadcrumb-action';
			if (count($project['cases']) > 0) {
				$stages[3]['class_bg'] = 'breadcrumb-error';
				$stages[3]['url'] = site_url('cancel/index');
			} else {
				if (isEntrepreneur()) {
					if ($project['due_date'] > 0 && $project['due_date'] < get_est_time()) {
						$stages[3]['class_border'] = 'breadcrumb-overdue';
					} else {
						$stages[3]['class_border'] = 'breadcrumb-progress';
					}
				} elseif (isProvider()) {
					$stages[3]['class_border'] = 'breadcrumb-action';
				}
				$stages[3]['url'] = site_url('project/view?id='.$project['id']);
			}
		}
		// Payment
		elseif ($project['job_status'] == Project_model::PROJECT_STATUS_COMPLETED && $project['payment']['due'] > 0) {
			$stage = 4;
			$stages[1]['class_bg'] = 'breadcrumb-complete';
			$stages[1]['url'] = site_url('project/view?id='.$project['id']);
			$stages[2]['class_bg'] = 'breadcrumb-complete';
			if (isEntrepreneur()) {
				$stages[2]['url'] = site_url('project/tender?id='.$project['id']);
			} elseif (isProvider()) {
				$stages[2]['url'] = site_url('search/tender?id='.$project['id']);
			}
			$stages[3]['class_bg'] = 'breadcrumb-complete';
			$stages[3]['url'] = site_url('project/view?id='.$project['id']);
			$stages[4]['class_bg'] = 'breadcrumb-active';
			if (isEntrepreneur()) {
				$stages[4]['class_border'] = 'breadcrumb-action';
			} elseif (isProvider()) {
				if ($project['due_date'] > 0 && $project['due_date'] < get_est_time()) {
					$stages[4]['class_border'] = 'breadcrumb-overdue';
				} else {
					$stages[4]['class_border'] = 'breadcrumb-progress';
				}
			}
			$stages[4]['url'] = site_url('finance/transfer?project='.$project['id']);
		}
		// Review
		elseif (in_array($project['job_status'], [Project_model::PROJECT_STATUS_COMPLETED, Project_model::PROJECT_STATUS_CANCELED]) &&
			(empty($project['review']) || empty($project['review_other'])))
		{
			$stage = 5;
			$stages[1]['class_bg'] = 'breadcrumb-complete';
			$stages[1]['url'] = site_url('project/view?id='.$project['id']);
			$stages[2]['class_bg'] = 'breadcrumb-complete';
			if (isEntrepreneur()) {
				$stages[2]['url'] = site_url('project/tender?id='.$project['id']);
			} elseif (isProvider()) {
				$stages[2]['url'] = site_url('search/tender?id='.$project['id']);
			}
			if ($project['job_status'] == Project_model::PROJECT_STATUS_COMPLETED) {
				$stages[3]['class_bg'] = 'breadcrumb-complete';
				$stages[4]['class_bg'] = 'breadcrumb-complete';
				$stages[5]['class_bg'] = 'breadcrumb-active';
			} else {
				$stages[3]['class_bg'] = 'breadcrumb-error';
				$stages[4]['class_bg'] = 'breadcrumb-error';
				$stages[5]['class_bg'] = 'breadcrumb-error';
			}
			$stages[3]['url'] = site_url('project/view?id='.$project['id']);
			$stages[4]['url'] = site_url('finance/transfer?project='.$project['id']);
			if (empty($project['review'])) {
				$stages[5]['class_border'] = 'breadcrumb-action';
				$stages[5]['url'] = site_url('project/review?id='.$project['id']);
			} else {
				$stages[5]['class_border'] = 'breadcrumb-progress';
				$stages[5]['url'] = site_url('project/view?id='.$project['id']);
			}
		}
		// Archive
		else {
			$stage = 6;
			$stages[1]['class_bg'] = 'breadcrumb-complete';
			$stages[1]['url'] = site_url('project/view?id='.$project['id']);
			$stages[2]['class_bg'] = 'breadcrumb-complete';
			if (isEntrepreneur()) {
				$stages[2]['url'] = site_url('project/tender?id='.$project['id']);
			} elseif (isProvider()) {
				$stages[2]['url'] = site_url('search/tender?id='.$project['id']);
			}
			if ($project['job_status'] == Project_model::PROJECT_STATUS_COMPLETED) {
				$stages[3]['class_bg'] = 'breadcrumb-complete';
				$stages[4]['class_bg'] = 'breadcrumb-complete';
				$stages[5]['class_bg'] = 'breadcrumb-complete';
				$stages[6]['class_bg'] = 'breadcrumb-active';
			} else {
				$stages[3]['class_bg'] = 'breadcrumb-error';
				$stages[4]['class_bg'] = 'breadcrumb-error';
				$stages[5]['class_bg'] = 'breadcrumb-error';
				$stages[6]['class_bg'] = 'breadcrumb-error';
			}
			$stages[3]['url'] = site_url('project/view?id='.$project['id']);
			$stages[4]['url'] = site_url('finance/transfer?project='.$project['id']);
			$stages[5]['url'] = site_url('project/view?id='.$project['id']);
			$stages[6]['url'] = site_url('project/view?id='.$project['id']);
		}

        $show_workflow = false;
		foreach ($stages as $key => $value) {
            $current_url = $_SERVER['QUERY_STRING']?current_url() .'?'.$_SERVER['QUERY_STRING']:current_url();
            if ($value['url'] == $current_url || $_SESSION['show_workflow']) {
                $show_workflow = true;
                $_SESSION['show_workflow'] = false;
                break;
            }
        }

        if ($show_workflow) {
            $this->outputData['project'] = $project;
            $this->outputData['stage'] = $stage;
            $this->outputData['stages'] = $stages;
            return ['view' => $this->load->view('workflow', $this->outputData, TRUE), 'url' => $stages[$stage]['url']];
        }
        else {
            return ['view' => '', 'url' => ''];
        }
	}
}