<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 13/05/19
 * Time: 14:42
 * To change this template use File | Settings | File Templates.
 */

class AxianDDRTerm{

    public static $types = array(
        'direction' => 'Direction',
        'departement' => 'Département / Service',
        'lieu' => 'Lieu / Bâtiment'
    );

    public $fields;

    public function __construct(){

        //init admin fields
        $this->fields = array(
            'type' => array(
                'label' => 'Type de terme',
                'type' => 'select',
                'class' => 'chosen-select',
                'name' => 'type',
                'required' => true,
                'options' => self::$types,
            ),

            'label' => array(
                'label' => 'Libellé',
                'type' => 'text',
                'name' => 'label',
                'size' => '50',
                'required' => true,
            ),

        );
    }

    public function submit_term(){
        if ( isset($_POST['submit-term']) ){
            $msg = axian_ddr_validate_fields($this);

            if ( !empty($msg) ){
                return array(
                    'code' => 'error',
                    'msg' => $msg,
                );
            } else {
                //process ad term
                $post_data = $_POST;
                $return_add = self::add(
                    $post_data['type'],
                    $post_data['label']
                );

                //test si echec
                if ( !$return_add ){
                    return array(
                        'code' => 'error',
                        'msg' => 'Erreur inconnu',
                    );
                }  else {
                    //unset post
                    unset($_POST['type']);
                    unset($_POST['label']);
                    return array(
                        'code' => 'updated',
                        'msg' => 'Enregistrement effectué avec succés.',
                    );
                }

            }
        } elseif ( isset($_POST['update-term']) ){
            $msg = axian_ddr_validate_fields($this);

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

    public static function add( $type, $label ){
        global $wpdb;
        $result = $wpdb->insert(TABLE_AXIAN_DDR_TERM, array(
            'type' => $type,
            'label' => $label
        ));
        if ( $result ) {
            $term_id = $wpdb->insert_id;
            return $term_id;
        }else return $result;
    }

    public static function update($id, $type, $label){
        global $wpdb;

        return $wpdb->update(
            TABLE_AXIAN_DDR_TERM,
            array(
                'type' => $type,
                'label' => $label,
            ),
            array( 'id' => $id )
        );
    }

    public static function delete($id){
        global $wpdb;
        $result = $wpdb->delete(TABLE_AXIAN_DDR_TERM, array( 'id' => $id));

        return $result;

    }

    public static function getby( $args = array(), $format = null ){
        $default_args = array(
            'offset' => 0,
            'limit' => 0,
            'type' => 'tous',
            'orderby' => 'label',
            'order' => 'ASC',
        );

        $args = wp_parse_args($args, $default_args);
        extract($args);

        global $wpdb;
        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR_TERM ;

        //type
        if ( $type != 'tous' ){
            $query_select .= " WHERE type='{$type}'";
        }

        //ordre
        $query_select .= " ORDER BY {$orderby} {$order} ";

        //limit
        if( $offset && $limit ){
            $query_select .= " LIMIT {$offset},{$limit} ";
        }

        $result = $wpdb->get_results($query_select);
        if ( $format == 'options' ){
            $options = array();
            foreach ( $result as $obj ){
                $options[$obj->id] = $obj->label;
            }
            return $options;
        }

        return array(
            'count' => sizeof($result),
            'items' => $result
        );

    }

    public static function getby_id($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM '. TABLE_AXIAN_DDR_TERM . ' WHERE id = '.$id ,ARRAY_A);

        return $result;

    }

    public function count_result(){
        global $wpdb;
        $results = array();
        foreach(self::$types as $type => $value){
            $results[$type] = intval($wpdb->get_var("SELECT COUNT(*) FROM ".TABLE_AXIAN_DDR_TERM." WHERE type='".$type."'"));
        }
        $results['tous'] = array_sum($results);

        return $results;
    }

}
global $axian_ddr_term;
$axian_ddr_term = new AxianDDRTerm();