<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */

if ($_GET["type"] == 'html') {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo get_the_title(); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
						<?php echo get_the_content(); ?>
        <div style="text-align: right;">
            <a href="#" onclick="location.reload(true)">重新整理</a> 
            | 
            <a href="http://email-km.dlll.nccu.edu.tw/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit" target="edit">編輯網頁</a>
        </div>
				<?php endwhile; // end of the loop. ?>
    </body>
</html>
    <?php
    exit();
}
else if ($_GET["type"] == 'frameset') {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo get_the_title(); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
						<?php echo get_the_content(); ?>
				<?php endwhile; // end of the loop. ?>
</html>
    <?php
    exit();
}

get_header(); ?>


<div id="submain">
		<div id="primary">
            
			<div id="content" role="main">
                                <header class="page-header">
					<h1 class="page-title"><?php
						printf( __( 'Category: %s', 'foghorn' ), '<span>' .get_the_category_list( __( ', ', 'foghorn' ) ) . '</span>' );
					?></h1>

					<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
				</header>
                            
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                	<div class="content-wrap clearfix">
						<?php get_template_part( 'content', 'single' ); ?>
                    </div>
					<?php foghorn_content_nav( 'nav-below' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
       
<?php if ( of_get_option('layout','layout-2cr') != 'layout-1c') {
	get_sidebar();
} ?>
</div>     
<?php get_footer(); ?>