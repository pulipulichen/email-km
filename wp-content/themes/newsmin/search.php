<?php
get_header(); ?>

<div class="content">

<?php if ( have_posts() ) : ?>

				<?php
				get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
<div class="post" >
    <?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'newsmin' ); ?>
</div>
<?php endif; ?>
			
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
