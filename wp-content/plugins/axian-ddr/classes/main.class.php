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
        add_menu_page('DDR', 'DDR', 'manage_options', 'axian-ddr', 'ddr_home' );
        add_submenu_page( 'axian-ddr', 'Tous les DDR', 'Tous les DDR',
            'manage_options', 'axian-ddr');
        add_submenu_page( 'axian-ddr', 'Nouvelle DDR', 'Nouvelle DDR',
            'manage_options', 'ajout-ddr','new_ddr');
        add_submenu_page( 'axian-ddr', 'Direction', 'Direction',
            'manage_options', 'ddr-direction','DDR_label::direction');
        add_submenu_page( 'axian-ddr', 'Département', 'Département',
            'manage_options', 'ddr-departement','DDR_label::departement');
    }

}