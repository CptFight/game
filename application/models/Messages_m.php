<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_m extends MY_Model {

    public $_db = 'messages';
    public $_name = 'messages_m';


    public function getAll($table = false,$value = false) {
    	$this->db->select('*, messages.id as id');
    	$this->db->join('characters', 'characters.id = messages.character_from_id');
        if($table){
            $this->db->where($table,$value);
        }
        return $this->db->get($this->_db)->result();
    }

    public function getPanel($id) {
        $this->db->select('*, messages.id as id');
        $this->db->join('characters', 'characters.id = messages.character_from_id');

        $id_min = $id - 20;
        $id_max = $id + 20;

        if($id_min < 0) $id_min = 0;
        
        $this->db->where('messages.id >=',$id_min); 
        $this->db->where('messages.id <=',$id_max); 

        return $this->db->get($this->_db)->result();
    }

    public function getNextMessage($character_id, $last_message_id = false){
        if($last_message_id){
            $this->db->where('message_from_id',$last_message_id); 
            return $this->db->get($this->_db)->row();
        }else{
            $this->db->where('character_from_id',$character_id); 
            $this->db->order_by('id'); 
            return $this->db->get($this->_db)->row();
        }

        return false;
    }



}