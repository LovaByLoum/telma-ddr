<?php
/**
 * Template Name: Page inscription
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
if ( is_user_logged_in() ){
	wp_redirect( home_url() );
}
global $post, $telmarh_options;
$results = telmarh_inscription_user();
$anneeExperiences       = get_terms( JM_TAXONOMIE_ANNEE_EXPERIENCE, array( 'hide_empty' => false ) );
$typeContrat            = get_terms( JM_TAXONOMIE_TYPE_CONTRAT, array( 'hide_empty' => false ) );
$localisation           = get_terms( JM_TAXONOMIE_LOCALISATION,array( 'hide_empty' => false ) );
$criticites             = get_terms( JM_TAXONOMIE_CRITICITE, array( 'hide_empty' => false ) );
$niveauEtudes           = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false ) );
$domainesMetier         = get_terms( JM_TAXONOMIE_DEPARTEMENT, array( 'hide_empty' => false ) );
$referentielEtude       = ( isset( $telmarh_options['list_domaine_etude'] ) && !empty( $telmarh_options['list_domaine_etude'] ) ) ? explode(",", $telmarh_options['list_domaine_etude']) : array();
$listPays               = ( isset( $telmarh_options['list_pays'] ) && !empty( $telmarh_options['list_pays'] ) ) ? explode( ",", $telmarh_options['list_pays'] ) : array();
$entreprises            = JM_Societe::getBy();
$nonce                  = wp_create_nonce( "inscription-user" );
get_header(); ?>
	<section id="page-full-entry-content">
		    <div class="grid grid-pad">
			    <div class="col-1-1">
	                <div id="primary" class="content-area">
	                    <main id="main" class="site-main" role="main">
	                        <article class="status-publish hentry">
	                            <div>
									<?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
										<header class="entry-header">
				                            <h1 class="entry-title">
					                            <?php echo $post->post_title;?>
				                            </h1>
				                            <!-- .entry-meta -->
			                            </header>
									<?php endif;?>
									<div class="entry-content">
	                                    <?php echo apply_filters("the_content", $post->post_content );?>
                                    </div>
		                            <?php if ( isset( $results['error'] ) && $results['error'] == 1  ) :?>
			                            <!--error php-->
			                            <?php if ( isset( $results['messages'] ) && !empty( $results['messages'] ) ):?>
				                            <ul>
					                            <?php echo $results['messages'];?>
				                            </ul>
										<?php  endif;?>
			                            <!--error php-->
		                            <form class="comment-form" id="inscription_user" autocomplete="off" action="<?php echo get_permalink( $post->ID );?>" method="post">
			                            <div class="control-group">
				                            <h4 class="head-accordion open">Compte</h4>
				                            <div class="head-accordion">
					                            <p class="col-1-3 form-field">
						                            <label for="login">Login <span class="required">*</span></label>
                                                    <input type="text" placeholder="Login" name="login" id="login" value="<?php echo $_POST['login'];?>">
                                                </p>
                                                <p class="col-1-3 form-field">
	                                                <label for="passwrd">Mot de passe <span class="required">*</span></label>
                                                    <input type="password" placeholder="Mot de passe" name="passwrd" id="passwrd" value="<?php echo $_POST['passwrd'];?>">
                                                </p>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Utilisateur</h4>
				                            <div class="head-accordion">
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="nom">Nom <span class="required">*</span></label>
							                            <input type="text" placeholder="Nom " name="nom" id="nom" value="<?php echo $_POST['nom'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="prenom">Prénom <span class="required">*</span></label>
                                                        <input type="text" placeholder="Prénom " id="prenom" name="prenom" value="<?php echo $_POST['prenom'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="birthday">Date de naissance <span class="required">*</span></label>
                                                        <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="birthday" id="birthday" value="<?php echo $_POST['birthday'];?>">
                                                    </p>
					                            </div>
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="adresse">Adresse <span class="required">*</span></label>
                                                        <input type="text" placeholder="Adresse" name="adresse" id="adresse" value="<?php echo $_POST['adresse'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="num_phone">N° de téléphone </label>
                                                        <input type="text" placeholder="N° de téléphone" id="num_phone" name="num_phone" value="<?php echo $_POST['num_phone'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="email">Adresse email <span class="required">*</span></label>
                                                        <input type="text" placeholder="Adresse email" name="email" id="email" value="<?php echo $_POST['email'];?>">
                                                    </p>
					                            </div>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Votre parcours</h4>
				                            <div class="content-accordion">
					                            <div class="col-1-1">
						                            <div class="col-1-3 form-field">
                                                        <h5>Niveau d'etude <span class="required">*</span></h5>
                                                        <div class="select">
                                                        <select name="niveau_etude">
                                                            <option value="0">Sélectionnez</option>
                                                            <?php if ( !empty( $niveauEtudes ) && count( $niveauEtudes ) > 0 ):?>
                                                                <?php foreach ( $niveauEtudes as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['niveau_etude'] == $term->term_id ):?>selected="selected" <?php endif;?> ><?php echo $term->name;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
	                                                        <option value="autre">Autres</option>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
						                            <p class="col-1-3 form-field niveau-required">
                                                        <label for="autre_exp">Autre <span class="required">*</span></label>
                                                        <input type="text" placeholder="Autre niveau d'etude" name="autre_exp" id="autre_exp" value="<?php echo $_POST['autre_exp'];?>">
                                                    </p>
                                                    <div class="col-1-3 form-field">
                                                        <h5>Domaine d'etude</h5>
                                                        <div class="select">
                                                        <select name="ref_etude">
                                                            <option value="0">Sélectionnez</option>
                                                            <?php if ( !empty( $referentielEtude ) && count( $referentielEtude ) > 0 ):?>
                                                                <?php foreach ( $referentielEtude as $element ):?>
                                                                    <option value="<?php echo $element;?>" <?php if ( $_POST['ref_etude'] == $element ):?>selected="selected" <?php endif;?>><?php echo $element;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </div>

                                                    </div>
					                            </div>
					                            <div class="col-1-1">
						                            <div class="col-1-3 form-field">
                                                        <h5>En poste<span class="required">*</span></h5>
                                                        <label class="control control--radio">Non
                                                            <input type="radio"  value="0" name="en_poste" checked="checked">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                        <label class="control control--radio">Oui
                                                            <input type="radio"  value="1" name="en_poste">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </div>
                                                    <p class="col-1-3 form-field post-required">
	                                                    <label for="entreprise">Nom de l'entreprise <span class="required">*</span></label>
                                                        <input type="text" name="entreprise_user" placeholder="Nom de l'entreprise" id="entreprise" value="<?php echo $_POST['entreprise_user'];?>"/>
                                                    </p>
                                                    <p class="col-1-3 form-field post-required">
	                                                    <label for="fonction">Fonction dans l'entreprise <span class="required">*</span></label>
                                                        <input type="text" name="fonction_user" placeholder="Fonction *" id="fonction" value="<?php echo $_POST['fonction_user'];?>"/>
                                                    </p>
					                            </div>
												<div class="col-1-1">
													<div class="col-1-3 form-field">
		                                                <h5>Mobilité</h5>
		                                                <div class="select">
		                                                    <select name="region">
		                                                        <option value="0">Sélectionnez</option>
		                                                        <?php if ( !empty( $localisation ) && count( $localisation ) > 0 ):?>
		                                                            <?php foreach ( $localisation as $term ):?>
		                                                                <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['region'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
		                                                            <?php endforeach;?>
		                                                        <?php endif;?>
		                                                    </select>
		                                                    <div class="select__arrow"></div>
		                                                </div>
		                                            </div>
													<div class="col-1-3 form-field">
		                                                <h5>Domaine de métier recherché</h5>
		                                                <div class="select">
		                                                    <select name="dom_metier">
		                                                        <option value="0">Sélectionnez</option>
		                                                        <?php if ( !empty( $domainesMetier ) && count( $domainesMetier ) > 0 ):?>
		                                                            <?php foreach ( $domainesMetier as $term ):?>
		                                                                <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['dom_metier'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
		                                                            <?php endforeach;?>
		                                                        <?php endif;?>
		                                                    </select>
		                                                    <div class="select__arrow"></div>
		                                                </div>
		                                            </div>
												</div>
												<div class="col-1-1">
													<div class="col-1-3 form-field">
	                                                    <h5>Permis de conduire <span class="required">*</span></h5>
	                                                    <label class="control control--radio">Non
	                                                        <input type="radio"  value="0" name="permis" checked="checked">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--radio">Oui
	                                                        <input type="radio"  value="1" name="permis">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                </div>
						                            <div class="col-1-3 form-field permis-required">
	                                                    <h5>Catégories permis<span class="required">*</span></h5>
	                                                    <label class="control control--checkbox">Permis A
	                                                        <input type="checkbox"  value="A" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--checkbox">Permis A'
	                                                        <input type="checkbox"  value="A'" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--checkbox">Permis B
	                                                        <input type="checkbox"  value="B" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--checkbox">Permis C
	                                                        <input type="checkbox"  value="C" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                </div>
						                            <div class="col-1-3 form-field permis-required">
							                            <label class="control control--checkbox">Permis D
	                                                        <input type="checkbox"  value="D" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--checkbox">Permis E
	                                                        <input type="checkbox"  value="E" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
	                                                    <label class="control control--checkbox latest">Permis F
	                                                        <input type="checkbox"  value="F" name="permCat">
	                                                        <div class="control__indicator"></div>
	                                                    </label>
						                            </div>
												</div>
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="date_dispo">Date de disponibilité <span class="required">*</span></label>
                                                        <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="date_dispo" id="date_dispo" value="<?php echo $_POST['date_dispo'];?>">
                                                    </p>
						                            <div class="col-1-3 form-field">
                                                        <h5>Années d’expérience professionnelle <span class="required">*</span></h5>
                                                        <div class="select">
                                                        <select name="annee_exp">
                                                            <option value="0">Sélectionnez</option>
                                                            <?php if ( !empty( $anneeExperiences ) && count( $anneeExperiences ) > 0 ):?>
                                                                <?php foreach ( $anneeExperiences as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['annee_exp'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
					                            </div>
				                            </div>
			                            </div>
			                            <div class="control-group">
				                            <h4 class="head-accordion">Expériences professionnelles (dont stages) <span class="required">*</span></h4>
				                            <div id="experience-repeat" class="content-accordion experience sample">
					                            <div class="col-1-1 number">
                                                    <h5>Expérience professionnelles n°<span>1</span></h5>
                                                </div>
					                            <div class="col-1-1 add-element">
						                            <a href="javascript:;" class="deleteExperience" title="En savoir plus">
                                                        <i class="fa fa-minus"></i>&nbsp;&nbsp;Supprimer
                                                    </a>
					                            </div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="titre_exp_prof">Titre de l'experience <span class="required">*</span></label>
	                                                    <input type="text" placeholder="Titre de l'experience" name="titre_exp_prof" id="titre_exp_prof" value="<?php echo $_POST['titre_exp_prof'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_prof">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="db_exp_prof" id="db_exp_prof" value="<?php echo $_POST['db_exp_prof'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_prof">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="df_exp_prof" id="df_exp_prof" value="<?php echo $_POST['df_exp_prof'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_prof">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" placeholder="Organisme / Entreprise " name="organisme_exp_prof" id="organisme_exp_prof" value="<?php echo $_POST['organisme_exp_prof'];?>">
                                                    </p>
													<p class="col-1-3 form-field">
														<label for="desc_exp_prof">Description <span class="required">*</span></label>
														<textarea name="desc_exp_prof" id="desc_exp_prof" placeholder="Quelques mots"><?php echo $_POST['desc_exp_prof'];?></textarea>
													</p>
													<div class="col-1-3 form-field">
                                                        <h5>Localisation </h5>
                                                        <div class="select">
                                                            <select name="localisation_prof">
                                                                <option value="0">Sélectionnez</option>
                                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                                    <?php foreach ( $listPays as $pays ):?>
                                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_prof'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </select>
                                                            <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
												</div>
				                            </div>
				                            <p class="col-1-1 add-element">
                                                <a href="javascript:;" id="addExperience" title="Ajouter plus">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter
                                                </a>
					                            <input type="hidden" id="experience-number" value="0" name="experience-number">
                                            </p>
			                            </div>
			                            <div class="control-group">
				                            <h4 class="head-accordion">Formations <span class="required">*</span></h4>
				                            <div id="formation-repeat" class="content-accordion sample formation">
					                            <div class="col-1-1 number">
						                            <h5>Formation n°<span>1</span></h5>
					                            </div>
					                            <div class="col-1-1 add-element">
                                                    <a href="javascript:;" class="deleteFormation" title="En savoir plus">
                                                        <i class="fa fa-minus"></i>&nbsp;&nbsp;Supprimer
                                                    </a>
                                                </div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="titre_exp_for">Titre de l'experience <span class="required">*</span></label>
	                                                    <input type="text" placeholder="Titre de l'experience" name="titre_exp_for" id="titre_exp_for" value="<?php echo $_POST['titre_exp_for'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_for">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="db_exp_for" id="db_exp_for" value="<?php echo $_POST['db_exp_for'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_for">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="df_exp_for" id="df_exp_for" value="<?php echo $_POST['df_exp_for'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_for">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" placeholder="Organisme / Entreprise " name="organisme_exp_for" id="organisme_exp_for" value="<?php echo $_POST['organisme_exp_for'];?>">
                                                    </p>
													<p class="col-1-3 form-field">
														<label for="desc_exp_for">Description <span class="required">*</span></label>
														<textarea name="desc_exp_for" id="desc_exp_for" placeholder="Quelques mots"><?php echo $_POST['desc_exp_for'];?></textarea>
													</p>
													<div class="col-1-3 form-field">
                                                        <h5>Localisation</h5>
                                                        <div class="select">
                                                            <select name="localisation_for">
                                                                <option value="0">Sélectionnez</option>
                                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                                    <?php foreach ( $listPays as $pays ):?>
                                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_for'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </select>
                                                            <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
												</div>
				                            </div>
				                            <p class="col-1-1 add-element">
	                                            <a href="javascript:;" id="addFormation"  title="Ajouter plus">
		                                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter
	                                            </a>
					                            <input type="hidden" id="formation-number" name="formation-number" value="0">
	                                        </p>
			                            </div>
			                            <div class="control-group">
				                            <h4 class="head-accordion">Projets personnels, professionnels </h4>
				                            <div class="col-1-1 form-field">
	                                            <h5>Projets</h5>
	                                            <label class="control control--radio">Non
	                                                <input type="radio"  value="0" name="projet" checked="checked">
	                                                <div class="control__indicator"></div>
	                                            </label>
	                                            <label class="control control--radio">Oui
	                                                <input type="radio"  value="1" name="projet">
	                                                <div class="control__indicator"></div>
	                                            </label>
	                                        </div>
				                            <div id="projet-repeat" class="content-accordion projet sample">
					                            <div class="col-1-1 number">
                                                    <h5>Projets n°<span>1</span></h5>
                                                </div>
					                            <div class="col-1-1 add-element">
                                                    <a href="javascript:;" class="deleteProjet" title="En savoir plus">
                                                        <i class="fa fa-minus"></i>&nbsp;&nbsp;Supprimer
                                                    </a>
                                                </div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="titre_exp_pgt">Titre de l'experience <span class="required">*</span></label>
	                                                    <input type="text" placeholder="Titre de l'experience" name="titre_exp_pgt" id="titre_exp_pgt" value="<?php echo $_POST['titre_exp_pgt'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_pgt">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="db_exp_pgt" id="db_exp_pgt" value="<?php echo $_POST['db_exp_pgt'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_pgt">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" class="datepicker" placeholder="date/mois/année" readonly name="df_exp_pgt" id="df_exp_pgt" value="<?php echo $_POST['df_exp_pgt'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_pgt">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" placeholder="Organisme / Entreprise " name="organisme_exp_pgt" id="organisme_exp_pgt" value="<?php echo $_POST['organisme_exp_pgt'];?>">
                                                    </p>
													<p class="col-1-3 form-field">
														<label for="desc_exp_pgt">Description <span class="required">*</span></label>
														<textarea name="desc_exp_pgt" id="desc_exp_pgt" placeholder="Quelques mots"><?php echo $_POST['desc_exp_pgt'];?></textarea>
													</p>
													<div class="col-1-3 form-field">
                                                        <h5>Localisation</h5>
                                                        <div class="select">
                                                            <select name="localisation_pgt">
                                                                <option value="0">Sélectionnez</option>
                                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                                    <?php foreach ( $listPays as $pays ):?>
                                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_pgt'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </select>
                                                            <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
												</div>
				                            </div>
				                            <p class="col-1-1 add-element">
                                                <a href="javascript:;" id="addProjet" title="Ajouter plus">
	                                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter
                                                </a>
					                            <input type="hidden" name="projet-number" id="projet-number" value="0">
                                            </p>
			                            </div>
			                            <div class="col-1-1 submit-form">
				                            <input type="hidden" name="nonce-inscription" value="<?php echo $nonce;?>">
                                            <input type="submit" class="submit_link button--wapasha button--round-l" value="Envoyer">
                                        </div>

		                            </form>
		                            <?php else : ?>
		                                <div class="col-1-1">
			                                <p>Merci d'avoir créé un compte sur le site  <a href='<?php echo site_url();?>'>Jobopportunity</a>.<br>
				                                Veuillez consulter votre email pour la confirmation de votre inscription.
			                                </p>
		                                </div>
									<?php endif;?>
								</div>
							</article>
                        </main>
                    </div>
				</div>
            </div>
	</section>
<?php get_footer();?>