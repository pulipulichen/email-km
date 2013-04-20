<?php get_header(); ?>

    <?php while ( have_posts() ) { ?>
        <?php the_post(); ?>
        <?php get_template_part( 'content', 'post' ); ?>
    <?php } ?>
                
    <?php if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'i123_hjemmeside' ) ); ?></div>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'i123_hjemmeside' ) ); ?></div>
        </nav>
    <?php } ?>
    <div class="clearboth"></div>
<?php get_footer(); ?>