<?php

function get_reset_password_form( $args ){

	$email = "";
	$msg = "";
	$form  = "";
	
	
	if ( !is_user_logged_in() ){
	
		//post action
		if ( isset( $_POST['reset-email'] ) ):
		
			$email = $_POST['reset-email'];
			$sent = reset_password_by_email( $email );
			
			if ( $sent == "invalid" ){
			
				$err = '<p>Email is invalid.</p>';
				$err = apply_filters( 'reset_password_invalid', $err );
			
				$msg .= '<div class="error reset-error">';
				$msg .= $err;
				$msg .= '</div>';
			
			}else{
			
				$success  = '<h2>Your password has been reset.</h2>';
				$success .= '<p>Please check your email. After you login, you can change your password at update profile page in admin section.</p>';
				$success  = apply_filters( 'reset_password_success', $success );
			
				$msg .= '<div class="success reset-success">';
				$msg .= $success;
				$msg .= '</div>';
			
			}
		
		endif;
				
		//form
		$form .= $msg;
		$form .= '<div class="reset-pwd">';
		$form .= '<h2>'. $args['title'] .'</h2>';
		$form .= '<p>'. $args['description'] .'</p>';
		$form .= '<form method="post" action="">';
		$form .= '<p><input type="text" class="reset-email" name="reset-email" value="'. $email .'" /></p>';
		$form .= '<p><input type="submit" value="Submit" class="btn-reset" /></p>';
		$form .= '</form>';
		$form .= '</div>';
	
	}else{
	
		//not login
		$form = '<h2 class="registered-title">You are a member of '. get_bloginfo('sitename') .' already.</h2>';
		$form = apply_filters( 'lost_password_not_login', $form );
		
	}
	
	return $form;
}

function reset_password_sending_email( $args = array() ){

	//variables
	$email = isset( $args['email'] ) ? $args['email'] : '';
	$first_name = isset( $args['first_name'] ) ? esc_attr( $args['first_name'] ) : '';
	$user_name = isset( $args['user_name'] ) ? esc_attr( $args['user_name'] ) : '';
	$password = isset( $args['password'] ) ? $args['password'] : '';
	
	//message	
	$message  = sprintf( "Hello %s", $first_name ) . "\r\n\r\n";
	$message .= sprintf( "You have requested to reset your password at: %s", get_site_url() );
	$message .= "\r\n\r\nHere is your login detail: \r\n\r\n";
	$message .= sprintf( "Username: %s", $user_name ) . "\r\n";
	$message .= sprintf( "Password: %s", $password );
	$message .= "\r\n\rAfter you login, you can change your password at update profile page in admin section.";
	$message = apply_filters( 'reset_password_email_message', $message );
	
	//send
	$headers[] = 'From: ' . get_option( 'blogname' ) . ' <'. get_option('admin_email') .'>';
	wp_mail( $email, sprintf(__('Request for password reset')), $message, $headers );

}

function reset_password_by_email( $email ){
	
	$updated = "";	
	if ( is_email( $email ) && email_exists( $email ) ){
		
		$user = get_user_by('email', $email );
		$id = isset( $user->ID ) ? $user->ID : "";
		$first_name = isset( $user->first_name ) ? $user->first_name : "";
		$user_name = isset( $user->user_login ) ? $user->user_login : "";
		
		//generate random password
		$password = wp_generate_password();
		
		//set password
		wp_set_password( $password, $id );
		
		//send email
		$args = array( 'email' => $email, 'first_name' => $first_name, 'user_name' => $user_name, 'password' => $password );
		reset_password_sending_email( $args );		
		$updated = "success";
		
	}else{
		$updated = "invalid";
	}
	
	return $updated;

}


/** end */