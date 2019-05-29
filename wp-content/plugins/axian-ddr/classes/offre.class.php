<?php

class AxianDDROffre{

    public $fields;

    public $type_contrats;
    public $localisations;
    public $domaine_etudes;
    public $domaine_metiers;
    public $experiences;
    public $competences;
    public $criticites;
    public $niveaux;

    public function __construct(){
        $experiences = get_terms( JM_TAXONOMIE_ANNEE_EXPERIENCE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $criticites = get_terms( JM_TAXONOMIE_CRITICITE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $niveaux = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $competences = get_terms( JM_TAXONOMIE_COMPETENCE_REQUISES, array( 'hide_empty' => false, 'parent' =>0 ) );

        $this->fields = array(
            'mission' => array(
                'label' => 'Mission principales',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offres[mission]',
            ),

            'responsabilite' => array(
                'label' => 'Responsabilités',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offres[responsabilite]',
            ),

            'qualite' => array(
                'label' => 'Qualités requises',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'offres[qualite]',
            ),

            JM_TAXONOMIE_DOMAINE_ETUDE => array(
                'label' => 'Domaine d\'étude',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_DOMAINE_ETUDE,
                'name' => 'offres[' . JM_TAXONOMIE_DOMAINE_ETUDE . ']',
            ),

            JM_TAXONOMIE_LOCALISATION => array(
                'label' => 'Localisation',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_LOCALISATION,
                'name' => 'offres[' . JM_TAXONOMIE_LOCALISATION . ']',
            ),

            JM_TAXONOMIE_TYPE_CONTRAT => array(
                'label' => 'Type de contrat',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_TYPE_CONTRAT,
                'name' => 'offres[' . JM_TAXONOMIE_TYPE_CONTRAT . ']',
            ),

            JM_TAXONOMIE_DEPARTEMENT => array(
                'label' => 'Domaine métier',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_DEPARTEMENT,
                'name' => 'offres[' . JM_TAXONOMIE_DEPARTEMENT . ']',
            ),

            JM_TAXONOMIE_COMPETENCE_REQUISES => array(
                'label' => 'Compétences',
                'type' => 'taxonomy_checkboxes',
                'taxonomy' => JM_TAXONOMIE_COMPETENCE_REQUISES,
                'name' => 'offres[' . JM_TAXONOMIE_COMPETENCE_REQUISES . ']',
            ),
        );
    }


}