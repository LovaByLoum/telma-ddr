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

$idImage = get_post_thumbnail_id($post->ID);
list($image) = wp_get_attachment_image_src( $idImage, "full" );
$imageBackground = ( isset( $image ) && !empty( $image ) ) ? $image : get_template_directory_uri() . '/images/design/bldr.jpg';
$blocService = CPage::getAllElementServiceHp( $post->ID );
$blocPartenaires = CPage::getAllpartnerHp( $post->ID );
$blocTestimonial = CPage::getAllElementTestimonialHp( $post->ID );
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
$offresUrgent = COffre::getOffreUrgent();

$blocConnecterPicto = get_field( "picto_connecter",$post->ID );
$blocConnecterTitre = get_field( "titre_connecter",$post->ID );
$blocConnecterImage = get_field( "image_connecter",$post->ID );
$blocConnecterLien = get_field( "lien_connecter",$post->ID );
$blocConnecterCouleur = get_field( "selection_couleur_connecter",$post->ID );

$blocRecherchePicto = get_field( "picto_recherche",$post->ID );
$blocRechercheTitre = get_field( "titre_recherche",$post->ID );
$blocRechercheImage = get_field( "image_recherche",$post->ID );
$blocRechercheLien = get_field( "lien_recherche",$post->ID );
$blocRechercheCouleur = get_field( "selection_couleur_recherche",$post->ID );

$blocDecouvrirPicto = get_field( "picto_decouvrir",$post->ID );
$blocDecouvrirTitre = get_field( "titre_decouvrir",$post->ID );
$blocDecouvrirImage = get_field( "image_decouvrir",$post->ID );
$blocDecouvrirLien = get_field( "lien_decouvrir",$post->ID );
$blocDecouvrirCouleur = get_field( "selection_couleur_decouvrir",$post->ID );

$blocContacterPicto = get_field( "picto_contacter",$post->ID );
$blocContacterTitre = get_field( "titre_contacter",$post->ID );
$blocContacterImage = get_field( "image_contacter",$post->ID );
$blocContacterLien = get_field( "lien_contacter",$post->ID );
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
list( $imageContacter ) = ( isset( $blocContacterImage ) && !empty( $blocContacterImage ) ) ? wp_get_attachment_image_src( $blocContacterImage, "full" ) : array();
$imgBlocContacter = $imageContacter;
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;

get_header(); ?>
<div class="home-hero"  style="background-image: url('<?php echo $imageBackground;?>');">
    <h1 class="animate-plus animate-init logo-home" data-animations="fadeInDown" data-animation-delay="0.1s"><img src="<?php echo esc_url( get_theme_mod( 'telmarh_logo' ) ); ?>" title="Axian - Let's grow together" /></h1>
</div>
<div class="container">
    <section class="cards">
        <div class="row">
            <!--block connecter-->
            <?php if (isset( $blocConnecterLien ) &&  !empty( $blocConnecterLien ) && isset( $blocConnecterTitre ) && !empty( $blocConnecterTitre ) && isset( $blocConnecterPicto ) && !empty( $blocConnecterPicto ) ):?>
            <div class="col-md-6 col-lg-4 card-item ">
                <div class="animate-plus animate-init" data-animations="bounceIn" data-animation-delay="0.5s">
                    <div class="connecter animate-tilt" style="background-image: url(<?php print_r($imgBlocConnecter); ?>); background-color: <?php print_r($blocConnecterCouleur); ?>;">
                        <a href="<?php print_r($blocConnecterLien); ?>">
                            <p><i class="fa <?php echo $blocConnecterPicto; ?>"></i></p>
                            <p> <?php print_r($blocConnecterTitre); ?> </p>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <!--block Recheche-->
            <?php if ( isset( $blocRechercheLien ) && !empty( $blocRechercheLien ) && isset( $blocRechercheTitre ) && !empty( $blocRechercheTitre ) && isset( $blocRecherchePicto ) && !empty( $blocRecherchePicto ) ):?>
            <div class="col-md-6  col-lg-4 card-item">
                <div class="animate-plus" data-animations="bounceIn" data-animation-delay="0.8s">
                    <div class="rechercher animate-tilt" style="background-color: <?php print_r($blocRechercheCouleur); ?>;">
                        <a href="<?php print_r($blocRechercheLien); ?>">
                            <p><i class="fa <?php echo $blocRecherchePicto; ?>"></i></p>
                            <p><?php print_r($blocRechercheTitre); ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <!--block Découvrir-->
            <?php if ( isset( $blocDecouvrirLien ) && !empty( $blocDecouvrirLien ) && isset( $blocDecouvrirTitre ) && !empty( $blocDecouvrirTitre ) && isset( $blocRechercheTitre ) && isset( $blocDecouvrirPicto ) && !empty( $blocDecouvrirPicto ) ):?>
            <div class="col-md-6 col-lg-4 card-item">
                <div class="animate-plus" data-animations="bounceIn" data-animation-delay="1s">
                    <div class="decouvrir animate-tilt" style="background-image: url(<?php print_r($imgBlocDecouvrir); ?>); background-color: <?php print_r($blocContacterCouleur); ?>;">
                        <a href="<?php print_r($blocDecouvrirLien); ?>">
                            <p><i class="fa <?php echo $blocDecouvrirPicto; ?>"></i></p>
                            <p><?php print_r($blocDecouvrirTitre); ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <!--block contacter-->
            <?php if ( isset( $blocContacterLien ) && !empty( $blocContacterLien ) && isset( $blocContacterTitre ) && !empty( $blocContacterTitre ) && isset( $blocRechercheTitre ) && isset( $blocContacterPicto ) && !empty( $blocContacterPicto ) ):?>
            <div class="col-lg-8 card-item">
                <div class="animate-plus" data-animations="bounceIn" data-animation-delay="1.2s">
                    <div class="contacter animate-tilt" style="background-image: url(<?php print_r($imgBlocContacter); ?>); background-color: <?php print_r($blocDecouvrirCouleur); ?>;">
                        <a href="<?php print_r($blocContacterLien); ?>">
                        <p><i class="fa <?php echo $blocContacterPicto; ?>"></i></p>
                            <p><?php print_r($blocContacterTitre); ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </section>
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

    <section class="job-last">
        <!-- offres urgents -->
        <?php if ( !empty( $offresUrgent ) && count( $offresUrgent ) > 0 ){?>
            <h3 class="widget-title"><a href="<?php echo get_permalink($postOffes->ID);?>" title="Nos dernières offres" style="color:#c80f2d;text-decoration: none;text-transform: uppercase;"> Nos dernières offres </a><i class="fa fa-search"></i></h3>
            <?php
            foreach( $offresUrgent as $offre ){ ?>
                <div class="job-item">
                    <div class="row">
                        <?php $urlImage = $offre->logo[0];?>
                        <?php if ( !empty( $urlImage ) ):?>
                            <div class="col-sm-3 img-show">
                                <figure>
                                    <img src="<?php echo $urlImage;?>"/>
                                </figure>
                            </div>
                        <?php endif;?>
                        <div class="col-sm-9">
                            <h5><a href="<?php echo get_permalink( $offre->id );?>" title="<?php echo $offre->titre;?>"><?php echo $offre->titre;?></a> <span class="label">Urgent</span></h5>
                            <p class="summary">
                                <?php if ( isset( $offre->nameEntreprise ) && !empty( $offre->nameEntreprise ) ):?>
                                    Entreprise : <?php echo $offre->nameEntreprise;?><br>
                                <?php endif;?>
                                <?php if ( isset( $offre->type_contrat ) && !empty( $offre->type_contrat ) ):?>
                                    Type de contrat  : <?php echo $offre->type_contrat;?><br>
                                <?php endif;?>
                            </p>

                            <p  class="desc">
                                <?php echo wp_limite_text( $offre->desc, 200 );?>
                            </p>

                            <p  class="link">
                                <a href="<?php echo get_permalink( $offre->id );?>" class="link-more" title="Voir les missions">
                                    Voir les missions
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            <?php }?>
        <?php }?>
    </section>
</div>
<?php get_footer(); ?>
