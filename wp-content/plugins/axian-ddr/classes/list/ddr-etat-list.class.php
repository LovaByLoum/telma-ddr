<?php
class AxianDDREtatList extends WP_Filter_List_Table{
    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste etat ticket',
            'plural'    => 'Liste etat tickets',
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
            case 'title':
                return $item->title;
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
            'title' => 'Titre de la demande',
        );

        return $columns;
    }

    /**
     * Fonction qui gère les données à afficher
     */
    function prepare_items($etat) {
        $this->_column_headers = $this->get_column_info();

        $per_page = 7;
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1 ) * $per_page;

        $get_data = $_GET;
        unset($get_data['page']);
        unset($get_data['paged']);
        unset($get_data['orderby']);
        unset($get_data['order']);

        $get_data['etat'] = $etat;

        $args_supp = array(
            'offset' => $offset,
            'limit' => $per_page,
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'id',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );


        $resultats = AxianDDR::getby($get_data, $args_supp);

        $this->set_pagination_args( array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_id( $item ) {
        global $current_user;

        $title = '<strong>DDR-' . $item->id . '</strong>';

        $actions = array();
        if ( current_user_can(DDR_CAP_CAN_VIEW_OTHERS_DDR) || ( current_user_can(DDR_CAP_CAN_VIEW_DDR) && $item->author_id == $current_user->ID ) ){
            $actions['view'] = sprintf( '<a href="?page=%s&action=%s&id=%s">Afficher</a>', 'axian-ddr','view', absint( $item->id ) );
        }

        if ( current_user_can(DDR_CAP_CAN_EDIT_OTHERS_DDR) || ( current_user_can(DDR_CAP_CAN_EDIT_DDR) && $item->author_id == $current_user->ID ) ){
            $post_data = AxianDDR::getbyId($item->id);
            if ( AxianDDRWorkflow::checkActionActeurInEtape($post_data['etape'], DDR_ACTION_UPDATE ) ){
                $actions['edit'] = sprintf( '<a href="?page=%s&action=%s&id=%s">Modifier</a>', 'axian-ddr', 'edit', absint( $item->id ) );
            }
        }

        return $title . $this->row_actions( $actions );
    }

}
