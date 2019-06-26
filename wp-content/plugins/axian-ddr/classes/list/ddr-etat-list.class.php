<?php
class AxianDDREtatList extends WP_List_Table{

    public $etat;
    public $total_items;
    function __construct( $etat = null ){
        parent::__construct( array(
            'singular'  => 'Liste des demandes par état',
            'plural'    => 'Liste des demandes par état',
            'ajax'      =>  true
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

    function display() {

        echo '<div class="wp-ajax-list-table">';

        wp_nonce_field( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );

        echo '<input id="order" type="hidden" name="order" value="' . $this->_pagination_args['order'] . '" />';
        echo '<input id="orderby" type="hidden" name="orderby" value="' . $this->_pagination_args['orderby'] . '" />';
        echo '<input id="etat" type="hidden" name="etat" value="' . $this->etat . '" />';

        parent::display();

        echo '</div>';
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
            //'etat' => 'Etat',
            'etape' => 'Etape',
            //'created' => 'Date de création',
            'societe' => 'Société',
        );

        return $columns;
    }


    function ajax_response() {

        check_ajax_referer( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );

        $this->prepare_items();

        extract( $this->_args );
        extract( $this->_pagination_args, EXTR_SKIP );

        ob_start();
        if ( ! empty( $_REQUEST['no_placeholder'] ) )
            $this->display_rows();
        else
            $this->display_rows_or_placeholder();
        $rows = ob_get_clean();

        ob_start();
        $this->print_column_headers();
        $headers = ob_get_clean();

        ob_start();
        $this->pagination('top');
        $pagination_top = ob_get_clean();

        ob_start();
        $this->pagination('bottom');
        $pagination_bottom = ob_get_clean();

        $response = array( 'rows' => $rows );
        $response['pagination']['top'] = $pagination_top;
        $response['pagination']['bottom'] = $pagination_bottom;
        $response['column_headers'] = $headers;

        if ( isset( $total_items ) )
            $response['total_items_i18n'] = sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) );

        if ( isset( $total_pages ) ) {
            $response['total_pages'] = $total_pages;
            $response['total_pages_i18n'] = number_format_i18n( $total_pages );
        }

        die( json_encode( $response ) );
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

        $per_page = 5;
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1 ) * $per_page;

        $get_data = $_GET;
        unset($get_data['page']);
        unset($get_data['paged']);
        unset($get_data['orderby']);
        unset($get_data['order']);

        $orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'id';
        //If no order, default to asc
        $order = ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'DESC';

        $args_supp = array(
            'offset' => $offset,
            'limit' => $per_page,
            'orderby' => $orderby,
            'order' => $order,
        );

        //filter by etat
        if  ( $this->etat ){
            $get_data['etat'] = $this->etat;
        }

        $resultats = AxianDDR::getby($get_data, $args_supp);
        $total_items = $resultats['count'];
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages'   => ceil( $total_items / $per_page ),
            // Set ordering values if needed (useful for AJAX)
            'orderby'   => ! empty( $_REQUEST['orderby'] ) && '' != $_REQUEST['orderby'] ? $_REQUEST['orderby'] : 'title',
            'order'     => ! empty( $_REQUEST['order'] ) && '' != $_REQUEST['order'] ? $_REQUEST['order'] : 'asc'
        ));

        $this->items = $resultats["items"];
        $this->total_items = $total_items;
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

    public static function admin_footer(){


        $screen = get_current_screen();
        if ( 'toplevel_page_axian-ddr-etat' != $screen->id )
            return false;

        ?>
        <script>
            (function($) {

                list = {
                    init: function() {
                        var timer;
                        var delay = 500;

                        // Pagination links, sortable link
                        $('.tablenav-pages a, .manage-column.sortable a, .manage-column.sorted a').on('click', function(e) {
                            var table_wrapper = $(this).parents('.wp-ajax-list-table');

                            // We don't want to actually follow these links
                            e.preventDefault();
                            // Simple way: use the URL to extract our needed variables

                            var query = this.search.substring( 1 );

                            var data = {
                                paged: list.__query( query, 'paged' ) || '1',
                                order: list.__query( query, 'order' ) || 'DESC',
                                orderby: list.__query( query, 'orderby' ) || 'id',
                                etat: $('input[name=etat]', table_wrapper).val()
                            };
                            list.update( data, table_wrapper );
                        });

                        // Page number input
                        $('input[name=paged]').on('keyup', function(e) {
                            var table_wrapper = $(this).parents('.wp-ajax-list-table');

                            if ( 13 == e.which )
                                e.preventDefault();

                            // This time we fetch the variables in inputs
                            var data = {
                                paged: parseInt( $('input[name=paged]', table_wrapper).val() ) || '1',
                                order: $('input[name=order]', table_wrapper).val() || 'DESC',
                                orderby: $('input[name=orderby]', table_wrapper).val() || 'id',
                                etat: $('input[name=etat]', table_wrapper).val()
                            };

                            window.clearTimeout( timer );
                            timer = window.setTimeout(function() {
                                list.update( data, table_wrapper );
                            }, delay);
                        });
                    },

                    update: function( data, wrapper ) {
                        wrapper.addClass('loading');
                        $.ajax({
                            // /wp-admin/admin-ajax.php
                            url: ajaxurl,
                            // Add action and nonce to our collected data
                            data: $.extend(
                                {
                                    _ajax_custom_list_nonce: $('#_ajax_custom_list_nonce', wrapper).val(),
                                    action: '_ajax_fetch_custom_list'
                                },
                                data
                            ),
                            // Handle the successful result
                            success: function( response ) {

                                // WP_List_Table::ajax_response() returns json
                                var response = $.parseJSON( response );

                                // Add the requested rows
                                if ( response.rows.length )
                                    $('#the-list', wrapper).html( response.rows );
                                // Update column headers for sorting
                                if ( response.column_headers.length )
                                    $('thead tr, tfoot tr', wrapper).html( response.column_headers );
                                // Update pagination for navigation
                                if ( response.pagination.bottom.length )
                                    $('.tablenav.top .tablenav-pages', wrapper).html( $(response.pagination.top).html() );
                                if ( response.pagination.top.length )
                                    $('.tablenav.bottom .tablenav-pages', wrapper).html( $(response.pagination.bottom).html() );

                                wrapper.removeClass('loading');

                                // Init back our event handlers
                                list.init();
                            }
                        });
                    },

                    __query: function( query, variable ) {

                        var vars = query.split("&");
                        for ( var i = 0; i <vars.length; i++ ) {
                            var pair = vars[ i ].split("=");
                            if ( pair[0] == variable )
                                return pair[1];
                        }
                        return false;
                    }
                }

                // Show time!
                list.init();

            })(jQuery);
        </script>
        <?php
    }

}

function _ajax_fetch_custom_list_callback() {
    $etat = isset($_REQUEST['etat']) ? $_REQUEST['etat'] : '';
    $wp_list_table = new AxianDDREtatList($etat);
    $wp_list_table->ajax_response();
}
add_action('wp_ajax__ajax_fetch_custom_list', '_ajax_fetch_custom_list_callback');

add_action('admin_footer', 'AxianDDREtatList::admin_footer');



