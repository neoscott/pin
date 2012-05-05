<?php

require 'functions.php';
require 'config.php';

// define variables
$apptitle = 'pinrural';
$placeholder = 'Localidad';
$btn_search = 'Buscar casas rurales';
$credits = 'experimento realizado por <a href="http://miquelcamps.com" target="_blank">Miquel Camps Orteza</a> con la api de <a href="http://www.toprural.com/" target="_blank">toprural</a>, <a href="https://developers.google.com/maps/?hl=es" target="_blank">google maps</a>, <a href="http://jquery.com" target="_blank">jquery</a> y <a href="http://masonry.desandro.com/index.html" target="_blank">masonry</a>';
$lat = $lng = false;
$items = array();

// geolocation
$default = array('lat' => 42.3408923, 'lng' => -3.6997623, 'q' => 'Burgos');
list($q,$lat,$lng) = getGeolocation( $default );

// get results
if( $lat && $lng ){
	$url = 'http://api.toprural.com/rest/es/accommodations/filter/gmaps/' . $lat . '/' . $lng;
	$ch = curl_init( $url );
	curl_setopt($ch, CURLOPT_USERPWD, USER_TOPRURAL . ":" . PASS_TOPRURAL); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$xml = simplexml_load_string( curl_exec($ch) );
	
	if( isset( $xml->accommodations->accommodation ) ){
		foreach( $xml->accommodations->accommodation as $item ){
			$total = $item->minCapacity;
			if( $item->maxCapacity ) $total .= ' - ' . $item->maxCapacity;
		
			$items[] = array(
				'img' => $item->mainPicture,
				'title' => $item->name,
				'text' => $item->village . ', ' . $item->province . ' (' . $item->country . ')',
				'url' => 'http://www.toprural.com/x/x_' . $item->id . '_f.html',
				'total' => $total
				);
		}
	}
}

require 'template.php';