<?php

//is login
function is_login_page() {
   return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


//entry function
function custom_login_form( $args ){
	
	$form = "";		
	if ( !is_user_logged_in() ):	
		$args['echo'] = false;			
		$form .= '<div class="login-wrap">';
		
		//login error
		if ( isset( $_GET['err'] ) && $_GET['err'] == "invalid" ){
			$form .= '<div class="error login-error">';
			$form .= '<p>Your login information is invalid. Please try again.</p>';
			$form .= '</div>';
		}
					
		$form .= wp_login_form( $args );
		$form .= "</div>"; 

	else:
		$form = '<div class="signed-in">You signed in already.</div>';
	endif;
	
	return $form;
}



/** end */