<?php

/**
 *      ____  ____  _________  _________  ____
 *     / __ \/ __ \/ ___/ __ \/ ___/ __ \/ __ \
 *    / /_/ / /_/ / /  / /_/ / /__/ /_/ / / / /
 *    \____/ .___/_/   \____/\___/\____/_/ /_/
 *        /_/
 *
 *          Copyright (C) 2016 Oprocon
 *
 *          You aren't allowed to share any parts of this script!
 *          All rights reserved.
 *
 *          Changelog:
 *              15.04.2016 - Prepare the CI3 integration, initial release of the header
 *
 *          (Please update this any time you edit this script, newest first)
 *
 * @package        Consultant Marketplace
 * @author        Oprocon Dev Team
 * @copyright    Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link        https://consultant-marketplace.com
 * @version     1.0.0
 */

class Email_model extends CI_Model
{
	// Types of message linked to periods and managed for every user
	const EMAIL_PERIOD_TYPE_MESSAGE = 0;
	const EMAIL_PERIOD_TYPE_PROJECT = 1;
	const EMAIL_PERIOD_TYPE_QUOTE = 2;

	// Periods when messages are checked/sent
	const EMAIL_PERIOD_INSTANTLY = 0;
	const EMAIL_PERIOD_HOURLY = 1;
	const EMAIL_PERIOD_DAILY = 2;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $email_type
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    function get_mail($email_type, $parameters = [])
    {
        // Get mail
        $this->db->select('*');
        $this->db->from('email_templates');
        $this->db->where('type', $email_type);
        $mail = $this->db->get();
        if (!$mail) {
            throw_db_exception();
        }
        $mail = $mail->row();
        if (!isset($mail)) {
            throw new Exception('Mail type does not exist');
        }

        // Substitute parameters
        $mail_subject = $mail->mail_subject;
        $mail_body = $mail->mail_body;
        if (is_array($parameters)) {
            foreach ($parameters as $parameter_name => $parameter_value) {
                $mail_subject = str_replace($parameter_name, $parameter_value, $mail_subject);
                $mail_body = str_replace($parameter_name, $parameter_value, $mail_body);
            }
        }

        return [
            'subject' => $mail_subject,
            'body' => $mail_body
        ];
    }

    /**
     * @param $email_type
     * @param $user_id
     * @param array $parameters
     * @param bool $send_immediately
     * @throws Exception
     */
    function prepare($email_type, $user_id, $parameters = [], $send_immediately = TRUE /* TODO FALSE */)
    {
        $this->load->model('user_model');

        // Get mail
        $this->db->select('*');
        $this->db->from('email_templates');
        $this->db->where('type', $email_type);
        $mail = $this->db->get();
        if (!$mail) {
            throw_db_exception();
        }
        $mail = $mail->row();
        if (!isset($mail)) {
            throw new Exception('Mail type does not exist');
        }

        // Get user
        $user = $this->user_model->getUsers(['users.id' => $user_id])->row();
        if (isset($user)) {
            $mail_to = $user->email;
        } else {
            throw new Exception('User does not exist');
        }

        // Substitute parameters
        $mail_subject = $mail->mail_subject;
        $mail_body = $mail->mail_body;
        if (is_array($parameters)) {
            foreach ($parameters as $parameter_name => $parameter_value) {
                $mail_subject = str_replace($parameter_name, $parameter_value, $mail_subject);
                $mail_body = str_replace($parameter_name, $parameter_value, $mail_body);
            }
        }

        // Get frequency of mail checks based on mail type and user settings
		/*switch ($mail->period_type)
		{
			case self::EMAIL_PERIOD_TYPE_MESSAGE:
				$user_period = $user->message_notify;
				break;
			case self::EMAIL_PERIOD_TYPE_PROJECT:
				$user_period = $user->job_notify;
				break;
			case self::EMAIL_PERIOD_TYPE_QUOTE:
				$user_period = $user->bid_notify;
				break;
			default:
				throw new Exception('Incorrect message period type');
		}

		// Do not send message if period is not set
		if ($user_period == NULL)
		{
			return;
		}*/

        // Insert into email table
        if (!$this->db->insert('email', [
            'mail_to' => $mail_to,
            'mail_subject' => $mail_subject,
            'mail_body' => $mail_body,
            'time' => get_est_time(),
			'period' => /*$user_period*/ 0
        ])) {
            throw_db_exception();
        }

        if ($send_immediately) {
            $id = $this->db->insert_id();
            $this->send($id);
        }
    }

    /**
     * @param int $user_id recipient
     * @param string $mail_subject subject of email
     * @param string $mail_body body of email
     * @param array $parameters array of values for email body
     * @param bool $send_immediately true/false
     * @throws Exception
     */
    function custom($user_id, $mail_subject, $mail_body, $parameters = [], $send_immediately = FALSE)
    {
        // Get user
        $user = $this->user_model->getUsers(['users.id' => $user_id])->row();
        if (isset($user)) {
            $mail_to = $user->email;
        } else {
            throw new Exception('User does not exist');
        }

        if (is_array($parameters)) {
            foreach ($parameters as $parameter_name => $parameter_value) {
                $mail_subject = str_replace($parameter_name, $parameter_value, $mail_subject);
                $mail_body = str_replace($parameter_name, $parameter_value, $mail_body);
            }
        }

        // Insert into email table
        if (!$this->db->insert('email', [
            'mail_to' => $mail_to,
            'mail_subject' => $mail_subject,
            'mail_body' => $mail_body,
            'time' => get_est_time()
        ])) {
            throw_db_exception();
        }

        if ($send_immediately) {
            $id = $this->db->insert_id();
            $this->send($id);
        }
    }


    /**
     * @param int|null $id
	 * @param int $period
     */
    function send($id = NULL, $period = self::EMAIL_PERIOD_INSTANTLY)
    {
        $this->load->library('email');
		$this->email->initialize([
			'useragent' => "CodeIgniter",
			'mailpath' => "/usr/bin/sendmail",
			'protocol' => "smtp",
			'smtp_host' => "localhost",
			'smtp_port' => "25",
			'mailtype' => 'text',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'wordwrap' => TRUE
		]);
//        $this->email->initialize([
//            'protocol' => "mail",
//            'mailtype' => 'text',
//            'charset' => 'utf-8',
//            'newline' => "\r\n",
//            'wordwrap' => TRUE
//        ]);

        $this->db->select('*');
        $this->db->from('email');
        $this->db->where('sent', 0);
        if ($id) {
            $this->db->where('id', $id);
        } elseif ($period) {
			$this->db->where('period', $period);
		}
        $res = $this->db->get()->result_array();

        foreach ($res as $mail) {

            // Get mail parameters
            $site_name = $this->config->item('site_title');
            $mail_from = $this->config->item('site_admin_mail');

            $message = $this->load->view('email/layout', [
                'email_subject' => $mail['mail_subject'],
                'email_body' => $mail['mail_body']], true);


            // Send mail
            $this->email->set_mailtype("html");
            $this->email->from($mail_from, $site_name);
            $this->email->to($mail['mail_to']);
            $this->email->subject($mail['mail_subject']);
            $this->email->message($message);

            if ($this->email->send()) {
                $this->db->update('email', ['sent' => 1], ['id' => $mail['id']]);
            } else {
                $this->db->update('email', ['sent' => 2, 'error' => $this->email->print_debugger()], ['id' => $mail['id']]);
            }
        }
    }


    /**
     * Get Email settings from database
     *
     * @access private
     * @param
     *            nil
     * @return array payment settings informations in array format
     */
    function getEmailSettings($conditions = array(), $limit = array(), $orderby = array())
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->select('email_templates.id, email_templates.title, email_templates.mail_subject, email_templates.mail_body');
        $this->db->from('email_templates');
        $result = $this->db->get();
        return $result;
    }
    // End of getEmailSettings Function

    function countEmailTemplates($conditions = array(), $like = array())
    {
        if (is_array($conditions) and count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            if (count($like) == 1) {
                $this->db->like($like);
            } elseif (count($like) > 1) {
                $this->db->group_start();
                $this->db->or_like($like);
                $this->db->group_end();
            }
        }

        $this->db->select('count(email_templates.id) as count');
        $this->db->from('email_templates');

        $result = $this->db->get();
        return $result;
    }

    /**
     * Add Email Settings
     *
     * @access private
     * @param
     *            array an associative array of insert values
     * @return void
     */
    function addEmailSettings($insertData = array())
    {
        $this->db->insert('email_templates', $insertData);
        return;
    }
    // End of addEmailSettings Function
    // --------------------------------------------------------------------

    /**
     * delete Email Settings
     *
     * @access private
     * @param
     *            array an associative array of insert values
     * @return void
     */
    function deleteEmailSettings($condition = array())
    {
        if (isset($condition) and count($condition) > 0)
            $this->db->where($condition);

        $this->db->delete('email_templates');
        return;
    }
    // End of deleteEmailSettings Function
    // ------------------------------------------------------------------------

    /**
     * Send Mail
     *
     * @access private
     * @param
     *            array
     * @return array site settings informations in array format
     */
    function sendMail($to = '', $from = '', $subject = '', $message = '', $cc = '')
    {
        $config = array();

        $config['useragent'] = "CodeIgniter";
        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "localhost";
        $config['smtp_port'] = "25";
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        /*
         * $config['protocol'] = "smtp";
         * $config['smtp_host'] = "ssl://smtp.googlemail.com";
         * $config['smtp_port'] = "465";
         * $config['smtp_user'] = 'xxxx@googlemail.com';
         * $config['smtp_pass'] = 'xxxx';
         * $config['mailtype'] = 'text';
         * $config['charset'] = 'utf-8';
         * $config['newline'] = "\r\n";
         * $config['wordwrap'] = TRUE;
         */

        // load Email Library
        $this->load->library('email');
        $config['mailtype'] = 'text';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->to($to);
        $this->email->from($from);
        $this->email->cc($cc);
        $this->email->subject($subject);
        $this->email->message($message);
        if (!$this->email->send()) {
            // exit($this->email->print_debugger());
            echo $this->email->print_debugger();
        }
    }
    // Function sendmail End

    /**
     * Update Email Settings
     *
     * @access private
     * @param
     *            array an associative array of insert values
     * @return void
     */
    function updateEmailSettings($id = 0, $updateData = array())
    {
        $this->db->where('id', $id);
        $this->db->update('email_templates', $updateData);
    }

    // End of updateEmailSettings Function
    function sendHtmlMail($to = '', $from = '', $subject = '', $message = '', $cc = '')
    {
        $config = array();
        $config['useragent'] = "CodeIgniter";
        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "localhost";
        $config['smtp_port'] = "25";
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        // load Email Library
        $this->load->library('email');

        /*
         * $config['mailtype'] = 'html';
         * $config['wordwrap'] = TRUE;
         */

        $this->email->initialize($config);

        $this->email->to($to);
        $this->email->from($from);
        $this->email->cc($cc);
        $this->email->subject($subject);
        $this->email->message($message);
        if (!$this->email->send()) {
            return $this->email->print_debugger();
        }

        return "";
    } // End of sendHtmlMail Function
}