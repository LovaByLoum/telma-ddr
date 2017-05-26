<?php
/**
 * The template for displaying all single posts.
 *
 * @package telmarh
 */
global $post;
$offre = JM_Offre::getById( $post->ID );
$offreElment = COffre::getById( $post->ID );
$idEntreprise = ( isset( $offre->societe_associe ) && !empty( $offre->societe_associe ) ) ? $offre->societe_associe : "";
$society = ( intval( $idEntreprise ) > 0 ) ? JM_Societe::getById( $idEntreprise ) : "";
$postOffes = ( is_object( wp_get_post_by_template( "offres.php" ) ) ) ?  wp_get_post_by_template( "offres.php" ) : $post;
$competenceRequis = COffre::getCompetenceRequis( $post->ID );
$domaineEtude = COffre::getCompetenceRequis( $post->ID, JM_TAXONOMIE_DOMAINE_ETUDE );
$pageInscription = wp_get_post_by_template( "page-inscription.php", "" );
$pagePostuleOffre = wp_get_post_by_template( "page-postuler-offre.php", "" );
$linkPostule = ( is_user_logged_in() ) ? get_permalink( $pagePostuleOffre->ID ) ."?po=" . $post->ID : "javascript:;";
get_header(); ?>
<div class="listing-offer-page offer-page">
    <figure class="alauneImg">
        <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
    </figure>
	<section id="page-entry-content" class="single-offer">
        <header class="entry-header">
            <div class="container">
                <p class="candidature-spontanne-link"><a href="#">Envoyer une candidature spontannée</a></p>
                <?php if ( isset( $offre->titre ) && !empty( $offre->titre ) ):?>
                    <h1 class="entry-title"><?php echo $offre->titre;?></h1>
                <?php endif;?>
                <p class="retour-offre-link">
                    <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link"><span>Retour aux résultats de recherche</span></a>
                </p>
            </div>
        </header>
        <article class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xl-1">
                        <?php  if ( isset( $offre->criticite ) && !empty( $offre->criticite ) && $offre->criticite[0]->term_id == ID_TAXONOMIE_CRITICITE_URGENT ) :?>
                            <div class="entry-meta status-offre">
                            <!-- ajout class urgent et urgent -->
                                <p class="criticite-offre urgent"><?php echo $offre->criticite[0]->name;?></p>
                            </div>
                        <?php  endif;?>
                        <!-- .entry-meta -->
                    </div>
                    <div class="col-md-10 col-xl-11">
                        <div class="main-desc">
                            <div class="row">
                                <div class="col-lg-8">
                                    <article class="caracteristique-bloc">
                                        <h3 class="widget-title">Caracteristiques du poste :</h3>
                                        <ul>
                                            <?php if ( isset( $society->titre )  && !empty( $society->titre ) ):?>
                                                <li>Nom de l'entreprise :<?php echo $society->titre;?></li>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->localisation ) && !empty( $offre->localisation ) ):?>
                                                <li>Région :&nbsp;
                                                    <?php   $i = 1;
                                                        $glue = ', ';
                                                        foreach ( $offre->localisation as $term ){
                                                            echo $term->name;
                                                            if ( ( count( $offre->localisation ) - 1 ) == $i  ) { echo " et "; $i++; }
                                                            if ( count( $offre->localisation ) > $i )  { echo $glue; $i++; }
                                                        }
                                                    ?>
                                                </li>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->date )  && !empty( $offre->date ) ):?>
                                                <li>Date de publication :&nbsp;&nbsp;<?php echo COffre::dateLongueText( $offre->date );?></li>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->expire )  && !empty( $offre->expire ) ):?>
                                                <li>Date d'expiration :&nbsp;&nbsp;<?php echo COffre::dateLongueText( $offre->expire );?></li>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->{JM_TAXONOMIE_DEPARTEMENT} )  && !empty( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) && count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) > 0 ):?>
                                                <li>Domaine de métier :&nbsp;&nbsp;
                                                    <?php   $i = 1;
                                                        $glue = ', ';
                                                        foreach ( $offre->{JM_TAXONOMIE_DEPARTEMENT} as $term ){
                                                            echo $term->name;
                                                            if ( ( count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) - 1 ) == $i  ) { echo " et "; $i++; }
                                                            if ( count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) > $i )  { echo $glue; $i++; }
                                                        }
                                                    ?>
                                                </li>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} )  && !empty( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) ):?>
                                                <li>Type de contrat :&nbsp;
                                                    <?php   $i = 1;
                                                        $glue = ', ';
                                                        foreach ( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} as $term ){
                                                            echo $term->name;
                                                            if ( ( count( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) - 1 ) == $i  ) { echo " et "; $i++; }
                                                            if ( count( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) > $i )  { echo $glue; $i++; }
                                                        }
                                                    ?>
                                                </li>
                                            <?php endif;?>
                                        </ul>
                                    </article>
                                    <article class="status-publish hentry">
                                        <h3 class="widget-title">Description de l’entreprise :</h3>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offre->description );?>
                                        </div>
                                        <?php if ( !empty( $society ) ):?>
                                        <div class="testimonial clearfix">
                                            <?php if ( isset( $society->titre ) ):?>
                                            <h2><i class="fa fa-industry"></i>&nbsp;<?php echo $society->titre; ?></h2>
                                            <?php  endif;?>
                                            <?php if ( isset( $society->logo ) && !empty( $society->logo ) ):
                                                list( $urlImage, $w, $h ) = $society->logo;
                                            ?>
                                            <figure><img src="<?php echo $urlImage;?>" width="<?php echo $w;?>" height="<?php echo $h;?>" title="<?php echo $societe->titre;?>" ></figure>
                                            <?php endif;?>
                                            <?php if ( isset( $society->description ) && !empty( $society->description ) ):?>
                                                <?php echo apply_filters("the_content", $society->description);?>
                                            <?php endif;?>
                                            <div class="entry-meta">
                                                <?php if ( isset( $society->adresse ) && !empty( $society->adresse ) ):?>
                                                <span class="meta-block"><i class="fa fa-home"></i><?php echo $society->adresse;?></span>
                                                <?php endif;?>
                                                <?php if ( isset( $society->ville ) && !empty( $society->ville ) ):?>
                                                <span class="meta-block"><i class="fa fa-area-chart"></i><?php echo $society->ville;?>
                                                    <?php echo ( isset( $society->code_postal ) && !empty( $society->code_postal ) ) ? "(" . $society->code_postal . ")" : ""; ?>
                                                    <?php echo ( isset( $society->pays ) && !empty( $society->pays ) ) ? ", " . $society->pays : ""; ?>
                                                </span>
                                                <?php endif;?>
                                                <?php if ( isset( $society->activites ) && !empty( $society->activites ) ):?>
                                                <span class="meta-block"><i class="fa fa-bar-chart"></i><?php echo $society->activites;?></span>
                                                <?php endif;?>
                                                <?php if ( isset( $society->telephone ) && !empty( $society->telephone ) ):?>
                                                <span class="meta-block"><i class="fa fa-phone-square"></i><?php echo $society->telephone;?></span>
                                                <?php endif;?>
                                                <?php if ( isset( $society->email ) && !empty( $society->email ) ):?>
                                                <span class="meta-block"><i class="fa fa fa-envelope"></i><?php echo $society->email;?></span>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <div id="comments">
                                            <!--description des missions-->
                                            <?php if ( isset( $offreElment->mission_principal ) ) :?>
                                                <h3>Missions principales :</h3>
                                                <div class="entry-content">
                                                    <?php echo apply_filters("the_content", $offreElment->mission_principal );?>
                                                </div>
                                            <?php endif;?>
                                            <!--description des missions-->
                                            <!--description responsabilite-->
                                            <?php if ( isset( $offreElment->responsabilite ) && !empty( $offreElment->responsabilite ) ):?>
                                                <h3>Responsabilités :</h3>
                                                <div class="entry-content">
                                                    <?php echo apply_filters("the_content", $offreElment->responsabilite );?>
                                                </div>
                                            <?php endif;?>
                                            <!--description responsabilite-->
                                            <!--description qualité requise-->
                                            <?php if ( isset( $offreElment->qualite_requise ) && !empty( $offreElment->qualite_requise ) ) :?>
                                                <h3>Qualités requises :</h3>
                                                <div class="entry-content">
                                                    <?php echo apply_filters("the_content", $offreElment->qualite_requise );?>
                                                </div>
                                            <?php endif;?>
                                            <!--description qualité requise-->
                                            <p class="single-offre-left hidden-md-down">
                                                <a href="<?php echo $linkPostule;?>" class="postule-link submit_link <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" ><span>Intéressé(e) ? Postulez !</span></a>
                                            </p>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-lg-4 widget-profil">
                                    <aside class="widget widget_recent_entries">
                                        <h3 class="widget-title">Profil recherché :</h3>
                                        <ul>
                                            <?php if ( isset( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} )  && !empty( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} ) ):?>
                                                <li><?php echo $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE}[0]->name . " d'expérience ";?></li>
                                            <?php endif;?>

                                            <?php if ( isset( $offre->{JM_TAXONOMIE_NIVEAU_ETUDE} )  && !empty( $offre->{JM_TAXONOMIE_NIVEAU_ETUDE} ) ):?>
                                                <li><?php echo $offre->{JM_TAXONOMIE_NIVEAU_ETUDE}[0]->name;?></li>
                                            <?php endif;?>

                                            <?php if ( isset( $domaineEtude )  && !empty( $domaineEtude ) ):?>
                                                <?php  foreach ( $domaineEtude[0] as $parent ): ?>
                                                    <li>
                                                        <?php echo $parent['name'] ;?>
                                                        <?php if ( isset( $domaineEtude[$parent['id']][0] ) && !empty( $domaineEtude[$parent['id']][0] ) ):?>
                                                            <ul>
                                                                <?php foreach( $domaineEtude[$parent['id']][0] as $firstChild ):?>
                                                                    <li>
                                                                        <?php echo $firstChild['name'];?>
                                                                        <?php if ( isset( $domaineEtude[$parent['id']][$firstChild['id']][0] ) && !empty( $domaineEtude[$parent['id']][$firstChild['id']][0] ) ):?>
                                                                            <ul>
                                                                                <?php foreach( $domaineEtude[$parent['id']][$firstChild['id']][0] as $secondChild ):?>
                                                                                    <li><?php echo $secondChild['name'];?></li>
                                                                                <?php endforeach;?>
                                                                            </ul>
                                                                        <?php endif;?>
                                                                    </li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        <?php endif;?>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                            <?php if ( isset( $offre->{JM_TAXONOMIE_COMPETENCE_REQUISES} )  && !empty( $offre->{JM_TAXONOMIE_COMPETENCE_REQUISES} ) ): ?>
                                                <?php foreach( $competenceRequis[0] as $parent ): ?>
                                                <li>
                                                    <?php echo $parent['name'] ;?>
                                                    <?php if ( isset( $competenceRequis[$parent['id']][0] ) && !empty( $competenceRequis[$parent['id']][0] ) ):?>
                                                        <ul>
                                                            <?php foreach( $competenceRequis[$parent['id']][0] as $firstChild ):?>
                                                                <li>
                                                                    <?php echo $firstChild['name'];?>
                                                                    <?php if ( isset( $competenceRequis[$parent['id']][$firstChild['id']][0] ) && !empty( $competenceRequis[$parent['id']][$firstChild['id']][0] ) ):?>
                                                                        <ul>
                                                                            <?php foreach( $competenceRequis[$parent['id']][$firstChild['id']][0] as $secondChild ):?>
                                                                                <li><?php echo $secondChild['name'];?></li>
                                                                            <?php endforeach;?>
                                                                        </ul>
                                                                    <?php endif;?>
                                                                </li>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    <?php endif;?>
                                                </li>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                            <?php if ( isset( $offreElment->autreProfil ) && !empty( $offreElment->autreProfil ) && count( $offreElment->autreProfil ) ) :?>
                                                <?php foreach( $offreElment->autreProfil as $profil ):?>
                                                    <li><?php echo $profil[FIELD_PROFIL_ELEMENT];?></li>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </ul>
                                    </aside>
                                </div>
                            </div>
                            <p class="single-offre-left hidden-lg-up">
                                <a href="<?php echo $linkPostule;?>" class="postule-link submit_link <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" ><span>Intéressé(e) ? Postulez !</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
	</section>
</div>
<?php get_footer(); ?>
