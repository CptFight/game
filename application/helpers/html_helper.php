<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	function title($string) {
		$CI =& get_instance();
		if($CI->_page->metatitle != '') {
			$string = t('config.sitename') . ' - ' . $CI->_page->metatitle;
		}
		
		e('<title>' . $string . '</title>');
	}

	function e($string) {
		echo $string;
	}
	
	function v($value, $property = false, $default = '') {
		return (isset($value) ? (isset($value->$property) ? $value->$property : $value) : $default);
	}
	
	
	function f($value, $property = false, $default = '') {
		e(v($value, $property, $default));
	}
	
	function t($label) {
		$CI =& get_instance();
		$return = $CI->lang->line($label);
		if($return == '') {
			$CI->_labels_not_found[] = $label;
		}
		return $return;
	}
	
	function l($label) {
		e(t($label));
	}
	
	function get_router_method($separator = ' ', $method = false) {
		$CI =& get_instance();
		return $CI->router->class . $separator . ($method !== false ? $method : $CI->router->method);
	}

	function i($src = '', $index_page = FALSE) {
		e (img($src, $index_page));
	}
	
	function d($content, $exit = false) {
		$backtrace = debug_backtrace();
		$backtrace = $backtrace[0];
		echo '<div style="background:#eee; border: 1px solid #666; padding: 10px; font-family: monospace; color: #666; margin: 5px;">';
		echo (is_array($content) || is_object($content)) ? '<pre>' . print_r($content, true) . '</pre>' : (!is_bool($content) ? $content : ($content ? 'TRUE' : 'FALSE'));
		echo '<p style="font-weight: bold;">Ce debug se situe dans <span style="color: #2C88EA">' . $backtrace['file'] . '</span> à la ligne <span style="color: #2C88EA">' . $backtrace['line'] . '</span></p>';
		echo '</div>';
		if($exit) {
			exit;
		}
	}


	function flag($language) {
		return img('images/flags/' . $language. '.png');
	}

	function icon($action, $link = false, $attributes = array()) {
		$CI =& get_instance();

		if ($link !== false) {
			return anchor(
				base_url() . $CI->router->uri->uri_string . '/' . $action . '/' . $link, 
				'<span class="hide">' . t('admin-action-'.$action). '</span>', 
				$attributes
			);
		}
		else {
			if(isset($attributes['class'])){
				$attributes = ' class="'.$attributes['class'].'"';
			}else{
				$attributes = '';
			}
			return '<span'.$attributes.'>' . t('admin-action-'.$action). '</span>';
		}
	}
	
	function script_tag($script) {
		global $CI;
		$add_href = '&amp;label=' . (get_router_method());
		if($CI->config->item('csrf_protection') == TRUE) {
			$add_href .= '&amp;token=' . $CI->security->csrf_token_name;
			$add_href .= '&amp;tokenvalue=' . $CI->security->csrf_hash;
		}
		else {
			$add_href .= '&amp;token=token';
			$add_href .= '&amp;tokenvalue=' . $CI->session->userdata('token');
		}

		if(count($CI->_languages) > 1) $add_href .= '&amp;multilang=1';
		return '<script type="text/javascript" src="' . base_url() . $script . $add_href . '"></script>';		
	}
	
	function session($key) {
		$CI =& get_instance();
		return $CI->session->userdata[$key];
	}
	
	function checkToken(){
		global $CI;
		
		if($CI->config->item('csrf_protection') === FALSE) {
			//$token_name = $CI->security->csrf_token_name;
			//$token_value = $CI->security->csrf_hash;

			$token_name = 'token';
			$token_value = $CI->session->userdata('token');
		
			if(isset($_POST[$token_name]) && $_POST[$token_name] == $token_value) return true;
			else show_error('The action you have requested is not allowed.');
		}
	}
	
	function check_access($config, $redirectUrl = false) {
		global $CI;

		if($config_item = $CI->config->item($config)) {
			$return = array_key_exists($config_item, $CI->session->userdata('group'));
		}
		if($redirectUrl !== false && !$return) {
			redirect($redirectUrl);	
			exit;
		}
		return $return;
	}

	// Added by Vince
	function echo_pre_data($data, $die = false) {
	    echo "<pre>";
	    print_r($data);
	    echo "</pre>";
	    if ($die) die();
	}
	
	
	function echo_php_array($array) {
	    // for JS
	    $out = '';
	    foreach ($array as $key => $value) {
		$out .= "* $key = $value | ";
	    }
	    echo $out;
	}

	function echo_array($array, $die = false) {
	    
	    $out = '';
	    foreach ($array as $key => $value) {
		
		echo $key;
		echo $value;
		echo "<br>";
	    }
	    echo $out;
	    if ($die) die();
	}
?>