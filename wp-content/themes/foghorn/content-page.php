<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title page-entry-title"><?php the_title(); ?></h1>
        <?php edit_post_link( __( '編輯頁面', 'foghorn' ), '<span class="edit-link">', '</span>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
            
            <!--[related_posts_by_tax]-->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
