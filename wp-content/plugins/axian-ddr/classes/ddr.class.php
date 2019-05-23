<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 13/05/19
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */
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
        'etat' => STATUS_EN_COURS,
        'etape' =>"validation"

    );

    public $fields;

    public static $directions;
    public static $departements;
    public static $lieux;

    public function __construct(){
        self::$directions['']='';
        self::$departements['']='';
        self::$lieux['']='';
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
                'name' => 'author_id',
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
                'name' => 'direction',
                'size' => '50',
                'required' => true,
                'search' => true,
                'add' => true,
                'class' => 'direction',
                'options' => self::$directions,
                'placeholder' => ' '
            ),

            'titre' => array(
                'label' => 'Titre du poste',
                'type' => 'text',
                'size' => '50',
                'name' => 'title',
                'required' => true,
            ),

            'departement' => array(
                'label' => 'Département / Service',
                'type' => 'select',
                'name' => 'departement',
                'size' => '50',
                'required' => true,
                'search' => true,
                'add' => true,
                'class' =>'departement',
                'options' => self::$departements,
                'placeholder' => ' '
            ),

            'superieur' => array(
                'label' => 'Superieur immédiat',
                'type' => 'text',
                'size' => '50',
                'name' => 'superieur_id',
                'required' => true,
            ),

            'lieu' => array(
                'label' => 'Lieu de travail',
                'type' => 'select',
                'name' => 'lieu_travail',
                'size' => '50',
                'required' => true,
                'search' => true,
                'add' => true,
                'class' =>'lieu_travail',
                'options' => self::$lieux,
                'placeholder' => ' '
            ),

            'batiment' => array(
                'label' => 'Bâtiment',
                'type' => 'select',
                'name' => 'batiment',
                'size' => '50',
                'required' => true,
                'search' => true,
                'add' => true,
                'class' =>'',
                'options' => self::$lieux,
                'placeholder' => ' '
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
                'name' => 'dernier_titulaire',
            ),

            'date' => array(
                'label' => 'Date prévisionnelle d\'embauche',
                'type' => 'date',
                'name' => 'date_previsionnel',
            ),

            'comment' => array(
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
                'name' => 'assignee_id',
            ),

            'candidature' => array(
                'label' => 'Type de candidature',
                'type' => 'select',
                'name' => 'type_candidature',
                'size' => '50',
                'required' => true,
                'options' => self::$types_candidature,
            ),
        );
    }

    public static function template_list(){
        include AXIAN_DDR_PATH . '/templates/ddr/ddr-list.tpl.php';
    }

    public static function template_edit(){
        include AXIAN_DDR_PATH . '/templates/ddr/ddr.tpl.php';
    }

    public static function add($args){
        global $wpdb;
        $status = ( isset($args['submit-ddr']) && !empty($args['submit-ddr']) ) ? STATUS_EN_COURS : STATUS_DRAFT;
        $now = date("Y-m-d");
        $args = array_merge(self::$default, $args);
        $s =str_replace('/','-',$args['date_previsionnel']);
        $date = date('Y/m/d',strtotime($s));

        $result = $wpdb->insert(TABLE_AXIAN_DDR,array(
            'author_id' => intval($args['author_id']),
            'type' => $args['type'],
            'direction' => $args['direction'],
            'title' => $args['title'],
            'departement' => $args['departement'],
            'superieur_id' => intval($args['superieur_id']),
            'lieu_travail' => $args['lieu_travail'],
            'batiment' => $args['batiment'],
            'motif' => $args['motif'],
            'dernier_titulaire' => $args['dernier_titulaire'],
            'date_previsionnel' => $date,
            'comment' => $args['comment'],
            'assignee_id' => intval($args['assignee_id']),
            'type_candidature' => $args['type_candidature'],
            'created' => $now,
            'etat' => $status,
            'etape' => $args['etape'],

        ));
        if ( $result ){
            $ddr_id =$wpdb->insert_id;
            $historique = new AxianDDRHistorique();
            $historique_result = $historique->add($ddr_id,intval($args['author_id']),'creation','' ,$status, $args['etape']);
            if ( !$historique_result ) return $historique_result;

        }
        return $result;

    }

    public static function update($args){

    }

    public static function delete($id){

    }

    public static function getbyId($id){

    }

    public function submit_ddr(){

        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        if ( isset($_POST['submit-ddr']) || isset($_POST['save-ddr']) ){
            $msg = axian_ddr_valiate_fields($this);

            if ( !empty($msg) ){
                return array(
                    'code' => 'error',
                    'msg' => $msg,
                );
            } else {
                //process ad term
                $post_data = $_POST;
                if (strpos($post_data['direction'], 'new|') !== false) {
                    $label = str_replace( 'new|','',$post_data['direction']);
                    $new = AxianDDRTerm::add('direction', $label);
                    if ( $new != false ) $post_data['direction'] = $new;
                }

                if (strpos($post_data['departement'], 'new|') !== false) {
                    $label = str_replace( 'new|','',$post_data['departement']);
                    $new = AxianDDRTerm::add('departement', $label);
                    if ( $new != false ) $post_data['departement'] = $new;
                }

                if (strpos($post_data['lieu_travail'], 'new|') !== false) {
                    $label = str_replace( 'new|','',$post_data['lieu_travail']);
                    $new = AxianDDRTerm::add('lieu', $label);
                    if ( $new != false ) $post_data['lieu_travail'] = $new;
                }

                $return_add = self::add( $post_data );

                if ( !empty($return_add) ){
                    //unset post
                    unset($_POST['title']);
                    unset($_POST['author_id']);
                    unset($_POST['superieur_id']);
                    unset($_POST['motif']);
                    unset($_POST['departement']);
                    unset($_POST['lieu_travail']);
                    unset($_POST['dernier_titulaire']);
                    unset($_POST['assignee_id']);
                    unset($_POST['date_previsionnel']);
                    unset($_POST['comment']);
                    return array(
                        'code' => 'updated',
                        'msg' => 'Enregistrement effectué avec succés.',
                    );
                }  else {
                    return array(
                        'code' => 'error',
                        'msg' => 'Erreur inconnu',
                    );
                }

            }
        } elseif ( isset($_POST['update-term']) ){
            $msg = axian_ddr_valiate_fields($this);

            if ( !empty($msg) ){
                return array(
                    'code' => 'error',
                    'msg' => $msg,
                );
            } else {
                //process update term
                $post_data = $_POST;
                $return_update = self::update(
                    $post_data['id'],
                    $post_data['type'],
                    $post_data['label']
                );

                if ( $return_update ){
                    //unset post
                    unset($_POST['id']);
                    unset($_POST['type']);
                    unset($_POST['label']);
                    unset($_GET['id']);

                    return array(
                        'code' => 'updated',
                        'msg' => 'Enregistrement effectué avec succés.',
                    );
                }  else {
                    return array(
                        'code' => 'error',
                        'msg' => 'Erreur inconnu',
                    );
                }

            }
        }elseif ( ( $_GET['action'] == "delete" ) && !empty( $_GET['_wpnonce'] ) && !empty( $_GET['id'] )){
            $nonce = wp_create_nonce( 'addr_delete_term'.absint( $_GET['id'] ) );


            if ( $nonce != $_GET['_wpnonce'] ){
                return array(
                    'code' => 'error',
                    'msg' => 'Action denied',
                );
            } else {
                //process delete term
                $return_update = self::delete(absint( $_GET['id'] ));

                if ( $return_update ){
                    //unset post
                    unset($_POST['id']);
                    unset($_POST['type']);
                    unset($_POST['label']);
                    unset($_GET['id']);

                    return array(
                        'code' => 'updated',
                        'msg' => 'Suppresion effectué avec succés.',
                    );
                }

            }
        }else {
            return false;
        }
    }

    public static function getby( $args ){
        global $wpdb;
        $default = array(
            'offset' => 0,
            'limit' => null,
            'type' => null,
            'debut' => null,
            'fin' => null,
            'candidature' => null,
            'etat' => null,
            'etape' => null,
        );

        $args = array_merge($default, $args);

        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR . " WHERE id >" . 0;

        //type
        $type = ( isset($_GET['type']) && !empty($_GET['type']) ) ? $_GET['type'] : $args['type'];
        if ( !is_null($type) ){
            $query_select .= " AND type='{$type}'";
        }

        //date_debut
        $debut = ( isset($_GET['debut']) && !empty($_GET['debut']) ) ? $_GET['debut'] : $args['debut'];
        if ( !is_null($type) ){
            $query_select .= " AND type='{$debut}'";
        }

        //date_fin
        $fin = ( isset($_GET['fin']) && !empty($_GET['fin']) ) ? $_GET['fin'] : $args['fin'];
        if ( !is_null($type) ){
            $query_select .= " AND type='{$fin}'";
        }

        //type_candidature
        $candidature = ( isset($_GET['candidature']) && !empty($_GET['candidature']) ) ? $_GET['candidature'] : $args['candidature'];
        if ( !is_null($type) ){
            $query_select .= " AND type_candidature='{$candidature}'";
        }

        //ordre
        if(isset($_GET) && isset($_GET['orderby'])){
            $query_select .= " ORDER BY {$_GET['orderby']} {$_GET['order']} ";
        }

        //limit
        if ( $args['limit'] != null ){
            $query_select .= " LIMIT {$args['offset']},{$args['limit']} ";
        }

        $result = $wpdb->get_results($query_select);

        return array(
            'count' => sizeof($result),
            'items' => $result
        );

    }

}

global $axian_ddr;
$axian_ddr = new AxianDDR();