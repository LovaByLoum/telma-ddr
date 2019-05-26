<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class WP_Filter_List_Table extends WP_List_Table{
    function __construct( $args = array() ){
        parent::__construct($args);
    }

    /**
     * Get a list of filterable columns. The format is:
     * 'internal-name' => array('type' => 'text')
     * 'internal-name' => array('type' => 'datepicker')
     * 'internal-name' => array('type' => 'select', 'options' => array('key'=>'value','key'=>'value',...))
     */
    public function get_filterable_columns() {
        return array();
    }

    public function display_styles(){
        ?>
        <style>
            .filter-button.button{
                padding-top: 5px!important;
            }
            input.filter-text{
                padding: 5px!important;
                width: 100%;
            }
            select.filter-select{
                padding: 5px!important;
                width: 100%;
            }
        </style>
        <?php
    }

    public function display_scripts(){

    }

    public function display() {
        $singular = $this->_args['singular'];

        $this->display_styles();
        $this->display_scripts();
        $this->display_tablenav('bottom');

        $this->screen->render_screen_reader_content( 'heading_list' );
        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
            <thead>
            <tr>
                <?php $this->print_column_headers(); ?>
            </tr>
            <tr>
                <?php $this->print_filter_headers(); ?>
            </tr>
            </thead>

            <tbody id="the-list"<?php
            if ( $singular ) {
                echo " data-wp-lists='list:$singular'";
            } ?>>
            <?php $this->display_rows_or_placeholder(); ?>
            </tbody>

            <tfoot>
            <tr>
                <?php $this->print_column_headers( false ); ?>
            </tr>
            </tfoot>

        </table>
        <?php
        $this->display_tablenav( 'bottom' );
    }

    public function print_filter_headers() {
        $filterable_columns = $this->get_filterable_columns();
        if ( empty($filterable_columns) ) return;

        list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();

        $count_col = 0;
        $button_search = "<button type='submit' class='filter-button button dashicons-before dashicons-search'></button>";
        foreach ( $columns as $column_key => $column_display_name ) {
            $class = array(
                'manage-column',
                "column-$column_key",
                'filter-column',
                "filter-column-$column_key"
            );

            if ( in_array( $column_key, $hidden ) ) {
                $class[] = 'hidden';
            }

            if ( 'cb' === $column_key )
                $class[] = 'check-column';

            if ( $column_key === $primary ) {
                $class[] = 'column-primary';
            }


            $tag = ( 'cb' === $column_key ) ? 'td' : 'th';
            $scope = ( 'th' === $tag ) ? 'scope="col"' : '';
            $id = "id='filter-$column_key'";

            if ( !empty( $class ) )
                $class = "class='" . join( ' ', $class ) . "'";

            if ( array_key_exists($column_key, $filterable_columns) ){
                $filter_info = $filterable_columns[$column_key];

                $current = isset($_REQUEST[$column_key]) && !empty($_REQUEST[$column_key]) ? $_REQUEST[$column_key] : '';

                switch( $filter_info['type'] ){
                    case 'text':
                        $filter_input = "<input type='text' value='$current' class='filter-text' name='$column_key'>";
                        break;
                    case 'autocompletion':
                        $filter_input =
                            "<input type='text' value='' class='filter-text ddr-autocompletion' data-source='" . $filter_info['source'] . "'>
                            <input type='hidden' value='$current' class='ddr-autocompletion-hidden' name='$column_key'>";
                        break;
                    case 'datepicker':
                        $filter_input = "<input type='text' value='$current' class='filter-text datepicker' name='$column_key' readonly>";
                        break;
                    case 'select':
                        $filter_input = "<select name='$column_key' class='filter-select'>";
                        $filter_input .= "<option value=''>Tous</option>";
                        if ( is_array($filter_info['options']) && !empty($filter_info['options']) ){
                            foreach( $filter_info['options'] as $value => $label ){
                                $selected = ($current==$value) ? 'selected' : '';
                                $filter_input .= "<option value='$value' $selected>$label</option>";
                            }
                        }
                        $filter_input .= "</select>";
                        break;
                }

            } else {
                $filter_input = '';
            }


            if ( ! empty( $columns['cb'] ) ) {
                if ( 'cb' === $column_key ){
                    echo "<$tag $scope $id $class>$button_search</$tag>";
                }
            } else {
                if ( $count_col == 0 ){
                    echo "<$tag $scope $id $class>$button_search$filter_input</$tag>";
                } else {
                    echo "<$tag $scope $id $class>$filter_input</$tag>";
                }
            }

            $count_col++;
        }
    }

}