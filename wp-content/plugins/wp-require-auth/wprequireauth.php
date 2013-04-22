<?php
/*
Plugin Name: WP Require Auth
Version: 1.0.2
Plugin URI: http://johnny.chadda.se/projects/wp-require-auth/
Description: This plugin makes it mandatory to be logged in before viewing any content.
Author: Johnny Chadda
Author URI: http://johnny.chadda.se/
*/

class wprequireauth
{
	/*
	Make sure that the user is logged in if the page is not one of the following:
		* wp-login.php
		* wp-register.php
	*/
	
	function wprequireauth_check_auth()
	{
                //記錄現在的錯誤網址
                //error_log("wprequireauth_check_auth() " . $_SERVER['PHP_SELF']);
                //DebugEcho("wprequireauth_check_auth() " . $_SERVER['PHP_SELF']);
		if ((strpos($_SERVER["PHP_SELF"], "wp-login.php") === false) 
			&& (strpos($_SERVER['PHP_SELF'], 'wp-register.php') === false)
			&& (strpos($_SERVER['PHP_SELF'], 'async-upload.php') === false)
                        && (strpos($_SERVER['PHP_SELF'], 'wp-cron.php') === false)
                        && (strpos($_SERVER['PHP_SELF'], 'get_mail.php') === false))    //為了讓Postie能夠自動啟動
		{
			if (!is_user_logged_in())
			{
				auth_redirect();
			}
		}
	}
}

// Add the filter to Wordpress
add_filter('init', array('wprequireauth','wprequireauth_check_auth'));
?>