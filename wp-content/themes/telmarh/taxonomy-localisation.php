<?php
global $term, $telmarh_options;
$termData = get_term_by( "slug", $term, JM_TAXONOMIE_LOCALISATION );
$typeContratDefault = "";
$localisationDefault = $termData->term_id;
$entrepriseDefault = "";
$domaineDefault = "";
$anneeExpDefault = "";
$criticiteDefault = "";
$postOffres = wp_get_post_by_template( "offres.php" );
$postTitle = ( isset( $postOffres->post_title ) && !empty( $postOffres->post_title ) ) ? $postOffres->post_title : "";
$postContent = ( isset( $postOffres->post_content ) && !empty( $postOffres->post_content ) ) ? $postOffres->post_content : "";
get_header(); ?>
	<?php include( "page-templates/template-list_offre.php" );?>
<?php get_footer(); ?>