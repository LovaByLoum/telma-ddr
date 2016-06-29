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
$anneeExperience = get_terms( array( 'taxonomy' => JM_TAXONOMIE_ANNEE_EXPERIENCE,'hide_empty' => false ) );
$typeContrat = get_terms( array( 'taxonomy' => JM_TAXONOMIE_TYPE_CONTRAT,'hide_empty' => false ) );
get_header(); ?>
	<section>
	    <div class="grid grid-pad">
	        <div class="col-1-1">
		        <aside class="widget widget_search homepage">
			        <form role="search" method="get" class="search-form" action="<?php echo get_permalink( $postOffes->ID );?>" autocomplete="off">
	                    <label>
	                    <span class="screen-reader-text">Search for:</span>
	                    <input class="search-field offre" placeholder="Recherche offre …" value="" name="sof" type="search">
	                    </label>
	                    <input class="search-submit" value="Search" type="submit">
	                </form>
		        </aside>
	        </div><!-- col-1-1 -->
	    </div><!-- grid -->
	</section><!-- page-full-entry-content -->
	<section id="page-entry-content">
	    <div class="grid grid-pad">
	        <div class="col-9-12">
	            <div id="primary" class="content-area">
	                <main id="main" class="site-main" role="main">
                        <article class="page type-page status-publish hentry">
                            <?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                            <header class="entry-header">
                                <h1 class="entry-title">
                                    <?php echo $post->post_title;?>
                                </h1>
                            </header>
                            <?php endif;?>
                            <div class="entry-content">
                                <div id="pl-64">
                                    <div class="panel-grid" id="pg-64-0">
                                        <div class="panel-grid-cell" id="pgc-64-0-0">
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

                                            <!--liste offre-->
                                            <div class="so-panel widget widget_siteorigin-panels-postloop panel-last-child" id="panel-64-0-0-1">
                                            <?php $object = new WP_Pagination_Loading('offre-pagination-box');
                                            //configuration
                                            //set list or table view
                                            $object->setListView('div');
                                            //number of item on first load
                                            $object->setItemPerPage(2);
                                            //container class
                                            $object->setContainerClasses('wrapper');
                                            //item classes
                                            $object->setItemClasses('post type-post status-publish format-standard has-post-thumbnail hentry');
                                            //set function callback for customize item template
                                            $object->setRenderItemCallback(array(COffre, 'renderItemCallback'));
                                            //set function callback for getting items by offset, limit, filter and sort, must return array('posts', 'count')
                                            $object->setGetItemsCallback(array(COffre, 'getItemsCallback'));
                                            //add class to retrieve sorting element
                                            $object->addSorting('product-sort-date');
                                            //add class to retrieve filter element
                                            $object->addFilter('product-filtre-category');
                                            $object->configPagination(array('first_text'=>"<<", 'last_text'=>">>"));

                                            //display pagination loading box
                                            $object->displayItems();
                                            //display the pagination loading button
                                            $object->displayPaginationLoadButton();

                                            //hook class item
                                            // $class = class name element
                                            //$key = position element
                                            //apply_filters('wppl_item_class_' . $this->clean_id,$class,$key);

                                            //Filtre type select ajout data-filter="<nom-filtre>" et class
                                            //Filtre input radio/checkbox ajout data-filter="<nom-filtre>" et class

                                            ?>
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
                        <label>Annnée d'experience</label>
                        <select name="data">
                            <option>Sélectionnez</option>
                            <option>option1</option>
                            <option>option2</option>
                            <option>option3</option>
                            <option>option4</option>
                        </select>
                    </aside>
                    <aside class="widget">
                        <input type="checkbox" name="entreprise" value="0" checked>
                        <label for="data">Tous</label>
                    </aside>
                </div>
            </div>
        </div><!-- grid -->
    </section><!-- page-entry-content -->
<?php get_footer(); ?>