<?php
define( 'SHORTINIT', true );

if ( preg_match('/^(.+)wp-content.*/', dirname(__FILE__), $path) ){
    include($path[1] . 'wp-load.php');

    global $wpdb, $current_user;
    if ( $wpdb ) {
        $source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $role = isset($_REQUEST['role']) ? $_REQUEST['role'] : '';
        if ( !empty($source) ){
            //request an autocompletion by term
            if ( !empty($term) ){
                $results = array();
                switch($source){
                    case 'user':
                        $sql = '
                            SELECT u.ID as id, u.display_name as label FROM ' . $wpdb->users . ' AS u
                            INNER JOIN ' . $wpdb->usermeta . ' AS um
                            ON  ( u.ID = um.user_id AND um.meta_key = "wp_capabilities" )
                            WHERE u.display_name LIKE "%' . $term . '%"
                        ';

                        if ( !empty($role) ){
                            //user in ability group only
                            $role_filter = explode( '|', $role);
                        }else{
                            $role_filter = array(
                                'administrateur-ddr',
                                'manager',
                                'assistante-direction',
                                'assistante-rh',
                                'controleur-budgetaire',
                                'drh',
                                'dg',
                                'responsable_rh',
                            );
                        }
                        $glue = '';
                        $sql .= ' AND (';
                        foreach ( $role_filter as $role ){
                            $sql .= $glue . ' um.meta_value LIKE \'%"' . $role . '"%\' ';
                            $glue = ' OR ';
                        }
                        $sql .= ')';

                        $results = $wpdb->get_results($sql);
                        break;
                    case 'entreprise':
                        $results = $wpdb->get_results('SELECT ID as id, post_title as label FROM ' . $wpdb->posts . ' WHERE post_title LIKE "%' . $term . '%" AND post_type = "societe"');
                        break;
                    default:
                        die('invalid source');
                }
                if ( !empty($results) ){
                    echo json_encode($results);die;
                }

            //request a label to display for a id value
            } elseif ( !empty($id) ){
                $result = '';
                switch($source){
                    case 'user':
                        $result = $wpdb->get_var('SELECT display_name as label FROM ' . $wpdb->users . ' WHERE ID =' . $id );
                        break;
                    case 'entreprise':
                        $result = $wpdb->get_var('SELECT post_title as label FROM ' . $wpdb->posts . ' WHERE ID =' . $id );
                        break;
                    default:
                        die('invalid source');
                }
                if ( !empty($result) ){
                    echo $result;die;
                }
            }

        }
    } else {
        die('wpdb not loaded');
    }
} else {
    die('wp-load not found');
}
