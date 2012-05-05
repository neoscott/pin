<?php

// define variables
$apptitle = 'pintunes';
$placeholder = 'Artista o Canción';
$btn_search = 'Buscar canciones';
$credits = '<script src="js/player.js"></script>experimento realizado por <a href="http://miquelcamps.com" target="_blank">Miquel Camps Orteza</a> con la api de <a href="http://www.apple.com/itunes/" target="_blank">itunes</a>, <a href="http://www.youtube.com" target="_blank">youtube</a>, <a href="http://jquery.com" target="_blank">jquery</a> y <a href="http://masonry.desandro.com/index.html" target="_blank">masonry</a><div id="secret" style="width:1px;height:1px;overflow:hidden"></div>';
$items = array();
$limit = 25;

// search?
if( isset( $_GET['q'] ) && $_GET['q'] ){

	$q = strip_tags( $_GET['q'] );
	$url = 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?media=music&term=' . urlencode( $q );
	$json = json_decode( file_get_contents( $url ) );
	
	if( isset( $json->results[0] ) ){
		foreach( $json->results as $item ){
		
			$items[] = array(
				'img' => str_replace('100x100','200x200', $item->artworkUrl100),
				'title' => $item->trackName . ' - ' . $item->artistName,
				'text' => $item->primaryGenreName,
				'url' => $item->trackViewUrl
				);
		}
	}

// homepage? top songs itunes
}else{

	$url = 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/topsongs/limit=' . $limit . '/xml';
	$xml = simplexml_load_file( $url );
	
	if( isset( $xml->entry[0] ) ){
		foreach( $xml->entry as $item ){
		
			preg_match_all( '/src="(.+?)"/', $item->content, $matches );
			$info = explode(' - ', $item->title);
		
			$items[] = array(
				'img' => $matches[1][0],
				'title' => $info[0] . ' - ' . $info[1],
				'text' => (string)$item->category->attributes()->term,
				'url' => (string) $item->id
				);
		}
	}
}

require 'template.php';