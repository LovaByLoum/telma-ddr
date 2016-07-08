<?php
/**
 * Theme options
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $telmarh_options;
require_once get_template_directory() . '/theme-options/options.php';
$telmarh_options = get_option( 'telmarh_theme_options' );

add_action( 'admin_init', 'telmarh_options_init' );
function telmarh_options_init(){
 register_setting( 'telmarh_options', 'telmarh_theme_options','telmarh_options_validate');
} 

function telmarh_options_validate($input)
{
   $allfields_settings = telmarh_get_all_settings();

   foreach ( $input as $i ){
     if ( isset($allfields_settings[$i]) ){
        switch ( $allfields_settings[$i]['type'] ){
          case 'text':
            $input[$i] = sanitize_text_field( $input[$i] );
            break;
          case 'select':
            break;
          case 'date':
            break;
          case 'url':
            $input[$i] = esc_url_raw( $input[$i] );
            break;
          case 'textarea':
            $input[$i] = sanitize_text_field( $input[$i] );
            break;
          case 'image':
            $input[$i] = telmarh_image_validation(esc_url_raw( $input[$i]));
            break;
          default:
        }
     }
   }

	  return $input;
}
function telmarh_image_validation($telmarh_imge_url){
	$telmarh_filetype = wp_check_filetype($telmarh_imge_url);
	$telmarh_supported_image = array('gif','jpg','jpeg','png','ico');
	if (in_array($telmarh_filetype['ext'], $telmarh_supported_image)) {
		return $telmarh_imge_url;
	} else {
	return '';
	}
}
function telmarh_get_all_settings(){
  global $telmarh_options_settings;
  $allfields = array();
  foreach ( $telmarh_options_settings as $tab) {
      $allfields = array_merge( $allfields, $tab );
  }
  return $allfields;
}

add_action( 'admin_enqueue_scripts', 'telmarh_framework_load_scripts' );
function telmarh_framework_load_scripts(){
	wp_enqueue_media();
	wp_enqueue_style( 'telmarh_framework', get_template_directory_uri(). '/theme-options/css/theme-options.css' ,false, '1.0.0');
	// Enqueue custom option panel JS
	wp_enqueue_script( 'options-custom', get_template_directory_uri(). '/theme-options/js/theme-options.js', array( 'jquery' ) );
	wp_enqueue_script( 'media-uploader', get_template_directory_uri(). '/theme-options/js/media-uploader.js', array( 'jquery') );		
}

add_action( 'admin_menu', 'telmarh_options_add_page' );
function telmarh_options_add_page() {
	add_theme_page( 'telmarh Options', 'Theme Options', 'edit_theme_options', 'telmarh_framework', 'telmarh_framework_page');
}

function telmarh_framework_page(){
  include 'admin-page.php';
}
