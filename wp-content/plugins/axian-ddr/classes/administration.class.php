<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 15/05/19
 * Time: 10:10
 * To change this template use File | Settings | File Templates.
 */

class AxianDDRAdministration{

    public $fields;

    public function __construct() {

        if ( is_admin() ) {
            add_action( 'admin_init', array( $this, 'register_settings' ) );
        }

        //init admin fields
        foreach( AxianDDR::$etapes as $key => $value ){
            if ( DDR_STEP_CREATE != $key && DDR_STEP_PUBLISH != $key ){
                $this->fields[$key] = array(
                    'label' => $value,
                    'type' => 'autocompletion',
                    'source' => 'user',
                    'name' => 'theme_options['.$key.']',
                );
            }
        }
    }

    public static function template(){
        include AXIAN_DDR_PATH . '/templates/administration/admin.tpl.php';
    }

    /**
     * Register a setting and its sanitization callback.
     *
     * We are only registering 1 setting so we can store all options in a single option as
     * an array. You could, however, register a new setting for each option
     *
     * @since 1.0.0
     */
    public static function register_settings() {
        foreach( AxianDDR::$etapes as $key => $value ){
            if ( DDR_STEP_CREATE != $key && DDR_STEP_PUBLISH != $key ){
                add_option( $key , '', '', 'yes' );
            }
        }
    }


    /**
     * Returns single theme option
     *
     * @since 1.0.0
     */
    public static function get_theme_option( $id ) {
        return get_option( $id );
    }

    public function get_options(){
        $options = [];
        foreach( $this->fields as $key => $value ){
            $options[$value['name']] = get_option( $key );
        }

        return $options;
    }

    public static function submit_option() {
        if ( isset( $_POST['theme_options'] ) && !empty( $_POST['theme_options'] ) ){
            foreach( $_POST['theme_options'] as $option => $new_value ){
                update_option( $option, $new_value );
            }

            unset( $_POST['theme_options'] );
            return array(
                'code' => 'updated',
                'msg' => 'Enregistrement effectué avec succés.',
            );
        }
    }

}
global $axian_ddr_administration;
$axian_ddr_administration = new AxianDDRAdministration();