<?php
$args = array(
	'post_type'      => JM_POSTTYPE_OFFRE,
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'order'          => 'DESC',
	'orderby'        => 'date',
	'fields'         => 'ids'
);
$posts = get_posts( $args );
if ( !empty( $posts ) && count( $posts ) > 0 ){
	foreach ( $posts as $postId ){
		$post_type = get_post_type( $postId );
		if ( $post_type == JM_POSTTYPE_OFFRE ) {
			$offre              = JM_Offre::getById( $postId );
			$societe            = ( isset( $offre->societe_associe ) && !empty( $offre->societe_associe ) ) ? JM_Societe::getById( $offre->societe_associe ) : "";
			$societeName        = ( !empty( $societe ) && isset( $societe->slug ) && !empty( $societe->slug ) ) ? mb_strtoupper( $societe->slug ) : "TELMA";
			$departement        = ( isset( $offre->departement ) && !empty( $offre->departement ) ) ? $offre->departement[0] : "";
			$departementName    = ( !empty( $departement ) && isset( $departement->slug ) && !empty( $departement->slug ) ) ? mb_strtoupper( $departement->slug ) : "RH";
			$dateNow            =  date( "Ym", strtotime( $offre->date ) );

			changeReferenceIsExistToMeta( $societeName . "/" . $departementName . "/" . $dateNow, $postId );
		}
	}
}
