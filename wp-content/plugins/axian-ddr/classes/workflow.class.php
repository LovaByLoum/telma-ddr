<?php
class AxianDDRWorkflow{

    public static $etapes;
    public static $capabilities;
    public function __construct(){
        //capabilities statiques
        self::$capabilities = array(

            DDR_ROLE_ADMINISTRATEUR_DDR => array(
                DDR_CAP_CAN_CREATE_DDR,
                DDR_CAP_CAN_SUBMIT_DDR,
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_LIST_OTHERS_DDR,
                DDR_CAP_CAN_DELETE_DDR,
                DDR_CAP_CAN_DELETE_OTHERS_DDR,
                DDR_CAP_CAN_EDIT_DDR,
                DDR_CAP_CAN_EDIT_OTHERS_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_VIEW_OTHERS_DDR,
                DDR_CAP_CAN_VALIDATE_DDR,
                DDR_CAP_CAN_REFUSE_DDR,
                DDR_CAP_CAN_CLOSE_DDR,
                DDR_CAP_CAN_ADMIN_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
                DDR_CAP_CAN_EXPORT_OTHERS_DDR,
            ),

            DDR_ROLE_MANAGER => array(
                DDR_CAP_CAN_CREATE_DDR,
                DDR_CAP_CAN_SUBMIT_DDR,
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_DELETE_DDR,
                DDR_CAP_CAN_EDIT_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_EXPORT_DDR
            ),

            DDR_ROLE_ASSISTANTE_DIRECTION => array(
                DDR_CAP_CAN_CREATE_DDR,
                DDR_CAP_CAN_SUBMIT_DDR,
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_DELETE_DDR,
                DDR_CAP_CAN_EDIT_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
            ),

            DDR_ROLE_ASSISTANTE_RH => array(
                DDR_CAP_CAN_CREATE_DDR,
                DDR_CAP_CAN_SUBMIT_DDR,
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_DELETE_DDR,
                DDR_CAP_CAN_EDIT_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
            ),

            DDR_ROLE_CONTROLEUR_BUDGET => array(
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
            ),

            DDR_ROLE_DRH => array(
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_LIST_OTHERS_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_VIEW_OTHERS_DDR,
                DDR_CAP_CAN_VALIDATE_DDR,
                DDR_CAP_CAN_REFUSE_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
                DDR_CAP_CAN_EXPORT_OTHERS_DDR,
            ),

            DDR_ROLE_DG => array(
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_LIST_OTHERS_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_VIEW_OTHERS_DDR,
                DDR_CAP_CAN_VALIDATE_DDR,
                DDR_CAP_CAN_REFUSE_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
                DDR_CAP_CAN_EXPORT_OTHERS_DDR,
            ),

            DDR_ROLE_GESTIONNAIRE_TALENT => array(
                DDR_CAP_CAN_LIST_DDR,
                DDR_CAP_CAN_LIST_OTHERS_DDR,
                DDR_CAP_CAN_VIEW_DDR,
                DDR_CAP_CAN_VIEW_OTHERS_DDR,
                DDR_CAP_CAN_CLOSE_DDR,
                DDR_CAP_CAN_EXPORT_DDR,
                DDR_CAP_CAN_EXPORT_OTHERS_DDR,
            )

        );

        //workflow statique
        self::$etapes = array(
            //etape 1
            1 => array(
                'etat' => DDR_STATUS_DRAFT,
                'etape' => DDR_STEP_CREATE,
                'acteur' => array(
                    DDR_ROLE_MANAGER => array(
                        'type' => TYPE_DEMANDE_NON_PREVU,
                        'action' => array(DDR_ACTION_CREATE, DDR_ACTION_UPDATE, DDR_ACTION_SUBMIT, DDR_ACTION_DELETE),
                    ),

                    DDR_ROLE_ASSISTANTE_DIRECTION => array(
                        'type' => TYPE_DEMANDE_PREVU,
                        'action' => array(DDR_ACTION_CREATE, DDR_ACTION_UPDATE, DDR_ACTION_SUBMIT, DDR_ACTION_DELETE),
                    ),

                    DDR_ROLE_ASSISTANTE_RH => array(
                        'type' => TYPE_DEMANDE_PREVU,
                        'action' => array(DDR_ACTION_CREATE, DDR_ACTION_UPDATE, DDR_ACTION_SUBMIT, DDR_ACTION_DELETE),
                    ),
                ),

            ),

            //etape 2
            2 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_1,
                'acteur' => array(
                    DDR_ROLE_CONTROLEUR_BUDGET => array(
                        'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE, DDR_ACTION_UPDATE),
                    ),
                    DDR_ROLE_MANAGER => array(
                        'action' => array(DDR_ACTION_CANCEL)
                    ),

                    DDR_ROLE_ASSISTANTE_DIRECTION => array(
                        'action' => array(DDR_ACTION_CANCEL)
                    ),

                    DDR_ROLE_ASSISTANTE_RH => array(
                        'action' => array(DDR_ACTION_CANCEL)
                    ),
                ),
            ),

            //etape 3
            3 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_2,
                'acteur' => array(
                    DDR_ROLE_DRH => array(
                        'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE)
                    ),
                ),
            ),

            //etape 4
            4 => array(
                'etat' => DDR_STATUS_EN_COURS,
                'etape' => DDR_STEP_VALIDATION_3,
                'acteur' => array(
                    DDR_ROLE_DG => array(
                        'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
                    )
                ),
            ),

            //etape 5
            5 => array(
                'etat' => DDR_STATUS_VALIDE,
                'etape' => DDR_STEP_PUBLISH,
                'acteur' => array(
                    DDR_ROLE_GESTIONNAIRE_TALENT => array(
                        'action' => array(DDR_ACTION_CLOSE),
                    ),
                ),
            ),

            //etape 6
            6 => array(
                'etat' => DDR_STATUS_REFUSE,
                'etape' => DDR_STEP_REFUSE,
                'acteur' => array(
                    DDR_ROLE_GESTIONNAIRE_TALENT => array(
                        'action' => array(DDR_ACTION_DELETE),
                    ),
                ),
            ),

            //etape 7 finish
            7 => array(
                'etat' => DDR_STATUS_CLOTURE,
                'etape' => DDR_STEP_FINISH,
                'acteur' => array(
                    DDR_ROLE_GESTIONNAIRE_TALENT => array(
                        'action' => array(DDR_ACTION_DELETE),
                    )
                ),
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

        if ( isset($workflow_etape_info['workflow_info']['acteur']) ){
            foreach ( $workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur ){
                if ( in_array($role, $current_user->roles) ){
                    return true;
                }
            }
        }
        return false;
    }

    public static function getTypeDemandeByRole($current_etape){
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);
        if ( isset($workflow_etape_info['workflow_info']['acteur']) ){
            foreach ( $workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur ){
                if ( in_array($role, $current_user->roles) ){
                    return $data_acteur['type'];
                }
            }
        }
        return false;
    }

    public static function isActionInCurrentActeurActions($current_etape, $current_action){
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);
        if ( isset($workflow_etape_info['workflow_info']['acteur']) ){
            foreach ( $workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur ){
                if ( in_array($role, $current_user->roles) ){
                    return in_array($current_action, $data_acteur['action']);
                }
            }
        }
        return false;
    }

    public static function checkActionActeurInEtape( $current_etape, $current_action ){
        //verifier que l'acteur est present dans l'étape
        //verifier que l'action est présent dans les actions de l'acteur dans l'étape en cours
        return self::isUserInCurrentEtape($current_etape) && self::isActionInCurrentActeurActions($current_etape, $current_action);
    }

    public static function getValidatorByEtape( $current_etape ){
        $current_workflow_etape = self::getWorkflowInfoBy($current_etape);
        $validateur = $glue = '';
        foreach($current_workflow_etape['workflow_info']['acteur'] as $actor => $value){
            if(DDR_ROLE_MANAGER != $actor){
                $validateur .= $glue .$actor;
                $glue = '|';
            }
        }

        return $validateur;
    }

}
global $axian_ddr_workflow;
$axian_ddr_workflow = new AxianDDRWorkflow();