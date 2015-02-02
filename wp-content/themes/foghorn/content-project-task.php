<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */

$list_type = 'open';
if (isset($_GET['project_type'])) {
    $list_type = $_GET['project_type'];
}
?>
	<div class="content-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    	<?php if( has_post_thumbnail() ) { ?>
    	<div class="post-thumbnail">
    		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'foghorn'); ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail('multiple-thumb'); ?></a>
            <?php if ( is_sticky() ) { ?>
				<span class="entry-format"><?php _e( 'Featured', 'foghorn' ); ?></span>
			<?php } ?>
        </div>
        <?php } ?>
        
        
        <div<?php if( has_post_thumbnail() ) { ?> class="post-wrap"<?php } ?>>
		<header class="entry-header">

            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foghorn' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

            <footer class="entry-meta">
                <?php
                    $id = get_the_author_ID();
                    $name = get_the_author_meta('display_name');
                    $link = get_author_posts_url($id);
                    $avatar = get_avatar( $id, 12 );

                    echo '<a href="'.$link.'">'.$avatar.' '.$name.'</a>';

                ?>
                <span class="sep"> | </span>

                <?php

                printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'foghorn' ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() )
                );

                ?>
            
                <?php $show_sep = false; ?>
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

            <?php if ( comments_open() ) : ?>
            <?php if ( $show_sep ) : ?>
            <span class="sep"> | </span>
            <?php endif; // End if $show_sep ?>
            <span class="leave-reply"><?php comments_popup_link( __( '<span class="reply">回覆</span>', 'foghorn' ), __( '<span class="reply">回覆:</span> 1', 'foghorn' ), __( '<span class="reply">回覆:</span> %', 'foghorn' ) ); ?></span>
            <?php endif; // End if comments_open() ?>
            <?php edit_post_link( __( '編輯文章', 'foghorn' ), '<span class="sep"> | </span><span class="edit-link index">', '</span>' ); ?>
            
        <?php
        if ($list_type === 'open') {
                            ?>
                             <a class="ui labeled icon green mini button" href="<?php echo get_template_directory_uri(); ?>/project-management/issue-manage.php?post_id=<?php echo get_the_ID(); ?>&close=true&tag=<?php echo urlencode($_GET['project_tag']) ?>">
                                <i class="checkmark icon"></i>
                                設定任務完成
                            </a>
                            <?php
                        }
                        else if ($list_type === 'closed') {
                            ?>
            <a class="ui labeled icon red mini button" href="<?php echo get_template_directory_uri(); ?>/project-management/issue-manage.php?post_id=<?php echo get_the_ID(); ?>&close=false&tag=<?php echo urlencode($_GET['project_tag']) ?>">
                                <i class="undo icon"></i>
                                設定任務未完成
                            </a>
                            <?php
                        }
        ?>
            </footer><!-- .entry-meta -->



			
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt( __( '<繼續閱讀>', 'foghorn' ) ); ?>
		</div><!-- .entry-summary -->

		<footer class="entry-meta">
			
		</footer><!-- #entry-meta -->
        </div>
	</article><!-- #post-<?php the_ID(); ?> -->
    </div>