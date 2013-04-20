<?php get_header(); ?>
    <h1 class="page_heading"><?php printf(__('Archive for %s', 'i123_hjemmeside'), single_cat_title( '', false )); ?></h1>
    <?php get_template_part('loop', 'list'); ?>
    <?php i123_hjemmeside_content_nav(); ?>
<?php get_footer(); ?>