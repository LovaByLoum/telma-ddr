<?php
class AxianDDRHistoriqueList extends WP_Filter_List_Table{

    function __construct(){
        parent::__construct( array(
            'singular'  => 'Liste des historiques DDR',
            'plural'    => 'Liste des historiques DDR',
            'ajax'      =>  false
        ) );

        $this->filter_position = 'top';
        //$this->filter_position = 'table';

    }


    public static function load_hook(){
        global $DDRHistoriqueListTable;

        $option = 'per_page';
        $args = array(
            'label' => 'Historique DDR',
            'default' => 20,
            'option' => 'ddr_historique_per_page'
        );
        add_screen_option( $option, $args );

        $DDRHistoriqueListTable = new AxianDDRHistoriqueList();
    }

    function no_items() {
        _e( 'Aucun résultat.' );
    }

    function column_export_id( $item ){
        return 'DDR-' . $item->id;
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
            case 'traitement':
                return AxianDDRHistorique::getDelaiEtape($item->id, DDR_STEP_VALIDATION_1, DDR_STEP_PUBLISH) . '<br><a href="javascript:;" class="open-details-delai">+ détails</a>' . AxianDDRHistoriqueList::getAllDelai($item->id);
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
            'etat' => array('etat',false),
            'etape' => array('etape',false),
            'created' => array('created',false),
            'societe' => array('societe',false),
        );

        return $sortable_columns;
    }

    function get_filterable_columns() {
        global $axian_ddr;
        $filterable_columns = array(
            'id' => array('type' => 'text'),
            'title' => array('type' => 'text'),
            'type' => array('type' => 'select', 'options' => AxianDDR::$types_demande),
            'etat' => array('type' => 'select', 'options' => AxianDDR::$etats),
            'etape' => array('type' => 'select', 'options' => AxianDDR::$etapes),
            'created' => array('type' => 'daterangepicker'),
            'societe' => array('type' => 'autocompletion', 'source' => 'entreprise'),
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
            'etat' => 'Etat',
            'etape' => 'Etape',
            'created' => 'Date de création',
            'societe' => 'Société',
            'traitement' => 'Temps de traitement total',
        );

        return $columns;
    }



    /**
     * Fonction qui gère les données à afficher
     */
    function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        $per_page = $this->get_items_per_page('ddr_historique_per_page', 20);
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1 ) * $per_page;

        $get_data = $_GET;
        unset($get_data['page']);
        unset($get_data['paged']);
        unset($get_data['orderby']);
        unset($get_data['order']);

        $args_supp = array(
            'offset' => $offset,
            'limit' => $per_page,
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'id',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'ASC',
        );

        $resultats = AxianDDRHistorique::getby($get_data, $args_supp);

        $this->set_pagination_args( array(
            'total_items' => $resultats['count'],
            'per_page'    => $per_page
        ));

        $this->query_export = current_user_can(DDR_CAP_CAN_EXPORT_DDR) ? $resultats["query_export"] : '';
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

    function column_export_traitement($item){
        return AxianDDRHistorique::getDelaiEtape($item->id, DDR_STEP_VALIDATION_1, DDR_STEP_PUBLISH);
        //return AxianDDRHistorique::getDelaiEtape($item->id, DDR_STEP_VALIDATION_1, DDR_STEP_PUBLISH) . " (Details : " . AxianDDRHistoriqueList::getAllDelai($item->id, 'string');
    }

    function getAllDelai( $ddr_id, $format = 'html' ){
        $etapes = AxianDDRWorkflow::$etapes;
        if ( $format == 'html' ):
            ob_start();
            ?>
            <fieldset class="ddr-histrotique-delai-box">
                <a href="javascript:;" class="close-details-delai" style="float:right;">x Fermer</a>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="libelle">Etape</th>
                        <th class="libelle">Temps de traitement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($etapes as $etape_numero => $step_object):
                        if ( isset($etapes[$etape_numero-1]) ) :
                            $step_avant = $etapes[$etape_numero-1];
                            $step_current = $step_object;
                            ?>
                            <tr class=" <?php echo ($etape_numero % 2 == 0) ? 'odd' : 'even';?> ">
                                <td valign="top">
                                    <?php echo AxianDDR::$etapes[$step_current['etape']];?>
                                </td>
                                <td>
                                    <?php echo AxianDDRHistorique::getDelaiEtape($ddr_id, $step_avant['etape'], $step_current['etape'] );?>
                                </td>
                            </tr>
                        <?php endif;?>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </fieldset>
            <?php
            return ob_get_clean();
        elseif ( $format == 'string' ) :
            $str = '';
            foreach($etapes as $etape_numero => $step_object):
                if ( isset($etapes[$etape_numero-1]) ) :
                    $step_avant = $etapes[$etape_numero-1];
                    $step_current = $step_object;
                    $str.= AxianDDR::$etapes[$step_current['etape']] . ' en ' . AxianDDRHistorique::getDelaiEtape($ddr_id, $step_avant['etape'], $step_current['etape'] ) . ", ";
                endif;
            endforeach;
            return $str;
        endif;
    }
}
