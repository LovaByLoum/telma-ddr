<?php
/**
 * The template for displaying all single posts.
 *
 * @package telmarh
 */
global $post,$current_user;
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
$postIdCandidature = wp_get_post_by_template("page-candidature-spontanee.php", "");
get_header(); ?>
<div class="listing-offer-page offer-page">
    <figure class="alauneImg">
        <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
    </figure>
    <div class="breadcrumb"><div class="container"><?php get_breadcrumb("<a href=". get_permalink( $postOffes->ID )."> Nos offres </a>"); ?></div></div>
    <section id="page-entry-content" class="single-offer">
        <header class="entry-header">
            <div class="container">
                <!--<p class="candidature-spontanne-link"><a href="<?php //echo get_permalink($postIdCandidature->ID);?>">Envoyer une candidature spontannée</a></p>-->
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

                            <div class="entry-meta status-offre">
                            <!-- ajout class urgent et urgent -->
                                <?php  if ( isset( $offre->criticite ) && !empty( $offre->criticite ) && $offre->criticite[0]->term_id == ID_TAXONOMIE_CRITICITE_URGENT ) :?>
                                    <p class="criticite-offre urgent"><?php echo $offre->criticite[0]->name;?></p>
                                <?php else:?>
<!--     ****************************************************     MODIFICATION NON-URGENT   ********************************                   -->
                                    <p class="criticite-offre no-urgent" style="display: none;"><?php echo __("Non urgent", "telmarh");?></p>
                                <?php  endif;?>
                            </div>

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
                                                <li>Localisation :&nbsp;
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
                                        <h3 class="widget-title">Description de l’offre :</h3>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offre->description );?>
                                        </div>
                                        
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


                                            <!--societe footer-->
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
                                            <!--societe footer-->
                                            <p class="single-offre-left hidden-md-down">
                                                <a  href="<?php echo $linkPostule;?>" class="postule-link submit_link <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" ><span id="postuler_offre_popup">Postuler</span></a>
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
                                <a href="<?php echo $linkPostule;?>" class="postule-link submit_link <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" ><span>Postuler</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
	</section>
</div>
<?php get_footer(); ?>
<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        -webkit-animation-name: fadeIn; /* Fade in the background */
        -webkit-animation-duration: 0.4s;
        animation-name: fadeIn;
        animation-duration: 0.4s
    }

    /* Modal Content */
    .modal-content {
        position: fixed;
        padding: auto;
        bottom: 0;
        background-color: #c80f2d;
        width: 100%;
        -webkit-animation-name: slideIn;
        -webkit-animation-duration: 0.4s;
        animation-name: slideIn;
        animation-duration: 0.4s;
        text-align: center;
        color:#fefefe ;
        font-size: 25px;
        font-weight: 400;
        font-family: "Open Sans", Helvetica, Lucida, Arial, sans-serif;
    }

    /* The Close Button */
    .close {
        color: white;

        font-size: 28px;
        font-weight: bold;
        text-align: right;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        /*padding: 2px 16px;*/
        padding: 0px !important;
        color: white;
    }

    .modal-body {padding: 2px 16px;}

    /* Add Animation */
    @-webkit-keyframes slideIn {
        from {bottom: -300px; opacity: 0}
        to {bottom: 0; opacity: 1}
    }

    @keyframes slideIn {
        from {bottom: -300px; opacity: 0}
        to {bottom: 0; opacity: 1}
    }

    @-webkit-keyframes fadeIn {
        from {opacity: 0}
        to {opacity: 1}
    }

    @keyframes fadeIn {
        from {opacity: 0}
        to {opacity: 1}
    }
</style>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <p>Pour pouvoir postuler à cette offre il faut d’abord s’inscrire et suivre les instructions.</p>
        </div>
    </div>

</div>
<script type="text/javascript">
    var modal = document.getElementById('myModal');
    // Get the button that opens the modal
    var btn = document.getElementById("postuler_offre_popup");
    var user = '<?php echo is_user_logged_in(); ?>';

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    if ( !user) {
        // When the user clicks the button, open the modal
        btn.onclick = function () {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
    }}







</script>