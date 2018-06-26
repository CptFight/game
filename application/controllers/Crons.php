<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Crons extends CI_Controller {

	public function mails($frequency){

		if(!$this->input->is_cli_request()){
	      	echo "This script can only be accessed via the command line" . PHP_EOL;
	      	return;
	  	}
		
		echo "Traitement.. \n";
		$this->config->load('email');
		$this->load->model(array('Subscribers_m','Annonces_m'));

		$date_min = strtotime(date("Y-m-d 00:00:01"));
		switch($frequency){
			case 'hour':
				$date_min = strtotime('-1 hour');
				break;
			case 'week':
				$date_min = strtotime('-1 week');
				break;
			case 'month':
				$date_min = strtotime('-1 month');
				break;
			case 'day':
			default:
				//already the good value;
				break;
		}

		$params_subscribers = array(
			"frequency" => $frequency,
			"active" => 1
		);
		$subscribers = $this->Subscribers_m->get($params_subscribers);
		if($subscribers && is_array($subscribers)){
			echo count($subscribers)." subscribers \n";
		}else{
			echo "No subscribers \n";
		}
		
		if($subscribers){
			foreach($subscribers as $key => $subscriber){
				$provinces = json_decode($subscriber->search_provinces);
				$criterias = array(
					'date_min' => $date_min,
					'date_max' => '',
					'price_min' => $subscriber->search_price_min,
					'price_max' => $subscriber->search_price_max,
					'zipcode' => $subscriber->search_zipcodes,
					'province' => $provinces,
					'lang' => $subscriber->search_lang,
					'vente' => $subscriber->search_sell,
					'created' => $date_min
				);

				$order = array(
					'column' => 'last_publication_id',
					'dir' => 'DESC'
				);

				$params = array(
					"search" => $subscriber->search_words,
					"start" => 0,
					"length" => 100,
					"order" => $order,
					"criterias" => $criterias
				);

				$annonces = $this->Annonces_m->get($params);
				echo "--------------------------\n";
				echo "Email : ".$subscriber->login." \n";
				if($annonces){
					echo "Annonces : ".count($annonces)." \n";
					$this->lang->load('global', $subscriber->lang);


					$data = array(
						"variable" => "test",
						"host" => "http://www.google.be",
						"subscriber" => $subscriber,
						"annonces" => $annonces
					);

					$this->load->library('email');
					$this->lang->load('global', $subscriber->lang);

					$this->email->from('no-reply@immoffice.be', 'Immoffice');
					$this->email->to($subscriber->login);
					//$this->email->cc('another@another-example.com');
					//$this->email->bcc('them@their-example.com');

					$this->email->subject($this->lang->line('mail_subscribers_subject'));


					$data = array(
						"variable" => "test",
						"host" => "http://www.google.be",
						"subscriber" => $subscriber,
						"annonces" => $annonces
					);
					$body = $this->load->view('emails/subscribers.php',$data,TRUE);
					$this->email->message($body);   
					
					if($this->email->send()){

						$this->load->model(array('Exports_m'));

						$datas = array();
						$datas['user_id'] = $subscriber->id;
				        $datas['nb_annonces'] = count($annonces);
				        $datas['type'] = 'email';
				        $datas['page'] = 'crons';
				        $datas['created'] = strtotime('now');
			
						$this->Exports_m->insert($datas);

						echo "Mail envoyé \n";
					}else{
						echo "ERROR Mails \n";
					}
				}
				
				
			}
		}
		
		
	}

}
