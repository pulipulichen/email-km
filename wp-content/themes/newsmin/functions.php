<?php  
  if ( ! isset( $content_width ) ) 
    $content_width = 630;

  function newsmin_template_setup() 
  {	
	load_theme_textdomain('newsmin', TEMPLATEPATH . '/languages');
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if (is_readable($locale_file ))
	  require_once($locale_file);	
  	 register_nav_menus(
    array('header-menu' => __( 'Header Menu', 'newsmin'  ) )
  );  

      add_theme_support( 'automatic-feed-links' );
    };

  function newsmin_sidebars()
  {
 
  	
    register_sidebar(array(
	    'id' => 'big1',
        'name' => __('First right wide sidebar area', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
		
	register_sidebar(array(
	    'id' => 'small-left1',
        'name' => __('First right slim sidebar area (left part)', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
	    'id' => 'small-right1',
        'name' => __('First right slim sidebar area (right part)', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
	    'id' => 'big2',
        'name' => __('Second right wide sidebar area', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
	    'id' => 'small-left2',
        'name' => __('Second right slim sidebar area (left part)', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
	    'id' => 'small-right2',
        'name' => __('Second right slim sidebar area (right part)', 'newsmin'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
		
   
  };
    add_action('after_setup_theme', 'newsmin_template_setup');
  add_action( 'widgets_init', 'newsmin_sidebars' );
  
  function newsmin_short_title($char) {
$title = get_the_title();
$title = mb_substr($title,0,$char);
echo $title;
}
  
function newsmin_scripts(){
  if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );	

}
add_action( 'wp_enqueue_scripts', 'newsmin_scripts' );  
  
  
  function newsmin_new_excerpt_length($length) {
	return 25; }
add_filter('excerpt_length', 'newsmin_new_excerpt_length');


add_action( 'init', 'register_my_menus' );
  
  function newsmin_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'newsmin' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-author"><?php _e( 'Your comment is awaiting moderation.', 'newsmin' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'newsmin' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'newsmin' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post">
		<p><?php _e( 'Pingback:', 'newsmin' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'newsmin' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
  };
?>