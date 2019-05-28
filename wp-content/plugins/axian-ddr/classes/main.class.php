<?php

class AxianDDRMain {
    public function __construct()
    {
        add_action( 'init', array($this,'init') );
        add_action( 'admin_menu',array($this,'admin_menu') );
        add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
        add_filter( 'set-screen-option', array( $this ,'set_screen_option'), 999, 3);
    }

    public function init(){
        add_role( 'administrateur-ddr', 'Administrateurs DDR');
        add_role( 'manager', 'Manager');
        add_role( 'assistante-direction', 'Assistante de Direction');
        add_role( 'assistante-rh', 'Assistante RH');
        add_role( 'drh', 'DRH');
        add_role( 'dg', 'DG');
    }

    public static function install(){
        //install
        global $wpdb;

        // create table ddr
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . TABLE_AXIAN_DDR ." (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `author_id` bigint(20) NOT NULL COMMENT 'Identifiant de l’utilisateur connecté ayant créé le ticket',
                `type` varchar(20) NOT NULL COMMENT 'Choix entre prevu et non-prevu',
                `direction` text,
                `title` text NOT NULL,
                `departement` text,
                `superieur_id` bigint(20) DEFAULT NULL COMMENT 'id de l''utilisateur superieur',
                `lieu_travail` text,
                `batiment` text,
                `motif` longtext,
                `dernier_titulaire` text,
                `date_previsionnel` date DEFAULT NULL,
                `comment` longtext,
                `assignee_id` bigint(20) DEFAULT NULL COMMENT 'id de l''utilisateur assigné au ticket',
                `type_candidature` varchar(20) DEFAULT NULL COMMENT 'Choix entre interne et externe',
                `created` datetime NOT NULL,
                `modified` datetime DEFAULT NULL,
                `etat` varchar(50) DEFAULT NULL COMMENT 'Etat actuel du ticket',
                `etape` varchar(50) DEFAULT NULL COMMENT 'Etape actuelle du ticket',
                PRIMARY KEY (`id`),
                KEY `author_id` (`author_id`),
                KEY `type` (`type`),
                KEY `assignee_id` (`assignee_id`),
                KEY `type_candidature` (`type_candidature`),
                KEY `etat` (`etat`),
                KEY `etape` (`etape`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        // create table ddr historique
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . TABLE_AXIAN_DDR_HISTORIQUE ." (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `ddr_id` bigint(20) NOT NULL COMMENT 'id du ddr',
                `actor_id` bigint(20) NOT NULL COMMENT 'user id executant l''action',
                `action` varchar(50) NOT NULL COMMENT 'l''action entrepris',
                `etat_avant` varchar(50) NOT NULL COMMENT 'etat du ticket avant',
                `etat_apres` varchar(50) NOT NULL COMMENT 'etat du ticket apres',
                `etape` varchar(50) NOT NULL COMMENT 'etape actuelle du ticket',
                `date` datetime NOT NULL COMMENT 'date de l''action',
                PRIMARY KEY (`id`),
                KEY `ddr_id` (`ddr_id`),
                KEY `actor_id` (`actor_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        // create table ddr historique
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . TABLE_AXIAN_DDR_INTERIM ." (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `collaborator_id` bigint(20) NOT NULL,
                `collaborator_interim_id` bigint(20) NOT NULL,
                `date_debut` datetime DEFAULT NULL,
                `date_fin` datetime DEFAULT NULL,
                PRIMARY KEY (`id`,`collaborator_id`,`collaborator_interim_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        // create table ddr historique
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . TABLE_AXIAN_DDR_TERM ." (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `type` varchar(50) NOT NULL,
                `label` varchar(50) NOT NULL,
                PRIMARY KEY (`id`,`type`,`label`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

    }

    public function admin_menu(){
        //menu DDR
        add_menu_page('Demande de recrutement', 'Demande de recrutement', 'manage_options', 'axian-ddr-list','AxianDDR::template_list','dashicons-megaphone');
        $hook = add_submenu_page( 'axian-ddr-list', 'Toutes les demandes', 'Toutes les demandes','manage_options', 'axian-ddr-list', 'AxianDDR::template_list');
        add_action( "load-{$hook}", 'AxianDDRList::load_hook' );
        add_submenu_page( 'axian-ddr-list', 'Faire une demande', 'Faire une demande','manage_options', 'axian-ddr','AxianDDR::template_edit');

        //menu admin
        add_menu_page('DDR Administration', 'DDR Administration', 'manage_options', 'axian-ddr-admin','','dashicons-networking');
        add_submenu_page( 'axian-ddr-admin', 'Réglage général', 'Réglage général','manage_options', 'axian-ddr-admin','AxianDDRAdministration::template');
        add_submenu_page( 'axian-ddr-admin', 'Termes de taxonomie', 'Termes de taxonomie','manage_options', 'axian-ddr-admin&tab=term', 'AxianDDRAdministration::template');

        //
    }


    public function admin_enqueue_scripts(){
        //styles
        wp_enqueue_style('axian-ddr-bootstrap', AXIANDDR_PLUGIN_URL . '/assets/css/bootstrap.min.css');
        wp_enqueue_style('axian-ddr-date', AXIANDDR_PLUGIN_URL . '/assets/css/jquery-ui-datepicker.css');
        wp_enqueue_style('axian-ddr-daterangepicker', AXIANDDR_PLUGIN_URL . '/assets/css/daterangepicker.css');
        wp_enqueue_style('axian-ddr-chosen', AXIANDDR_PLUGIN_URL . '/assets/css/chosen.css');
        wp_enqueue_style('axian-ddr-main', AXIANDDR_PLUGIN_URL . '/assets/css/main.css');

        //scripts
        wp_enqueue_script('axian-ddr-chosen', AXIANDDR_PLUGIN_URL.'/assets/js/chosen.jquery.js');
        wp_enqueue_script('axian-ddr-date', AXIANDDR_PLUGIN_URL.'/assets/js/jquery.ui.datepicker.js');
        wp_enqueue_script('axian-ddr-date-fr', AXIANDDR_PLUGIN_URL.'/assets/js/jquery.ui.datepicker-fr.js');
        wp_enqueue_script('axian-ddr-bootstrap-js', AXIANDDR_PLUGIN_URL.'/assets/js/bootstrap.min.js');
        wp_enqueue_script('axian-ddr-moment', AXIANDDR_PLUGIN_URL.'/assets/js/moment.min.js');
        wp_enqueue_script('axian-ddr-daterangepicker', AXIANDDR_PLUGIN_URL.'/assets/js/daterangepicker.min.js');
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script('axian-ddr-main', AXIANDDR_PLUGIN_URL.'/assets/js/main.js');
        wp_localize_script('axian-ddr-main', 'ddr_settings', array(
            'admin_url' => admin_url('/admin-ajax.php'),
            'autocompletion_url' => AXIANDDR_PLUGIN_URL . '/entrypoint/autocompletion.php',
        ));
    }


    public function set_screen_option($status, $option, $value) {
         return $value;
    }

}