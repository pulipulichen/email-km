<?php
/* 
Plugin Name: Reply Comment to Email
Plugin URI: http://www.euqueroaprender.ismywebsite.com/
Version: 1.0
Author: jaysponsored
Description: When you (or someone) reply a comment, the person who receive this reply will be avised by mail.
Author URI: http://www.euqueroaprender.ismywebsite.com/
*/
	// When plugin be activated, execute the following function:
	// FILE indicate this file location.
	register_activation_hook(__FILE__,'plugin');
	
	function plugin() {
		add_option('reply_comment_message_subject','[comment_name], your comment at [blogname] has a new reply');
		add_option('reply_comment_message', '[comment_name], your comment posted in [comment_date] on post [postname] has a new reply.<br /><br />

Your comment: [comment_content].<br /><br />

Answer from [comment_reply_name] in [comment_reply_date]: [comment_reply_content] <br /><br />

You can see more information for the reply on this link: <a href=[comment_reply_url]>[comment_reply_url]</a>.<br /><br />

Automatic Email. Please do not reply.');
	}
	
	add_action('admin_menu', 'admin');
	
	function admin() 
	{
		add_options_page('Reply Comment to Email', 'Reply Comment to Email', 'manage_options', 'reply-comment-to-email', 'load');
	}
	
	add_action('wp_set_comment_status','status');
	add_action('comment_post', 'comment');
	
	function status() 
	{
		// plugin don't work in localhost
		// plugin will not influence in trash, spam and unapprove actions.
		$arr = array("localhost","edit-comments.php");
			
		foreach ($arr as $neddle) 
		{
			if (strpos($_SERVER["REQUEST_URI"], $neddle) == false) 
			{
				//end function
				return 0;
			}
		}
		
		// receive comment id that are being approved. it comes from wp_set_comment_status.
		$comment_reply_id = get_comment_ID();
			
		$query = mysql_query('SELECT * FROM $wpdb->comments WHERE comment_ID = ' . get_comment_ID());
				
		while ($check = mysql_fetch_array($query)) 
		{
			$comment_reply_date = mysql2date(get_option('date_format'), $check['comment_date']);
			$comment_reply_content = $check['comment_content'];
			$comment_reply_name = $check['comment_author'];
							
			if ($check['comment_approved'] == '1' and $check['comment_parent'] > 0) 
			{		
				// READ COMMENT PARENT E-MAIL
				$query = mysql_query('SELECT * FROM $wpdb->comments WHERE comment_ID = ' . $check['comment_parent']);	
								
				while ($check = mysql_fetch_array($query)) 
				{
					$comment_date = mysql2date(get_option('date_format'), $check['comment_date']);
					$comment_content = $check['comment_content'];
					$comment_name = $check['comment_author'];
								
					$comment_id = $check['comment_ID'];
							
					// SAVE EMAIL FROM REPLIED COMMENT
					$comment_email = $check['comment_author_email'];
								
					// READ POST TITLE AND URL
					$query = mysql_query('SELECT * FROM $wpdb->posts WHERE ID = ' . $check['comment_post_ID']); 
								
					while ($check = mysql_fetch_array($query)) 
					{
						$post_title = $check['post_title'];
						$post_url = $check['guid'];
					}		
								
					/*
					**********************************
					MESSAGE SUBJECT 
					**********************************
					*/
									
					$reply_comment_message_subject = get_option('reply_comment_message_subject');
					$reply_comment_message_subject = str_replace('[blogname]', get_option('blogname'), $reply_comment_message_subject);
					$reply_comment_message_subject = str_replace('[postname]', $post, $reply_comment_message_subject);
					$reply_comment_message_subject = str_replace('[comment_name]', $comment_name, $reply_comment_message_subject);
									
					/*
					**********************************
					MESSAGE
					**********************************
					*/
									
					$reply_comment_message = get_option('reply_comment_message');
									
					// Old comment
					$reply_comment_message = str_replace('[comment_date]', $comment_date, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_content]', $comment_content, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_name]', $comment_name, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_url]', $post_url . '#comment-' . $comment_id, $reply_comment_message);
									
					// Comment reply
					$reply_comment_message = str_replace('[comment_reply_date]', $comment_reply_date, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_content]', $comment_reply_content, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_name]', $comment_reply_name, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_url]', $post_url . '#comment-' . $comment_reply_id, $reply_comment_message);
		
					$reply_comment_message = str_replace('[blogname]', get_option('blogname'), $reply_comment_message);
					$reply_comment_message = str_replace('[blogurl]', get_option('home'), $reply_comment_message);
					$reply_comment_message = str_replace('[postname]', $post_title, $reply_comment_message);
					$reply_comment_message = str_replace('[posturl]', $post_url, $reply_comment_message);
									
					// for testing purposes in localhost environment. change ==false to !==false in top of this function.
					// mysql_query ('UPDATE $wpdb->comments SET comment_content="'. $reply_comment_message .'" WHERE comment_ID = ' . $comment_id);
								
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								
					wp_mail($comment_email,$reply_comment_message_subject,$reply_comment_message, $headers);
				} 
			}
		}
	} // status

	// SAVE comment_id from the new comment in DB.
	// this is a variable that comes with function that runs only when a new comment is added to DB. 
	// we can use the name we want to read, i prefered $comment_reply_id, but you can use another if you want, too.
	function comment($comment_reply_id) 
	{
		// plugin don't work in localhost
		// plugin will not influence in trash, spam and unapprove actions.
		$arr = array("localhost","edit-comments.php");
			
		foreach ($arr as $neddle) 
		{
			if (strpos($_SERVER["REQUEST_URI"], $neddle) == false) 
			{
					//end function
					return 0;
			}
		}
				
		$query = mysql_query('SELECT * FROM $wpdb->comments WHERE comment_ID = ' . $comment_reply_id);
					
		while ($check = mysql_fetch_array($query)) 
		{
			$comment_reply_date = mysql2date(get_option('date_format'), $check['comment_date']);
			$comment_reply_content = $check['comment_content'];
			$comment_reply_name = $check['comment_author'];
							
			if ($check['comment_approved'] == '1' and $check['comment_parent'] > 0) 
			{		
				// READ COMMENT PARENT E-MAIL
				$query = mysql_query('SELECT * FROM $wpdb->comments WHERE comment_ID = ' . $check['comment_parent']);	
								
				while ($check = mysql_fetch_array($query)) 
				{
					$comment_date = mysql2date(get_option('date_format'), $check['comment_date']);
					$comment_content = $check['comment_content'];
					$comment_name = $check['comment_author'];
			
					// SAVE REPLYED ID
					$comment_id = $check['comment_ID'];
								
					// SAVE COMMENT EMAIL
					$comment_email = $check['comment_author_email'];
								
					// READ POST TITLE
					$query = mysql_query('SELECT * FROM wp_posts WHERE ID = ' . $check['comment_post_ID']); 
								
					while ($check = mysql_fetch_array($query)) 
					{
						$post_title = $check['post_title'];
						$post_url = $check['guid'];
					}		
								
					/*
					**********************************
					MESSAGE SUBJECT 
					**********************************
					*/
								
					$reply_comment_message_subject = get_option('reply_comment_message_subject');
					$reply_comment_message_subject = str_replace('[blogname]', get_option('blogname'), $reply_comment_message_subject);
					$reply_comment_message_subject = str_replace('[postname]', $post, $reply_comment_message_subject);
					$reply_comment_message_subject = str_replace('[comment_name]', $comment_name, $reply_comment_message_subject);
								
					/*
					**********************************
					MESSAGE
					**********************************
					*/
									
					$reply_comment_message = get_option('reply_comment_message');
									
					// Old comment
					$reply_comment_message = str_replace('[comment_date]', $comment_date, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_content]', $comment_content, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_name]', $comment_name, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_url]', $post_url . '#comment-' . $comment_id, $reply_comment_message);
								
					// Comment reply
					$reply_comment_message = str_replace('[comment_reply_date]', $comment_reply_date, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_content]', $comment_reply_content, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_name]', $comment_reply_name, $reply_comment_message);
					$reply_comment_message = str_replace('[comment_reply_url]', $post_url . '#comment-' . $comment_reply_id, $reply_comment_message);
								
					$reply_comment_message = str_replace('[blogname]', get_option('blogname'), $reply_comment_message);
					$reply_comment_message = str_replace('[blogurl]', get_option('home'), $reply_comment_message);
					$reply_comment_message = str_replace('[postname]', $post_title, $reply_comment_message);
					$reply_comment_message = str_replace('[posturl]', $post_url, $reply_comment_message);
								
					// for testing purposes in localhost environment. change ==false to !==false in top of this function.
					// mysql_query ('UPDATE $wpdb->comments SET comment_content="'. $reply_comment_message .'" WHERE comment_ID = ' . $comment_id);
									
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
									
					wp_mail($comment_email,$reply_comment_message_subject,$reply_comment_message, $headers);
				} 
			}
		} 
	}
	
	function load() {
		
		$plugin_dir = plugins_url() . '/reply-comment-to-email';
		
?>

	<link href="<?php echo $plugin_dir; ?>/style.css" rel="stylesheet" type="text/css" />
    
    <div id="container">
    
    <?php
    	if (isset($_POST['reply_comment_message'])) 
			{ ?>
				<META HTTP-EQUIV="refresh" CONTENT="0; URL=<?php echo $_SERVER['PHP_SELF'] . '?page=reply-comment-to-email' ?>">
	  <?php 
	  } ?>

    
        <h1 class="plugin">
        	<a href="#">Reply Comment to Email</a>
        </h1>
        
	<div id="logo">
    </div>
    
    <div id="breadcrumb-top">
    </div> 
    
<div id="principal">
			<div id="post">
                     
			<div class="texto">
            <?php 
			
			if (strpos(home_url(), 'localhost') !== false) 
			{
			?>
				<blockquote>You're in localhost enviroment. <b>Reply Comment to Email doesn't work in localhost environment.</b></blockquote>
			<?php
			} 
			?>
            
            <blockquote>You can use HTML code (only in message, not in subject).</blockquote> 
            
            	<form method="post" action="">
                                
				    <p>
     					<input type="text" name="reply_comment_message_subject" value="<?php echo get_option('reply_comment_message_subject') ?>" id="reply_comment_message_subject" size="44" tabindex="1" />
     					<label for="reply_comment_message_subject">Message Subject (<span style="color: #F00;">*</span>)</label>
                        <br /><br />
    				</p>
                    
                    <p>
                    	<label for="reply_comment_message">Message (<span style="color: #F00;">*</span>)</label><br />
      					<textarea name="reply_comment_message" id="reply_comment_message" value="" cols="92%" rows="10" tabindex="2"><?php echo get_option('reply_comment_message') ?></textarea>
    				</p>
                    
                    <input type="submit" name="update" value="update" tabindex="10" />
                    
                <blockquote>
                	<p>You can use in message subject:</p> 
                	<p><b>[blogname]</b>: Returns "<?php echo get_option('blogname') ?>"</p>
                    <p><b>[postname]</b>: Returns post name.</p>
                    <p><b>[comment_name]</b>: Returns name from person who commented and now was replied.</p>
                </blockquote>
                
                <blockquote>
                    <p>You can use in message:</p>
                    <p><b>[blogname]</b>: Returns "<?php echo get_option('blogname') ?>"</p>
                    <p><b>[postname]</b>: Returns post name.</p>
                    <p><b>[posturl]</b>: Returns post url.</p>
                    <p><b>[blogurl]</b>: Returns blog url</p>
                    <i>Comment Replied</i>
                    <p><b>[comment_name], [comment_date], [comment_content], [comment_url]</b>.</p>
                    <i> Author from comment reply </i>
                    <p><b>[comment_reply_name], [comment_reply_date], [comment_reply_content], [comment_reply_url]</b>.</p>
                </blockquote>
                    
            	</form>

			</div>
            	        
		</div> <!-- .posts -->
	            
</div> <!-- #principal -->
    
	<div id='footer-plugin'>
	</div>

	<div id='copyright'>
    <small>Logo from plugin theme is copyright by SilentReaper.</small>
	</div>
    
    </div>

<?php
	if (isset($_POST['reply_comment_message'])) {
		update_option('reply_comment_message_subject', $_POST['reply_comment_message_subject']);
		update_option('reply_comment_message', $_POST['reply_comment_message']);
	}
} // End load() function
?>