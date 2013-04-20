<?php
/* Included in the header.  */
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type='text/javascript' src='<?php echo $this->pluginPath ?>fcarriedo-jquery-blink-c0b98c2/lib/jquery.blink.js'></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->pluginPath ?>css/style.css" />
<script type='text/javascript'>
	$(document).ready(function() {
		// 'title' exhibits is a little bit more complex behavior.
		$('.member_status').blink({
			onMaxBlinks: function() {
				
			},
			onBlink: function(i) {
			}
		});
	});
</script>