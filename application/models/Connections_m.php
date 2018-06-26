<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Connections_m extends MY_Model {

    public $_db = 'connections';
    public $_name = 'connections_m';


    public function getForAgenceSuperviser($params){
        $this->db->select('*');

        $this->db->join('users','connections.user_id = users.id');

        if(isset($params['agence_id'] ) && $params['agence_id']){ 
            $this->db->where('agence_id',$params['agence_id']);
        } 

         if(isset($params['user_id'] ) && $params['user_id']){ 
            $this->db->where('user_id',$params['user_id']);
        } 

        if($params['length'] <= 0){
           $params['length'] = $this->_limit; 
           $params['start'] = 0;
        } 

        if($params['search']){
            $request_search = "( users.name LIKE '%".$params['search']."%'";
            $request_search .= "OR users.firstname LIKE '%".$params['search']."%' )";
            $this->db->where($request_search);
        }

        if(isset($params['order'])){
            $this->db->order_by($params['order']['column'],$params['order']['dir']);
        }

        return $this->db->get($this->_db,$params['length'],$params['start'])->result();
    }
   
}