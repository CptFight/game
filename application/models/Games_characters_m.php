<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Games_characters_m extends MY_Model {

    public $_db = 'games_characters';
    public $_name = 'games_characters_m';

    public function getGameChar($game_id,$character_id){
        $this->db->where('game_id',$game_id);
        $this->db->where('character_id',$character_id);
        return $this->db->get($this->_db)->row();
    }

    public function getAll($table = false,$value = false) {
        $this->db->select('games_characters.id as id, character_id, games_characters_status.value as status, states.name as state ,current_area_id as area_id, characters.name,characters.firstname,characters.icon, uploads.web_path as icon, last_message_id
      ');
        $this->db->join('characters', 'characters.id = games_characters.character_id');
        $this->db->join('uploads', 'uploads.id = characters.icon','LEFT');
        $this->db->join('states', 'states.id = games_characters.current_state_id','LEFT');
        $this->db->join('games_characters_status', 'games_characters_status.id = games_characters.current_games_characters_status_id','LEFT');
        //$this->db->where('game_id',$game_id);
        if($table){
            $this->db->where($table,$value);
        }
        $this->db->order_by('id');
        return $this->db->get($this->_db)->result();
    }

    public function reset($game_id){
        $this->db->set('current_games_characters_status_id', 1);
        $this->db->set('last_message_timestamp', NULL);
        $this->db->set('last_message_id', NULL);
        $this->db->set('next_message_timestamp', 0);
        $this->db->set('current_state_id', NULL);
        $this->db->set('current_area_id', 1);
        $this->db->where('game_id', $game_id);
        $this->db->where('character_id != ', 1);
        $this->db->update($this->_db); 
    }

    private function constructBasicRequest($game_id){
        $this->db->select('games_characters.id as id, character_id, games_characters_status.value as status, states.name as state ,current_area_id as area_id, characters.name,characters.firstname,characters.icon,characters.color, uploads.web_path as icon, last_message_id
      ');
        $this->db->join('characters', 'characters.id = games_characters.character_id');
        $this->db->join('uploads', 'uploads.id = characters.icon','LEFT');
        $this->db->join('states', 'states.id = games_characters.current_state_id','LEFT');
        $this->db->join('games_characters_status', 'games_characters_status.id = games_characters.current_games_characters_status_id','LEFT');
        $this->db->where('game_id',$game_id);
        $this->db->where('next_message_timestamp <=',strtotime('now'));
        $this->db->order_by('id');
        $this->db->where('character_type_id',2);
    }

    public function getWaiting($game_id){
        $this->constructBasicRequest($game_id);
        $this->db->where('(games_characters.current_games_characters_status_id = 1 OR games_characters.current_games_characters_status_id = 2 OR games_characters.current_games_characters_status_id = 3)');
        return $this->db->get($this->_db)->result();
    }

     public function getActing($game_id){
        $this->constructBasicRequest($game_id);
        $this->db->where('(games_characters.current_games_characters_status_id = 4 OR games_characters.current_games_characters_status_id = 5 OR games_characters.current_games_characters_status_id = 6 OR games_characters.current_games_characters_status_id = 7)');
        return $this->db->get($this->_db)->result();
    }

    public function getReporting($game_id){
        $this->constructBasicRequest($game_id);
        $this->db->where('games_characters.current_games_characters_status_id = 1');
        return $this->db->get($this->_db)->result();
    }

    public function getWaitingForResponse($game_id){
        $this->constructBasicRequest($game_id);
        $this->db->where('games_characters.current_games_characters_status_id = 2');
        return $this->db->get($this->_db)->result();
    }

    public function getWaitingForUrgentResponse($game_id){
        $this->constructBasicRequest($game_id);
        $this->db->where('games_characters.current_games_characters_status_id = 3');
        return $this->db->get($this->_db)->result();
    }


    public function updateLastMessageId($char_id,$message_id){
        $this->db->set('last_message_id', $message_id);
        $this->db->set('last_message_timestamp', strtotime('now'));
        $this->db->where('id', $char_id);
        $this->db->update($this->_db); 
    }

    public function updateStatus($char_id,$status_id){
        $this->db->set('current_games_characters_status_id', $status_id);
        $this->db->where('id', $char_id);
        $this->db->update($this->_db); 
    }



   

}