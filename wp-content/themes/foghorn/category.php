<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */

if (single_cat_title( '', false ) == "個人專區") {
	header("location: ../../personal/");
}

get_header(); ?>
<div id="submain">
		<section id="primary">
			<div id="content" role="main">

				<header class="page-header">
					<h1 class="page-title">
                                            <div class="ui action input" style='float: right;margin-bottom: 1em;'>
                                                <input type="text" placeholder="新增文章..."  id='new_project_name'>
                                                <div class="ui icon button" onclick="add_new_project()"><i class="write icon"></i></div>
                                                <script>
                                                function add_new_project() {
                                                    var _name = document.getElementById('new_project_name').value;
                                                    location.href = '/wp-admin/post-new.php?post_title=' + encodeURI(_name) + '&category=<?php echo urlencode(single_cat_title( '', false )); ?>';
                                                }
                                                </script>
                                              </div>
                                            <?php
						printf( __( 'Category: %s', 'foghorn' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
				</header>
                            <div style='clear:both;'></div>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'index' ); ?>

				<?php endwhile; ?>

				<?php foghorn_content_nav( 'nav-below' ); ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php if ( of_get_option('layout','layout-2cr') != 'layout-1c') {
	get_sidebar();
} ?>
</div>
<?php get_footer(); ?>