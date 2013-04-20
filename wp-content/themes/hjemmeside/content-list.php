<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>><a class="listheading" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <div class="listexcerpt">
        <?php echo '<p>' . str_replace('[...]', '...' . sprintf(__('</p><p class="listreadmore"><a href="%1$s">Read the full entry</a>', 'i123_hjemmeside'), get_permalink()), get_the_excerpt()) . '</p>'; ?>
        <?php get_template_part( 'tags' ); ?>
    </div>
</li>