<?php
/*
Plugin Name: CLEditor for WordPress
Plugin URI:
Description: <a href="http://premiumsoftware.net/cleditor/index.html" target="_blank">CLEditor</a> is an open-source jQuery plugin which provides a lightweight, full-featured, cross-browser, extensible, WYSIWYG HTML-editor. This plugin adds CLEditor to WordPress comments.
Version: 1.4
Author: Azim Hikmatov
Author URI:
*/

function add_cleditor () {
?>
<!-- CLEditor load starts -->
<link rel="stylesheet" href="<?php echo plugins_url('jquery.cleditor.css', __FILE__); ?>" />
<script src="<?php echo plugins_url('jquery-1.7.1.min.js', __FILE__); ?>"></script>
<script src="<?php echo plugins_url('jquery.cleditor.js', __FILE__); ?>"></script>
<script>
$(document).ready(function() {
	$("#comment, #new-topic-post textarea, #new-post textarea, #whats-new-textarea textarea, #post-topic-reply textarea").cleditor();
});
</script>
<!-- CLEditor load ends -->
<?php }
add_action('wp_head', 'add_cleditor');
?>