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

get_header(); ?>
	<section id="page-entry-content">
	    <div class="grid grid-pad">
	        <div class="col-9-12">
	            <div id="primary" class="content-area">
	                <main id="main" class="site-main" role="main">
		                <?php $object = new WP_Pagination_Loading('offre-pagination-box');
		                    //configuration
		                    //set list or table view
		                    $object->setListView('list');
		                    //number of item on first load
		                    $object->setItemPerPage(3);
		                    //container class
		                    $object->setContainerClasses('wrapper');
		                    //item classes
		                    $object->setItemClasses('test');
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
	                </main><!-- #main -->
				</div><!-- #primary -->
            </div><!-- col-9-12 -->
        </div><!-- grid -->
    </section><!-- page-entry-content -->
<?php get_footer(); ?>