<?php
/*
Plugin Name: Axian DDR
Description: Axian Demande de Recrutement
Version: 1.0
Author: Njaratiana
*/

define ( 'ADDR_PATH', dirname(__FILE__) );
require_once ('inc/constantes.inc.php');
require_once('classes/main.class.php');
require_once('classes/label.class.php');

register_activation_hook( __FILE__ , 'axian_ddr_active' );


function axian_ddr_active(){
    //install base
}

new Main_DDR();

