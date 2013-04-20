<div class="page_content template_list">
    <?php if (have_posts()) { ?>
        <ul>
            <?php while (have_posts()) { ?>
                <?php the_post(); ?>
                <?php get_template_part( 'content', 'list' ); ?>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <?php _e('Nothing found...', 'i123_hjemmeside') ?>
    <?php } ?>
</div>