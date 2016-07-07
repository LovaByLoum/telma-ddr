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
list( $image ) = ( isset( $post->image_background_hp ) && !empty( $post->image_background_hp ) ) ? wp_get_attachment_image_src( $post->image_background_hp, "full" ) : array();
$imageBackground = ( isset( $image ) && !empty( $image ) ) ? $image : get_template_directory_uri() . '/images/design/bldr.jpg';
$blocService = CPage::getAllElementServiceHp( $post->ID );
$blocPartenaires = CPage::getAllpartnerHp( $post->ID );
$blocTestimonial = CPage::getAllElementTestimonialHp( $post->ID );
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
$offresUrgent = COffre::getOffreUrgent();
get_header('home'); ?>
     <section id="home-hero">

     	<div class="telmarh-hero-bg" style="background-image: url('<?php echo $imageBackground;?>');"></div>

        <div class="telmarh-hero-content-container">
            <div class="telmarh-hero-content">
                <h1 class="animate-plus animate-init" data-animations="fadeInDown" data-animation-delay="0.5s">
					<?php echo $description;?>
                </h1>
	            <aside class="widget widget_search homepage">
	            <form role="search" method="get" class="search-form" action="<?php echo get_permalink( $postOffes->ID );?>" autocomplete="off">
                    <label>
                    <span class="screen-reader-text">Search for:</span>
                    <input class="search-field offre" placeholder="Rechercher une offre …" value="" name="sof" type="search">
                    </label>
                    <input class="search-submit" value="Search" type="submit">
                </form>
                <p class="separator">
                    <span>ou</span>
                </p>
	            </aside>

	            <p class="animate-plus animate-init link_formation" data-animations="fadeInUp" data-animation-delay="1.5s">
                    <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link button--wapasha button--round-l">
	                    <span>
		                    Accéder directement aux offres
                        </span>
                    </a>
                </p>
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
															<?php foreach ( $blocService['element'] as $element ):
																	$infosLink = ( isset($element->link ) && !empty( $element->link ) ) ? $element->link : array() ;
																	$link = ( isset( $infosLink['link'] ) && !empty( $infosLink['link'] ) ) ? $infosLink['link'] : "";
																	$label = ( isset( $infosLink['label'] ) && !empty( $infosLink['label'] ) ) ? $infosLink['label'] : $element->titre; ?>
															<div class="col-1-3 tri-clear">
																<div class="single-service">
																	<?php if ( isset( $element->fontClass ) && !empty( $element->fontClass ) ):?>
																		<a href="<?php echo $link;?>" title="<?php echo $label;?>">
																			<i class="fa <?php echo $element->fontClass;?> service-icon"></i>
																		</a>
																	<?php endif;?>
																	<?php if ( isset( $element->titre ) && !empty( $element->titre ) ): ?>
																		<h3 class="service-title">
																			<a href="<?php echo $link;?>" title="<?php echo $label;?>">
																				<?php echo $element->titre;?>
																			</a>
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
													   class="submit_link button--wapasha button--round-l">
														<?php echo $blocService['text_bouton'];?>
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
																				<a href="<?php echo $slider->link;?>" title="<?php echo $slider->name;?>">
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
									<?php if ( !empty( $blocTestimonial ) && count( $blocTestimonial ) > 0 ):?>
									<div class="panel-grid" id="pg-636-5">
										<div class="panel-grid-cell" id="pgc-636-5-0">
											<section id="home-testimonials" class="testimonials">
												<?php if ( isset( $blocTestimonial['titre'] ) && !empty( $blocTestimonial['titre'] ) ):?>
												<div class="grid grid-pad">
													<div class="col-1-1">
														<h3 class="widget-title">
															<?php echo $blocTestimonial['titre'];?>
														</h3>
													</div>
												</div>
												<?php endif;?>
												<?php if ( isset( $blocTestimonial['element'] ) && !empty( $blocTestimonial['element'] ) ):?>
												<div class="grid grid-pad overflow">
													<?php foreach ( $blocTestimonial['element'] as $data ):?>
													<div class="col-1-3 tri-clear">
														<div class="testimonial">
															<?php if ( isset( $data->imageUrl ) && !empty( $data->imageUrl )  ):?>
															<img
																src="<?php echo $data->imageUrl;?>"
																class="testimonial-img wp-post-image"
															    <?php if ( isset( $data->imageTronque ) && !empty( $data->imageTronque ) ):?>
															    width="<?php echo $data->imageTronque[0];?>"
															    height="<?php echo $data->imageTronque[1];?>"
															    style="<?php echo $data->imageTronque[2];?>"
																<?php  endif;?>
																>
															<?php endif;?>
															<?php if ( isset( $data->desc ) && !empty( $data->desc ) ):?>
																<p>
																	<?php echo $data->desc;?>
																</p>
															<?php endif;?>
															<?php if ( isset( $data->auteur ) && !empty( $data->auteur ) ):?>
																<h3><?php echo $data->auteur;?></h3>
															<?php endif;?>
															<?php if ( isset( $data->profession ) && !empty( $data->profession ) ):?>
																<h4><?php echo $data->profession;?></h4>
															<?php endif;?>
														</div>
													</div>
													<?php endforeach;?>
												</div>
												<?php endif;?>
											</section>


										</div>
									</div>
									<?php endif;?>
									<?php if ( !empty( $offresUrgent ) && count( $offresUrgent ) > 0 ):?>
									<div class="panel-grid" id="pg-636-7">
										<div class="panel-grid-cell" id="pgc-636-7-0">
											<section id="home-news" class="home-news-area">

												<div class="grid grid-pad">
													<div class="col-1-1">
														<h3 class="widget-title">Les dernières offres urgentes</h3>
													</div>
													<!-- col-1-1 -->
												</div>
												<!-- grid -->

												<div class="grid grid-pad">
													<?php foreach( $offresUrgent as $offre ):?>
													<div class="col-1-3 tri-clear">
														<h5><strong><?php echo $offre->titre;?></strong></h5>

														<p>
															<?php echo $offre->desc;?>
														</p>
														<?php if ( isset( $offre->nameEntreprise ) && !empty( $offre->nameEntreprise ) ):?>
															<p><strong>Entreprise : </strong><em><?php echo $offre->nameEntreprise;?></em></p>
														<?php endif;?>

														<?php if ( isset( $offre->type_contrat ) && !empty( $offre->type_contrat ) ):?>
															<p><strong>Type de cotrat  : </strong><em><?php echo $offre->type_contrat;?></em></p>
														<?php endif;?>
														<a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link button--wapasha button--round-l" title="En savoir plus">
															En savoir plus
														</a>
													</div>
													<!-- col-1-3 -->
													<?php endforeach;?>
												</div>
												<!-- grid -->


											</section>

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
