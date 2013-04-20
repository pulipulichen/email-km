<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta inline">
			<?php
				printf( __( '<span class="sep"></span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'foghorn' ),
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
			?>
                    
                        <span class="sep"> | </span>
                        <span class="author">
                            <?php
                            $id = get_the_author_ID();
                            $name = get_the_author_meta('display_name');
                            $link = get_author_posts_url($id);
                            $avatar = get_avatar( $id, 15 );

                            echo '<a href="'.$link.'">'.$avatar.' '.$name.'</a>';
                            ?>
                        </span>
                        <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'foghorn' ) );
                if ( $categories_list ):
            ?>
                        <span class="sep"> | </span>
            <?php printf( __( '<span class="%1$s">分類:</span> %2$s', 'foghorn' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
            $show_sep = true; ?>
            <?php endif; // End if categories ?>
        <?php $tag_list = get_the_tag_list( '', ', ' );
        if ( '' != $tag_list ) {
            echo '<span class="sep"> | </span>';
            printf( __( '<span class="%1$s">標籤:</span> %2$s', 'foghorn' ), 'entry-utility-prep entry-utility-prep-tag-links', $tag_list );
        } ?>
                <span class="title"> </span>
                <span class="content"><?php edit_post_link( __( '編輯文章', 'foghorn' ), '', '' ); ?></span>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
        <?php //edit_post_link( __( '編輯文章', 'foghorn' ), '<span class="edit-link">', '</span>' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'foghorn' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
    <?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'foghorn_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( esc_attr__( 'About %s', 'foghorn' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
		<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

<footer class="entry-meta">
		<div class="post-date">
                        <span class="sep">Posted </span>
                        <time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate>
                            <span class="month"><?php echo get_the_date('M'); ?> </span>
                            <span class="day"><?php echo get_the_date('d'); ?> <span class="sep">, </span></span>
                            <span class="year"><?php echo get_the_date('Y'); ?></span>
                        </time>
                </div>
        <div class="tags">
                <span class="title">作者</span>
                <span class="author">
                    <?php
                    $id = get_the_author_ID();
                    $name = get_the_author_meta('display_name');
                    $link = get_author_posts_url($id);
                    $avatar = get_avatar( $id, 75 );

                    echo '<a href="'.$link.'">'.$avatar.'<br />'.$name.'</a>';
                    ?>
                </span>
            </div>
        <?php $categories_list = get_the_category_list( __( ', ', 'foghorn' ) );
		if ( '' != $categories_list ) { ?>
            <div class="categories">
                <span class="title">
                    <?php printf( __( '<span class="%1$s">分類:</span>', 'foghorn' ), 'entry-utility-prep entry-utility-prep-cat-links' ); ?>
                    分類:
                </span> 
                <span class="content"><?php echo $categories_list; ?></span>
            </div>
        <?php } ?>
        <?php $tag_list = get_the_tag_list( '', ', ' );
		if ( '' != $tag_list ) { ?>
            <div class="tags">
                <span class="title">
                    <?php printf( __( '<span class="%1$s">標籤:</span>', 'foghorn' ), 'entry-utility-prep entry-utility-prep-tag-links'); ?>
                    標籤:
                </span> 
                <span class="content"><?php echo $tag_list; ?></span>
            </div>
        <?php } ?>
            <div class="tags">
                <span class="title">管理</span>
                <span class="content"><?php edit_post_link( __( '編輯文章', 'foghorn' ), '', '' ); ?></span>
            </div>
</footer><!-- .entry-meta -->