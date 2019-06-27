<?php
class AxianDDRTermList extends WP_Filter_List_Table{
    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste des termes',
            'plural'    => 'Liste des termes',
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

        switch( $column_name ) {
            case 'id':
                return $item->id;
                break;
            case 'type':
                return $item->type;
                break;
            case 'label':
                return $item->label;
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
            'type' => array('type',false),
            'label' => array('label',false),
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
            'label' => 'Libellé',
            'type' => 'Type de terme',
            'id' => 'Identifiant'
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

        $per_page = 50;

        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $args = array(
            'offset' => $offset,
            'limit' => $per_page,
            'type' => isset($_GET['type']) ? $_GET['type'] : 'tous',
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'label',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );

        $resultats = AxianDDRTerm::getby( $args );
        $this->set_pagination_args( array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_label( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'addr_delete_term' .absint( $item->id ) );
        $title = '<strong>' . $item->label . '</strong>';

        $actions = array(
            'edit' => sprintf( '<a href="?page=%s&tab=term&action=%s&id=%s">Modifier</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item->id ) ),
            'delete' => sprintf( '<a href="?page=%s&tab=term&action=%s&id=%s&_wpnonce=%s">Supprimer</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ), $delete_nonce )
        );

        return $title . $this->row_actions( $actions );
    }

}
