<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Params extends MY_Controller {

	public function edit(){
		
		$this->load->model(array('Agences_m','Status_m','Users_m'));
	

		if($this->input->post('save')){

			$agence['id'] = $this->current_user->agence_id;
			$agence['adress'] = $this->input->post('adress');
			$agence['number'] = $this->input->post('number');
			$agence['zipcode'] = $this->input->post('zipcode');
			$agence['city'] = $this->input->post('city');
			$agence['tel'] = $this->input->post('tel');
			
			$status_favoris_names = $this->input->post('status_favoris');
			$status_favoris_ids = $this->input->post('status_favoris_id');
			$status_favoris_colors = $this->input->post('status_favoris_color');

			foreach($status_favoris_names as $key => $status_favoris){
				if($status_favoris && $status_favoris != ''){

					$status = array();
					$status['agence_id'] = $this->current_user->agence_id;
					$status['name'] = $status_favoris;
					if(isset($status_favoris_colors[$key]) && $status_favoris_colors[$key]){
						$status['color'] = $status_favoris_colors[$key];
					}else{
						$status['color'] = "#ffffff";
					}
					$status['type'] = 'favoris';

					if(isset($status_favoris_ids[$key]) && $status_favoris_ids[$key]){
						$status['id'] = $status_favoris_ids[$key];
						$this->Status_m->update($status);
					}else{
						$this->Status_m->insert($status);
					}
					
				}
			}

			$status_owners_names = $this->input->post('status_owners');
			$status_owners_ids = $this->input->post('status_owners_id');
			$status_owners_colors = $this->input->post('status_owners_color');

			foreach($status_owners_names as $key => $status_owners){
				if($status_owners && $status_owners != ''){

					$status = array();
					$status['agence_id'] = $this->current_user->agence_id;
					$status['name'] = $status_owners;
					if(isset($status_owners_colors[$key]) && $status_owners_colors[$key]){
						$status['color'] = $status_owners_colors[$key];
					}else{
						$status['color'] = "#ffffff";
					}
					$status['type'] = 'owners';

					if(isset($status_owners_ids[$key]) && $status_owners_ids[$key]){
						$status['id'] = $status_owners_ids[$key];
						$this->Status_m->update($status);
					}else{
						$this->Status_m->insert($status);
					}
					
				}
			}

			if($this->Agences_m->update($agence)){
				//$this->addMessage($this->lang->line('update_done'));
			}

			$user = array();
			$user['id'] = $this->current_user->id;
			$user['lang'] = $this->current_user->lang = $this->input->post('lang');
			$user['public_access'] = $this->current_user->public_access = $this->input->post('public_access');
			$user['public_access_option'] = $this->current_user->public_access_option = $this->input->post('public_access_option');

			$user['direct_access_page'] = $this->current_user->direct_access_page = $this->input->post('direct_access_page');
			if($this->Users_m->update($user)){
				$this->addMessage($this->lang->line('update_done'));
			}
			
			
		}

		$this->data['status_favoris'] = $this->Status_m->getStatus($this->current_user->agence_id,'favoris');
		$this->data['status_owners'] = $this->Status_m->getStatus($this->current_user->agence_id,'owners');
		
		$this->data['agence'] = $this->Agences_m->get($this->current_user->agence_id);
		$this->data['user'] = $this->Users_m->get($this->current_user->id);

		$this->data['tab'] = 1;
		$this->load->view('template', $this->data);
	}

}
