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

$offresUrgent = COffre::getOffreUrgent();

$blocConnecterPicto = get_field( "picto_connecter","option" );
$blocConnecterTitre = get_field( "titre_connecter","option" );
$blocConnecterImage = get_field( "image_connecter","option" );
$blocConnecterLien = get_field( "lien_connecter","option" );

$blocRecherchePicto = get_field( "picto_recherche","option" );
$blocRechercheTitre = get_field( "titre_recherche","option" );
$blocRechercheImage = get_field( "image_recherche","option" );
$blocRechercheLien = get_field( "titre_recherche","option" );

$blocDecouvrirPicto = get_field( "picto_decouvrir","option" );
$blocDecouvrirTitre = get_field( "titre_decouvrir","option" );
$blocDecouvrirImage = get_field( "image_decouvrir","option" );
$blocDecouvrirLien = get_field( "lien_decouvrir","option" );

$blocContacterPicto = get_field( "picto_contacter","option" );
$blocContacterTitre = get_field( "titre_contacter","option" );
$blocContacterImage = get_field( "image_contacter","option" );
$blocContacterLien = get_field( "lient_contacter","option" );

// image pour block connecter
list( $imageConnecter ) = ( isset( $blocConnecterImage ) && !empty( $blocConnecterImage ) ) ? wp_get_attachment_image_src( $blocConnecterImage, "full" ) : array();
list( $pictoConnecter ) = ( isset( $blocConnecterPicto ) && !empty( $blocConnecterPicto ) ) ? wp_get_attachment_image_src( $blocConnecterPicto, "full" ) : array();
$imgBlocConnecter = $imageConnecter;
$pictoBlocConnecter = $pictoConnecter;

// image pour block recherche
list( $imageRecherche ) = ( isset( $blocRechercheImage ) && !empty( $blocRechercheImage ) ) ? wp_get_attachment_image_src( $blocRechercheImage, "full" ) : array();
list( $pictoRecherche ) = ( isset( $blocRecherchePicto ) && !empty( $blocRecherchePicto ) ) ? wp_get_attachment_image_src( $blocRecherchePicto, "full" ) : array();
$imgBlocRecherche = $imageRecherche;
$pictoBlocRecherche = $pictoRecherche;

// image pour block découvrir
list( $imageDecouvrir ) = ( isset( $blocDecouvrirImage ) && !empty( $blocDecouvrirImage ) ) ? wp_get_attachment_image_src( $blocDecouvrirImage, "full" ) : array();
list( $pictoDecouvrir ) = ( isset( $blocDecouvrirPicto ) && !empty( $blocDecouvrirPicto ) ) ? wp_get_attachment_image_src( $blocDecouvrirPicto, "full" ) : array();
$imgBlocDecouvrir = $imageDecouvrir;
$pictoBlocDecouvir = $pictoDecouvrir;

// image pour block contatcer
list( $imageContacter ) = ( isset( $blocConnecterImage ) && !empty( $blocConnecterImage ) ) ? wp_get_attachment_image_src( $blocConnecterImage, "full" ) : array();
list( $pictoContacter ) = ( isset( $blocContacterPicto ) && !empty( $blocContacterPicto ) ) ? wp_get_attachment_image_src( $blocContacterPicto, "full" ) : array();
$imgBlocContacter = $imageContacter;
$pictoBlocContacter = $pictoContacter;

get_header('home'); ?>
     <section id="home-hero">
     	<div class="telmarh-hero-bg" style="background-image: url('<?php echo $imageBackground;?>');"></div>
        <div class="telmarh-hero-content-container">
            <div class="telmarh-hero-content">
                <h1 class="animate-plus animate-init" data-animations="fadeInDown" data-animation-delay="0.5s">
					<?php echo $description;?>
                </h1>
				<!--block connecter-->
				<p><img src="<?php print_r($pictoBlocConnecter); ?>" class="" width="" height=""></p>
				<a href="<?php print_r($blocConnecterLien); ?>">
					<p>
						<?php print_r($blocConnecterTitre); ?>
						<img src="<?php print_r($imgBlocConnecter); ?>" class="" width="" height="">
					</p>
				</a>

				<!--block Recheche-->
				<p><img src="<?php print_r($pictoBlocRecherche); ?>" class=" " width="" height=""></p>
				<a href="<?php print_r($blocRechercheLien); ?>">
					<p>
						<?php print_r($blocRechercheTitre); ?>
						<img src="<?php print_r($imgBlocRecherche); ?>" class=" " width="" height="">
					</p>
				</a>

				<!--block Découvrir-->
				<p><img src="<?php print_r($pictoBlocDecouvir); ?>" class=" " width="" height=""></p>
				<a href="<?php print_r($blocDecouvrirLien); ?>">
					<p>
						<?php print_r($blocDecouvrirTitre); ?>
						<img src="<?php print_r($imgBlocDecouvrir); ?>" class=" " width="" height="">
					</p>
				</a>

				<!--block connecter-->
				<p><img src="<?php print_r($pictoBlocContacter); ?>" class=" " width="" height=""></p>
				<a href="<?php print_r($blocContacterLien); ?>">
					<p>
						<?php print_r($blocContacterTitre); ?>
						<img src="<?php print_r($imgBlocContacter); ?>" class=" " width="" height="">
					</p>
				</a>
			</div>
    	</div>
    </section>

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
														<h5><a href="<?php echo get_permalink( $offre->id );?>" title="<?php echo $offre->titre;?>"><strong><?php echo $offre->titre;?></strong></a></h5>

														<p>
															<?php echo wp_limite_text( $offre->desc, 200 );?>
														</p>
														<?php if ( isset( $offre->nameEntreprise ) && !empty( $offre->nameEntreprise ) ):?>
															<p><strong>Entreprise : </strong><em><?php echo $offre->nameEntreprise;?></em></p>
														<?php endif;?>

														<?php if ( isset( $offre->type_contrat ) && !empty( $offre->type_contrat ) ):?>
															<p><strong>Type de contrat  : </strong><em><?php echo $offre->type_contrat;?></em></p>
														<?php endif;?>
														<a href="<?php echo get_permalink( $offre->id );?>" class="submit_link button--wapasha button--round-l" title="En savoir plus">
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
