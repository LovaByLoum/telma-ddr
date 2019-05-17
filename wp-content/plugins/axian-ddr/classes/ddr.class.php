<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 13/05/19
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */
if( ! class_exists( 'AxianDDRTerm' ) ) {
    require_once( AXIAN_DDR_PATH . '/classes/term.class.php' );
}

class AxianDDR{

    public static $types_demande = array(
        TYPE_DEMANDE_PREVU => 'Prévu',
        TYPE_DEMANDE_NON_PREVU => 'Non prévu',
    );

    public static $types_candidature = array(
        CANDIDATURE_INTERNE => 'Interne',
        CANDIDATURE_EXTERNE => 'Externe',
    );

    public static $default = array(
        'demandeur' => '',
        'type' => '',
        'direction' => '',
        'titre' => '',
        'departement' => '',
        'superieur' => '',
        'lieu' => '',
        'batiment' => '',
        'motif' => '',
        'dernier_titulaire' => '',
        'date' => '',
        'comment' => '',
        'attribution' => '',
        'candidature' => ''

    );

    public $fields;

    public static $directions;
    public static $departements;
    public static $lieux;

    public function __construct(){
        $obj_directions = AxianDDRTerm::getby(false, false, 'direction' )['items'];
        $obj_departements = AxianDDRTerm::getby(false, false, 'departement' )['items'];
        $obj_lieux = AxianDDRTerm::getby(false, false, 'lieu' )['items'];
        foreach($obj_directions as $direction){
            self::$directions[$direction->id] = $direction->label;
        }

        foreach($obj_departements as $departement){
            self::$departements[$departement->id] = $departement->label;
        }

        foreach($obj_lieux as $lieu){
            self::$lieux[$lieu->id] = $lieu->label;
        }

        $this->fields = array(
            'demandeur' => array(
                'label' => 'Demandeur',
                'type' => 'text',
                'size' => '50',
                'name' => 'demandeur',
                'required' => true,
            ),

            'type' => array(
                'label' => 'Type de demande',
                'type' => 'select',
                'name' => 'type',
                'size' => '50',
                'required' => true,
                'options' => self::$types_demande,
            ),

            'direction' => array(
                'label' => 'Direction',
                'type' => 'select',
                'name' => 'type',
                'size' => '50',
                'required' => true,
                'class' =>'chosen-select chosen-select-add',
                'options' => self::$directions,
            ),

            'titre' => array(
                'label' => 'Titre du poste',
                'type' => 'text',
                'size' => '50',
                'name' => 'titre',
                'required' => true,
            ),

            'departement' => array(
                'label' => 'Département / Service',
                'type' => 'select',
                'name' => 'type',
                'size' => '50',
                'required' => true,
                'class' =>'chosen-select chosen-select-add',
                'options' => self::$departements,
            ),

            'superieur' => array(
                'label' => 'Superieur immédiat',
                'type' => 'text',
                'size' => '50',
                'name' => 'superieur',
                'required' => true,
            ),

            'lieu' => array(
                'label' => 'Lieu de travail',
                'type' => 'select',
                'name' => 'lieu',
                'size' => '50',
                'required' => true,
                'class' =>'chosen-select chosen-select-add',
                'options' => self::$lieux,
            ),

            'motif' => array(
                'label' => 'Motif de la demande',
                'type' => 'text',
                'size' => '50',
                'name' => 'motif',
                'required' => true,
            ),

            'dernier_titulaire' => array(
                'label' => 'Nom du dernier titulaire du poste',
                'type' => 'text',
                'size' => '50',
                'name' => 'dernier-titulaire',
            ),

            'date' => array(
                'label' => 'Date prévisionnelle d\'embauche',
                'type' => 'date',
                'name' => 'date',
            ),

            'commentaire' => array(
                'label' => 'Commentaire',
                'type' => 'textarea',
                'name' => 'comment',
                'cols' => '40',
                'rows' => '5'
            ),

            'attribution' => array(
                'label' => 'Attribution',
                'type' => 'text',
                'size' => '50',
                'name' => 'attribution',
            ),

            'candidature' => array(
                'label' => 'Type de candidature',
                'type' => 'select',
                'name' => 'type',
                'size' => '50',
                'required' => true,
                'options' => self::$types_candidature,
            ),
        );
    }

    public static function template_list(){

    }

    public static function template_edit(){
        include AXIAN_DDR_PATH . '/templates/ddr/ddr.tpl.php';
    }

    public static function add($args){

    }

    public static function update($args){

    }

    public static function delete($id){

    }
}
global $axian_ddr;
$axian_ddr = new AxianDDR();