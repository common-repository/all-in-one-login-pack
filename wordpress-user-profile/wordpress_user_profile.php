<?php

define('USER_PROFILE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

include_once( USER_PROFILE_PATH . 'user_profile_helper.php' );
include_once( USER_PROFILE_PATH . 'do_user_profile.php' );
include_once( USER_PROFILE_PATH . 'user_profile_shortcode.php' );

add_action('init', 'save_current_user_profile');
function save_current_user_profile(){

	$url = get_login_pack_current_url();
	$url = preg_replace( '/\?.*/', '', $url );
	$last = get_login_pack_last_segment( trailingslashit($url) );
	
	if( $last == "save-user-profile" ){
	
		//error variable
		$error = "";
		
		if ( isset( $_GET['uid'] ) && ( $_GET['uid'] > 0 ) ){
			
			//update user profile here
			$userid = $_GET['uid'];
						
			$firstname	= isset( $_POST['firstname'] ) ? trim( esc_html ( $_POST['firstname'] ) ) : "";
			$lastname 	= isset( $_POST['lastname'] ) ? trim( esc_html ( $_POST['lastname'] ) ) : "";
			$email 		= isset( $_POST['email'] ) ? trim( esc_html ( $_POST['email'] ) ) : "";
			$photo 		= isset( $_POST['user_photo'] ) ? esc_html( $_POST['user_photo'] ): "";
			
			//this can cause header already sent error
			//echo htmlspecialchars_decode ( stripslashes( $photo ) );
			
			$password1 = isset( $_POST['password1'] ) ? $_POST['password1'] : '';
			$password2 = isset( $_POST['password2'] ) ? $_POST['password2'] : '';

			$data = array();
			$data['ID'] = $userid;
			$data['user_email'] = $email;
			
			$check_pwd = user_profile_validate_password( $password1, $password2 );
			if ( $check_pwd == "valid" ){
				$data['user_pass'] = $password1;
			}else{
				$error .= $check_pwd;
			}

			if( $firstname == "" ){
				$error .= "<p>First name is required.</p>";
			}

			if( $lastname == "" ){
				$error .= "<p>Last name is required.</p>";
			}

			//validate primary email
			$error .= user_profile_validate_email( $email );

			//if no error, update
			if ( $error == "" ){
				wp_update_user( $data );
				update_user_meta( $userid, 'user_photo', $photo );
				update_user_meta( $userid, 'first_name', $firstname );
				update_user_meta( $userid, 'last_name', $lastname );
			}else{		
				$error = '<div class="error profile-error">'. $error .'</div>';
			}
						
			
		}

		//put custom page template
		show_update_profile_action( $error );		
		exit;
			
	}


}




add_action('wp_head', 'wordpress_custom_profile_script');
function wordpress_custom_profile_script(){

	$user_profile_page = get_option('user_profile_page');
	if ( is_page( $user_profile_page ) ){
?>	
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.input-submit').mousedown( function(){
		tinyMCE.triggerSave();
    }); 	
});
</script>
<?php
	}
}

/** end */