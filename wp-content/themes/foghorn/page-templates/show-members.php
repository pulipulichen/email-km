<?php
/**
 * Template Name: Show Members
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div id='submain'>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<article class="page type-page status-publish hentry user-list">

                            <header>
<h1 class="ui dividing header">
  <i class="circular users icon"></i>
  <div class="content">
    <?php echo get_the_title(); ?>
      <a class="sub header" href='/wp-admin/users.php' style="display: block">進入管理者界面</a>
  </h1></header>                            
                            
                            
<?php
//new WP_Query( array('meta_key'=>'instrument',  'orderby' => 'meta_value_num', 'order' => 'desc' ) );
$blogusers = get_users( array(
    'orderby' => 'meta_value',
    'order' => 'asc',
    'meta_key' => 'wp-last-login',
//    'meta_query' => array(
//        'orderby' => 'wp-last-login',
//        'order' => 'asc'
//    )
) );
// Array of WP_User objects.
$displayed_user = array();
foreach ( $blogusers as $user ) {
	//echo '<span>' . esc_html( $user->ID ) . '</span>';
        echo Author_Bio_Box_Frontend::view(array(), $user->ID);
        array_push($displayed_user, $user->ID);
}

// -------------------------

$blogusers = get_users( array(
    'orderby' => 'post_count',
    'order' => 'desc',
//    'meta_query' => array(
//        'orderby' => 'wp-last-login',
//        'order' => 'asc'
//    )
) );
// Array of WP_User objects.

foreach ( $blogusers as $user ) {
    if (in_array($user->ID, $displayed_user)) {
        continue;
    }
    //echo '<span>' . esc_html( $user->ID ) . '</span>';
    echo Author_Bio_Box_Frontend::view(array(), $user->ID);
        
}

?>
                            
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>