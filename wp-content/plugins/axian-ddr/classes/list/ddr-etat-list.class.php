<?php
class AxianDDREtatList extends WP_List_Table{

    public $etat;
    function __construct( $etat ){
        parent::__construct( array(
            'singular'  => 'Liste des demandes par état',
            'plural'    => 'Liste des demandes  par état',
            'ajax'      =>  false
        ) );

        $this->etat = $etat;
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
                return (!empty($item->$column_name) ? axian_ddr_convert_to_human_datetime($item->$column_name) : '');
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
            'author_id' => array('author_id',false),
            'assignee_id' => array('assignee_id',false),
            'etat' => array('etat',false),
            'etape' => array('etape',false),
            'created' => array('created',false),
            'societe' => array('societe',false),
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
            'author_id' => 'Créateur',
            'assignee_id' => 'Attribution',
            'etat' => 'Etat',
            'etape' => 'Etape',
            'created' => 'Date de création',
            'societe' => 'Société',
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
        //var_dump($sortable);die;

        $per_page = 10;
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
            'order' => isset($_GET[$this->etat.'order']) ? $_GET[$this->etat.'order'] : 'ASC',
        );

        //filter by etat
        if  ( $this->etat ){
            $get_data['etat'] = $this->etat;
        }

        $resultats = AxianDDR::getby($get_data, $args_supp);
        $total_items = $resultats['count'];
        $this->set_pagination_args( array(
            'total_items' => $total_items,
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
