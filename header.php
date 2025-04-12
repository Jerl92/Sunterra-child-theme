<?php
/**
 * The Header for our theme.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php global $current_user;
      wp_get_current_user(); ?>

<?php if (is_front_page())  { ?>

  <!-- #header -->
  <header id="header" class="clearfix" role="banner">

  <?php wp_nav_menu( array( 'theme_location' => 'header-top-menu', 'container_id' => 'top-menu-container' ) ); ?>

    <div class="ht-container-min">

      <div id="header-inner-logo-center-small" class="clearfix">
      <!-- #logo -->
        <div id="logo-center-small">
            <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">
            <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo get_theme_mod( 'st_site_logo' ); ?>" />
            </a>
            <div class="logo-center-small-dropdown-content">
              <a title="www.sunterrapc.com" href="http://sunterrapc.com">
                <img alt="<?php bloginfo( 'name' ); ?>" src="http://www.sunterrapc.com/images/colors/bridge/logo.png" />
              </a>
              <p class="logo-center-dropdown-content-info">Sunterrapc.com</p>
            </div>
        </div>
      <!-- /#logo -->

    </div>
  </div>

  <div class="ht-container">

  <div id="header-inner-logo-center" class="header-inner-margin clearfix">
  <!-- #logo -->
    <div id="logo-center">
        <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">
        <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo get_theme_mod( 'st_site_logo' ); ?>" />
        </a>
        <div class="logo-center-dropdown-content">
          <a title="www.sunterrapc.com" href="http://sunterrapc.com">
            <img alt="<?php bloginfo( 'name' ); ?>" src="http://www.sunterrapc.com/images/colors/bridge/logo.png" />
          </a>
          <p class="logo-center-dropdown-content-info">Sunterrapc.com</p>
        </div>
    </div>   
  <!-- /#logo -->


  </div>
  </div>
  </header>
  <!-- /#header -->

<?php } else { ?>

<?php if ( get_post_type( get_the_id() ) == 'nanosupport' ) {
  $term_list = wp_get_post_terms( get_the_id(), 'nanosupport_status', array("fields" => "all"));
  $get_term_color = get_term_meta( $term_list[0]->term_id, 'meta_color', true);
} ?>

<?php 
			$status_terms = get_terms( array(
				'taxonomy' => 'nanosupport_status',
				'hide_empty' => false,
			) );

			if ( $status_terms ) {
				foreach ( $status_terms as $status_term ) {
					if( isset( $_GET['status'] ) && $status_term->slug == $_GET['status'] ){
            $get_term_color = get_term_meta( $status_term->term_id, 'meta_color', true);
					} 
				}
      }
?>

<!-- #header -->
<header id="header" class="clearfix" role="banner" style="border-color: <?php echo $get_term_color; ?>">

  <?php wp_nav_menu( array( 'theme_location' => 'header-top-menu', 'container_id' => 'top-menu-container' ) ); ?>

<?php global $post; ?>

<div class="ht-container-min" style="border-color: <?php echo $get_term_color; ?>">

  <div id="header-inner" class="clearfix">
  <!-- #logo -->
    <div id="logo">
        <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">
        <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo get_theme_mod( 'st_site_logo' ); ?>" />
        </a>
    </div>
  <!-- /#logo -->


  <!-- #primary-nav -->
  <nav id="primary-nav" role="navigation" class="clearfix">
    <?php if ( has_nav_menu( 'primary-nav' ) ) { ?>
      <?php wp_nav_menu( array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'nav sf-menu clearfix' )); ?>
      <?php } else { ?>
	  <!--
    <ul>
      <?php echo wp_list_pages( array( 'title_li' => '' ) ); ?>
      </ul>
	  -->
    <?php } ?>
  </nav>
  <!-- #primary-nav -->


  </div>
</div>

<div class="ht-container">

<div id="header-inner" class="header-inner-margin clearfix">
<!-- #logo -->
  <div id="logo">
      <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">
      <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo get_theme_mod( 'st_site_logo' ); ?>" />
      </a>
  </div>
<!-- /#logo -->


<!-- #primary-nav -->
<nav id="primary-nav" role="navigation" class="clearfix">
  <?php if ( has_nav_menu( 'primary-nav' ) ) { ?>
    <?php wp_nav_menu( array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'nav sf-menu clearfix' )); ?>
     <?php } else { ?>
	<!--
	 <ul>
     <?php echo wp_list_pages( array( 'title_li' => '' ) ); ?>
    </ul>
-->
  <?php } ?>
</nav>
<!-- #primary-nav -->


</div>
</div>
</header>
<!-- /#header -->

<?php } ?>

<!-- #primary-nav-mobile -->
<nav id="primary-nav-mobile">
<a class="menu-toggle" href="#"><span><?php if (qtranxf_getLanguage() == 'en') { _e( 'Main Menu', 'supportdesk-child-theme' ); } else if (qtranxf_getLanguage() == 'fr') {  _e( 'Menu', 'supportdesk-child-theme' ); } ?></span></a>
<?php wp_nav_menu( array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'clearfix', 'menu_id' => 'mobile-menu', )); ?>
</nav>
<!-- /#primary-nav-mobile -->