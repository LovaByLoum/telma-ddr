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

    public static $actions = array(
        DDR_ACTION_CREATE => 'Créer',
        DDR_ACTION_SUBMIT => 'Soumettre',
        DDR_ACTION_VALIDATE => 'Valider',
        DDR_ACTION_REFUSE => 'Refuser',
        DDR_ACTION_CLOSE => 'Clôturer',
    );

    public static $etats = array(
        DDR_STATUS_DRAFT => 'Brouillon',
        DDR_STATUS_VALIDE => 'Validé',
        DDR_STATUS_EN_COURS => 'En cours',
        DDR_STATUS_REFUSE => 'Refusé',
        DDR_STATUS_ANNULE => 'Annulé',
        DDR_STATUS_CLOTURE => 'Clôturé',
    );

    public static $etapes = array(
        DDR_STEP_CREATE => 'Création',
        DDR_STEP_VALIDATION_1 => 'Validation N1',
        DDR_STEP_VALIDATION_2 => 'Validation N2',
        DDR_STEP_VALIDATION_3 => 'Validation N3',
        DDR_STEP_VALIDATION_4 => 'Validation N4',
        DDR_STEP_PUBLISH => 'Publication',
    );

    public $fields;

    public $directions;
    public $departements;
    public $lieux;

    public function __construct(){
        $this->directions = AxianDDRTerm::getby(array('type' => 'direction'), 'options' );
        $this->departements = AxianDDRTerm::getby(array('type' => 'departement') , 'options' );
        $this->lieux = AxianDDRTerm::getby(array('type' => 'lieu') , 'options' );

        $this->fields = array(
            'demandeur' => array(
                'label' => 'Demandeur',
                'type' => 'hidden',
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
                'options' => $this->directions,
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
                'options' => $this->departements,
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
                'options' => $this->lieux,
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
                'options' => $this->lieux,
                'placeholder' => ' '
            ),

            'motif' => array(
                'label' => 'Motif de la demande',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
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

            'attribution' => array(
                'label' => 'Attribution',
                'type' => 'autocompletion',
                'source' => 'user',
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
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        if ( 'view' == $_GET['action'] ){
            include AXIAN_DDR_PATH . '/templates/ddr/ddr-view.tpl.php';
        }else include AXIAN_DDR_PATH . '/templates/ddr/ddr-edit.tpl.php';
    }

    public static function insert($args){
        global $wpdb;
        $now = date("Y-m-d H:i:s");

        if ( preg_match('#([0-9]{4})/([0-9]{2})/([0-9]{2})#', $args['date_previsionnel'], $matches) ){
            $args['date_previsionnel'] = $matches[3] . '-' . $matches[2] . '' . $matches[1];
        }

        $result = $wpdb->insert(TABLE_AXIAN_DDR, array(
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
            'date_previsionnel' => $args['date_previsionnel'],
            'assignee_id' => intval($args['assignee_id']),
            'type_candidature' => $args['type_candidature'],
            'created' => $now,
            'etat' => $args['etat'],
            'etape' => $args['etape'],

        ));

        return $result;

    }

    public static function update($args){
        global $wpdb, $current_user;
        $now = date("Y-m-d H:i:s");
        $args = array_merge(self::$default, $args);
        $s =str_replace('/','-',$args['date_previsionnel']);
        $date = date('Y/m/d',strtotime($s));

        $result = $wpdb->update(
            TABLE_AXIAN_DDR,
            array(
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
                'modified' => $now,
                'etat' => $args['etat'],

            ),
            array( 'id' => $args['id'] )
        );

        if( $result && !empty($_POST['publish-ddr']) ){
            $historique = new AxianDDRHistorique();
            $historique_result = $historique->add($args['id'],'publier',DDR_STATUS_DRAFT ,$args['etat'], $args['etape']);
            if ( !$historique_result ) return $historique_result;
        }

        return $result;
    }

    public static function delete($id){

    }

    public static function getbyId($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM '. TABLE_AXIAN_DDR . ' WHERE id = '.$id ,ARRAY_A);

        return $result;
    }

    public function process_ddr( $ddr_id = null ){

        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        $is_save_draft = isset($_POST['save-draft']);
        $is_submit_ddr = isset($_POST['submit-ddr']);
        $is_update_ddr = isset($_POST['update-ddr']);
        $is_delete_ddr = isset($_POST['delete-ddr']);
        if ( $is_save_draft || $is_submit_ddr || $is_update_ddr ){
            $msg = axian_ddr_validate_fields($this);

            //data not valid
            if ( !empty($msg) ){
                return self::manage_message(DDR_MSG_VALIDATE_ERROR, $msg);
            //data valid
            } else {
                //process add term
                $post_data = $_POST;
                if ( strpos($post_data['direction'], 'new|') !== false ) {
                    $label = str_replace( 'new|','',$post_data['direction']);
                    $new = AxianDDRTerm::add('direction', $label);
                    if ( $new != false ) $post_data['direction'] = $new;
                }

                if ( strpos($post_data['departement'], 'new|') !== false ) {
                    $label = str_replace( 'new|','',$post_data['departement']);
                    $new = AxianDDRTerm::add('departement', $label);
                    if ( $new != false ) $post_data['departement'] = $new;
                }

                if ( strpos($post_data['lieu_travail'], 'new|') !== false ) {
                    $label = str_replace( 'new|','',$post_data['lieu_travail']);
                    $new = AxianDDRTerm::add('lieu', $label);
                    if ( $new != false ) $post_data['lieu_travail'] = $new;
                }

                //creation
                if ( is_null($ddr_id) ){
                    //maj etat / etape
                    if ( $is_save_draft ){
                        $post_data['etat'] = DDR_STATUS_DRAFT;
                        $post_data['etape'] = DDR_STEP_CREATE;
                    } elseif ( $is_submit_ddr ){
                        $post_data['etat'] = DDR_STATUS_EN_COURS;
                        $post_data['etape'] = DDR_STEP_VALIDATION_1;
                    }

                    //insert
                    $new_ddr_id = self::insert( $post_data );

                    //historique
                    $story_id = AxianDDRHistorique::add($new_ddr_id, array(
                        'action' => DDR_ACTION_CREATE,
                        'etat_avant' => DDR_STATUS_DRAFT,
                        'etat_apres' => $post_data['etat'],
                        'etape' => $post_data['etape'],
                        'comment' => $post_data['comment'],
                    ));

                    if ( $is_save_draft ){
                        $redirect_to = 'admin.php?page=axian-ddr&action=edit&id=' . $new_ddr_id . '&msg=' . DDR_MSG_SAVED_SUCCESSFULLY;
                    } elseif ( $is_submit_ddr ){
                        $redirect_to = 'admin.php?page=axian-ddr&action=view&id=' . $new_ddr_id . '&msg=' . DDR_MSG_SUBMITTED_SUCCESSFULLY;
                    }

                    wp_safe_redirect($redirect_to);die;
                //mise à jour
                } else {

                    $the_ddr = AxianDDR::getbyId($ddr_id);

                    //maj etat / etape
                    if ( $is_save_draft ){
                        $post_data['etat'] = DDR_STATUS_DRAFT;
                        $post_data['etape'] = DDR_STEP_CREATE;
                    } elseif ( $is_update_ddr ){
                        $post_data['etat'] = DDR_STATUS_EN_COURS;
                        $post_data['etape'] = DDR_STEP_CREATE;
                    }

                    self::update( $post_data );

                    //historique
                    $story_id = AxianDDRHistorique::add($ddr_id, array(
                        'action' => DDR_ACTION_UPDATE,
                        'etat_avant' => $the_ddr->etat,
                        'etat_apres' => $post_data['etat'],
                        'etape' => $post_data['etape'],
                        'comment' => $post_data['comment'],
                    ));

                    $redirect_to = 'admin.php?page=axian-ddr&action=edit&id=' . $new_ddr_id . '&msg=' . DDR_MSG_SAVED_SUCCESSFULLY;
                    wp_safe_redirect($redirect_to);die;
                }

            }
        } elseif ( $is_delete_ddr ){
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

                    return self::manage_message(DDR_MSG_DELETED_SUCCESSFULLY);
                }

            }
        }else {
            return false;
        }
    }

    public static function manage_message( $slug = null, $msg = '' ){
        if ( is_null($slug) ){
            $slug = isset($_GET['msg']) ? $_GET['msg'] : '';
        }
        $return = null;
        switch( $slug ){
            case DDR_MSG_SAVED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Enregistrement effectué avec succés.'
                );
                break;
            case DDR_MSG_SUBMITTED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Soumission effectuée avec succés. Votre ticket est en phase de validation.'
                );
                break;
            case DDR_MSG_DELETED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Suppresion effectuée avec succés.',
                );
                break;
            case DDR_MSG_ACTION_DENIED:
                $return = array(
                    'code' => 'error',
                    'msg' => 'Action non autorisée',
                );
                break;
            case DDR_MSG_VALIDATE_ERROR:
                $return = array(
                    'code' => 'error',
                    'msg' => $msg,
                );
                break;
            case DDR_MSG_UNKNOWN_ERROR:
                $return = array(
                    'code' => 'error',
                    'msg' => 'Action denied',
                );
                break;
        }

        return $return;
    }

    public static function getby( $field_args = array(), $supp_args = array(), $predifined_filters = '' ){
        global $wpdb, $current_user;

        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR . " WHERE 1=1 ";

        //predefine filter
        if ( !empty($predifined_filters) ){
            if ( $predifined_filters == 'myvalidation' ){
                $field_args['assignee_id'] = $current_user->ID;
            }

            if ( $predifined_filters == 'mytickets' ){
                $field_args['author_id'] = $current_user->ID;
            }

            if ( $predifined_filters == 'alltickets' ){

            }
        }

        foreach ( $field_args as $field => $value ){
            if ( empty($value) ) continue;

            switch( $field ){
                case 'id':
                    if ( preg_match('/DDR-([0-9]+)/', $value, $matches) ){
                        $value = $matches[1];
                    }
                    $query_select .= " AND $field = '{$value}'";
                    break;
                case 'title':
                case 'motif' :
                    $query_select .= " AND $field LIKE '%{$value}%'";
                    break;
                case 'date_previsionnel' :
                case 'created' :
                case 'modified' :
                    list($begin, $end) = explode(':', $value);
                    list($bd, $bm, $by) = explode('/', $begin);
                    list($ed, $em, $ey) = explode('/', $end);
                    $mysql_begin = $by . '-' . $bm . '-' . $bd . ' 00:00:00';
                    $mysql_end = $ey . '-' . $em . '-' . $ed . ' 23:59:59';
                    $query_select .= " AND $field >= '{$mysql_begin}' AND $field < '{$mysql_end}' ";
                    break;
                default:
                    $query_select .= " AND $field = '{$value}'";
            }
        }


        //ordre
        if( isset($supp_args['orderby']) && isset($supp_args['order']) ){
            $query_select .= " ORDER BY {$supp_args['orderby']} {$supp_args['order']} ";
        }

        //limit
        if ( isset($supp_args['limit']) && isset($supp_args['offset']) ){
            $query_select .= " LIMIT {$supp_args['offset']},{$supp_args['limit']} ";
        }

        $result = $wpdb->get_results($query_select);
        $count = $wpdb->get_var( "SELECT FOUND_ROWS()" );
        return array(
            'count' => $count,
            'items' => $result
        );

    }

}

global $axian_ddr;
$axian_ddr = new AxianDDR();