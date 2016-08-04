<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package telmarh
 */

get_header(); ?>

	<div class="grid grid-pad">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'telmarh' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>
			          <strong><?php echo __('Cette page n’est malheureusement pas disponible.','telmarh');?></strong>
			          <?php echo __('Le lien que vous avez suivi peut être incorrect ou la page peut avoir été supprimée.','telmarh');?>
			        </p>
				</div><!-- .page-content -->
				<p class="btn">
		          <a href="<?php echo home_url(); ?>" title="Retour" class="submit_link button--wapasha button--round-l"><?php echo __('Retour','telmarh');?></a>
		        </p>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
    </div><!-- grid -->

<?php get_footer(); ?>
