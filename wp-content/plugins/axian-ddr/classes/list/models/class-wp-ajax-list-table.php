<?php
/**
 * WP List Table Ajax Sample
 *
 * WP List Table Ajax Sample is a WordPress Plugin example of WP_List_Table
 * AJAX implementation. This plugin loads datasets completly in async.
 * It is a fork of Charlie MERLAND's Custom List Table Example plugin.
 *
 * Plugin Name: WP List Table Ajax Sample
 * Plugin URI:  https://github.com/debba/wp-list-table-ajax-sample
 * Description: A sample plugin for studying how can creating a AJAX List Table fully asynchronous using WP_List_Table
 * Version:     1.0
 * Author:      Andrea Debernardi
 * Author URI:  https://www.dueclic.com
 * License:     GPL-2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/debba/wp-list-table-ajax-sample
 */
/**
Copyright 2016 Andrea Debernardi (email : andrea.debernardi@dueclic.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
/**
 *
 * WP_List_Table class inclusion
 *
 */
if ( ! class_exists( 'WP_List_Table' ) )
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
/**
 *
 * As Charlie suggested in its plugin https://github.com/Askelon/Custom-AJAX-List-Table-Example
 * it's better to set the error_reporting in order to hiding notices to avoid AJAX errors
 *
 */
error_reporting( ~E_NOTICE );
class WP_Ajax_List_Table extends WP_List_Table {

    /**
     * @Override of prepare_items method
     *
     */
    function prepare_items() {
        /**
         * How many records for page do you want to show?
         */
        $per_page = 5;
        /**
         * Define of column_headers. It's an array that contains:
         * columns of List Table
         * hiddens columns of table
         * sortable columns of table
         * optionally primary column of table
         */
        $columns  = $this->get_columns();
        $hidden   = $this->hidden_columns;
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        /**
         * Following lines are only a sample with a static array
         * in a real situation you can get data
         * from a REST architecture or from database (using $wpdb)
         */
        $data = $this->sample_data;
        function usort_reorder( $a, $b ) {
            $orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'title';
            $order = ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'asc';
            $result = strcmp( $a[ $orderby ], $b[ $orderby ] );
            return ( 'asc' === $order ) ? $result : -$result;
        }
        usort( $data, 'usort_reorder' );
        /**
         * Get current page calling get_pagenum method
         */
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        /**
         * Call to _set_pagination_args method for informations about
         * total items, items for page, total pages and ordering
         */
        $this->set_pagination_args(
            array(
                'total_items'	=> $total_items,
                'per_page'	    => $per_page,
                'total_pages'	=> ceil( $total_items / $per_page ),
                'orderby'	    => ! empty( $_REQUEST['orderby'] ) && '' != $_REQUEST['orderby'] ? $_REQUEST['orderby'] : 'title',
                'order'		    => ! empty( $_REQUEST['order'] ) && '' != $_REQUEST['order'] ? $_REQUEST['order'] : 'asc'
            )
        );
    }

    /**
     * @Override of display method
     */
    function display() {
        /**
         * Adds a nonce field
         */
        wp_nonce_field( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );
        /**
         * Adds field order and orderby
         */
        echo '<input type="hidden" id="order" name="order" value="' . $this->_pagination_args['order'] . '" />';
        echo '<input type="hidden" id="orderby" name="orderby" value="' . $this->_pagination_args['orderby'] . '" />';
        parent::display();
    }

    /**
     * @Override ajax_response method
     */
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
}

function wp_list_page() {
    ?>

    <div class="wrap">

        <h2>WP List Table Ajax Sample</h2>

        <form id="email-sent-list" method="get">

            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
            <input type="hidden" name="order" value="<?php echo $_REQUEST['order']; ?>" />
            <input type="hidden" name="orderby" value="<?php echo $_REQUEST['orderby']; ?>" />

            <div id="ts-history-table" style="">
                <?php
                wp_nonce_field( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );
                ?>
            </div>

        </form>

    </div>

<?php
}

/**
 * Action wp_ajax for fetching ajax_response
 */
function _ajax_fetch_sts_history_callback() {
    $wp_list_table = new My_List_Table();
    $wp_list_table->ajax_response();
}
add_action( 'wp_ajax__ajax_fetch_sts_history', '_ajax_fetch_sts_history_callback' );

/**
 * Action wp_ajax for fetching the first time table structure
 */
function _ajax_sts_display_callback() {
    check_ajax_referer( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce', true );
    $wp_list_table = new My_List_Table();
    $wp_list_table->prepare_items();
    ob_start();
    $wp_list_table->display();
    $display = ob_get_clean();
    die(
    json_encode(array(
        "display" => $display
    ))
    );
}
add_action('wp_ajax__ajax_sts_display', '_ajax_sts_display_callback');

/**
 * fetch_ts_script function based from Charlie's original function
 */
function fetch_ts_script() {
    $screen = get_current_screen();
    /**
     * For testing purpose, finding Screen ID
     */
    ?>

    <script type="text/javascript">console.log("<?php echo $screen->id; ?>")</script>

    <?php
    if ( $screen->id != "toplevel_page_wp_ajax_list_test" )
        return;
    ?>

    <script type="text/javascript">
        (function ($) {
            list = {
                /** added method display
                 * for getting first sets of data
                 **/
                display: function() {
                    $.ajax({
                        url: ajaxurl,
                        dataType: 'json',
                        data: {
                            _ajax_custom_list_nonce: $('#_ajax_custom_list_nonce').val(),
                            action: '_ajax_sts_display'
                        },
                        success: function (response) {
                            $("#ts-history-table").html(response.display);
                            $("tbody").on("click", ".toggle-row", function(e) {
                                e.preventDefault();
                                $(this).closest("tr").toggleClass("is-expanded")
                            });
                            list.init();
                        }
                    });
                },
                init: function () {
                    var timer;
                    var delay = 500;
                    $('.tablenav-pages a, .manage-column.sortable a, .manage-column.sorted a').on('click', function (e) {
                        e.preventDefault();
                        var query = this.search.substring(1);
                        var data = {
                            paged: list.__query( query, 'paged' ) || '1',
                            order: list.__query( query, 'order' ) || 'asc',
                            orderby: list.__query( query, 'orderby' ) || 'title'
                        };
                        list.update(data);
                    });
                    $('input[name=paged]').on('keyup', function (e) {
                        if (13 == e.which)
                            e.preventDefault();
                        var data = {
                            paged: parseInt($('input[name=paged]').val()) || '1',
                            order: $('input[name=order]').val() || 'asc',
                            orderby: $('input[name=orderby]').val() || 'title'
                        };
                        window.clearTimeout(timer);
                        timer = window.setTimeout(function () {
                            list.update(data);
                        }, delay);
                    });
                    $('#email-sent-list').on('submit', function(e){
                        e.preventDefault();
                    });
                },
                /** AJAX call
                 *
                 * Send the call and replace table parts with updated version!
                 *
                 * @param    object    data The data to pass through AJAX
                 */
                update: function (data) {
                    $.ajax({
                        url: ajaxurl,
                        data: $.extend(
                            {
                                _ajax_custom_list_nonce: $('#_ajax_custom_list_nonce').val(),
                                action: '_ajax_fetch_sts_history',
                            },
                            data
                        ),
                        success: function (response) {
                            var response = $.parseJSON(response);
                            if (response.rows.length)
                                $('#the-list').html(response.rows);
                            if (response.column_headers.length)
                                $('thead tr, tfoot tr').html(response.column_headers);
                            if (response.pagination.bottom.length)
                                $('.tablenav.top .tablenav-pages').html($(response.pagination.top).html());
                            if (response.pagination.top.length)
                                $('.tablenav.bottom .tablenav-pages').html($(response.pagination.bottom).html());
                            list.init();
                        }
                    });
                },
                /**
                 * Filter the URL Query to extract variables
                 *
                 * @see http://css-tricks.com/snippets/javascript/get-url-variables/
                 *
                 * @param    string    query The URL query part containing the variables
                 * @param    string    variable Name of the variable we want to get
                 *
                 * @return   string|boolean The variable value if available, false else.
                 */
                __query: function (query, variable) {
                    var vars = query.split("&");
                    for (var i = 0; i < vars.length; i++) {
                        var pair = vars[i].split("=");
                        if (pair[0] == variable)
                            return pair[1];
                    }
                    return false;
                },
            }
            list.display();
        })(jQuery);
    </script>
<?php
}
add_action('admin_footer', 'fetch_ts_script');