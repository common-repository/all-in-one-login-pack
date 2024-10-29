<?php
add_shortcode('LOSTPASSWORD', 'wordpress_reset_password_func');
function wordpress_reset_password_func( $atts ) {
	
	//attribute
	extract(shortcode_atts(array(
	
		'title' => 'Lost Password',
		'description' => 'Please fill in your email address below to reset your password.'
		
	), $atts));
	
	//set args
	$args = array();
	$args['title'] = isset( $title ) ? $title : "";
	$args['description'] = isset( $description ) ? $description : "";
	
	//return output	
	$output = get_reset_password_form( $args );
	return $output;

}



/** end */