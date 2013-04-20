<?php
/**
 * Template Name: Show PHP
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
	float: left;
	margin-right: 1em;
	margin-bottom: 0.5em;
}

.user-list li,
.user-list ul {

	clear: both;
}

.user-list h3 {
	clear: none;
}
				</style>
<?php 

add_shortcode('group-list', 'my_group_list_shortcode');
function my_group_list_shortcode( $atts ) {
    // Get the global $wpdb object
    global $wpdb;

    // Extract the parameters and set the default
    extract ( shortcode_atts( array(
        'group' => 'No Group' // No Group is a defined user-group
        ), $atts ) );
    // The taxonomy name will be used to get the objects assigned to that group
    $taxonomy = 'user-group';

    // Use a dBase query to get the ID of the user group
    $userGroupID = $wpdb->get_var(
                    $wpdb->prepare("SELECT term_id
                        FROM {$wpdb->terms} t
                        WHERE t.name = %s", $group));
    // Now grab the object IDs (aka user IDs) associated with the user-group
    $userIDs = get_objects_in_term($userGroupID, $taxonomy);

    // Check if any user IDs were returned; if so, display!
    // If not, notify visitor none were found.
    $content = "";
    if ($userIDs) {
    	
        $content = "<header class='entry-header'><h1 class=\"entry-title\">".$group."</h1></header><div class='group-list'><ul>";

        foreach( $userIDs as $userID ) {
            $user = get_user_by('id', $userID);
            $content .= "<li>";
            $content .= get_avatar( $user->ID, 70 );
            $content .= "<h3><a href='". get_author_posts_url( $user->ID ) . "' class='more-info-icon'>" . $user->display_name . "</a></h3>";
            //$content .= "<p><a href='". get_author_posts_url( $user->ID ) . "' class='more-info-icon'>More info</a>";
            $content .= "<!-- add more here --></p>";
            $content .= "</li>";
        }
        $content .= "</ul></div>";
    } else {
        //$content =
        //"<div class='group-list group-list-none'>Returned no results</div>";

    }
    return $content;
}

add_shortcode('groups-list', 'my_groups_list_shortcode');
function my_groups_list_shortcode() {
    // Get the global $wpdb object
    global $wpdb;

    // Use a dBase query to get the ID of the user group
    $userGroupIDs = $wpdb->get_results(
                    $wpdb->prepare("SELECT name
                        FROM {$wpdb->terms} t"), ARRAY_A);

    foreach ($userGroupIDs as $i => $userGroupID) {
    	$userNames[] = $userGroupID["name"];
    }

    return $userNames;
}



$groupNames = my_groups_list_shortcode();

foreach ($groupNames as $i => $groupName) {
	echo my_group_list_shortcode(array(
		"group"=>$groupName));
}

foreach ($groupNames as $i => $groupName) {
	echo my_group_list_shortcode(array(
		"group"=>$groupName));
}

?>
<br style="clear:both" />
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>