<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_m extends MY_Model {

    public $_db = 'users';
    public $_name = 'users_m';
  
    public function delete($id){
        $this->db->where('user_id', $id);
        $this->db->delete('connections'); 

        $this->db->where('user_id', $id);
        $this->db->delete('visits'); 

        $this->db->where('user_id', $id);
        $this->db->delete('uploads'); 

        $this->db->where('user_id', $id);
        $this->db->delete('subscribers');

        $sql = "DELETE FROM rappels WHERE rappels.favoris_id IN (SELECT id FROM favoris WHERE favoris.user_id = ".$id." )";
        $this->db->query($sql); 

        $sql = "DELETE FROM remarks WHERE remarks.favoris_id IN (SELECT id FROM favoris WHERE favoris.user_id = ".$id." )";
        $this->db->query($sql); 

        $this->db->where('user_id', $id);
        $this->db->delete('favoris'); 

        $this->db->where('user_id', $id);
        $this->db->delete('exports');  

        $this->db->where('user_id', $id);
        $this->db->delete('connections');  
        
        $this->db->where('id', $id);
        return $this->db->delete($this->_db);     
    }


    public function getByAgences($agence_id){
        $this->db->where('agence_id',$agence_id);
        return $this->db->get($this->_db)->result();
    }

    public function get($params) {
        $this->db->select('*,users.id as id,users.tel as tel, agences.tel as agences_tel, users.name as name, agences.name as agence_name, roles.name as role_name, users.adress as adress');
        $this->db->join('agences','users.agence_id = agences.id');
        $this->db->join('roles','users.role_id = roles.id');
    
        if(!is_array($params)){
            $id = $params;
            $this->db->where('users.id',$id);
            return $this->db->get($this->_db)->row();
        }else{

            if(!isset($params['deleted'])){
                $this->db->where('deleted !=',1);
            }

             if(isset($params['agence_id']) && $params['agence_id']){
                $this->db->where('agence_id',$params['agence_id']);
            }

            if($params['length'] <= 0){
               $params['length'] = $this->_limit; 
               $params['start'] = 0;
            } 

            
            if($params['search']){
                $request_search = "(";
                $request_search .= "users.name LIKE '%".$params['search']."%'";
                $request_search .= "OR agences.name LIKE '%".$params['search']."%'";
                $request_search .= "OR login LIKE '%".$params['search']."%' ";
                $request_search .= "OR users.tel LIKE '%".$params['search']."%' ";
                $request_search .= "OR roles.name LIKE '%".$params['search']."%' ";
                $request_search .= "OR firstname LIKE '%".$params['search']."%' ";
                $request_search .= "OR users.adress LIKE '%".$params['search']."%' ";
                $request_search .= ")";
                $this->db->where($request_search);
            }

            if(isset($params['order'])){
                $this->db->order_by($params['order']['column'],$params['order']['dir']);
            }

            return $this->db->get($this->_db,$params['length'],$params['start'])->result();
        }
    }

    public function emailExist($email){
        $this->db->where('login',$email);
        return $this->db->get($this->_db)->row();
    }

    public function getForAgenceSuperviser($params){
        $this->db->select('*,users.id as id, users.name as name, agences.name as agence_name');
        $this->db->join('agences','agence_id = agences.id');
        $this->db->where('deleted !=',1);

        if(isset($params['agence_id'] )){

          $this->db->where('agence_id',$params['agence_id']);
        } 


        if($params['length'] <= 0){
           $params['length'] = $this->_limit; 
           $params['start'] = 0;
        } 

        if($params['search']){
            $request_search = "( users.name LIKE '%".$params['search']."%'";
            $request_search .= " OR login LIKE '%".$params['search']."%' ";
            $request_search .= " OR users.tel LIKE '%".$params['search']."%' ";
            $request_search .= " OR firstname LIKE '%".$params['search']."%' ";
            $request_search .= " OR users.adress LIKE '%".$params['search']."%' ";
            $this->db->where($request_search);
        }

        if(isset($params['order'])){
            $this->db->order_by($params['order']['column'],$params['order']['dir']);
        }

        return $this->db->get($this->_db,$params['length'],$params['start'])->result();
    }

    public function getMandatairesList($agence_id){
        $this->db->where('agence_id',$agence_id);
        $this->db->where('deleted !=',1);
        return $this->db->get($this->_db)->result();
    }

    public function insert($user){
        return $this->db->insert($this->_db, $user); 
    }

    public function update($user){
        $this->db->where('id', $user['id']);
        unset($user['id']);
        return $this->db->update($this->_db, $user); 
    }


    public function updateLang($user_id,$lang){
        $data = array(
           'lang' => $lang
        );
        $this->db->where('id', $user_id);
        return $this->db->update($this->_db, $data); 
    }

    public function login($login, $password){
        $this->db->where('deleted !=',1);
        $today = strtotime('today');
        $tomorrow = strtotime('tomorrow');
        $this->db->group_by('users.id');
        $this->db->where('login',$login);
        $this->db->where('password',md5($password));
        $user = $this->db->get($this->_db)->row();
        if($user){
            $data = array(
                'id' => $user->id,
                'last_connection' => strtotime('now')
            );
            $this->update($data);
        }
        return $user;
     }
   
}