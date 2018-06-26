<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exports extends MY_Controller {

	

	//AJAX

	public function insertExport(){
		$this->load->model(array('Exports_m'));

		$datas = array();
		$datas['user_id'] = $this->input->post('user_id');
        $datas['nb_annonces'] = $this->input->post('nb_annonces');
        $datas['type'] = $this->input->post('type');
        $datas['page'] = $this->input->post('page');
        $datas['created'] = strtotime('now');
       
		$this->Exports_m->insert($datas);
	}


}

