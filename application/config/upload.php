<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['upload_repository']    = 'files/';
$config['upload_path']          = $_SERVER['DOCUMENT_ROOT'].'/game/'.$config['upload_repository'];
$config['allowed_types']        = 'gif|jpg|png|pdf';
$config['max_size']             = 2000;
$config['max_width']            = 8096;
$config['max_height']           = 7000;

