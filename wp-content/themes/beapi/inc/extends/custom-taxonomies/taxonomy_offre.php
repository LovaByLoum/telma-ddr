<?php
/**
 * register taxo type actualite
 *
 * @package    WordPress
 * @subpackage beapi
 * @since      beapi 1.0
 * @author     : Netapsys
 */

add_action( 'init', 'beapi_init_typeactus', 2 );
function beapi_init_typeactus()
{
	//taxonomies
	$labels = get_custom_taxonomy_labels( 'Entreprise', 'Entreprises', 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_ENTREPRISE, POST_TYPE_OFFRE, $args );

	//regions
	$labels = get_custom_taxonomy_labels( "Région", "Régions", 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_REGION, POST_TYPE_OFFRE, $args );

	//référence metier
	$labels = get_custom_taxonomy_labels( "Référence métier", "Références métier", 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_REFERENCE_METIER, POST_TYPE_OFFRE, $args );

	//Année d'experience
	$labels = get_custom_taxonomy_labels( "Année d'experience", "Année d'experience", 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_ANNEE_EXPERIENCE, POST_TYPE_OFFRE, $args );

	//type de contrat
	$labels = get_custom_taxonomy_labels( "Type de contrat", "Type de contrat", 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_TYPE_CONTRAT, POST_TYPE_OFFRE, $args );

	//Criticité
	$labels = get_custom_taxonomy_labels( "Criticité", "Criticité", 1 );
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( TAXONOMY_CRITICITE, POST_TYPE_OFFRE, $args );


}