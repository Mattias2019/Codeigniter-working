<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: geymur-vs
 * Date: 13.07.17
 * Time: 16:59
 */

class AccessCheck
{
    public function index($params) {

        $resource = $this->Acl->getResourceName();

        // Check if the user have permission to the current resource
        if (!$acl->isAllowed($resource, GRANT_READ)) {

            if ($this->input->is_ajax_request()) {
                $this->result([
                    'error' => true,
                    'code' => ERROR_ACCESS_DENIED,
                    'message' => $this->t->_('you-dont-have-access')
                ]);
                $this->toast->info($this->t->_('you-dont-have-access'));
            } else {
                if ($identity['id'] == 0) {
                    $this->flash->notice('You don\'t have access to resource : ');
                    $this->response->redirect('/login');
                } else {
                    $this->response->redirect('index/error404');
                }

            }
            return false;
        }
        return true;
    }
}