<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dialogs_m extends MY_Model {

    public $_db = 'dialogs';
    public $_name = 'dialogs_m';

    public function reset($game_id){
        $this->db->where('game_id', $game_id);
        $this->db->delete($this->_db); 
    }

    public function getAll($table = false,$value = false) {
        $this->db->select('*,dialogs.id as id, dialogs.message_id as message_id, areas.name as area_name');
    	$this->db->join('messages', 'messages.id = dialogs.message_id');
        $this->db->join('areas', 'areas.id = messages.area_id');
        $this->db->join('characters', 'characters.id = messages.character_from_id');
        if($table){
            $this->db->where($table,$value);
        }
        $this->db->where('date <=',strtotime('now'));
        $this->db->order_by('dialogs.date','asc');
        return $this->db->get($this->_db)->result();
    }

    public function getLastMessageFromChar($game_id,$char_id) {
        $this->db->select('*,dialogs.id as id, dialogs.message_id as message_id');
        $this->db->join('messages', 'messages.id = dialogs.message_id');
        $this->db->join('characters', 'characters.id = messages.character_from_id');

        $this->db->where('characters.id',$char_id);
        $this->db->where('game_id',$game_id);

        $this->db->where('date <=',strtotime('now'));
        $this->db->limit(1);
        $this->db->order_by('dialogs.date','desc');
        

        return $this->db->get($this->_db)->row();
         // $this->db->last_query();
    }

    public function exist($game_id,$message_id){
        $this->db->where('game_id',$game_id);
        $this->db->where('message_id',$message_id);
        return $this->db->get($this->_db)->row();
    }

}