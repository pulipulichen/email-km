<?php
/*
 * Plugin Name: Simple post listing
 * Description: List a subset of your posts using the shortcode [postlist].
 * Version: 0.2
 * Author: Samuel Coskey
 * Author URI: http://boolesrings.org
*/

/*
 * The shortcode which shows a list of future events.
 * Usage example:
 * [postlist category="talks" text="excerpt"]
*/
add_shortcode( 'postlist', 'posts_loop' );

function posts_loop( $atts ) {
	global $more;
	global $post;

	// Arguments to the shortcode
	extract( shortcode_atts(  array(
		'category' => '',
        	'category_name' => '',
		'tag' => '',
		'style' => 'list',
		'text' => 'none',
		'more_text' => ' ...',
		'null_text' => '(none)',
		'class_name' => '',
		'show_date' => '',
		'date_format' => get_option('date_format'), // I recommend 'F j, Y'
		'q' => '',
	), $atts ) );

	/*
	 * sanitize the input a little bit
	*/
	if ( $category_name && !$category ) {
		$category = $category_name; // support old name for option
	}
	if ( $style != "list" && $style != "post" ) {
		$style = "list";
	}
	if ( $text != "none" && $text != "excerpt" && $text != "normal" ) {
		$text = "none";
	}
	if ( $q ) {
		$q = str_replace ( "&#038;", "&", $q );
	}

	/*
	 * query the database for the posts with EventDate in the future
	 * query syntax:
	 * http://codex.wordpress.org/Class_Reference/WP_Query#Parameters
	*/
	$query = "";
	$query .= 'ignore_sticky_posts=1&posts_per_page=-1';
	if ( $category ) {
		$query .= '&' . "category_name=" . $category;
	}
	if ( $tag ) {
		$query .= '&' . "tag=" . $tag;
	}
	if ( $q ) {
		$query .= "&" . $q;
	}
	$query_results = new WP_Query($query);

	if ( $query_results->post_count == 0 ) {
		return "<p>" . wp_kses($null_text,array()) . "</p>\n";
	}
	
	// building the output
	$ret_val = "<ul class='post-listing post-listing-$style";
	if ( $class_name ) {
		$ret_val .= " " . $class_name;
	}
	$ret_val .= "'>\n";
	while ( $query_results->have_posts() ) {
		$query_results->the_post();
		$ret_val .= "<li class='";
		foreach((get_the_category()) as $category) {
			$ret_val .= "category-" . $category->slug . " ";
		}
		$ret_val .= "'>";
		if ( $style == "post" ) {
			$ret_val .= "<h2 class='post-listing-entry-title'>";
		}
		if ( $show_date ) {
			$ret_val .= "<span class='post-listing-date'>";
			$ret_val .= get_the_date($date_format);
			$ret_val .= "</span>";
			$ret_val .= "<span class='post-listing-date-sep'>: </span>\n";
		}
		$ret_val .= "<a href='" . get_permalink() . "'>";
		$ret_val .= the_title( '', '', false);
		$ret_val .= "</a>";
		if ( $style == "post" ) {
			$ret_val .= "</h2>";
		}
		$ret_val .= "\n";
		if ( $text == "excerpt" ) {
			$ret_val .= "<div>\n";
			$override_excerpt = function()use($more_text){return $more_text;};
			add_filter ( 'excerpt_more', $override_excerpt );
			$ret_val .= apply_filters( 'the_content', wp_trim_excerpt($post->post_excerpt) );
			remove_filter ( 'excerpt_more', $override_excerpt );
			$ret_val .= "</div>\n";
		} elseif ( $text == "normal" ) {
			$ret_val .= "<div>\n";
			$more = 0; // Tell wordpress to respect the [more] tag for the next line:
			$ret_val .= apply_filters( 'the_content', get_the_content($more_text) );
			$ret_val .= "</div>\n";
		}
		$ret_val .= "</li>\n";
	}
	wp_reset_postdata();
	$ret_val .= "</ul>\n";

	return $ret_val;
}

/*
 * Load our default style sheet
*/
add_action( 'wp_print_styles', 'enqueue_post_listing_styles' );
function enqueue_post_listing_styles() {
	wp_register_style( 'simple-post-listing-styles',
		   plugins_url('simple-post-listing-styles.css', __FILE__) );
	wp_enqueue_style( 'simple-post-listing-styles' );
}

?>