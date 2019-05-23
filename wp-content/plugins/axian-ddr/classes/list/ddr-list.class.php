<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if( ! class_exists( 'AxianDDRTerm' ) ) {
    require_once( AXIAN_DDR_PATH . '/classes/term.class.php' );
}
if( ! class_exists( 'WP_Filter_List_Table' ) ) {
    require_once( AXIAN_DDR_PATH . '/classes/list/class-wp-filter-list-table.php' );
}

class AxianDDRList extends WP_Filter_List_Table{

    public $type = array(
        TYPE_DEMANDE_PREVU => 'Prévu',
        TYPE_DEMANDE_NON_PREVU => 'Non prévu',
    );

    public $candidature = array(
        CANDIDATURE_INTERNE => 'Interne',
        CANDIDATURE_EXTERNE => 'Externe',
    );

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
            case 'candidature':
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
            'created' => array('created',false),
        );

        return $sortable_columns;
    }

    function get_filterable_columns() {
        $filterable_columns = array(
            'title' => array('type' => 'text'),
            'type' => array('type' => 'select', 'options' => $this->type),
            'candidature' => array('type' => 'select', 'options' => $this->candidature),
        );

        return $filterable_columns;
    }

    function extra_tablenav( $which ) {

    }

    /**
     * Fonction qui gère les colonnes à utiliser.
     */
    function get_columns(){

        $columns = array(
            'id' => 'Numéro du ticket',
            'title' => 'Titre',
            'direction' => 'Direction',
            'type' => 'Type de demande',
            'departement' => 'Département',
            'lieu' => 'Lieu',
            'candidature' => 'Type de candidature',
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
        $user = get_current_user_id();

        $screen = get_current_screen();

        $option = $screen->get_option('per_page', 'option');

        $per_page = get_user_meta($user, $option, true);
        var_dump($option);
        $current_page = $this->get_pagenum();
        $current_page = ($current_page -1 ) * $per_page;

        $resultats = AxianDDR::getby(array(
            'offset' => $current_page,
            'limit' => $per_page,
        ));
        $this->set_pagination_args( array(
            'total_items' => intval($resultats["count"]),
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_id( $item ) {

        $title = '<strong>DDR-' . $item->id . '</strong>';

        $actions = [
            'view' => sprintf( '<a href="?page=%s&action=%s&id=%s">Afficher</a>', 'new-axian-ddr','view', absint( $item->id ) ),
            'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">Editer</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item->id ) ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s">Supprimer</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ) )
        ];

        return $title . $this->row_actions( $actions );
    }


}
