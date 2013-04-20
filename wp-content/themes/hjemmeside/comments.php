<div id="comments">
<?php if ( post_password_required() ) { ?>
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'i123_hjemmeside' ); ?></p>
    </div><!-- #comments -->
    <?php
    return;
}
?>
<?php if ( have_comments() ) { ?>
    <h2 id="comments-title"><?php printf( _n( 'One comment on "%2$s"', '%1$s comments on "%2$s"', get_comments_number(), 'i123_hjemmeside' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?></h2>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
        <nav id="comment-nav-above">
        <h1 class="assistive-text"><?php _e( 'Comment navigation', 'i123_hjemmeside' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'i123_hjemmeside' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'i123_hjemmeside' ) ); ?></div>
        </nav>
    <?php } ?>

    <ol class="commentlist">
    <?php wp_list_comments( array( 'callback' => 'i123_hjemmeside_comment' ) ); ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
        <nav id="comment-nav-below">
        <h1 class="assistive-text"><?php _e( 'Comment navigation', 'i123_hjemmeside' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'i123_hjemmeside' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'i123_hjemmeside' ) ); ?></div>
        </nav>
        <?php
    }
} elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
    <p class="nocomments"><?php _e( 'Comments are closed.', 'i123_hjemmeside' ); ?></p>
    <?php 
} 
?>

<?php
comment_form(array('title_reply'=> sprintf('<h4>' . __('Post a comment on "%1$s"', 'i123_hjemmeside') . '</h4>', '<span>' . get_the_title() . '</span>')));
?>

</div><!-- #comments -->
