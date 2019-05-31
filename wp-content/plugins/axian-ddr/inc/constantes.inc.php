<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Njaratiana
 * Date: 09/05/19
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 *
 */

//url
define ( 'AXIANDDR_PLUGIN_URL' , plugins_url(basename(dirname(dirname(__FILE__)))) );

//etat
define('DDR_STATUS_DRAFT','draft');
define('DDR_STATUS_VALIDE','valid');
define('DDR_STATUS_EN_COURS','in_progress');
define('DDR_STATUS_REFUSE','denied');
define('DDR_STATUS_ANNULE','canceled');
define('DDR_STATUS_CLOTURE','finished');

//etape
define('DDR_STEP_CREATE','create');
define('DDR_STEP_VALIDATION_1','validation1');
define('DDR_STEP_VALIDATION_2','validation2');
define('DDR_STEP_VALIDATION_3','validation3');
define('DDR_STEP_VALIDATION_4','validation4');
define('DDR_STEP_PUBLISH','publish');
define('DDR_STEP_FINISH','finish');
define('DDR_STEP_REFUSE','refuse');
define('DDR_STEP_CANCEL','annulation');

//action
define('DDR_ACTION_CREATE','create');
define('DDR_ACTION_UPDATE','update');
define('DDR_ACTION_DELETE','delete');
define('DDR_ACTION_SUBMIT','submit');
define('DDR_ACTION_VALIDATE','validate');
define('DDR_ACTION_REFUSE','refuse');
define('DDR_ACTION_CANCEL','cancel');
define('DDR_ACTION_CLOSE','close');

//type candidat
define('CANDIDATURE_INTERNE','internal');
define('CANDIDATURE_EXTERNE','external');

//type demande
define('TYPE_DEMANDE_PREVU','planned');
define('TYPE_DEMANDE_NON_PREVU','not_planned');

//msg
define('DDR_MSG_SAVED_SUCCESSFULLY', 'saved-successfully');
define('DDR_MSG_SUBMITTED_SUCCESSFULLY', 'submitted-successfully');
define('DDR_MSG_DELETED_SUCCESSFULLY', 'deleted-successfully');
define('DDR_MSG_VALIDATED_SUCCESSFULLY', 'validated-successfully');
define('DDR_MSG_INVALIDATED_SUCCESSFULLY', 'invalidated-successfully');
define('DDR_MSG_CLOSED_SUCCESSFULLY', 'closed-successfully');
define('DDR_MSG_CANCELED_SUCCESSFULLY', 'canceled-successfully');
define('DDR_MSG_ACTION_DENIED', 'action-denied');
define('DDR_MSG_VALIDATE_ERROR', 'validate-error');
define('DDR_MSG_UNKNOWN_ERROR', 'unknown-error');

//role
define('DDR_ROLE_ADMINISTRATEUR_DDR', 'administrateur-ddr');
define('DDR_ROLE_MANAGER', 'manager');
define('DDR_ROLE_ASSISTANTE_DIRECTION', 'assistante-direction');
define('DDR_ROLE_ASSISTANTE_RH', 'assistante-rh');
define('DDR_ROLE_CONTROLEUR_BUDGET', 'controleur-budgetaire');
define('DDR_ROLE_DRH', 'drh');
define('DDR_ROLE_DG', 'dg');
define('DDR_ROLE_GESTIONNAIRE_TALENT', 'responsable_rh'); //même que le role qui peut gérer les offres

//capabilities
define('DDR_CAP_CAN_CREATE_DDR', 'can-create-ddr');
define('DDR_CAP_CAN_SUBMIT_DDR', 'can-submit-ddr');
define('DDR_CAP_CAN_LIST_DDR', 'can-list-ddr');
define('DDR_CAP_CAN_LIST_OTHERS_DDR', 'can-list-others-ddr');
define('DDR_CAP_CAN_DELETE_DDR', 'can-delete-ddr');
define('DDR_CAP_CAN_DELETE_OTHERS_DDR', 'can-delete-others-ddr');
define('DDR_CAP_CAN_EDIT_DDR', 'can-edit-ddr');
define('DDR_CAP_CAN_EDIT_OTHERS_DDR', 'can-edit-others-ddr');
define('DDR_CAP_CAN_VIEW_DDR', 'can-view-ddr');
define('DDR_CAP_CAN_VIEW_OTHERS_DDR', 'can-view-others-ddr');
define('DDR_CAP_CAN_VALIDATE_DDR', 'can-validate-ddr');
define('DDR_CAP_CAN_REFUSE_DDR', 'can-refuse-ddr');
define('DDR_CAP_CAN_CLOSE_DDR', 'can-close-ddr');
define('DDR_CAP_CAN_ADMIN_DDR', 'can-admin-ddr');
define('DDR_CAP_CAN_EXPORT_DDR', 'can-export-ddr');
define('DDR_CAP_CAN_EXPORT_OTHERS_DDR', 'can-export-others-ddr');

//Table name
global $wpdb;
define('TABLE_AXIAN_DDR', $wpdb->prefix . 'ddr');
define('TABLE_AXIAN_DDR_HISTORIQUE', $wpdb->prefix . 'ddr_historique');
define('TABLE_AXIAN_DDR_INTERIM', $wpdb->prefix . 'ddr_interim');
define('TABLE_AXIAN_DDR_TERM', $wpdb->prefix . 'ddr_term');

define ( 'DDR_SETTINGS_NAME', 'axian_ddr_settings');