<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */
?>
<?php 
/*
if (strpos($_SERVER["REQUEST_URI"], "/file/") !== false) {
    
    $article_page = $_SERVER["REQUEST_URI"];
    $article_page = substr($article_page, 0, strpos($article_page, "/file/") );
    ?>
    <script type="text/javascript">
    //location.href = "<?php echo $article_page; ?>";
    </script>
    121212
    <?php
}
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
		<?php 
                if ($post->post_type == "attachment") {
                    $permelink = get_post_permalink( $post->post_parent);
                    $parent_title = get_the_title($post->post_parent);
                    
                    $attachment_link = wp_get_attachment_link();
                    ?>
            <div class="auto-attachments"><div class="dIW2"><div class="dI">
            <ul>
                <li>文章連結： <a  href="<?php echo $permelink ?>">
        <?php echo $parent_title ?>
    </a></li>
                <li>檔案名稱： <?php echo $attachment_link ?></li>
                <li>檔案類型： <?php echo get_post_mime_type($post); ?></li>
                
            </ul>
</div></div><div style="clear:both;"></div></div> 
                    <?php
                    if (get_post_mime_type($post) == "text/plain") {
                        $link = wp_get_attachment_url();
                        $content = file_get_contents($link);
                        
                        echo "<pre>".$content."</pre>";
                    }
                }
                else {
                    
    $subject = get_the_title();           
    
    global $wpdb;

    $id = NULL;

                    // see if subject starts with Re:
                    if (preg_match("/(^Re:)(.*)/i", $subject, $matches)) {
                        $subject = trim($matches[2]);

                        $link = "/?s=" . $subject . "&submit=Search&search-type=by-title";
                        ?>
                            <a href="<?php echo $link; ?>" class="search_thread">查看「<?php echo $subject; ?>」討論文章</a>
                        <?php
                    }
                    
                    the_content(); 
                    
                }   //else {
                ?>
        
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
                
                <hr />
                
                <div class="alert alert-warning" style="box-sizing: border-box;padding: 15px;
margin-bottom: 20px;
border: 1px solid transparent;
border-radius: 4px;color: #8a6d3b;
background-color: #fcf8e3;
border-color: #faebcc;">
                    
            <?php echo do_shortcode( '[related_posts_by_tax ]' ) ?>
                    
                </div>
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
            <?php
            /*
            <div class="tags">
                <span class="title">點閱數: <span class="post-view-count"><?php 
                // @20130624 Pudding Chen
                // 加入文章計數功能
                echo do_shortcode('[post_view]'); 
                ?></span></span>
            </div>
            */
            ?>
            
                <?php 
                if ( function_exists( 'wfp_button' ) ) {
                    ?>
            <div class="tags">
                <span class="title">加入我的最愛:</span> 
                <span class="content">    
                    <?php
                    wfp_button(); 
                    ?>
                </span></span>
            </div>
                    <?php
                }
                ?>
            
</footer><!-- .entry-meta -->
