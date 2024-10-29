<?php

define('CUSTOM_LOGIN_PATH', plugin_dir_path( __FILE__ ));
define('CUSTOM_LOGIN_URL', plugin_dir_url( __FILE__ ));

include_once( CUSTOM_LOGIN_PATH . 'custom_login_helper.php' );
include_once( CUSTOM_LOGIN_PATH . 'custom_login_shortcode.php' );
include_once( CUSTOM_LOGIN_PATH . 'custom_action.php' );


/** end */