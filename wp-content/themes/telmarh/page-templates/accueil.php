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
		        <aside class="widget widget_search homepage">
			        <form role="search" method="get" class="search-form" action="<?php echo get_permalink( $postOffes->ID );?>" autocomplete="off">
	                    <label>
	                    <span class="screen-reader-text">Search for:</span>
	                    <input class="search-field offre" placeholder="Recherche offre …" value="" name="sof" type="search">
	                    </label>
	                    <input class="search-submit" value="Search" type="submit">
                    </form>
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