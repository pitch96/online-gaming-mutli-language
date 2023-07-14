<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(file_exists('static') && !defined('NO_STATIC')){
	if(file_exists('index_static.php')){
		require_once('index_static.php');
		exit();
	}
}

require( 'config.php' );
require( 'init.php' );
require( 'classes/Collection.php' );
require( 'includes/plugin.php' );

$_wgts = get_option('widgets');
$_wgts = ($_wgts) ? json_decode($_wgts, true) : [];
$stored_widgets = $_wgts;

$url_params = [];
$cur_url = $_SERVER['REQUEST_URI'];

if( PRETTY_URL ){
	$url_params = isset($_GET['viewpage']) ? explode("/", $_GET['viewpage']) : [];
	
	$_GET['viewpage'] = isset( $url_params[0] ) ? $url_params[0] : 'homepage';
	if(isset( $url_params[1] )){
		$_GET['slug'] = $url_params[1];
	}

	if(end($url_params) == ''){
		array_pop($url_params);
	}
	if(count($url_params)){
		if(substr($cur_url, -1) != '/' && !strpos($cur_url, '?')){
			// Add trailing slash, then redirect
			header('Location: '.$cur_url.'/', true, 301);
			exit();
		}
	}
}

load_language('index');
load_plugins('index');

$page_name = isset( $_GET['viewpage'] ) ? $_GET['viewpage'] : 'homepage';

$custom_path = get_custom_path($page_name);

if($custom_path == 'search'){
	if(PRETTY_URL){
		// Redirect to pretty url for search
		if(isset($_GET['slug']) && strpos($cur_url, 'index.php?viewpage=search')){
			header('Location: '.get_permalink('search', $_GET['slug']), true, 301);
			exit();
		}
	}
}

require_once( TEMPLATE_PATH . '/functions.php' );

if(file_exists( 'includes/page-' . $custom_path . '.php' )){
	require( 'includes/page-' . $custom_path . '.php' );
} else {
	if(file_exists( TEMPLATE_PATH.'/page-' . $page_name . '.php' )){
		require( TEMPLATE_PATH.'/page-' . $page_name . '.php' );
	} else {
		require( 'includes/page-404.php' );
	}
}

?>