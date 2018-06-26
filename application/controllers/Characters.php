<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Characters extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Characters_m','Areas_m','Messages_m','States_m','Games_characters_status_m','Characters_types_m'));
	
		if($this->savePost()){
			redirect($back_path);
		}
		
		$this->data['characters_types'] = $this->Characters_types_m->getAll();
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['states'] = $this->States_m->getAll();
		$this->data['games_character_status'] = $this->Games_characters_status_m->getAll();
		$this->data['messages'] = $this->Messages_m->getAll('message_type_id',4);
		$this->data['character'] = $this->Characters_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Characters_m','Areas_m','Messages_m','States_m','Games_characters_status_m','Characters_types_m'));

		if(!isset($_GET['id']) || $_GET['id'] == ''){
			redirect($back_path);
		}else{		
			
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['characters_types'] = $this->Characters_types_m->getAll();
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['states'] = $this->States_m->getAll();
		$this->data['games_character_status'] = $this->Games_characters_status_m->getAll();
		$this->data['messages'] = $this->Messages_m->getAll('message_type_id',4);
		$this->data['character'] = $this->Characters_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'characters/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			$characters = array();
			$characters['name'] = $this->input->post('name');
			$characters['firstname'] = $this->input->post('firstname');
			$characters['character_type_id'] = $this->input->post('character_type_id');
			$characters['first_message_id'] = $this->input->post('first_message_id');
			$characters['first_game_character_status_id'] = $this->input->post('first_game_character_status_id');
			$characters['first_state_id'] = $this->input->post('first_state_id');
			$characters['first_area_id'] = $this->input->post('first_area_id');

			$error_upload = false;
			if(isset($_FILES['picture']['name']) && ($_FILES['picture']['name'] != '')){
				$return = $this->uploadFile('picture');
				if(isset($return['id'])){
					$characters['icon'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(!$error_upload){
				if($this->input->post('id')) {
					$characters['id'] = $this->input->post('id');
					$return = $this->Characters_m->update($characters);
				}else{
					$return = $this->Characters_m->insert($characters);
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
		$this->load->model(array('Characters_m'));
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
				case 0:
					$order['column'] = 'name';
					break;			
				default:
					$order['column'] = 'characters.id';
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

		
		$characters = $this->Characters_m->get($params);
		$all_characters = $this->Characters_m->getAll();
		$data = array();
		foreach($characters as $key => $characters){				
			$data[] = array(
				$characters->id,
				$characters->type_value,
				$characters->name,
				$characters->firstname,
				'<a href="'.$characters->path.'" target="_blank">'.$characters->icon.'</a>',
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('characters/edit/?id='.$characters->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_characters);
		$return["recordsFiltered"] = count($characters);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
