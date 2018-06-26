<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stuffs extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Stuffs_m'));
	
		if($this->savePost()){
			redirect($back_path);
		}
		
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Stuffs_m'));

		if(!isset($_GET['id']) || $_GET['id'] == ''){
			redirect($back_path);
		}else{		
			
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['stuff'] = $this->Stuffs_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'stuffs/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			$stuffs = array();
			$stuffs['name'] = $this->input->post('name');

			$error_upload = false;
			if(isset($_FILES['picture']['name']) && ($_FILES['picture']['name'] != '')){
				$return = $this->uploadFile('picture');
				if(isset($return['id'])){
					$stuffs['icon'] = $return['id'];
				}else if(isset($return['error'])){
					$error_upload = true;
					$this->addError($return['error']);
				}
			}

			if(!$error_upload){
				if($this->input->post('id')) {
					$stuffs['id'] = $this->input->post('id');
					$return = $this->Stuffs_m->update($stuffs);
				}else{
					$return = $this->Stuffs_m->insert($stuffs);
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
		$this->load->model(array('Stuffs_m'));
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
				case 1:
					$order['column'] = 'name';
					break;	
				default:
					$order['column'] = 'stuffs.id';
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

		
		$stuffs = $this->Stuffs_m->get($params);
		$all_stuffs = $this->Stuffs_m->getAll();
		$data = array();

		foreach($stuffs as $key => $stuff){
						
			$data[] = array(
				$stuff->id,
				$stuff->name,
				'<a href="'.$stuff->path.'" target="_blank">'.$stuff->icon.'</a>',
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('stuffs/edit/?id='.$stuff->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_stuffs);
		$return["recordsFiltered"] = count($stuffs);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
