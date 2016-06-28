<?php
/**
 * TELMA RH functions and definitions
 *
 * @package TELMARH
 */

require_once( get_template_directory() . '/inc/constante.inc.php' );
require_once( get_template_directory() . '/inc/default.config.php' );
require_once( get_template_directory() . '/inc/utils/functions.php' );
require_once( get_template_directory() . '/login.php' );
//classes de service
require_once_files_in( get_template_directory() . '/inc/classes/posttype' );
require_once_files_in( get_template_directory() . '/inc/classes/taxonomy' );
require_once_files_in( get_template_directory() . '/inc/classes/user' );

if (is_admin()){
  require_once( get_template_directory() . '/admin-functions.php' );

  /*** Theme Option ***/
  if ( is_dir( get_template_directory() . '/theme-options' ) ){
    require get_template_directory() . '/theme-options/theme-options.php';
  }
}
global $telmarh_options;
$telmarh_options = get_option( 'telmarh_theme_options' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'telmarh_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function telmarh_setup() {

    require_once_files_in( get_template_directory() . '/inc/extends/custom-role' );
    require_once_files_in( get_template_directory() . '/inc/extends/custom-types' );
    require_once_files_in( get_template_directory() . '/inc/extends/custom-taxonomies' );

	/* Make telmarh available for translation.
	 * Translations can be added to the /languages/ directory.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	load_theme_textdomain( 'telmarh', get_template_directory() . '/languages' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'telmarh-blog-archive', 800, 250, array( 'center', 'center' ) );
	add_image_size( 'telmarh-home-blog', 400, 250, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'telmarh' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'telmarh_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // telmarh_setup
add_action( 'after_setup_theme', 'telmarh_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */

/**
 * Enqueue scripts and styles.
 */
function telmarh_scripts() {
	wp_enqueue_style( 'telmarh-style', get_stylesheet_uri() );

	wp_enqueue_style( 'telmarh-slick', get_template_directory_uri() . '/css/slick.css' );

	wp_enqueue_style( 'telmarh-animate', get_template_directory_uri() . '/css/animate.css' );
	
	wp_enqueue_style( 'telmarh-menu', get_template_directory_uri() . '/css/jPushMenu.css' ); 
	
	wp_enqueue_style( 'telmarh-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.css' );
	
	$headings_font = esc_html(get_theme_mod('headings_fonts'));
	$body_font = esc_html(get_theme_mod('body_fonts'));
	
	if( $headings_font ) {
		wp_enqueue_style( 'telmarh-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );	
	} else {
		wp_enqueue_style( 'telmarh-source-sans', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600');   
	}	
	if( $body_font ) {
		wp_enqueue_style( 'telmarh-body-fonts', '//fonts.googleapis.com/css?family='. $body_font ); 	
	} else {
		wp_enqueue_style( 'telmarh-source-body', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600');  
	}

	wp_enqueue_script( 'telmarh-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'telmarh-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'telmarh-parallax', get_template_directory_uri() . '/js/parallax.js', array('jquery'), false, false );

	wp_enqueue_script( 'telmarh-menu', get_template_directory_uri() . '/js/jPushMenu.js', array('jquery'), false, true );

	wp_enqueue_script( 'telmarh-slick', get_template_directory_uri() . '/js/slick.js', array('jquery'), false, true );
	
	wp_enqueue_script( 'telmarh-added-panel', get_template_directory_uri() . '/js/panel-class.js', array('jquery'), false, true ); 
	
	if ( get_theme_mod('telmarh_sticky_active') != 1 ) { 

	wp_enqueue_style( 'telmarh-header-css', get_template_directory_uri() . '/css/headhesive.css' ); 
	wp_enqueue_script( 'telmarh-headhesive', get_template_directory_uri() . '/js/headhesive.js', array('jquery'), false, true );
	wp_enqueue_script( 'telmarh-sticky-head', get_template_directory_uri() . '/js/sticky-head.js', array('jquery'), false, true );
	
	}
	
	if ( get_theme_mod('telmarh_animate') != 1 ) {

	wp_enqueue_script( 'telmarh-animate', get_template_directory_uri() . '/js/animate-plus.js', array('jquery'), false, true );
	
	}

	wp_enqueue_script( 'telmarh-scripts', get_template_directory_uri() . '/js/telmarh.scripts.js', array('jquery'), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'telmarh_scripts' );

/**
 * Load html5shiv
 */
function telmarh_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'telmarh_html5shiv' );

/**
 * Change the excerpt length
 */
function telmarh_excerpt_length( $length ) {
	
	$excerpt = esc_attr( get_theme_mod('exc_length', '50')); 
	return $excerpt; 

}

add_filter( 'excerpt_length', 'telmarh_excerpt_length', 999 ); 

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
require get_template_directory() . '/inc/rows.php'; 
require get_template_directory() . '/inc/telmarh-styles.php';
require get_template_directory() . '/inc/telmarh-sanitize.php';

/**
 * favicon upload
 */
require get_template_directory() . '/inc/telmarh-favicon.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Google Fonts  
 */
require get_template_directory() . '/inc/gfonts.php';

/**
 * register your custom widgets
 */ 
require get_template_directory() . "/widgets/contact-info.php"; 
require get_template_directory() . "/widgets/video-widget.php";

/**
 * Activate for a child theme.  Always use a child theme to make edits.
 */
require_once( trailingslashit( get_template_directory() ) . '/inc/use-child-theme.php' );

/**
 * Load the front page widgets.
 */
if ( function_exists('siteorigin_panels_activate') ) {
	require get_template_directory() . "/widgets/telmarh-clients.php";
	require get_template_directory() . "/widgets/telmarh-projects.php";
	require get_template_directory() . "/widgets/telmarh-testimonials.php";
	require get_template_directory() . "/widgets/telmarh-services.php"; 
	require get_template_directory() . "/widgets/telmarh-home-news.php";
	require get_template_directory() . "/widgets/telmarh-cta.php";  
	require get_template_directory() . "/widgets/telmarh-columns.php";
	
} 

/**
 * Enqueues the necessary script for image uploading in widgets
 */
add_action('admin_enqueue_scripts', 'telmarh_image_upload');
function telmarh_image_upload($post) {
    if( 'post.php' != $post )
        return;	
    wp_enqueue_script('telmarh-image-upload', get_template_directory_uri() . '/js/image-uploader.js', array('jquery'), true );
	if ( did_action( 'wp_enqueue_media' ) )
		return;    
    wp_enqueue_media();    
}
