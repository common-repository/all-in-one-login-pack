<?php

define('CUSTOM_REGISTRATION_PATH', plugin_dir_path( __FILE__ ));

include_once( CUSTOM_REGISTRATION_PATH . 'custom_registration_helper.php' );
include_once( CUSTOM_REGISTRATION_PATH . 'custom_registration_shortcode.php' );
include_once( CUSTOM_REGISTRATION_PATH . 'do_registration.php' );


//for comfirm email
add_action('init', 'custom_confirm_registration');
function custom_confirm_registration(){
	
	$url = get_login_pack_current_url();
	$url = preg_replace( '/\?.*/', '', $url );
	$last = get_login_pack_last_segment( trailingslashit($url) );
	
	if( $last == "confirm-user" ){
	
		if ( isset( $_GET['uid'] ) && ( $_GET['uid'] > 0 ) ){
			
			$userid = $_GET['uid'];
			$user = get_user_by( 'id', $userid );
						
			//delete & send login info
			$pending = get_user_meta( $userid, 'user_status', true );
			if ( $pending == "pending" ){
				delete_user_meta( $userid, "user_status" );
				custom_registration_send_mail( $user->user_email, $user->first_name, $user->user_login, "your chosen password", $userid );
			
				//call the template to show confirmation message
				show_confirmation_message(); 
			}
			
		}	
		
		exit;
	}

}

/** end */