<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_m extends MY_Model {

    public $_db = 'areas';
    public $_name = 'areas_m';

    public function get($params){

        $this->db->select('*, areas.id as id, upload_1.file_name as icon, upload_1.web_path as path_icon, upload_2.file_name as picture, upload_2.web_path as path_picture');
        $this->db->join('uploads as upload_1','upload_1.id = areas.icon','left');
        $this->db->join('uploads as upload_2','upload_2.id = areas.picture','left');
        
        if(!is_array($params)){
            $id = $params;
            $this->db->where('areas.id',$id);
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