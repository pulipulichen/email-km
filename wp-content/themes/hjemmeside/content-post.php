<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h2 class="page_heading"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'i123_hjemmeside' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="page_content template_default">
    <?php the_content(); ?>
    <?php get_template_part( 'tags' ); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'i123_hjemmeside' ) . '</span>', 'after' => '</div>' ) ); ?>
    <?php if (wp_attachment_is_image()) { ?>
        <nav class="page-link">
            <span class="nav-previous"><?php previous_image_link( false, __( '&larr; Previous' , 'i123_hjemmeside' ) ); ?></span>
            <span class="nav-next"><?php next_image_link( false, __( 'Next &rarr;' , 'i123_hjemmeside' ) ); ?></span>
        </nav><!-- #nav-single -->
    <?php } ?>
    <?php if (is_single()) { ?>
        <nav id="nav-single">
                <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'i123_hjemmeside' ) ); ?></span>
                <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'i123_hjemmeside' ) ); ?></span>
        </nav><!-- #nav-single -->
    
        <?php comments_template(); ?>
    <?php } ?>
</div><!-- #post-<?php the_ID(); ?> -->
</div>
<div class="clearboth"></div>