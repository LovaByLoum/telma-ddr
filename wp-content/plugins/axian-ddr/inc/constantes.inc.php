<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Njaratiana
 * Date: 09/05/19
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 *
 */

define ( 'AXIANDDR_PLUGIN_URL' , plugins_url(basename(dirname(dirname(__FILE__)))) );

define('DDR_STATUS_DRAFT','draft');
define('DDR_STATUS_VALIDE','valid');
define('DDR_STATUS_EN_COURS','in_progress');
define('DDR_STATUS_REFUSE','denied');
define('DDR_STATUS_ANNULE','canceled');
define('DDR_STATUS_CLOTURE','finished');

define('DDR_STEP_CREATE','create');
define('DDR_STEP_VALIDATION_1','validation1');
define('DDR_STEP_VALIDATION_2','validation2');
define('DDR_STEP_VALIDATION_3','validation3');
define('DDR_STEP_VALIDATION_4','validation4');
define('DDR_STEP_PUBLISH','publish');

define('CANDIDATURE_INTERNE','internal');
define('CANDIDATURE_EXTERNE','external');

define('TYPE_DEMANDE_PREVU','planned');
define('TYPE_DEMANDE_NON_PREVU','not_planned');

//Table name
global $wpdb;
define('TABLE_AXIAN_DDR', $wpdb->prefix . 'ddr');
define('TABLE_AXIAN_DDR_HISTORIQUE', $wpdb->prefix . 'ddr_historique');
define('TABLE_AXIAN_DDR_INTERIM', $wpdb->prefix . 'ddr_interim');
define('TABLE_AXIAN_DDR_TERM', $wpdb->prefix . 'ddr_term');

