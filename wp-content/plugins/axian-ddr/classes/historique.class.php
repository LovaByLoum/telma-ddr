<?php

class AxianDDRHistorique{

    public function add($ddr_id, $action, $etat_avant, $etat_apres, $etape){
        global $wpdb, $current_user;
        $date = date("Y-m-d H:i:s");

        return $wpdb->insert(TABLE_AXIAN_DDR_HISTORIQUE, array(
            'ddr_id' => $ddr_id,
            'actor_id' => intval($current_user->data->ID),
            'action' => $action,
            'etat_avant' => $etat_avant,
            'etat_apres' => $etat_apres,
            'etape' => $etape,
            'date' => $date
        ));
    }

    public function getByDdrId($id){
        global $wpdb;
        $historiques = $wpdb->get_results('SELECT h.*, u.display_name FROM '. TABLE_AXIAN_DDR_HISTORIQUE . ' AS h
                                                        INNER JOIN '.$wpdb->prefix.'users  AS u ON actor_id = u.`ID`
                                                WHERE ddr_id = '.$id ,ARRAY_A);

        return $historiques;
    }
}