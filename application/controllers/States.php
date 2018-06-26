<?php defined('BASEPATH') OR exit('No direct script access allowed');

class States extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('States_m'));
	
		if($this->savePost()){
			redirect($back_path);
		}
		
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('States_m'));

		if(!isset($_GET['id']) || $_GET['id'] == ''){
			redirect($back_path);
		}else{		
			
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['state'] = $this->States_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'states/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			$states = array();
			$states['name'] = $this->input->post('name');

			$error_upload = false;
			if(isset($_FILES['picture']['name']) && ($_FILES['picture']['name'] != '')){
				$return = $this->uploadFile('picture');
				if(isset($return['id'])){
					$states['icon'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(!$error_upload){
				if($this->input->post('id')) {
					$states['id'] = $this->input->post('id');
					$return = $this->States_m->update($states);
				}else{
					$return = $this->States_m->insert($states);
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
		$this->load->model(array('States_m'));
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
					$order['column'] = 'states.id';
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

		
		$states = $this->States_m->get($params);
		$all_states = $this->States_m->getAll();
		$data = array();

		foreach($states as $key => $state){
						
			$data[] = array(
				$state->id,
				$state->name,
				'<a href="'.$state->path.'" target="_blank">'.$state->icon.'</a>',
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('states/edit/?id='.$state->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_states);
		$return["recordsFiltered"] = count($states);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
