<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if( ! class_exists( 'AxianDDRTerm' ) ) {
    require_once( AXIAN_DDR_PATH . '/classes/term.class.php' );
}

class AxianDDRList extends WP_List_Table{
    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste des demandes',
            'plural'    => 'Liste des demandes',
            'ajax'      =>  false
        ) );
    }

    function no_items() {
        _e( 'Aucun résultat.' );
    }

    /**
     * Fonction qui gère les valeurs qui doivent être affichées pour chaque colonne.
     */
    function column_default( $item, $column_name ) {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        switch( $column_name ) {
            case 'id':
                return $item->id;
                break;
            case 'type':
                return ($item->type == TYPE_DEMANDE_PREVU) ? 'Prévu' : 'Non prévu';
                break;
            case 'title':
                return $item->title;
                break;
            case 'created':
                return strftime("%d %b %Y", strtotime($item->created) );
                break;
            case 'direction':
                $direction = AxianDDRTerm::getby_id($item->direction);
                return $direction['label'];
                break;
            case 'departement':
                $departement = AxianDDRTerm::getby_id($item->departement);
                return $departement['label'];
                break;
            case 'lieu':
                $lieu = AxianDDRTerm::getby_id($item->lieu_travail);
                return $lieu['label'];
                break;
            case 'type_candidature':
                return ($item->type_candidature == CANDIDATURE_INTERNE) ? 'Interne' : 'Externe';
                break;
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Fonction qui gère les colonnes qui sont sortable.
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id',false),
            'title' => array('title',false),
        );

        return $sortable_columns;
    }

    function extra_tablenav( $which ) {

    }

    /**
     * Fonction qui gère les colonnes à utiliser.
     */
    function get_columns(){

        $columns = array(
            'id' => 'Numéro du ticket',
            'type' => 'Type de la demande',
            'title' => 'Titre de la demande',
            'direction' => 'Direction',
            'departement' => 'Département',
            'lieu' => 'Lieu',
            'type_candidature' => 'Type de candidature',
            'created' => 'Date de création',
        );

        return $columns;
    }

    /**
     * Fonction qui gère les données à afficher
     */
    function prepare_items() {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page = 10;

        $current_page = $this->get_pagenum();
        $current_page = ($current_page -1 ) * $per_page;

        $total = self::count_result();
        $resultats = AxianDDR::getby(array(
            'offset' => $current_page,
            'limit' => $per_page)
        );
        $this->set_pagination_args( array(
            'total_items' => $total,
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_id( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'addr_delete_term' .absint( $item->id ) );
        $title = '<strong>DDR-' . $item->id . '</strong>';

        $actions = [
            'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">Editer</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item->id ) ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s">Supprimer</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ), $delete_nonce )
        ];

        return $title . $this->row_actions( $actions );
    }

    function count_result(){
        global $wpdb;
        return intval($wpdb->get_var("SELECT COUNT(*) FROM ".TABLE_AXIAN_DDR ));
    }

}
