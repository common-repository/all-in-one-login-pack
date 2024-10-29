<?php

function do_registration(){

	//get form data
	$user_name = esc_attr ( trim( $_POST['username'] ) );
	$password = esc_attr ( trim( $_POST['password'] ) );
	$confirm_password = esc_attr ( trim( $_POST['confirm-password'] ) );			
	$user_email = esc_attr ( trim( $_POST['email'] ) );
	$first_name = esc_attr ( trim( $_POST['firstname'] ) );
	$last_name = esc_attr ( trim( $_POST['lastname'] ) );

	$user_id = username_exists( $user_name );
	if ( !$user_id ) {

		$reg  = custom_registration_check_mail( $user_email );
			
		if ( $password == "" ){
			$reg .= "<p>Password is required.</p>";
		}
		
		if ( strlen( $password ) < 4 ){
			$reg .= "<p>Password must be at least 4 characters.</p>";
		}

		$reg .= custom_registration_compare_password( $password, $confirm_password );	
		
		
		if ( $first_name == "" ){
			$reg .= "<p>First name is required.</p>";
		}
		
		if ( $last_name == "" ){
			$reg .= "<p>Last name is required.</p>";
		}
		
				
		// no error, create user
		if ( $reg == "" ){
			$user_id = wp_create_user( "$user_name", "$password", "$user_email" );				
			wp_new_user_notification( $user_id  );	
			$reg = register_success_message();
		}else{		
			//set wrapper for error messages
			$reg = '<div class="regerror">' . $reg . '</div>';		
		}
		
		// if user is created
		if ( is_int( $user_id ) ){	
			
			update_user_meta( $user_id, 'first_name', "$first_name" );
			update_user_meta( $user_id, 'last_name', "$last_name" );
			update_user_meta( $user_id, 'user_status', "pending" );
			
			//send mail
			custom_registration_send_mail( $user_email, $first_name, $user_name, $password, $user_id );
			
		}	
		
		return $reg;
		
	}else{
		$msg = '<div class="regerror"><p>This user name already exists.</p></div>';
		return $msg;
	}
}


add_filter('wp_authenticate_user', 'custom_authenticate_login' );
function custom_authenticate_login( $userdata ){

	$status = get_user_meta( $userdata->ID, 'user_status', true );
	
	//not allow login if status is pending.
	if ( $status == "pending" ){
		$userdata->user_pass = "";
	}
		
	return $userdata;

}

function show_confirmation_message(){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Confirm email</title>
 <style>
	body{ background: #efefef; font-family: arial, helvetica, sans-serif; }
	h2{ font-size: 16px; }
	.msg-wrap{ background: #f7f7f7; padding: 20px; text-align: center; border: 1px solid #ccc; width: 500px; margin: 0 auto; }
 </style>
</head>
 
<body class="custom">
	<br />
	<br />
	<div class="msg-wrap">
		<h2>Thank you. Your account has been activated.</h2>
		<a class="homelink" href="<?php echo home_url(); ?>">Go to home page</a>
	</div>

</body>
</html>

<?php
}


/** end */