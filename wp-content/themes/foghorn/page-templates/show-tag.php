<?php
/**
 * Template Name: Show Tag
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<article class="page type-page status-publish hentry user-list">
				<style>
.user-list .avatar {
	/*float: left;*/
    display: block;
	/*margin-right: 1em;*/
	/*margin-bottom: 0.5em;*/
}

.user-list li.avatar,
.user-list ul {

	/*clear: both;*/
}

.user-list ul.posts { 
    margin-bottom: 0;
}

.user-list li.avatar {
    float:left;
    width: 90px;
    margin-right: 0.5em;
    margin-bottom: 0.5em;
}

.user-list li.avatar .info {
    font-size: 0.8em;
}

.user-list h3 {
	clear: none;
}
.user-list h2 {
    margin-top: 0.5em;
}
				</style>
<header class='entry-header'><h1 class="entry-title"><?php echo get_the_title() ?></h1></header>
<article>
<div class="user-list">
<?php 
function display_posts_list($is_cat = true, $tag) {
    global $wpdb;
    $cat_id = $tag->term_id;

    $posts = query_posts( 'tag_id='.$cat_id."&posts_per_page=5" ); 

    //$posts_count = count($posts);
    $cat_name = $tag->name;

    $querystr = "
            SELECT count
            FROM $wpdb->term_taxonomy
            WHERE term_id = $cat_id";
    $result = $wpdb->get_var($querystr);

    ?>
    <header class='entry-header'>
        <h2 class="entry-title tag">
            <?php 
            if ($result > 0) {
                ?>
            <a href="<?php echo get_category_link( $cat_id ) ?>">
            <?php echo $cat_name ?> 
            </a>(共<?php echo $result ?>篇文章)
                <?php
            }
            else {
                ?>
            <?php echo $cat_name ?> 
            (共<?php echo $result ?>篇文章)
                <?php
            }
            echo "<a id='cat".$cat_id."' name='cat".$cat_id."'></a>";
            ?>
            
        </h2>
    </header>
    <?php

    echo "<ul class='posts'>";
    foreach ($posts as $post) {
        //print_r($post);
        $date = $post->post_date;
        $date = substr($date, 0, 10);
        echo '<li>'.$date. ' <a href="'.get_permalink($post->ID).'">'
            . $post->post_title.'</a></li>';
    }
     echo "</ul>";
     if ($result > count($posts)) {
        echo '<a href="'.get_category_link( $cat_id ).'">瀏覽全部文章...</a>';
    }
}

$categories = get_tags();
echo "<ul class='index tag'>";
foreach ($categories as $tag) {
    $cat_id = $tag->term_id;
    $cat_name = $tag->name;

    $querystr = "
            SELECT count
            FROM $wpdb->term_taxonomy
            WHERE term_id = $cat_id";
    $result = $wpdb->get_var($querystr);

    echo '<li><a href="#cat'.$cat_id.'">'.$cat_name.' (共'.$result.'篇文章)</a></li>';    
}
echo "</ul>";
echo "<hr />";

foreach ($categories as $tag) {
    display_posts_list(false, $tag);
}


?>

<br style="clear:both" />
</div>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>