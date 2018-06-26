<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function index(){
		if($this->current_user->role_id != 4){
			redirect('stuffs/index');
		}
		$this->load->view('template', $this->data);
	}

	public function lost_password(){
		$lang = 'french';
		if(isset($_GET['lang_user'])){
			$lang = $_GET['lang_user'];
		}
		$this->lang->load('config', $lang);
		$this->lang->load('global', $lang);
		$this->lang->load('breadcrumb', $lang);
		$this->lang->load('specific', $lang);

		$this->load->model(array('Users_m'));
		if($this->input->post('send-login')) {
			$email = $this->input->post('login');
			$user = $this->Users_m->emailExist($email);
			
			if($user){
				$password = uniqid();
				$params = array(
					'to' => $email,
					'subject' => $this->lang->line('new_password_subject'),
					'body' => array(
						'template' => 'emails/new_password.php',
						'data' => array(
							'password' => $password
						)
					)
				);
				if($this->sendMail($params)){
					$new_param['id'] = $user->id;
					$new_param['password'] = md5($password);
					$this->Users_m->update($new_param);
					$this->addMessage($this->lang->line('new_password_send').$email);
					redirect('users/login');
				}
				
			}else{
				$this->addError($this->lang->line('email_not_exist'));
			}
		}
		$this->load->view('template_landing');
	}

	public function change() {
		$user_id = $this->input->get('id');
		$token = $this->input->get('token');
		$back_path = $this->input->get('back_path');
		if($token == md5('immofficetoken'.date('h'))){
			$this->load->model(array('Users_m'));
			$user = $this->Users_m->get($user_id);
			echo $user_id;
			if($user){
				$this->session->unset_userdata('user');
				$this->session->set_userdata('user', $user);
				redirect($back_path);
			}
		}else{
			$this->addError($this->lang->line('bad_token'));
			redirect($back_path);
		}
	}

	public function login() {

		$lang = 'french';
		if(isset($_GET['lang_user'])){
			$lang = $_GET['lang_user'];
		}
		$this->lang->load('config', $lang);
		$this->lang->load('global', $lang);
		$this->lang->load('breadcrumb', $lang);
		$this->lang->load('specific', $lang);

		
		$this->session->unset_userdata('user');
		$this->load->model(array('Users_m','Connections_m'));

		if($this->input->post('send-login')) {

			$login = $this->input->post('login');
			$password = $this->input->post('password');
			$user = $this->Users_m->login($login,$password);
			if($user){
				$this->Connections_m->insert(array(
					'user_id' => $user->id,
					'timestamp' => strtotime('now')
				));
				$this->session->set_userdata('user', $user);
				redirect($this->lang->line('home_path'));
				die();
			}else{
				$this->addError($this->lang->line('error_login'));
			}
		}		
		$this->load->view('template_landing');
	}

	public function news(){
		if($this->current_user->role_id != 4){
			redirect('stuffs/index');
		}
		$this->load->model(array('Users_m'));
		$this->load->model(array('Users_m','Roles_m'));
		$this->data['roles'] = $this->Roles_m->getAll();

		if($this->input->post('save') ){
			$user = array();
			
			$user['login'] = $this->input->post('email');
			$user['lang'] = $this->input->post('lang');
			$user['password'] = md5($this->input->post('password'));
			$user['name'] = $this->input->post('name');
			$user['firstname'] = $this->input->post('firstname');
			$user['adress'] = $this->input->post('adress');
			$user['tel'] = $this->input->post('tel');
			$user['role_id'] = $this->input->post('role');
			$user['agence_id'] = $this->input->post('agence_id');
			$user['created'] = strtotime('now');
			
			if($this->Users_m->insert($user)){
				$this->addMessage($this->lang->line('insert_done'));
			}

			if(!$this->verifyPassword($this->input->post('password'), $this->input->post('verify_password'))){	
				$this->addError($this->lang->line('error_password'));
			}
		}

		$this->load->view('template', $this->data);
	}

	public function edit(){
		if($this->current_user->role_id != 4){
			redirect('stuffs/index');
		}
		$this->load->model(array('Users_m','Roles_m'));
		$this->data['roles'] = $this->Roles_m->getAll();
		
		if($this->input->post('save') ){
			$user = array();
			$user['id'] = $this->input->post('id');
			$user['login'] = $this->input->post('email');
			$user['lang'] = $this->input->post('lang');
			if($this->input->post('password') != ''){
				$user['password'] = md5($this->input->post('password'));
			}
			
			$user['name'] = $this->input->post('name');
			$user['firstname'] = $this->input->post('firstname');
			$user['adress'] = $this->input->post('adress');
			$user['tel'] = $this->input->post('tel');
			$user['role_id'] = $this->input->post('role');
			$user['deleted'] = $this->input->post('deleted');
			$user['agence_id'] = $this->input->post('agence_id');

			if($this->Users_m->update($user)){
				$this->addMessage($this->lang->line('update_done'));
				redirect('users/index');
			}

			if(!$this->verifyPassword($this->input->post('password'), $this->input->post('verify_password'))){	
				$this->addError($this->lang->line('error_password'));
			}
		}

		if($this->input->post('delete') ){
			$user = array();
			$user['id'] = $this->input->get('id');
			//$user['deleted'] = 1;
			if(!$this->Users_m->delete($this->input->get('id'))){
				$this->addError($this->lang->line('users_with_favoris'));
			}else{
				$this->addMessage($this->lang->line('delete_done'));
			}
			redirect('users/index');
		}
		$this->data['user'] = $this->Users_m->get($this->input->get('id'));
		if(!$this->data['user']){
			//redirect('users/index');
		}
		
		$this->load->view('template', $this->data);
	}

	private function verifyPassword($password1,$password2,$verify_empty = true){
		
		if($verify_empty){
			if(  $password1 == '' || $password2 == '' ) {
				return false;
			}
		}
		
		if( $password1 != $password2 ){
			return false;
		}
		return true;
	}

	public function edit_profile(){
		$this->load->model(array('Users_m'));
		if($this->input->post('save') ){
			$user = array();
			$user['id'] = $this->current_user->id;
			$user['login'] = $this->current_user->login = $this->input->post('email');
			$user['agence_id'] = $this->current_user->agence_id;
			if($this->input->post('password') != ''){
				if($this->verifyPassword($this->input->post('password'), $this->input->post('verify_password'),false)){
					$user['password'] = $this->current_user->password = md5($this->input->post('password'));
				}else{
					$this->addError($this->lang->line('error_password'));
				}
			}
			$user['lang'] = $this->current_user->lang = $this->input->post('lang');
			$user['name'] = $this->current_user->name = $this->input->post('name');
			$user['firstname'] = $this->current_user->firstname = $this->input->post('firstname');
			$user['adress'] = $this->current_user->adress = $this->input->post('adress');
			$user['tel'] = $this->current_user->tel = $this->input->post('tel');
			if($this->Users_m->update($user)){
				$user = $this->Users_m->get($this->current_user->id);
				$this->session->unset_userdata('user');
				$this->session->set_userdata('user', $user);
				$this->addMessage($this->lang->line('update_done'));
				redirect('stuffs/index');
			}
			
		}

		$this->data['user'] = $this->Users_m->get($this->current_user->id);
		$this->load->view('template', $this->data);
	}
	
	public function lock() {
		$this->load->view('user');
	}

	public function logout() {
		$this->session->unset_userdata('user');
		redirect('users/login');
	}

	//AJAX

	

	public function getAllUsersDataTable(){
		$this->load->model(array('Users_m'));
		$return = $this->input->get();
		/*if(isset($this->input->get('search')['value'])){
			$search = $this->input->get('search')['value'];
		}else{
			$search = false;
		}*/
		$search = false;

		$start = 0;
		$length = 0;

		if($this->input->get('start')){
			$start = $this->input->get('start');
		}

		if($this->input->get('length')){
			$length = $this->input->get('length');
		}

		$order = false;
		if($this->input->get('order')){
			$order = array('column','dir');
			$order_value = $this->input->get('order');
			$order['dir'] = $order_value[0]['dir'];

			//$column = $this->input->get('order');
			switch($order_value[0]['column']){
				case 0:
					$order['column'] = 'users.name';
					break;
				case 2:
					$order['column'] = 'role_name';
					break;
				case 3:
					$order['column'] = 'login';
					break;
				case 4:
					$order['column'] = 'created';
					break;
				case 5:
					$order['column'] = 'last_connection';
					break;	
				case 6:
					$order['column'] = 'deleted';
					break;					
				default:
					$order['column'] = 'name';
					break;
			}
		}

		
		$params = array(
			"search" => $search,
			"start" => $start,
			"length" => $length,
			"order" => $order,
			"deleted" => true
		);

		
		$users = $this->Users_m->get($params);
		$all_users = $this->Users_m->getAll();
	//	echo $this->db->last_query();
		$data = array();

		foreach($users as $key => $user){
			if($user->deleted != 1)
				$deleted = '<i class="fa fa-check green"></i>';
			else $deleted = '<i class="fa fa-remove red"></i>';

			if($user->last_connection){
				$last_connection = date('d/m/Y H:i:s',$user->last_connection);
			}else{
				$last_connection = '';
			}
			
			$data[] = array(
				$user->name." ".$user->firstname,
				$user->role_name,
				$user->login,
				date('d/m/Y H:i:s',$user->created),
				$last_connection,
				$deleted,
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('users/edit/?id='.$user->id).'"><i class="fa fa-pencil"></i><span>Editer le user</span></a></li>
                    <li class="table-btn-rappel"><a href="'.site_url('supervision/view').'/?id='.$user->id.'" ><i class="fa fa-binoculars"></i><span>See More</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_users);
		$return["recordsFiltered"] = count($users);
		
		$return["data"] = $data;

		echo json_encode($return);
		 
	}
}
