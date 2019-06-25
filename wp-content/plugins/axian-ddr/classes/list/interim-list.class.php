<?php
class AxianDDRInterimList extends WP_Filter_List_Table{
    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste des interims',
            'plural'    => 'Liste des interims',
            'ajax'      =>  false
        ) );

        $this->filter_position = 'top';
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
            case 'creator_id':
            case 'interim_id':
            case 'collaborator_id':
                $user = AxianDDRUser::getById($item->$column_name);
                return $user->display_name;
                break;
            case 'date_debut':
            case 'date_fin':
                return (!empty($item->$column_name) ? axian_ddr_convert_to_human_date($item->$column_name) : '');
                break;
            case 'created':
            case 'modified':
                return (!empty($item->$column_name) ? axian_ddr_convert_to_human_datetime($item->$column_name) : '');
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
            'creator_id' => array('creator_id',false),
            'interim_id' => array('interim_id',false),
            'collaborator_id' => array('collaborator_id',false),
            'date_debut' => array('date_debut',false),
            'date_fin' => array('date_fin',false),
            'created' => array('created',false),
            'modified' => array('created',false),
        );

        return $sortable_columns;
    }

    function get_filterable_columns() {
        $filterable_columns = array(
            'interim_id' => array('type' => 'autocompletion', 'source' => 'user'),
            'collaborator_id' => array('type' => 'autocompletion', 'source' => 'user'),
            'date_debut' => array('type' => 'datepicker'),
            'date_fin' => array('type' => 'datepicker'),
            'created' => array('type' => 'datepicker'),
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
            'collaborator_id' => 'Collaborateur',
            'interim_id' => 'Intérim',
            'date_debut' => 'Date de début',
            'date_fin' => 'Date de fin',
            'creator_id' => 'Créateur',
            'created' => 'Date de création',
            'modified' => 'Date de modification',
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

        $per_page = 25;

        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $get_data = $_GET;
        unset($get_data['page']);
        unset($get_data['paged']);
        unset($get_data['orderby']);
        unset($get_data['order']);
        unset($get_data['msg']);

        $supp_args = array(
            'offset' => $offset,
            'limit' => $per_page,
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'id',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );

        $resultats = AxianDDRInterim::getby( $get_data, $supp_args );
        $this->set_pagination_args( array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_collaborator_id( $item ) {

        $user = AxianDDRUser::getById($item->collaborator_id);

        $title = '<strong>' . $user->display_name . '</strong>';

        $actions = [
            'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">Modifier</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item->id ) ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s" class="confirm-before">Supprimer</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ) )
        ];

        return $title . $this->row_actions( $actions );
    }

}
