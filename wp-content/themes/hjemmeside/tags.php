<?php
    $i123_hjemmeside_categories_list = i123_hjemmeside_niceList(explode('-_-_SPLIT_-_-', get_the_category_list( '-_-_SPLIT_-_-' )), true);
    $i123_hjemmeside_tag_list = i123_hjemmeside_niceList(explode('-_-_SPLIT_-_-', get_the_tag_list( '', '-_-_SPLIT_-_-', '' )), true);
    
    if (( '' != $i123_hjemmeside_tag_list )&&( '' != $i123_hjemmeside_categories_list )) {
            $i123_hjemmeside_utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'i123_hjemmeside' );
    } elseif ( '' != $i123_hjemmeside_categories_list ) {
            $i123_hjemmeside_utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'i123_hjemmeside' );
    } elseif ( '' != $i123_hjemmeside_tag_list ) {
            $i123_hjemmeside_utility_text = __( 'This entry was tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'i123_hjemmeside' );
    } else {
            $i123_hjemmeside_utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'i123_hjemmeside' );
    }
    echo '<div class="magicclear"></div><p class="postinfo">';
    printf(
            $i123_hjemmeside_utility_text,
            $i123_hjemmeside_categories_list,
            $i123_hjemmeside_tag_list,
            esc_url( get_permalink() ),
            the_title_attribute( 'echo=0' ),
            get_the_author(),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
    );
    echo '</p>';