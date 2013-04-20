<?php get_header(); ?>
<h1 class="page_heading"><?php printf(__("Search results for \"%s\"", 'i123_hjemmeside'), get_search_query()) ?></h1>
    <?php get_template_part('loop', 'list'); ?>
<?php get_footer(); ?>