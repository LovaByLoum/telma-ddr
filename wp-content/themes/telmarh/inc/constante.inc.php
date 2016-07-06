<?php
/*
 * Definir ici les constantes applicatives
 *
 * Essayez de bien organiser la declaration des constantes :
 * en regroupant les mêmes types de constantes
 * en prefixant les mêmes types de constantes
 * et en mettant des commentaires
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

//post types
define( 'POST_TYPE_ARTICLE', 'article' );
define( 'POST_TYPE_PAGE', 'page' );

//taxonomies
define( 'TAXONOMY_TYPE_CONTRAT', 'type_contrat' );
define( 'TAXONOMY_ENTREPRISE', 'tax_entreprise' );
define( 'TAXONOMY_REGION', 'tax_region' );
define( 'TAXONOMY_REFERENCE_METIER', 'ref_metier' );
define( 'TAXONOMY_ANNEE_EXPERIENCE', 'annee_experience' );
define( 'TAXONOMY_CRITICITE', 'criticite' );

//user role
define ('USER_PROFILE_MEMBRE', 'subscriber');
define ('USER_PROFILE_WEBMASTER', 'webmaster');
define ('USER_PROFILE_ADMIN', 'administrator');

//offre
define ( 'INCREMENTATION_OFFRE', 'incrementation_offre' );
define ( 'REFERENCE_OFFRE', 'reference_offre' );

//field ACF offres
define ( "FIELD_DOMAINE_METIER", "domaine_de_metier_offre" );
define ( "FIELD_MISSIONS_PRINCIPALE", "missions_principales_offre" );
define ( "FIELD_RESPONSABILITE", "responsabilites_offre" );
define ( "FIELD_QUALITE_REQUISE", "qualites_requises_offre" );

//field ACF homepage
define ( "TITRE_BLOC_SERVICE", "titre_bloc_service" );
define ( "LINK_BOUTON_BLOC_SERVICE", "lien_du_bouton_bloc_service" );
define ( "TEXT_BOUTON_BLOC_SERVICE", "titre_bouton_bloc_service" );
define ( "ELEMENTS_BLOC_SERVICE", "elements_bloc_service" );
define ( "FONT_ELEMENTS_BLOC_SERVICE", "font_element_service" );
define ( "TITRE_ELEMENTS_BLOC_SERVICE", "titre_element_service" );
define ( "DESC_ELEMENTS_BLOC_SERVICE", "description_element_service" );
define ( "LINK_ELEMENT_BLOC_SERVICE", "lien_element_service" );

//field ACF slide
define ( "TITRE_BLOC_PARTENAIRE", "titre_partenaire" );
define ( "LISTES_PARTENAIRE", "bloc_partenaires" );
define ( "IMAGE_PARTENAIRE", "image_partenaire" );
define ( "LINK_PARTENAIRE", "lien_partenaire" );
define ( "NAME_PARTENAIRE", "nom_partenaire" );

//field ACF Testimoniale
define ( "TITRE_TESTIMONIAL", "titre_testimonial" );
define ( "ELEMENT_TESTIMONIAL", "testimoniales" );
define ( "IMAGE_TESTIMONIAL", "image_testimonial" );
define ( "DESCRIPTION_TESTIMONIAL", "description_testimonial" );
define ( "AUTEUR_TESTIMONIAL", "auteur_testimonial" );
define ( "PROFESSION_TESTIMONIAL", "profession_testimonial" );

// id taxonomy
define ( "ID_TAXONOMIE_CRITICITE_URGENT", 38 );

//slug menu
define ( "SLUG_MENU_FOOTER", 'footer' );


