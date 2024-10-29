<?php

//entry function
function get_user_profile_form(){

	$form  = '';
		
	if ( is_user_logged_in() ){
	
		$id = get_current_user_id();
		$edit = wp_get_current_user();
		
		$fieldnote  = '<p class="fieldnote">Note: fields marked with (*) are required.</p>';
		
		$photo  = '<div id="user-photo">';
		$photo .= '<span class="food_photo">Photo</span>';
		
		ob_start();
				
		$args = array( 	
						
						'textarea_name' => 'user_photo',
						'wpautop'		=> false,
						'media_buttons'	=> true,
						'quicktags'		=> false,
						'editor_height' => 200,
						'tinymce'		=> array(
												'theme_advanced_buttons1' => '',
												'theme_advanced_buttons2' => '',
												'content_css' => ''
											),
						
					);
		
		wp_editor( htmlspecialchars_decode( stripslashes( get_user_meta( $id, 'user_photo', true ) ) ), 'user_photo', $args );
				
		$photo .= ob_get_clean();
		$photo .= '<div class="clearBoth"></div></div>';
		
		$firstname  = '<div class="field"><label for="firstname">First name <span class="arteris">*</span></label>';
		$firstname .= '<input class="input-text firstname" type="text" name="firstname" value="'. get_user_meta( $id, 'first_name', true ) .'" />';
		$firstname .= '<div class="clearBoth"></div></div>';

		$lastname	= '<div class="field"><label for="lastname">Last name <span class="arteris">*</span></label>';
		$lastname  .= '<input type="text" class="input-text lastname" name="lastname" value="' . get_user_meta( $id, 'last_name', true ) . '" />';
		$lastname  .= '<div class="clearBoth"></div></div>';

		$email	    = '<div class="field"><label for="email">Email <span class="arteris">*</span></label>';
		$email	   .= '<input type="text" class="input-text email" name="email" value="' . get_the_author_meta('user_email', $id) . '" />';
		$email	   .= '<div class="clearBoth"></div></div>';
		
		$password   = '<div id="password">';
		$password  .= '<h4>Change Your Password</h4>';
		$password  .= '<input type="hidden" id="user_login" value="' . $edit->user_login . '" />';
		$password  .= '<label for="password1"><strong>'. 'New Password' . '</strong></label>';
		$password  .= '<div class="password-fields">';
		$password  .= '<input class="pwd" type="password" name="password1" id="password1" size="16" value="" autocomplete="off" /> <span class="description">' . "If you would like to change the password type a new one. Otherwise leave this blank." . '</span>';
		$password  .= '<input class="pwd" type="password" name="password2" id="password2" size="16" value="" autocomplete="off" /> <span class="description">' . "Type your new password again." . '</span>';
		$password  .= '<!--<div id="pass-strength-result">' . 'Strength indicator' . '</div> -->';
		$password  .= '<p class="description indicator-hint">' . 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ' . '</p>';
		$password  .= '</div><div class="clearBoth"></div></div>';

		$submit	    = '<div class="field"><input type="submit" name="update_user_profile" value="Submit" class="input-submit" /></div>';
		
		
		//construct the form
		$form_open = '<form id="user-profile" method="post" action="'. site_url( '/save-user-profile/?uid=' . $id ) .'">';
		$form .= apply_filters( 'user_profile_form_open', $form_open );
		$form .= apply_filters( 'user_profile_field_note', $fieldnote );
		$form .= apply_filters( 'user_profile_photo', $photo );
		$form .= apply_filters( 'user_profile_first_name', $firstname );
		$form .= apply_filters( 'user_profile_last_name', $lastname );
		$form .= apply_filters( 'user_profile_email', $email );
		$form .= apply_filters( 'user_profile_password', $password );
		$form .= apply_filters( 'user_profile_submit', $submit );
		$form .= '</form>';
	
	}else{
	
		$form .= "<div class='nopermission'>You do not have permission to access this page.</div>";
	
	}
	
	return $form;
	
}


/** end */