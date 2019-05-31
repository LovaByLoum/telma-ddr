<?php

class AxianDDROffre{

    public $fields;

    public function __construct(){
        $this->fields = array(
            'mission' => array(
                'label' => 'Mission principales',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offre_data[mission]',
            ),

            'responsabilite' => array(
                'label' => 'Responsabilités',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offre_data[responsabilite]',
            ),

            'qualite' => array(
                'label' => 'Qualités requises',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offre_data[qualite]',
            ),

            JM_TAXONOMIE_DOMAINE_ETUDE => array(
                'label' => 'Domaine d\'étude',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_DOMAINE_ETUDE,
                'name' => 'offre_data[' . JM_TAXONOMIE_DOMAINE_ETUDE . ']',
            ),

            JM_TAXONOMIE_LOCALISATION => array(
                'label' => 'Localisation',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_LOCALISATION,
                'name' => 'offre_data[' . JM_TAXONOMIE_LOCALISATION . ']',
            ),

            JM_TAXONOMIE_TYPE_CONTRAT => array(
                'label' => 'Type de contrat',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_TYPE_CONTRAT,
                'name' => 'offre_data[' . JM_TAXONOMIE_TYPE_CONTRAT . ']',
            ),

            JM_TAXONOMIE_DEPARTEMENT => array(
                'label' => 'Domaine métier',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_DEPARTEMENT,
                'name' => 'offre_data[' . JM_TAXONOMIE_DEPARTEMENT . ']',
            ),

            JM_TAXONOMIE_COMPETENCE_REQUISES => array(
                'label' => 'Compétences',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_COMPETENCE_REQUISES,
                'name' => 'offre_data[' . JM_TAXONOMIE_COMPETENCE_REQUISES . ']',
            ),

            JM_TAXONOMIE_ANNEE_EXPERIENCE => array(
                'label' => 'Année d\'experience',
                'type' => 'taxonomy_select',
                'taxonomy' => JM_TAXONOMIE_ANNEE_EXPERIENCE,
                'name' => 'offre_data[' . JM_TAXONOMIE_ANNEE_EXPERIENCE . ']',
            ),
            JM_TAXONOMIE_CRITICITE => array(
                'label' => 'Criticité',
                'type' => 'taxonomy_select',
                'taxonomy' => JM_TAXONOMIE_CRITICITE,
                'name' => 'offre_data[' . JM_TAXONOMIE_CRITICITE . ']',
            ),
            JM_TAXONOMIE_NIVEAU_ETUDE => array(
                'label' => 'Niveau d\'etude',
                'type' => 'taxonomy_select',
                'taxonomy' => JM_TAXONOMIE_NIVEAU_ETUDE,
                'name' => 'offre_data[' . JM_TAXONOMIE_NIVEAU_ETUDE . ']',
            ),

            JM_POSTTYPE_SOCIETE => array(
                'label' => 'Entreprise',
                'type' => 'post_select',
                'post_type' => JM_POSTTYPE_SOCIETE,
                'name' => 'offre_data[' . JM_POSTTYPE_SOCIETE . ']',
            ),
        );
    }

    public static function insert($args=array(), $post_meta, $terms_to_set){
        $id_offre = wp_insert_post(array(
            'post_title' => $args['title'],
            'post_name' => sanitize_title( $args['title']),
            'post_status' => 'pending',
            'post_type' => JM_POSTTYPE_OFFRE,
        ));

        foreach ( $post_meta as $key => $value ) {
            add_post_meta( $id_offre, $key, $value);
        }

        foreach ( $terms_to_set as $tax => $ids ) {
            if ( !empty($ids) ){
                $tt_ids = wp_set_post_terms( $id_offre, $ids, $tax );
            }
        }

        return $id_offre;
    }


}