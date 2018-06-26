<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	function n($page = false) {
		//echo $page;
		/*$url = site_url($page);
		e($url);*/
		e(base_url().$page);
	}