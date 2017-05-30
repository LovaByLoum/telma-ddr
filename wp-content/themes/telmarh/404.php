<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package telmarh
 */

get_header(); ?>
<article class="error-404 not-found">
	<figure class="alauneImg">
        <img src="<?php echo get_template_directory_uri(); ?>/images/404-2000w.jpg" alt="">
    </figure>
	<header class="page-header">
		<h1 class="page-title">404 <span>error</span></h1>
		<p><?php echo __('Désolé, cette page est introuvable');?></p>
	</header><!-- .page-header -->

	<div class="page-content">
		
	</div><!-- .page-content -->
	<p class="btn">
      <a href="<?php echo home_url(); ?>" title="Retour" class="submit_link"><?php echo __('Retour','telmarh');?></a>
    </p>
</article>

<?php get_footer(); ?>
