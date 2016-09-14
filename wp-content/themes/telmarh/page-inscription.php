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
$referentielEtude       = get_terms( JM_TAXONOMIE_DOMAINE_ETUDE, array( 'hide_empty' => false ) );
$listPays               = ( isset( $telmarh_options['list_pays'] ) && !empty( $telmarh_options['list_pays'] ) ) ? explode( ",", $telmarh_options['list_pays'] ) : array();
$entreprises            = JM_Societe::getBy();
$nonce                  = wp_create_nonce( "inscription_user" );
$enPoste                = array( 0 => "Non", 1 => "Oui" );
$permis                 = $enPoste;
$catPermis1             = array( "a" => "Permis A", "ap" => "Permis A'", "b" => "Permis B", "c" => "Permis C" );
$catPermis2             = array( "d" => "Permis D", "e" => "Permis E", "f" => "Permis F" );

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
		                            <?php if (  isset( $results['error'] ) && $results['error'] == 1  ) :?>
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
                                                    <input type="text" placeholder="Login" name="login" id="login" value="<?php echo $_POST['login'];?>" autocomplete="off">
                                                </p>
                                                <p class="col-1-3 form-field">
	                                                <label for="passwrd">Mot de passe <span class="required">*</span></label>
                                                    <input type="password" placeholder="Mot de passe" name="passwrd" id="passwrd" value="" autocomplete="off">
                                                </p>
                                                <p class="col-1-3 form-field">
	                                                <label for="passwrdConfirm">Confirmation du mot de passe <span class="required">*</span></label>
                                                    <input type="password" placeholder="Confirmation du mot de passe" name="passwrdConfirm" id="passwrdConfirm" value="<?php echo $_POST['passwrdConfirm'];?>" autocomplete="off">
                                                </p>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Utilisateur</h4>
				                            <div class="head-accordion">
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="nom">Nom <span class="required">*</span></label>
							                            <input type="text" autocomplete="off" placeholder="Nom " name="nom" id="nom" value="<?php echo $_POST['nom'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="prenom">Prénom <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" placeholder="Prénom " id="prenom" name="prenom" value="<?php echo $_POST['prenom'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="birthday">Date de naissance <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="birthday" id="birthday" value="<?php echo $_POST['birthday'];?>">
                                                    </p>
					                            </div>
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="adresse">Adresse <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" placeholder="Adresse" name="adresse" id="adresse" value="<?php echo $_POST['adresse'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="num_phone">N° de téléphone </label>
                                                        <input type="text" autocomplete="off" placeholder="N° de téléphone" id="num_phone" name="num_phone" value="<?php echo $_POST['num_phone'];?>">
                                                    </p>
                                                    <p class="col-1-3 form-field">
	                                                    <label for="email">Adresse email <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" placeholder="Adresse email" name="email" id="email" value="<?php echo $_POST['email'];?>">
                                                    </p>
					                            </div>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Votre parcours</h4>
				                            <div class="content-accordion">
					                            <div class="col-1-1">
						                            <div class="col-1-3 form-field">
                                                        <h5>Niveau d'études <span class="required">*</span></h5>
                                                        <div class="select">
                                                        <select name="niveau_etude">
                                                            <option value="0">Sélectionnez</option>
                                                            <?php if ( !empty( $niveauEtudes ) && count( $niveauEtudes ) > 0 ):?>
                                                                <?php foreach ( $niveauEtudes as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['niveau_etude'] == $term->term_id ):?>selected="selected" <?php endif;?> ><?php echo $term->name;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
	                                                        <option value="autre" <?php if ( $_POST['niveau_etude'] == "autre" ):?>selected="selected" <?php endif;?> >Autre</option>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </div>
                                                    </div>
						                            <p class="col-1-3 form-field niveau-required" <?php if ( $_POST['niveau_etude'] == "autre" ):?>style="display: block;" <?php endif;?> >
                                                        <label for="autre_exp">Autre <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" placeholder="Autre Niveau d'étude" name="autre_exp" id="autre_exp" value="<?php echo $_POST['autre_exp'];?>">
                                                    </p>
                                                    <div class="col-1-3 form-field">
                                                        <h5>Domaine d'étude</h5>
                                                        <div class="select">
                                                        <select name="ref_etude">
                                                            <option value="0">Sélectionnez</option>
                                                            <?php if ( !empty( $referentielEtude ) && count( $referentielEtude ) > 0 ):?>
                                                                <?php foreach ( $referentielEtude as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['ref_etude'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
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
							                            <?php foreach ( $enPoste as $key=>$val ) :?>
		                                                    <label class="control control--radio"><?php echo $val;?>
		                                                        <input type="radio"  value="<?php echo $key;?>" name="en_poste" <?php if ( isset( $_POST['en_poste'] ) && intval( $_POST['en_poste'] ) == $key ):?>checked="checked"<?php endif;?><?php if ( !isset( $_POST['en_poste'] ) && $key == 0 ):?>checked="checked"<?php endif;?>>
		                                                        <div class="control__indicator"></div>
		                                                    </label>
														<?php endforeach;?>
                                                    </div>
                                                    <p class="col-1-3 form-field post-required" <?php if ( isset( $_POST['en_poste'] ) && $_POST['en_poste'] == 1 ):?>style="display: block;" <?php endif;?>>
	                                                    <label for="entreprise">Nom de l'entreprise <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" name="entreprise_user" placeholder="Nom de l'entreprise" id="entreprise" value="<?php echo $_POST['entreprise_user'];?>"/>
                                                    </p>
                                                    <p class="col-1-3 form-field post-required" <?php if ( isset( $_POST['en_poste'] ) && $_POST['en_poste'] == 1 ):?>style="display: block;" <?php endif;?>>
	                                                    <label for="fonction">Fonction dans l'entreprise <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" name="fonction_user" placeholder="Fonction" id="fonction" value="<?php echo $_POST['fonction_user'];?>"/>
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
														<?php foreach ( $permis as $key=>$val ) :?>
	                                                    <label class="control control--radio"><?php echo $val;?>
	                                                        <input type="radio"  value="<?php echo $key;?>" name="permis" <?php if ( isset( $_POST['permis'] ) && intval( $_POST['permis'] ) == $key ):?>checked="checked"<?php endif;?><?php if ( !isset( $_POST['permis'] ) && $key == 0 ):?>checked="checked"<?php endif;?>>
	                                                        <div class="control__indicator"></div>
	                                                    </label>
														<?php endforeach;?>
	                                                </div>
						                            <div class="col-1-3 form-field permis-required" <?php if ( isset( $_POST['permis'] ) && $_POST['permis'] == 1 ):?>style="display: block;" <?php endif;?>>
	                                                    <h5>Catégories <span class="required">*</span></h5>
							                            <?php foreach ( $catPermis1 as $key=> $val ):?>
	                                                    <label class="control control--checkbox"><?php echo $val;?>
	                                                        <input type="checkbox"  value="<?php echo $key;?>" name="permCat[]" class="permCat" <?php if ( isset( $_POST['permCat'] ) && in_array( $key, $_POST['permCat'] ) ):?>checked="checked" <?php endif;?> >
	                                                        <div class="control__indicator"></div>
	                                                    </label>
														<?php endforeach;?>
	                                                </div>
						                            <div class="col-1-3 form-field permis-required" <?php if ( isset( $_POST['permis'] ) && $_POST['permis'] == 1 ):?>style="display: block;" <?php endif;?>>
							                            <h5>&nbsp;</h5>
							                            <?php
							                            $i = 1;
							                            foreach ( $catPermis2 as $key=>$val ):?>
							                            <label class="control control--checkbox <?php if ( count( $catPermis2 ) == $i ):?>latest<?php endif;?> "><?php echo $val;?>
	                                                        <input type="checkbox"  value="<?php echo $key;?>" name="permCat[]" class="permCat" <?php if ( isset( $_POST['permCat'] ) && in_array( $key, $_POST['permCat'] ) ):?>checked="checked" <?php endif;?>>
	                                                        <div class="control__indicator"></div>
	                                                    </label>
													<?php   $i++;
						                                endforeach;?>
						                            </div>
												</div>
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
							                            <label for="date_dispo">Date de disponibilité <span class="required">*</span></label>
                                                        <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="date_dispo" id="date_dispo" value="<?php echo $_POST['date_dispo'];?>">
                                                    </p>
						                            <div class="col-1-3 form-field">
                                                        <h5>Nombre d’années d’expérience professionnelle <span class="required">*</span></h5>
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
                                                    <h5>Expérience professionnelle n°<span>1</span></h5>
                                                </div>
					                            <div class="col-1-1 add-element">
						                            <a href="javascript:;" class="deleteExperience" title="En savoir plus">
                                                        <i class="fa fa-minus"></i>&nbsp;&nbsp;Supprimer
                                                    </a>
					                            </div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="titre_exp_prof">Titre de l'experience <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" placeholder="Titre de l'experience" name="titre_exp_prof" id="titre_exp_prof" value="<?php echo $_POST['titre_exp_prof'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_prof">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="db_exp_prof" id="db_exp_prof" value="<?php echo $_POST['db_exp_prof'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_prof">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="df_exp_prof" id="df_exp_prof" value="<?php echo $_POST['df_exp_prof'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_prof">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" autocomplete="off" placeholder="Organisme / Entreprise " name="organisme_exp_prof" id="organisme_exp_prof" value="<?php echo $_POST['organisme_exp_prof'];?>">
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
				                            <h4 class="head-accordion">Etudes et formations <span class="required">*</span></h4>
				                            <div id="formation-repeat" class="content-accordion sample formation">
					                            <div class="col-1-1 number">
						                            <h5>Etude et formation n°<span>1</span></h5>
					                            </div>
					                            <div class="col-1-1 add-element">
                                                    <a href="javascript:;" class="deleteFormation" title="En savoir plus">
                                                        <i class="fa fa-minus"></i>&nbsp;&nbsp;Supprimer
                                                    </a>
                                                </div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="titre_exp_for">Titre de l'experience <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" placeholder="Titre de l'experience" name="titre_exp_for" id="titre_exp_for" value="<?php echo $_POST['titre_exp_for'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_for">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="db_exp_for" id="db_exp_for" value="<?php echo $_POST['db_exp_for'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_for">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="df_exp_for" id="df_exp_for" value="<?php echo $_POST['df_exp_for'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_for">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" autocomplete="off" placeholder="Organisme / Entreprise " name="organisme_exp_for" id="organisme_exp_for" value="<?php echo $_POST['organisme_exp_for'];?>">
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
	                                                    <input type="text" autocomplete="off" placeholder="Titre de l'experience" name="titre_exp_pgt" id="titre_exp_pgt" value="<?php echo $_POST['titre_exp_pgt'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="db_exp_pgt">Date de debut <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="db_exp_pgt" id="db_exp_pgt" value="<?php echo $_POST['db_exp_pgt'];?>">
	                                                </p>
	                                                <p class="col-1-3 form-field">
		                                                <label for="df_exp_pgt">Date de fin <span class="required">*</span></label>
	                                                    <input type="text" autocomplete="off" class="datepicker" placeholder="jour/mois/année" readonly name="df_exp_pgt" id="df_exp_pgt" value="<?php echo $_POST['df_exp_pgt'];?>">
	                                                </p>
												</div>
												<div class="col-1-1">
													<p class="col-1-3 form-field">
														<label for="organisme_exp_pgt">Organisme / Entreprise <span class="required">*</span></label>
														<input type="text" autocomplete="off" placeholder="Organisme / Entreprise " name="organisme_exp_pgt" id="organisme_exp_pgt" value="<?php echo $_POST['organisme_exp_pgt'];?>">
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
				                            <input type="hidden" name="nonce_inscription" value="<?php echo $nonce;?>">
                                            <input type="submit" class="submit_link button--wapasha button--round-l" value="Envoyer">
                                        </div>

		                            </form>
		                            <?php else : ?>
		                                <div class="col-1-1 result-submit">
			                                <p>Merci d'avoir créé un compte sur le site  <a href='<?php echo site_url();?>'>Jobopportunity</a>.<br>
				                                Veuillez consulter votre email pour confirmer votre inscription.
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