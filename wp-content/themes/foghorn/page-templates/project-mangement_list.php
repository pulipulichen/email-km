<?php
/**
 * Template Name: Project Management List
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
if (isset($_GET['project_tag']) === false) {
    //header("Location: /project-management");
}
$project_tag = $_GET['project_tag'];
$project_tag = '測試專案';

$list_type = 'open';
if (isset($_GET['project_type'])) {
    $list_type = $_GET['project_type'];
}

$args = array(
    'posts_per_page' => -1,
    'tag' => $project_tag,
    
);


include_once './wp-content/themes/foghorn/project-management/count_project_tags.php';
$project_tags = count_project_tags($args);
$project = array_pop($project_tags);
$project = filter_project_tag($project, '專案', $project_tag);

if ($list_type === 'open') {
    //echo '111';
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => 'closed',
            'operator' => 'NOT IN'
        ),
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => 'reply',
            'operator' => 'NOT IN'
        ),
    );
}
else if ($list_type === 'closed') {
    $args['tag_slug__and'] = array('closed');
}
else if ($list_type === 'other') {
    $args['tag_slug__and'] = array('reply');
}

query_posts( $args );

// ------------------

$progress = $project['progress'];
$progress_type = $project['progress_type'];

get_header(); ?>

<div id="submain">
    
	<div id="primary" class="site-content">
			<div id="content" role="main">
            
            	<?php the_post(); ?>

                <header class="page-header">
<div class="ui action input" style='float: right;'>
  <input type="text" placeholder="新增任務..."  id='new_project_name'>
  <div class="ui icon button" onclick="add_new_project()"><i class="write icon"></i></div>
  <script>
  function add_new_project() {
      var _name = document.getElementById('new_project_name').value;
      location.href = '/wp-admin/post-new.php?post_title=' + encodeURI(_name) + '&category=<?php echo urlencode($cat); ?>&tags=<?php echo urlencode($project_tag); ?>';
  }
  </script>
</div>
                        <a class="page-title" href='/project-management'><?php
                                printf( __( ' Category: %s', 'foghorn' ), '<span>專案管理</span>' );
                        ?></a>
    <h1 class="page-title ui header">
        <div style="float:right">
            <?php echo $project['avatars']; ?></div>
  <i class="browser icon"></i>
  <div class="content">
      
    <?php echo single_tag_title( '', false ); ?>
      
      <div class="subheading" style="width: 300px;">
      <div class="ui <?php echo $progress_type; ?> small progress" data-percent="<?php echo $progress; ?>" style="margin-bottom: 0;">
        <div class="bar" style="width: <?php echo $progress; ?>%">
            <div class="progress"><?php echo $progress; ?>%</div>
        </div> 
      </div>  
      </div>
  </div></h1>
                </header>
<div class="ui menu">
  <a class="<?php if ($list_type==='open') echo 'active'; ?> red item" href='?project_tag=<?php urlencode($project_tag) ?>&project_type=open'>
      <i class="radio icon"></i>
      未完任務
      <?php
      if (count($project['open']) > 0) {
          ?>
            <div class="ui red label"><?php echo count($project['open']); ?></div>
          <?php
      }
      else {
          ?>
            <div class="ui label"><?php echo count($project['open']); ?></div>
          <?php
      }
      ?>
  </a>
  <a class="<?php if ($list_type==='closed') echo 'active'; ?> green item" href='?project_tag=<?php urlencode($project_tag) ?>&project_type=closed'>
      <i class="check circle icon"></i>
      完成任務
      <?php
      if (count($project['closed']) > 0) {
          ?>
            <div class="ui teal label"><?php echo count($project['closed']); ?></div>
          <?php
      }
      else {
          ?>
            <div class="ui label"><?php echo count($project['closed']); ?></div>
          <?php
      }
      ?>
      
  </a>
    <a class="<?php if ($list_type==='other') echo 'active'; ?> item" href='?project_tag=<?php urlencode($project_tag) ?>&project_type=other'>
      <i class="comment icon"></i>
      其他討論
      <div class="ui label"><?php echo count($project['other']); ?></div>
  </a>
</div>
                <?php rewind_posts(); ?>

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'content', 'project-task' ); ?>

                <?php endwhile; ?>
                            
                <?php 
                if ($list_type === 'open' && count($project['open']) === 0) {
                    ?>
<h2 class="ui center aligned icon header">
  <i class="star yellow icon"></i>
  所有任務都完成了！太棒了！
</h2>
                            <?php
                }
                else if ($list_type === 'closed' && count($project['closed']) === 0) {
                    ?>
<h2 class="ui center aligned icon teal header">
  <i class="thumbs up icon"></i>
  還沒有任務完成，但你可以做得到！
</h2>
                            <?php
                }
                ?>

                <?php foghorn_content_nav( 'nav-below' ); ?>

			</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>