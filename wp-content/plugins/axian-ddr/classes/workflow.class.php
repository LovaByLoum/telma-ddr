<?php
class AxianDDRWorkflow{

    public $etapes;
    public function __construct(){
        //workflow statique
        $this->etapes = array(
            //etape 1
            1 => array(
                'etat' => array(
                    DDR_STATUS_EN_COURS,
                    DDR_STATUS_DRAFT
                ),
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
                        ),
                        'type' => TYPE_DEMANDE_NON_PREVU
                    ),
                    array(
                        'role' => DDR_ROLE_ASSISTANTE_DIRECTION,
                        'capabilities' => array(
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
                        ),
                        'type' => TYPE_DEMANDE_PREVU
                    ),
                ),
                'action' => array(DDR_ACTION_CREATE, DDR_ACTION_UPDATE, DDR_ACTION_SUBMIT),
            ),

            //etape 2
            2 => array(
                'etat' => array(
                    DDR_STATUS_EN_COURS
                ),
                'etape' => DDR_STEP_VALIDATION_1,
                'acteur' => array(
                    array(
                        'role' => DDR_ROLE_ASSISTANTE_RH,
                        'capabilities' => array(
                            DDR_CAP_CAN_LIST_DDR,
                            DDR_CAP_CAN_LIST_OTHERS_DDR,
                            DDR_CAP_CAN_VIEW_DDR,
                            DDR_CAP_CAN_VIEW_OTHERS_DDR,
                            DDR_CAP_CAN_VALIDATE_DDR,
                            DDR_CAP_CAN_REFUSE_DDR,
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
            ),

            //etape 3
            3 => array(
                'etat' => array(
                    DDR_STATUS_EN_COURS
                ),
                'etape' => DDR_STEP_VALIDATION_3,
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
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
            ),

            //etape 4
            4 => array(
                'etat' => array(
                    DDR_STATUS_VALIDE
                ),
                'etape' => DDR_STEP_VALIDATION_4,
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
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_VALIDATE, DDR_ACTION_REFUSE),
            ),

            //etape 5
            5 => array(
                'etat' => array(
                    DDR_STATUS_CLOTURE
                ),
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
                        )
                    ),
                ),
                'action' => array(DDR_ACTION_CLOSE),
            ),

        );

    }
}
global $axian_ddr_workflow;
$axian_ddr_workflow = new AxianDDRWorkflow();