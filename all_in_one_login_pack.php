<?php
/*
Plugin Name: All-In-One Login Pack
Plugin URI: http://gidd.org/wordpress-plugins/login-pack/
Description: All-In-One Login Pack is a collection of 4 components which help to make login & registration forms work with your theme.
Version: 1.0.0
Author: Vichet Sen
Author URI: http://gidd.org
License: GPLv2 or later
*/


define('LOGIN_PACK_PATH', plugin_dir_path( __FILE__ ));
define('LOGIN_PACK_URL', plugin_dir_url( __FILE__ ));

//add login pack style
add_action('wp_head', 'login_pack_script');
function login_pack_script(){
	wp_enqueue_style( 'login-pack', LOGIN_PACK_URL . 'login_pack.css' );
}


//disable caching pages
add_action('wp_head', 'login_pack_disable_caching');
function login_pack_disable_caching(){

	$meta  = '<meta http-equiv="cache-control" content="max-age=0" />';
	$meta .= '<meta http-equiv="cache-control" content="no-cache" />';
	$meta .= '<meta http-equiv="expires" content="0" />';
	$meta .= '<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />';
	$meta .= '<meta http-equiv="pragma" content="no-cache" />';

	$register_page = get_option('register_page');
	$login_page = get_option('login_page');
	$lost_password_page = get_option('lost_password_page');
	$user_profile_page = get_option('user_profile_page');
		
	if ( is_page( $register_page ) || is_page( $login_page ) || 
	is_page( $lost_password_page ) || is_page( $user_profile_page ) ){
		echo $meta;
	}
	
}


//url functions
//get last segment from url
function get_login_pack_last_segment( $url ) {        
	$path = parse_url( $url, PHP_URL_PATH ); // to get the path from a whole URL
	$pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
	$pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

	if (substr($path, -1) !== '/')
		array_pop($pathTokens);

	return end($pathTokens); // get the last segment
}

//Get the current url
function get_login_pack_strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }
function get_login_pack_current_url(){ 
	
	if(!isset($_SERVER['REQUEST_URI'])){
		$serverrequri = $_SERVER['PHP_SELF'];
	}else{
		$serverrequri = $_SERVER['REQUEST_URI'];
	}
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = get_login_pack_strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
	
}


//login pack options
include_once( LOGIN_PACK_PATH . 'login_pack_options.php' );

//load registration
include_once( LOGIN_PACK_PATH . 'wordpress-custom-registration/wordpress_custom_registration.php' );

//load login
include_once( LOGIN_PACK_PATH . 'wordpress-custom-login/wordpress_custom_login.php' );

//load password reset
include_once( LOGIN_PACK_PATH . 'wordpress-password-reset/wordpress_password_reset.php' );

//load user profile
include_once( LOGIN_PACK_PATH . 'wordpress-user-profile/wordpress_user_profile.php' );


/** end */