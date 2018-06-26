<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulaire extends MY_Controller {

	public function index() {
		$this->load->model(array('Annonces_m','Updates_m','Users_m'));
		$user = $this->Users_m->getCurrentUser();

		$this->data['user_id'] = $user->id;
		$this->lang->load('global', $user->lang);
		
		$this->load->view('template', $this->data);
	}
}

