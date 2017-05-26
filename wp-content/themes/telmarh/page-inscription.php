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
$referentielEtude       = get_terms( JM_TAXONOMIE_DEPARTEMENTMIE_DOMAINE_ETUDE, array( 'hide_empty' => false ) );
$listPays               = ( isset( $telmarh_options['list_pays'] ) && !empty( $telmarh_options['list_pays'] ) ) ? explode( ",", $telmarh_options['list_pays'] ) : array();
$entreprises            = JM_Societe::getBy();
$nonce                  = wp_create_nonce( "inscription_user" );
$enPoste                = array( 0 => "Non", 1 => "Oui" );
$permis                 = $enPoste;
$catPermis1             = array( "a" => "Permis A", "ap" => "Permis A'", "b" => "Permis B", "c" => "Permis C" );
$catPermis2             = array( "d" => "Permis D", "e" => "Permis E", "f" => "Permis F" );
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );

get_header(); ?>
<section id="page-full-entry-content" class="registration-form form-page">
    <figure class="alauneImg">
        <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
    </figure>
    <header class="entry-header">
        <div class="container">
            <?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                <h1 class="entry-title"><?php echo $post->post_title;?></h1>
            <?php endif;?>
            <div class="entry-content">
                <?php echo apply_filters("the_content", $post->post_content );?>
            </div>
        </div>
    </header>
    <article class="content-area main-content" id="primary">
        <div class="status-publish hentry container">
            <?php if (  isset( $results['error'] ) && $results['error'] == 1  ) :?>
                <!--error php-->
                <?php if ( isset( $results['messages'] ) && !empty( $results['messages'] ) ):?>
                    <ul>
                        <?php echo $results['messages'];?>
                    </ul>
                   <?php  endif;?>
                <!--error php-->
                <div class="form-layout">
                    <form class="comment-form" id="inscription_user" autocomplete="off" action="<?php echo get_permalink( $post->ID );?>" method="post">
                        <!-- Compte -->
                        <div class="control-group">
                            <h4 class="head-accordion open">Compte</h4>
                            <div class="head-accordion">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="login">Login <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Login" name="login" id="login" value="<?php echo $_POST['login'];?>" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="passwrd">Mot de passe <span class="required">*</span></label>
                                        <input type="password" class="form-control" placeholder="Mot de passe" name="passwrd" id="passwrd" value="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="passwrdConfirm">Confirmation du mot de passe <span class="required">*</span></label>
                                        <input type="password" class="form-control" placeholder="Confirmation du mot de passe" name="passwrdConfirm" id="passwrdConfirm" value="<?php echo $_POST['passwrdConfirm'];?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Compte -->

                        <!-- Utilisateur -->
                        <div class="control-group open">
                            <h4 class="head-accordion">Utilisateur</h4>
                            <div class="head-accordion">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="nom">Nom <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Nom " name="nom" id="nom" value="<?php echo $_POST['nom'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="prenom">Prénom <span class="required">*</span></label>
                                        <input class="form-control" type="text" autocomplete="off" placeholder="Prénom " id="prenom" name="prenom" value="<?php echo $_POST['prenom'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="birthday">Date de naissance <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="birthday" id="birthday" value="<?php echo $_POST['birthday'];?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="adresse">Adresse <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Adresse" name="adresse" id="adresse" value="<?php echo $_POST['adresse'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="num_phone">N° de téléphone </label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="N° de téléphone" id="num_phone" name="num_phone" value="<?php echo $_POST['num_phone'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Adresse email <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Adresse email" name="email" id="email" value="<?php echo $_POST['email'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Utilisateur -->

                        <!-- Votre parcours -->
                        <div class="control-group open">
                            <h4 class="head-accordion">Votre parcours</h4>
                            <div class="content-accordion">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h5>Niveau d'études <span class="required">*</span></h5>
                                        <div class="select">
                                            <select name="niveau_etude" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $niveauEtudes ) && count( $niveauEtudes ) > 0 ):?>
                                                    <?php foreach ( $niveauEtudes as $term ):?>
                                                        <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['niveau_etude'] == $term->term_id ):?>selected="selected" <?php endif;?> ><?php echo $term->name;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                                <option value="autre" <?php if ( $_POST['niveau_etude'] == "autre" ):?>selected="selected" <?php endif;?> >Autre</option>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 form-field niveau-required" <?php if ( $_POST['niveau_etude'] == "autre" ):?>style="display: block;" <?php endif;?>>
                                        <label for="autre_exp">Autre <span class="required">*</span></label>
                                        <input type="text" class="form-control" autocomplete="off" placeholder="Autre Niveau d'étude" name="autre_exp" id="autre_exp" value="<?php echo $_POST['autre_exp'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h5>Domaine d'étude</h5>
                                        <div class="select">
                                            <select name="ref_etude" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $referentielEtude ) && count( $referentielEtude ) > 0 ):?>
                                                    <?php foreach ( $referentielEtude as $term ):?>
                                                        <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['ref_etude'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h5>En poste<span class="required">*</span></h5>
                                        <div class="radio-item">
                                            <?php foreach ( $enPoste as $key=>$val ) :?>
                                                <label class="control control--radio">
                                                    <input type="radio" class="" value="<?php echo $key;?>" name="en_poste" <?php if ( isset( $_POST['en_poste'] ) && intval( $_POST['en_poste'] ) == $key ):?>checked="checked"<?php endif;?><?php if ( !isset( $_POST['en_poste'] ) && $key == 0 ):?>checked="checked"<?php endif;?>>
                                                    <span class="control__indicator"></span>
                                                    <span class="control__description"><?php echo $val;?></span>
                                                </label>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 post-required" <?php if ( isset( $_POST['en_poste'] ) && $_POST['en_poste'] == 1 ):?>style="display: block;" <?php endif;?>>
                                        <label for="entreprise">Nom de l'entreprise <span class="required">*</span></label>
                                        <input type="text" class="form-control" autocomplete="off" name="entreprise_user" placeholder="Nom de l'entreprise" id="entreprise" value="<?php echo $_POST['entreprise_user'];?>"/>
                                    </div>
                                    <div class="form-group col-md-4 post-required" <?php if ( isset( $_POST['en_poste'] ) && $_POST['en_poste'] == 1 ):?>style="display: block;" <?php endif;?>>
                                        <label for="fonction">Fonction dans l'entreprise <span class="required">*</span></label>
                                        <input type="text" class="form-control" autocomplete="off" name="fonction_user" placeholder="Fonction" id="fonction" value="<?php echo $_POST['fonction_user'];?>"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h5>Mobilité</h5>
                                        <div class="select">
                                            <select name="region" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $localisation ) && count( $localisation ) > 0 ):?>
                                                    <?php foreach ( $localisation as $term ):?>
                                                        <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['region'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h5>Domaine de métier recherché</h5>
                                        <div class="select">
                                            <select name="dom_metier" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $domainesMetier ) && count( $domainesMetier ) > 0 ):?>
                                                    <?php foreach ( $domainesMetier as $term ):?>
                                                        <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['dom_metier'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h5>Permis de conduire <span class="required">*</span></h5>
                                        <div class="radio-item">
                                            <?php foreach ( $permis as $key=>$val ) :?>
                                                <label class="control control--radio">
                                                    <input type="radio" value="<?php echo $key;?>" name="permis" <?php if ( isset( $_POST['permis'] ) && intval( $_POST['permis'] ) == $key ):?>checked="checked"<?php endif;?><?php if ( !isset( $_POST['permis'] ) && $key == 0 ):?>checked="checked"<?php endif;?>>
                                                    <span class="control__indicator"></span>
                                                    <span class="control__description"><?php echo $val;?></span>
                                                </label>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                    <div class="form-group permis-required col-6 col-md-4" <?php if ( isset( $_POST['permis'] ) && $_POST['permis'] == 1 ):?>style="display: block;" <?php endif;?> >
                                        <h5>Catégories <span class="required">*</span></h5>
                                        <ul class="checkbox-item checkbox-list">
                                            <?php foreach ( $catPermis1 as $key=> $val ):?>
                                                <li>
                                                    <label class="control control--checkbox">
                                                        <input type="checkbox" value="<?php echo $key;?>" name="permCat[]" class="permCat" <?php if ( isset( $_POST['permCat'] ) && in_array( $key, $_POST['permCat'] ) ):?>checked="checked" <?php endif;?> >
                                                        <span class="control__indicator"></span>
                                                        <span class="control__description"><?php echo $val;?></span>
                                                    </label>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                    <div class="form-group permis-required col-6 col-md-4" <?php if ( isset( $_POST['permis'] ) && $_POST['permis'] == 1 ):?>style="display: block;" <?php endif;?> >
                                        <h5>&nbsp;</h5>
                                        <ul class="checkbox-item checkbox-list">
                                            <?php $i = 1;  foreach ( $catPermis2 as $key=>$val ):?>
                                                <li>
                                                    <label class="control control--checkbox <?php if ( count( $catPermis2 ) == $i ):?>latest<?php endif;?>">
                                                        <input type="checkbox" value="<?php echo $key;?>" name="permCat[]" class="permCat" <?php if ( isset( $_POST['permCat'] ) && in_array( $key, $_POST['permCat'] ) ):?>checked="checked" <?php endif;?> >
                                                        <span class="control__indicator"></span>
                                                        <span class="control__description"><?php echo $val;?></span>
                                                    </label>
                                                </li>
                                            <?php   $i++; endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-lg-4">
                                        <label for="date_dispo">Date de disponibilité <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="date_dispo" id="date_dispo" value="<?php echo $_POST['date_dispo'];?>">
                                    </div>
                                    <div class="form-group col-md-6 col-lg-4">
                                        <h5>Nombre d’années d’expérience professionnelle <span class="required">*</span></h5>
                                        <div class="select">
                                            <select name="annee_exp" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $anneeExperiences ) && count( $anneeExperiences ) > 0 ):?>
                                                    <?php foreach ( $anneeExperiences as $term ):?>
                                                        <option value="<?php echo $term->term_id;?>" <?php if ( $_POST['annee_exp'] == $term->term_id ):?>selected="selected" <?php endif;?>><?php echo $term->name;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- /Votre parcours -->

                        <!-- Expériences professionnelles (dont stages) -->
                        <div class="control-group">
                            <h4 class="head-accordion">Expériences professionnelles (dont stages) <span class="required">*</span></h4>
                            <div id="experience-repeat" class="content-accordion experience sample">
                                <div class="number clearfix">
                                    <div class="action-element remove-element">
                                        <a href="javascript:;" class="deleteExperience" title="En savoir plus"><i class="fa fa-minus"></i>Supprimer</a>
                                    </div>
                                    <h5>Expérience professionnelle n°<span>1</span></h5>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="titre_exp_prof">Titre de l'expérience <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Titre de l'experience" name="titre_exp_prof" id="titre_exp_prof" value="<?php echo $_POST['titre_exp_prof'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="db_exp_prof">Date de début <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="db_exp_prof" id="db_exp_prof" value="<?php echo $_POST['db_exp_prof'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="df_exp_prof">Date de fin <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="df_exp_prof" id="df_exp_prof" value="<?php echo $_POST['df_exp_prof'];?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="organisme_exp_prof">Organisme / Entreprise <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Organisme / Entreprise " name="organisme_exp_prof" id="organisme_exp_prof" value="<?php echo $_POST['organisme_exp_prof'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="desc_exp_prof">Description <span class="required">*</span></label>
                                        <textarea name="desc_exp_prof" class="form-control" id="desc_exp_prof" placeholder="Quelques mots"><?php echo $_POST['desc_exp_prof'];?></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h5>Localisation </h5>
                                        <div class="select">
                                            <select name="localisation_prof" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                    <?php foreach ( $listPays as $pays ):?>
                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_prof'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="action-element add-element">
                                <a href="javascript:;" id="addExperience" title="Ajouter plus"><i class="fa fa-plus"></i>Ajouter</a>
                                <input type="hidden" id="experience-number" value="0" name="experience-number">
                            </p>
                        </div>
                        <!-- //Expériences professionnelles (dont stages) -->
                        
                        <!-- Etudes et formations -->
                        <div class="control-group">
                            <h4 class="head-accordion">Etudes et formations <span class="required">*</span></h4>
                            <div id="formation-repeat" class="content-accordion formation sample">
                                <div class="number clearfix">
                                    <div class="action-element remove-element">
                                        <a href="javascript:;" class="deleteFormation" title="En savoir plus"><i class="fa fa-minus"></i>Supprimer</a>
                                    </div>
                                    <h5>Etude et formation n°<span>1</span></h5>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="titre_exp_for">Intitulé de la formation <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Intitulé de la formation" name="titre_exp_for" id="titre_exp_for" value="<?php echo $_POST['titre_exp_for'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="db_exp_for">Date de début <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="db_exp_for" id="db_exp_for" value="<?php echo $_POST['db_exp_for'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="df_exp_for">Date de fin <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="df_exp_for" id="df_exp_for" value="<?php echo $_POST['df_exp_for'];?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="organisme_exp_for">Ecole / Université / Organisme de formation<span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Ecole / Université / Organisme de formation…" name="organisme_exp_for" id="organisme_exp_for" value="<?php echo $_POST['organisme_exp_for'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <textarea name="desc_exp_for" class="form-control" id="desc_exp_for" placeholder="Quelques mots"><?php echo $_POST['desc_exp_for'];?></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h5>Localisation</h5>
                                        <div class="select">
                                            <select name="localisation_for" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                    <?php foreach ( $listPays as $pays ):?>
                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_for'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="action-element add-element">
                                <a href="javascript:;" id="addFormation"  title="Ajouter plus"><i class="fa fa-plus"></i>Ajouter</a>
                                <input type="hidden" id="formation-number" name="formation-number" value="0">
                            </p>
                        </div>
                        <!-- //Etudes et formations -->

                        <div class="control-group">
                            <h4 class="head-accordion">Projets personnels, professionnels (ingéniorat ou autres)</h4>
                            <div class="form-group">
                                <h5>Projets</h5>
                                <div class="radio-item">
                                    <label class="control control--radio">
                                        <input type="radio" value="0" name="projet" checked="checked">
                                        <span class="control__indicator"></span>
                                        <span class="control__description">Non</span>
                                    </label>
                                    <label class="control control--radio">
                                        <input type="radio" value="1" name="projet">
                                        <span class="control__indicator"></span>
                                        <span class="control__description">Oui</span
                                    </label>
                                </div>
                            </div>
                            <div id="projet-repeat" class="content-accordion projet projet-required sample">
                                <div class="number clearfix">
                                    <div class="action-element remove-element">
                                        <a href="javascript:;" class="deleteProjet" title="En savoir plus"><i class="fa fa-minus"></i>Supprimer</a>
                                    </div>
                                    <h5>Projets n°<span>1</span></h5>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="titre_exp_pgt">Titre de l'expérience <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Titre de l'experience" name="titre_exp_pgt" id="titre_exp_pgt" value="<?php echo $_POST['titre_exp_pgt'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="db_exp_pgt">Date de début <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="db_exp_pgt" id="db_exp_pgt" value="<?php echo $_POST['db_exp_pgt'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="df_exp_pgt">Date de fin <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="datepicker form-control" placeholder="jour/mois/année" readonly name="df_exp_pgt" id="df_exp_pgt" value="<?php echo $_POST['df_exp_pgt'];?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="organisme_exp_pgt">Organisme / Entreprise <span class="required">*</span></label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Organisme / Entreprise " name="organisme_exp_pgt" id="organisme_exp_pgt" value="<?php echo $_POST['organisme_exp_pgt'];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="desc_exp_pgt">Description <span class="required">*</span></label>
                                        <textarea name="desc_exp_pgt" class="form-control" id="desc_exp_pgt" placeholder="Quelques mots"><?php echo $_POST['desc_exp_pgt'];?></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h5>Localisation</h5>
                                        <div class="select">
                                            <select name="localisation_pgt" class="form-control">
                                                <option value="0">Sélectionnez</option>
                                                <?php if ( !empty( $listPays ) && count( $listPays ) > 0 ):?>
                                                    <?php foreach ( $listPays as $pays ):?>
                                                        <option value="<?php echo $pays;?>" <?php if ( $_POST['localisation_pgt'] == $pays ):?>selected="selected" <?php endif;?>><?php echo $pays;?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                            <div class="select__arrow"><i class="fa fa-caret-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="action-element add-element">
                                <a href="javascript:;" id="addProjet" title="Ajouter plus"><i class="fa fa-plus"></i>Ajouter</a>
                                <input type="hidden" name="projet-number" id="projet-number" value="0">
                            </p>
                        </div>
                        <div class="submit-form">
                            <input type="hidden" name="nonce_inscription" value="<?php echo $nonce;?>">
                            <input type="submit" class="submit_link submit-button" value="Envoyer">
                        </div>
                    </form>
                </div>
            <?php else : ?>
                <div class="result-submit">
                    <p>Merci d'avoir créé un compte sur le site  <a href='<?php echo site_url();?>'>Jobopportunity</a>.<br> Veuillez consulter votre email pour confirmer votre inscription.</p>
                </div>
            <?php endif;?>
        </div>
    </article>
</section>
<?php get_footer();?>