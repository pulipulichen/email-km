    <?php
/**
 * Template Name: Redirect
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
			<article class="page type-page status-publish hentry">
                            <?php 
                                $page = get_post();
                                $link = $page->post_content;  
                            ?>
Redirect to <a href="<?php echo $link ?>"><?php echo $link ?></a> ...
<script type="text/javascript">// <![CDATA[
location.href="<?php echo $link ?>";
// ]]></script>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>