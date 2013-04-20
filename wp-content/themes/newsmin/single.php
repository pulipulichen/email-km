<?php
get_header(); ?>

	<div class="content">

			<?php
				get_template_part( 'loop', 'single' );
			?>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
