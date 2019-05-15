<?php
if (!defined("WP_UNINSTALL_PLUGIN"))
    exit();

//put plugin uninstall code here
global $wpdb;
$wpdb->query('DROP TABLE ' . TABLE_AXIAN_DDR . ';');
$wpdb->query('DROP TABLE ' . TABLE_AXIAN_DDR_HISTORIQUE . ';');
$wpdb->query('DROP TABLE ' . TABLE_AXIAN_DDR_INTERIM . ';');
$wpdb->query('DROP TABLE ' . TABLE_AXIAN_DDR_TERM . ';');