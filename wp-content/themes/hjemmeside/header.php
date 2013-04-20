<?php
global $post;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php wp_title() ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <?php wp_enqueue_style('themestyles', get_stylesheet_directory_uri() . '/style.css' ); ?>
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
        <!--[if IE 7]>
        <style type="text/css">.content_widget {height: 115px;}#headermenu li ul a {width: 140px;}</style>
        <![endif]-->
        <?php
	$text_color = get_header_textcolor();
	// If no custom options for text are set, let's bail.
	if ( $text_color != HEADER_TEXTCOLOR ) {
                ?>
                <style type="text/css">
                <?php
                        // Has the text been hidden?
                        if ( 'blank' != $text_color ) {
                ?>
                        #site-title a,
                        #site-description {
                                color: #<?php echo $text_color; ?> !important;
                        }
                <?php } ?>
                </style>
        <?php } ?>
        
        <?php wp_head(); ?>
    </head>
    <body <?php body_class( ); ?>>
        <div id="topbar"></div>
        <div class="pagewidth">
            <div id="header">
                <?php
                // Check to see if the header image has been removed
                $header_image = get_header_image();
                if ( $header_image ) {
                    // Compatibility with versions of WordPress prior to 3.4.
                    if ( function_exists( 'get_custom_header' ) ) {
                        // We need to figure out what the minimum width should be for our featured image.
                        // This result would be the suggested width if the theme were to implement flexible widths.
                        $header_image_width = get_theme_support( 'custom-header', 'width' );
                    } else {
                        $header_image_width = HEADER_IMAGE_WIDTH;
                    }
                    ?>
                    <a id="home-link-header" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        // Compatibility with versions of WordPress prior to 3.4.
                        if ( function_exists( 'get_custom_header' ) ) {
                            $header_image_width  = get_custom_header()->width;
                            $header_image_height = get_custom_header()->height;
                        } else {
                            $header_image_width  = HEADER_IMAGE_WIDTH;
                            $header_image_height = HEADER_IMAGE_HEIGHT;
                        }
                        ?>
                        <img src="<?php header_image(); ?>" height="49" alt="" />
                    </a>
                <?php } ?>
                <?php if ( 'blank' != get_header_textcolor() ) { ?>
                    <h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
                    <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
                <?php } ?>
            </div>
            <div class="clearboth"></div>
            <div id="sidebar_venstre">
                <div class="i123_widget">
                    <div class="i123_sidemenu_widget">
                        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                    </div>
                </div>
                <div id="belowsidebarmenu_widgets">
                    <?php dynamic_sidebar( 'sidebar_venstre' ); ?>
                </div>
            </div>
            <div id="contentarea">
                <div class="clearboth"></div>
                <div class="padding20" id="contentbg">