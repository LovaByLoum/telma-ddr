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
get_header(); ?>
	<section id="page-entry-content" class="single-offer">
	    <div class="grid grid-pad">
		    <div class="col-9-12">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <article class="status-publish hentry">
                            <div>
	                            <?php if ( isset( $offre->titre ) && !empty( $offre->titre ) ):?>
	                            <header class="entry-header">
		                            <h1 class="entry-title">
			                            <?php echo $offre->titre;?>
		                            </h1>
		                            <?php if ( isset( $offre->criticite ) && !empty( $offre->criticite ) && $offre->criticite[0]->term_id == ID_TAXONOMIE_CRITICITE_URGENT ) :?>
			                            <div class="entry-meta">
	                                        <span class="meta-block"><i class="fa fa-exclamation-triangle"></i><?php echo $offre->criticite[0]->name;?></span>
	                                    </div>
		                            <?php  endif;?>
		                            <!-- .entry-meta -->
	                            </header>
	                            <?php endif;?>
	                            <div class="entry-content">
                                    <?php echo apply_filters("the_content", $offre->description );?>
                                </div>
	                            <?php if ( !empty( $society ) ):?>
	                            <div class="testimonial">
		                            <?php if ( isset( $society->titre ) ):?>
		                            <h2>
			                            <i class="fa fa-industry"></i>&nbsp;<?php echo $society->titre; ?>
                                    </h2>
		                            <?php  endif;?>
		                            <?php if ( isset( $society->logo ) && !empty( $society->logo ) ):?>
                                        <img src="<?php echo $society->logo;?>" height="150" width="150">
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

	                            <div>
		                            <!--description des missions-->
		                            <?php if ( isset( $offreElment->mission_principal ) ) :?>
			                            <header class="entry-header">
				                            <h2><i class="fa fa-hand-o-right"></i>&nbsp;Mission principale</h2>
			                            </header>
			                            <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->mission_principal );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description des missions-->
		                            <!--description responsabilite-->
		                            <?php if ( isset( $offreElment->responsabilite ) && !empty( $offreElment->responsabilite ) ):?>
			                            <header class="entry-header">
                                            <h2><i class="fa fa-hand-o-right"></i>&nbsp;Résponsabilité</h2>
                                        </header>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->responsabilite );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description responsabilite-->
		                            <!--description qualité requise-->
		                            <?php if ( isset( $offreElment->qualite_requise ) && !empty( $offreElment->qualite_requise ) ) :?>
			                            <header class="entry-header">
                                            <h2><i class="fa fa-hand-o-right"></i>&nbsp;Qualité requise</h2>
                                        </header>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->qualite_requise );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description qualité requise-->
		                            <p class="animate-plus animate-init link_formation" data-animations="fadeInUp" data-animation-delay="1.5s">
                                        <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link button--wapasha button--round-l">
                                            <span>
                                                Accéder directement aux offres
                                            </span>
                                        </a>
                                        <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link button--wapasha button--round-l">
                                            <span>
                                                Accéder directement aux offres
                                            </span>
                                        </a>
                                    </p>
	                            </div>
                            </div>
                        </article>
                    </main>
                </div>
		    </div>
		    <div class="col-3-12">
                <div class="widget-area">
                    <aside class="widget widget_recent_entries">
	                    <h3 class="widget-title">
		                    Caracteristiques du poste
	                    </h3>
						<ul>
							<?php if ( isset( $society->titre )  && !empty( $society->titre ) ):?>
								<li><strong>Nom de l'entreprise :</strong>&nbsp;<?php echo $society->titre;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->localisation )  && !empty( $offre->localisation ) ):?>
								<li><strong>Région :</strong>&nbsp;<?php echo $offre->localisation[0]->name;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->date )  && !empty( $offre->date ) ):?>
								<li><strong>Date de publication :</strong>&nbsp;<?php echo COffre::dateLongueText( $offre->date );?></li>
							<?php endif;?>
							<?php if ( isset( $offre->expire )  && !empty( $offre->expire ) ):?>
								<li><strong>Date d'expiration :</strong>&nbsp;<?php echo COffre::dateLongueText( $offre->expire );?></li>
							<?php endif;?>
							<?php if ( isset( $offreElment->domaine_metier )  && !empty( $offreElment->domaine_metier ) ):?>
								<li><strong>Domaine de métier :</strong>&nbsp;<?php echo $offreElment->domaine_metier;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} )  && !empty( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) ):?>
								<li><strong>Type de contrat :</strong>&nbsp;<?php echo $offre->{JM_TAXONOMIE_TYPE_CONTRAT}[0]->name;?></li>
							<?php endif;?>
						</ul>
                    </aside>
                    <aside class="widget widget_recent_entries">
	                    <h3 class="widget-title">
		                    Profil recherché
	                    </h3>
						<ul>
							<?php if ( isset( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} )  && !empty( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} ) ):?>
								<li><strong>Nom de l'entreprise :</strong>&nbsp;<?php echo $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE}[0]->name . " d'expérience ";?></li>
							<?php endif;?>
							<?php if ( isset( $offre->localisation )  && !empty( $offre->localisation ) ):?>
								<li><strong>Région :</strong>&nbsp;<?php echo $offre->localisation[0]->name;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->date )  && !empty( $offre->date ) ):?>
								<li><strong>Date de publication :</strong>&nbsp;<?php echo COffre::dateLongueText( $offre->date );?></li>
							<?php endif;?>
							<?php if ( isset( $offre->expire )  && !empty( $offre->expire ) ):?>
								<li><strong>Date d'expiration :</strong>&nbsp;<?php echo COffre::dateLongueText( $offre->expire );?></li>
							<?php endif;?>
							<?php if ( isset( $offreElment->domaine_metier )  && !empty( $offreElment->domaine_metier ) ):?>
								<li><strong>Domaine de métier :</strong>&nbsp;<?php echo $offreElment->domaine_metier;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} )  && !empty( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) ):?>
								<li><strong>Type de contrat :</strong>&nbsp;<?php echo $offre->{JM_TAXONOMIE_TYPE_CONTRAT}[0]->name;?></li>
							<?php endif;?>
						</ul>
                    </aside>
                </div>
		    </div>
	    </div>
	</section>


<?php get_footer(); ?>
