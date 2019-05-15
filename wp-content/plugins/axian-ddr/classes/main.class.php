<?php

class AxianDDRMain {
    public function __construct()
    {
        add_action('admin_init', array($this,'install'));
        add_action('admin_menu',array($this,'admin_menu'));


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
                `date_previsionnel` datetime DEFAULT NULL,
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
        add_menu_page('Demande de recrutement', 'Demande de recrutement', 'manage_options', 'axian-ddr','','dashicons-megaphone');
        add_submenu_page( 'axian-ddr', 'Tous les DDR', 'Tous les DDR','manage_options', 'axian-ddr', 'AxianDDR::template_list');
        add_submenu_page( 'axian-ddr', 'Nouvelle DDR', 'Nouvelle DDR','manage_options', 'new-axian-ddr','AxianDDR::template_edit');

        //menu admin
        add_menu_page('DDR Administration', 'DDR Administration', 'manage_options', 'axian-ddr-admin','','dashicons-networking');
        add_submenu_page( 'axian-ddr-admin', 'Réglage général', 'Réglage général','manage_options', 'axian-ddr-admin','AxianDDRAdministration::template');
        add_submenu_page( 'axian-ddr-admin', 'Termes de taxonomie', 'Termes de taxonomie','manage_options', 'axian-ddr-admin&tab=term', 'AxianDDRAdministration::template');

        //
    }

}