<?php
function count_project_tags($args) {
    $postslist = get_posts( $args );

$project_tags = array();
$skip_tags = array(
    'email', 'closed', 'reply'
);

//print_r($postslist);



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
            
    foreach ($tags AS $tags_key => $tag) {
        $tag_name = $tag->name;
        
        if ($tag_name === 'closed') {
            $post_type = 'closed';
        }
        
        if (in_array($tag_name, $skip_tags)
                || is_email($tag_name)) {
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
        
        if ($tag_name !== 'closed') {
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
    }
}

return $project_tags;
}

function filter_project_tag($project_tag) {
    
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