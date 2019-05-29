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
        DDR_STEP_FINISH => 'Fini',
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

        add_action('admin_init', array($this, 'process_ddr'));
    }

    public static function template_list(){
        include AXIAN_DDR_PATH . '/templates/ddr/ddr-list.tpl.php';
    }

    public static function template_edit(){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        include AXIAN_DDR_PATH . '/templates/ddr/ddr-edit.tpl.php';
    }

    public static function insert($args){
        global $wpdb;
        $now = date("Y-m-d H:i:s");

        $args['date_previsionnel'] = axian_ddr_convert_to_mysql_date($args['date_previsionnel']);
        $args['offre_data'] = serialize($args['offre_data']);

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
            'offre_data' => $args['offre_data'],

        ));

        if ( $result ){
            return $wpdb->insert_id;
        }
        return false;

    }

    public static function update($args){
        global $wpdb;
        $now = date("Y-m-d H:i:s");

        $data_authorized = array(
            'type',
            'direction',
            'title',
            'departement',
            'superieur_id',
            'lieu_travail',
            'batiment',
            'motif',
            'dernier_titulaire',
            'date_previsionnel',
            'assignee_id',
            'type_candidature',
            'etat',
            'etape',
            'offre_data',

        );
        $data = array();
        foreach ( $args as $key => $value ){
            if ( in_array($key, $data_authorized) ){
                $data[$key] = $value;
            }
        }

        $data['offre_data'] = serialize($data['offre_data']);
        $data['date_previsionnel'] = axian_ddr_convert_to_mysql_date($data['date_previsionnel']);
        $data['modified'] = $now;

        $result = $wpdb->update(
            TABLE_AXIAN_DDR,
            $data,
            array( 'id' => $args['id'] )
        );

        return $result;
    }

    public static function delete($id, $force_delete = true){
        global $wpdb;
        $wpdb->query('DELETE FROM '. TABLE_AXIAN_DDR . ' WHERE id = '.$id);
        if ( $force_delete ){
            $wpdb->query('DELETE FROM '. TABLE_AXIAN_DDR_HISTORIQUE . ' WHERE ddr_id = '.$id);
        }
    }

    public static function getbyId($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM '. TABLE_AXIAN_DDR . ' WHERE id = '.$id , ARRAY_A);

        return $result;
    }

    public function process_ddr(){
        global $ddr_process_msg;
        $is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
        $the_ddr_id = null;
        if ( $is_edit ) $the_ddr_id = intval($_GET['id']);

        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        $is_save_draft = isset($_POST['save-draft']);
        $is_submit_ddr = isset($_POST['submit-ddr']);
        $is_update_ddr = isset($_POST['update-ddr']);
        $is_delete_ddr = isset($_POST['delete-ddr']);
        $is_validate_ddr = isset($_POST['validate-ddr']);
        $is_refuse_ddr = isset($_POST['refuse-ddr']);
        $is_cloture_ddr = isset($_POST['cloture-ddr']);

        //permission
        if ( $is_save_draft && !current_user_can(DDR_CAP_CAN_CREATE_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_submit_ddr && !current_user_can(DDR_CAP_CAN_SUBMIT_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_update_ddr && !current_user_can(DDR_CAP_CAN_EDIT_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_delete_ddr && !current_user_can(DDR_CAP_CAN_DELETE_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_validate_ddr && !current_user_can(DDR_CAP_CAN_VALIDATE_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_refuse_ddr && !current_user_can(DDR_CAP_CAN_REFUSE_DDR) ){
            wp_die('Action non autorisée');
        }
        if ( $is_cloture_ddr && !current_user_can(DDR_CAP_CAN_CLOSE_DDR) ){
            wp_die('Action non autorisée');
        }

        if ( $is_save_draft || $is_submit_ddr || $is_update_ddr ){
            $msg = axian_ddr_validate_fields($this);

            //data not valid
            if ( !empty($msg) ){
                $ddr_process_msg = self::manage_message(DDR_MSG_VALIDATE_ERROR, $msg);
                return false;
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
                if ( is_null($the_ddr_id) ){
                    //maj etat / etape
                    if ( $is_save_draft ){
                        $post_data['etat'] = DDR_STATUS_DRAFT;
                    } elseif ( $is_submit_ddr ){
                        $post_data['etat'] = $post_data['next_etat'];
                        $post_data['etape'] = $post_data['next_etape'];
                    }

                    //insert
                    $new_ddr_id = self::insert( $post_data );

                    //historique
                    AxianDDRHistorique::add($new_ddr_id, array(
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

                    if ( !empty($redirect_to) ){
                        wp_safe_redirect($redirect_to);die;
                    }

                //mise à jour
                } else {

                    $the_ddr = AxianDDR::getbyId($the_ddr_id);

                    //maj etat / etape
                    if ( $is_submit_ddr ){
                        $post_data['etat'] = $post_data['next_etat'];
                        $post_data['etape'] = $post_data['next_etape'];
                    }

                    self::update( $post_data );

                    //historique
                    AxianDDRHistorique::add($the_ddr_id, array(
                        'action' => DDR_ACTION_UPDATE,
                        'etat_avant' => $the_ddr['etat'],
                        'etat_apres' => $post_data['etat'],
                        'etape' => $post_data['etape'],
                        'comment' => $post_data['comment'],
                    ));

                    //mail here
                    if ( $is_submit_ddr ){
                        //mail here
                    }
                    $redirect_to = 'admin.php?page=axian-ddr&action=edit&id=' . $the_ddr_id . '&msg=' . DDR_MSG_SAVED_SUCCESSFULLY;
                    wp_safe_redirect($redirect_to);die;
                }

            }
        } elseif ( $is_delete_ddr ){
            $nonce = wp_create_nonce( 'addr_delete_term'.absint( $_GET['id'] ) );


            if ( $nonce != $_GET['_wpnonce'] ){
                $ddr_process_msg = self::manage_message(DDR_MSG_ACTION_DENIED);
                return false;
            } else {
                //process delete term
                self::delete($the_ddr_id);

                $redirect_to = 'admin.php?page=axian-ddr-list&msg=' . DDR_MSG_DELETED_SUCCESSFULLY;
                wp_safe_redirect($redirect_to);die;

            }
        } elseif ( $is_validate_ddr ){
            if ( !is_null($the_ddr_id) ){
                $post_data = $_POST;
                $the_ddr = AxianDDR::getbyId($the_ddr_id);

                //maj etat / etape
                $post_data['etat'] = $post_data['next_etat'];
                $post_data['etape'] = $post_data['next_etape'];

                self::update( $post_data );

                //historique
                AxianDDRHistorique::add($the_ddr_id, array(
                    'action' => DDR_ACTION_VALIDATE,
                    'etat_avant' => $the_ddr['etat'],
                    'etat_apres' => $post_data['etat'],
                    'etape' => $post_data['etape'],
                    'comment' => $post_data['comment'],
                ));

                //mail here

                $redirect_to = 'admin.php?page=axian-ddr&action=view&id=' . $the_ddr_id . '&msg=' . DDR_MSG_VALIDATED_SUCCESSFULLY;
                wp_safe_redirect($redirect_to);die;
            }
        } elseif ( $is_refuse_ddr ){
            if ( !is_null($the_ddr_id) ){
                $post_data = $_POST;
                $the_ddr = AxianDDR::getbyId($the_ddr_id);

                //maj etat / etape
                $post_data['etat'] = DDR_STATUS_REFUSE;
                $post_data['etape'] = DDR_STEP_REFUSE;

                self::update( $post_data );

                //historique
                AxianDDRHistorique::add($the_ddr_id, array(
                    'action' => DDR_ACTION_REFUSE,
                    'etat_avant' => $the_ddr['etat'],
                    'etat_apres' => $post_data['etat'],
                    'etape' => $post_data['etape'],
                    'comment' => $post_data['comment'],
                ));

                //mail here

                $redirect_to = 'admin.php?page=axian-ddr&action=view&id=' . $the_ddr_id . '&msg=' . DDR_MSG_INVALIDATED_SUCCESSFULLY;
                wp_safe_redirect($redirect_to);die;
            }
        } elseif ( $is_cloture_ddr ){
            if ( !is_null($the_ddr_id) ){
                $post_data = $_POST;
                $the_ddr = AxianDDR::getbyId($the_ddr_id);

                //maj etat / etape
                $post_data['etat'] = DDR_STATUS_CLOTURE;
                $post_data['etape'] = DDR_STEP_FINISH;

                self::update( $post_data );

                //historique
                AxianDDRHistorique::add($the_ddr_id, array(
                    'action' => DDR_ACTION_CLOSE,
                    'etat_avant' => $the_ddr['etat'],
                    'etat_apres' => $post_data['etat'],
                    'etape' => $post_data['etape'],
                    'comment' => $post_data['comment'],
                ));

                $redirect_to = 'admin.php?page=axian-ddr&action=view&id=' . $the_ddr_id . '&msg=' . DDR_MSG_CLOSED_SUCCESSFULLY;
                wp_safe_redirect($redirect_to);die;
            }
        } else {
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
            case DDR_MSG_VALIDATED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Validation du ticket effectuée avec succés.',
                );
                break;
            case DDR_MSG_INVALIDATED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Refus du ticket effectué avec succés.',
                );
                break;
            case DDR_MSG_CLOSED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Clôture du ticket effectuée avec succés.',
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

        //restriction by permission
        if ( !current_user_can(DDR_CAP_CAN_LIST_OTHERS_DDR) && current_user_can(DDR_CAP_CAN_LIST_DDR) ){
            $field_args['author_id'] = $current_user->ID;
        }

        $data_authorized = array(
            'id',
            'author_id',
            'type',
            'direction',
            'title',
            'departement',
            'superieur_id',
            'lieu_travail',
            'batiment',
            'motif',
            'dernier_titulaire',
            'date_previsionnel',
            'assignee_id',
            'type_candidature',
            'created',
            'modified',
            'etat',
            'etape'
        );

        foreach ( $field_args as $field => $value ){
            if ( !in_array($field, $data_authorized) ) continue;
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