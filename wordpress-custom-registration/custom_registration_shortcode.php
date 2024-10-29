<?php
add_shortcode('REGISTER', 'wordpress_custom_registration_func');
function wordpress_custom_registration_func( $atts ) {
	
	//attribute
	extract(shortcode_atts(array(
		'showterm' => false,
	), $atts));
	
	//return output
	$showterm = ( $showterm === 'true' ) ? true : false;
	$output = do_custom_registration( $showterm );
	return $output;
}


add_shortcode('RECONFIRM', 'wordpress_send_confirm_email_func');
function wordpress_send_confirm_email_func( $atts ) {
	
	//attribute
	extract(shortcode_atts(array(
		'fill_in_message' => 'If you do not receive a confirmation email, please fill in your email address below to send again.',
	), $atts));
	
	//return output
	$args = array();
	$args['fill_in_message'] = $fill_in_message;
	$output = request_confirm_email_form( $args );
	return $output;
}



/** end */