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
$blocService = CPage::getAllElementServiceHp( $post->ID );
$blocPartenaires = CPage::getAllpartnerHp( $post->ID );
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
get_header('home'); ?>
     <section id="home-hero">

     	<div class="telmarh-hero-bg" style="background-image: url('<?php echo get_template_directory_uri()?>/images/design/bldr.jpg');"></div>

        <div class="telmarh-hero-content-container">
            <div class="telmarh-hero-content">
                <h1 class="animate-plus animate-init" data-animations="fadeInDown" data-animation-delay="0.5s">
					<?php echo $description;?>
                </h1>
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
	            </aside>

                <a href="<?php echo get_permalink( $postOffes->ID );?>" class="featured-link">
                    <span class="animate-plus animate-init" data-animations="fadeInUp" data-animation-delay="1.5s">
                        <button>
	                        Accéder directement aux offres
                        </button>
                    </span>
                </a>
	            <h2 class="animate-plus animate-init" data-animations="fadeIn" data-animation-delay="1s">
                    <?php echo apply_filters("the_content", $post->post_content)?>
                </h2>
        	</div>
    	</div>
    </section>
	<section>

	<section id="home-content">
        <div class="grid-home grid-home-pad">
			<div class="col-home">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
						<article id="post-636" class="post-636 page type-page status-publish hentry">
							<div class="home-entry-content">
								<div id="pl-636">
									<?php if ( !empty( $blocService ) ) :?>
									<div class="panel-grid" id="pg-636-2">
										<div  class="panel-row-style">
											<div class="panel-grid-cell" id="pgc-636-2-0">
												<section id="home-services" class="services">
													<!--titre-->
													<?php if ( isset( $blocService['titre'] ) ):?>
														<div class="grid grid-pad">
															<div class="col-1-1">
																<h3 class="widget-title">
																	<?php echo $blocService['titre'];?>
																</h3>
															</div>
														</div>
													<?php endif;?>
													<!--titre-->
													<!--elements-->
													<?php if ( isset( $blocService['element'] ) && count( $blocService['element'] ) > 0 ):?>
														<div class="grid grid-pad">
															<?php foreach ( $blocService['element'] as $element ):?>
															<div class="col-1-3 tri-clear">
																<div class="single-service">
																	<?php if ( isset( $element->fontClass ) && !empty( $element->fontClass ) ):?>
																		<i class="fa <?php echo $element->fontClass;?> service-icon"></i>
																	<?php endif;?>
																	<?php if ( isset( $element->titre ) && !empty( $element->titre ) ): ?>
																		<h3 class="service-title">
																			<?php echo $element->titre;?>
																		</h3>
																	<?php endif;?>
																	<?php if ( isset( $element->description ) && !empty( $element->description ) ):?>
																		<p>
																			<?php echo $element->description;?>
																		</p>
																	<?php endif;?>
																</div>
															</div>
															<?php endforeach;?>
														</div>
													<?php endif;?>
													<!--elements-->
													<?php if ( isset( $blocService['lien'] ) && !empty( $blocService['lien'] ) ):?>
													<a href="<?php echo $blocService['lien'];?>"
													   class="telmarh-home-widget">
														<button><?php echo $blocService['text_bouton'];?></button>
													</a>
													<?php endif;?>
												</section>
											</div>
										</div>
									</div>
									<?php endif;?>
									<?php if ( isset( $blocPartenaires ) && !empty( $blocPartenaires ) ):?>
									<div class="panel-grid" id="pg-636-6">
										<div  class="panel-row-style">
											<div class="panel-grid-cell" id="pgc-636-6-0">
												<section id="home-clients" class="clients">
													<?php if ( isset( $blocPartenaires['titre'] ) && !empty( $blocPartenaires['titre'] ) ):?>
													<div class="grid grid-pad">
														<div class="col-1-1">
															<h3 class="widget-title">
																<?php echo $blocPartenaires['titre'];?>
															</h3>
														</div>
													</div>
													<?php  endif;?>
													<?php if ( isset( $blocPartenaires['element'] ) && !empty( $blocPartenaires['element'] ) ):?>
													<div class="grid grid-pad">
														<div class="col-1-1">
															<div class="client-carousel slick-initialized slick-slider">
																<div tabindex="0" aria-live="polite"
																     class="slick-list draggable">
																	<div class="slick-track">
																		<?php foreach ( $blocPartenaires['element'] as $slider ):?>
																		<div>
																			<?php if ( isset( $slider->imageUrl ) && !empty( $slider->imageUrl ) ):?>
																				<a href="<?php echo $slider->link;?>">
																			<div class="client-container">
																					<img
																					src="<?php echo $slider->imageUrl;?>"
																					class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
																				    <?php if ( isset( $slider->imageTronque ) && !empty( $slider->imageTronque ) ):?>
																					    width="<?php echo $slider->imageTronque[0];?>"
																					    height="<?php echo $slider->imageTronque[1];?>"
																					<?php endif;?>
																					>
																			</div>
																				</a>
																			<?php endif;?>
																		</div>
																		<?php endforeach;?>
																	</div>
																</div>
															</div>
														</div>
													</div >
													<?php endif;?>
												</section>
											</div>
										</div>
									</div>
									<?php endif;?>
								</div>
							</div>
						</article>
                    </main>
                </div>
			</div>
        </div>
	</section>

<?php get_footer(); ?>
