<h2 class="page_heading"><?php the_title(); ?></h2>
<div class="page_content template_default">
    <?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'i123_hjemmeside' ) . '</span>', 'after' => '</div>' ) ); ?>
    <?php comments_template(); ?>
</div><!-- #post-<?php the_ID(); ?> -->
<div class="clearboth"></div>