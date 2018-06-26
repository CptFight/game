<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_accessibilite_m extends MY_Model {

    public $_db = 'areas_accessibilite';
    public $_name = 'areas_accessibilite_m';


    public function getAll($target = false,$value = false){
        $this->db->where($target,$value);
        $lists_id = $this->db->get($this->_db)->result();
        $return = array();
        foreach($lists_id as $key => $infos){
            $return[] = $infos->from_area_id;
        }
        return $return;
    }
}