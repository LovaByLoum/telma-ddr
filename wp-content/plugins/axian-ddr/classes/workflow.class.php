<?php
class AxianDDRWorkflow{

    public static $etapes;
    public function __construct(){
        //workflow statique
        self::$etapes = array(
            //etape 1
            1 => array(
                'etat' => DDR_STATUS_DRAFT,
                'etape' => DDR_STEP_CREATE,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_MANAGER,
                        'capabilities' => array(
                            DDR_CAP_CAN_CREATE_DDR,
                            DDR_CAP_CAN_SUBMIT_DDR,
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_DELETE_DDR,
                            DDR_CAP_CAN_EDIT_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_EXPORT_DDR
                        ),
                        'type' => TYPE_DEMANDE_NON_PREVU
                    ),
                    array(
                        'role' => DDR_ROLE_ASSISTANTE_DIRECTION,
                        'capabilities' => array(
                            DDR_CAP_CAN_CREATE_DDR,
                            DDR_CAP_CAN_SUBMIT_DDR,
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_DELETE_DDR,
                            DDR_CAP_CAN_EDIT_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                        ),
                        'type' => TYPE_DEMANDE_PREVU
                    ),
                ),
                'action' => array(DDR_ACTION_CREATE, DDR_ACTION_UPDATE, DDR_ACTION_SUBMIT, DDR_ACTION_DELETE),
            ),

            //etape 2
            2 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_1,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_ASSISTANTE_RH,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_DELETE_DDR,
                            DDR_CAP_CAN_DELETE_OTHERS_DDR,
                            DDR_CAP_CAN_EDIT_DDR,
                            DDR_CAP_CAN_EDIT_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                            DDR_CAP_CAN_VALIDATE_DDR,
                            DDR_CAP_CAN_REFUSE_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE, DDR_ACTION_UPDATE),
            ),

            //etape 3
            3 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_2,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_DRH,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_VALIDATE_DDR,
                            DDR_CAP_CAN_REFUSE_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
            ),

            //etape 4
            4 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_3,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_DG,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_VALIDATE_DDR,
                            DDR_CAP_CAN_REFUSE_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
            ),

            //etape 5
            5 => array(
                'etat' => DDR_STATUS_VALIDE,
                'etape' => DDR_STEP_PUBLISH,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_GESTIONNAIRE_TALENT,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_CLOSE_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_CLOSE),
            ),

            //etape 6
            6 => array(
                'etat' => DDR_STATUS_REFUSE,
                'etape' => DDR_STEP_REFUSE,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_GESTIONNAIRE_TALENT,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_CLOSE_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_DELETE),
            ),

            //etape 7 finish
            7 => array(
                'etat' => DDR_STATUS_CLOTURE,
                'etape' => DDR_STEP_FINISH,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_GESTIONNAIRE_TALENT,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_CLOSE_DDR,
                            DDR_CAP_CAN_EXPORT_DDR,
                            DDR_CAP_CAN_EXPORT_OTHERS_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_DELETE),
            ),
        );

    }

    public static function getWorkflowInfoBy( $current_etape  ){
        $workflow_etape_info = null;
        foreach ( AxianDDRWorkflow::$etapes as $numero_etape => $data_etape ){
            if ( $current_etape == $data_etape['etape'] ){
                $next_numero_etape = $numero_etape+1;
                $next_etape = isset(AxianDDRWorkflow::$etapes[$next_numero_etape]) ? AxianDDRWorkflow::$etapes[$next_numero_etape] : null;
                $workflow_etape_info = array(
                    'numero_step' => $numero_etape,
                    'next_numero_step' => $next_numero_etape,
                    'next_etape' => $next_etape['etape'],
                    'next_etat' => $next_etape['etat'],
                    'workflow_info' => AxianDDRWorkflow::$etapes[$numero_etape]
                );
            }
        }
        return $workflow_etape_info;
    }

    public static function isUserInCurrentEtape( $current_etape ){
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);
        foreach ( $workflow_etape_info['workflow_info']['acteur'] as $acteur ){
            if ( in_array($acteur['role'], $current_user->roles) ){
                return true;
            }
        }
        return false;
    }
}
global $axian_ddr_workflow;
$axian_ddr_workflow = new AxianDDRWorkflow();