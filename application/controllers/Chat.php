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
 * @package	    Consultant Marketplace
 * @author	    Oprocon Dev Team
 * @copyright	Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link	    https://consultant-marketplace.com
 * @version     1.0.0
 */

class Chat extends MY_Controller
{
	// Constructor
	function __construct()
	{

		parent::__construct();

		$this->load->library('settings');

		//Get Config Details From Db
		$this->settings->db_config_fetch();

		//Manage site Status
		if($this->config->item('site_status') == 1)
			redirect('offline');

		//Load Models Common
		$this->load->model('common_model');
		$this->load->model('skills_model');
		$this->load->model('messages_model');
		$this->load->model('file_model');

		//language file
		load_lang('enduser/account');

		$this->load->helper('file');
	}

	public function chatigniter()
	{
		$outputData['users'] = $this->user_model->get_contacts($this->logged_in_user->id, TRUE);
		$this->load->view('chatigniter/chat', $outputData);
	}

	public function Chatmessages()
	{
		$this->load->helper('smiley');
		//get paginated messages
		$per_page = 5;
		$user 		= $this->logged_in_user->id;
		$buddy 		= $this->input->post('user');
		$getLimit	= $this->input->post('limit');
		$limit 		= $getLimit != '' ? $getLimit : $per_page ;

		$messages 	= array_reverse($this->user_model->conversation($user, $buddy, $limit));
		$total 		= $this->user_model->thread_len($user, $buddy);

		$thread = array();
		foreach ($messages as $message)
		{
			$owner = $this->user_model->getUsers(array('users.id'=>$message->from))->row();
			$owner->logo = $this->file_model->get_user_logo_path($owner->id, $owner->logo);
			$chat = array(
				'msg' 		=> $message->id,
				'sender' 	=> $message->from,
				'recipient' => $message->to,
				'avatar' 	=> $owner->logo != '' ? $owner->logo : image_url('noImage.jpg'),
				'body' 		=> parse_smileys($message->message),
				'time' 		=> date("M j, Y, g:i a", strtotime($message->time)),
				'type'		=> $message->from == $user ? 'out' : 'in',
				'name'		=> $message->from == $user ? 'You' : ucwords($owner->user_name)
			);
			array_push($thread, $chat);
		}
		$chatbuddy = $this->user_model->getUsers(array('users.id'=>$buddy))->row();
		$chatbuddy->logo = $this->file_model->get_user_logo_path($chatbuddy->id, $chatbuddy->logo);

		$contact = array(
			'name'=>ucwords($chatbuddy->user_name),
			'status'=>$chatbuddy->login_status,
			'id'=>$chatbuddy->id,
			'limit'=>$limit + $per_page,
			'more' => $total  <= $limit ? false : true,
			'scroll'=> $limit > $per_page  ?  false : true,
			'remaining'=> $total - $limit
		);

		$response = array(
			'success' => true,
			'errors'  => '',
			'message' => '',
			'buddy'	  => $contact,
			'thread'  => $thread
		);
		//add the header here
		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function save_Chatmessage()
	{
		$this->load->helper('smiley');
		$logged_user = $this->logged_in_user->id;
		$buddy 		= $this->input->post('user');
		$message 	= $this->input->post('message');

		if($message != '' && $buddy != '')
		{
			$msg_id = $this->user_model->insertChatMsg(array(
				'from' 		=> $logged_user,
				'to' 		=> $buddy,
				'message' 	=> $message,
			));
			$msg = $this->user_model->getNewInsertMsg($msg_id)->row();
			$owner = $this->user_model->getUsers(array('users.id'=>$msg->from))->row();
			$owner->logo = $this->file_model->get_user_logo_path($owner->id, $owner->logo);
			$chat = array(
				'msg' 		=> $msg->id,
				'sender' 	=> $msg->from,
				'recipient' => $msg->to,
				'avatar' 	=> $owner->logo != '' ? $owner->logo : image_url('noImage.jpg'),
				'body' 		=> parse_smileys($msg->message),
				'time' 		=> date("M j, Y, g:i a", strtotime($msg->time)),
				'type'		=> $msg->from == $logged_user ? 'out' : 'in',
				'name'		=> $msg->from == $logged_user ? 'You' : ucwords($owner->user_name)
			);
			$response = array(
				'success' => true,
				'message' => $chat
			);
		}
		else{
			$response = array(
				'success' => false,
				'message' => 'Empty fields exists'
			);
		}
		//add the header here
		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function ChatMsgupdates()
	{
		// Confirm that user is active
		$this->user_model->set_last_activity($this->logged_in_user->id);

		$this->load->helper('smiley');
		$new_exists = false;
		$user_id 	= $this->logged_in_user->id;
		$last_seen  = $this->user_model->getChatLastSeen_by($user_id)->row();
		$last_seen  = empty($last_seen) ? 0 : $last_seen->message_id;
		$exists = $this->user_model->latest_Chatmessage($user_id, $last_seen);
		//echo $exists;
		if($exists){
			$new_exists = true;
		}
		// THIS WHOLE SECTION NEED A GOOD OVERHAUL TO CHANGE THE FUNCTIONALITY
		if ($new_exists) {
			$new_messages = $this->user_model->ChatUnread($user_id);
			$thread = array();
			$senders = array();
			foreach ($new_messages as $message)
			{
				if(!isset($senders[$message->from]))
				{
					$senders[$message->from]['count'] = 1;
				}
				else
				{
					$senders[$message->from]['count'] += 1;
				}
				$owner = $this->user_model->getUsers(array('users.id'=>$message->from))->row();
				$owner->logo = $this->file_model->get_user_logo_path($owner->id, $owner->logo);
				$chat = array(
					'msg' 		=> $message->id,
					'sender' 	=> $message->from,
					'recipient' => $message->to,
					'avatar' 	=> $owner->logo != '' ? $owner->logo : image_url('noImage.jpg'),
					'body' 		=> parse_smileys($message->message),
					'time' 		=> date("M j, Y, g:i a", strtotime($message->time)),
					'type'		=> $message->from == $user_id ? 'out' : 'in',
					'name'		=> $message->from == $user_id ? 'You' : ucwords($owner->first_name)
				);
				array_push($thread, $chat);
			}

			$groups = array();
			foreach ($senders as $key=>$sender) {
				$sender = array('user'=> $key, 'count'=>$sender['count']);
				array_push($groups, $sender);
			}
			// END OF THE SECTION THAT NEEDS OVERHAUL DESIGN
			$this->user_model->updateChat_lastSeen($user_id);

			$response = array(
				'success' => true,
				'messages' => $thread,
				'senders' =>$groups
			);

			//add the header here
			header('Content-Type: application/json');
			echo json_encode( $response );
		}
	}

	public function mark_ChatMsgRead(){
		$this->user_model->mark_readChatMsg();
	}

	public function check_contact_status()
	{
		$users = $this->input->post('users');
		$result = [];
		if (isset($users) and is_array($users))
		{
			foreach($users as $user)
			{
				$result[] = [
					'id' => $user,
					'online' => $this->user_model->is_online($user)
				];
			}
		}
		echo json_encode($result);
	}
}