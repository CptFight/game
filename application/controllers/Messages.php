<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('messages_m','Areas_m','Characters_m','Messages_types_m'));
	
		if($this->savePost()){
			redirect($back_path);
		}

		$this->data['characters'] = $this->Characters_m->getAll();
		$this->data['messages_types'] = $this->Messages_types_m->getAll();
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['messages'] = $this->messages_m->getPanel($this->input->get('id'));
		$this->data['message'] = $this->messages_m->get($this->input->get('id'));
		
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('messages_m','Areas_m','Characters_m','Messages_types_m'));	

		if(!$this->input->get('id')){
			redirect($back_path);
		}else{		
			
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['characters'] = $this->Characters_m->getAll();
		$this->data['messages_types'] = $this->Messages_types_m->getAll();
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['messages'] = $this->messages_m->getPanel($this->input->get('id'));
		$this->data['message'] = $this->messages_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'messages/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			$messages = array();

			$messages['area_id'] = $this->input->post('area_id');
			$messages['character_from_id'] = $this->input->post('character_from_id');
			$messages['character_to_id'] = $this->input->post('character_to_id');
			$messages['message_type_id'] = $this->input->post('message_type_id');
			$messages['message_from_id'] = $this->input->post('message_from_id');
			$messages['message_to_id'] = $this->input->post('message_to_id');
			$messages['value'] = $this->input->post('value');

			$error_upload = false;
			if(isset($_FILES['picture']['name']) && ($_FILES['picture']['name'] != '')){
				$return = $this->uploadFile('picture');
				if(isset($return['id'])){
					$messages['icon'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(!$error_upload){
				if($this->input->post('id')) {
					$messages['id'] = $this->input->post('id');
					$return = $this->messages_m->update($messages);
				}else{
					$return = $this->messages_m->insert($messages);
				}

				if($return){
					$this->addMessage($this->lang->line('update_done'));
				}else{
					$this->addError($this->lang->line('update_error'));
				}
			}
			return true;
		}else{
			return false;	
		}
	}

	public function getAllDatatable(){
		$this->load->model(array('messages_m'));
		$return = $this->input->get();
		
		$search = $this->input->get('search');
		if(isset($search['value'])){
			$search = $search['value'];
		}else{
			$search = false;
		}

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

			switch($order_value[0]['column']){
			
				default:
					$order['column'] = 'id';
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

		
		$messages = $this->messages_m->get($params);
		$all_messages = $this->messages_m->getAll();
		$data = array();

		foreach($messages as $key => $message){
			$data[] = array(
				$message->id,
				$message->value,
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('messages/edit/?id='.$message->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_messages);
		$return["recordsFiltered"] = count($messages);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
