<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php 
    global $page, $paged;

	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
		
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'newsmin' ), max( $paged, $page ) ); 
?></title>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>

<div class="wrapper">

<div class="header">

<div class="title">
<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
</div>



<div id="access" role="navigation">	

  <?php wp_nav_menu( array( 'container_class' => 'header-menu', 'theme_location' => 'header-menu'  ) ); ?>
</div>

<div class="middle">