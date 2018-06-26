<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Planets_m extends MY_Model {

    public $_db = 'planets';
    public $_name = 'planets_m';

    public function getFirstPlanet(){
    	return $this->get(1);
    }
}