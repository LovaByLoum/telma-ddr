<?php
/**
 * Template Name: Liste des offres
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post;
$anneeExperiences = get_terms( JM_TAXONOMIE_ANNEE_EXPERIENCE, array( 'hide_empty' => false ) );
$typeContrat = get_terms( JM_TAXONOMIE_TYPE_CONTRAT, array( 'hide_empty' => false ) );
$localisation = get_terms( JM_TAXONOMIE_LOCALISATION,array( 'hide_empty' => false ) );
$criticites = get_terms( JM_TAXONOMIE_CRITICITE, array( 'hide_empty' => false ) );
$entreprises  = JM_Societe::getBy();
$recherche = ( isset( $_GET['sof'] ) && !empty( $_GET['sof'] ) ) ? $_GET['sof'] : "";
get_header(); ?>
	<section class="listing-offer">
	    <div class="grid grid-pad">
	        <div class="col-1-1">
		        <?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                <header class="entry-header">
                    <h1 class="entry-title">
                        <?php echo $post->post_title;?>
                    </h1>
                </header>
                <?php endif;?>
		        <!--post content-->
                <?php if ( isset( $post->post_content ) && !empty( $post->post_content ) ):?>
                <div class="so-panel widget widget_sow-editor panel-first-child" id="panel-64-0-0-0" data-index="0"><div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <div class="siteorigin-widget-tinymce textwidget">
                            <?php echo apply_filters( "the_content", $post->post_content );?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <!--/post content-->
	        </div><!-- col-1-1 -->
	    </div><!-- grid -->
	</section><!-- page-full-entry-content -->
	<section id="page-entry-content" class="listing-offer">
	    <div class="grid grid-pad">
	        <div class="col-9-12">
	            <div id="primary" class="content-area">
	                <main id="main" class="site-main" role="main">
                        <article class="page type-page status-publish hentry">
                            <div>
	                            <aside class="widget widget_search homepage"style="text-align: center;">
                                    <label>
                                    <span class="screen-reader-text">Search for:</span>
                                    <input class="search-field offre recherche" data-filter="recherche" placeholder="Rechercher une offre …" value="<?php echo $recherche;?>" name="sof" type="text">
                                    </label>
                                    <input class="search-submit" value="Search" type="submit">
                                </aside>
                                <div id="pl-64">
                                    <div class="panel-grid" id="pg-64-0">
                                        <div class="panel-grid-cell" id="pgc-64-0-0">
                                            <!--liste offre-->
                                            <div class="so-panel widget widget_siteorigin-panels-postloop panel-last-child" id="panel-64-0-0-1">
                                            <?php $object = new WP_Pagination_Loading('offre-pagination-box');
                                            //configuration
                                            //set list or table view
                                            $object->setListView('div');
                                            //number of item on first load
                                            $object->setItemPerPage(8);
                                            //container class
                                            $object->setContainerClasses('wrapper');
                                            //item classes
                                            $object->setItemClasses('post type-post status-publish format-standard has-post-thumbnail hentry');
                                            //set function callback for customize item template
                                            $object->setRenderItemCallback(array(COffre, 'renderItemCallback'));
                                            //set function callback for getting items by offset, limit, filter and sort, must return array('posts', 'count')
                                            $object->setGetItemsCallback(array(COffre, 'getItemsCallback'));
                                            //add class to retrieve sorting element
//                                            $object->addSorting('order-criteria');
                                            //add class to retrieve filter element
                                            $object->addFilter('recherche');
                                            $object->addFilter('order-criteria');
                                            $object->addFilter('entreprise');
                                            $object->addFilter(JM_TAXONOMIE_CRITICITE);
                                            $object->addFilter(JM_TAXONOMIE_ANNEE_EXPERIENCE);
                                            $object->addFilter(JM_TAXONOMIE_TYPE_CONTRAT);
                                            $object->addFilter(JM_TAXONOMIE_LOCALISATION);
                                            $object->configPagination(array('prev_text'=>"Page précédente", 'next_text'=>"Page suivante", "always_show" => false, "dotleft_text" => "&nbsp;", "dotright_text"=> "&nbsp;", "last_text" => "", "first_text" => "", "num_pages" => 7 ));

                                            //display pagination loading box
                                            $object->displayItems();
                                            if ( !empty( $recherche ) ) {
	                                            $object->setOnLoadFilter( array( 'recherche' => $recherche ) );
                                            }
                                            //display the pagination loading button
                                            ?>
                                            <nav class="pagination-bloc hidden-xs hidden-sm">
                                            <?php
                                            $object->displayPaginationLoadButton();
											?>
                                            </nav>
                                            </div>
                                            <!--liste offre-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
	                </main><!-- #main -->
				</div><!-- #primary -->
            </div><!-- col-9-12 -->
            <div class="col-3-12">
                <div class="widget-area">
	                <aside class="widget">
		                <div class="control-group">
							<h4>Triée par :</h4>
			                <div class="select">
				                <select class="order-criteria" data-filter="order-criteria">
									<option value="date">Date de publication</option>
									<option value="date-offre">Date d’expiration de l’offre</option>
                                </select>
				                <div class="select__arrow"></div>
			                </div>
		                </div>
	                </aside>
                    <aside class="widget">
	                    <div class="control-group">
		                    <h4 class="head-accordion open">Entreprise</h4>
		                        <div class="content-accordion">
			                        <?php if ( !empty( $entreprises ) && count( $entreprises ) > 0 ):
	                                        foreach ( $entreprises as $entreprise ):  ?>
	                                            <label class="control control--checkbox"><?php echo $entreprise->titre;?>
	                                                <input type="checkbox" name="entreprise" value="<?php echo $entreprise->id;?>" data-filter="entreprise" class="entreprise">
	                                                <div class="control__indicator"></div>
	                                            </label>
	                                <?php   endforeach;
	                                    endif;?>
		                        </div>
	                    </div>
                    </aside>
	                <aside class="widget">
                        <div class="control-group">
	                        <h4 class="head-accordion open">Région</h4>
							<div class="content-accordion">
								<?php if ( !empty( $localisation ) && count( $localisation ) > 0 ):
			                            foreach ( $localisation as $term ):?>
				                        <label class="control control--checkbox"><?php echo $term->name;?>
					                        <input type="checkbox" value="<?php echo $term->term_id;?>" name="<?php echo JM_TAXONOMIE_LOCALISATION;?>" data-filter="<?php echo JM_TAXONOMIE_LOCALISATION;?>" class="<?php echo JM_TAXONOMIE_LOCALISATION;?>">
					                        <div class="control__indicator"></div>
				                        </label>
		                        <?php   endforeach;
		                            endif;?>
							</div>
                        </div>
                    </aside>
	                <aside class="widget">
		                <div class="control-group">
                            <h4 class="head-accordion open">Année d'experience</h4>
							<div class="content-accordion">
								<?php if ( !empty( $anneeExperiences ) && count( $anneeExperiences ) > 0 ):
	                                    foreach ( $anneeExperiences as $term ):?>
	                                        <label class="control control--checkbox"><?php echo $term->name;?>
	                                            <input type="checkbox" value="<?php echo $term->term_id;?>" name="<?php echo JM_TAXONOMIE_ANNEE_EXPERIENCE;?>" data-filter="<?php echo JM_TAXONOMIE_ANNEE_EXPERIENCE;?>" class="<?php echo JM_TAXONOMIE_ANNEE_EXPERIENCE;?>">
	                                            <div class="control__indicator"></div>
	                                        </label>
	                            <?php   endforeach;
	                                endif;?>
							</div>
                        </div>
                    </aside>
	                <aside class="widget">
		                <div class="control-group">
	                        <h4 class="head-accordion open">Type de contrat</h4>
			                <div class="content-accordion">
				                <?php if ( !empty( $typeContrat ) && count( $typeContrat ) > 0 ):
                                        foreach ( $typeContrat as $term ):?>
                                            <label class="control control--checkbox"><?php echo $term->name;?>
                                                <input type="checkbox" value="<?php echo $term->term_id;?>" name="<?php echo JM_TAXONOMIE_TYPE_CONTRAT;?>" data-filter="<?php echo JM_TAXONOMIE_TYPE_CONTRAT;?>" class="<?php echo JM_TAXONOMIE_TYPE_CONTRAT;?>">
                                                <div class="control__indicator"></div>
                                            </label>
                                <?php   endforeach;
                                    endif;?>
			                </div>
		                </div>
                    </aside>
	                <aside class="widget">
		                <div class="control-group">
	                        <h4 class="head-accordion open">Criticité</h4>
			                <div class="content-accordion">
				                <?php if ( !empty( $criticites ) && count( $criticites ) > 0 ):
                                        foreach ( $criticites as $term ):?>
                                            <label class="control control--checkbox"><?php echo $term->name;?>
                                                <input type="checkbox" value="<?php echo $term->term_id;?>" name="<?php echo JM_TAXONOMIE_CRITICITE;?>" data-filter="<?php echo JM_TAXONOMIE_CRITICITE;?>" class="<?php echo JM_TAXONOMIE_CRITICITE;?>">
                                                <div class="control__indicator"></div>
                                            </label>
                                <?php   endforeach;
                                    endif;?>
			                </div>
		                </div>
                    </aside>
	                <aside class="widget">
		                <p class="reset">
			                <a href="<?php echo get_permalink( $post->ID );?>" title="Réinitialiser" class="submit_link button--wapasha button--round-l">Réinitialiser</a>
		                </p>
                    </aside>
                </div>
            </div>
        </div><!-- grid -->
    </section><!-- page-entry-content -->
<?php get_footer(); ?>