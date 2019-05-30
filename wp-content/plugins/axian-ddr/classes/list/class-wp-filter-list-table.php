<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class WP_Filter_List_Table extends WP_List_Table{
    public $filter_position = 'top';
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
                padding: 2px!important;
            }
            input.filter-text{
                padding: 5px!important;
                width: 100%;
            }
            select.filter-select{
                padding: 5px!important;
                width: 100%;
            }
            .oneline-filter{
                display: flex!important;
                flex-direction: row;
                justify-content: center;
                align-items: center;
            }
            #advanced-filter{
                clear: both!important;
                border-width: 1px;
                border-style: solid;
                border-color: #e5e5e5;
                padding: 20px;
                border-radius: 5px;
            }
            a[href='#advanced-filter']{
                float: right!important;
                font-size: 14px!important;
            }
            #advanced-filter .filter-button{
                margin-top: 20px!important;
            }
            #advanced-filter label{
                margin-top: 10px!important;
                font-size: 13px!important;
                margin-bottom: 5px!important;
            }
            #advanced-filter .chosen-container{
                width: 100%!important;
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
        if ( $this->filter_position == 'top' ){
            $this->print_filter_headers();
        }

        $this->display_tablenav('bottom');

        $this->screen->render_screen_reader_content( 'heading_list' );
        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
            <thead>
            <tr>
                <?php $this->print_column_headers(); ?>
            </tr>

            <?php if ( $this->filter_position == 'table' ) : ?>
            <tr>
                <?php $this->print_filter_table(); ?>
            </tr>
            <?php endif;?>

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

    public function print_filter_table() {
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

                $filter_input = $this->render_fields($column_key, $filter_info);

            } else {
                $filter_input = '';
            }


            if ( ! empty( $columns['cb'] ) ) {
                if ( 'cb' === $column_key ){
                    echo "<$tag $scope $id $class>$button_search</$tag>";
                }
            } else {
                if ( $count_col == 0 ){
                    echo "<$tag $scope $id $class><div class='oneline-filter'>$button_search$filter_input</div></$tag>";
                } else {
                    echo "<$tag $scope $id $class>$filter_input</$tag>";
                }
            }

            $count_col++;
        }
    }

    public function print_filter_headers() {
        $filterable_columns = $this->get_filterable_columns();
        if ( empty($filterable_columns) ) return;

        list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();

        echo '<a class="btn" data-toggle="collapse" href="#advanced-filter" role="button" aria-expanded="false" aria-controls="advanced-filter">+ Filtres avancées</a>';
        echo '<div id="advanced-filter" class="collapse clearfix">';
        echo '<div  class="row">';
        foreach ( $columns as $column_key => $column_display_name ) {

            if ( array_key_exists($column_key, $filterable_columns) ){
                $filter_info = $filterable_columns[$column_key];

                $filter_input = $this->render_fields($column_key, $filter_info);

                echo "<div class='col col-md-3 col-sm-6 col-xs-12 col-12'>
                        <label>" . $column_display_name . "</label>
                        $filter_input
                      </div>";
            }

        }
        echo '</div>';
        echo "<button type='submit' class='filter-button button dashicons-before dashicons-search'>Rechercher</button>";
        echo '</div>';
    }

    public function render_fields($column_key, $filter_info){
        $current = isset($_REQUEST[$column_key]) && !empty($_REQUEST[$column_key]) ? $_REQUEST[$column_key] : '';
        $filter_input = '';
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
            case 'daterangepicker':
                $filter_input = "<input type='text' value='$current' class='filter-text daterangepicker-input' name='$column_key' readonly>";
                break;
            case 'select':
                $filter_input = "<select name='$column_key' class='filter-select " . (isset($filter_info['search']) ? 'chosen-select':''). "' >";
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
        return $filter_input;
    }
}