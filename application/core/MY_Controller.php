<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $current_user = false;

	public function __construct(){
		parent::__construct();

		$controller = $this->uri->segment(1);
		$method = $this->uri->segment(2);
		if($controller == 'users' && ($method == 'login' || $method == 'lost_password') ){
			return;
		}

		$user = $this->getCurrentUser();
		if(isset($_GET['lang_user'])){
			$this->load->model(array('Users_m'));
			$user->lang = $_GET['lang_user'];
			$this->Users_m->updateLang($user->id,$user->lang);
		}


		$this->current_user = $user;
		$this->data['current_user'] = $this->current_user;

		$this->lang->load('config', $this->current_user->lang);
		$this->lang->load('global', $this->current_user->lang);
		$this->lang->load('breadcrumb', $this->current_user->lang);
		$this->lang->load('menu', $this->current_user->lang);
		$this->lang->load('specific', $this->current_user->lang);

		$header = array();
		$header['page_title'] =  $this->lang->line('breadcrumb_'.$controller); 
		$header['breadcrumb'] =  array();
		$header['breadcrumb'][] = array(
			'url' => site_url($this->lang->line('home_path')),
			'title' => $this->lang->line('home'),
			'active' => false
		);
		$header['breadcrumb'][] = array(
			'url' => '',
			'title' => $this->lang->line('breadcrumb_'.$method),
			'active' => true
		);


		$this->data['header'] = $header; 
		$this->data['pagename'] = $controller;
		$this->data['current_controller'] = $controller;
		$this->data['current_method'] = $method;

		$this->load->model(array('Users_m'));
		

/*		$this->data['errors'] = array();
		$this->data['errors'] = array();*/
		$this->loadScripts();

	}

	/* EXEMPLE
	if($this->sendMail(array(
		'to' => 'gabypirson@gmail.com',
		'subject' => 'test',
		'body' => 'test'
	))){
		//OK
	}

	OR 

	if($this->sendMail(array(
		'to' => 'gabypirson@gmail.com',
		'subject' => 'test',
		'body' => array(
			'template' => 'emails/subscribers.php',
			'data' => array(
				'value1' => 'test'
			)
		)
	))){
		//OK
	}
	*/
	protected function sendMail($params = array()){
		$this->config->load('email');
		$this->load->library('email');

		if(isset($params['from'])){
			$this->email->from($params['from']['adress'], $params['from']['name']);
		}else{
			$this->email->from('no-reply@immoffice.be', 'Immoffice');
		}

		if(isset($params['to'])){
			$this->email->to($params['to']);
		}

		if(isset($params['cc'])){
			$this->email->cc($params['cc']);
		}

		if(isset($params['bcc'])){
			$this->email->bcc($params['bcc']);
		}

		if(isset($params['subject'])){
			$this->email->subject($params['subject']);
		}
		
		$body = '';
		if(isset($params['body'])){

			if(is_array($params['body']) || isset($params['body']['template']) ){
				$body = $this->load->view($params['body']['template'],$params['body']['data'],TRUE);
			}else{
				$body = $params['body'];
			}

			
		}

		$this->email->message($body);   
		
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}

	
	protected function addMessage($message){
		$messages = $this->session->flashdata('messages');
		if($messages && is_array($messages)){
			$messages[] = $message;
		}else{
			$messages = array($message);
		}
		$this->session->set_flashdata('messages',$messages);
	}

	protected function addError($message){
		$errors = $this->session->flashdata('errors');
		if($errors && is_array($errors)){
			$errors[] = $message;
		}else{
			$errors = array($message);
		}
		$this->session->set_flashdata('errors',$errors);
	}

	protected function uploadFile($file_name){
		$this->config->load('upload');
		$uploadPath = $this->config->item('upload_path');
		$config['allowed_types']        = $this->config->item('allowed_types');
		$config['max_size']             = $this->config->item('max_size');
		$config['max_width']            = $this->config->item('max_width');
		$config['max_height']           = $this->config->item('max_height');

		$uploadPath .= $this->current_user->id."/";
		$config['upload_path'] = $uploadPath;

		if(!file_exists($uploadPath)){
			mkdir($uploadPath, 0700);
		}

		$this->load->library('upload',$config);

		if (!$this->upload->do_upload($file_name)){
            $return = array('error' => $this->upload->display_errors());
          	$this->addError($this->lang->line('allowed_types').' : '.$config['allowed_types']);
          	$this->addError($this->lang->line('max_size').' : '.$config['max_size']);
          	$this->addError($this->lang->line('max_width').' : '.$config['max_width']);
          	$this->addError($this->lang->line('max_height').' : '.$config['max_height']);
        }else{
            $return = array('upload_data' => $this->upload->data());
            $this->load->model(array('Uploads_m'));
            $data = $return['upload_data'];
            $data['user_id'] = $this->current_user->id;
            $upload_repository = $this->config->item('upload_repository');

            $data['web_path'] = base_url().$upload_repository.$this->current_user->id."/".$data['file_name'];
            $return['id'] = $this->Uploads_m->insert($data);
            
        }
		return $return;		
	}

	protected function loadScripts(){

		$controller = strtolower($this->uri->segment(1) );
		$view = strtolower($this->uri->segment(2) );
		if($view == '') $view = 'index';

		$base_view_path_abs = APPPATH."views/";
		$base_view_path_rel = base_url().'application/views/';

		$this->data['custom_scripts'] = array();
		$this->data['custom_scripts'][] = $base_view_path_rel."common/header.js";
		$this->data['custom_scripts'][] = $base_view_path_rel."common/footer.js";
		
		$custom_script_path_rel = $base_view_path_rel.$controller."/".$view.".js";
		$custom_script_path_abs = $base_view_path_abs.$controller."/".$view.".js";
	

		if(file_exists($custom_script_path_abs)){
			$this->data['custom_scripts'][] = $custom_script_path_rel;

		}

	}
	
    public function getCurrentUser(){
        $user = $this->session->get_userdata('user');
      
        if(!$user || !isset($user['user']) || !isset($user['user']->id)){
            redirect('/users/login');
        }else{
            $user = $user['user'];
        }
        return $user;
  	}



  	

}
