<?php

class AxianDDRHistorique{

    public function add($ddr_id, $actor_id, $action, $etat_avant, $etat_apres, $etape){
        global $wpdb;
        $date = date("Y-m-d H:i:s");

        return $wpdb->insert(TABLE_AXIAN_DDR_HISTORIQUE, array(
            'ddr_id' => $ddr_id,
            'actor_id' => $actor_id,
            'action' => $action,
            'etat_avant' => $etat_avant,
            'etat_apres' => $etat_apres,
            'etape' => $etape,
            'date' => $date
        ));
    }
}