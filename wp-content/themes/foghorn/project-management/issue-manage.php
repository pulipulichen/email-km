<?php
//define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('../../../../wp-blog-header.php');

$post_id = $_GET['post_id'];
$close = $_GET['close'];

if ($close === 'true') {
    wp_set_post_tags( $post_id, 'closed', true );
}
else {
    $tags = wp_get_post_tags( $post_id);
    $filtered_tags = array();
    foreach ($tags AS $tag_key => $tag) {
        if ($tag->name !== 'closed') {
            $filtered_tags[] = $tag->name;
        }
    }
    
    wp_set_post_tags( $post_id, $filtered_tags);
}

if (isset($_GET['tag']) === false) {
    header('Location: /?p=' . $post_id);
}
else {
    $type = 'closed';
    if ($close === 'true') {
        $type = 'open';
    }
    header('Location: /project-management-list?project_tag=' . urlencode($_GET['tag']).'&project_type='.$type);
}