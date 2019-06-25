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
require_once('classes/interim.class.php');
require_once('classes/ddr.class.php');
require_once('classes/administration.class.php');
require_once('classes/list/models/class-wp-filter-list-table.php');
//require_once('classes/list/models/class-wp-ajax-list-table.php');
require_once('classes/list/ddr-list.class.php');
require_once('classes/list/ddr-etat-list.class.php');
require_once('classes/list/historique-list.class.php');
require_once('classes/list/term-list.class.php');
require_once('classes/list/interim-list.class.php');
require_once('classes/mail.class.php');

register_activation_hook( __FILE__ , 'AxianDDRMain::install' );

global $axian_ddr_main, $axian_ddr_tasks, $axian_ddr_settings;;
$axian_ddr_main = new AxianDDRMain();

$axian_ddr_tasks = array(
    'daily_rappel' => isset($axian_ddr_settings['cron']['rappel_validation_cron_freq']) ? $axian_ddr_settings['cron']['rappel_validation_cron_freq'] : 60*60*24,
    'interim' => isset($axian_ddr_settings['cron']['interim_cron_freq']) ? $axian_ddr_settings['cron']['interim_cron_freq'] : 60*60*24,
);

//tache cron pour envoie mail de rappel de validation
add_filter('cron_schedules', 'axian_ddr_add_scheduled');
function axian_ddr_add_scheduled($schedules) {
    global $axian_ddr_tasks;
    foreach ( $axian_ddr_tasks as $schedule => $value ){
        $schedules[$schedule] = array(
            'interval' => $value,
            'display' => $schedule
        );
    }
    return $schedules;
}

foreach ( $axian_ddr_tasks as $schedule => $value ){
    // Cron action
    $funcname =  'axian_ddr_' . str_replace('-', '_', $schedule ) . '_action';

    if ( !wp_next_scheduled( $funcname, array('schedule' => $schedule) ) ) {

        if($schedule == 'axian_ddr_daily_rappel') {
            $time = strtotime("9:00:00");
        }
        else{
            $time = time();
        }
        wp_schedule_event( $time, $schedule, $funcname, array('schedule' => $schedule) );
    }
    add_action( $funcname, 'axian_ddr_cron_callback' );
}

function axian_ddr_cron_callback($current_schedule){
    //notification rappel
    if ( 'daily_rappel' ==  $current_schedule ){
        $validators = AxianDDRUser::getUserValidator();
        if( !empty($validators) ){
            foreach($validators as $value){
                AxianDDRMail::sendRappel($value['id']);
            }
        }

    //gestion interim
    }elseif ( 'interim' ==  $current_schedule ){
        AxianDDRInterim::manageInterim();
    }

}

add_action('admin_init', 'axian_ddr_force_run_cron');
function axian_ddr_force_run_cron(){
    if ( isset($_GET['forceruncron']) && $_GET['forceruncron'] == 'interim' && current_user_can(DDR_CAP_CAN_ADMIN_INTERIM) ){
        AxianDDRInterim::manageInterim();
        wp_safe_redirect('admin.php?page=axian-ddr-admin&tab=cron&msg=cron-forced');die;
    }
    if ( isset($_GET['forceruncron']) && $_GET['forceruncron'] == 'daily_rappel' && current_user_can(DDR_CAP_CAN_ADMIN_DDR) ){
        $validators = AxianDDRUser::getUserValidator();
        if( !empty($validators) ){
            foreach($validators as $value){
                AxianDDRMail::sendRappel($value['id']);
            }
        }
        wp_safe_redirect('admin.php?page=axian-ddr-admin&tab=cron&msg=cron-forced');die;
    }
}
