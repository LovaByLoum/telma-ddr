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
//var_dump($offresUrgent);die;

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
list( $imageContacter ) = ( isset( $blocContacterImage ) && !empty( $blocContacterImage ) ) ? wp_get_attachment_image_src( $blocContacterImage, "full" ) : array();
$imgBlocContacter = $imageContacter;

get_header(); ?>
<div class="home-hero"  style="background-image: url('<?php echo $imageBackground;?>');">
    <h1 class="animate-plus animate-init logo-home" data-animations="fadeInDown" data-animation-delay="0.1s"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-rgb.png" title="Axian - Let's grow together" /></h1>
</div>
<div class="container">
    <section class="cards">
        <div class="row">
            <!--block connecter-->
            <?php if (isset( $blocConnecterLien ) &&  !empty( $blocConnecterLien ) && isset( $blocConnecterTitre ) && !empty( $blocConnecterTitre ) && isset( $blocConnecterPicto ) && !empty( $blocConnecterPicto ) ):?>
            <div class="col-md-6 col-lg-4 card-item ">
                <div class="connecter animate-plus animate-init" data-animations="bounceIn" data-animation-delay="0.5s" style="background-image: url(<?php print_r($imgBlocConnecter); ?>); background-color: <?php print_r($blocConnecterCouleur); ?>;">
                    <a href="<?php print_r($blocConnecterLien); ?>">
                        <p><i class="fa <?php echo $blocConnecterPicto; ?>"></i></p>
                        <p> <?php print_r($blocConnecterTitre); ?> </p>
                    </a>
                </div>
            </div>
            <?php endif;?>
            <!--block Recheche-->
            <?php if ( isset( $blocRechercheLien ) && !empty( $blocRechercheLien ) && isset( $blocRechercheTitre ) && !empty( $blocRechercheTitre ) && isset( $blocRechercheTitre ) && isset( $blocRecherchePicto ) && !empty( $blocRecherchePicto ) ):?>
            <div class="col-md-6  col-lg-4 card-item">
                <div class="rechercher  animate-plus"  data-animations="bounceIn" data-animation-delay="0.8s" style="background-color: <?php print_r($blocRechercheCouleur); ?>;">
                    <a href="<?php print_r($blocRechercheLien); ?>">
                        <p><i class="fa <?php echo $blocRecherchePicto; ?>"></i></p>
                        <p><?php print_r($blocRechercheTitre); ?></p>
                    </a>
                </div>
            </div>
            <?php endif;?>
            <!--block Découvrir-->
            <?php if ( isset( $blocDecouvrirLien ) && !empty( $blocDecouvrirLien ) && isset( $blocDecouvrirTitre ) && !empty( $blocDecouvrirTitre ) && isset( $blocRechercheTitre ) && isset( $blocDecouvrirPicto ) && !empty( $blocDecouvrirPicto ) ):?>
            <div class="col-md-6 col-lg-4 card-item">
                <div class="decouvrir  animate-plus"  data-animations="bounceIn" data-animation-delay="1s"  style="background-image: url(<?php print_r($imgBlocDecouvrir); ?>); background-color: <?php print_r($blocContacterCouleur); ?>;">
                    <a href="<?php print_r($blocDecouvrirLien); ?>">
                        <p><i class="fa <?php echo $blocDecouvrirPicto; ?>"></i></p>
                        <p><?php print_r($blocDecouvrirTitre); ?></p>
                    </a>
                </div>
            </div>
            <?php endif;?>
            <!--block contacter-->
            <?php if ( isset( $blocContacterLien ) && !empty( $blocContacterLien ) && isset( $blocContacterTitre ) && !empty( $blocContacterTitre ) && isset( $blocRechercheTitre ) && isset( $blocContacterPicto ) && !empty( $blocContacterPicto ) ):?>
            <div class="col-lg-8 card-item">
                <div class="contacter  animate-plus"  data-animations="bounceIn" data-animation-delay="1.2s"  style="background-image: url(<?php print_r($imgBlocContacter); ?>); background-color: <?php print_r($blocDecouvrirCouleur); ?>;">
                    <a href="<?php print_r($blocContacterLien); ?>">
                    <p><i class="fa <?php echo $blocContacterPicto; ?>"></i></p>
                        <p><?php print_r($blocContacterTitre); ?></p>
                    </a>
                </div>
            </div>
            <?php endif;?>
        </div>
    </section>
    <section class="job-last">
        <!-- offres urgents -->
        <?php if ( !empty( $offresUrgent ) && count( $offresUrgent ) > 0 ){
            $i = 1;?>
            <h3 class="widget-title">NOS OFFRES <i class="fa fa-search"></i></h3>
            <?php
            $count = 0;
            foreach( $offresUrgent as $offre ){ ?>
                <div class="job-item">
                    <div class="row">
                        <?php $urlImage = $offre->logo[0];?>
                        <?php if ( !empty( $urlImage ) && $i%2 == 1 ):?>
                            <figure class="col-sm-3 <?php if ( $count % 2  != 0 ) {?> right <?php }?>"><img src="<?php echo $urlImage;?>"/></figure>
                        <?php endif;?>
                        <div class="col-sm-9">
                            <h5><a href="<?php echo get_permalink( $offre->id );?>" title="<?php echo $offre->titre;?>"><?php echo $offre->titre;?></a> <span class="label">urgent</span></h5>
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
            <?php $count ++; }?>
        <?php }?>
    </section>
</div>

<?php get_footer(); ?>
