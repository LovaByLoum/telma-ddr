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

define('STATUS_DRAFT','draft');
define('STATUS_VALIDE','valid');
define('STATUS_EN_COURS','in_progress');
define('STATUS_REFUSE','denied');
define('STATUS_ANNULE','canceled');
define('STATUS_CLOTURE','finished');

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

