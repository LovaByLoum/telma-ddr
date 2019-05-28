<?php

class AxianDDRHistorique{

    public static function add( $ddr_id, $args = array() ){
        global $wpdb, $current_user;
        $date = date("Y-m-d H:i:s");

        $wpdb->insert(TABLE_AXIAN_DDR_HISTORIQUE, array(
            'ddr_id' => $ddr_id,
            'actor_id' => intval($current_user->data->ID),
            'action' => $args['action'],
            'etat_avant' => $args['etat_avant'],
            'etat_apres' => $args['etat_apres'],
            'etape' => $args['etape'],
            'comment' => $args['comment'],
            'date' => $date
        ));
    }

    public static function getByDDRId($id){
        global $wpdb;
        $historiques = $wpdb->get_results('SELECT h.*, u.display_name FROM '. TABLE_AXIAN_DDR_HISTORIQUE . ' AS h
                                                        INNER JOIN '.$wpdb->prefix.'users  AS u ON actor_id = u.`ID`
                                                WHERE ddr_id = '.$id ,ARRAY_A);

        return $historiques;
    }
}