<?php
class AxianDDRWorkflowList extends WP_Filter_List_Table
{
    function __construct()
    {
        parent::__construct(array(
            'singular'  => 'Liste des workflows',
            'plural'    => 'Liste des workflows',
            'ajax'      =>  false
        ));
    }
    public static function load_hook()
    {
        global $DDRListTable;

        $option = 'per_page';
        $args = array(
            'label' => 'DDR',
            'default' => 20,
            'option' => 'ddr_per_page'
        );
        add_screen_option($option, $args);

        $DDRListTable = new AxianDDRWorkflowList();
    }


    function no_items()
    {
        _e('Aucun résultat.');
    }

    /**
     * Fonction qui gère les valeurs qui doivent être affichées pour chaque colonne.
     */
    function column_default($item, $column_name)
    {

        switch ($column_name) {
            case 'nom':
                return $item->nom;
                break;
            case 'createur':
                return $item->createur;
                break;
            case 'societe':
                return $item->societe;
                break;
            case 'statut':
                return $item->statut;
                break;
            case 'date_creation':
                return $item->date_creation;
                break;
            case 'date_modification':
                return $item->date_modification;
                break;
            case 'type_ticket':
                return $item->type_ticket;
                break;
            case 'etat':
                return $item->etat;
                break;
            case 'etape':
                return $item->etape;
                break;
            case 'role':
                return $item->role;
                break;
            default:
                return print_r($item, true);
        }
    }

    /**
     * Fonction qui gère les colonnes qui sont sortable.
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'nom' => array('nom', false),
            'createur' => array('createur', false),
            'societe' => array('type' => 'autocompletion', 'source' => 'entreprise'),
            'statut' => array('statut', false),
            'date_creation' => array('date_creation', false),
            'date_modification' => array('date_modification', false),
            'type_ticket' => array('type_ticket', false),
            'etat' => array('etat', false),
            'etape' => array('etape', false),
            'role' => array('role', false),
        );

        return $sortable_columns;
    }

    function extra_tablenav($which)
    { }

    /**
     * Fonction qui gère les colonnes à utiliser.
     */
    function get_columns()
    {

        $columns = array(
            'nom' => 'Nom',
            'createur' => 'Créateur',
            'societe' => 'Société',
            'statut' => 'Statut',
            'date_creation' => 'Date de création',
            'date_modification' => 'Date de modification',
            'type_ticket' => 'Type de ticket',
            'etat' => 'Etat',
            'etape' => 'Etape',
            'role' => 'role',
        );

        return $columns;
    }

    /**
     * Fonction qui gère les données à afficher
     */
    function prepare_items()
    {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page = 50;

        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $args = array(
            'offset' => $offset,
            'limit' => $per_page,
            'type' => isset($_GET['type']) ? $_GET['type'] : 'tous',
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'nom',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );

        $resultats = AxianDDRWorkflow::getby($args);
        $this->set_pagination_args(array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->items = $resultats["items"];
    }

    function column_nom($item)
    {

        // create a nonce
        $delete_nonce = wp_create_nonce('addr_delete_workflow' . absint($item->id));
        $title = '<strong>' . $item->nom . '</strong>';

        $actions = [
            'edit' => sprintf('<a href="?page=%s&tab=term&action=%s&id=%s">Modifier</a>', esc_attr($_REQUEST['page']), 'edit', absint($item->id)),
            'delete' => sprintf('<a href="?page=%s&tab=workflow&action=%s&id=%s&_wpnonce=%s">Supprimer</a>', esc_attr($_REQUEST['page']), 'delete', absint($item->id), $delete_nonce)
        ];

        return $title . $this->row_actions($actions);
    }

    public static function delete($id)
    {
        global $wpdb;
        $result = $wpdb->delete(TABLE_AXIAN_DDR_WORKFLOW, array('id' => $id));

        return $result;
    }
}
