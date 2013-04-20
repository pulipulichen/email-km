<?php
load_theme_textdomain( 'i123_hjemmeside', __DIR__ . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_editor_style();

$defaults = array(
	'default-image'          => get_template_directory_uri() . '/images/logo.png',
	'random-default'         => false,
	'width'                  => 212,
	'height'                 => 49,
	'flex-height'            => false,
	'flex-width'             => true,
	'uploads'                => true,
        'default-text-color'     => '0EB7FC'
);
add_theme_support( 'custom-header', $defaults );

if ( ! isset( $content_width ) ) $content_width = 678;

/*******************************************************************************
 * Set excerpt length
 ******************************************************************************/
add_filter('excerpt_length', 'i123_hjemmeside_excerpt_length');
function i123_hjemmeside_excerpt_length($length) {
    return 45;
}
/*******************************************************************************
 * Set excerpt length end
 ******************************************************************************/
/*******************************************************************************
 * Menus
 ******************************************************************************/
register_nav_menu( 'primary', __('Top menu', 'i123_hjemmeside'));
/*******************************************************************************
 * Menus end
 ******************************************************************************/
/*******************************************************************************
 * Widget areas
 ******************************************************************************/
add_action( 'widgets_init', 'register_custom_sidebars', 11 );
function register_custom_sidebars() {
    global $wp_registered_sidebars;
    foreach($wp_registered_sidebars as $i123_hjemmeside_key => $i123_hjemmeside_value) {
        unregister_sidebar($i123_hjemmeside_key);
    }
    register_sidebar( array(
        'name' => __('SideBar', 'i123_hjemmeside'),
        'id' => 'sidebar_venstre',
        'description' => __('The widget area to the side of all pages', 'i123_hjemmeside'),
        'before_widget' => '<div class="i123_widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget_header">',
        'after_title' => '</div>'
        ));
}
/*******************************************************************************
 * Widget areas end
 ******************************************************************************/

/*******************************************************************************
 * Required stuff for repository submission
 ******************************************************************************/

function i123_hjemmeside_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) {
        case 'pingback' :
        case 'trackback' :
            ?>
            <li class="post pingback">
            <p><?php _e( 'Pingback:', 'i123_hjemmeside' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'i123_hjemmeside' ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
            break;
        default :
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <?php
                $avatar_size = 68;
                if ( '0' != $comment->comment_parent ) $avatar_size = 39;
                echo get_avatar( $comment, $avatar_size );

                ?>
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    printf( __( '%2$s, %1$s', 'i123_hjemmeside' ),
                            sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                            sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    sprintf( __( '%1$s at %2$s', 'i123_hjemmeside' ), get_comment_date(), get_comment_time() )
                                    )
                            );
                    ?>
                </div><!-- .comment-author .vcard -->
                
                <?php if ( $comment->comment_approved == '0' ) { ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'i123_hjemmeside' ); ?></em>
                    <br />
                <?php } ?>
            </div>

            <div class="comment-content"><?php comment_text(); ?>
            </div>
            <div class="reply">
            <?php edit_comment_link( __( 'Edit', 'i123_hjemmeside' ), '<span class="edit-link">', '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ); ?>
            </div>
            </article>
            <?php
            break;
    }
}

function i123_hjemmeside_niceList($inputarray, $quote = false) {
    $retval = '';
    foreach ($inputarray as $key => $val) {
        if (trim($val)!='') {
            if ($quote) $val = '"' . $val . '"';
            if ($key == 0) {
                $retval = $val;
            } else if ($key<count($inputarray)-1) {
                $retval .= ', ' . $val;
            } else {
                $retval .= __(' and ', 'i123_hjemmeside') . $val;
            }
        }
    }
    return $retval;
}


function i123_hjemmeside_content_nav() {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) { ?>
		<div>
			<div class="nav-previous"><?php next_posts_link( __( '&larr; Older Posts', 'i123_hjemmeside' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer Posts &rarr;', 'i123_hjemmeside' ) ); ?></div>
		</div>
            <div class="clearboth"></div>
	<?php }
}

function i123_hjemmeside_filter_wp_title( $title ) {
    global $page, $paged;
    $retval = get_bloginfo( 'name' );
    if (( is_home() || is_front_page() )) {
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description!='' ) $retval .= ' | ' . $site_description;
    } else {
        $retval .= $title;
    }
    if ( $paged >= 2 || $page >= 2 )
            $retval .= ' | ' . sprintf( __( 'Page %s', 'i123_hjemmeside' ), max( $paged, $page ) );
    return $retval;
}
add_filter( 'wp_title', 'i123_hjemmeside_filter_wp_title' );