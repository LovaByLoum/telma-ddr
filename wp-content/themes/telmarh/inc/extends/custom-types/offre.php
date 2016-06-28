<?php
/**
 * register post type actualite
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

add_action('init', 'telmarh_init_actus', 1);
function telmarh_init_actus(){
  //post type
  $labels = get_custom_post_type_labels( 'Offre', 'Offres', 1 );
  $data = array(
    'capability'         => 'post',
		'supports'             => array( 'title', 'editor'),
		'hierarchical'         => false,
		'exclude_from_search'  => false,
		'public'               => true,
		'show_ui'              => true,
		'show_in_nav_menus'    => true,
		'menu_icon'            => get_template_directory_uri() . '/images/grey-icon/list_w__images.png',
		'menu_position'        => 6,
		'labels'               => $labels,
		'query_var'            => true,
	);
	register_post_type( POST_TYPE_OFFRE, $data);
	
}