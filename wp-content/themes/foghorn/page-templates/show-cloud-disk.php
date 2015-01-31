<?php
/**
 * Template Name: Show Cloud Disk
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
            <ul>
                <li><a href="http://cloud-disk.dlll.nccu.edu.tw/?uid=<?php echo $user_login ?>" target="cloud_disk">新視窗開啟雲端硬碟</a></li>
                <li><a href="http://email-km.dlll.nccu.edu.tw/2015/01/ru-he-shi-yong-yun-duan-ying-die/"  target="_blank">雲端硬碟教學說明</a></li>
            </ul>
		<div id="content" role="main">
                    <article class="page type-page status-publish hentry user-list" style="min-width:90%;">
                        <p><iframe src="http://cloud-disk.dlll.nccu.edu.tw/?uid=<?php echo $user_login ?>" height="500" width="100%"></iframe></p>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>