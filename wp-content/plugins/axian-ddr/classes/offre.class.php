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
        $type_contrats = get_terms( JM_TAXONOMIE_TYPE_CONTRAT, array( 'hide_empty' => false, 'parent' =>0 ) );
        $localisations = get_terms( JM_TAXONOMIE_LOCALISATION, array( 'hide_empty' => false, 'parent' =>0 ) );
        $experiences = get_terms( JM_TAXONOMIE_ANNEE_EXPERIENCE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $criticites = get_terms( JM_TAXONOMIE_CRITICITE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $niveaux = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $domaine_etudes = get_terms( JM_TAXONOMIE_DOMAINE_ETUDE, array( 'hide_empty' => false, 'parent' =>0 ) );
        $domaine_metiers = get_terms( JM_TAXONOMIE_DEPARTEMENT, array( 'hide_empty' => false, 'parent' =>0 ) );
        $competences = get_terms( JM_TAXONOMIE_COMPETENCE_REQUISES, array( 'hide_empty' => false, 'parent' =>0 ) );

        foreach($domaine_etudes as $domaine){
            $child = get_term_children( $domaine->term_id, JM_TAXONOMIE_DOMAINE_ETUDE );
            if(!empty($child)) $domaine->child = self::getChilds($child , JM_TAXONOMIE_DOMAINE_ETUDE);
        }

        foreach($domaine_metiers as $domaine){
            $child = get_term_children( $domaine->term_id, JM_TAXONOMIE_DEPARTEMENT );
            if(!empty($child)) $domaine->child = self::getChilds($child , JM_TAXONOMIE_DEPARTEMENT);
        }

        foreach($competences as $competence){
            $child = get_term_children( $competence->term_id, JM_TAXONOMIE_COMPETENCE_REQUISES );
            if(!empty($child)) $competence->child = self::getChilds($child , JM_TAXONOMIE_COMPETENCE_REQUISES);
        }

        $this->type_contrats = $type_contrats;
        $this->localisations = $localisations;
        $this->experiences = $experiences;
        $this->niveaux = $niveaux;
        $this->criticites = $criticites;
        $this->domaine_etudes = $domaine_etudes;
        $this->domaine_metiers = $domaine_metiers;
        $this->competences = $competences;


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
        );
    }

    public static function getChilds($args, $tax){
        $terms = [];
        foreach($args as $id){
            $terms[] = get_term_by( 'id', $id, $tax );
        }

        return $terms;
    }


}