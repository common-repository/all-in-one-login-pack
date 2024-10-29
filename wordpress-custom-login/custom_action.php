<?php

//change logout url to homepage
add_filter('logout_url', 'custom_logout_url', 0, 2);
function custom_logout_url( $logout_url, $redirect ){
	$redirect = home_url();
	$args = array( 'action' => 'logout' );
	if ( !empty( $redirect ) ) {
		$args['redirect_to'] = urlencode( $redirect );
	}
	
	$logout_url = add_query_arg($args, site_url('wp-login.php', 'login'));
	$logout_url = wp_nonce_url( $logout_url, 'log-out' );	
	return $logout_url;
}

/** change login url to a custom one **/
add_action('init', 'add_ob_start');
function add_ob_start(){
	if ( is_login_page() ):
		ob_start();
	endif;
}

add_action('wp_footer', 'flush_ob_end');
function flush_ob_end(){
	if ( is_login_page() ):
		ob_end_flush();
	endif;
}

add_action('login_url', 'custom_login_url');
function custom_login_url(){
	$login_page = get_option('login_page');
	$site_url = ( $login_page == "/" ) ? home_url() : get_permalink( $login_page ) . '?err=invalid';
	return $site_url;
}

add_action('login_head', 'custom_login_redirect');
function custom_login_redirect(){
	if ( !is_user_logged_in() ){
		$login_page = get_option('login_page');
		$site_url = ( $login_page == "/" ) ? home_url() : get_permalink( $login_page ) . '?err=invalid';
		wp_redirect( $site_url );
		exit;
	}
}

add_filter( 'login_form_middle', 'custom_login_form_middle' );
function custom_login_form_middle( $pwd ){
	$lost_password = get_option('lost_password_page');
	$pwd .= '<a class="lost-password" href="'. get_permalink( $lost_password ) .'">Forget Your Password?</a>';
	return $pwd;
}


/** end */