<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Heimdall extends MY_Controller {

	public function index() {

		$this->load->view('template', $this->data);
	}

	public function refreshDialog(){
		//TRANSFORM ALL GESTION TO CRON. 
	}

	public function simulator(){

		if($this->input->get('game_id')){
			$game_id = $this->input->get('game_id');
		}else{
			redirect('games/index');
		}

		$this->load->model(array('Updates_games_characters_status_m','Dialogs_m','Messages_m','Games_characters_m','Characters_m','Games_characters_planets_m','Planets_m'));

		//$this->Dialogs_m->reset($game_id);
		//$this->Games_characters_m->reset($game_id);


		//manage activation reporting. 
		if($this->input->post('character')){
			$this->activeReporting($game_id);
		}

		//manage answer
		if($this->input->post('answer')){
			$this->updateAnwer($game_id);
		}

		$dialogs = $this->getDialog($game_id);
		$answers = $this->getAnswers($game_id);
		$reporting_characters = $this->Games_characters_m->getReporting($game_id);

		$all_characters = $this->Games_characters_m->getAll('game_id',$game_id);

		//set urgent case
		$waiting_for_urgent_response_characters = $this->Games_characters_m->getWaitingForUrgentResponse($game_id);
		if($waiting_for_urgent_response_characters && is_array($waiting_for_urgent_response_characters) && count($waiting_for_urgent_response_characters) > 0){
			$characters = $this->activeOneChar($reporting_characters,$waiting_for_urgent_response_characters[0]->id,true);
			$answers = array();
		}

		$this->data['reporting_characters'] = $reporting_characters; 
		$this->data['all_characters'] = $all_characters; 
		$this->data['answers'] = $answers;
		$this->data['dialogs'] = $dialogs;
		$this->load->view('template_empty', $this->data);	
	}

	public function activeReporting($game_id){
		$reporting_characters = $this->Games_characters_m->getReporting($game_id);

		//ask for reporting char. 
		$character_id = $this->input->post('character');
		$character = $this->getCharacterOnList($reporting_characters,$character_id);



		$message = $this->Messages_m->getNextMessage($character->character_id,$character->last_message_id);
		
		if(!$this->Dialogs_m->exist($game_id,$message->id)){
			$dialog_data = array('game_id' => $game_id, 'message_id' => $message->id, 'date' => strtotime('now'));
			$this->Dialogs_m->insert($dialog_data);
		}

		$updates_games_characters_status = $this->Updates_games_characters_status_m->getAll('message_id',$message->id);
		foreach($updates_games_characters_status as $key => $update ){
			$this->Games_characters_m->updateStatus($update->game_characters_id,$update->game_characters_status_id);
		}

		$this->Games_characters_m->updateLastMessageId($character_id,$message->id);
	}

	public function resetGame($game_id){
		$this->load->model(array('Games_characters_m'));
		$this->Games_characters_m->reset($game_id);
	}

	public function updateDialog($game_id){
		$this->load->model(array('Games_characters_m'));
		//TODO
		$acting_characters = $this->Games_characters_m->getActing($game_id);
		foreach($acting_characters as $key => $character){
			$message = $this->Messages_m->getNextMessage($character_id,$character->last_message_id);
			print_r($message);
		}
	}

	public function getDialog($game_id){
		$this->load->model(array('Dialogs_m'));
		$dialogs = $this->Dialogs_m->getAll('game_id',$game_id);
		if(!$dialogs){
			$dialogs = array();
		} 
		return $dialogs;
	}

	public function getAnswers($game_id){
		$this->load->model(array('Games_characters_m'));
		$answers = array();
		$waiting_for_response_characters = $this->Games_characters_m->getWaitingForResponse($game_id);
		if($waiting_for_response_characters && is_array($waiting_for_response_characters) && count($waiting_for_response_characters) > 0){
			foreach($waiting_for_response_characters as $key => $char){
				$answers[] = array(
					'char_id' => $char->id,
					'name' => $char->name." ".$char->firstname,
					'answers' => $this->Messages_m->getAll('message_from_id',$char->last_message_id)
				);
			}
		}
		return $answers;
	}

	public function updateAnwer($game_id){
		$this->load->model(array('Games_characters_m','Dialogs_m'));

		$message_id = $this->input->post('answer');

		$message = $this->Messages_m->get($message_id);
		$character_id = $message->game_character_to_id;

		if(!$this->Dialogs_m->exist($game_id,$message->id)){
			$dialog_data = array('game_id' => $game_id, 'message_id' => $message->id, 'date' => strtotime('now'));
			$this->Dialogs_m->insert($dialog_data);
		}

		$updates_games_characters_status = $this->Updates_games_characters_status_m->getAll('message_id',$message->id);
		foreach($updates_games_characters_status as $key => $update ){
			$this->Games_characters_m->updateStatus($update->game_characters_id,$update->game_characters_status_id);
		}

		$this->Games_characters_m->updateLastMessageId(1,$message->id);
		$this->Games_characters_m->updateLastMessageId($character_id,$message->id);
	}

	public function activeOneChar($characters, $char_id, $alert = false){
		foreach ($characters as $key => $char) {
			if($char->id == $char_id){
				$characters[$key]->active = true;
				$characters[$key]->alert = $alert;
			}else{
				$characters[$key]->active = false;
				$characters[$key]->alert = false;
			}
		}
		return $characters;
	}

	public function getCharacterOnList($characters,$char_id){
		foreach ($characters as $key => $char) {
			if($char->id == $char_id){
				return $char;
			}
		}
		return false;
	}

	public function oldsimulator() {

		if($this->input->get('game_id')){
			$game_id = $this->input->get('game_id');
		}else{
			redirect('games/index');
		}
		
		$this->load->model(array('Dialogs_m','Messages_m','Games_characters_m','Characters_m','Games_characters_planets_m','Planets_m'));
		
		if($this->input->post('character')){
			$character_id = $this->input->post('character');
			$game_char = $this->Games_characters_m->getGameChar($game_id,$character_id);

			
			$game_char_data = array();
			$game_char_data['id'] = $game_char->id;
			$game_char_data['current_games_characters_status_id'] = $game_char->current_games_characters_status_id;
			$this->Games_characters_m->update($game_char_data);

			$messages_from_this_char = $this->Dialogs_m->getAll(array('game_id','character_id'), array($game_id,$character_id));
			if(!$messages_from_this_char){
				$message = $this->Messages_m->get($game_char->last_message_id);
				$delay = strtotime('now')+$message->delay;
				$dialog_data = array('game_id' => $game_id, 'message_id' => $game_char->last_message_id, 'date' => $delay);
				$this->Dialogs_m->insert($dialog_data);

				$game_char_data = array();
				$game_char_data['current_games_characters_status_id'] = $message->current_games_characters_status_id;
				$game_char_data['next_intervention'] = $delay;
				$this->Games_characters_m->updateWhere(array('game_id','character_id'),array($game_id,$character_id),$game_char_data);
			}
		}

		if($this->input->post('answer')){
			//inject answer
			$message_id = $this->input->post('answer');
			$message = $this->Messages_m->get($message_id);
			$character_target_id = $message->character_to_id;

			$dialog_data = array('game_id' => $game_id, 'message_id' => $message->id, 'date' => strtotime('now'));
			$this->Dialogs_m->insert($dialog_data);
			$delay = strtotime('now') + $message->delay;
			$current_games_characters_status_id = $message->current_games_characters_status_id;
			//injecct dialgu next until answer needed

			//inject first message. 
			/*$message = $this->Messages_m->get($message->message_to_id);
			$dialog_data = array('game_id' => $game_id, 'message_id' => $message->id, 'date' => $delay) ;
			$this->Dialogs_m->insert($dialog_data);*/
		
			//inject all messages after
			if($message->message_to_id){
				$end = false;
				$message = $this->Messages_m->get($message->message_to_id);

				while(!$end){

					$dialog_data = array('game_id' => $game_id, 'message_id' => $message->id, 'date' => $delay) ;
					$this->Dialogs_m->insert($dialog_data);
					
					$delay += $message->delay;
					if($message->message_to_id){
						$message = $this->Messages_m->get($message->message_to_id);
					}else{
						$end = true;
					}			
				}
			}
		
			$game_char_data = array();
			$game_char_data['current_games_characters_status_id'] = $current_games_characters_status_id;
			$game_char_data['next_intervention'] = $delay;
			$this->Games_characters_m->updateWhere(array('game_id','character_id'),array($game_id,$character_target_id),$game_char_data);
		}

		$characters = $this->Games_characters_m->getWaiting($game_id);
		$all_chars = $this->Games_characters_m->getAll('game_id',$game_id);
	

		$dialogs = $this->Dialogs_m->getAll('game_id',$game_id);
		$answers = array();
		if(!$dialogs){
			$dialogs = array();
		} 
		else{

			foreach($all_chars as $key => $char){
				$last_message = $this->Dialogs_m->getLastMessageFromChar($game_id,$char->character_id);
				if($last_message){
					$answers[] = array(
						'char_id' => $char->id,
						'name' => $char->name." ".$char->firstname,
						'answers' => $this->Messages_m->getAll('answer_from_id',$last_message->message_id)
					);
					//unset($characters[$key]);

					/*$game_char_data = array();
			$game_char_data['current_games_characters_status_id'] = $current_games_characters_status_id;
			$game_char_data['next_intervention'] = $delay;
			$this->Games_characters_m->updateWhere(array('game_id','character_id'),array($game_id,$character_target_id),$game_char_data);*/
				}
			}
		}


		/*if($answers && is_array($answers) && count($answers) > 0){
			foreach ($characters as $key => $character) {
				$characters[$key]->active = false;
			}
		}*/

		

		$this->data['characters'] = $characters; 
		$this->data['all_chars'] = $all_chars; 
		$this->data['answers'] = $answers;
		$this->data['dialogs'] = $dialogs;
		$this->load->view('template_no_layout', $this->data);
	}
}

