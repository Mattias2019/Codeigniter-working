<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function init($type, $message, $title = "") {
        $toasts = $this->session->userdata('toast');
        if (!isset($toasts)) {
            $toasts = array();
        }
        $toasts[] = array(
            'type' => $type,
            'message' => $message,
            'title' => $title
        );
        $this->session->set('toasts', $toasts);

        return $this;
    }

    function info($message, $title = "") { return $this->init('info', $message, $title); }
    function success($message, $title = "") {  return $this->init('success', $message, $title); }
    function warning($message, $title = "") {  return $this->init('warning', $message, $title); }
    function error($message, $title = "") {  return $this->init('error', $message, $title); }

    // Show toast if data about it contains it the session.
    function show($message_type, $message_text, $title = '') {
        if (!$this->request->isAjax()) {
            $toasts = "";
            $sesToasts = $this->session->get('toasts');
            if (isset($sesToasts) && count($sesToasts) > 0) {
                foreach ($sesToasts as $value) {
                    $type = $value['type'];
                    $message = $value['message'];
                    $title = strlen(trim($value['title'])) > 0?",'".$value['title']."''":"";
                    $toasts .= "toastr['$type'](\"$message\"$title);";
                }
                $this->session->set('toasts', array());
            }
            $this->view->toasts = $toasts;
        }
    }
?>