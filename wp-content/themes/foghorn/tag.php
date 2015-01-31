<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */

get_header(); ?>
<div id="submain">
		<section id="primary">
			<div id="content" role="main">
            
            	<?php the_post(); ?>

				<header class="page-header">
					<h1 class="page-title">
                                            <div class="ui action input" style='float: right;margin-bottom: 1em;'>
                                                <input type="text" placeholder="新增文章..."  id='new_project_name'>
                                                <div class="ui icon button" onclick="add_new_project()"><i class="write icon"></i></div>
                                                <script>
                                                function add_new_project() {
                                                    var _name = document.getElementById('new_project_name').value;
                                                    location.href = '/wp-admin/post-new.php?post_title=' + encodeURI(_name) + '&tags=<?php echo urlencode(single_tag_title( '', false )); ?>';
                                                }
                                                </script>
                                              </div>
                                            <?php
						printf( __( 'Tag Archives: %s', 'foghorn' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					?></h1>
				</header>
                
                            <div style='clear:both;'></div>
                <?php rewind_posts(); ?>

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