<?php

function user_profile_validate_email( $email ){

	$error = "";

	if( $email == "" ){
		$error .= "<p>Email is required.</p>";
	}else{

		if( is_email( $email ) ){
			
			$prev_email = get_the_author_meta( 'user_email', get_current_user_id() );
			if ( $email != $prev_email ):
				if ( email_exists( $email ) ){
					$error .= "Email already exists.";
				}
			endif;
			
		}else{
			$error .= "<p>Email is invalid.</p>";
		}

	}
	
	return $error;
	
}

function user_profile_validate_password( $password1, $password2 ){

	$error = "";
	if ( !empty( $password1 ) ){		
		if ( strlen( $password1 ) < 4 ){
			$error .= "<p>Password must be at least 4 characters.</p>";
		}
		if ( $password1 != $password2 ){
			$error .= '<p>Passwords do not match.</p>';
		}else{
			return 'valid';
		}		
	}
	
	return $error;
}

function show_update_profile_action( $msg = "" ){
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
		<?php 
		
		if ( $msg == "" ){
			$msg = "<p>Your profile is updated successfully.</p>";
		}
		
		echo $msg; ?>
		<a class="profilelink" href="<?php echo get_permalink( get_option('user_profile_page') ); ?>">Go to user profile page</a>
	</div>

</body>
</html>

<?php
}

/** end.php */