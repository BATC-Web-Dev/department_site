<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Test_Underscores_Based_Theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
<!-- Stylesheets for Bootstraps from Bootstraps Static Homepage -->
<link rel="stylesheet" href="http://localhost:8888/wordpress/wp-content/themes/batc-web-mobile-development/css/bootstrap.min.css">
<link rel="stylesheet" href="http://localhost:8888/wordpress/wp-content/themes/batc-web-mobile-development/css/styles.css">
<title><?php wp_title()?></title>
    
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<!---------------------------------- NAVIGATION ----------------------------------->

<nav class="navbar navbar-inverse">
  <div class="container-fluid">

    <div class="navbar-header">
      <a href="#" class="navbar-brand"><?php bloginfo( 'name' ); ?></a>
    </div><!-- navbar-header-->

    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">About</a></li>
      <li><a href="#">Classes</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Resources</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Login</a></li>
    </ul>
  </div><!-- container -->
</nav>

    
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'batc-web-mobile-development' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">

            <!-- Comment out original default underscores theme header info
            <?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>

        </div>--><!-- .site-branding -->

<!-- Comment out original default underscores theme header nav
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'batc-web-mobile-development' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->

        </header><!-- #masthead -->

	<div id="content" class="site-content">
