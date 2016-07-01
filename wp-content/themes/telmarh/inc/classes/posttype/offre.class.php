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
			'orderby'     => ( isset( $filters['order-criteria'] ) && !empty( $filters['order-criteria'] ) && $filters['order-criteria'] != "date"  ) ? "meta_value_num" : "date",
			'fields'      => 'ids',
		);
		$args['meta_query'] = array();
		if ( isset( $filters['order-criteria'] ) && !empty( $filters['order-criteria'] ) && $filters['order-criteria'] != "date" ){
			$args['meta_key'] = $filters['order-criteria'];
		}
		if ( isset( $filters['entreprise'] ) ) {
			$args['meta_query'][] =
		        array(
		          'key'     => JM_META_SOCIETE_OFFRE_RELATION,
		          'value'   => $filters['entreprise'],
		          'compare' => 'IN',
		         );
		}
		if ( !empty( $filters ) ) {
			foreach ( $filters as $filter => $filterby ) {
				if ( $filterby > 0 && !in_array( $filter,array("entreprise", "recherche","order-criteria" ) ) ) {
					$args['tax_query'][] = array(
						'taxonomy'         => $filter,
						'field'            => 'id',
						'terms'            => $filterby,
						'operator'         => 'IN',
						'include_children' => true
					);
				}
			}
			$args['tax_query']['relation'] = 'AND';
		}
		if ( !empty( $filters["recherche"] ) ) {
	      $args['s'] = $filters["recherche"];
	    }
		$posts = query_posts($args);
		global $wp_query;
		return array('posts' => $posts, 'count'=> $wp_query->found_posts);
	}

	public static function renderItemCallback( $pid ){
		$html = "";
		$offre = JM_Offre::getById( $pid );
        $elementOffre = COffre::getById( $pid );
		$isUrgent = ( isset( $offre->criticite ) && !empty( $offre->criticite ) && $offre->criticite[0]->slug != "normale" ) ? true : false;
		$reference = get_post_meta( $pid, REFERENCE_OFFRE, true );
        $html .= '
			<article class="list-offres">
	            <div class="entry-content testimonial">
	            	<header class="entry-header">
	                    <h2 class="entry-title">' . $offre->titre . '</h2>
	                    <div class="entry-meta">
	                            	<span class="meta-block"><i class="fa fa-eye"></i>Publié le ' .self::dateLongueText( $offre->date ) . '</span>
	                                <span class="meta-block"><i class="fa fa-suitcase"></i>' . $elementOffre->domaine_metier  .'</span>
                        </div>
	                </header><!-- .entry-header -->
	                ' . apply_filters( "the_content", $offre->extrait );
		if ( $isUrgent ){
			$html .= '        <div class="newFormation">' . $offre->criticite[0]->name . '</div>';
		}
		$html .= '
	            <footer class="entry-footer">
                    <span class="comments-link">
                    <a href="' . get_permalink( $offre->id ) . '" title="En savoir plus" class="submit_link button--wapasha button--round-l">En savoir plus</a>
                    </span>
                </footer><!-- .entry-footer -->
	            </div><!-- .entry-content -->
            </article>
        ';

        return $html;

	}

	public static function getOffreUrgent(){
		$data = array();
		$offres = JM_Offre::getBy( array( 'taxonomy' => JM_TAXONOMIE_CRITICITE, 'id' => ID_TAXONOMIE_CRITICITE_URGENT, null, 3 ) );
		if ( !empty( $offres ) && count( $offres ) > 0 ){
			foreach ( $offres as $offre ){
				$elt = new stdClass();
				$elt->titre         = $offre->titre;
				$elt->id            = $offre->id;
				$elt->desc          = $offre->extrait;
				$typeContrat        = "";
				$nameEntreprise     = "";
				if (  isset( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) && !empty( $offre->{JM_TAXONOMIE_TYPE_CONTRAT} ) ){
					$typeContrat = $offre->{JM_TAXONOMIE_TYPE_CONTRAT}[0]->name;
				}

				if ( isset( $offre->societe_associe ) && !empty( $offre->societe_associe ) ){
					$entreprise = JM_Societe::getById( $offre->societe_associe );
					$nameEntreprise     = $entreprise->titre;
				}
				$elt->type_contrat      = $typeContrat;
				$elt->nameEntreprise    = $nameEntreprise;
				$data[] = $elt;
			}
		}

		return $data;
	}
	/**
	     * pour le format date mois années
	     * @param $date
	     * @return string
	     */
	    public static function dateLongueText($date){
	        setlocale (LC_TIME, 'fr_FR','fra');
	        //Définit le décalage horaire par défaut de toutes les fonctions date/heure
	        date_default_timezone_set("Europe/Paris");
	        //Definit l'encodage interne
	        mb_internal_encoding("UTF-8");
	        if($date == date('Ymd')){
	            return 'Aujourd\'hui';
	        }else{
	            $strDate = mb_convert_encoding('%d %B %Y', 'ISO-8859-9', 'UTF-8');
	            return ucwords(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
	        }
	    }


	//set you custom function

}

add_action( 'manage_edit-' . JM_POSTTYPE_OFFRE . '_columns', 'COffre::add_column' );
add_action( 'manage_' . JM_POSTTYPE_OFFRE . '_posts_custom_column', 'COffre::manage_column', 10, 2 );
?>