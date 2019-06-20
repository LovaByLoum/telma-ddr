<?php

class AxianDDRInterim{

    public $fields;

    public static $status = array(
        DDR_INTERIM_EN_COURS => 'En cour',
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
            'collaborator_interim_id' => array(
                'label' => 'Intérim',
                'type' => 'autocompletion',
                'source' => 'interim',
                'name' => 'collaborator_interim_id',
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

        $result = $wpdb->insert(TABLE_AXIAN_DDR_INTERIM, array(
            'creator_id' => $current_user->ID,
            'collaborator_id' => intval($args['collaborator_id']),
            'collaborator_interim_id' => intval($args['collaborator_interim_id']),
            'date_interim' => $args['date_interim'],
            'collaborator_roles' => $args['collaborator_roles'],
            'status' => DDR_INTERIM_EN_COURS,

        ));

        if ( $result ){
            return $wpdb->insert_id;
        }
        return false;
    }

    public static function update($args){
        global $wpdb;
        $data_authorized = array(
            'collaborator_id',
            'collaborator_interim_id',
            'date_interim',
            'collaborator_roles',
            'status',
        );
        $data = array();
        foreach ( $args as $key => $value ){
            if ( in_array($key, $data_authorized) ){
                $data[$key] = $value;
            }
        }


        $result = $wpdb->update(
            TABLE_AXIAN_DDR_INTERIM,
            $data,
            array( 'id' => $args['id'] )
        );

        return $result;
    }

    public static function delete($id){

    }

    public static function template(){
        include AXIAN_DDR_PATH . '/templates/interim/interim-edit.tpl.php';
    }

    public function process(){
        global $interim_process_msg;
        $user = new Wp_User(1486);
        //var_dump($user);die;
        $is_submit_interim = isset($_POST['submit-interim']);
        $is_update_interim = isset($_POST['update-interim']);
        $is_delete_interim = isset($_POST['delete-interim']);
        $the_interim_id = ( isset($_GET['id']) && !empty($_GET['id']) ) ? intval($_GET['id']) : null;
        $msg = axian_ddr_validate_fields($this);

        //data not valid
        if ( !empty($msg) ){
            $interim_process_msg = self::manage_message(DDR_MSG_VALIDATE_ERROR, $msg);
            return false;
            //data valid
        } else {
            //process add term
            $post_data = $_POST;
            $collaborator_id = intval( $post_data['collaborator_id'] );
            $user_meta = get_userdata($collaborator_id);
            $user_roles = $user_meta->roles;
            $post_data['collaborator_roles'] = serialize($user_roles);
            if ( $is_submit_interim ){
                //insert
                $the_new_interim_id = self::add($post_data);
                $redirect_to = 'admin.php?page=axian-ddr-interim&action=view&id=' . $the_new_interim_id . '&msg=' . DDR_MSG_SUBMITTED_SUCCESSFULLY;
            }elseif ($is_update_interim){
                self::update($post_data);
                $redirect_to = 'admin.php?page=axian-ddr-interim&action=view&id=' . $the_interim_id . '&msg=' . DDR_MSG_SAVED_SUCCESSFULLY;
            }elseif ($is_delete_interim){
                self::delete($the_interim_id);
                //$redirect_to = 'admin.php?page=axian-ddr-interim-list&msg=' . DDR_MSG_DELETED_SUCCESSFULLY;
            }

            if ( !empty($redirect_to) ){
                wp_safe_redirect($redirect_to);die;
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

    public static function getBy($field_args = array(), $supp_args = array(), $predifined_filters =''){
        global $wpdb;

        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR_INTERIM . " WHERE 1=1 ";

        //predefine filter
        /*if ( !empty($predifined_filters) ){
            if ( $predifined_filters == 'myvalidation' ){
                $field_args['assignee_id'] = $current_user->ID;
            }

            if ( $predifined_filters == 'mytickets' ){
                $field_args['author_id'] = $current_user->ID;
            }

            if ( $predifined_filters == 'alltickets' ){

            }
        }*/

        $data_authorized = array(
            'collaborator_id',
            'collaborator_interim_id',
            'date_interim',
            'status',
        );

        foreach ( $field_args as $field => $value ){
            if ( !in_array($field, $data_authorized) ) continue;
            if ( empty($value) ) continue;

            switch( $field ){

                case 'date_interim' :
                    list($begin, $end) = explode(':', $value);
                    list($bd, $bm, $by) = explode('/', $begin);
                    list($ed, $em, $ey) = explode('/', $end);
                    $mysql_begin = $by . '-' . $bm . '-' . $bd . ' 00:00:00';
                    $mysql_end = $ey . '-' . $em . '-' . $ed . ' 23:59:59';
                    //$query_select .= " AND $field >= '{$mysql_begin}' AND $field < '{$mysql_end}' ";
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
        $today = date_create("today");
        $interims = self::getBy(array('status'=>DDR_INTERIM_EN_COURS));
        if ( $interims['count'] > 0 ) foreach($interims['items'] as $interim){
            $user_meta=get_userdata($interim->collaborator_id);
            $collaborator_interim_roles= $user_meta->roles;
            $collaborator_interim = new Wp_User($interim->collaborator_interim_id);
            list($begin,$end) = explode(':', $interim->date_interim);
            list($bd, $bm, $by) = explode('/', $begin);
            list($ed, $em, $ey) = explode('/', $end);
            $mysql_end = date_create($ey . '-' . $em . '-' . $ed );
            $collaborator_interim_default_roles = unserialize($interim->collaborator_roles);
            if( $mysql_end >= $today){
                foreach($collaborator_interim_roles as $role){
                    if( !in_array($role,$collaborator_interim_default_roles)) $collaborator_interim->add_role($role); $collaborator_interim->add_role($role);
                }
                AxianDDR::substitutionDDR($interim->collaborator_id,$interim->collaborator_interim_id);
            }else{

                foreach($collaborator_interim_roles as $role){
                    if( !in_array($role,$collaborator_interim_default_roles)) $collaborator_interim->remove_role($role);
                }
                AxianDDR::substitutionDDR($interim->collaborator_interim_id, $interim->collaborator_id);
                self::update(array(
                    'id' => $interim->id,
                    'status' =>DDR_INTERIM_FINI,
                ));
            }
        }
    }
}

global $axian_ddr_interim;
$axian_ddr_interim = new AxianDDRInterim();
