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

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on telmarh, use a find and replace
	 * to change 'telmarh' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'telmarh', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'telmarh-blog-archive', 800, 250, array( 'center', 'center' ) );
	add_image_size( 'telmarh-home-blog', 400, 250, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'telmarh' ),
		'footer'  => "Menu footer"
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
function telmarh_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'telmarh' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'telmarh' ),
		'id'            => 'footer-1',
		'description'   => __( 'Populate your first Footer area', 'telmarh' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'telmarh' ),
		'id'            => 'footer-2',
		'description'   => __( 'Populate your second Footer area', 'telmarh' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'telmarh' ),
		'id'            => 'footer-3',
		'description'   => __( 'Populate your third Footer area', 'telmarh' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'telmarh' ),
		'id'            => 'footer-4',
		'description'   => __( 'Populate your fourth Footer area', 'telmarh' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	//Register the sidebar widgets   
	register_widget( 'telmarh_Video_Widget' ); 
	register_widget( 'telmarh_Contact_Info' );
	
	//Register the post type widgets
	if ( function_exists('siteorigin_panels_activate') ) {
		register_widget( 'telmarh_clients' );
		register_widget( 'telmarh_testimonials' );
		register_widget( 'telmarh_projects' ); 
		register_widget( 'telmarh_services' );
		register_widget( 'telmarh_home_news' );
		register_widget( 'telmarh_action' );
		register_widget( 'telmarh_columns' );
	}
	
}
add_action( 'widgets_init', 'telmarh_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function telmarh_scripts() {
	wp_enqueue_style( 'telmarh-style', get_stylesheet_uri() );

	wp_enqueue_style( 'telmarh-slick', get_template_directory_uri() . '/css/slick.css' );

	wp_enqueue_style( 'telmarh-animate', get_template_directory_uri() . '/css/animate.css' );

	wp_enqueue_style( 'telmarh-select', get_template_directory_uri() . '/css/style-checkbok_select.css' );
	
	wp_enqueue_style( 'telmarh-menu', get_template_directory_uri() . '/css/jPushMenu.css' ); 
	
	wp_enqueue_style( 'telmarh-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.css' );
	
	$headings_font = esc_html(get_theme_mod('headings_fonts'));
	$body_font = esc_html(get_theme_mod('body_fonts'));
//	if( $headings_font ) {
//		wp_enqueue_style( 'telmarh-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
//	} else {
		wp_enqueue_style( 'telmarh-source-sans', get_template_directory_uri() . '/css/font_telmarh.css');
//	}
//	if( $body_font ) {
//		wp_enqueue_style( 'telmarh-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );
//	} else {
		wp_enqueue_style( 'telmarh-source-body', get_template_directory_uri() . '/css/font_telmarh.css');
	//}

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
 * Include additional custom admin panel features. 
 */
require get_template_directory() . '/panel/functions-admin.php';
require get_template_directory() . '/panel/telmarh-admin_page.php'; 

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
if (is_admin()){
  require_once( get_template_directory() . '/admin-functions.php' );

  /*** Theme Option ***/
  require get_template_directory() . '/theme-options/theme-options.php';

}
global $telmarh_options;
$telmarh_options = get_option( 'telmarh_theme_options' );

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

/**
 *  add inscription user
 *
 * @return string
 */
function telmarh_inscription_user(){
	$msg = "";
	if ( isset( $_POST['nonce_inscription'] ) && !empty( $_POST['nonce_inscription'] ) && wp_verify_nonce( $_POST['nonce_inscription'], "inscription_user" ) ){
		$login              = ( isset( $_POST['login'] ) && !empty( $_POST['login'] ) ) ? strip_tags( $_POST['login'] ) : "";
		$password           = ( isset( $_POST['passwrd'] ) && !empty( $_POST['passwrd'] ) ) ? strip_tags( $_POST['passwrd'] ) : "";
		$nom                = ( isset( $_POST['nom'] ) && !empty( $_POST['nom'] ) ) ? strip_tags( $_POST['nom'] ) : "";
		$prenom             = ( isset( $_POST['prenom'] ) && !empty( $_POST['prenom'] ) ) ? strip_tags( $_POST['prenom'] ) : "";
		$birthday           = ( isset( $_POST['birthday'] ) && !empty( $_POST['birthday'] ) ) ? strip_tags( $_POST['birthday'] ) : "";
		$adresse            = ( isset( $_POST['adresse'] ) && !empty( $_POST['adresse'] ) ) ? strip_tags( $_POST['adresse'] ) : "";
		$numPhone           = ( isset( $_POST['num_phone'] ) && !empty( $_POST['num_phone'] ) ) ? strip_tags( $_POST['num_phone'] ) : "";
		$email              = ( isset( $_POST['email'] ) && !empty( $_POST['email'] ) ) ? strip_tags( $_POST['email'] ) : "";
		$niveauEtude        = ( isset( $_POST['niveau_etude'] ) && !empty( $_POST['niveau_etude'] ) ) ? strip_tags( $_POST['niveau_etude'] ) : "";
		$autreNivEtude      = ( isset( $_POST['autre_exp'] ) && !empty( $_POST['autre_exp'] ) ) ? strip_tags( $_POST['autre_exp'] ) : "";
		$domaineEtude       = ( isset( $_POST['ref_etude'] ) && !empty( $_POST['ref_etude'] ) ) ? strip_tags( $_POST['ref_etude'] ) : "";
		$mobilite           = ( isset( $_POST['region'] ) && !empty( $_POST['region'] ) ) ? strip_tags( $_POST['region'] ) : "";
		$enPoste            = ( isset( $_POST['en_poste'] ) && !empty( $_POST['en_poste'] ) ) ? strip_tags( $_POST['en_poste'] ) : "";
		$nomEntreprise      = ( isset( $_POST['entreprise_user'] ) && !empty( $_POST['entreprise_user'] ) ) ? strip_tags( $_POST['entreprise_user'] ) : "";
		$fonction           = ( isset( $_POST['fonction_user'] ) && !empty( $_POST['fonction_user'] ) ) ? strip_tags( $_POST['fonction_user'] ) : "";
		$domaineMetier      = ( isset( $_POST['dom_metier'] ) && !empty( $_POST['dom_metier'] ) ) ? strip_tags( $_POST['dom_metier'] ) : "";
		$permis             = ( isset( $_POST['permis'] ) && !empty( $_POST['permis'] ) ) ? strip_tags( $_POST['permis'] ) : "";
		$catPermis          = ( isset( $_POST['permCat'] ) && !empty( $_POST['permCat'] ) ) ? $_POST['permCat'] : "";
		$dateDispo          = ( isset( $_POST['date_dispo'] ) && !empty( $_POST['date_dispo'] ) ) ? strip_tags( $_POST['date_dispo'] ) : "";
		$anneeExperience    = ( isset( $_POST['annee_exp'] ) && !empty( $_POST['annee_exp'] ) ) ? strip_tags( $_POST['annee_exp'] ) : "";
		$titreExpProf       = ( isset( $_POST['titre_exp_prof'] ) && !empty( $_POST['titre_exp_prof'] ) ) ? strip_tags( $_POST['titre_exp_prof'] ) : "";
		$isProjet           = ( isset( $_POST['projet'] ) && !empty( $_POST['projet'] ) ) ? strip_tags( $_POST['projet'] ) : "";
		$dbExpProf          = ( isset( $_POST['db_exp_prof'] ) && !empty( $_POST['db_exp_prof'] ) ) ? strip_tags( $_POST['db_exp_prof'] ) : "";
		$dfExpProf          = ( isset( $_POST['df_exp_prof'] ) && !empty( $_POST['df_exp_prof'] ) ) ? strip_tags( $_POST['df_exp_prof'] ) : "";
		$organismeExpProf   = ( isset( $_POST['organisme_exp_prof'] ) && !empty( $_POST['organisme_exp_prof'] ) ) ? strip_tags( $_POST['organisme_exp_prof'] ) : "";
		$descExpProf        = ( isset( $_POST['desc_exp_prof'] ) && !empty( $_POST['desc_exp_prof'] ) ) ? strip_tags( $_POST['desc_exp_prof'] ) : "";
		$localisationExpProf = ( isset( $_POST['localisation_prof'] ) && !empty( $_POST['localisation_prof'] ) ) ? strip_tags( $_POST['localisation_prof'] ) : "";
		$titreExpFor        = ( isset( $_POST['titre_exp_for'] ) && !empty( $_POST['titre_exp_for'] ) ) ? strip_tags( $_POST['titre_exp_for'] ) : "";
		$dbExpFor           = ( isset( $_POST['db_exp_for'] ) && !empty( $_POST['db_exp_for'] ) ) ? strip_tags( $_POST['db_exp_for'] ) : "";
		$dfExpFor           = ( isset( $_POST['df_exp_for'] ) && !empty( $_POST['df_exp_for'] ) ) ? strip_tags( $_POST['df_exp_for'] ) : "";
		$organismeExpFor    = ( isset( $_POST['organisme_exp_for'] ) && !empty( $_POST['organisme_exp_for'] ) ) ? strip_tags( $_POST['organisme_exp_for'] ) : "";
		$descExpFor         = ( isset( $_POST['desc_exp_for'] ) && !empty( $_POST['desc_exp_for'] ) ) ? strip_tags( $_POST['desc_exp_for'] ) : "";
		$localisationExpfor = ( isset( $_POST['localisation_for'] ) && !empty( $_POST['localisation_for'] ) ) ? strip_tags( $_POST['localisation_for'] ) : "";
		$titreExpPgt        = ( isset( $_POST['titre_exp_pgt'] ) && !empty( $_POST['titre_exp_pgt'] ) ) ? strip_tags( $_POST['titre_exp_pgt'] ) : "";
		$dbExpPgt           = ( isset( $_POST['db_exp_pgt'] ) && !empty( $_POST['db_exp_pgt'] ) ) ? strip_tags( $_POST['db_exp_pgt'] ) : "";
		$dfExpPgt           = ( isset( $_POST['df_exp_pgt'] ) && !empty( $_POST['df_exp_pgt'] ) ) ? strip_tags( $_POST['df_exp_pgt'] ) : "";
		$organismeExpPgt    = ( isset( $_POST['organisme_exp_pgt'] ) && !empty( $_POST['organisme_exp_pgt'] ) ) ? strip_tags( $_POST['organisme_exp_pgt'] ) : "";
		$descExpPgt         = ( isset( $_POST['desc_exp_pgt'] ) && !empty( $_POST['desc_exp_pgt'] ) ) ? strip_tags( $_POST['desc_exp_pgt'] ) : "";
		$localisationExpPgt = ( isset( $_POST['localisation_pgt'] ) && !empty( $_POST['localisation_pgt'] ) ) ? strip_tags( $_POST['localisation_pgt'] ) : "";
		//test login
		if ( empty( $login ) ) $msg .= "<li>Le login est requis.</li>";
		//test mdp
		if ( empty( $password ) ) $msg .="<li>Le mot de passe est requis.</li>";
		//test nom
		if ( empty( $nom ) ) $msg .= "<li>Le nom est requis.</li>";
		//test prenom
		if ( empty( $prenom ) ) $msg .= "<li>Le prénom est requis.</li>";
		//test date de naissance
		if ( empty( $birthday ) ) $msg .= "<li>La date de naissance est requise.</li>";
		//test adresse
		if ( empty( $adresse ) ) $msg .= "<li>L'adresse est requise.</li>";


		if ( empty( $email) ) $msg .= "<li>L'adresse email est requis.</li>";
		//test email
		if ( empty( $niveauEtude) ) $msg .= "<li>Le niveau d'etude est requis.</li>";
		//en poste
		if ( $enPoste == 1 ){
			if ( empty( $fonction ) ) $msg .= "<li>La fonction est requise.</li>";
		}
		//permis de conduire
		if ( $permis == 1 ){
			if ( empty( $catPermis ) ) $msg .= "<li>La catégorie de permis est requise.</li>";
		}
		// date de disponibilite
		if ( empty($dateDispo ) ) $msg .= "<li>La date de disponibilité est requise.</li>";

		// année d'experience
		if ( $anneeExperience == "0" ) $msg .= "<li>L'année d'expérience professionnelle est requise.</li>";

		//années experience autre
		if ( $niveauEtude == "autre" ) {
			if ( empty( $autreNivEtude ) ) $msg .= "<li>Autre niveau d'étude est requise.</li>";
		}

		// titre experience professionnelle
		if ( empty( $titreExpProf ) ) $msg .= "<li>Le titre de l'expérience professionnelle est requis</li>";

		//titre formation professionnelle
		if ( empty( $titreExpFor ) ) $msg .= "<li>Le titre de la formation professionnelle est requis</li>";

		//projet
		if ( $isProjet == "1" ){
			if ( empty( $titreExpPgt ) ) $msg .= "<li>Le titre du projet est requis.</li>";
		}

		// date de debut experience professionnelle
		if ( empty( $dbExpProf ) ) $msg .= "<li>La date de début de l'expérience professionnelle est requise</li>";

		//date de debut formation professionnelle
		if ( empty( $dbExpFor ) ) $msg .= "<li>La date de début  du formation professionnelle est requise</li>";

		//projet
		if ( $isProjet == 1 ){
			if ( empty( $dbExpPgt ) ) $msg .= "<li>La date de début  du projet est requise.</li>";
		}

		// date de fin experience professionnelle
		if ( empty( $dfExpProf ) ) $msg .= "<li>La date de fin de l'expérience professionnelle est requise</li>";

		//date de fin formation professionnelle
		if ( empty( $dfExpFor ) ) $msg .= "<li>La date de fin  du formation professionnelle est requise</li>";

		//projet
		if ( $isProjet == 1 ){
			if ( empty( $dfExpPgt ) ) $msg .= "<li>La date de fin  du projet est requise.</li>";
		}

		// organisme experience professionnelle
		if ( empty( $organismeExpProf ) ) $msg .= "<li>Organisme ou Entreprise de l'expérience professionnelle est requise</li>";

		//date de fin formation professionnelle
		if ( empty( $organismeExpFor ) ) $msg .= "<li>Organisme ou Entreprise de la formation professionnelle est requise</li>";

		//projet
		if ( $isProjet == "1" ){
			if ( empty( $organismeExpPgt ) ) $msg .= "<li>Organisme ou Entreprise  du projet est requise.</li>";
		}

		// organisme experience professionnelle
		if ( empty( $descExpProf ) ) $msg .= "<li>La description de l'expérience professionnelle est requise</li>";

		//date de fin formation professionnelle
		if ( empty( $descExpFor ) ) $msg .= "<li>La description de la formation professionnelle est requise</li>";

		//projet
		if ( $isProjet == "1" ){
			if ( empty( $descExpPgt ) ) $msg .= "<li>La description du projet est requise.</li>";
		}
		if ( empty( $msg ) ){
			//create user
			$obj = pw_new_user_approve();
			remove_action( "user_register", array( $obj , 'add_user_status') );
			remove_action( "user_register", array( $obj , 'request_admin_approval_email_2') );
			add_action( "user_register", "CUser::request_user_approval_email");
			$args = array(
				"user_login"        => wp_slash( $login ),
				"user_email"        => wp_slash( $email ),
				'user_pass'         => $password,
				'nickname'          => $login,
				'first_name'        => $nom,
				'last_name'         => $prenom,
				'display_name'      => $prenom . '  ' . $nom,
				'role'              => USER_ROLE_CANDIDAT
			);
			$userId = wp_insert_user( $args );
			wp_set_password( $password, $userId );
			//field user
			add_user_meta( $userId, 'pw_user_status', 'pending' );
			add_user_meta( $userId, 'date_naissance_user', date( "Ymd", strtotime( str_replace('/', '-',  $birthday ) ) ) );
			add_user_meta( $userId, 'adresse_user', $adresse );
			add_user_meta( $userId, 'num_phone_user', $numPhone );
			add_user_meta( $userId, 'niveau_etude_user', $niveauEtude );
            if ( $niveauEtude == "autre" )add_user_meta( $userId, 'autre_niveau_user', $autreNivEtude );
			add_user_meta( $userId, 'domaine_etude_user', sanitize_title($domaineEtude) );
			add_user_meta( $userId, 'mobilite_user', $mobilite );
			add_user_meta( $userId, 'en_poste_user', $enPoste );
			if ( $enPoste == "1" ){
				add_user_meta( $userId, 'entreprise_user', $nomEntreprise );
				add_user_meta( $userId, 'fonction_user', $fonction );
			}
			add_user_meta( $userId, 'domaine_metier_recherche_user', $domaineMetier );
			add_user_meta( $userId, 'permis_de_conduire', $permis );
			if ( $permis == 1 ){
				add_user_meta( $userId, 'categorie_permis_user', $catPermis );
			}
			add_user_meta( $userId, 'date_disponibilite_user', date( "Ymd", strtotime( str_replace('/', '-', $dateDispo ) ) ) );
			//experience professionnel
			$field_key = "annee_exp_prof";
			$key = get_acf_key( $field_key );
			$value = array();
			$value[] = array(
				"titre_exp_prof"        =>  $titreExpProf,
				"db_exp_prof"           =>  date( "Ymd" , strtotime( str_replace('/', '-', $dbExpProf ) ) ),
				"df_exp_prof"           =>  date( "Ymd" , strtotime( str_replace('/', '-', $dfExpProf ) ) ),
				"description_exp_prof"  =>  $descExpProf,
				"organisme_exp_prof"    =>  $organismeExpProf,
				"localisation"          =>  sanitize_title( $localisationExpProf )
			);
			if ( isset( $_POST['experience-number'] ) && intval( $_POST['experience-number'] ) > 0 ){
				for ( $i = 1; $i <= intval( $_POST['experience-number'] ); $i++  ){
					$value[] = array(
						"titre_exp_prof"        =>  strip_tags( $_POST['titre_exp_prof' . $i] ),
						"db_exp_prof"           =>  date( "Ymd" , strtotime( str_replace('/', '-', $_POST['db_exp_prof' . $i] ) ) ),
						"df_exp_prof"           =>  date( "Ymd" , strtotime( str_replace('/', '-', $_POST['df_exp_prof' . $i] ) ) ),
						"description_exp_prof"  =>  strip_tags( $_POST['desc_exp_prof' . $i] ),
						"organisme_exp_prof"    =>  strip_tags( $_POST['organisme_exp_prof' . $i] ),
						"localisation"          =>  sanitize_title( strip_tags( $_POST['localisation_prof' . $i] ) )
					);
				}
			}

			update_field( $key, $value, "user_" . $userId );

			//formation
			$field_key = "formations_user";
			$key = get_acf_key( $field_key );
			$value = array();
			$value[] = array(
				"titre_exp_for"        => $titreExpFor,
				"db_exp_for"            => date( "Ymd" , strtotime( str_replace('/', '-', $dbExpFor  ) ) ),
				"df_exp_for"            => date( "Ymd" , strtotime( str_replace('/', '-', $dfExpFor ) ) ),
				"description_exp_for"   => $descExpFor,
				"organisme_exp_for"     => $organismeExpFor,
				"localisation_exp_for"  => sanitize_title( $localisationExpfor )
			);
			if ( isset( $_POST['formation-number'] ) && intval( $_POST['formation-number'] ) > 0 ){
				for ( $i = 1; $i <= intval( $_POST['formation-number'] ); $i++  ){
					$value[] = array(
						"titre_exp_for"        => strip_tags( $_POST['titre_exp_for' . $i] ),
						"db_exp_for"            => date( "Ymd" , strtotime( str_replace('/', '-', $_POST['db_exp_for' . $i] ) ) ),
						"df_exp_for"            => date( "Ymd" , strtotime( str_replace('/', '-', $_POST['df_exp_for' . $i] ) ) ),
						"description_exp_for"   => strip_tags( $_POST['desc_exp_for' . $i] ),
						"organisme_exp_for"     => strip_tags( $_POST['organisme_exp_for' . $i] ),
						"localisation_exp_for"  => sanitize_title( strip_tags( $_POST['localisation_for' . $i] ) )
					);
				}
			}

			update_field( $key, $value, "user_" . $userId );


			//projets
			if (  intval( $isProjet )  ) {
				$field_key = "projets_personnels_professionnels_user";
				$key = get_acf_key( $field_key );
				$value = array();
				$value[] = array(
					"titre_exp_pgt"         => $titreExpPgt,
					"db_exp_pgt"            => date( "Ymd" , strtotime( str_replace('/', '-', $dbExpPgt ) ) ),
					"df_exp_pgt"            => date( "Ymd" , strtotime( str_replace('/', '-', $dfExpPgt ) ) ),
					"description_exp_pgt"   => $descExpPgt,
					"organisme_exp_pgt"     => $organismeExpPgt,
					"localisation_exp_pgt"  => sanitize_title( $localisationExpPgt )
				);

				if ( isset( $_POST['projet-number'] ) && intval( $_POST['projet-number'] ) > 0 ){
					for ( $i = 1; $i <= intval( $_POST['projet-number'] ); $i++  ){
						$value[] = array(
							"titre_exp_pgt"         => strip_tags( $_POST['titre_exp_pgt' . $i] ),
							"db_exp_pgt"            => date( "Ymd" , strtotime( str_replace('/', '-', $_POST['db_exp_pgt' . $i] ) ) ),
							"df_exp_pgt"            => date( "Ymd" , strtotime( str_replace('/', '-', $_POST['df_exp_pgt' . $i] ) ) ),
							"description_exp_pgt"   => strip_tags( $_POST['desc_exp_pgt' . $i] ),
							"organisme_exp_pgt"     => strip_tags( $_POST['organisme_exp_pgt' . $i] ),
							"localisation_exp_pgt"  => sanitize_title( strip_tags( $_POST['localisation_pgt' . $i] ) )
						);
					}
				}
			}


			update_field( $key, $value, "user_" . $userId );
			$error = 0;
		} else {
			$error = 1;
		}

	} else {
		$error =  1;
		$msg .= (isset(  $_POST['nonce-inscription']  ) ) ? "Ceci est un robot" : "";
	}
	return array( 'error' => $error, 'messages' => $msg );
}

/**
 * @param $email
 * @param $subjet_mail
 * @param $msg
 * @param $blogname
 */
function telmarh_send_mail( $email, $subjet_mail, $msg, $blogname )
{
	ob_start();
	include( "tpl/template.tpl.php" );
	$output = ob_get_contents();
	ob_end_clean();
	$header = 'From: ' . $blogname . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>';
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	@wp_mail( $email, $subjet_mail, $output, $header );
}

/**
 * @return string
 */
function set_html_content_type()
{
	return 'text/html';
}

function get_acf_key($field_name) {

    global $wpdb;

    return $wpdb->get_var("
        SELECT `meta_key`
        FROM $wpdb->postmeta
        WHERE `meta_key` LIKE 'field_%' AND `meta_value` LIKE '%$field_name%';
    ");

}
add_action('wp_logout','telmarh_go_home');
function telmarh_go_home(){
  wp_redirect( home_url() );
  exit();
}

add_filter( "login_form_bottom", "telmarh_login_form_bottom", 10, 1 );
function telmarh_login_form_bottom( $arg ) {
	$pageInscription = wp_get_post_by_template( "page-inscription.php", "" );
	$linkLostPassword = wp_lostpassword_url();
	$html = '<p class="login-submit">
				<a href="' . $linkLostPassword . '" class="lostpassword" title="Mot de passe oublié">
					Mot de passe oublié
				</a>
				<a href="' . get_permalink( $pageInscription->ID ) . '" class="lostpassword" title="S\'inscrire">
					S\'inscrire
				</a>
			 </p>
			 ';
	return $html;
}

add_filter( "custom_validate_php_form", "telmarh_custom_validate_php_form", 10, 1 );
function telmarh_custom_validate_php_form( $postDataSend ){
	$error = 0;
	if ( isset( $postDataSend['fm_id'] ) && !empty( $postDataSend['fm_id'] )  ){
		if ( $postDataSend['fm_id'] == FORMULAIRE_POSTULER_OFFRE ){
			//validation competences Informatique
			if ( isset( $_POST['compInfo'] ) && empty( $_POST['compInfo'] ) ){
				$error = 1;
			}

			//validation competence liguistique
			if ( isset( $_POST['langue'] ) && empty( $_POST['langue'] ) ){
				$error = 1;
			}

			//cv
			if ( isset( $postDataSend['file-57864af3474de'] ) && empty( $postDataSend['file-57864af3474de'] ) ) {
				$error = 1;
			}
			//lm
			if ( isset( $postDataSend['file-57864b273eb37'] ) && empty( $postDataSend['file-57864b273eb37'] ) ){
				$error = 1;
			}

			if ( $error ) {
				return false;
			} else {
				//competence infos
				$competenceInfo = "";
				$i = 1;
				$glue = ", ";
				foreach ( $postDataSend['compInfo'] as $termId ){
					$term = get_term_by( "id", $termId, JM_TAXONOMIE_COMPETENCE_REQUISES );
					$competenceInfo .= $term->name;
                    if ( isset( $postDataSend[$term->slug] ) && !empty( $postDataSend[$term->slug] ) ) {
                        foreach ( $postDataSend[$term->slug] as $termChildId ){
                            $termChild = get_term_by( "id", $termChildId, JM_TAXONOMIE_COMPETENCE_REQUISES );
                            $competenceInfo .= " ( " . $termChild->name . " ) ";
                        }
                    }
					if ( ( count( $postDataSend['compInfo'] ) - 1 ) == $i  ) { $competenceInfo .= " et "; $i++; }
					if ( count( $postDataSend['compInfo'] ) > $i )  { $competenceInfo .= $glue; $i++; }
				}
				$_POST[CPage::fm_get_unique_name_by_nickname( "informatique_postule",$postDataSend['fm_id'] )] = $competenceInfo;
				$slugLangues = array( "anglais", "francais", "malagasy" );
				foreach ( $slugLangues as $langue ){
					if ( isset( $postDataSend[$langue] ) && !empty( $postDataSend[$langue] ) && count( $postDataSend[$langue] ) > 0 ){
						$i = 1;
						$glue = ", ";
						$data = "";
						foreach ( $postDataSend[$langue] as $elt ){
							$term = get_term_by( "id", $elt, JM_TAXONOMIE_COMPETENCE_REQUISES );
							$data .= $term->name;
							if ( ( count( $postDataSend[$langue] ) - 1 ) == $i  ) { $data .= " et "; $i++; }
							if ( count( $postDataSend[$langue] ) > $i )  { $data .= $glue; $i++; }
						}
						$_POST[CPage::fm_get_unique_name_by_nickname( $langue . "_postule",$postDataSend['fm_id'] )] = $data;
					}
				}
				return $error;
			}
		}
	}
}

remove_action( 'fm_form_submission', 'fm_extraSubmissionActions' );
add_action( 'fm_form_submission', 'telmarh_custom_mail_send' );
function telmarh_custom_mail_send( $info ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    global $wpdb;
    CUser::installTable();
	$postData = $info['data'];
	$uniqueId = $postData['unique_id'];
	if ( $info['form']['ID'] == FORMULAIRE_POSTULER_OFFRE ){
		$offreId = $postData['parent_post_id'];
		$element = get_post_meta( $offreId, JM_META_SOCIETE_OFFRE_RELATION, true );
		$args = array(
			"meta_value"    => $element,
			"meta_key"      => JM_META_USER_SOCIETE_FILTER_ID,
			"fields"        => "all"
		);
		$users = get_users( $args );
		if ( !empty( $users ) && count( $users ) > 0 && is_plugin_active( "new-user-approve/new-user-approve.php" ) ){
			foreach ( $users as $user ){
	            $statusUser = get_user_meta( $user->ID,SLUG_META_APPROVED_USER , true);
	            if ( !empty( $statusUser) && $statusUser == 'approved' ){
	                $wpdb->insert( CUser::$_tableNameEmail, array( 'id' => NULL, 'email' => $user->user_email, 'date_envoi' => NULL, 'envoyer' => 0, "element" => $uniqueId ));
	            }
	        }
		}
	} elseif ( $info['form']['ID'] == FORMULAIRE_CANDIDATURE_SPONTANEE ) {
		$users = get_users( array( "role" => JM_ROLE_RESPONSABLE_RH ) );
		if ( !empty( $users ) && count( $users ) > 0 && is_plugin_active( "new-user-approve/new-user-approve.php" ) ){
			foreach ( $users as $user ) {
				$statusUser = get_user_meta( $user->ID,SLUG_META_APPROVED_USER , true);
	            if ( !empty( $statusUser) && $statusUser == 'approved' ){
	                $wpdb->insert( CUser::$_tableNameEmail, array( 'id' => NULL, 'email' => $user->user_email, 'date_envoi' => NULL, 'envoyer' => 0, "element" => $uniqueId ));
	            }
			}
		}
	}



}

//hide role
add_action( 'pre_user_query', 'telmarh_pre_user_query' );
function telmarh_pre_user_query( $user_search )
{
    global $wpdb;
    $user = wp_get_current_user();
	if ( in_array( $user->roles[0], array( JM_ROLE_RESPONSABLE_RH ) ) ){
		$user->get_role_caps();
		    $where = 'WHERE 1=1';

		    // Temporarily remove this hook otherwise we might be stuck in an infinite loop
		    remove_action( 'pre_user_query', 'telmarh_pre_user_query' );

		    // View adminstrators? (Remember: this is capability defined by you!)
		    $view_users = in_array( 'list_users', $user->allcaps );
		    if ( $view_users ) {
		        // Get the list of admin IDs
		        $args = array(
		            'role__in' => array( JM_ROLE_RESPONSABLE_RH, USER_ROLE_ADMINISTRATOR, USER_ROLE_WEBMASTER, "editor", "author" ),
		        );
		        $user_query = new WP_User_Query( $args );
		        $admins = $user_query->get_results();
		        $admin_ids = array( );
		        foreach ( $admins as $admin ) {
		            $admin_ids[] = $admin->id;
		        }

		        $where .= ' AND '.$wpdb->users.'.ID NOT IN ('.implode(',', $admin_ids).')';
		    }

		    // Repeat block above for other capabilities you define,
		    // i.e. hide users not everybody should see
		    // ...

		    // Modify original WP_User_Query
		    $user_search->query_where = str_replace(
		        'WHERE 1=1',
		        $where,
		        $user_search->query_where
		    );

		     // Re-add the hook
		    add_action( 'pre_user_query', 'telmarh_pre_user_query' );
	} elseif( in_array( $user->roles[0], array( USER_ROLE_WEBMASTER ) ) ) {
		$user->get_role_caps();
	    $where = 'WHERE 1=1';

	    // Temporarily remove this hook otherwise we might be stuck in an infinite loop
	    remove_action( 'pre_user_query', 'telmarh_pre_user_query' );

	    // View adminstrators? (Remember: this is capability defined by you!)
	    $view_users = in_array( 'list_users', $user->allcaps );
	    if ( $view_users ) {
	        // Get the list of admin IDs
	        $args = array(
	            'role__in' => array( "administrator" ),
	        );
	        $user_query = new WP_User_Query( $args );
	        $admins = $user_query->get_results();
	        $admin_ids = array( );
	        foreach ( $admins as $admin ) {
	            $admin_ids[] = $admin->id;
	        }

	        $where .= ' AND '.$wpdb->users.'.ID NOT IN ('.implode(',', $admin_ids).')';
	    }

	    // Repeat block above for other capabilities you define,
	    // i.e. hide users not everybody should see
	    // ...

	    // Modify original WP_User_Query
	    $user_search->query_where = str_replace(
	        'WHERE 1=1',
	        $where,
	        $user_search->query_where
	    );

	     // Re-add the hook
	    add_action( 'pre_user_query', 'telmarh_pre_user_query' );
	}

}

add_filter("fm_data_columns", "telmarh_fm_data_columns", 10, 1);
function telmarh_fm_data_columns( $cols ){
	$newCols = array();
	foreach ( $cols as $col ){
		if ( $col['key'] == "user" ){
			$col['show-callback'] = "telmarh_fm_link_user";
		}
		$newCols[] = $col;
	}
	return $newCols;
}

function telmarh_fm_link_user( $col, $dbRow ){
	$userName = $dbRow[$col['key']];
	$user = get_user_by( "login", $userName );
	if(isset( $user->ID  ) &&  $user->ID != 0)
			return '<a href="'.get_edit_user_link($user->ID).'">'.$userName.'</a>';
		else
			return "";
}


/*
 * cron pour le sendmail
 */
add_filter("cron_schedules", "telmarh_add_scheduled_interval");
function telmarh_add_scheduled_interval( $shedules ){
  $schedules['cinq_minute'] = array('interval'=>300, 'display'=>'Once 5 minute');
  $schedules['dix_minute'] = array('interval'=>600, 'display'=>'Once 10 minute');
  $schedules['one_day'] = array('interval'=>86400, 'display'=>'Once one Day');
  return $schedules;
}


if (!wp_next_scheduled('my_cinq_minute_action')) {
  wp_schedule_event(time(), 'cinq_minute', 'my_cinq_minute_action');
}
if (!wp_next_scheduled('my_dix_minute_action')) {
  wp_schedule_event(time(), 'dix_minute', 'my_dix_minute_action');
}
if (!wp_next_scheduled('my_one_day_action')) {
  wp_schedule_event(time(), 'one_day', 'my_trente_minute_action');
}

//for cron job task
add_action('my_dix_minute_action', array(CUser, 'send_notifications'));
add_action('my_one_day_action', array(CUser, 'purge_list_email'));

add_filter( "fm_change_nickname_to_label", "telmarh_fm_change_nickname_to_label", 10, 1 );
function telmarh_fm_change_nickname_to_label( $col ){
	if ( isset( $col['item'] ) && !empty( $col['item'] ) ) return $col['item']['label'];
	else return $col['value'];
}
add_action("init", "telmarh_connection");
function telmarh_connection(){
	$secure_cookie = '';
	$creds = array();
	if ( !is_user_logged_in() ){
		// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['custom_log']) && !force_ssl_admin() ) {
				$user_name = sanitize_user($_POST['custom_log']);
				$user = get_user_by( 'login', $user_name );

				if ( ! $user && strpos( $user_name, '@' ) ) {
					$user = get_user_by( 'email', $user_name );
				}

				if ( isset( $user->ID ) && $user->ID > 0 ) {
					$secure_cookie = true;
				}
			}
		$creds['user_login'] = $_POST['custom_log'];
		$creds['user_password'] = $_POST['custom_pwd'];
		$creds['remember'] = $_POST['custom_rememberme'];
		$user = wp_signon( $creds, $secure_cookie );
		if ( isset( $user->errors ) ){
			$_POST['errors'] = $user->errors;
		} else {
			wp_set_current_user( $user->ID );
		}
		$to_redirect = ( isset( $_POST['redirect_to'] ) && !empty( $_POST['redirect_to'] ) ) ? $_POST['redirect_to']  : home_url();
		if ( !is_wp_error($user) ) {
			wp_redirect( $to_redirect );
			exit;
		}

	}

}
add_action("admin_menu", "telmarh_restrict_to_edit_user");
function telmarh_restrict_to_edit_user() {
	global $pagenow, $current_user;
	if ( in_array( $pagenow, array( "user-edit.php" ) ) && isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ){
		$userEdit = get_user_by( "id", intval( $_GET['user_id'] ) );
		if ( in_array( $current_user->roles[0], array( USER_ROLE_WEBMASTER, JM_ROLE_RESPONSABLE_RH ) ) ){
			if ( in_array( $userEdit->roles[0], array( USER_ROLE_ADMINISTRATOR ) ) ){
				wp_die( "Vous n'avez pas acces a cette modification. Veuillez consultez votre administrateur" );
			}
		}

		if ( in_array( $current_user->roles[0], array( JM_ROLE_RESPONSABLE_RH ) ) ){
			if ( $current_user->ID != $userEdit->ID  && in_array( $userEdit->roles[0], array( JM_ROLE_RESPONSABLE_RH ) ) ){
				wp_die( "Vous n'avez pas acces a cette modification. Veuillez consultez votre administrateur" );
			}
		}
	}
}

add_action("init", "telmarh_init_nous_contacter");
function telmarh_init_nous_contacter(){
	global $telmarh_options;
	$msg = "";
	$error = 0;
	if ( is_page_template( "page-nous_contacter.php" ) ){
		if ( isset( $_POST['wp_nonce_contact'] ) && !empty( $_POST['wp_nonce_contact'] ) && wp_verify_nonce( $_POST['wp_nonce_contact'], "wp_nonce_contact" ) ){
			$name       = ( isset( $_POST['nom_contact'] ) && !empty( $_POST['nom_contact'] ) ) ? $_POST['nom_contact'] : "";
			$surname    = ( isset( $_POST['surname_contact'] ) && !empty( $_POST['surname_contact'] ) ) ? $_POST['surname_contact'] : "";
			$email      = ( isset( $_POST['email_contact'] ) && !empty( $_POST['email_contact'] ) ) ? $_POST['email_contact'] : "";
			$num_phone  = ( isset( $_POST['num_phone'] ) && !empty( $_POST['num_phone'] ) ) ? $_POST['num_phone'] : "";
			$message    = ( isset( $_POST['message'] ) && !empty( $_POST['message'] ) ) ? $_POST['message'] : "";
			if ( empty( $name ) ) $msg .= '<li><span>Le nom est requis.</span></li>';
			if ( empty( $surname ) ) $msg .= '<li><span>Le prénom est requis.</span></li>';
			if ( empty( $email ) ) $msg .= '<li><span>L\'adresse email est requise.</span></li>';
			if ( !empty( $email ) && !filter_var($email, FILTER_VALIDATE_EMAIL) ) $msg .= '<li><span>L\'adresse email n\'est pas valide.</span></li>';
			if ( empty( $message ) ) $msg .= '<li>Le message est requis.</li>';
			if ( !empty( $num_phone ) && !is_numeric( $num_phone ) ) $msg .= '<li><span>La numéro de téléphone est invalide (entier uniquement).</span></li>';
			if ( empty( $msg ) ){
				$blogname       = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
				$email_admin    = $telmarh_options['email_send_contact'];
				$subjet_user    = $telmarh_options['subjet_mail_user'];
				$subjet_admin   = $telmarh_options['subjet_mail_admin'];
				$siteName       = get_bloginfo( "name" );
				$data_user      = '	<ul>
										<li><strong>Nom : </strong>' . $name . '</li>
										<li><strong>Prénom : </strong>' . $surname . '</li>
										<li><strong>Adresse email : </strong>' . $email . '</li>
										<li><strong>Numéro de téléphone  : </strong>' . $num_phone . '</li>
										<li><strong>Message  : </strong>' . $message . '</li>
									</ul>';

				$tobereplaced   = array('[soubmission:data]', '[site:name]');
			    $replacement    = array( $data_user, $siteName );
				$content_user   = str_replace($tobereplaced, $replacement, $telmarh_options['content_mail_user']);
				$content_admin  = str_replace($tobereplaced, $replacement, $telmarh_options['content_mail_admin']);
				telmarh_send_mail( $email_admin, $subjet_admin, $content_admin, $blogname );
				telmarh_send_mail( $email, $subjet_user, $content_user, $blogname );
				$error = 0;
			} else {
				$error = 1;
			}
		} else {
			$error =  1;
			$msg .= (isset(  $_POST['wp_nonce_contact']  ) && !empty( $_POST['wp_nonce_contact'] ) ) ? "<li><span>Veuillez recharger la page</span></li>" : "";
		}
		$_POST['error'] = array(
			'error' => $error,
			'msg'   => $msg
		);
	}
}
add_filter( 'acf/load_field/name=niveau_etude_user', 'telmarh_custom_value_niveau_etude' );
function telmarh_custom_value_niveau_etude($field){
    $terms = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false ) );
    $field['choices'] = array();
    foreach ( $terms as $term ) {
        $data[$term->term_id] = $term->name;
    }
    $data['autre'] = "Autre";
    $field['choices'] = $data;

    return $field;
}

add_filter( "posts_search", "telmarh_posts_search", 10, 2 );
function telmarh_posts_search( $sql, $query   ){
    global $wpdb;
    if ( isset($query->query_vars['query_name']) && $query->query_vars['query_name'] == 'offre_search_ajax' && isset( $query->query_vars['s'] ) && !empty( $query->query_vars['s'] ) ){
        return "AND (
                        {$wpdb->posts}.post_title LIKE '%" . $query->query_vars['s'] . "%'
                        OR {$wpdb->posts}.post_excerpt LIKE '%" . $query->query_vars['s'] . "%'
                        OR {$wpdb->posts}.post_content LIKE '%" . $query->query_vars['s'] . "%'
                        OR ( {$wpdb->postmeta}.meta_key = 'missions_principales_offre' AND CAST({$wpdb->postmeta}.meta_value AS CHAR) LIKE '%" . $query->query_vars['s'] . "%' )
                        OR ( {$wpdb->postmeta}.meta_key = 'qualites_requises_offre' AND CAST({$wpdb->postmeta}.meta_value AS CHAR) LIKE '%" . $query->query_vars['s'] . "%' )
                        OR ( {$wpdb->postmeta}.meta_key = 'responsabilites_offre' AND CAST({$wpdb->postmeta}.meta_value AS CHAR) LIKE '%" . $query->query_vars['s'] . "%' )
                    )";
    }
    return $sql;
}

add_filter( "posts_join", "telmarh_posts_join", 10, 2 );
function telmarh_posts_join( $sql, $query   ){
    global $wpdb;
    if ( isset($query->query_vars['query_name']) && $query->query_vars['query_name'] == 'offre_search_ajax' && isset( $query->query_vars['s'] ) && !empty( $query->query_vars['s'] ) ){
        return " INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) ";
    }
    return $sql;
}

add_filter('editable_roles','exclude_editor_role', 10 );
function exclude_editor_role($roles) {
    if ( current_user_can( JM_ROLE_RESPONSABLE_RH ) ){
        $arrayUnset = array(
            "administrator", "author", "editor", "responsable_rh", "contributor", "webmaster"
        );
        foreach ( $arrayUnset as $role ){
            unset( $roles[$role] );
        }
    }
    return $roles;
}
add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );

function remove_row_actions( $actions )
{
    if( current_user_can( JM_ROLE_RESPONSABLE_RH ) && get_post_type() === JM_POSTTYPE_OFFRE )
        unset($actions['inline hide-if-no-js']);
    return $actions;
}
add_action("admin_head", "telmarh_admin_head_hide_list");
function telmarh_admin_head_hide_list(){
    global $current_user;
    $script ="";
    if ( in_array( $current_user->roles[0], array( JM_ROLE_RESPONSABLE_RH ) )  ) {
        $script .="<style> ul.subsubsub .all,
                    ul.subsubsub .publish,
                    ul.subsubsub .sticky,
                    ul.subsubsub .trash,
                    ul.subsubsub .draft,
                    ul.subsubsub .pending,
                    ul.subsubsub .expired{display:none;}
                   </style> ";
    }
    echo $script;
}
