<?php

//support moving wp-config.php as described here http://codex.wordpress.org/Hardening_WordPress#Securing_wp-config.php
$wp_config_path = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($wp_config_path . DIRECTORY_SEPARATOR . "wp-config.php")) {
    include_once ($wp_config_path . DIRECTORY_SEPARATOR . "wp-config.php");
} else {
    include_once (dirname($wp_config_path)) . DIRECTORY_SEPARATOR . "wp-config.php";
}

require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mimedecode.php');
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'postie-functions.php');
if (!function_exists('file_get_html')) {
    require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'simple_html_dom.php');
}

EchoInfo("Starting mail fetch");
EchoInfo("Time: " . date('Y-m-d H:i:s', time()) . " GMT");
include('Revision');
$wp_content_path = dirname(dirname(dirname(__FILE__)));
DebugEcho("wp_content_path: $wp_content_path");
if (file_exists($wp_content_path . DIRECTORY_SEPARATOR . "filterPostie.php")) {
    DebugEcho("found filterPostie.php in wp-content");
    include_once ($wp_content_path . DIRECTORY_SEPARATOR . "filterPostie.php");
}

$test_email = null;
$config = config_Read();
extract($config);
if (!isset($maxemails)) {
    $maxemails = 0;
}

$emails = FetchMail($mail_server, $mail_server_port, $mail_userid, $mail_password, $input_protocol, $time_offset, $test_email, $delete_mail_after_processing, $maxemails, $email_tls);
$message = 'Done.';

EchoInfo(sprintf(__("There are %d messages to process", "postie"), count($emails)));

if (function_exists('memory_get_usage')) {
    DebugEcho(__("memory at start of e-mail processing:") . memory_get_usage());
}

DebugEcho("Error log: " . ini_get('error_log'));
DebugDump($config);

$has_email = false;
//loop through messages
foreach ($emails as $email) {
    DebugEcho("------------------------------------");
    //sanity check to see if there is any info in the message
    if ($email == NULL) {
        $message = __('Dang, message is empty!', 'postie');
        EchoInfo($message);
        continue;
    } else if ($email == 'already read') {
        $message = __("There does not seem to be any new mail.", 'postie');
        EchoInfo($message);
        continue;
    }

    $mimeDecodedEmail = DecodeMIMEMail($email, true);

    DebugEmailOutput($email, $mimeDecodedEmail);

    //Check poster to see if a valid person
    $poster = ValidatePoster($mimeDecodedEmail, $config);
    if (!empty($poster)) {
        PostEmail($poster, $mimeDecodedEmail, $config);
    } else {
        EchoInfo("Ignoring email - not authorized.");
    }
    flush();
    $has_email = true;
}

if (function_exists('memory_get_usage'))
{
    DebugEcho("memory at end of e-mail processing:" . memory_get_usage());
	if (isset($_GET["reload"])) {
            if ($has_email) {
                ?>
		<a name="end" id="end" />
<script type="text/javascript" src="/js/jquery-1.2.6.js"></script>
<script type="text/javascript">
if ($("pre").length > 0 && $("pre:contains('There are 0 messages to process')").length === 0) {
	$("#end").append('<h1 style="color: red;">Reload in 3 seconds... </h1>');
	location.href = "#end";
	//location.href = "<?php echo $_SERVER["HTTP_REFERER"];  ?>";
	setTimeout(function () {
		location.reload();
	}, 3000);
}
else {
    location.href = "<?php echo get_home_url();  ?>";
}
</script>
                <?php
            }
            else {
                ?>
<script type="text/javascript" src="/js/jquery-1.2.6.js"></script>
<script type="text/javascript">
location.href = "<?php echo get_home_url();  ?>";
</script>
                <?php
            }
		
	}
    else if ($has_email) {
        //header("Location:" . get_home_url());
        ?>
<script type="text/javascript">
location.href = "<?php echo get_home_url();  ?>";
</script>
    <?php
    }
    else {
        //header("Location:" . get_home_url());
        ?>
		Reload in 3 seconds...
<script type="text/javascript">
//location.href = "<?php echo $_SERVER["HTTP_REFERER"];  ?>";
location.href = "<?php echo get_home_url();  ?>";
/*
setTimeout(function () {
	location.reload();
}, 3000);
*/
</script>
    <?php
        //header("Location:" . $_SERVER["HTTP_REFERER"]);
    }
    
}	// if (function_exists('memory_get_usage'))