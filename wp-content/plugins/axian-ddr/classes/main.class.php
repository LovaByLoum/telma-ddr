<?php

class Main_DDR {
    public function __construct()
    {

        add_action('admin_init', array($this,'install'));
        add_action('admin_menu',array($this,'setup_menu'));


    }

    public static function install(){
        //install

    }

    public function setup_menu(){
        add_menu_page('Demande de recrutement', 'Demande de recrutement', 'manage_options', 'axian-ddr','','dashicons-megaphone');
        add_menu_page('DDR Administration', 'DDR Administration', 'manage_options', 'axian-ddr-admin','','dashicons-networking');

        add_submenu_page( 'axian-ddr', 'Tous les DDR', 'Tous les DDR','manage_options', 'axian-ddr', 'list_ddr');
        add_submenu_page( 'axian-ddr', 'Nouvelle DDR', 'Nouvelle DDR','manage_options', 'new-axian-ddr','new_ddr');
        add_submenu_page( 'axian-ddr-admin', 'Réglage général', 'Réglage général','manage_options', 'axian-ddr-admin','global_setting');
        add_submenu_page( 'axian-ddr-admin', 'Termes de taxonomie', 'Termes de taxonomie','manage_options', 'taxonomie-setting',function() { DDR_label::show(LABEL_TYPE_DEPARTEMENT);});
    }

}