<?php
/**
 * Layout for posts with comments etc.
 */
?>
<?php get_header(); ?>
    <?php the_post(); ?>
    <?php get_template_part( 'content', 'post' ); ?>
<?php get_footer(); ?>