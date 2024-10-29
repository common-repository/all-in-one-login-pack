<?php

add_shortcode('LOGIN', 'wordpress_custom_login_func');
function wordpress_custom_login_func( $atts ) {
	
	//attribute
	extract(shortcode_atts(array(
		'redirect' => "/",
		'form_id' => "loginform",
		'label_username' => "Username",
		'label_password' => "Password",
		'label_remember' => "Remember Me",
		'label_log_in' => "Log in",
		'id_username' => "user_login",
		'id_password' => "user_pass",
		'id_remember' => "rememberme",
		'id_submit' => "wp-submit",
		'remember' => false,
		'value_username' => "",
		'value_remember' => false,
		
		
	), $atts));
	
	//set args
	$redirect = ( $redirect == "/" ) ? home_url() : site_url( '/'. $redirect . '/' );
	$args['redirect'] = $redirect;
	$args['form_id'] = "$form_id";
	$args['label_username'] = __( "$label_username" );
	$args['label_password'] = __( "$label_password" );
	$args['label_remember'] = __( "$label_remember" );
	$args['label_log_in'] = __( "$label_log_in" );
	$args['id_username'] = "$id_username";
	$args['id_password'] = "$id_password";
	$args['id_remember'] = "$id_remember";
	$args['id_submit'] = "$id_submit";
	$args['remember'] = $remember;
	$args['value_username'] = "$value_username";
	$args['value_remember'] = $value_remember;
	
	//return output
	$output = custom_login_form( $args );
	return $output;
}



/** end */