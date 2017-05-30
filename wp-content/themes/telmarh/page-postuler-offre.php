<?php
/**
 * Template Name: Page postuler un offre
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post,$fmdb, $fm_globals;
$offreId = ( isset( $_GET['po'] ) && !empty( $_GET['po'] ) ) ? $_GET['po'] : ( ( isset( $fm_globals['post_data'] ) && !empty( $fm_globals['post_data'] ) ) ? $fm_globals['post_data'][FORMULAIRE_POSTULER_OFFRE]['parent_post_id'] :  0 );
$offre = JM_Offre::getById( $offreId );
$pageInscription = wp_get_post_by_template( "page-inscription.php", "" );
if ( !is_user_logged_in()  ){
	wp_redirect( get_permalink( $pageInscription->ID ) );
}

if ( empty( $_POST ) ) {
	if ( empty( $offre ) || !isset( $_GET['po'] ) ){
		wp_die( 'Vous n\'avez pas le droit d\'accèder à ce lien. Veuillez contactez l\'administrateur.' );
	}
}
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header(); ?>
<section id="page-full-entry-content" class="postuler-form form-page">
	<figure class="alauneImg">
		<?php if ( isset( $image ) && !empty( $image ) ){?>
			<img src="<?php echo $image; ?>" alt="">
		<?php } else {?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
		<?php }?>
	</figure>
	<header class="entry-header">
		<div class="container">
			<?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                <h1 class="entry-title">Postuler à l'offre <a href="<?php echo get_permalink( $offre->id );?>">&quot;<?php echo $offre->titre;?>&quot;</a></h1>
			<?php endif;?>
			<div class="entry-content">
                <?php echo apply_filters("the_content", $post->post_content );?>
            </div>
		</div>
	</header>
	<article class="content-area main-content" id="primary">
		<div class="status-publish hentry container">
			<?php echo apply_filters('the_content','[form form-postuler]');?>
		</div>
	</article>

    <div class="grid grid-pad">
	    <div class="col-1-1">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <article class="status-publish hentry">
                        <div>
							
							
						</div>
					</article>
				</main>
            </div>
	    </div>
	</div>
</section>
<?php get_footer();