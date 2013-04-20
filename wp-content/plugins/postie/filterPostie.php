<?php

/*
 * WARNING - WARNING - WARNING
 * Do not put any custom filter code in the Postie directory. The standard WordPress
 * upgrade process will delete your code. 
 * 
 * Instead copy filterPostie.php.sample to the wp-content directory and rename it
 * to filterPostie.php and edit to your hearts content.
 * 
 * Another option is to create your own plugin or add this code to your theme.
 */

/*
 * Any filter function you write should accept one argument, which is the post
  array, which contains the following fields:
  'post_author'
  'comment_author'
  'comment_author_url'
  'user_ID'
  'email_author'
  'post_date'
  'post_date_gmt'
  'post_content'
  'post_title'
  'post_modified'
  'post_modified_gmt'
  'ping_status'
  'post_category'
  'tags_input'
  'comment_status'
  'post_name'
  'post_excerpt'
  'ID'
  'customImages'
  'post_status'

  Your function can modify any of these fields. It should then return the array
  back. If you return null then the post will not be created.
 */

//add_filter('postie_post', 'filter_title');
//add_filter('postie_post', 'filter_content');
//add_filter('postie_post', 'add_custom_field');
add_filter('postie_post', 'auto_tag');

//add_filter('postie_filter_email', 'change_email');

function auto_tag($post) {
    // this function automatically inserts tags for a post
    /*
    $my_tags = array('cooking', 'latex', 'wordpress');
    foreach ($my_tags as $my_tag) {
        if (stripos($post['post_content'], $my_tag) !== false)
            array_push($post['tags_input'], $my_tag);
    }
    */
    
    $title = $post['post_title'];

    $indicator = " #";

    $title_parts = split($title, $indicator);

    foreach ($title_parts as $key => $part) {
        if ($key == 0) {
          $post['post_title'] = $part;
          continue;
        }
        else {
          array_push($post['tags_input'], $part);
        }
    }

    return $post;
}

//changes the email to the admin email if the sender was from the example.com domain
function change_email($email) {
    //if (stristr($email, '@example.com'))
    //    return get_option("admin_email");
    return $email;
}

?>
