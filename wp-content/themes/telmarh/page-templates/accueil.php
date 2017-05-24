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

$blocConnecterPicto = get_field( "picto_connecter",$post->ID );
$blocConnecterTitre = get_field( "titre_connecter",$post->ID );
$blocConnecterImage = get_field( "image_connecter",$post->ID );
$blocConnecterLien = get_field( "lien_connecter",$post->ID );
$blocConnecterCouleur = get_field( "selection_couleur_connecter",$post->ID );

$blocRecherchePicto = get_field( "picto_recherche",$post->ID );
$blocRechercheTitre = get_field( "titre_recherche",$post->ID );
$blocRechercheImage = get_field( "image_recherche",$post->ID );
$blocRechercheLien = get_field( "titre_recherche",$post->ID );
$blocRechercheCouleur = get_field( "selection_couleur_recherche",$post->ID );

$blocDecouvrirPicto = get_field( "picto_decouvrir",$post->ID );
$blocDecouvrirTitre = get_field( "titre_decouvrir",$post->ID );
$blocDecouvrirImage = get_field( "image_decouvrir",$post->ID );
$blocDecouvrirLien = get_field( "lien_decouvrir",$post->ID );
$blocDecouvrirCouleur = get_field( "selection_couleur_decouvrir",$post->ID );

$blocContacterPicto = get_field( "picto_contacter",$post->ID );
$blocContacterTitre = get_field( "titre_contacter",$post->ID );
$blocContacterImage = get_field( "image_contacter",$post->ID );
$blocContacterLien = get_field( "lient_contacter",$post->ID );
$blocContacterCouleur = get_field( "selection_couleur_contacter",$post->ID );

// image pour block connecter
list( $imageConnecter ) = ( isset( $blocConnecterImage ) && !empty( $blocConnecterImage ) ) ? wp_get_attachment_image_src( $blocConnecterImage, "full" ) : array();
$imgBlocConnecter = $imageConnecter;

// image pour block recherche
list( $imageRecherche ) = ( isset( $blocRechercheImage ) && !empty( $blocRechercheImage ) ) ? wp_get_attachment_image_src( $blocRechercheImage, "full" ) : array();
$imgBlocRecherche = $imageRecherche;

// image pour block découvrir
list( $imageDecouvrir ) = ( isset( $blocDecouvrirImage ) && !empty( $blocDecouvrirImage ) ) ? wp_get_attachment_image_src( $blocDecouvrirImage, "full" ) : array();
$imgBlocDecouvrir = $imageDecouvrir;

// image pour block contatcer
list( $imageContacter ) = ( isset( $blocConnecterImage ) && !empty( $blocConnecterImage ) ) ? wp_get_attachment_image_src( $blocConnecterImage, "full" ) : array();
$imgBlocContacter = $imageContacter;

get_header(); ?>
     <section id="home-hero">
     	<div class="telmarh-hero-bg" style="background-image: url('<?php echo $imageBackground;?>');"></div>
        <div class="telmarh-hero-content-container">
            <div class="telmarh-hero-content">
                <h1 class="animate-plus animate-init" data-animations="fadeInDown" data-animation-delay="0.5s">
					<?php echo $description;?>
                </h1>
				<!--block connecter-->
				<p><i class="fa <?php echo $blocConnecterPicto; ?>"></i></p>
				<a href="<?php print_r($blocConnecterLien); ?>">
					<p>
						<?php print_r($blocConnecterTitre); ?>
						<img src="<?php print_r($imgBlocConnecter); ?>" class="" width="" height="">
					</p>
				</a>

				<!--block Recheche-->
				<p><i class="fa <?php echo $blocRecherchePicto; ?>"></i></p>
				<a href="<?php print_r($blocRechercheLien); ?>">
					<p>
						<?php print_r($blocRechercheTitre); ?>
						<img src="<?php print_r($imgBlocRecherche); ?>" class=" " width="" height="">
					</p>
				</a>

				<!--block Découvrir-->
				<p><i class="fa <?php echo $blocDecouvrirPicto; ?>"></i></p>
				<a href="<?php print_r($blocDecouvrirLien); ?>">
					<p>
						<?php print_r($blocDecouvrirTitre); ?>
						<img src="<?php print_r($imgBlocDecouvrir); ?>" class=" " width="" height="">
					</p>
				</a>

				<!--block connecter-->
				<p><i class="fa <?php echo $blocContacterPicto; ?>"></i></p>
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
									<?php if ( !empty( $offresUrgent ) && count( $offresUrgent ) > 0 ):
											$i = 1;?>
									<div class="panel-grid" id="pg-636-7">
										<div class="panel-grid-cell" id="pgc-636-7-0">
											<section id="home-news" class="home-news-area">

												<div class="grid grid-pad">
													<div class="col-1-1">
														<h3 class="widget-title">Nos offres</h3>
													</div>
													<!-- col-1-1 -->
												</div>
												<!-- grid -->

												<div class="grid grid-pad">
													<?php foreach( $offresUrgent as $offre ):?>
														<?php list($urlImage) = ( isset( $offre->logo ) && !empty( $offre->logo ) ) ? $offre->logo : array();?>
															<?php if ( !empty( $urlImage ) && $i%2 == 1 ):?>
																<img src="<?php echo $urlImage;?>"/>
															<?php endif;?>
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
														<?php if ( !empty( $urlImage ) && $i%2 == 0 ):?>
															<img src="<?php echo $urlImage;?>"/>
														<?php endif;?>
													</div>
													<!-- col-1-3 -->
													<?php 	$i++;
															endforeach;?>
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
