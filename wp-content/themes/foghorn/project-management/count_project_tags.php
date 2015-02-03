<?php
function count_project_tags($args) {
    $postslist = get_posts( $args );

$project_tags = array();
$skip_tags = array(
    'email', 'closed', 'reply'
);

//print_r($postslist);

$skip_email = array(
    'dlll.email.km@gmail.com'
);


foreach ($postslist AS $key => $post) {
    //echo $post->ID;
    $tags = wp_get_post_tags($post->ID);
    //print_r($tags);
    
    $date = substr ( $post->post_modified_gmt, 0, 10 );
    $date = str_replace('-', '', $date);
    $date = intval($date);
    //echo $date . '<br />';
    
    $author = $post->post_author;
    
    $filtered_tags = array();
    $post_type = 'open';
    if (strtolower(substr($post->post_title, 0, 4)) === 're: ') {
        $post_type = 'other';
    }

    $group = array();
    foreach ($tags AS $tags_key => $tag) {
        $tag_name = $tag->name;
        
        if ($tag_name === 'closed') {
            $post_type = 'closed';
        }
                
        if (in_array($tag_name, $skip_email) === false 
                && is_email($tag_name) 
                && $user = get_user_by_email($tag_name)) {
            $author = $user->ID;
            $group[] = $author;
            //echo $author. ',';
            //continue;
        }
        
        if (in_array($tag_name, $skip_tags) || is_email($tag_name)) {
            continue;
        }
        
        if (isset($project_tags[$tag_name]) === FALSE) {
            $project_tags[$tag_name] = array(
                "open" => array(),
                "closed" => array(),
                "other" => array(),
                'last_modify_date' => $date,
                'authors' => array()
            );
        }
        
        //echo $project_tags[$tag_name]['last_modify_date'] . ' - '. $date . '<br />';
        if ($project_tags[$tag_name]['last_modify_date'] < $date) {
            
            $project_tags[$tag_name]['last_modify_date'] = $date;
        }
        
        if (in_array($tag_name, $skip_tags) === FALSE 
                && is_email($tag) === FALSE) {
            $filtered_tags[] = $tag;
        }
    }   //foreach ($tags AS $tags_key => $tag) {
    
    foreach ($filtered_tags AS $tags_key => $tag) {
        $tag_name = $tag->name;
        $project_tags[$tag_name][$post_type][] = $post->ID;
        
        if (isset($project_tags[$tag_name]['authors'][$author]) === false) {
            $project_tags[$tag_name]['authors'][$author] = 1;
        }
        else {
            $project_tags[$tag_name]['authors'][$author]++;
        }
        
        foreach ($group AS $g_key => $user_id) {
            if (isset($project_tags[$tag_name]['authors'][$user_id]) === false) {
                $project_tags[$tag_name]['authors'][$user_id] = 1;
            }
            else {
                $project_tags[$tag_name]['authors'][$user_id]++;
            }
        }
    }
}

return $project_tags;
}

function filter_project_tag($project_tag, $cat = '', $key = '') {
    
    $last_modified_date = strval($project_tag['last_modify_date']);
    $last_modified_data_year = substr($last_modified_date, 0, 4);
    $last_modified_data_month = substr($last_modified_date, 4, 2);
    $last_modified_data_day = substr($last_modified_date, 6, 2);
    $last_modified_date = $last_modified_data_year.'-'.$last_modified_data_month.'-'.$last_modified_data_day;
    
    $project_tag['last_modify_date_string'] = $last_modified_date;
    
    // ------
    
    $avatars = '';
    foreach ($project_tag['authors'] AS $author_id => $author_count) {
        $author_name = get_the_author_meta( 'display_name', $author_id );
        $author_nickname = get_the_author_meta( 'nickname', $author_id );
        $author_avatar = get_avatar( $author_id, '25');
        
        $href = '/author/' . urlencode($author_nickname) . '/?cat=' . urlencode($cat) . '&tag=' . urlencode($key);
        
        $author_avatar = '<a class="ui image label" href="' . $href . '">
                     '. $author_avatar . ' ' . $author_name 
                . '<div class="detail">' . $author_count .'</div>
                  </a> ';
        $avatars .= $author_avatar;
    }
    
    $project_tag['avatars'] = $avatars;
    
    // ------
    
    $progress = (count($project_tag['closed']) / (count($project_tag['closed']) + count($project_tag['open'])));
    $progress = intval($progress * 100);
    
    $progress_type = '';
    if ($progress > 90) {
        $progress_type = 'green';
    }
    else if ($progress > 70) {
        $progress_type = 'teal';
    }
    else if ($progress > 50) {
        $progress_type = 'yellow';
    }
    else if ($progress > 30) {
        $progress_type = 'purple';
    }
    
    $project_tag['progress'] = $progress;
    $project_tag['progress_type'] = $progress_type;
    
    return $project_tag;
    
}

function classify_tags() {
    $posttags = get_the_tags();
        $tags = array();
        $users = array();
        $email = false;
        foreach ($posttags AS $p_key => $tag) {
            $name = $tag->name;

            if (in_array($name, $skip_user)) {
                continue;
            }

            if (is_email($name) 
                    && $user = get_user_by_email($name)) {

                $id = $user->ID;
                $name = get_the_author_meta('display_name', $id);
                $link = get_author_posts_url($id);
                $avatar = get_avatar( $id, 12 );

                $link = '<a href="'.$link.'">'.$avatar.' '.$name.'</a>';

                $users[] = $link;
            }
            else {
                //$link = '<a href="/tag/'.$tag->term_id.'/" ref="tag">'.$name.'</a>';
                $link = get_tag_link($tag->term_id);
                
                if ($name === 'email') {
                    $email = '<a href="'.$link.'" ref="tag"><i class="mail icon"></i></a>';
                }
                else {
                    $link = '<a href="'.$link.'" ref="tag">'.$name.'</a>';
                    $tags[] = $link;
                }
            }
        }
        
    return array(
        'tags' => $tags,
        'group' => $users,
        'email' => $email
    );
}

function display_post_tags($post_id) {
    $tag_list = get_the_tag_list( '', ', ' );
    $skip_user = array(
        'dlll.email.km@gmail.com'
    );
    
    if ( '' != $tag_list ) {

        $results = classify_tags();

        if ($results['email'] !== false) {
            echo '<span class="sep"> | </span>';
            //printf( __( '<span class="%1$s">參與者:</span> %2$s', 'foghorn' ), 'entry-utility-prep entry-utility-prep-user-links', $user_list );
            echo $results['email'];
        }
        
        if (count($results['tags']) > 0) {
            echo '<span class="sep"> | </span>';
            $tag_list = implode(',', $results['tags']);
            printf( __( '<span class="%1$s">標籤:</span> %2$s', 'foghorn' ), 'entry-utility-prep entry-utility-prep-tag-links', $tag_list );
        }

        if (count($results['group']) > 0) {
            echo '<span class="sep"> | </span>';
            $user_list = implode(',', $results['group']);
            printf( __( '<span class="%1$s">參與者:</span> %2$s', 'foghorn' ), 'entry-utility-prep entry-utility-prep-user-links', $user_list );
        }
    }
}