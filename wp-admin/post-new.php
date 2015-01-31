<?php
/**
 * New Post Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Administration Bootstrap */
require_once('./admin.php');

if ( !isset($_GET['post_type']) )
	$post_type = 'post';
elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
	$post_type = $_GET['post_type'];
else
	wp_die( __('Invalid post type') );

$post_type_object = get_post_type_object( $post_type );

if ( 'post' == $post_type ) {
	$parent_file = 'edit.php';
	$submenu_file = 'post-new.php';
} elseif ( 'attachment' == $post_type ) {
	wp_redirect( admin_url( 'media-new.php' ) );
	exit;
} else {
	$submenu_file = "post-new.php?post_type=$post_type";
	if ( isset( $post_type_object ) && $post_type_object->show_in_menu && $post_type_object->show_in_menu !== true ) {
		$parent_file = $post_type_object->show_in_menu;
		if ( ! isset( $_registered_pages[ get_plugin_page_hookname( "post-new.php?post_type=$post_type", $post_type_object->show_in_menu ) ] ) )
			$submenu_file = $parent_file;
	} else {
		$parent_file = "edit.php?post_type=$post_type";
	}
}

add_filter('wp_get_object_terms', function($terms, $object_ids, $taxonomies, $args)
{
    if (!$terms && basename($_SERVER['PHP_SELF']) == 'post-new.php') {

        // Category - note: only 1 category is supported currently
        $return_ids = array();
        if ($taxonomies == "'category'" && isset($_REQUEST['category'])) {
            $id = get_cat_id($_REQUEST['category']);
            if ($id) {
                //return array($id);
                $return_ids[] = $id;
            }
        }

        // Tags
        if ($taxonomies == "'post_tag'" && isset($_REQUEST['tags'])) {
            $tags = $_REQUEST['tags'];
            echo $tags;
            /*
            global $wp_taxonomies;
            $wp_taxonomies['post_tag']->label = $tags;
            $tags = is_array($tags) ? $tags : explode( ',', trim($tags, " \n\t\r\0\x0B,") );
            
            $term_ids = array();
            foreach ($tags as $term) {
                if ( !$term_info = term_exists($term, 'post_tag') ) {
                    // Skip if a non-existent term ID is passed.
                    if ( is_int($term) )
                        continue;
                    $term_info = wp_insert_term($term, 'post_tag');
                }
                //$term_ids[] = $term_info['term_id'];
                //echo $term_info['term_id'];
                $return_ids[] = $term_info['term_id'];
            }
            */
            //return $term_ids;
        }
        
        return $return_ids;
    }
    return $terms;
}, 10, 4);

$title = $post_type_object->labels->add_new_item;

$editing = true;

if ( ! current_user_can( $post_type_object->cap->edit_posts ) || ! current_user_can( $post_type_object->cap->create_posts ) )
	wp_die( __( 'Cheatin&#8217; uh?' ) );

// Schedule auto-draft cleanup
if ( ! wp_next_scheduled( 'wp_scheduled_auto_draft_delete' ) )
	wp_schedule_event( time(), 'daily', 'wp_scheduled_auto_draft_delete' );

wp_enqueue_script( 'autosave' );

// Show post form.
$post = get_default_post_to_edit( $post_type, true );
$post_ID = $post->ID;
include('edit-form-advanced.php');
include('./admin-footer.php');
