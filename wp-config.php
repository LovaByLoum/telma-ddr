<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

$appPath = dirname( __FILE__ ) . '/';
switch ( dirname( __FILE__ ) ) {
	case( '/var/www/html' ):
		define( "SERVERCONFIG", 'recette' );
		break;
	case( '/home/users/europcar/srcs' ):
		define( "SERVERCONFIG", 'prod' );
		break;
	default :  //Machines de l'équipe projets
		define( "SERVERCONFIG", 'localhost' );
//Les fichiers correspondants n'existe pas sur le serveur de dev, il convient de les créer sur la machine concernée en faisant un copier coller des fichiers "dev"
}
define ( "BASEPATH", dirname( __FILE__ ) );
require_once( $appPath . 'wp-config/' . SERVERCONFIG . "/wp-config.php" );