<?php
/*
Plugin Name: CLEditor for WordPress
Plugin URI:
Description: <a href="http://premiumsoftware.net/cleditor/index.html" target="_blank">CLEditor</a> is an open-source jQuery plugin which provides a lightweight, full-featured, cross-browser, extensible, WYSIWYG HTML-editor. This plugin adds CLEditor to WordPress comments.
Version: 1.5
Author: Azim Hikmatov
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function cleditor_enqueue () {
	wp_enqueue_style( 'cleditor-style', plugins_url('/jquery.cleditor.css', __FILE__) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'cleditor-script', plugins_url('/jquery.cleditor.js', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'cleditor_enqueue' );
?>
<?php
function add_cleditor() { ?>
<!-- CLEditor starts -->
	<script>
	<!--
	jQuery(document).ready(function() {
		jQuery("#comment, #new-topic-post textarea, #new-post textarea, #whats-new-textarea textarea, #post-topic-reply textarea").cleditor();
	});
	//-->
	</script>
<!-- CLEditor ends -->
<?php }
add_action( 'wp_head', 'add_cleditor' );
?>