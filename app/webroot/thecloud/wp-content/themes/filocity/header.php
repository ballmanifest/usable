<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html <?php language_attributes(); ?>>



<head>



<meta charset="<?php bloginfo( 'charset' ); ?>" />



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title><?php



	global $page, $paged;



	wp_title( '|', true, 'right' );



	bloginfo( 'name' );



	$site_description = get_bloginfo( 'description', 'display' );

	

	if ( $site_description && ( is_home() || is_front_page() ) )

		echo " | $site_description";



	if ( $paged >= 2 || $page >= 2 )

		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );



?></title>

<link href="<?php bloginfo( 'stylesheet_url' ); ?>" rel="stylesheet" type="text/css" />

<link href="<?php bloginfo('template_directory'); ?>/css/menu.css" rel="stylesheet" type="text/css" />

<script src="<?php bloginfo('template_directory'); ?>/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<link href="<?php bloginfo('template_directory'); ?>/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<?php



if ( is_singular() && get_option( 'thread_comments' ) )

	wp_enqueue_script( 'comment-reply' );



wp_head();



?>

</head>

<body>

<!-- side strip begins -->

<!-- side strip ends -->

	<!-- main container begins -->

<div class="main_container">

  <!--<div class="right_side_img"><?php //echo do_shortcode('[dcssb-link]'); ?></div>-->
  
  <div class="main_container2 clearfix">  

  	<!-- header begins -->

    <div class="header">

      <div class="logo"><a href="<?php echo site_url(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.jpg" alt="" width="318" height="68" border="0" /></a></div>

      <div class="header_right">

        <div class="top_navi">

          <?php wp_nav_menu( array( 'menu' => 'top-menu', 'menu_class'=> 'top_navi_1' ) );?>
          
        </div>

        <!-- AddThis Button BEGIN -->

            <div class="addthis_toolbox addthis_default_style" style="float: right; height: auto; margin: 0 10px 0 0; width: 170px;">

            <a class="addthis_button_preferred_1"></a>

            <a class="addthis_button_preferred_2"></a>

            <a class="addthis_button_preferred_3"></a>

            <a class="addthis_button_preferred_4"></a>

            <a class="addthis_button_compact"></a>

            <a class="addthis_counter addthis_bubble_style"></a>

            </div>

            <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-509e46e92fd11c77"></script>

            <!-- AddThis Button END -->

      </div>

      <div id="nav">

        <?php wp_nav_menu(array('menu' => 'main-menu'));?>

      </div>

    </div>

    <!-- header ends -->