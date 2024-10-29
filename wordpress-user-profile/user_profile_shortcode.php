<?php

add_shortcode('USERPROFILE', 'wordpress_custom_profile_func');
function wordpress_custom_profile_func( $atts ) {
	$output = get_user_profile_form();
	return $output;
}

/** end */