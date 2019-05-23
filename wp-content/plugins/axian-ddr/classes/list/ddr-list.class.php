<?php
class AxianDDRList extends WP_Filter_List_Table{

    public static $type = array(
        TYPE_DEMANDE_PREVU => 'Prévu',
        TYPE_DEMANDE_NON_PREVU => 'Non prévu',
    );

    public static $candidature = array(
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


    public static function load_hook(){
        global $DDRListTable;

        $option = 'per_page';
        $args = array(
            'label' => 'DDR',
            'default' => 20,
            'option' => 'ddr_per_page'
        );
        add_screen_option( $option, $args );

        $DDRListTable = new AxianDDRList();
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
                return self::$type[$item->$column_name];
                break;
            case 'title':
                return $item->title;
                break;
            case 'created':
                return strftime("%d %b %Y", strtotime($item->created) );
                break;
            case 'direction':
            case 'departement':
            case 'lieu_travail':
                $term = AxianDDRTerm::getby_id($item->$column_name);
                return $term['label'];
                break;
            case 'type_candidature':
                return self::$candidature[$item->$column_name];
                break;
            default:
                return $item->$column_name ;
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

    function get_filterable_columns() {
        $filterable_columns = array(
            'title' => array('type' => 'text'),
            'type' => array('type' => 'select', 'options' => $this->type),
            'type_candidature' => array('type' => 'select', 'options' => $this->candidature),
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
            'type' => 'Type de la demande',
            'author_id' => 'Créateur',
            'assignee_id' => 'Attribution',
            'title' => 'Titre de la demande',
            'etat' => 'Etat',
            'etape' => 'Etape',
            'direction' => 'Direction',
            'departement' => 'Département',
            'lieu_travail' => 'Lieu',
            'type_candidature' => 'Type de candidature',
            'motif' => 'Motif',
            'date_previsionnel' => 'Date prévisionnelle',
            'created' => 'Date de création',
            'modified' => 'Date de modification',
        );

        return $columns;
    }

    /**
     * Fonction qui gère les données à afficher
     */
    function prepare_items() {
        /*$columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );*/
        $this->_column_headers = $this->get_column_info();

        $per_page = $this->get_items_per_page('ddr_per_page', 20);
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1 ) * $per_page;

        $total = self::count_result();
        $resultats = AxianDDR::getby(array(
            'offset' => $offset,
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