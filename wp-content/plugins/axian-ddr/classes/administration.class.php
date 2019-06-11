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
        $field_general = array(
            'max_upload_size' => array(
                'label' => 'Max upload size',
                'type' => 'text',
                'name' => 'axian_ddr_settings[general][max_upload_size]',
                'description' => 'en MegaOctet'
            ),
            'sujet_notification_validateur' => array(
                'label' => 'Sujet notification mail pour validateur',
                'type' => 'text',
                'name' => 'axian_ddr_settings[general][sujet_notification_validateur]',
                'description' => ''
            ),
            'content_notification_validateur' => array(
                'label' => 'Contenu notification mail pour validateur',
                'type' => 'textarea',
                'rows' => '8',
                'name' => 'axian_ddr_settings[general][content_notification_validateur]',
                'description' => 'Vous pouvez utiliser les jettons suivants: <pre>type de demande = [type de demande],
    lien vers la demande = [reference]</pre>'
            ),
            'sujet_notification_rappel' => array(
                'label' => 'Sujet notification de rappel',
                'type' => 'text',
                'name' => 'axian_ddr_settings[general][sujet_notification_rappel]',
                'description' => ''
            ),
            'content_notification_rappel' => array(
                'label' => 'Contenu notification de rappel',
                'type' => 'textarea',
                'rows' => '8',
                'name' => 'axian_ddr_settings[general][content_notification_rappel]',
                'description' => 'Vous pouvez utiliser les jettons suivants: <pre>nombre de ticket = [nb],
    lien tableau de bord = [ici]</pre>'
            ),

        );

        foreach($field_general as $field => $content){
            $this->fields['general'][$field] = $content;
        }

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