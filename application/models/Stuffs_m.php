<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stuffs_m extends MY_Model {

    public $_db = 'stuffs';
    public $_name = 'stuffs_m';

    public function get($params){

        $this->db->select('*, stuffs.id as id, uploads.file_name as icon, uploads.web_path as path');
        $this->db->join('uploads','uploads.id = stuffs.icon','left');
       
        if(!is_array($params)){
            $id = $params;
            $this->db->where('stuffs.id',$id);
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



}