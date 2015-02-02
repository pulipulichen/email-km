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
            
		<div id="content" role="main">
                    <article class="page type-page status-publish hentry user-list" style="min-width:90%;">
                        <!-- <p><iframe src="http://cloud-disk.dlll.nccu.edu.tw/?uid=<?php echo $user_login ?>" height="500" width="100%"></iframe></p>-->
                        <!--
                        <a href="http://cloud-disk.dlll.nccu.edu.tw/?uid=<?php echo $user_login ?>" target="cloud_disk" class="ui teal large button">新視窗開啟雲端硬碟</a>
            <ul>
                <li><a href="http://email-km.dlll.nccu.edu.tw/2015/01/ru-he-shi-yong-yun-duan-ying-die/"  target="_blank">雲端硬碟教學說明</a></li>
            </ul> -->
                        
<p><a class="ui teal large button" href="http://cloud-disk.dlll.nccu.edu.tw/?uid=<?php echo $user_login ?>" target="cloud_disk">新視窗開啟雲端硬碟</a></p>

<hr />

<h1>DLLL雲端硬碟(ownCloud)</h1>
<p><a href="http://owncloud.org/" target="_blank">ownCloud</a>，和DropBox非常非常類似，支援多種作業系統：如Mac OS, Linux, Windows, Android...也可以使用WebDAV的方式進行同步。由於測試的結果發現這套軟體的運作非常近似DropBox，且安裝過程較無痛苦，所以是此次最佳的學習範例。另外若企業有具備維護Linux系統的人才，可採用此套軟體簡化備份、並節省大量的建置成本。自第4版開始之後，新加入版本控制功能、檔案加密、還有免安裝Client以拖拉方式進行同步等許許多多的先進能力。。</p>
<p>網址：<a href="http://cloud-disk.dlll.nccu.edu.tw/">http://cloud-disk.dlll.nccu.edu.tw</a></p>
<p>帳號密碼由LDAP控管，<a href="http://email-km.dlll.nccu.edu.tw/2014/02/cloud-service-cloud-ldap-2014-dlll-nccu-edu-tw/">細節請看LDAP的設定</a>。</p>
<p><span style="color: #000000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 2em; font-weight: bold;">客戶端同步軟體安裝</span></p>
<p>Windows：請下載附件的<a href="http://email-km.dlll.nccu.edu.tw/wp-content/download.php?file=2014/02/1394191976-58193521.exe&amp;name=windows-ownCloud-1.5.2.2445-setup.exe">windows-ownCloud-1.5.2.2445-setup.exe</a></p>
<p>Android：請下載附件的<a href="http://email-km.dlll.nccu.edu.tw/wp-content/download.php?file=2014/02/1394191956-966504905.apk&amp;name=ownCloud-103000-MarketMilitia.apk">ownCloud-103000-MarketMilitia.apk</a> </p>
<p>連線位置：<a href="http://cloud-disk-2013.dlll.nccu.edu.tw:11580/">http://cloud-disk.dlll.nccu.edu.tw:11580</a> <span style="background-color: #ffff00;">(注意！一定要加上連接埠)</span></p>
<p>其他操作請看ownCloud的說明 <a href="https://owncloud.com/products/desktop-clients/">https://owncloud.com/products/desktop-clients/</a></p>
<hr />
<p>網管若要查看雲端硬碟的伺服器，請看這一篇 <a href="http://email-km.dlll.nccu.edu.tw/2014/02/cloud-service-cloud-disk-2013-dlll-nccu-edu-tw/">http://email-km.dlll.nccu.edu.tw/2014/02/cloud-service-cloud-disk-2013-dlll-nccu-edu-tw/</a>。</p>
                    </article>
                    
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>