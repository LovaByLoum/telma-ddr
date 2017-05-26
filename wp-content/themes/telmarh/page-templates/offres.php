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
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header(); ?>
	<?php include( "template-list_offre.php" );?>
<?php get_footer(); ?>