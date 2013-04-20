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

function auto_tag($post) {
    
    $title = $post['post_title'];
    $indicator = " #";
    $title_parts = explode($indicator, $title);

    /*
    $categories = get_all_category_ids();
    $cate_names = array();
    foreach($categories as $category_id) { 
      $cate_names[] = get_cat_name($category_id);
    }
    */
    
    foreach ($title_parts as $key => $part) {
        if ($key == 0) {
          $post['post_title'] = $part;
          continue;
        }
        else {
          if ($part != null) {
            /*
            //先檢查是否符合目前的目錄
            $is_category = false;

            if (in_array($part, $cate_names)) {
              $is_category = true;
              $post["post_category"] = $part;
            }

            if ($is_category == false) {
              array_push($post['tags_input'], $part);  
            }
            */

            array_push($post['tags_input'], $part);  
          }
        }
    }

    //array_push($post['tags_input'], "postie");

    return $post;
}

add_filter('postie_post', 'auto_tag');

//$post["post_title"] = "測試看看的標題 #1 #如何？ #3 #測試";
//$post["tags_input"] = array();
//echo auto_tag($post)["post_title"] . "|<br />" ;
//echo auto_tag($post)["post_category"] . "|<br />" ;
//print_r(auto_tag($post)["tags_input"]);

?>
