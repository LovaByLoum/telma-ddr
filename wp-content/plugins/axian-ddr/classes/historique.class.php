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

    public static function template_list(){
        include AXIAN_DDR_PATH . '/templates/historique/historique-list.tpl.php';
    }

    public static function getby( $field_args = array(), $supp_args = array() ){
        global $wpdb, $current_user;
        $the_user = AxianDDRUser::getById($current_user->ID);

        $query_select = "SELECT SQL_CALC_FOUND_ROWS *  FROM  " . TABLE_AXIAN_DDR . " WHERE 1=1 ";

        //restriction by permission
        if ( !current_user_can(DDR_CAP_CAN_LIST_OTHERS_DDR) && current_user_can(DDR_CAP_CAN_LIST_DDR) ){
            $field_args['author_id'] = $current_user->ID;
        }

        //restriction by societe
        //$field_args['societe'] = $the_user->company;

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
            'etape',
            'societe',
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
            'items' => $result,
            'query_export' => $query_select
        );

    }

    public static function getDelaiEtape( $ddr_id, $etape_start, $etape_end ){
        global $wpdb;
        $date_debut = $wpdb->get_var(
            "SELECT date FROM " . TABLE_AXIAN_DDR_HISTORIQUE .
            " WHERE ddr_id = " . $ddr_id .
            " AND etape = '" . $etape_start . "'
            ORDER BY id ASC"
        );

        $date_fin = $wpdb->get_var(
            "SELECT date FROM " . TABLE_AXIAN_DDR_HISTORIQUE .
            " WHERE ddr_id = " . $ddr_id .
            " AND etape = '" . $etape_end . "'
            ORDER BY id ASC"
        );

        if ( $date_fin && $date_debut ) {
            //$diff = abs(strtotime($date_fin) - strtotime($date_debut));

            $date1 = new DateTime($date_debut);
            $date2 = new DateTime($date_fin);
            $interval = $date1->diff($date2);
            return $interval->d . " jours " . $interval->i . " mn " . $interval->s . " sec" ;
        } else {
            return 'Traitement en cours';
        }
    }

}
