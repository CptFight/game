<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Areas_m','Messages_m'));
	
		if($this->savePost()){
			redirect($back_path);
		}
		
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['messages'] = $this->Messages_m->getAll('message_type_id',4);
		
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Areas_m','Messages_m', 'Areas_accessibilite_m'));

		if(!isset($_GET['id']) || $_GET['id'] == ''){
			redirect($back_path);
		}else{		
			
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['area'] = $this->Areas_m->get($this->input->get('id'));
		$this->data['areas'] = $this->Areas_m->getAll();
		$this->data['messages'] = $this->Messages_m->getAll('message_type_id',4);
		$areas_accessibilites =  $this->Areas_accessibilite_m->getAll('target_area_id',$this->input->get('id'));
		$areas_accessibilites[] = $_GET['id'];
		$this->data['areas_accessibilites'] =$areas_accessibilites;
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'areas/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			

			$areas = array();
			$areas['name'] = $this->input->post('name');
			$areas['first_message_id'] = $this->input->post('first_message_id');

			$error_upload = false;
			if(isset($_FILES['picture']['name']) && ($_FILES['picture']['name'] != '')){
				$return = $this->uploadFile('picture');
				if(isset($return['id'])){
					$areas['picture'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(isset($_FILES['icon']['name']) && ($_FILES['icon']['name'] != '')){
				$return = $this->uploadFile('icon');
				if(isset($return['id'])){
					$areas['icon'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(!$error_upload){
				if($this->input->post('id')) {
					$areas['id'] = $this->input->post('id');
					$target_area_id = $this->Areas_m->update($areas);
				}else{
					$target_area_id = $this->Areas_m->insert($areas);
				}

				if(!$target_area_id){

					$this->addError($this->lang->line('update_error'));
					return false;
				}
			}


			$this->load->model(array('Areas_accessibilite_m'));
			$this->Areas_accessibilite_m->deleteAll('target_area_id',$target_area_id);
			foreach($this->input->post('accessibilite') as $key => $area_id){
				$accessibilite = array();
				$accessibilite['target_area_id'] = $target_area_id;
				$accessibilite['from_area_id'] = $area_id;
				$this->Areas_accessibilite_m->insert($accessibilite);
			}

			$this->addMessage($this->lang->line('update_done'));

			return true;
		}else{
			return false;	
		}
	}

	public function getAllDatatable(){
		$this->load->model(array('Areas_m'));
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
					$order['column'] = 'areas.id';
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

		
		$areas = $this->Areas_m->get($params);
		$all_areas = $this->Areas_m->getAll();
		$data = array();

		foreach($areas as $key => $area){
						
			$data[] = array(
				$area->id,
				$area->name,
				'<a href="'.$area->path_icon.'" target="_blank">'.$area->icon.'</a>',
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('areas/edit/?id='.$area->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_areas);
		$return["recordsFiltered"] = count($areas);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
