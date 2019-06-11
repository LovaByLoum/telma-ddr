<?php
/*
Plugin Name: Axian DDR
Description: Axian Demande de Recrutement
Version: 1.0
Author: Njaratiana
*/

define ( 'AXIAN_DDR_PATH', dirname(__FILE__) );
define ( 'AXIAN_DDR_URL', plugin_dir_url(__FILE__));
require_once('utils/functions.utils.php');
require_once ('inc/constantes.inc.php');
require_once('classes/term.class.php');
require_once('classes/user.class.php');
require_once('classes/workflow.class.php');
require_once('classes/main.class.php');
require_once('classes/historique.class.php');

require_once('classes/offre.class.php');
require_once('classes/ddr.class.php');
require_once('classes/administration.class.php');
require_once('classes/list/class-wp-filter-list-table.php');
require_once('classes/list/ddr-list.class.php');
require_once('classes/list/term-list.class.php');
require_once('classes/mail.class.php');

register_activation_hook( __FILE__ , 'AxianDDRMain::install' );

global $axian_ddr_main;
$axian_ddr_main = new AxianDDRMain();

//tache cron pour envoie mail de rappel de validation
add_filter('cron_schedules', 'axian_ddr_add_scheduled_interval');
function axian_ddr_add_scheduled_interval($schedules) {
    $schedules['axian-ddr-daily'] = array('interval'=>60, 'display'=>'Once 1 day');
    return $schedules;
}

if (!wp_next_scheduled('axian_ddr_daily_task')) {
    wp_schedule_event(time(), 'axian-ddr-daily', 'axian_ddr_daily_task');
}
add_action ( 'axian_ddr_daily_task', 'axian_ddr_send_rappel' );
function axian_ddr_send_rappel(){
    $validators = AxianDDRUser::getUserValidator();
    if( !empty($validators) ){
        foreach($validators as $value){
            AxianDDRMail::sendRappel($value['id']);
        }
    }
}
