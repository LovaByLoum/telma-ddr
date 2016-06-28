<?php
/**
 * Template Name: Accueil
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post;
$description = ( isset( $post->texte_descriptif_hp ) && !empty( $post->texte_descriptif_hp ) ) ? $post->texte_descriptif_hp : "";
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
get_header(); ?>
	<?php if ( !empty( $description ) ):?>
		<section class="services description">
			<div class="grid grid-pad">
		        <div class="col-1-1">
		            <p class="widget-title" style="text-transform: none;font-size: 30px;">
			            <?php echo  $description;?>
		            </p>
		        </div>
		    </div>
		</section>
	<?php endif;?>
	<section>
	    <div class="grid grid-pad">
	        <div class="col-1-1">
		        <aside class="widget_search">
                    <input class="search-field" placeholder="Recherche offre ..." value="" name="offre" type="search" style="width: 70%;margin: 0 auto;padding: 8px;font-size: 1.6em;" title="Recherche offre">
                    <input class="" value="Search" type="submit">
			        <p class="separator">
				        <span>ou</span>
			        </p>

			        <p class="link_formation">
				        <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link" title="Accéder directement aux offres">Accéder directement aux offres</a>
			        </p>

		        </aside>
	        </div><!-- col-1-1 -->
	    </div><!-- grid -->
	</section><!-- page-full-entry-content -->
	<section  id="page-full-entry-content-homepage" >
		<div class="grid grid-pad">
			<div class="col-1-1">
				<div id="primary" class="content-area homepage">
			        <main id="main" class="site-main" role="main">
			            <?php while ( have_posts() ) : the_post(); ?>

			                <?php get_template_part( 'content', 'page' ); ?>

			            <?php endwhile; // end of the loop. ?>

			        </main><!-- #main -->
			    </div><!-- #primary -->
		    </div><!-- #primary -->
        </div><!-- #primary -->
	</section>

<?php get_footer(); ?>