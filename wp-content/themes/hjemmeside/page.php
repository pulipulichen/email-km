<?php get_header(); ?>
    <?php while ( have_posts() ) { ?>
        <?php the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
    <?php } ?>
<?php get_footer(); ?>