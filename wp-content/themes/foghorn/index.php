<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Foghorn
 */
/*
$text = '<a href="mailto:98306044@nccu.edu.tw">121</a>查看「20130618版proposal 送存Km 系統」討論文章
布丁學長:
我是參考下列資訊,所設 e-mail ,下次我會用  dlll.email.km@gmail.com
 
http://email-km.dlll.nccu.edu.tw/wp-admin/post.php?post=467&action=edit
 
 
 
 
Dear 薏婷，
 
對了，為什麼妳會用「email.km@dlll.nccu.edu.tw」這個信箱？
因為我哪邊寫錯了嗎？
2013/7/4 Pulipuli Chen <pulipuli.chen@gmail.com>
Dear 薏婷，
 
信件記錯人了
是「dlll.email.km@gmail.com」
Pulipuli Chen <pulipuli.chen@gmail.com> 於 2013年7月4日上午12:36 寫道：
Dear 薏婷，
 
標題的關鍵字的「#」前面要加空格喔
 
妳原本是：「20130618版proposa 送存Km 系統l#論文#proposal」
應該改成「20130618版proposal 送存Km 系統 #論文 #proposal」
 
注意「#」字號之前的空格
 
101155012 <101155012@nccu.edu.tw> 於 2013年7月3日下午7:55 寫道：
布丁學長:   20130618版proposa ,報告檔放入km

薏婷

 




 
–

***************************************************
Yung-Ting Chen
 
PhD Student of Graduate Institute of Library, Information and Archival Studies
National Chengchi University
E-mail: pudding@nccu.edu.tw
Telephone: +886-2-29393091 Ext. 62955
***************************************************
 
#te11st #aferaa

 
–

***************************************************
Yung-Ting Chen
 
PhD Student of Graduate Institute of Library, Information and Archival Studies
National Chengchi University
E-mail: pudding@nccu.edu.tw
Telephone: +886-2-29393091 Ext. 62955
***************************************************
 
#tes2t #aaa1
 
–

***************************************************
Yung-Ting Chen #tqwest #aqweaa
 #dfdtest #acvaa
PhD Student of Graduate Institute of Library, Information and Archival Studies
National Chengchi University #test #aaa
E-mail: pudding@nccu.edu.tw
Telephone: +886-2-29393091 Ext. 62955
***************************************************
(2)'; 

//echo filter_var($text, FILTER_VALIDATE_EMAIL);
//echo $text;

function extract_email_address ($string) {
    foreach(preg_split('/\s/', $string) as $token) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
            
            //再過濾
            //echo $email . " || ";
            if (strpos($email, 'mailto')) {
                $email = substr($email, strpos($email, 'mailto') + 6);
            }
            
            //取最後
            //echo strrpos($email, '.tw');
            if (strrpos($email, '.tw') > 0) {
                $email = substr($email, 0, strrpos($email, '.tw') + 3);
            }
            if (strrpos($email, '.com')) {
                $email = substr($email, 0, strrpos($email, '.com') + 4);
            }
            if (strrpos($email, '.org')) {
                $email = substr($email, 0, strrpos($email, '.org') + 4);
            }
            if (strrpos($email, '.net')) {
                $email = substr($email, 0, strrpos($email, '.net') + 4);
            }
            
            $emails[] = $email;
            //echo $email . " | ";
        }
    }
    
    //去除重複的email
    $emails = array_unique ($emails);
    
    return $emails;
}

//var_dump(extract_email_address($text));

$tag_list = array();

$content = $text;
    $content = strip_tags($content);
    $lines = explode("\n", $content);
    foreach ($lines AS $line) {
        $line = trim($line);
        while (strpos($line, "#") === 0) {
            $space = strpos($line, " ");
            if ($space > 0) {
                $tag = substr($line, 1, $space - 1);
                array_push($tag_list, $tag);
                $line = substr($line, $space + 1);
            }
            else {
                $tag = substr($line, 1);
                array_push($tag_list, $tag);
                break;
            }
        }
    }

    var_dump($tag_list);
    */
get_header(); ?>
 <?php ResponsiveColumnWidgets(); ?>
<div id="submain">
		<div id="primary">
                        
                   
			<div id="content" role="main">
           		<?php foghorn_content_nav( 'nav-above' ); ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'index' ); ?>

				<?php endwhile; ?>

				<?php foghorn_content_nav( 'nav-below' ); ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php if ( of_get_option('layout','layout-2cr') != 'layout-1c') {
	get_sidebar();
} ?>
        </div>
<?php get_footer(); ?>