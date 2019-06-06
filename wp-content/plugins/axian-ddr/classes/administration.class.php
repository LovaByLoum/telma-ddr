<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 15/05/19
 * Time: 10:10
 * To change this template use File | Settings | File Templates.
 */

global $axian_ddr_settings;
class AxianDDRAdministration{

    public $fields;

    public function __construct() {

        //fields general
        $this->fields['general']['max_upload_size'] = array(
            'label' => 'Max upload size',
            'type' => 'text',
            'name' => 'axian_ddr_settings[general][max_upload_size]',
            'description' => 'en MegaOctet'
        );

        //fields validation
        foreach( AxianDDR::$etapes as $key => $value ){
            if ( DDR_STEP_CREATE != $key ){
                $this->fields['validation'][$key] = array(
                    'label' => $value,
                    'type' => 'autocompletion',
                    'source' => 'user',
                    'name' => 'axian_ddr_settings[validation]['.$key.']',
                );
            }
        }
    }

    public static function template(){
        include AXIAN_DDR_PATH . '/templates/administration/admin.tpl.php';
    }

    public static function get_settings() {
        return get_option( DDR_SETTINGS_NAME, array() );
    }

    public static function submit_settings() {
        global $axian_ddr_settings;
        $axian_ddr_settings = self::get_settings();

        if ( isset( $_POST[DDR_SETTINGS_NAME] ) ){
            $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';

            if ( isset( $_POST[DDR_SETTINGS_NAME][$active_tab]) ){
                $post_data = $_POST[DDR_SETTINGS_NAME][$active_tab];
                $axian_ddr_settings[$active_tab] = $post_data;
                update_option( DDR_SETTINGS_NAME, $axian_ddr_settings );
            }

            return array(
                'code' => 'updated',
                'msg' => 'Enregistrement effectué avec succés.',
            );
        }
    }

}
global $axian_ddr_administration;
$axian_ddr_administration = new AxianDDRAdministration();