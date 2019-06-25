<?php

class AxianDDRInterim{

    public $fields;

    public static $status = array(
        DDR_INTERIM_EN_COURS => 'En cours',
        DDR_INTERIM_FINI => 'Terminé',
    );

    public function __construct(){
        $this->fields = array(
            'collaborator_id' => array(
                'label' => 'Collaborateur',
                'type' => 'autocompletion',
                'source' => 'user',
                'name' => 'collaborator_id',
                'required' => true,
            ),
            'interim_id' => array(
                'label' => 'Intérim',
                'type' => 'autocompletion',
                'source' => 'interim',
                'name' => 'interim_id',
                'required' => true,
            ),
            'date_interim' => array(
                'label' => 'Date debut et fin ',
                'type' => 'daterangepicker',
                'name' => 'date_interim',
                'required' => true,
            ),

        );
        add_action('admin_init',array($this,'process'));
    }

    public static function add($args){
        global $wpdb, $current_user;

        $data = array(
            'creator_id' => $current_user->ID,
            'collaborator_id' => intval($args['collaborator_id']),
            'interim_id' => intval($args['interim_id']),
            'date_debut' => $args['date_debut'],
            'date_fin' => $args['date_fin'],
            'interim_roles' => maybe_serialize($args['interim_roles']) ,
            'collaborator_tickets' => maybe_serialize($args['collaborator_tickets']),
            'status' => DDR_INTERIM_EN_COURS,
            'created' => date('Y-m-d H:i:s'),
        );

        $result = $wpdb->insert(TABLE_AXIAN_DDR_INTERIM, $data);

        if ( $result ){
            return $wpdb->insert_id;
        }
        return false;
    }

    public static function update($args){
        global $wpdb;

        $data_authorized = array(
            'creator_id',
            'collaborator_id',
            'interim_id',
            'date_debut',
            'date_fin',
            'interim_roles',
            'collaborator_tickets',
            'status',
            'created',
        );
        $data = array();
        foreach ( $args as $key => $value ){
            if ( in_array($key, $data_authorized) ){
                $data[$key] = $value;
            }
        }

        if ( isset($data['interim_roles']) && !empty($data['interim_roles']) ){
            $data['interim_roles'] = maybe_serialize($data['interim_roles']);
        }

        if ( isset($data['collaborator_tickets']) && !empty($data['collaborator_tickets']) ){
            $data['collaborator_tickets'] = maybe_serialize($data['collaborator_tickets']);
        }

        $data['modified'] = date('Y-m-d H:i:s');

        $result = $wpdb->update(
            TABLE_AXIAN_DDR_INTERIM,
            $data,
            array( 'id' => $args['id'] )
        );

        return $result;
    }

    public static function delete($id){
        global $wpdb;
        $wpdb->delete(
            TABLE_AXIAN_DDR_INTERIM,
            array('id' => $id)
        );
    }

    public static function template(){
        include AXIAN_DDR_PATH . '/templates/interim/interim-edit.tpl.php';
    }

    public function process(){
        global $interim_process_msg;
        $is_submit_interim = isset($_POST['submit-interim']);
        $is_update_interim = isset($_POST['update-interim']);
        $is_delete_interim = (isset($_GET['action']) && 'delete' == $_GET['action']);
        $id = ( isset($_GET['id']) && !empty($_GET['id']) ) ? intval($_GET['id']) : null;

        if ($is_delete_interim){
            if ( !current_user_can(DDR_CAP_CAN_ADMIN_INTERIM) ){
                wp_die('Action non autorisée');
            }
            self::delete($id);
            $redirect_to = 'admin.php?page=axian-ddr-interim&msg=' . DDR_MSG_DELETED_SUCCESSFULLY;
            wp_safe_redirect($redirect_to);die;
        } elseif ( $is_submit_interim || $is_update_interim ){
            if ( !current_user_can(DDR_CAP_CAN_ADMIN_INTERIM) ){
                wp_die('Action non autorisée');
            }
            $msg = axian_ddr_validate_fields($this);
            //data not valid
            if ( !empty($msg) ){
                $interim_process_msg = self::manage_message(DDR_MSG_VALIDATE_ERROR, $msg);
                return false;
                //data valid
            } else {
                //process add interim
                $post_data = $_POST;
                $collaborator_id = intval( $post_data['collaborator_id'] );
                $interim_id = intval( $post_data['interim_id'] );

                //save interim role
                $user_meta = get_userdata($interim_id);
                $user_roles = $user_meta->roles;
                $post_data['interim_roles'] = $user_roles;

                //Date
                list($date_debut, $date_fin) = explode(':', $post_data['date_interim']);
                $post_data['date_debut'] = axian_ddr_convert_to_mysql_date($date_debut);
                $post_data['date_fin'] = axian_ddr_convert_to_mysql_date($date_fin);
                unset($post_data['date_interim']);

                //collaborator tickets
                $post_data['collaborator_tickets'] = AxianDDR::getByAssigneeId($collaborator_id, array(DDR_STATUS_EN_COURS));

                if ( $is_submit_interim ){
                    //insert
                    $id = self::add($post_data);
                    $redirect_to = 'admin.php?page=axian-ddr-interim&msg=' . DDR_MSG_SUBMITTED_SUCCESSFULLY;
                }elseif ($is_update_interim){

                    //reactivate interim for cron
                    $post_data['status'] = DDR_INTERIM_EN_COURS;
                    self::update($post_data);
                    $redirect_to = 'admin.php?page=axian-ddr-interim&action=edit&id=' . $id . '&msg=' . DDR_MSG_SAVED_SUCCESSFULLY;
                }
                if ( !empty($redirect_to) ){
                    wp_safe_redirect($redirect_to);die;
                }
            }
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
                    'msg' => 'Soumission effectuée avec succés.'
                );
                break;
            case DDR_MSG_DELETED_SUCCESSFULLY:
                $return = array(
                    'code' => 'updated',
                    'msg' => 'Suppression effectuée avec succés.'
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

    public static function getById($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM '. TABLE_AXIAN_DDR_INTERIM . ' WHERE id = '.$id , ARRAY_A);

        return $result;
    }

    public static function getBy($field_args = array(), $supp_args = array()){
        global $wpdb;

        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR_INTERIM . " WHERE 1=1 ";

        $data_authorized = array(
            'creator_id',
            'collaborator_id',
            'interim_id',
            'date_fin',
            'date_debut',
            'date_debut',
            'created',
        );

        foreach ( $field_args as $field => $value ){
            if ( !in_array($field, $data_authorized) ) continue;
            if ( empty($value) ) continue;

            switch( $field ){

                case 'date_debut' :
                    $query_select .= " AND $field >= '" . axian_ddr_convert_to_mysql_date($value) . "'";
                    break;
                case 'date_fin' :
                    $query_select .= " AND $field <= '" . axian_ddr_convert_to_mysql_date($value) . "'";
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

    public static function manageInterim(){
        $today = date("Y-m-d");
        $interims = self::getBy(array('status'=>DDR_INTERIM_EN_COURS));
        if ( $interims['count'] > 0 ) foreach($interims['items'] as $interim){
            $user_collaborator = new WP_User($interim->collaborator_id);
            $user_interim = new WP_User($interim->interim_id);

            $date_debut = $interim->date_debut;
            $date_fin = $interim->date_fin;

            //si on est dans la période de l'interim
            if( $date_debut <= $today && $today <= $date_fin ){
                foreach($user_collaborator->roles as $role){
                    if( !in_array($role, $user_interim->roles)){
                        $user_interim->add_role($role);
                    }
                }
                $new_ddrs = AxianDDR::substitutionDDR($interim->collaborator_id, $interim->interim_id);

                $collaborator_tickets = maybe_unserialize($interim->collaborator_tickets);
                $collaborator_tickets = array_unique(array_merge($collaborator_tickets, $new_ddrs));
                self::update(array(
                    'id' => $interim->id,
                    'collaborator_tickets'=> $collaborator_tickets
                ));
            }elseif ( $date_fin < $today ) {
                $original_interim_roles = unserialize($interim->interim_roles);
                foreach($user_interim->roles as $role){
                    $user_interim->remove_role($role);
                }
                foreach($original_interim_roles as $role){
                    $user_interim->add_role($role);
                }
                AxianDDR::substitutionDDR($interim->interim_id, $interim->collaborator_id, unserialize($interim->collaborator_tickets));
                self::update(array(
                    'id' => $interim->id,
                    'status'=> DDR_INTERIM_FINI
                ));
            }
        }
    }

    public static function getCurrentInterim($user_id){
        global $wpdb;
        $today = date('Y-m-d');
        return $wpdb->get_row(
            "SELECT * FROM " . TABLE_AXIAN_DDR_INTERIM .
            " WHERE collaborator_id = " . $user_id .
            " AND date_debut <= '" . $today . "' AND '" . $today . "' <= date_fin
            LIMIT 1"
        );
    }
}

global $axian_ddr_interim;
$axian_ddr_interim = new AxianDDRInterim();
