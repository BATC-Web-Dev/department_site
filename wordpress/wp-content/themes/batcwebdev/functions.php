<?php
/**
 * BATCWebDev functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BATCWebDev
 */

 
 /*  hide worpress dashboard for subscribers  */
 add_action("user_register", "set_user_admin_bar_false", 10, 1);
 function set_user_admin_bar_false( $user_id ) {
	$user = get_userdata( $user_id );
	if ( in_array( 'subscriber', (array) $user->roles ) )  {
		update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
		update_user_meta( $user_id, 'show_admin_bar_admin', 'false' );
	}
 }
 
  /*  replace forum profile links with member home links  */
add_filter( 'bbp_get_author_link', 'remove_author_links', 10, 2);
add_filter( 'bbp_get_reply_author_link', 'remove_author_links', 10, 2);
add_filter( 'bbp_get_topic_author_link', 'remove_author_links', 10, 2);
function remove_author_links($author_link, $args) {
	$ini = strpos($author_link, 'user=') + 5;
	$linked_id = substr($author_link, $ini, 1);
	$linked_user = get_user_by('ID', $linked_id);
	$avatar = get_avatar( $linked_user->user_email, 20 );
	$name = $linked_user->display_name;
	if ($args[post_id] != 0){
		$replacement = "<form method='POST' action='?page_id=66'><button type='submit' class='text_button' name='view-profile' value='$linked_id'>$avatar$name</button></form>";
		$author_link = $replacement;
	}
	return $author_link;
 }
 

 /* add custom user meta data */
function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['user_url_2'] = 'Second Website';
	$profile_fields['user_url_3'] = 'Third Website';
	$profile_fields['user_job'] = 'Employment';
	$profile_fields['user_spec'] = 'Specialization';
	
	 return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');


 function custom_user_profile_fields($user){
    ?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_url_2">Second Website</label></th>
            <td>
                <input type="text" class="regular-text" name="user_url_2" value="<?php 
				echo esc_attr( get_the_author_meta( 'user_url_2', $user->ID ) ); ?>" id="user_url_2" /><br />
            </td>
        </tr>
		
		<tr>
            <th><label for="user_url_3">Third Website</label></th>
            <td>
                <input type="text" class="regular-text" name="user_url_3" value="<?php 
				echo esc_attr( get_the_author_meta( 'user_url_3', $user->ID ) ); ?>" id="user_url_3" /><br />
            </td>
        </tr>
		
		<tr>
            <th><label for="user_job">Employment</label></th>
            <td>
                <input type="text" class="regular-text" name="user_job" value="<?php 
				echo esc_attr( get_the_author_meta( 'user_job', $user->ID ) ); ?>" id="user_job" /><br />
            </td>
        </tr>
		
		<tr>
            <th><label for="user_spec">Specialization</label></th>
            <td>
                <select name="user_spec" value="<?php echo esc_attr( get_the_author_meta( 'user_spec', $user->ID ) ); ?>" id="user_spec" />
					<option value='Undecided'>Undecided</option>
					<option value='Front-End'>Front End</option>
					<option value='Back-End'>Back End</option>
				</select><br />
            </td>
        </tr>
		
		
    </table>
<?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
    # again do this only if you can
    if(!current_user_can('manage_options'))
        return false;

    # save my custom field
    update_usermeta($user_id, 'user_url_2', $_POST['user_url_2']);
    update_usermeta($user_id, 'user_url_3', $_POST['user_url_3']);
    update_usermeta($user_id, 'user_job', $_POST['user_job']);
    update_usermeta($user_id, 'user_spec', $_POST['user_spec']);
}
add_action('user_register', 'save_custom_user_profile_fields');
 
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
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/assets/css/bootstrap.min.css',array(),'3.3.7' );

    wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/assets/css/font-awesome.min.css',array(),'4.6.3' );


    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script( 'bootstrap-min-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '3.3.7', true );
    wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array(), '1.15.0', true );
    wp_enqueue_script( 'batcwebdev-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20120206', true );
    wp_enqueue_script( 'batcwebdev-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
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

add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {
    ob_start();
    wp_loginout('index.php');
    $loginoutlink = ob_get_contents();
    ob_end_clean();
    $items .= '<li>'. $loginoutlink .'</li>';     return $items; }

function my_custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'BATC Web and Mobile Developement';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function login_error_override()
{
    return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');

function admin_login_redirect( $redirect_to, $request, $user )
{
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) ) {
            return 'http://localhost:8888/wordpress/?page_id=62';
        } else {
            return 'http://localhost:8888/wordpress/?page_id=62';
        }
    }
    else
    {
        return $redirect_to;
    }
}
add_filter("login_redirect", "admin_login_redirect", 10, 3);

function login_checked_remember_me() {
    add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
}



