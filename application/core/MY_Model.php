<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    
    public $_limit = 0;

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /*public function get($id) {
      $this->db->where('id',$id);
      return $this->db->get($this->_db)->row();
    }*/

    public function get($params){
        if(!is_array($params)){
            $id = $params;
            $this->db->where('id',$id);
            return $this->db->get($this->_db)->row();
        }else{
            if($params['length'] <= 0){
               $params['length'] = $this->_limit; 
               $params['start'] = 0;
            } 

            if(isset($params['order'])){
                $this->db->order_by($params['order']['column'],$params['order']['dir']);
            }

            return  $this->db->get($this->_db,$params['length'],$params['start'])->result();
        }

    }

    public function getAll($tables = false,$value = false) {
        if(is_array($tables)){
            foreach($tables as $key => $table_value){
                $this->db->where($table_value, $value[$key]);
            }
        }else{
            $this->db->where($tables,$value);
        }
        return $this->db->get($this->_db)->result();
    }

    public function count(){
        return count($this->db->get($this->_db)->result());
    }

    public function update($object){
        $this->db->where('id', $object['id']);
        $id = $object['id'];
        unset($object['id']);
        if($this->db->update($this->_db, $object)){
            return $id;
        }else{
            return false;
        }
        
    }

    public function updateWhere($tables,$value,$object){
        if(is_array($tables)){
            foreach($tables as $key => $table_value){
                $this->db->where($table_value, $value[$key]);
            }
        }else{
            $this->db->where($tables, $value);
        }
        
        if($this->db->update($this->_db, $object)){
            return true;
        }else{
            return false;
        }   
    }

    public function insert($data){
        if(isset($data['id'])){
            unset($data['id']);
        }
        if($this->db->insert($this->_db, $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function delete($id){
        try{
            $this->db->where('id', $id);
            return $this->db->delete($this->_db); 
        }catch(exception $e){
            return false;
        }
    }

    public function deleteAll($table,$value){
        try{
            $this->db->where($table, $value);
            return $this->db->delete($this->_db); 
        }catch(exception $e){
            return false;
        }
    }


    public function getCurrentUser(){
        $user = $this->session->get_userdata('user');
      
        if(!$user || !isset($user['user']) || !isset($user['user']->id)){
            redirect('/users/login');
        }else{
            $user = $user['user'];
        }
        return $user;
    }


}