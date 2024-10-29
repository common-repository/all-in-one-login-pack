<?php
//check mail
function custom_registration_check_mail( $user_email ){
		
	$err = "";
	if ( $user_email == '' ) {
		$err .= '<p>Email is required.</p>';
	} elseif ( ! is_email( $user_email ) ) {						
		$err .= '<p>This email is not valid.</p>';
	} elseif ( email_exists( $user_email ) ) {
		$err .= '<p>This email already exists.</p>';
	}
	
	return $err;
}

//custom register compare password
function custom_registration_compare_password( $password, $confirm_password ){

	$err = "";		
	if ($password != $confirm_password )
		$err .= "<p>Passwords do not match.</p>";
	
	return $err;
}


function get_terms_conditions( $page_id ){

	$agree  = get_page( $page_id );
	$output = "";
		
	$output .= '<div id="agreepage">';
	$output .= '<h2 class="agree-page-title">' . $agree->post_title . '</h2>';
	$output .= apply_filters ( 'the_content', $agree->post_content );	
	$output .= '</div>';
	
	//agree form
	$output .= '<div id="agreeform">';
	$output .= '<form method="post" action="">';
	$output .= '<p class="agreecheck">';
	$output .= '<label id="lbl_agree"><input type="checkbox" value="agree" id="chk_agree" name="chkagree" />Agree with the terms and conditions above.</label>';
	$output .= '<small>You must agree with these terms and conditions before you can proceed.</small>';
	$output .= '</p>';
	$output .= '<p class="agreesubmit">';
	$output .= '<input type="submit" name="agreesubmit" value="Agree" />';
	$output .= '</p>';
	$output .= '</form>';
	$output .= '</div>';

	return $output;

}
	
function get_register_form(){

	$output = "";
	
	$username = "";
	if( isset( $_POST['username'] ) && ( $_POST['username'] != "" ) ):
		$username = $_POST['username'];
	endif;
	
	$firstname = "";
	if( isset( $_POST['firstname'] ) && ( $_POST['firstname'] != "" ) ):
		$firstname = $_POST['firstname'];
	endif;
	
	$lastname = "";
	if( isset( $_POST['lastname'] ) && ( $_POST['lastname'] != "" ) ):
		$lastname = $_POST['lastname'];
	endif;
	
	$email = "";
	if( isset( $_POST['email'] ) && ( $_POST['email'] != "" ) ):
		$email = $_POST['email'];
	endif;
	
	
	if ( isset( $_POST['registersubmit'] ) ):
		$output .= do_registration();
	endif;

	$output .= '<div class="registerform">';
	$output .= '<h2>Create a new account</h2>';
	
	$output .= '<p class="fieldnote">Note: Fields marked with (*) are required.</p>';
	
	$output .= '<form class="signupform" method="post" action="">';
	
	$output .= '<p>';
	$output .= '<label for="username">User name <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="text" name="username" id="regusername" value="'. $username .'" />';			
	$output .= '</p>';	
	
	$output .= '<p>';
	$output .= '<label for="password">Password <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="password" name="password" id="regpassword" value="" />';
	$output .= '</p>';	
		
	$output .= '<p>';
	$output .= '<label for="confirm-password">Confirm password <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="password" name="confirm-password" id="confirm-password" />';
	$output .= '</p>';
	
	$output .= '<p>';
	$output .= '<label for="firstname">First name <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="text" name="firstname" id="firstname" value="'. $firstname .'" />';
	$output .= '</p>';	
		
	$output .= '<p>';
	$output .= '<label for="lastname">Last name <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="text" name="lastname" id="lastname" value="'. $lastname .'" />';
	$output .= '</p>';	
	
	$output .= '<p>';
	$output .= '<label for="email">Email <span class="arteris">*</span></label>';
	$output .= '<input class="signupfield" type="text" name="email" id="email" value="'. $email .'" />';
	$output .= '</p>';	
		
	$output .= '<p>';
	$output .= '<input type="submit" name="registersubmit" id="registersubmit" value="Submit" />';
	$output .= '</p>';
	
	$output .= '</form>';	
	$output .= '</div>';
	
	return $output;
		
}

function register_success_message(){

	$output = "";

	$output .= '<div class="regsuccess">';
	$output .= '<h2>You have been registered successfully.</h2>';
	$output .= '<h4>Please check your email to confirm your account.</h4>';
	$output .= '</div>';
	
	$output = apply_filters('register_success_message', $output);	
	return $output;

}

function custom_registration_send_mail( $user_email, $first_name, $user_name, $password, $user_id ){

	$subject = "";
	$message = "";
	$status = get_user_meta( $user_id, 'user_status', true );
	

	if ( $status == "pending" ){
	
		$subject  = sprintf(__("Please confirm your account"));
		$message .= sprintf(__("Hello, \r\n\r\n"));
		$message .= sprintf(__("You have registered at %s. "), get_option( 'blogname' ));
		$message .= sprintf(__("Please click the link below to confirm your account:\r\n\r\n"));
		$message .= sprintf(__('%s'), site_url('/confirm-user?uid=' . $user_id));
		
		$messsage = apply_filters( 'confirm_email_message', $message );
		$subject  = apply_filters( 'confirm_email_subject', $subject );
		
	}else{
		
		$subject  = sprintf(__('Your username and password'));	
		$message .= sprintf( "Welcome %s", $first_name ) . "\r\n\r\n";
		$message .= sprintf( "Thank you for registering at: %s", get_site_url() );
		$message .= "\r\n\r\nHere is your login detail: \r\n\r\n";
		$message .= sprintf( "Username: %s", $user_name ) . "\r\n";
		$message .= sprintf( "Password: %s", $password );

		$messsage = apply_filters( 'register_email_message', $message );
		$subject  = apply_filters( 'register_email_subject', $subject );
		
	}
	
	$headers[] = 'From: ' . get_option( 'blogname' ) . ' <'. get_option('admin_email') .'>';
	$headers = apply_filters( 'custom_registration_email_header', $headers  );
	wp_mail( $user_email, $subject, $message, $headers );

}

function request_confirm_email_form( $args = array() ){
	
	$msg = "";	
	if ( isset( $_POST['confirm_email'] ) ){
	
		$email = isset( $_POST['user_email'] ) ? trim( $_POST['user_email'] ) : "";
		if ( is_email( $email ) ){		
			//send the confirm email
			$msg = request_confirm_email( $email );
		}else{		
			$msg = '<div class="confirm_error">Invalid email address.</div>';
		}
	
	}
	
	$form  = $msg;
	$form .= '<form class="confirm-email-form" method="post" action="">';
	$form .= '<p>'. $args['fill_in_message'] .'</p>';
	$form .= '<p><input type="text" name="user_email" class="user_email" value="" /></p>';
	$form .= '<p><input type="submit" name="confirm_email" class="confirm_email" value="Send" /></p>';
	$form .= '</form>';
	
	return $form;

}

function request_confirm_email( $email ){

	$subject = "";
	$message = "";
	$user = get_user_by( 'email', $email );
	$user_id = isset( $user->ID ) ? $user->ID : "";
	$status = get_user_meta( $user_id, 'user_status', true );
	$info = "";
	
	if ( $status == "pending" ){	
		$subject  = sprintf(__("Please confirm your account"));
		$message .= sprintf(__("Hello, \r\n\r\n"));
		$message .= sprintf(__("You have registered at %s. "), get_option( 'blogname' ));
		$message .= sprintf(__("Please click the link below to confirm your account:\r\n\r\n"));
		$message .= sprintf(__('%s'), site_url('/confirm-user?uid=' . $user_id));
		
		$messsage = apply_filters( 'confirm_email_message', $message );
		$subject  = apply_filters( 'confirm_email_subject', $subject );
		
		$headers[] = 'From: ' . get_option( 'blogname' ) . ' <'. get_option('admin_email') .'>';
		$headers = apply_filters( 'custom_registration_email_header', $headers  );
		wp_mail( $email, $subject, $message, $headers );
	
		$info = '<div class="confirm_success">A confirmation email is sent, please check your email.</div>';
		$info = apply_filters( 'confirmation_email_success_message', $info );
		
	}else{
	
		$info = '<div class="confirm_error>We cannot find your email address or it is already confirmed.</div>';
		$info = apply_filters( 'confirmation_email_error_message', $info );
		
	}
	
	return $info;

}


// the entry function
function do_custom_registration( $showterm ){

	$output = "";
	$pageid = get_option('term_page_id');
	
	if ( get_option('users_can_register') ):
	
		if ( !is_user_logged_in() ):
			
			$error = '<p>You must agree with terms and conditions before you can register.</p>';
			$error = apply_filters( 'term_condition_error_message', $error );
			
			if ( $showterm ):

				$chkagree = isset( $_POST['chkagree'] ) ? $_POST['chkagree'] : "";				
				if ( ( $chkagree == 'agree' ) || ( isset( $_POST['registersubmit'] ) ) ){					
					$output .= get_register_form(); 
				}else{
					$output .= '<div class="agree-error">'. $error .'</div>';
					$output .= get_terms_conditions( $pageid ); 
				}
			
			else:
				$output .= get_register_form();
			endif;
		
		else:
			$output .= '<h2 class="registered-title">You are a member of '. get_bloginfo('sitename') .' already.</h2>';
			$output  = apply_filters( 'already_register_message', $output );
		endif;
	
	else:
		$output .= '<h2 class="noreg">You must enable user registration from WordPress admin in General Settings.</h2>';
		$output  = apply_filters( 'enable_registration_message', $output );
	endif;
	
	return $output;

}

/** end */