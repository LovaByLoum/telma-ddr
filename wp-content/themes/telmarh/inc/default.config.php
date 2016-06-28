<?php
/**
 * configuration par defaut
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

//enlever le p auto et br auto
add_filter('tiny_mce_before_init','telmarh_tiny_mce_before_init',10,2);
function telmarh_tiny_mce_before_init($mceInit, $editor_id){
  $mceInit["wpautop"] = false;
  $mceInit["remove_linebreaks"] = false;
  $mceInit["apply_source_formatting"] = true;
  return $mceInit;
}

//charger les images en lazy load
add_action( 'wp_enqueue_scripts', 'telmarh_default_scripts' );
function telmarh_default_scripts(){
  wp_enqueue_script('jquery-lazyload', get_template_directory_uri() .'/js/library/jquery.lazyload.min.js', array('jquery'), '1.8.0' , true);
}

add_filter( 'the_content','telmarh_default_the_content',9);
function telmarh_default_the_content($html){
  //charger en lazy load les images wp-image
  $html = preg_replace_callback(
    '!<img(.+?)>!',
    'wp_do_lazyload_wpimage',
    $html
  );
  return $html;
}
function wp_do_lazyload_wpimage($matches){
  $lazyimage = get_template_directory_uri() .'/images/trans.gif';
  //recherche l'attribut src
  $src1 = preg_replace('!(src=)(")(.+?)(")!','$1$2'.$lazyimage.'$4 data-original="$3"',$matches[1]);
  if (preg_match('#(class=)(")(.*?)(")#', $src1)){
    $src1 = preg_replace('#(class=)(")(.*?)(")#', '$1$2$3 lazy$4', $src1);
  }else{
    $src1.= ' class="lazy"';
  }
  return '<img'.$src1 . '>';
}