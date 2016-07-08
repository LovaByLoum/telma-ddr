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
global $post;
$anneeExperiences       = get_terms( JM_TAXONOMIE_ANNEE_EXPERIENCE, array( 'hide_empty' => false ) );
$typeContrat            = get_terms( JM_TAXONOMIE_TYPE_CONTRAT, array( 'hide_empty' => false ) );
$localisation           = get_terms( JM_TAXONOMIE_LOCALISATION,array( 'hide_empty' => false ) );
$criticites             = get_terms( JM_TAXONOMIE_CRITICITE, array( 'hide_empty' => false ) );
$niveauEtudes           = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false ) );
$domainesMetier         = get_terms( JM_TAXONOMIE_DEPARTEMENT, array( 'hide_empty' => false ) );
$referentielEtude = array();
$entreprises  = JM_Societe::getBy();

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
		                            <form class="comment-form" autocomplete="off">
			                            <div class="control-group">
				                            <h4 class="head-accordion open">Compte</h4>
				                            <div class="head-accordion">
					                            <p class="col-1-3 form-field">
                                                    <input type="text" placeholder="Login *" name="login" autocomplete="false">
                                                </p>
                                                <p class="col-1-3 form-field">
                                                    <input type="password" placeholder="Mot de passe *" name="passwrd" autocomplete="false">
                                                </p>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Utilisateur</h4>
				                            <div class="head-accordion">
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Nom *">
                                                    </p>
                                                    <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Prénom *">
                                                    </p>
                                                    <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Date de naissance *">
                                                    </p>
					                            </div>
					                            <div class="col-1-1">
						                            <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Adresse *">
                                                    </p>
                                                    <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="N° de téléphone *">
                                                    </p>
                                                    <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Adresse email *">
                                                    </p>
                                                    <p class="col-1-3 form-field">
                                                        <input type="text" placeholder="Date de naissance *">
                                                    </p>
					                            </div>
				                            </div>
			                            </div>
			                            <div class="control-group  open">
				                            <h4 class="head-accordion">Votre parcours</h4>
				                            <div class="head-accordion">
					                            <div class="col-1-1">
						                            <div class="col-1-3 form-field">
                                                        <h5>Niveau d'etude</h5>
                                                        <p class="select">
                                                        <select>
                                                            <option value="">Sélectionnez</option>
                                                            <?php if ( !empty( $niveauEtudes ) && count( $niveauEtudes ) > 0 ):?>
                                                                <?php foreach ( $niveauEtudes as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </p>

                                                    </div>
                                                    <div class="col-1-3 form-field">
                                                        <h5>Domaine d'etude</h5>
                                                        <p class="select">
                                                        <select>
                                                            <option value="">Sélectionnez</option>
                                                            <?php if ( !empty( $referentielEtude ) && count( $referentielEtude ) > 0 ):?>
                                                                <?php foreach ( $referentielEtude as $element ):?>
                                                                    <option value=""></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                        </p>

                                                    </div>
                                                    <div class="col-1-3 form-field">
                                                        <h5>Région</h5>
                                                        <p class="select">
                                                            <select>
                                                                <option value="">Sélectionnez</option>
                                                                <?php if ( !empty( $localisation ) && count( $localisation ) > 0 ):?>
                                                                    <?php foreach ( $localisation as $term ):?>
                                                                        <option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </select>
                                                            <div class="select__arrow"></div>
                                                        </p>
                                                    </div>
					                            </div>
					                            <div class="col-1-3 form-field">
						                            <h5>En poste<span class="required">*</span></h5>
                                                    <label class="control control--radio">Oui
                                                        <input type="radio"  value="0" name="en_poste" checked="checked">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--radio">Non
                                                        <input type="radio"  value="1" name="en_poste">
                                                        <div class="control__indicator"></div>
                                                    </label>
					                            </div>
					                            <p class="col-1-3 form-field">
                                                    <input type="text" name="entreprise_user" placeholder="Nom de l'entreprise *"/>
                                                </p>
					                            <p class="col-1-3 form-field">
                                                    <input type="text" name="fonction_user" placeholder="Fonction *"/>
                                                </p>
					                            <div class="col-1-3 form-field">
                                                    <h5>Domaine de métier recherché</h5>
                                                    <p class="select">
                                                        <select>
                                                            <option value="">Sélectionnez</option>
                                                            <?php if ( !empty( $domainesMetier ) && count( $domainesMetier ) > 0 ):?>
                                                                <?php foreach ( $domainesMetier as $term ):?>
                                                                    <option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                    </p>
                                                </div>
					                            <div class="col-1-3 form-field">
					                            </div>
					                            <div class="col-1-3 form-field">
					                            </div>
					                            <div class="col-1-3 form-field">
                                                    <h5>Permis de conduire<span class="required">*</span></h5>
                                                    <label class="control control--radio">Oui
                                                        <input type="radio"  value="0" name="permis" checked="checked">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--radio">Non
                                                        <input type="radio"  value="1" name="permis">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </div>
					                            <div class="col-1-3 form-field">
                                                    <h5>Catégories permis<span class="required">*</span></h5>
                                                    <label class="control control--checkbox">Permis A
                                                        <input type="checkbox"  value="a" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--checkbox">Permis A'
                                                        <input type="checkbox"  value="ap" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--checkbox">Permis B
                                                        <input type="checkbox"  value="b" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--checkbox">Permis C
                                                        <input type="checkbox"  value="c" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </div>
					                            <div class="col-1-3 form-field suite">
						                            <label class="control control--checkbox">Permis D
                                                        <input type="checkbox"  value="d" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--checkbox">Permis E
                                                        <input type="checkbox"  value="e" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                    <label class="control control--checkbox">Permis F
                                                        <input type="checkbox"  value="f" name="permis_cat">
                                                        <div class="control__indicator"></div>
                                                    </label>
					                            </div>
				                            </div>
			                            </div>

		                            </form>
								</div>
							</article>
                        </main>
                    </div>
				</div>
            </div>
	</section>
<?php get_footer();?>