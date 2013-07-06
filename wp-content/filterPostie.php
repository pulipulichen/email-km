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

function extract_email_address ($string) {
    $string = strip_tags($string);
    foreach(preg_split('/\s/', $string) as $token) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
            
            //再過濾
            //echo $email . " || ";
            if (strpos($email, 'mailto')) {
                $email = substr($email, strpos($email, 'mailto') + 6);
            }
            if (strpos($email, 'Email')) {
                $email = substr($email, strpos($email, 'Email') + 5);
            }
            
             
            
            //取最後
            //echo strrpos($email, '.tw');
            if (strrpos($email, '.tw') > 0) {
                $email = substr($email, 0, strrpos($email, '.tw') + 3);
            }
            if (strrpos($email, '.com')) {
                $email = substr($email, 0, strrpos($email, '.com') + 4);
            }
            if (strrpos($email, '.org')) {
                $email = substr($email, 0, strrpos($email, '.org') + 4);
            }
            if (strrpos($email, '.net')) {
                $email = substr($email, 0, strrpos($email, '.net') + 4);
            }
            
            $emails[] = $email;
            //echo $email . " | ";
        }
    }
    
    //去除重複的email
    $emails = array_unique ($emails);
    
    return $emails;
}


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
    
    $content = $post['post_content'];
    $emails = extract_email_address($content);
    foreach ($emails AS $email) {
        array_push($post['tags_input'], $email);
    }
    
    array_push($post['tags_input'], $post['email_author']);
    //array_push($post['tags_input'], $post['comment_author']);
    
    //$post['post_content'] = $post['post_content'] . "| [" . $post['email_author'] . "] | [" . $post['comment_author'] . "]";

    //array_push($post['tags_input'], "postie");
    
    $content = $post["post_content"];
    $content = preg_replace('#<[^>]+>#', " \r\n", $content);
    $content = preg_replace("/((\r?\n)|(\r\n?))/", " ", $content);
    //$lines = explode("\n", $content);
    //foreach ($lines AS $line) {
    /*
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $content) as $line){
        $line = trim($line);
        while (strpos($line, "#") !== FALSE) {
            $space = strposa($line, array(" ", "&nbsp;", "#"), 1);
            
            if ($space > 0) {
                $tag = substr($line, 1, $space - 1);
                $tag = trim($tag);
                if (strlen($tag) > 0) {
                    array_push($post['tags_input'], $tag);
                }
                $line = substr($line, $space + 1);
                $line = trim($line);
            }
            else {
                $tag = substr($line, 1);
                $tag = trim($tag);
                if (strlen($tag) > 0) {
                    array_push($post['tags_input'], $tag);
                }
                break;
            }
        }
    }
     */
    $lines = explode("#", $content);
    foreach ($lines AS $line) {
        //$line = trim($line);
        $space = strposa($line, array(" ", "&nbsp;", "#"), 0);
        if ($space !== false) {
            $tag = substr($line, 0, $space);
        }
        else {
            $tag = $line;
        }
        
        array_push($post['tags_input'], $tag);
    }
    
    // ----------------------
    // 網頁內容加上換行
    //if (preg_match('/\<html\>(.*)\<\/html\>/', $post['post_content'])) {
        $post['post_content'] = nl2br($post['post_content']);
    //}

    return $post;
}

function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
}

add_filter('postie_post', 'auto_tag');

//$post["post_title"] = "測試看看的標題 #1 #如何？ #3 #測試";
//$post["tags_input"] = array();
//echo auto_tag($post)["post_title"] . "|<br />" ;
//echo auto_tag($post)["post_category"] . "|<br />" ;
//print_r(auto_tag($post)["tags_input"]);

?>
