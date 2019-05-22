<?php
/*
 * fonctions personnalistion de l'interface admin
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

add_action( 'admin_enqueue_scripts', 'telmarh_admin_enqueue_scripts' );
function telmarh_admin_enqueue_scripts(){
    wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/css/admin/styles.css' );
}
