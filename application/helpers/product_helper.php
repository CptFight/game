<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	function get_last_price($json_price) {
		/*$prices = json_decode($json_price);
		if(isset($prices[count($prices) -1]) && $prices[count($prices) -1]->value)
			return $prices[count($prices) -1]->value;
		else return 0;*/
		return 0;
	}

	function get_last_update($product){
		/*$prices = json_decode($product->price);
		$promo_prices = json_decode($product->promo_price);

		$timestamp = 0;
		if(isset($prices[count($prices) -1]) && $prices[count($prices) -1]->timestamp)
			$timestamp = $prices[count($prices) -1]->timestamp;

		if(isset($promo_prices[count($promo_prices) -1]) && $promo_prices[count($promo_prices) -1]->timestamp && $promo_prices[count($promo_prices) -1]->timestamp > $timestamp)
			$timestamp = $promo_prices[count($promo_prices) -1]->timestamp;

		if($timestamp == 0) return "N/A";
		else return date('d/m/Y h:i:s',$timestamp);*/
		return 0;
	}