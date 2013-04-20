<?php
/*
Plugin Name: Member Status
Plugin URI: http://webweb.ca/site/products/member-status/
Description: Member Status lets you insert a code that will show if the person/profile is available or not. Visit <a href="http://webweb.ca/site/products/member-status/" target="_blank">http://webweb.ca/site/products/member-status/</a> for more information.
Version: 1.0.0
Author: Svetoslav Marinov (Slavi) | http://webweb.ca
Author URI: http://WebWeb.ca
License: GPL v2
*/

/*
Copyright 2011-2020 Svetoslav Marinov (slavi@slavi.biz)

This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

define('WEBWEB_WP_MEMBER_STATUS_VERSION', '1.0.0');
define('WEBWEB_WP_MEMBER_STATUS_BASE_DIR', dirname(__FILE__)); // e.g. // htdocs/wordpress/wp-content/plugins/wp-command-center/
define('WEBWEB_WP_MEMBER_STATUS_DIR_NAME', basename(WEBWEB_WP_MEMBER_STATUS_BASE_DIR)); // e.g. wp-command-center

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

$webweb_ms_obj = new WebWeb_MemberStatus();
add_action('init', array($webweb_ms_obj, 'init'));

class WebWeb_MemberStatus {    
    function __construct() {
        global $wpdb;

        add_action('plugins_loaded', array($this,'init'), 1);                		
		$this->pluginPath = get_settings('siteurl') . '/wp-content/plugins/' . WEBWEB_WP_MEMBER_STATUS_DIR_NAME . '/';
    }
        
    function init() { 
        global $wpdb;
        
        if(!is_admin()) {            
			add_action('wp_head', array(&$this, 'header'));
			add_filter('the_content', array(&$this, 'parse_content'));
        } else {		
			// Administration menus
			add_action('admin_menu', array($this, 'administration_menu'));			
			add_action('admin_init', array($this, 'register_mysettings'));
		}
    }

	public $settings_group = 'webweb-member-status-group';
	
	public function register_mysettings() {
      register_setting($this->settings_group, 'status_available_text');
      register_setting($this->settings_group, 'status_unavailable_text');
    }
	
	/**
	* callback
	* Is called for each page/post content.
	* 
	* @param string $content post/page content
	*/
	public function parse_content($content) {
		$available = get_option('status_available_text');
		$available = empty($available) ? 'Available' : $available;
		
		$unavailable = get_option('status_unavailable_text');
		$unavailable = empty($unavailable) ? 'Unavailable' : $unavailable;
		
		if ((strpos($content, '%%STATUS-AVAILABLE%%') !== false) || (strpos($content, '%%STATUS-UNAVAILABLE%%') !== false)) {
			
			$content = str_replace('%%STATUS-AVAILABLE%%', '<div class="member_status member_status_available">' . $available . '</div>', $content);
			$content = str_replace('%%STATUS-UNAVAILABLE%%', '<div class="member_status member_status_unavailable">' 
				. $unavailable . '</div>', $content);
		}
		
		return $content;
	}
	  
    public function administration_menu() {     
        $main_page = '/menu/dashboard.php';
        add_menu_page(__('Member Status','webweb_member_status'), __('Member Status','webweb_member_status'), 'manage_options', 
            WEBWEB_WP_MEMBER_STATUS_DIR_NAME . '/menu/dashboard.php', null, null);                
    }
      
	/**
	* header
	* adds plugin css and js files to page header
	* 
	* @param 
	* @return 
	*/
	public function header() {
		if (!is_feed()) {
			include_once(WEBWEB_WP_MEMBER_STATUS_BASE_DIR . '/member-status-meta-inc.php');		
		}
	}
}