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
				                            <div class="criticite-offre"><?php echo $offre->criticite[0]->name;?></div></span>
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
		                            <?php if ( isset( $society->logo ) && !empty( $society->logo ) ):
                                        list( $urlImage, $w, $h ) = $society->logo;
                                                    ?>
                                        <img src="<?php echo $urlImage;?>" width="<?php echo $w;?>" height="<?php echo $h;?>" title="<?php echo $societe->titre;?>" >
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
			                            <header class="entry-header">
				                            <h3><i class="fa fa-hand-o-right"></i>&nbsp;Missions principales</h3>
			                            </header>
			                            <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->mission_principal );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description des missions-->
		                            <!--description responsabilite-->
		                            <?php if ( isset( $offreElment->responsabilite ) && !empty( $offreElment->responsabilite ) ):?>
			                            <header class="entry-header">
                                            <h3><i class="fa fa-hand-o-right"></i>&nbsp;Responsabilités</h3>
                                        </header>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->responsabilite );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description responsabilite-->
		                            <!--description qualité requise-->
		                            <?php if ( isset( $offreElment->qualite_requise ) && !empty( $offreElment->qualite_requise ) ) :?>
			                            <header class="entry-header">
                                            <h3><i class="fa fa-hand-o-right"></i>&nbsp;Qualités requises</h3>
                                        </header>
                                        <div class="entry-content">
                                            <?php echo apply_filters("the_content", $offreElment->qualite_requise );?>
                                        </div>
		                            <?php endif;?>
		                            <!--description qualité requise-->
		                            <p class="animate-plus animate-init single-offre-left" data-animations="fadeInUp" data-animation-delay="1.5s">
                                        <a href="<?php echo $linkPostule;?>" class="submit_link button--wapasha button--round-l <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" >
                                            <span>
                                                Postuler à cette offre
                                            </span>
                                        </a>
			                            </p>
		                            <p class="animate-plus animate-init single-offre-right" data-animations="fadeInUp" data-animation-delay="1.5s">
                                        <a href="<?php echo get_permalink( $postOffes->ID );?>" class="submit_link button--wapasha button--round-l">
                                            <span>
                                                Retour aux offres
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
	                    <p class="single-offre-sidebar">
		                    <a href="<?php echo $linkPostule;?>" class="submit_link button--wapasha button--round-l <?php if ( !is_user_logged_in() ):?>postule-offre<?php endif;?>" >
                                <span>
                                    Postuler à cette offre
                                </span>
                            </a>
                        </p>
	                    <h3 class="widget-title">
		                    Caracteristiques du poste
	                    </h3>
						<ul>
							<?php if ( isset( $society->titre )  && !empty( $society->titre ) ):?>
								<li><strong>Nom de l'entreprise :</br></strong>&nbsp;&nbsp;<?php echo $society->titre;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->localisation )  && !empty( $offre->localisation ) ):?>
								<li><strong>Région :</br></strong>&nbsp;
									<?php   $i = 1;
											$glue = ', ';
											foreach ( $offre->localisation as $term ){
												echo $term->name;
												if ( ( count( $offre->localisation ) - 1 ) == $i  ) { echo " et "; $i++; }
												if ( count( $offre->localisation ) > $i )  { echo $glue; $i++; }
											}?>
								</li>
							<?php endif;?>
							<?php if ( isset( $offre->date )  && !empty( $offre->date ) ):?>
								<li><strong>Date de publication :</br></strong>&nbsp;&nbsp;<?php echo COffre::dateLongueText( $offre->date );?></li>
							<?php endif;?>
							<?php if ( isset( $offre->expire )  && !empty( $offre->expire ) ):?>
								<li><strong>Date d'expiration :</br></strong>&nbsp;&nbsp;<?php echo COffre::dateLongueText( $offre->expire );?></li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_DEPARTEMENT} )  && !empty( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) && count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) > 0 ):?>
								<li><strong>Domaine de métier :</br></strong>&nbsp;&nbsp;
							<?php   $i = 1;
									$glue = ', ';
									foreach ( $offre->{JM_TAXONOMIE_DEPARTEMENT} as $term ){
										echo $term->name;
										if ( ( count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) - 1 ) == $i  ) { echo " et "; $i++; }
										if ( count( $offre->{JM_TAXONOMIE_DEPARTEMENT} ) > $i )  { echo $glue; $i++; }
									}?>
								</li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} )  && !empty( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) ):?>
								<li><strong>Type de contrat :</strong></br>&nbsp;
									<?php   $i = 1;
											$glue = ', ';
											foreach ( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} as $term ){
												echo $term->name;
												if ( ( count( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) - 1 ) == $i  ) { echo " et "; $i++; }
												if ( count( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) > $i )  { echo $glue; $i++; }
											}?>
								</li>
							<?php endif;?>
                            <?php if ( isset( $offre->niveau_etude ) && !empty( $offre->niveau_etude ) ):?>
                                <li><strong>Niveau d'étude :</br></strong>&nbsp;&nbsp;
                                    <?php   $i = 1;
                                    $glue = ', ';
                                    foreach ( $offre->niveau_etude as $term ){
                                        echo $term->name;
                                        if ( ( count( $offre->niveau_etude ) - 1 ) == $i  ) { echo " et "; $i++; }
                                        if ( count( $offre->niveau_etude ) > $i )  { echo $glue; $i++; }
                                    }?>
                                </li>
                            <?php endif;?>
						</ul>
                    </aside>
                    <aside class="widget widget_recent_entries">
	                    <h3 class="widget-title">
		                    Profil recherché
	                    </h3>
						<ul>
							<?php if ( isset( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} )  && !empty( $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE} ) ):?>
								<li><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;<?php echo $offre->{JM_TAXONOMIE_ANNEE_EXPERIENCE}[0]->name . " d'expérience ";?></li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_NIVEAU_ETUDE} )  && !empty( $offre->{JM_TAXONOMIE_NIVEAU_ETUDE} ) ):?>
								<li><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;<?php echo $offre->{JM_TAXONOMIE_NIVEAU_ETUDE}[0]->name;?></li>
							<?php endif;?>
							<?php if ( isset( $offre->{JM_TAXONOMIE_COMPETENCE_REQUISES} )  && !empty( $offre->{JM_TAXONOMIE_COMPETENCE_REQUISES} ) ): ?>
								<?php foreach( $competenceRequis[0] as $parent ): ?>
								<li><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;
									<?php echo $parent['name'] ;?>
									<?php if ( isset( $competenceRequis[$parent['id']][0] ) && !empty( $competenceRequis[$parent['id']][0] ) ):?>
										<ul>
											<?php foreach( $competenceRequis[$parent['id']][0] as $firstChild ):?>
												<li>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i>
													<?php echo $firstChild['name'];?>
													<?php if ( isset( $competenceRequis[$parent['id']][$firstChild['id']][0] ) && !empty( $competenceRequis[$parent['id']][$firstChild['id']][0] ) ):?>
														<ul>
															<?php foreach( $competenceRequis[$parent['id']][$firstChild['id']][0] as $secondChild ):?>
																<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-fighter-jet"></i>
																	<?php echo $secondChild['name'];?>
																</li>
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
                            <?php if ( !empty( $domaineEtude ) && count( $domaineEtude ) > 0 ):?>
                                <?php foreach( $domaineEtude[0] as $parent ): ?>
                                    <li><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;
                                        <?php echo $parent['name'] ;?>
                                        <?php if ( isset( $domaineEtude[$parent['id']][0] ) && !empty( $domaineEtude[$parent['id']][0] ) ):?>
                                            <ul>
                                                <?php foreach( $domaineEtude[$parent['id']][0] as $firstChild ):?>
                                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i>
                                                        <?php echo $firstChild['name'];?>
                                                        <?php if ( isset( $domaineEtude[$parent['id']][$firstChild['id']][0] ) && !empty( $domaineEtude[$parent['id']][$firstChild['id']][0] ) ):?>
                                                            <ul>
                                                                <?php foreach( $domaineEtude[$parent['id']][$firstChild['id']][0] as $secondChild ):?>
                                                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-fighter-jet"></i>
                                                                        <?php echo $secondChild['name'];?>
                                                                    </li>
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
									<li><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;<?php echo $profil[FIELD_PROFIL_ELEMENT];?></li>
								<?php endforeach;?>
							<?php endif;?>
						</ul>
                    </aside>
                </div>
		    </div>
	    </div>
	</section>


<?php get_footer(); ?>
