<?php
/**
 * Template Name: Liste des offres
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post, $telmarh_options;
$entrepriseDefault = "";
$typeContratDefault = "";
$localisationDefault = "";
$domaineDefault = "";
$anneeExpDefault = "";
$criticiteDefault = "";
$postTitle = ( isset( $post->post_title ) && !empty( $post->post_title ) ) ? $post->post_title : "";
$postContent = ( isset( $post->post_content ) && !empty( $post->post_content ) ) ? $post->post_content : "";
get_header(); ?>
	<?php include( "template-list_offre.php" );?>
<?php get_footer(); ?>