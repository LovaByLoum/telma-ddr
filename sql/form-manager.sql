/*
SQLyog Ultimate v9.10 
MySQL - 5.7.9 : Database - telma_rh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `wp_fm_data_1` */

DROP TABLE IF EXISTS `wp_fm_data_1`;

CREATE TABLE `wp_fm_data_1` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `parent_post_id` int(11) NOT NULL DEFAULT '0',
  `unique_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `text-578647f95d5db` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-57864a68da0d2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-57864a781ce98` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `textarea-57864acd93cf8` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file-57864af3474de` longblob NOT NULL,
  `file-57864b273eb37` longblob NOT NULL,
  `file-5787a3939c837` longblob NOT NULL,
  `text-5788961b09ffc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-578896221f08d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5788962296ea1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5788965e9cabf` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-578f6eed84499` text COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `unique_id` (`unique_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_data_1` */

/*Table structure for table `wp_fm_data_2` */

DROP TABLE IF EXISTS `wp_fm_data_2`;

CREATE TABLE `wp_fm_data_2` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `parent_post_id` int(11) NOT NULL DEFAULT '0',
  `unique_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `text-5791c400818e9` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5791c435dbe6d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5791c44862170` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5791c4629e06d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text-5791c47657804` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file-5791c48e104c8` longblob NOT NULL,
  `file-5791c4b7d5a8f` longblob NOT NULL,
  KEY `unique_id` (`unique_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_data_2` */

/*Table structure for table `wp_fm_forms` */

DROP TABLE IF EXISTS `wp_fm_forms`;

CREATE TABLE `wp_fm_forms` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitted_msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_btn_text` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `required_msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_table` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_index` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shortcode` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_list` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `behaviors` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_user_field` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `form_template` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_template` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_subject` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_from` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `summary_template` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `template_values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_summary` tinyint(1) NOT NULL DEFAULT '0',
  `use_advanced_email` tinyint(1) NOT NULL DEFAULT '0',
  `advanced_email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_post` tinyint(1) NOT NULL DEFAULT '0',
  `publish_post_category` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_post_status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `auto_redirect` tinyint(1) NOT NULL DEFAULT '0',
  `auto_redirect_page` int(11) NOT NULL DEFAULT '0',
  `auto_redirect_timeout` int(11) NOT NULL DEFAULT '5',
  `conditions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_user_only_msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_hide_empty` tinyint(1) NOT NULL DEFAULT '0',
  `exact_form_action` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enable_autocomplete` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_forms` */

insert  into `wp_fm_forms`(`ID`,`title`,`submitted_msg`,`submit_btn_text`,`required_msg`,`data_table`,`action`,`data_index`,`shortcode`,`type`,`email_list`,`behaviors`,`email_user_field`,`form_template`,`email_template`,`email_subject`,`email_from`,`summary_template`,`template_values`,`show_summary`,`use_advanced_email`,`advanced_email`,`publish_post`,`publish_post_category`,`publish_post_title`,`publish_post_status`,`auto_redirect`,`auto_redirect_page`,`auto_redirect_timeout`,`conditions`,`reg_user_only_msg`,`summary_hide_empty`,`exact_form_action`,`enable_autocomplete`) values (-3,'','','Envoyer','','','','','','form','','','','','','','','','',0,0,'',0,'','[form title] Soumission','publish',0,0,5,'','',0,'',1);
insert  into `wp_fm_forms`(`ID`,`title`,`submitted_msg`,`submit_btn_text`,`required_msg`,`data_table`,`action`,`data_index`,`shortcode`,`type`,`email_list`,`behaviors`,`email_user_field`,`form_template`,`email_template`,`email_subject`,`email_from`,`summary_template`,`template_values`,`show_summary`,`use_advanced_email`,`advanced_email`,`publish_post`,`publish_post_category`,`publish_post_title`,`publish_post_status`,`auto_redirect`,`auto_redirect_page`,`auto_redirect_timeout`,`conditions`,`reg_user_only_msg`,`summary_hide_empty`,`exact_form_action`,`enable_autocomplete`) values (1,'Formulaire de postulation à un offre','Merci! Vos informations ont bien été envoyées.','Envoyer','\'%s\' est requis.','wp_fm_data_1','','','form-postuler','form','','','','fm-postuler-offre.php','','[form title] Soumission','[admin email]','','a:4:{s:13:\"showFormTitle\";s:4:\"true\";s:10:\"showBorder\";s:4:\"true\";s:13:\"labelPosition\";s:4:\"left\";s:10:\"labelWidth\";s:3:\"200\";}',0,0,'',0,'1','[form title] Soumission','publish',0,2,5,'','Le formulaire \'%s\' n\'est accssiible qu\'aux utilisateurs enregistrés.',0,'',1);
insert  into `wp_fm_forms`(`ID`,`title`,`submitted_msg`,`submit_btn_text`,`required_msg`,`data_table`,`action`,`data_index`,`shortcode`,`type`,`email_list`,`behaviors`,`email_user_field`,`form_template`,`email_template`,`email_subject`,`email_from`,`summary_template`,`template_values`,`show_summary`,`use_advanced_email`,`advanced_email`,`publish_post`,`publish_post_category`,`publish_post_title`,`publish_post_status`,`auto_redirect`,`auto_redirect_page`,`auto_redirect_timeout`,`conditions`,`reg_user_only_msg`,`summary_hide_empty`,`exact_form_action`,`enable_autocomplete`) values (2,'Candidature Spontanée','Merci! Vos informations ont bien été envoyées.','Envoyer','\'%s\' est requis.','wp_fm_data_2','','','form-spontanee','form','','','','','','[form title] Soumission','[admin email]','','a:4:{s:13:\"showFormTitle\";s:4:\"true\";s:10:\"showBorder\";s:4:\"true\";s:13:\"labelPosition\";s:4:\"left\";s:10:\"labelWidth\";s:3:\"200\";}',0,0,'',0,'','[form title] Soumission','publish',0,137,5,'','Le formulaire \'%s\' n\'est accssiible qu\'aux utilisateurs enregistrés.',0,'',1);

/*Table structure for table `wp_fm_items` */

DROP TABLE IF EXISTS `wp_fm_items`;

CREATE TABLE `wp_fm_items` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `index` int(11) NOT NULL DEFAULT '0',
  `unique_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `db_type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `set` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `unique_name` (`unique_name`),
  UNIQUE KEY `unique_name_2` (`unique_name`),
  UNIQUE KEY `unique_name_3` (`unique_name`),
  KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `ID_3` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_items` */

insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,1,'text-578647f95d5db','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','name_postule','Nom',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,2,'text-57864a68da0d2','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','prenom_postule','Prénom',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,3,'text-57864a781ce98','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:5:\"email\";s:9:\"maxlength\";s:0:\"\";}','email_postule','Adresse email',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,4,'textarea-57864acd93cf8','textarea','a:3:{s:5:\"value\";s:0:\"\";s:4:\"rows\";s:3:\"100\";s:4:\"cols\";s:3:\"300\";}','message_postule','Votre message',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,9,'file-57864af3474de','file','a:7:{s:8:\"restrict\";s:16:\".doc, .rtf, .pdf\";s:7:\"exclude\";s:0:\"\";s:8:\"max_size\";s:5:\"10000\";s:10:\"upload_dir\";s:16:\"%wp_uploads_dir%\";s:10:\"upload_url\";s:16:\"%wp_uploads_url%\";s:11:\"name_format\";s:24:\"%filename% (m-d-y-h-i-s)\";s:10:\"media_type\";s:4:\"none\";}','cv_postule','CV',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,10,'file-57864b273eb37','file','a:7:{s:8:\"restrict\";s:16:\".doc, .rtf, .pdf\";s:7:\"exclude\";s:0:\"\";s:8:\"max_size\";s:5:\"10000\";s:10:\"upload_dir\";s:16:\"%wp_uploads_dir%\";s:10:\"upload_url\";s:16:\"%wp_uploads_url%\";s:11:\"name_format\";s:24:\"%filename% (m-d-y-h-i-s)\";s:10:\"media_type\";s:4:\"none\";}','lm_postule','Lettre de motivation',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,7,'text-578896221f08d','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','francais_postule','Français',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,8,'text-5788962296ea1','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','malagasy_postule','Malagasy',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,11,'file-5787a3939c837','file','a:7:{s:8:\"restrict\";s:16:\".doc, .rtf, .pdf\";s:7:\"exclude\";s:0:\"\";s:8:\"max_size\";s:5:\"10000\";s:10:\"upload_dir\";s:16:\"%wp_uploads_dir%\";s:10:\"upload_url\";s:16:\"%wp_uploads_url%\";s:11:\"name_format\";s:24:\"%filename% (m-d-y-h-i-s)\";s:10:\"media_type\";s:4:\"none\";}','autre_postule','Autre document',0,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,5,'text-5788965e9cabf','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','informatique_postule','Compétence informatique',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,6,'text-5788961b09ffc','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','anglais_postule','Anglais',1,'DATA','Description de l\\\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (1,0,'text-578f6eed84499','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','entreprise_postule','Entreprises',0,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,0,'text-5791c400818e9','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','nom_spontanee','Nom',1,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,1,'text-5791c435dbe6d','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','prenom_spontanee','Prénom',1,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,2,'text-5791c44862170','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:5:\"email\";s:9:\"maxlength\";s:0:\"\";}','email_spontanee','Adresse mail ',1,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,3,'text-5791c4629e06d','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','num_phone_spontanee','Numéro de téléphone ',0,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,4,'text-5791c47657804','text','a:4:{s:5:\"value\";s:0:\"\";s:4:\"size\";s:3:\"300\";s:10:\"validation\";s:4:\"none\";s:9:\"maxlength\";s:0:\"\";}','message_spontanee','Message',0,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,5,'file-5791c48e104c8','file','a:7:{s:8:\"restrict\";s:16:\".doc, .rtf, .pdf\";s:7:\"exclude\";s:0:\"\";s:8:\"max_size\";s:5:\"10000\";s:10:\"upload_dir\";s:16:\"%wp_uploads_dir%\";s:10:\"upload_url\";s:16:\"%wp_uploads_url%\";s:11:\"name_format\";s:24:\"%filename% (m-d-y-h-i-s)\";s:10:\"media_type\";s:4:\"none\";}','cv_spontanee','Mon CV ',0,'DATA','Description de l\'élément',0);
insert  into `wp_fm_items`(`ID`,`index`,`unique_name`,`type`,`extra`,`nickname`,`label`,`required`,`db_type`,`description`,`set`) values (2,6,'file-5791c4b7d5a8f','file','a:7:{s:8:\"restrict\";s:16:\".doc, .rtf, .pdf\";s:7:\"exclude\";s:0:\"\";s:8:\"max_size\";s:5:\"10000\";s:10:\"upload_dir\";s:16:\"%wp_uploads_dir%\";s:10:\"upload_url\";s:16:\"%wp_uploads_url%\";s:11:\"name_format\";s:24:\"%filename% (m-d-y-h-i-s)\";s:10:\"media_type\";s:4:\"none\";}','lm_spontanee','Ma lettre de motivation ',0,'DATA','Description de l\'élément',0);

/*Table structure for table `wp_fm_settings` */

DROP TABLE IF EXISTS `wp_fm_settings`;

CREATE TABLE `wp_fm_settings` (
  `setting_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_settings` */

insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('recaptcha_public','');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('recaptcha_private','');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('recaptcha_theme','red');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('recaptcha_lang','fr');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('title','Nouveau formulaire');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('submitted_msg','Merci! Vos informations ont bien été envoyées.');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('required_msg','\'%s\' est requis.');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('reg_user_only_msg','Le formulaire \'%s\' n\'est accssiible qu\'aux utilisateurs enregistrés.');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('email_admin','YES');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('email_reg_users','YES');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('email_subject','[form title] Soumission');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('email_from','[admin email]');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('template_form','');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_count','8');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_0','a:4:{s:4:\"name\";s:6:\"number\";s:5:\"label\";s:19:\"Seulement un nombre\";s:7:\"message\";s:25:\"\'%s\' doit être un nombre\";s:6:\"regexp\";s:27:\"/^\\s*[0-9]*[\\.]?[0-9]+\\s*$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_1','a:4:{s:4:\"name\";s:5:\"phone\";s:5:\"label\";s:22:\"Numéro de téléphone\";s:7:\"message\";s:48:\"\'%s\' doit être un numéro de téléphone valide\";s:6:\"regexp\";s:36:\"/^.*[0-9]{3}.*[0-9]{3}.*[0-9]{4}.*$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_2','a:4:{s:4:\"name\";s:5:\"email\";s:5:\"label\";s:6:\"E-Mail\";s:7:\"message\";s:46:\"\'%s\' doit être une adresse de courriel valide\";s:6:\"regexp\";s:51:\"/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,4}$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_3','a:4:{s:4:\"name\";s:4:\"date\";s:5:\"label\";s:15:\"Date (JJ/MM/YY)\";s:7:\"message\";s:49:\"\'%s\' doit être une date sous la forme (JJ/MM/YY)\";s:6:\"regexp\";s:34:\"/^[0-9]{1,2}.[0-9]{1,2}.[0-9]{2}$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_4','a:4:{s:4:\"name\";s:5:\"state\";s:5:\"label\";s:4:\"Etat\";s:7:\"message\";s:48:\"\'%s\' doit être une abbréviation d\'état valide\";s:6:\"regexp\";s:136:\"/^(A[LKSZRAEP]|C[AOT]|D[EC]|F[LM]|G[AU]|HI|I[ADLN]|K[SY]|LA|M[ADEHINOPST]|N[CDEHJMVY]|O[HKR]|P[ARW]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY])$/i\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_5','a:4:{s:4:\"name\";s:3:\"zip\";s:5:\"label\";s:11:\"Code postal\";s:7:\"message\";s:37:\"\'%s\' doit être un code postal valide\";s:6:\"regexp\";s:9:\"/^\\d{5}$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_6','a:4:{s:4:\"name\";s:10:\"dimensions\";s:5:\"label\";s:22:\"Dimensions (L x l x H)\";s:7:\"message\";s:35:\"\'%s\' must be dimensions (L x l x H)\";s:6:\"regexp\";s:71:\"/^\\s*(\\d+(\\.\\d+)?)\\s*(x|X)\\s*(\\d+(\\.\\d+)?)\\s*(x|X)\\s*(\\d+(\\.\\d+)?)\\s*$/\";}');
insert  into `wp_fm_settings`(`setting_name`,`setting_value`) values ('text_validator_7','a:4:{s:4:\"name\";s:5:\"date2\";s:5:\"label\";s:15:\"Date (DD/MM/YY)\";s:7:\"message\";s:30:\"\'%s\' must be a date (DD/MM/YY)\";s:6:\"regexp\";s:34:\"/^[0-9]{1,2}.[0-9]{1,2}.[0-9]{2}$/\";}');

/*Table structure for table `wp_fm_templates` */

DROP TABLE IF EXISTS `wp_fm_templates`;

CREATE TABLE `wp_fm_templates` (
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wp_fm_templates` */

insert  into `wp_fm_templates`(`title`,`filename`,`content`,`status`,`modified`) values ('Form Manager Default','fm-form-default.php','<?php\r\n/*\r\nTemplate Name: Form Manager Default\r\nTemplate Description: The default dislplay template for forms\r\nTemplate Type: form\r\n\r\noption: $showFormTitle, checkbox\r\n	label: Show form title:\r\n	default: checked\r\noption: $showBorder, checkbox\r\n	label: Show border:\r\n	default: checked	\r\noption: $labelPosition, select\r\n	label: Label position:\r\n	description: Labels can be placed to the left or above each field\r\n	options: \'left\' => \'Left\', \'top\' => \'Top\'\r\n	default: left\r\noption: $labelWidth, text\r\n	label: Label width (in pixels):\r\n	description: Applies to checkboxes, and when labels are to the left\r\n	default: 200\r\n\r\n	\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\nBelow are the functions that can be used within a form display template:\r\n\r\nfm_form_start(), fm_form_end() - These can be called (not echo\'ed) to open and close the form, respectively.\r\nfm_form_hidden() - Nonce and other hidden values required for the form; can be omitted if fm_form_end() is used.\r\nfm_form_the_title() - The form\'s title\r\n\r\nThe following can be used in place of the fm_form_start() function:\r\nfm_form_class() - The default form CSS class\r\nfm_form_action() - The default form action\r\nfm_form_ID() - Used for the opening form tag\'s \'name\' and \'id\' attributes.\r\n\r\nfm_form_the_submit_btn() - A properly formed submit button\r\nfm_form_submit_btn_name() - Submit button\'s \'name\' attribute\r\nfm_form_submit_btn_id() - Submit button\'s \'id\' attribute\r\nfm_form_submit_btn_text() - Submit button\'s \'value\' attribute, as set in the form editor.\r\nfm_form_submit_btn_script() - Validation script\r\n\r\nfm_form_have_items() - Returns true if there are more items (used to loop through the form items, similar to have_posts() in wordpress themes)\r\nfm_form_the_item() - Sets up the current item (similar to the_post() in wordpress themes)\r\nfm_form_the_label() - The current item\'s label\r\nfm_form_the_input() - The current item\'s input element\r\nfm_form_the_nickname() - The current item\'s nickname\r\n\r\nfm_form_is_separator() - Returns true if the current element is a horizontal line\r\nfm_form_is_note() - Returns true if the current element is a note\r\nfm_form_is_required() - Returns true if the current item is set as required\r\nfm_form_item_type() - The current item\'s type\r\n\r\nfm_form_get_item_input($nickname) - get an item\'s input by nickname\r\nfm_form_get_item_label($nickname) - get an item\'s label by nickname\r\n\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\n*/\r\n\r\n/* translators: the following are for the options for the default form display template */\r\n__(\"Show form title:\", \'wordpress-form-manager\');\r\n__(\"Show border:\", \'wordpress-form-manager\');\r\n__(\"Label position:\", \'wordpress-form-manager\');\r\n__(\"Labels can be placed to the left or above each field\", \'wordpress-form-manager\');\r\n_x(\'Left\', \'template-option\', \'wordpress-form-manager\');\r\n_x(\'Top\', \'template-option\', \'wordpress-form-manager\');\r\n__(\"Label width (in pixels):\", \'wordpress-form-manager\');\r\n__(\"Applies to checkboxes, and when labels are to the left\", \'wordpress-form-manager\');\r\n\r\n?>\r\n<?php echo fm_form_start(); ?>\r\n\r\n	<?php if($showBorder): ?><fieldset><?php endif; ?>\r\n	\r\n		<?php if($showFormTitle): ?>\r\n			<?php if($showBorder): ?>\r\n				<legend><?php echo fm_form_the_title(); ?></legend>\r\n			<?php else: ?>\r\n				<h2><?php echo fm_form_the_title(); ?></h2>\r\n			<?php endif; ?>\r\n		<?php endif; ?>\r\n		\r\n		<ul>\r\n			<?php while(fm_form_have_items()): fm_form_the_item(); ?>\r\n			<li id=\"fm-item-<?php echo (fm_form_the_nickname() != \"\" ? fm_form_the_nickname() : fm_form_the_ID()); ?>\">\r\n				<?php if($labelPosition == \"top\"): ?>\r\n					<label style=\"display:block;width:<?php echo $labelwidth;?>px;\"><?php echo fm_form_the_label(); ?>\r\n					<?php if(fm_form_is_required()) echo \"&nbsp;<em>*</em>\"; ?>\r\n					</label><?php echo fm_form_the_input(); ?>\r\n				<?php else: ?>\r\n					<table><tr>\r\n						<td style=\"width:<?php echo $labelWidth; ?>px\"><label><?php echo fm_form_the_label(); ?><?php if(fm_form_is_required()) echo \"&nbsp;<em>*</em>\"; ?></label></td>\r\n						<td><?php echo fm_form_the_input(); ?></td>\r\n					</tr></table>\r\n				<?php endif; ?>\r\n			</li>\r\n			<?php endwhile; ?>\r\n		</ul>\r\n\r\n		<div>\r\n		 <?php echo fm_form_the_submit_btn(); ?>\r\n		</div>\r\n\r\n	<?php if($showBorder): ?></fieldset><?php endif; ?>\r\n\r\n	<?php echo fm_form_hidden(); ?>\r\n<?php echo fm_form_end(); ?>','',1469106107);
insert  into `wp_fm_templates`(`title`,`filename`,`content`,`status`,`modified`) values ('Form Manager Default','fm-summary-default.php','<?php\r\n/*\r\nTemplate Name: Form Manager Default\r\nTemplate Description: The default template for e-mail notifications and summaries\r\nTemplate Type: email, summary\r\n\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\nBelow are the functions that can be used within a summary template:\r\n\r\nfm_summary_the_title() - the title of the form\r\nfm_summary_have_items() - works like have_posts() for wordpress themes.  Returns \'true\' if there are more items left in the form.\r\nfm_summary_the_item() - works like the_item() for wordpress themes.  Initializes the current form item.\r\nfm_summary_the_label() - label of the current form item\r\nfm_summary_the_type() - type of the current form item (text, textarea, checkbox, custom_list, note, separator, recaptcha, file)\r\nfm_summary_has_data() - returns true if the form element is a data element (as opposed to a separator, note, etc.)\r\nfm_summary_the_value() - submitted value of the current form item\r\nfm_summary_the_timestamp() - timestamp for the current submission\r\nfm_summary_the_user() - the login name for the current user.  If no user is logged in, this returns an empty string.\r\nfm_summary_the_IP() - the IP address of the user who submitted the form.\r\nfm_summary_the_nickname() - the current item\'s nickname\r\nfm_summary_the_parent() - post ID where the form was submitted from\r\n\r\nfm_summary_get_item_label($nickname) - get an item\'s label by nickname\r\nfm_summary_get_item_value($nickname) - get an item\'s value by nickname\r\n\r\n*NOTE: \'Summary\' templates can also be used for e-mails.  Notice that under \'Template Type\', both \'email\' and \'summary\' are listed.  If you want to make a template for e-mail notifications only, then you should only put \'email\' under \'Template Type\'.\r\n\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\n*/\r\n?>\r\n<?php /* The title of the form */ ?>\r\n<h2><?php echo fm_summary_the_title(); ?></h2>\r\n\r\n<?php /* The user\'s first and last name, if there is a logged in user */ ?>\r\n<?php \r\n$userName = fm_summary_the_user(); \r\nif(trim($userName) != \"\"){\r\n	$userData = get_userdatabylogin($userName);\r\n	echo \"Submitted by: <strong>\".$userData->last_name.\", \".$userData->first_name.\"</strong><br />\";\r\n}\r\n?>\r\n\r\n<?php /* The time and date of the submission.  Look up date() in the PHP reference at php.net for more info on how to format timestamps. */ ?>\r\nOn: <strong><?php echo date(\"M j, Y @ g:i A\", strtotime(fm_summary_the_timestamp())); ?></strong> <br />\r\nIP: <strong><?php echo fm_summary_the_IP(); ?></strong> <br />\r\n<?php /* The code below displays each form element, in order, along with the submitted data. */ ?>\r\n<ul id=\"fm-summary\">\r\n<?php while(fm_summary_have_items()): fm_summary_the_item(); ?>\r\n	<?php switch(fm_summary_the_type()){\r\n		case \'separator\': ?><hr /><?php break;\r\n		default:\r\n		if(fm_summary_has_data()): ?>\r\n		<li<?php if(fm_summary_the_nickname() != \"\") echo \" id=\\\"fm-item-\".fm_summary_the_nickname().\"\\\"\";?>><?php echo fm_summary_the_label();?>: <strong><?php echo fm_summary_the_value();?></strong></li>\r\n	<?php endif;\r\n		} // end switch ?>\r\n<?php endwhile; ?>\r\n</ul>','',1469106107);
insert  into `wp_fm_templates`(`title`,`filename`,`content`,`status`,`modified`) values ('Summary for Data List','fm-summary-multi.php','<?php\r\n/*\r\nTemplate Name: Summary for Data List\r\nTemplate Description: This is used by for displaying the submission data as a list of summaries, for example the [formdata] shortcode\r\nTemplate Type: email, summary\r\n\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\n*/\r\n?>\r\n<?php /* The user\'s first and last name, if there is a logged in user */ ?>\r\n<?php \r\n$userName = fm_summary_the_user(); \r\nif($userName != \"\"){\r\n	$userData = get_userdatabylogin($userName);\r\n	echo \"Submitted by: <strong>\".$userData->last_name.\", \".$userData->first_name.\"</strong><br />\";\r\n}\r\n?>\r\n\r\n<?php /* The time and date of the submission.  Look up date() in the PHP reference at php.net for more info on how to format timestamps. */ ?>\r\nOn: <strong><?php echo date(\"M j, Y @ g:i A\", strtotime(fm_summary_the_timestamp())); ?></strong> <br />\r\nIP: <strong><?php echo fm_summary_the_IP(); ?></strong> <br />\r\n<?php /* The code below displays each form element, in order, along with the submitted data. */ ?>\r\n<ul id=\"fm-summary-multi\">\r\n<?php while(fm_summary_have_items()): fm_summary_the_item(); ?>\r\n	<?php if(fm_summary_the_type() == \'separator\'): ?>\r\n		<hr />\r\n	<?php elseif(fm_summary_has_data()): ?>\r\n		<li<?php if(fm_summary_the_nickname() != \"\") echo \" id=\\\"fm-item-\".fm_summary_the_nickname().\"\\\"\";?>><?php echo fm_summary_the_label();?>: <strong><?php echo fm_summary_the_value();?></strong></li>\r\n	<?php endif; ?>\r\n<?php endwhile; ?>\r\n</ul>\r\n<hr />','',1469106107);
insert  into `wp_fm_templates`(`title`,`filename`,`content`,`status`,`modified`) values ('Formulaire postuler un offre','fm-postuler-offre.php','<?php\r\n/*\r\nTemplate Name: Formulaire postuler un offre\r\nTemplate Description: The default dislplay template for forms\r\nTemplate Type: form\r\n\r\noption: $showFormTitle, checkbox\r\n	label: Show form title:\r\n	default: checked\r\noption: $showBorder, checkbox\r\n	label: Show border:\r\n	default: checked	\r\noption: $labelPosition, select\r\n	label: Label position:\r\n	description: Labels can be placed to the left or above each field\r\n	options: \'left\' => \'Left\', \'top\' => \'Top\'\r\n	default: left\r\noption: $labelWidth, text\r\n	label: Label width (in pixels):\r\n	description: Applies to checkboxes, and when labels are to the left\r\n	default: 200\r\n\r\n	\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\nBelow are the functions that can be used within a form display template:\r\n\r\nfm_form_start(), fm_form_end() - These can be called (not echo\'ed) to open and close the form, respectively.\r\nfm_form_hidden() - Nonce and other hidden values required for the form; can be omitted if fm_form_end() is used.\r\nfm_form_the_title() - The form\'s title\r\n\r\nThe following can be used in place of the fm_form_start() function:\r\nfm_form_class() - The default form CSS class\r\nfm_form_action() - The default form action\r\nfm_form_ID() - Used for the opening form tag\'s \'name\' and \'id\' attributes.\r\n\r\nfm_form_the_submit_btn() - A properly formed submit button\r\nfm_form_submit_btn_name() - Submit button\'s \'name\' attribute\r\nfm_form_submit_btn_id() - Submit button\'s \'id\' attribute\r\nfm_form_submit_btn_text() - Submit button\'s \'value\' attribute, as set in the form editor.\r\nfm_form_submit_btn_script() - Validation script\r\n\r\nfm_form_have_items() - Returns true if there are more items (used to loop through the form items, similar to have_posts() in wordpress themes)\r\nfm_form_the_item() - Sets up the current item (similar to the_post() in wordpress themes)\r\nfm_form_the_label() - The current item\'s label\r\nfm_form_the_input() - The current item\'s input element\r\nfm_form_the_nickname() - The current item\'s nickname\r\n\r\nfm_form_is_separator() - Returns true if the current element is a horizontal line\r\nfm_form_is_note() - Returns true if the current element is a note\r\nfm_form_is_required() - Returns true if the current item is set as required\r\nfm_form_item_type() - The current item\'s type\r\n\r\nfm_form_get_item_input($nickname) - get an item\'s input by nickname\r\nfm_form_get_item_label($nickname) - get an item\'s label by nickname\r\n\r\n//////////////////////////////////////////////////////////////////////////////////////////\r\n\r\n*/\r\nglobal $fm_display, $current_user;\r\n$form_items = array();\r\n$form_required = array();\r\nwhile(fm_form_have_items()): fm_form_the_item();\r\n    $form_items[fm_form_the_nickname()] = fm_form_the_ID();\r\n    $form_required[fm_form_the_nickname()] = fm_form_is_required();\r\nendwhile;\r\n$termInformatiques = get_term_children( ID_TAXONOMIE_INFORMATIQUE, JM_TAXONOMIE_COMPETENCE_REQUISES );\r\n$termCompetence = COffre::getCompetenceRequis(0);\r\n$termLinguistiques = $termCompetence[ID_TAXONOMIE_LINGUISTIQUES];\r\n$user = CUser::getById( $current_user->ID );\r\n$postID = ( isset($_GET[\'po\'] ) && !empty( $_GET[\'po\'] ) ) ? $_GET[\'po\'] : 0;\r\n$entrepriseId = get_post_meta( $postID, JM_META_SOCIETE_OFFRE_RELATION, true);\r\n$entreprise = JM_Societe::getById( $entrepriseId );\r\n?>\r\n<form enctype=\"multipart/form-data\" method=\"post\" action=\"<?php echo $fm_display->currentFormOptions[\'action\'];?>\" name=\"fm-form-<?php echo $fm_display->currentFormInfo[\'ID\'];?>\" id=\"fm-form-<?php echo $fm_display->currentFormInfo[\'ID\'];?>\" autocomplete=\"on\" novalidate=\"novalidate\">\r\n	<div class=\"control-group\">\r\n        <h4 class=\"head-accordion open\">Informations personnelles</h4>\r\n        <div class=\"head-accordion\">\r\n            <div class=\"col-1-2 form-field\">\r\n				<label for=\"nom\">Nom<span class=\"required\">*</span></label>\r\n                <input type=\"text\" placeholder=\"Nom\" name=\"<?php echo $form_items[\'name_postule\'];?>\" id=\"nom\" value=\"<?php echo $user->nom;?>\" readonly>\r\n            </div>\r\n            <div class=\"col-1-2 form-field\">\r\n                <label for=\"prenom\">Prénom <span class=\"required\">*</span></label>\r\n                <input type=\"text\" placeholder=\"Prénom\" name=\"<?php echo $form_items[\'prenom_postule\'];?>\" id=\"prenom\" value=\"<?php echo $user->prenom;?>\" readonly>\r\n            </div>\r\n	        <div class=\"col-1-2 form-field\">\r\n		        <label for=\"email\">Adresse email <span class=\"required\">*</span></label>\r\n                <input type=\"text\" placeholder=\"Email\" name=\"<?php echo $form_items[\'email_postule\'];?>\" id=\"email\" value=\"<?php echo $user->email;?>\" readonly>\r\n	        </div>\r\n        </div>\r\n    </div>\r\n	<div class=\"control-group\">\r\n		<div class=\"col-1-1 form-field\">\r\n		    <div class=\"col-1-2\">\r\n			<h5 class=\"head-accordion open\">Compétences Informatiques<span class=\"required\">*</span></h5>\r\n				<?php if ( !empty( $termInformatiques ) && count( $termInformatiques ) > 0 ) :\r\n						$i=1?>\r\n					<?php foreach ( $termInformatiques as $termId ):\r\n							$term = get_term_by( \"id\", $termId, JM_TAXONOMIE_COMPETENCE_REQUISES );?>\r\n		                <label class=\"control control--checkbox <?php if ( count( $termInformatiques ) == $i ):?>latest<?php endif;?>\"><?php echo $term->name;?>\r\n							<input type=\"checkbox\"  value=\"<?php echo $termId;?>\" name=\"compInfo[]\">\r\n							<div class=\"control__indicator\"></div>\r\n						</label>\r\n					<?php   $i++;\r\n							endforeach;?>\r\n				<?php endif;?>\r\n		    </div>\r\n		</div>\r\n	</div>\r\n	<div class=\"control-group\">\r\n        <div class=\"col-1-1 form-field\">\r\n	        <div class=\"col-1-2\">\r\n	        <h5 class=\"head-accordion open\">Compétences linguistiques<span class=\"required\">*</span></h5>\r\n	        <?php if ( !empty( $termLinguistiques ) && count( $termLinguistiques ) > 0 ):?>\r\n		        <ul class=\"list-parent\">\r\n		        <?php foreach ( $termLinguistiques[0] as $termParent ) :?>\r\n			        <li>\r\n			        <label class=\"control control--checkbox\"><?php echo $termParent[\'name\'];?>\r\n		                <input type=\"checkbox\"  value=\"<?php echo $termParent[\'id\'];?>\" name=\"langue[]\" class=\"parent\" data-class=\"<?php echo sanitize_title( $termParent[\'name\'] );?>\">\r\n		                <div class=\"control__indicator\"></div>\r\n		            </label>\r\n			        <?php if ( isset( $termLinguistiques[$termParent[\'id\']] ) && !empty( $termLinguistiques[$termParent[\'id\']] ) && count( $termLinguistiques[$termParent[\'id\']] ) > 0 ) :?>\r\n				        <ul class=\"list-children\">\r\n				        <?php foreach ( $termLinguistiques[$termParent[\'id\']][0] as $termChild ):?>\r\n					        <li>\r\n						        <label class=\"control control--radio\"><?php echo $termChild[\'name\'];?>\r\n		                            <input type=\"radio\"  value=\"<?php echo $termChild[\'id\'];?>\" name=\"<?php echo sanitize_title( $termParent[\'name\'] );?>\" class=\"<?php echo sanitize_title( $termParent[\'name\'] );?>\">\r\n		                            <div class=\"control__indicator\"></div>\r\n		                        </label>\r\n					        </li>\r\n				        <?php endforeach;?>\r\n				        </ul>\r\n			        <?php endif;?>\r\n			        </li>\r\n		        <?php endforeach;?>\r\n		        </ul>\r\n            <?php  endif;?>\r\n			</div>\r\n        </div>\r\n    </div>\r\n	<div class=\"control-group\">\r\n		<div class=\"col-1-1 form-field\">\r\n			<h5 class=\"head-accordion open\">Votre Message</h5>\r\n			<textarea name=\"<?php echo $form_items[\'message_postule\'];?>\" placeholder=\"Votre message\"></textarea>\r\n		</div>\r\n	</div>\r\n	<div class=\"control-group\">\r\n		<div class=\"col-1-1 form-field\">\r\n			<h5 class=\"head-accordion open\">Pièces jointes</h5>\r\n			<div class=\"col-1-2\">\r\n				<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240000\">\r\n				<input name=\"<?php echo $form_items[\'cv_postule\'];?>\" id=\"fileCv\" type=\"file\" class=\"inputfile\">\r\n				<label for=\"fileCv\" class=\"input-file-trigger\"><span>Mon CV *</span></label>\r\n				<span class=\"file-return cv\"></span>\r\n			</div>\r\n			<div class=\"col-1-2\">\r\n				<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240000\">\r\n				<input name=\"<?php echo $form_items[\'lm_postule\'];?>\" id=\"fileLm\" type=\"file\" class=\"inputfile\">\r\n				<label for=\"fileLm\" class=\"input-file-trigger\"><span>Ma lettre de motivation *</span></label>\r\n				<span class=\"file-return lm\"></span>\r\n\r\n			</div>\r\n		</div>\r\n	</div>\r\n	<div class=\"control-group\">\r\n		<div class=\"col-1-1 form-field\">\r\n			<h5 class=\"head-accordion open\">Autres documents </h5>\r\n			<div class=\"col-1-2\">\r\n				<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240000\">\r\n				<input name=\"<?php echo $form_items[\'autre_postule\'];?>\" id=\"fileAutre\" type=\"file\" class=\"inputfile\">\r\n				<label for=\"fileAutre\" class=\"input-file-trigger\"><span>Autres documents</span></label>\r\n				<span class=\"file-return\"></span>\r\n			</div>\r\n		</div>\r\n	</div>\r\n	<input type=\"submit\" name=\"fm_form_submit\" id=\"fm_form_submit\" class=\"submit\" value=\"Valider\" >\r\n	<input type=\"hidden\" name=\"<?php echo $form_items[\'entreprise_postule\']?>\" value=\"<?php echo $entreprise->titre;?>\">\r\n	<input type=\"hidden\" name=\"fm_nonce\" id=\"fm_nonce\" value=\"<?php echo wp_create_nonce(\'fm-nonce\');?>\" />\r\n	<input type=\"hidden\" name=\"fm_nonce\" id=\"fm_nonce\" value=\"<?php echo wp_create_nonce(\'fm-nonce\');?>\" />\r\n	<input type=\"hidden\" name=\"fm_id\" id=\"fm_id\" value=\"<?php echo $fm_display->currentFormInfo[\'ID\'];?>\" />\r\n	<input type=\"hidden\" name=\"fm_uniq_id\" id=\"fm_uniq_id\" value=\"fm-<?php echo uniqid();?>\" />\r\n	<input type=\"hidden\" name=\"fm_parent_post_id\" id=\"fm_parent_post_id\" value=\"<?php echo $postID;?>\" />\r\n<?php echo fm_form_end(); ?>\r\n','',1469106107);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
