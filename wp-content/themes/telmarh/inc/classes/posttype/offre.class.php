<?php

/**
 * classe de service pour le type de post actualite
 *
 * @package    WordPress
 * @subpackage telmarh
 * @since      telmarh 1.0
 * @author     : Netapsys
 */
class COffre
{

	private static $_elements;

	public function __construct()
	{

	}

	/**
	 * fonction qui prend les informations par son Id.
	 *
	 * @param type $pid
	 */
	public static function getById( $pid )
	{
		$pid = intval( $pid );

		//On essaye de charger l'element
		if ( !isset( self::$_elements[$pid] ) ) {
			self::_load( $pid );
		}
		//Si on a pas réussi à chargé l'article (pas publiée?)
		if ( !isset( self::$_elements[$pid] ) ) {
			return false;
		}

		return self::$_elements[$pid];
	}

	/**
	 * fonction qui charge toutes les informations dans le variable statique $_elements.
	 *
	 * @param type $pid
	 */
	private static function _load( $pid )
	{
		$pid = intval( $pid );
		$p = get_post( $pid );

		if ( $p->post_type == JM_POSTTYPE_OFFRE ) {
			$element = new stdClass();
			$element->domaine_metier = get_field( FIELD_DOMAINE_METIER, $p->ID );
			$element->mission_principal = get_field( FIELD_MISSIONS_PRINCIPALE, $p->ID );
			$element->responsabilite = get_field( FIELD_RESPONSABILITE, $p->ID );
			$element->qualite_requise = get_field( FIELD_QUALITE_REQUISE, $p->ID );
			//stocker dans le tableau statique
			self::$_elements[$pid] = $element;
		}
	}

	/**
	 * fonction qui retourne une liste filtrée
	 *
	 */
	public static function getBy(
		$limit = -1,
		$sorting = null,
		$data_filters = array(),
		$tax_filters = array(),
		$meta_filters = array()
	) {
		$args = array(
			'post_type'      => JM_POSTTYPE_OFFRE,
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'paged'          => get_query_var( 'paged' ),
			'order'          => isset( $sorting['order'] ) ? $sorting['order'] : 'DESC',
			'orderby'        => isset( $sorting['orderby'] ) ? $sorting['orderby'] : 'date',
			'fields'         => 'ids'
		);

		if ( isset( $data_filters['author'] ) ) {
			$args['author'] = $data_filters['author'];
		}
		if ( isset( $data_filters['search'] ) ) {
			$args['s'] = $data_filters["search"];
		}

		$args['meta_query'] = array();
		if ( isset( $meta_filters['lieu'] ) ) {
			$args['meta_query'][] =
				array(
					'key'     => FIELD_ACTUALITE_LIEU,
					'value'   => $meta_filters['lieu'],
					'compare' => 'IN',
				);
		}

		if ( !empty( $tax_filters ) ) {
			foreach ( $tax_filters as $filter => $filterby ) {
				if ( $filterby > 0 ) {
					$args['tax_query'][] = array(
						'taxonomy'         => $filter,
						'field'            => 'id',
						'terms'            => array( intval( $filterby ) ),
						'operator'         => 'IN',
						'include_children' => true
					);
				}
			}
			$args['tax_query']['relation'] = 'AND';
		}

		$posts = query_posts( $args );
		$elts = array();
		foreach ( $posts as $id ) {
			$elt = self::getById( intval( $id ) );
			$elts[] = $elt;
		}

		return $elts;
	}

	//gestion de colonne BO
	public static function add_column( $columns )
	{
		$columns['vignette'] = __( "Vignette", "telmarh" );
		$columns['lieu'] = __( "Lieu", "telmarh" );

		return $columns;
	}

	//gestion des valeurs des colonnes BO
	public static function manage_column( $column_name, $post_id )
	{
		$actu = self::getById( $post_id );
		switch ( $column_name ) {
			case 'vignette':
				echo '<img width="50" src="' . $actu->image . '"/>';
				break;
			case 'lieu':
				echo $actu->lieu;
				break;
			default:
		}
	}

	public static function getItemsCallback( $offset, $limit, $filters, $sorting ){
		$paged =  intval($offset/$limit +1);
		$args = array(
			'post_type'   => JM_POSTTYPE_OFFRE,
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'paged' => $paged,
			'order'       => 'DESC',
			'orderby'     => 'date',
			'fields'      => 'ids',
		);
		if ( !empty( $filters ) ) {
			foreach ( $filters as $filter => $filterby ) {
				if ( $filterby > 0 ) {
					$args['tax_query'][] = array(
						'taxonomy'         => $filter,
						'field'            => 'id',
						'terms'            => array( intval( $filterby ) ),
						'operator'         => 'IN',
						'include_children' => true
					);
				}
			}
			$args['tax_query']['relation'] = 'AND';
		}
		$posts = query_posts($args);
		global $wp_query;
		return array('posts' => $posts, 'count'=> $wp_query->found_posts);
	}

	public static function renderItemCallback( $pid ){
		$offre = JM_Offre::getById( $pid );

	}


	//set you custom function

}

add_action( 'manage_edit-' . JM_POSTTYPE_OFFRE . '_columns', 'COffre::add_column' );
add_action( 'manage_' . JM_POSTTYPE_OFFRE . '_posts_custom_column', 'COffre::manage_column', 10, 2 );
?>