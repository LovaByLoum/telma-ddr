<?php
class AxianDDRList extends WP_Filter_List_Table{

    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste des demandes',
            'plural'    => 'Liste des demandes',
            'ajax'      =>  false
        ) );

        $this->filter_position = 'top';
        //$this->filter_position = 'table';
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
                return AxianDDR::$types_demande[$item->$column_name];
                break;
            case 'title':
                return $item->title;
                break;
            case 'modified':
            case 'created':
                return axian_ddr_convert_to_human_datetime($item->$column_name);
                break;
            case 'date_previsionnel':
                return axian_ddr_convert_to_human_date($item->$column_name);
                break;
            case 'direction':
            case 'departement':
            case 'lieu_travail':
                $term = AxianDDRTerm::getby_id($item->$column_name);
                return $term['label'];
                break;
            case 'author_id':
            case 'assignee_id':
                $user = AxianDDRUser::getById($item->$column_name);
                return $user->display_name;
                break;
            case 'type_candidature':
                return AxianDDR::$types_candidature[$item->$column_name];
                break;
            case 'etat':
                return AxianDDR::$etats[$item->$column_name];
                break;
            case 'etape':
                return AxianDDR::$etapes[$item->$column_name];
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
            'type' => array('type',false),
            'author_id' => array('author_id',false),
            'assignee_id' => array('assignee_id',false),
            'etat' => array('etat',false),
            'etape' => array('etape',false),
            'direction' => array('direction',false),
            'departement' => array('departement',false),
            'lieu_travail' => array('lieu_travail',false),
            'type_candidature' => array('type_candidature',false),
            'date_previsionnel' => array('date_previsionnel',false),
            'created' => array('created',false),
            'modified' => array('modified',false),
        );

        return $sortable_columns;
    }

    function get_filterable_columns() {
        global $axian_ddr;
        $filterable_columns = array(
            'id' => array('type' => 'text'),
            'title' => array('type' => 'text'),
            'type' => array('type' => 'select', 'options' => AxianDDR::$types_demande),
            'type_candidature' => array('type' => 'select', 'options' => AxianDDR::$types_candidature),
            'author_id' => array('type' => 'autocompletion', 'source' => 'user'),
            'assignee_id' => array('type' => 'autocompletion', 'source' => 'user'),
            'etat' => array('type' => 'select', 'options' => AxianDDR::$etats),
            'etape' => array('type' => 'select', 'options' => AxianDDR::$etapes),
            'direction' => array('type' => 'select', 'options' => $axian_ddr->directions),
            'departement' => array('type' => 'select', 'options' => $axian_ddr->departements),
            'lieu_travail' => array('type' => 'select', 'options' => $axian_ddr->lieux),
            //'motif' => array('type' => 'text'),
            'date_previsionnel' => array('type' => 'daterangepicker'),
            'created' => array('type' => 'daterangepicker'),
            'modified' => array('type' => 'daterangepicker'),
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
            'title' => 'Titre de la demande',
            'type' => 'Type de la demande',
            'author_id' => 'Créateur',
            'assignee_id' => 'Attribution',
            'etat' => 'Etat',
            'etape' => 'Etape',
            'direction' => 'Direction',
            'departement' => 'Département',
            'lieu_travail' => 'Lieu',
            'type_candidature' => 'Type de candidature',
            //'motif' => 'Motif',
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

        $this->_column_headers = $this->get_column_info();

        $per_page = $this->get_items_per_page('ddr_per_page', 20);
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1 ) * $per_page;

        $get_data = $_GET;
        unset($get_data['page']);
        unset($get_data['paged']);
        unset($get_data['orderby']);
        unset($get_data['order']);
        unset($get_data['prefilter']);

        $args_supp = array(
            'offset' => $offset,
            'limit' => $per_page,
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'id',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );

        $predifined_filters = isset($_GET['prefilter']) ? $_GET['prefilter'] : '';

        $resultats = AxianDDR::getby($get_data, $args_supp, $predifined_filters);

        $this->set_pagination_args( array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_id( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'addr_delete_term' .absint( $item->id ) );
        $title = '<strong>DDR-' . $item->id . '</strong>';

        $actions = [
			'view' => sprintf( '<a href="?page=%s&action=%s&id=%s">Afficher</a>', 'axian-ddr','view', absint( $item->id ) ),
            'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">Editer</a>', 'axian-ddr', 'edit', absint( $item->id ) ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s">Supprimer</a>', 'axian-ddr', 'delete', absint( $item->id ), $delete_nonce )
        ];

        return $title . $this->row_actions( $actions );
    }

}
