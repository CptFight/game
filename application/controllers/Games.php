<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends MY_Controller {

	public function index(){
		$this->load->view('template', $this->data);
	}

	public function news(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Games_m','Characters_m', 'Games_characters_m','Games_characters_planets_m','Planets_m'));
		
		

		if($this->savePost()){
			redirect($back_path);
		}
		
		$this->load->view('template', $this->data);
	}

	public function edit(){
		$back_path = $this->getBackPath();

		$this->load->model(array('Games_m','Games_characters_m','Dialogs_m','Games_characters_planets_m','Planets_m'));

		
		if(!$this->input->get('id')){
			redirect($back_path);
		}else{	

			if($this->input->post('delete')){
				$this->Games_m->delete($this->input->get('id'));
				$this->Games_characters_m->deleteAll('game_id',$this->input->get('id'));
				$this->Dialogs_m->deleteAll('game_id',$this->input->get('id'));
				redirect($back_path);
			}
	
			if($this->savePost()){
				redirect($back_path);
			}		
		}

		$this->data['game'] = $this->Games_m->get($this->input->get('id'));
		$this->load->view('template', $this->data);
	}


	private function getBackPath(){
		if(isset($_GET['back_path'])){
			$this->data['back_path'] = $_GET['back_path'];
		}else{
			$this->data['back_path'] = 'games/index';
		}
		return $this->data['back_path'];
	}

	private function savePost(){
		if($this->input->post('save') ){
			
			if(!$this->input->post('id')) {
				
				$game = array(
					'user_id' => $this->current_user->id
				);
				$game_id = $this->Games_m->insert($game);

				$characters = $this->Characters_m->getAllFirstCharacter();
				$game_characters_ids = array();
				foreach($characters as $key => $character){
					$game_characters = array(
						'game_id' => $game_id,
						'character_id' => $character->id,
						'current_games_characters_status_id' => $character->first_game_character_status_id,
						'current_state_id' => $character->first_state_id,
						'current_area_id' => $character->first_area_id,
						'next_message_timestamp' => strtotime('now'), //TODO + message->delay
						
					);
					$game_characters_ids[] = $this->Games_characters_m->insert($game_characters);
				}

				$first_planet = $this->Planets_m->getFirstPlanet();
				foreach($game_characters_ids as $key => $game_characters_id){
					$games_characters_planet = array(
						'planet_id' => $first_planet->id,
						'games_character_id' => $game_characters_id
					);
					$this->Games_characters_planets_m->insert($games_characters_planet);
				}
				
			}else{
				//TODO EDIT
			}

			return true;
		}else{
			return false;	
		}
	}

	public function getAllDatatable(){
		$this->load->model(array('Games_m','Dialogs_m'));
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
					$order['column'] = 'id';
					break;			
				default:
					$order['column'] = 'id';
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

		
		$games = $this->Games_m->get($params);
		$all_games = $this->Games_m->getAll();
		$data = array();
		foreach($games as $key => $game){	
			$last_message = '';
			$messages = $this->Dialogs_m->getAll('game_id',$game->id);
			if($messages && is_array($messages) && count($messages) > 0){
				$last_message = array_pop($messages);
				$last_message = $last_message->value;

			}
			$data[] = array(
				$game->id,
				$last_message,
				'<ul class="list-tables-buttons">
                    <li class="table-btn-edit"><a href="'.site_url('games/edit/?id='.$game->id).'"><i class="fa fa-pencil"></i><span>'. $this->lang->line('edit').'</span></a></li>

                    <li class="table-btn-edit"><a target="_blank" href="'.site_url('heimdall/simulator/?game_id='.$game->id).'"><i class="fa fa-external-link"></i><span>'. $this->lang->line('edit').'</span></a></li>
                </ul>'
			);
		}
		$return["recordsTotal"] = count($all_games);
		$return["recordsFiltered"] = count($games);
		$return["data"] = $data;
		echo json_encode($return);
		 
	}



}
