    <?php
/**
 * Template Name: Show Chat
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
                            <h1>實驗室偷偷摸摸聊天室</h1>
                            <ul>
                                <li>最多保留訊息<strong>50則</strong></li>
                                <li><span style="color:red;">不知道同學的帳號嗎？</span>請到「<a href="http://email-km.dlll.nccu.edu.tw/wp-admin/users.php" target="users">全部帳號</a>」去查詢。
                                    沒有你的帳號再<a href="mailto:pulipuli.chen+email.km@gmail.com&subject=我想申請EMAIL-KM的帳號&body=我的姓名、電話、Email帳號是：" 
                                              title="寄信給布丁"> 通知布丁幫同學新增</a>。</li>
                            </ul
                            <div>
                               <?php
                                echo do_shortcode('[quick-chat height="400" room="default" userlist="1" userlist_position="right" smilies="1" send_button="1" loggedin_visible="1" guests_visible="1" avatars="1" counter="1"]'); 
                                ?>
<br style="clear:both" />
</div>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>