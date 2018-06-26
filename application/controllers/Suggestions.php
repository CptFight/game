<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suggestions extends MY_Controller {

	public function index() {
		
		if($this->input->post('submit')){
			$this->config->load('email');
			$this->load->library('email');


			$this->email->from('no-reply@immoffice.be', 'Immoffice');
			$this->email->to('gabypirson@immoffice.be');
			$this->email->cc('walid.rafiki@immoffice.be');
			$this->email->subject('Suggestions from Immoffice');

			$message = "Message from ".$this->input->post('name')." : ".$this->input->post('email')." <br/> ";
			$message .= $this->input->post('message');
   			$this->email->message($message);   
   			
   			if($this->email->send()){
				$this->addMessage($this->lang->line('mail_send'));
			}else{

				$this->addError($this->lang->line('mail_not_send'));
			}

		}
		$this->load->view('template', $this->data);
	}

}

