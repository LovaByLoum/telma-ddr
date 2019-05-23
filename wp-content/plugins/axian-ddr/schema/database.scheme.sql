CREATE TABLE IF NOT EXISTS `wp_ddr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) NOT NULL COMMENT 'Identifiant de l’utilisateur connecté ayant créé le ticket',
  `type` varchar(20) NOT NULL COMMENT 'Choix entre prevu et non-prevu',
  `direction` text,
  `title` text NOT NULL,
  `departement` text,
  `superieur_id` bigint(20) DEFAULT NULL COMMENT 'id de l''utilisateur superieur',
  `lieu_travail` text,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8


CREATE TABLE IF NOT EXISTS `wp_ddr_historique` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8


CREATE TABLE IF NOT EXISTS `wp_ddr_interim` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `collaborator_id` bigint(20) NOT NULL,
  `collaborator_interim_id` bigint(20) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`collaborator_id`,`collaborator_interim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8



CREATE TABLE IF NOT EXISTS `wp_ddr_label` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `label` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`,`type`,`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8