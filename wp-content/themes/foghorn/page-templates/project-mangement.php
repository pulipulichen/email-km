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
                            <h1><?php echo get_the_title(); ?></h1>
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
$postslist = get_posts( $args );

$project_tags = array();
$skip_tags = array(
    'email', 'closed'
);

//print_r($postslist);



foreach ($postslist AS $key => $post) {
    //echo $post->ID;
    $tags = wp_get_post_tags($post->ID);
    //print_r($tags);
    
    $date = substr ( $post->post_modified_gmt, 0, 10 );
    $date = str_replace('-', '', $date);
    $date = intval($date);
    //echo $date . '<br />';
    
    $author = $post->post_author;
    
    $filtered_tags = array();
    $post_type = 'open';
    if (substr($post->post_title, 0, 4) === 'Re: ') {
        $post_type = 'other';
    }
            
    foreach ($tags AS $tags_key => $tag) {
        $tag_name = $tag->name;
        
        if ($tag_name === 'closed') {
            $post_type = 'closed';
        }
        
        if (in_array($tag_name, $skip_tags)
                || is_email($tag_name)) {
            continue;
        }
        
        if (isset($project_tags[$tag_name]) === FALSE) {
            $project_tags[$tag_name] = array(
                "open" => array(),
                "closed" => array(),
                "other" => array(),
                'last_modify_date' => $date,
                'authors' => array()
            );
        }
        
        if ($project_tags[$tag_name]['last_modify_date'] < $date) {
            $project_tags[$tag_name]['last_modify_date'] = $date;
        }
        
        if ($tag_name !== 'closed') {
            $filtered_tags[] = $tag;
        }
    }   //foreach ($tags AS $tags_key => $tag) {
    
    foreach ($filtered_tags AS $tags_key => $tag) {
        $tag_name = $tag->name;
        $project_tags[$tag_name][$post_type][] = $post->ID;
        
        if (isset($project_tags[$tag_name]['authors'][$author]) === false) {
            $project_tags[$tag_name]['authors'][$author] = 1;
        }
        else {
            $project_tags[$tag_name]['authors'][$author]++;
        }
    }
}

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
    
    $last_modified_data = strval($project_tag['last_modify_date']);
    $last_modified_data_year = substr($last_modified_data, 0, 4);
    $last_modified_data_month = substr($last_modified_data, 4, 2);
    $last_modified_data_day = substr($last_modified_data, 6, 2);
    $last_modified_data = $last_modified_data_year.'-'.$last_modified_data_month.'-'.$last_modified_data_day;
    
    // ------
    
    $avatars = '';
    foreach ($project_tag['authors'] AS $author_id => $author_count) {
        $author_name = get_the_author_meta( 'nickname', $author_id );
        $author_avatar = get_avatar( $author_id, '22');
        
        $href = '/author/' . urlencode($author_name) . '/?cat=' . urlencode($cat) . '&tag=' . urlencode($key);
        
        $author_avatar = '<a class="ui image label" href="' . $href . '">
                     '. $author_avatar . ' ' . $author_name 
                . '<div class="detail">' . $author_count .'</div>
                  </a> ';
        $avatars .= $author_avatar;
    }
    
    // ------
    
    $progress = (count($project_tag['closed']) / (count($project_tag['closed']) + count($project_tag['open'])));
    $progress = intval($progress * 100);
    
    $progress_type = '';
    if ($progress > 90) {
        $progress_type = 'green';
    }
    else if ($progress > 70) {
        $progress_type = 'teal';
    }
    else if ($progress > 50) {
        $progress_type = 'yellow';
    }
    else if ($progress > 30) {
        $progress_type = 'purple';
    }
    
    ?>
      <tr>
          <!-- 專案標題 -->
          <td><a href="/tag/<?php echo urlencode($key); ?>/?cat=<?php echo urlencode($cat); ?>"><?php echo $key; ?> </a></td>
          
          <!-- 最近更新日期 -->
          <td data-sort-value="<?php echo $project_tag['last_modify_date']; ?>" class="center aligned"><?php echo $last_modified_data; ?></td>
          
          <!-- 參與成員 -->
          <td><?php echo $avatars; ?></td>
          
          <!-- 未完任務 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['open']); ?>">
              <a class="ui label" href="/?tag=<?php echo urlencode($key); ?>">
                <i class="radio icon"></i> <?php echo count($project_tag['open']); ?>
              </a>
          </td>
          
          <!-- 完成任務 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['closed']); ?>">
              <?php 
              if (count($project_tag['closed']) > 0) {
                  ?>
                  <a class="ui label" href="/?tag=<?php echo urlencode($key); ?>+closed">
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
              
              
          </td>
          <!-- 其他討論 -->
          <td class="center aligned" data-sort-value="<?php echo count($project_tag['other']); ?>">
              <div class="ui label">
                <i class="comment  icon"></i> <?php echo count($project_tag['other']); ?>
              </div>              
          </td>
          
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