<?php
/*
Plugin Name: Axian DDR
Description: Axian Demande de Recrutement
Version: 1.0
Author: Njaratiana
*/

require_once ('inc/constantes.inc.php');
require_once('classes/main.class.php');

register_activation_hook( __FILE__ , 'Axian_DDR::activate' );

new Axian_DDR();


