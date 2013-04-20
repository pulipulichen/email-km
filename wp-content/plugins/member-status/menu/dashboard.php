<?php
$settings_group = 'webweb-member-status-group';
?>
<div class="wrap">
    <h2><?php echo __('Dashboard', 'webweb_member_status') ?></h2>   
    
	<p>Copy and paste one or the other text into blog posts or pages where you want the availability status to appear.</p>
	
	<p><strong>%%STATUS-AVAILABLE%%</strong> - Will display available status.</p>
	<p><strong>%%STATUS-UNAVAILABLE%%</strong> - Will display unavailable status.</p>
</div>
    
<div class="wrap">
	<h2>Settings</h2>

	<p>If you want to change the default text please enter the info below otherwise keep the fields blank</p>
	
	<form method="post" action="<?php echo get_settings('siteurl')?>/wp-admin/options.php">
		<?php settings_fields($settings_group); ?>
		
		<table class="form-table">			 
			<tr valign="top">
				<th scope="row">Available Status Text</th>
				<td><input type="text" name="status_available_text" value="<?php echo get_option('status_available_text'); ?>" />  (default: Available)</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Unvailable Status Text</th>
				<td><input type="text" name="status_unavailable_text" value="<?php echo get_option('status_unavailable_text'); ?>" /> (default: Unavailable)</td>
			</tr>
		</table>
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
</div>

<div class="wrap">
	<h2>Support</h2>

	<p>Please send questions, bug reports, feature requests to: <a href="mailto:help@WebWeb.CA?subject=member status">help@WebWeb.CA</a></p>
	<p>Plugin's home page: <a href="http://webweb.ca/site/products/member-status/" target="_blank">http://webweb.ca/site/products/member-status/</a></p>
		
</div>