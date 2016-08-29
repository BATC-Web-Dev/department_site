<?php
/**
 * BATCWebDev functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BATCWebDev
 */

 
 
 /**
*  Subscriber profile page functions
*
*/
add_action( 'personal_options_update', 'save_custom_profile_fields' );
add_action( 'edit_user_profile_update', 'save_custom_profile_fields' );
function save_custom_profile_fields( $user_id ) {
    update_user_meta( $user_id, 'approve_first_name', $_POST['approve_first_name'], get_user_meta( $user_id, 'approve_first_name', true ) );
    update_user_meta( $user_id, 'approve_last_name', $_POST['approve_last_name'], get_user_meta( $user_id, 'approve_last_name', true ) );
    update_user_meta( $user_id, 'approve_nickname', $_POST['approve_nickname'	], get_user_meta( $user_id, 'approve_nickname', true ) );
    update_user_meta( $user_id, 'approve_display_name', $_POST['approve_display_name'], get_user_meta( $user_id, 'approve_display_name', true ) );
    update_user_meta( $user_id, 'approve_user_email', $_POST['approve_user_email'], get_user_meta( $user_id, 'approve_user_email', true ) );
    update_user_meta( $user_id, 'approve_user url', $_POST['approve_user url'], get_user_meta( $user_id, 'approve_user url', true ) );
    update_user_meta( $user_id, 'approve_user url_2', $_POST['approve_user url_2'], get_user_meta( $user_id, 'approve_user url_2', true ) );
    update_user_meta( $user_id, 'approve_user url_3', $_POST['approve_user url_3'], get_user_meta( $user_id, 'approve_user url_3', true ) );
    update_user_meta( $user_id, 'approve_description', $_POST['approve_description'], get_user_meta( $user_id, 'approve_description', true ) );
	// update_user_meta( $user_id, '', $_POST[''], get_user_meta( $user_id, '', true ) );
}


function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['approve_first_name'] = 'Approve First Name';
	$profile_fields['approve_last_name'] = 'Approve Last Name';
	$profile_fields['approve_nickname'] = 'Approve Nickname';
	$profile_fields['approve_display_name'] = 'Approve Display Name';
	$profile_fields['approve_user_email'] = 'Approve Email Address';
	$profile_fields['approve_user url'] = 'Approve Primary Website Address';
	$profile_fields['approve_user_url_2'] = 'Approve Second Website Address';
	$profile_fields['approve_user_url_3'] = 'Approve Third Website Address';
	$profile_fields['approve_description'] = 'Approve Biographical Information';
	

	// return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
 
 
if ( ! function_exists( 'batcwebdev_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
require_once('inc/wp_bootstrap_navwalker.php');
function batcwebdev_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on BATCWebDev, use a find and replace
	 * to change 'batcwebdev' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'batcwebdev', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary', 'batcwebdev' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'batcwebdev_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'batcwebdev_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function batcwebdev_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'batcwebdev_content_width', 640 );
}
add_action( 'after_setup_theme', 'batcwebdev_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function batcwebdev_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'batcwebdev' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'batcwebdev' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'batcwebdev_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function batcwebdev_scripts() {
    wp_enqueue_style( 'batcwebdev-style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css',array(),'3.3.7' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome-4.6.3/css/font-awesome.min.css',array(),'4.6.3' );

    if( !is_admin()){
        wp_deregister_script( 'jquery' );
        wp_register_script('jquery', get_template_directory_uri().'/js/jquery.min.js', false,'3.1.0',true);
        wp_enqueue_script('jquery');
    }
    wp_enqueue_script( 'bootstrap-min-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.7', true );
    wp_enqueue_script( 'batcwebdev-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
    wp_enqueue_script( 'batcwebdev-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    #wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom-js.js', array(), '1.0', true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'batcwebdev_scripts' );

remove_filter('the_content', 'wpautop');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'batcwebdev' ),
) );

function addClassesToNewUser($user_id) {
//Write function to loop through all the available classes and set the new user id and finished
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM class");
    foreach ($result as $row){
        $wpdb->insert(
            'classes',
            array(
                'user_id' => $user_id,
                'class_id' => $row->ID,
                'finished' => 0,
            ),
            array(
                '%d',
                '%d',
                "%d",
            )
        );
    }
}
add_action('user_register', 'addClassesToNewUser', 10, 1);




