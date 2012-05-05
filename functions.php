<?php

function getGeolocation($default){

	if( isset( $_GET['q'] ) && $_GET['q'] ){
		$q = strip_tags( $_GET['q'] );
		$url = 'http://maps.google.com/maps/api/geocode/xml?address=' . urlencode( $q ) . '&sensor=false';
		$data = file_get_contents( $url );
		$xml = simplexml_load_string( $data );
		
		$lat = $xml->result[0]->geometry->location->lat;
		$lng = $xml->result[0]->geometry->location->lng;
		
	}else{
		$lat = $default['lat'];
		$lng = $default['lng'];
		$q = $default['q'];
	}

	return array($q,$lat,$lng);
}