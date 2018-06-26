<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Characters_m extends MY_Model {

    public $_db = 'characters';
    public $_name = 'characters_m';

    public function get($params){

        $this->db->select('*, characters.id as id, uploads.file_name as icon, uploads.web_path as path,characters_types.value as type_value');
        $this->db->join('uploads','uploads.id = characters.icon','left');
        $this->db->join('characters_types','characters_types.id = characters.character_type_id');
       
        if(!is_array($params)){
            $id = $params;
            $this->db->where('characters.id',$id);
            return $this->db->get($this->_db)->row();
        }else{
            if($params['length'] <= 0){
               $params['length'] = $this->_limit; 
               $params['start'] = 0;
            } 

            if($params['search']){
                $request_search = "(";
                $request_search .= "name LIKE '%".$params['search']."%'";
                $request_search .= "OR icon LIKE '%".$params['search']."%'";
                $request_search .= ")";
                $this->db->where($request_search);
            }

            if(isset($params['order'])){
                $this->db->order_by($params['order']['column'],$params['order']['dir']);
            }

            return  $this->db->get($this->_db,$params['length'],$params['start'])->result();
        }

    }

    public function getAllFirstCharacter(){
        $this->db->select('*,characters_types.value as type_value, characters.id as id');
        $this->db->join('characters_types','characters_types.id = characters.character_type_id');
        $this->db->where("character_type_id",2);
        $this->db->where("first_area_id",1);
        return $this->db->get($this->_db)->result();
    }

     public function getAll($table = false,$value = false) {
        $this->db->select('*,characters_types.value as type_value, characters.id as id');
        $this->db->join('characters_types','characters_types.id = characters.character_type_id');
        if($table){
            $this->db->where($table,$value);
        }

        return $this->db->get($this->_db)->result();
    }


}