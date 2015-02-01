<?php
/**
 * Template Name: Project Management
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

$cat =  '專案';

get_header(); ?>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.tablesorter.min.js"></script>

<div id="submain">
    
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<article>
                            <h1 class='ui header'>
                                
<div class="ui action input" style='float: right;'>
  <input type="text" placeholder="新增專案名稱..."  id='new_project_name'>
  <div class="ui icon button" onclick="add_new_project()"><i class="write icon"></i></div>
  <script>
  function add_new_project() {
      var _name = document.getElementById('new_project_name').value;
      location.href = '/wp-admin/post-new.php?tags=' + encodeURI(_name) + '&category=<?php echo urlencode($cat); ?>';
  }
  </script>
</div>
                                <div class="content"><?php echo get_the_title(); ?>
                                    <a class='sub header' href='http://email-km.dlll.nccu.edu.tw/2015/02/ru-he-shi-yong-zhuan-an-guan-li-gong-neng/' style='display:block'>
                                        <i class='help circle icon'></i>專案管理使用教學
                                    </a>
                                </div>
                            </h1>
<?php
$args = array(
        'posts_per_page' => -1,
        'category' => '793',
	//'tax_query' => array(
            
            //'genre' => 'projects',
            //'post_status' => 'publish',
            //'post_type'      => 'post',
//                array(
//			'taxonomy' => 'genre',
//			'field' => 'slug',
//			'terms' => '專案'
//		),
	//)
);

include_once './wp-content/themes/foghorn/project-management/count_project_tags.php';

$project_tags = count_project_tags($args);

// -------------------------

?>
                            
<table class="ui striped sortable celled table">
  <thead>
    <tr>
      <th class="center aligned">專案標題</th>
      <th class="center aligned">最近更新日期</th>
      <th class="center aligned">參與成員</th>
      <th class="center aligned">未完任務</th>
      <th class="center aligned">完成任務</th>
      <th class="center aligned">其他討論</th>
      <th class="center aligned">進度</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($project_tags AS $key => $project_tag) {
    
    $project_tag = filter_project_tag($project_tag, $cat, $key);
    $last_modified_date_string = $project_tag['last_modify_date_string'];
    $avatars = $project_tag['avatars'];
    $progress = $project_tag['progress'];
    $progress_type = $project_tag['progress_type'];
    
    
    ?>
      <tr>
          <!-- 專案標題 -->
          <td><a href="/tag/<?php echo urlencode($key); ?>/?cat=<?php echo urlencode($cat); ?>"><?php echo $key; ?> </a></td>
          
          <!-- 最近更新日期 -->
          <td data-sort-value="<?php echo $project_tag['last_modify_date']; ?>" class="center aligned"><?php echo $last_modified_date_string; ?></td>
          
          <!-- 參與成員 -->
          <td><?php echo $avatars; ?></td>
          
          <!-- 未完任務 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['open']); ?>">
              <?php 
              if (count($project_tag['open']) > 0) {
                  ?>
                  <a class="ui red label" href="/project-management-list?project_tag=<?php echo urlencode($key); ?>&project_type=open">
                    <i class="radio icon"></i> <?php echo count($project_tag['open']); ?>
                  </a>
                  <?php
              }
              else {
                  ?>
                  <div class="ui label">
                    <i class="radio icon"></i> <?php echo count($project_tag['open']); ?>
                  </div>
                  <?php
              }
              ?>
              <a class="mini ui icon button" href="/wp-admin/post-new.php?tags=<?php echo urlencode($key); ?>&category=<?php echo urlencode($cat); ?>">
                <i class="write icon"></i>
              </a>
          </td>
          
          <!-- 完成任務 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['closed']); ?>">
              <?php 
              if (count($project_tag['closed']) > 0) {
                  ?>
                  <a class="ui teal label" href="/project-management-list?project_tag=<?php echo urlencode($key); ?>&project_type=close">
                    <i class="check circle icon"></i> <?php echo count($project_tag['closed']); ?>
                  </a>
                  <?php
              }
              else {
                  ?>
                  <div class="ui label">
                    <i class="check circle icon"></i> <?php echo count($project_tag['closed']); ?>
                  </div>
                  <?php
              }
              ?>
              <a class="mini ui icon button" href="/wp-admin/post-new.php?tags=<?php echo urlencode($key); ?>,closed&category=<?php echo urlencode($cat); ?>">
                <i class="write icon"></i>
              </a>
              
          </td>
          <!-- 其他討論 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['other']); ?>">
              <a class="ui label" href="/project-management-list?project_tag=<?php echo urlencode($key); ?>&project_type=other">
                <i class="comment icon"></i> <?php echo count($project_tag['other']); ?>
              </div>              
          </a>
          
          <!-- 進度 -->
          <td data-sort-value="<?php echo $progress; ?>">
              <div class="ui <?php echo $progress_type; ?> progress" data-percent="<?php echo $progress; ?>" style="margin-bottom: 0;">
                    <div class="bar" style="width: <?php echo $progress; ?>%">
                        <div class="progress"><?php echo $progress; ?>%</div>
                    </div> 
                </div>  
          </td>
      </tr>
    <?php
    
}

//echo count($postslist);
//print_r($postslist);
//echo count($postslist);
//foreach ($postslist as $key => $id ) {
//    echo $id;
//}

//$myposts = new WP_Query(array( 'category__in' => array( 793 ) ));
//while($myposts->has_posts()) { 
//     echo 1;
//     break;
//    //$myposts->the_post();
//    //... do all the normal loop here ...
//}

?>
  </tbody>
</table>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>

                            <script>
                                //$(document).ready(function() {
                                    $('.sortable.table').tablesorter({
                                        'cssAsc': 'ascending',
                                        'cssDesc': 'descending',
                                    });
                                //});
                            </script>
<?php get_footer(); ?>