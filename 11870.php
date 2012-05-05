<?php

require 'functions.php';
require 'config.php';
require 'lib/magpierss/rss_fetch.inc';

// define variables
$apptitle = 'pin11870';
$placeholder = 'Localidad';
$btn_search = 'Buscar restaurantes';
$credits = 'experimento realizado por <a href="http://miquelcamps.com" target="_blank">Miquel Camps Orteza</a> con la api de <a href="http://www.11870.com/" target="_blank">11870</a>, <a href="https://developers.google.com/maps/?hl=es" target="_blank">google maps</a>, <a href="http://jquery.com" target="_blank">jquery</a> y <a href="http://masonry.desandro.com/index.html" target="_blank">masonry</a>';
$limit = 50;
$items = array();

// geolocation
$default = array('lat' => 40.416691, 'lng' => -3.7003453, 'q' => 'Madrid');
list($q,$lat,$lng) = getGeolocation( $default );

// get results
$lat_min = (float)$lat - 0.0036;
$lng_min = (float)$lng - 0.0036;
$lat_max = (float)$lat + 0.0036;
$lng_max = (float)$lng + 0.0036;

$tags = str_replace(',','&tag=','restaurante,restaurantes');
$url = 'http://11870.com/api/v1/search?appToken=' . TOKEN_11870 . '&authSign=' . AUTH_11870 . '&count=' . $limit . '&tag=' . $tags . '&tagOp=or&bbox=' . $lng_min . ',' . $lat_min . ',' . $lng_max . ',' . $lat_max;
$xml = @fetch_rss( $url );

if( isset( $xml->items ) && $xml->items ){
	foreach( $xml->items as $item ){
		$item = (object) $item;
		$items[] = array(
			'img' => str_replace('ps_','pl_', $item->link_media),
			'title' => utf8_encode( $item->title ),
			'text' => utf8_encode( $item->oos['useraddress'] . ', ' . $item->oos['locality'] . ' (' . $item->oos['country'] . ')' ),
			'url' => $item->link
			);
	}
}

require 'template.php';