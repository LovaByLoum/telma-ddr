<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 13/05/19
 * Time: 14:42
 * To change this template use File | Settings | File Templates.
 */

class DDR_label{



    public static function add($type, $label){
        global $wpdb;
        
    }

    public static function update($id, $type, $label){

    }

    public static function delete($id){

    }

    public static function show($type){
        global $wpdb;
        $page = ( isset($_GET['page']) && !empty($_GET['page']) ) ? intval($_GET['page']) : 0;
        $sql="SELECT * FROM ".TABLE_DDR_LABEL . " LIMIT = 10 OFFSET = ".$page*10;
        $count_sql="SELECT COUNT(*) FROM ".TABLE_DDR_LABEL . " WHERE type =";
        $count_sql .= "'".$type."'";
        $count = $wpdb->get_var( $count_sql);
        var_dump($count);
        $error_label_msg = '';
        if ( isset($_POST['submit-label']) && !empty($_POST['submit-label']) ){
            $label_name = (isset($_POST['label-name']) && !empty($_POST['label-name'])) ? $_POST['label-name'] : '';
            $label_description = (isset($_POST['label-description']) && !empty($_POST['label-description'])) ? $_POST['label-description'] : '';
            $label_type = (isset($_POST['label-type']) && !empty($_POST['label-type'])) ? $_POST['label-type'] : '';
        }

        if( ( isset($_POST['submit-label']) && !empty($_POST['submit-label']) ) && empty($label_name) ) $error_label_msg .= __('Le nom est requis','Axian DDR');

        if ( ( isset($_POST) && !empty($_POST) ) && ( isset($label_name) && !empty($label_name) ) && empty($error_label_msg) ){
            $wpdb->insert(TABLE_DDR_LABEL, array(
                'type' => $label_type,
                'label' => $label_name,
                'description' => $label_description,
            ));
        }
        $results = $wpdb->get_results( $sql, ARRAY_A );
        include_once( ADDR_PATH . '/views/taxonomie.tpl.php' );
    }
}