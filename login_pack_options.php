<?php

add_action('admin_menu', 'login_pack_option_page');
function login_pack_option_page(){
	add_options_page( 'wordpress_login_pack', 'Login Pack', 'manage_options', 
	'wordpress-login-pack', 'login_pack_options' );
}

function login_pack_options(){

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	//save form data
	if ( isset( $_POST['save_login_pack'] ) ){
		
		$register_page = isset( $_POST['register_page'] ) ? intval( trim( $_POST['register_page'] ) ) : "" ;
		$login_page = isset( $_POST['login_page'] ) ? intval( trim( $_POST['login_page'] ) ) : "" ;
		$lost_password_page = isset( $_POST['lost_password_page'] ) ? intval( trim( $_POST['lost_password_page'] ) ) : "" ;
		$user_profile_page = isset( $_POST['user_profile_page'] ) ? intval( trim( $_POST['user_profile_page'] ) ) : "" ;
		$term_condition_page = isset( $_POST['term_condition_page'] ) ? intval( trim( $_POST['term_condition_page'] ) ) : "" ;
	
		update_option( 'register_page', $register_page );
		update_option( 'login_page', $login_page );
		update_option( 'lost_password_page', $lost_password_page );
		update_option( 'user_profile_page', $user_profile_page );
		update_option( 'term_page_id', $term_condition_page );
		
		echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
		<p><strong>Settings saved.</strong></p></div>';
	
	}
	
	

	echo '<div class="wrap wrap-login-pack">';
?>
	<h2>Login Pack Settings</h2>
	<br />
	<form method="post" id="login-pack-form">
	
		<table>
			<tr>
				<td><label for="register_page">Registration Page ID</label></td>
				<td><input type="text" name="register_page" value="<?php echo get_option('register_page'); ?>" /></td>
			</tr>
			<tr>
				<td><label for="login_page">Login Page ID</label></td>
				<td><input type="text" name="login_page" value="<?php echo get_option('login_page'); ?>" /></td>
			</tr>
			<tr>
				<td><label for="lost_password_page">Lost Pasword Page ID</label></td>
				<td><input type="text" name="lost_password_page" value="<?php echo get_option('lost_password_page'); ?>" /></td>
			</tr>
			<tr>
				<td><label for="user_profile_page">User Profile Page ID</label></td>
				<td><input type="text" name="user_profile_page" value="<?php echo get_option('user_profile_page'); ?>" /></td>
			</tr>
			<tr>
				<td><label for="term_condition_page">Terms & Conditions Page ID</label></td>
				<td><input type="text" name="term_condition_page" value="<?php echo get_option('term_page_id'); ?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<br />
					<input type="submit" name="save_login_pack" value="Submit" class="button button-primary" />
				</td>
			</tr>
			
						
		</table>	
	
	</form>
<?php
	echo '</div>';

}




/** end **/