<?php
/**
 * Template Name: Page candidature spontanée
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post;
$idImage = get_post_thumbnail_id($post->ID);
list($image) = wp_get_attachment_image_src( $idImage, "full" );
$offre = JM_Offre::getById( $post->ID );
$offreElment = COffre::getById( $post->ID );
$idEntreprise = ( isset( $offre->societe_associe ) && !empty( $offre->societe_associe ) ) ? $offre->societe_associe : "";
$society = ( intval( $idEntreprise ) > 0 ) ? JM_Societe::getById( $idEntreprise ) : "";
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
get_header(); ?>
<section id="page-full-entry-content" class="spontaneous-form form-page">
    <figure class="alauneImg">
        <?php if ( isset( $image ) && !empty( $image ) ){?>
            <img src="<?php echo $image; ?>" alt="">
        <?php } else {?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
        <?php }?>
    </figure>
    <div class="breadcrumb"><div class="container"><?php get_breadcrumb("<a href=". get_permalink( $postOffes->ID )."> Nos offres </a>"); ?></div></div>
	<header class="entry-header">
		<div class="container">
			<?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                <h1 class="entry-title"><?php echo $post->post_title;?></h1>
			<?php endif;?>
			<div class="entry-content">
                <?php echo apply_filters("the_content", $post->post_content );?>
            </div>
        </div>
	</header>
	<article class="content-area main-content" id="primary">
        <div class="status-publish hentry container">
            <?php echo apply_filters('the_content','[form form-spontanee]');?>
        </div>
    </article>
</section>
<?php get_footer();