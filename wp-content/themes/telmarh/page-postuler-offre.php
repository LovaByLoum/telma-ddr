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
get_header(); ?>
	<section id="page-full-entry-content">
	    <div class="grid grid-pad">
		    <div class="col-1-1">
	            <div id="primary" class="content-area">
	                <main id="main" class="site-main" role="main">
	                    <article class="status-publish hentry">
	                        <div>
								<?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
									<header class="entry-header">
			                            <h1 class="entry-title">
                                            Postuler à l'offre
				                            <a href="<?php echo get_permalink( $offre->id );?>">&quot;<?php echo $offre->titre;?>&quot;</a>
			                            </h1>
			                            <!-- .entry-meta -->
		                            </header>
								<?php endif;?>
								<div class="entry-content">
	                                <?php echo apply_filters("the_content", $post->post_content );?>
	                            </div>
		                        <?php echo apply_filters('the_content','[form form-postuler]');?>
							</div>
						</article>
					</main>
	            </div>
		    </div>
		</div>
	</section>

<?php get_footer();