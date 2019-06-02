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
require_once('classes/user.class.php');
require_once('classes/workflow.class.php');
require_once('classes/main.class.php');
require_once('classes/historique.class.php');
require_once('classes/term.class.php');
require_once('classes/offre.class.php');
require_once('classes/ddr.class.php');
require_once('classes/administration.class.php');
require_once('classes/list/class-wp-filter-list-table.php');
require_once('classes/list/ddr-list.class.php');
require_once('classes/list/term-list.class.php');

register_activation_hook( __FILE__ , 'AxianDDRMain::install' );

global $axian_ddr_main;
$axian_ddr_main = new AxianDDRMain();

