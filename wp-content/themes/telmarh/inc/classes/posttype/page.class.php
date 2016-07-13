<?php

/**
 * classe de service pour ...
 *
 * @package    WordPress
 * @subpackage telmarh
 * @since      telmarh 1.0
 * @author     : Netapsys
 */
class CPage
{

	private static $_elements;

	public function __construct()
	{

	}

	/**
	 * fonction qui prend les informations son Id.
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

		if ( $p->post_type == "page" ) {
			$element = new stdClass();

			//traitement des données


			//stocker dans le tableau statique
			self::$_elements[$pid] = $element;
		}
	}

	/**
	 * fonction qui retourne une liste filtrée
	 *
	 */
	public static function getBy()
	{
		$args = array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'numberposts' => -1,
			'offset'      => 0,
			'order'       => 'DESC',
			'orderby'     => 'date',
			'fields'      => 'ids'
		);


		$elements = get_posts( $args );
		$elts = array();
		foreach ( $elements as $id ) {
			$elt = self::getById( intval( $id ) );
			$elts[] = $elt;
		}

		return $elts;

	}

	public static function getAllElementServiceHp( $pid ){
		$data = array();
		$elt = array();
		if ( intval( $pid ) > 0 ){
			$titre = get_field( TITRE_BLOC_SERVICE, $pid );
			$linkBouton = get_field( LINK_BOUTON_BLOC_SERVICE, $pid );
			$titreBouton = get_field( TEXT_BOUTON_BLOC_SERVICE, $pid );
			$data = array(
				'titre'         => $titre,
				'lien'          => $linkBouton,
				'text_bouton'   => $titreBouton
			);
			$elements = get_field( ELEMENTS_BLOC_SERVICE, $pid );
			if ( !empty( $elements ) && count( $elements ) > 0 ){
				foreach( $elements as $element ){
					$elts = new stdClass();
					$elts->fontClass    = $element[FONT_ELEMENTS_BLOC_SERVICE];
					$elts->titre        = $element[TITRE_ELEMENTS_BLOC_SERVICE];
					$elts->description  = $element[DESC_ELEMENTS_BLOC_SERVICE];
					$elts->link         = $element[LINK_ELEMENT_BLOC_SERVICE];
					$elt[] = $elts;
				}
			}
			$data['element'] = $elt;
		}

		return $data;
	}

	public static function getAllpartnerHp( $pid ){
		$data = array();
		if ( intval( $pid ) > 0 ){
			$partenaires = get_field( LISTES_PARTENAIRE, $pid );
			$titre      = get_field( TITRE_BLOC_PARTENAIRE, $pid);
			$data['titre'] = $titre;
			if ( !empty( $partenaires ) && count( $partenaires ) > 0 ){
				foreach ( $partenaires as $partenaire ){
					$elt                = new stdClass();
					$imageTronque       = "";
					$imageUrl           = "";
					$elt->link          = $partenaire[LINK_PARTENAIRE];
					$elt->name          = $partenaire[NAME_PARTENAIRE];
					$image              = wp_get_attachment_image_src( $partenaire[IMAGE_PARTENAIRE], "full" );
					if ( !empty( $image ) ){
						list( $url, $w, $h ) = $image;
						$imageTronque   =  self::getPropDim( $w, $h, 150, 150 );
						$imageUrl       =  $url;
					}
					$elt->imageUrl      = $imageUrl;
					$elt->imageTronque  = $imageTronque;
					$data['element'][] = $elt;
				}
			}
		}

		return $data;
	}

	public static function getAllElementTestimonialHp( $pid ){
		$data = array();
		if ( intval( $pid ) > 0 ){
			$testimoniales = get_field( ELEMENT_TESTIMONIAL, $pid );
			$data['titre'] = get_field( TITRE_TESTIMONIAL, $pid );
			if ( !empty( $testimoniales ) && count( $testimoniales ) > 0 ){
				foreach ( $testimoniales as $testimoniale ){
					$elt = new stdClass();
					$imageTronque       = "";
					$imageUrl           = "";
					$elt->desc          = $testimoniale[DESCRIPTION_TESTIMONIAL];
					$elt->auteur        = $testimoniale[AUTEUR_TESTIMONIAL];
					$elt->profession    = $testimoniale[PROFESSION_TESTIMONIAL];
					$image              = wp_get_attachment_image_src( $testimoniale[IMAGE_TESTIMONIAL] , "full" );
					if ( !empty( $image ) ){
						list( $url, $w, $h ) = $image;
						$imageTronque   =  self::getPropDim( $w, $h, 150, 150 );
						$imageUrl       =  $url;
					}
					$elt->imageUrl      = $imageUrl;
					$elt->imageTronque  = $imageTronque;
					$data['element'][] = $elt;
				}
			}
		}

		return $data;
	}

	public static function getPropDim($realWidth, $realHeight, $styledWidth, $styledHeight) {
	    if($realWidth<$styledWidth && $realHeight<$styledHeight){
	        $ratio = $realWidth/$realHeight;
	        if($ratio>1){
	            $w = $styledWidth;
	            $h = $styledWidth*$realHeight/$realWidth;
	            $p = ($styledHeight-$h)/2;
	            $sp = (($p>0)?"padding:{$p}px 0;":"");
	        }else{
	            $w = $styledHeight*$realWidth/$realHeight;
	            $h = $styledHeight;
	            $p = ($styledWidth-$w)/2;
	            $sp = (($p>0)?"padding:0 {$p}px;":"");
	        }
	    }elseif($realWidth<$styledWidth && $realHeight>=$styledHeight){
	        $w = $styledHeight*$realWidth/$realHeight;
	        $h = $styledHeight;
	        $p = ($styledWidth-$w)/2;
	        $sp = (($p>0)?"padding:0 {$p}px;":"");
	    }elseif($realHeight<$styledHeight){
	        $w = $styledWidth;
	        $h = $styledWidth*$realHeight/$realWidth;
	        $p = ($styledHeight-$h)/2;
	        $sp = (($p>0)?"padding:{$p}px 0;":"");
	    }else{
	        $ratio = $realWidth/$realHeight;
	        if($ratio>1){
	            $w = $styledWidth;
	            $h = $styledWidth*$realHeight/$realWidth;
	            $p = abs(($styledHeight-$h)/2);
	            $sp = (($p>0)?"padding:{$p}px 0;":"");
	            if ( $styledHeight < $h ){
	                $h = $h - ($p * 2 );
	                $sp = "";
	            }
	        }else{
	            $w = $styledHeight*$realWidth/$realHeight;
	            $h = $styledHeight;
	            $p = abs(($styledWidth-$w)/2);
	            $sp = (($p>0)?"padding:0 {$p}px;":"");
	        }
	    }
	    return array($w, $h, $sp);
	}

	public static function action(){
		if (
			isset( $_REQUEST['action'] )
			&& isset( $_REQUEST['id'] )
			&& isset( $_REQUEST['hash'] )
			&& isset( $_REQUEST['appouve'] )
			&& 'confirmation-user' == $_REQUEST['action']
		) {
			if ( hash_equals( urldecode( $_REQUEST['hash'] ), crypt( '123456','activate_user_' . $_REQUEST['id']) )
                && $_REQUEST['appouve'] == "1" ) {
				update_user_meta( $_REQUEST['id'],"pw_user_status" , "approved" );
	            $user = new WP_User($_REQUEST['id']);
	            $userData = $user->data;
				CUser::programmatic_login( $userData->user_login );
			} else {
				wp_die( 'Vous n\'avez pas le droit d\'accèder à ce lien. Veuillez contactez l\'administrateur.' );
			}

		}
	}
}

add_action( "init", "CPage::action" );

?>