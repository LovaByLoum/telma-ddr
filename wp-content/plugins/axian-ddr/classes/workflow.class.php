<?php
class AxianDDRWorkflow
{
    public static $etapes;
    public static $capabilities;
    public $societe;

    public static $types_demande = array(
        TYPE_DEMANDE_PREVU => 'Prévu',
        TYPE_DEMANDE_NON_PREVU => 'Non prévu',
    );

    public static $types_candidature = array(
        CANDIDATURE_INTERNE => 'Interne',
        CANDIDATURE_EXTERNE => 'Externe',
    );

    public static $actions = array(
        DDR_ACTION_CREATE => 'Créer',
        DDR_ACTION_SUBMIT => 'Soumettre',
        DDR_ACTION_VALIDATE => 'Valider',
        DDR_ACTION_REFUSE => 'Refuser',
        DDR_ACTION_CLOSE => 'Clôturer',
    );

    public static $etats = array(
        DDR_STATUS_DRAFT => 'Brouillon',
        DDR_STATUS_VALIDE => 'Validé',
        DDR_STATUS_EN_COURS => 'En cours',
        DDR_STATUS_REFUSE => 'Refusé',
        DDR_STATUS_ANNULE => 'Annulé',
        DDR_STATUS_CLOTURE => 'Clôturé',
    );

    public static $steps = array(
        DDR_STEP_CREATE => 'Création',
        DDR_STEP_VALIDATION_1 => 'Validation N1',
        DDR_STEP_VALIDATION_2 => 'Validation N2',
        DDR_STEP_VALIDATION_3 => 'Validation N3',
        DDR_STEP_VALIDATION_4 => 'Validation N4',
        DDR_STEP_PUBLISH => 'Publication',
        DDR_STEP_FINISH => 'Fini',
        DDR_STEP_CANCEL => 'Annulation'
    );
    public static $acteurs = array(
        DDR_ROLE_MANAGER => 'Manager',
        DDR_ROLE_ASSISTANTE_DIRECTION => 'Assistante de Direction',
        DDR_ROLE_ASSISTANTE_RH => 'Assistante RH',
        DDR_ROLE_CONTROLEUR_BUDGET => 'Controleur de Budget',
        DDR_ROLE_CONTROLEUR_DRH => 'DRH',
        DDR_ROLE_GESTIONNAIRE_TALENT => 'Gestionnaire de talent',
        DDR_ROLE_DG => 'DG',
    );


    public function __construct()
    {
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



        $this->fields = array(
            'nom' => array(
                'label' => 'Nom du workflow',
                'type' => 'text',
                'size' => '50',
                'name' => 'nom_workflow',
                'required' => true,
            ),
            'societe' => array(
                'label' => 'Société',
                'type' => 'select',
                'name' => 'societe_workflow',
                'size' => '50',
                'search' => true,
                'options' => AxianDDRUser::$company_list,
                'placeholder' => 'Choisir la société'
            ),
            /**'statut' => array(
                'type' => 'checkbox',
                'options' => array(
                    'name' => 'Statut',
                    'label' => 'statut_workflow',
                ),
            ),
            'etape' => array(
                'label' => 'Etape',
                'type' => 'select',
                'name' => 'etape_workflow',
                'options' => $this::$steps,
            ),
            'role' => array(
                'label' => 'Rôle',
                'type' => 'select multiple',
                'name' => 'role_workflow',
                'options' => $this::$acteurs
            ),
            'etat' => array(
                'label' => 'Etat',
                'type' => 'select',
                'name' => 'etat_workflow',
                'options' => $this::$etats
            ),
            'type_ticket' => array(
                'label' => 'Type de ticket',
                'type' => 'select',
                'name' => 'type_ticket_workflow',
                'options' => $this::$types_demande
            ),
            'action' => array(
                'label' => 'Action',
                'type' => 'select',
                'name' => 'type_ticket_workflow',
                'options' => $this::$actions
            ),**/
        );
    }

    public static function getWorkflowInfoBy($current_etape)
    {
        $workflow_etape_info = null;
        foreach (AxianDDRWorkflow::$etapes as $numero_etape => $data_etape) {
            if ($current_etape == $data_etape['etape']) {
                $next_numero_etape = $numero_etape + 1;
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

    public static function isUserInCurrentEtape($current_etape)
    {
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);

        if (isset($workflow_etape_info['workflow_info']['acteur'])) {
            foreach ($workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur) {
                if (in_array($role, $current_user->roles)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getTypeDemandeByRole($current_etape)
    {
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);
        if (isset($workflow_etape_info['workflow_info']['acteur'])) {
            foreach ($workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur) {
                if (in_array($role, $current_user->roles)) {
                    return $data_acteur['type'];
                }
            }
        }
        return false;
    }

    public static function isActionInCurrentActeurActions($current_etape, $current_action)
    {
        global $current_user;
        $workflow_etape_info = self::getWorkflowInfoBy($current_etape);
        if (isset($workflow_etape_info['workflow_info']['acteur'])) {
            foreach ($workflow_etape_info['workflow_info']['acteur'] as $role => $data_acteur) {
                if (in_array($role, $current_user->roles)) {
                    return in_array($current_action, $data_acteur['action']);
                }
            }
        }
        return false;
    }

    public static function checkActionActeurInEtape($current_etape, $current_action)
    {
        //verifier que l'acteur est present dans l'étape
        //verifier que l'action est présent dans les actions de l'acteur dans l'étape en cours
        return self::isUserInCurrentEtape($current_etape) && self::isActionInCurrentActeurActions($current_etape, $current_action);
    }

    public static function getValidatorByEtape($current_etape)
    {
        $current_workflow_etape = self::getWorkflowInfoBy($current_etape);
        $validateur = $glue = '';
        foreach ($current_workflow_etape['workflow_info']['acteur'] as $actor => $value) {
            if (DDR_ROLE_MANAGER != $actor) {
                $validateur .= $glue . $actor;
                $glue = '|';
            }
        }

        return $validateur;
    }

    public static function getby_id($id)
    {
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM ' . TABLE_AXIAN_DDR_WORKFLOW . ' WHERE id = ' . $id, ARRAY_A);

        return $result;
    }

    public static function getby($args = array(), $format = null)
    {
        $default_args = array(
            'offset' => 0,
            'limit' => 0,
            'nom' => 'tous',
            'orderby' => 'nom',
            'order' => 'ASC',
        );

        $args = wp_parse_args($args, $default_args);
        extract($args);

        global $wpdb;
        $query_select = "SELECT SQL_CALC_FOUND_ROWS * FROM  " . TABLE_AXIAN_DDR_WORKFLOW;

        //type
        if ($type != 'tous') {
            $query_select .= " WHERE type='{$type}'";
        }

        //ordre
        $query_select .= " ORDER BY {$orderby} {$order} ";

        //limit
        if ($offset && $limit) {
            $query_select .= " LIMIT {$offset},{$limit} ";
        }

        $result = $wpdb->get_results($query_select);
        if ($format == 'options') {
            $options = array();
            foreach ($result as $obj) {
                $options[$obj->id] = $obj->label;
            }
            return $options;
        }

        return array(
            'count' => sizeof($result),
            'items' => $result
        );
    }

    public function submit_workflow()
    {
        global $wpdb, $current_user;
        if (isset($_POST['submit-workflow'])) {

            $msg = axian_ddr_validate_fields($this);

            $the_user = AxianDDRUser::getById($current_user->ID);
            $post_data = $_POST;

            //$company = $the_user->company;
            $now = date("Y-m-d H:i:s");
            $nom = $post_data['nom_workflow'];
            $societe = $post_data['societe'];
            $par_defaut = $post_data['par_defaut'];
            foreach ($post_data['etat'] as $key => $value) {
                $etat = $value;
            }
            foreach ($post_data['etape'] as $key => $value) {
                $etape = $value;
            }
            foreach ($post_data['role'] as $key => $value) {
                $role = $value;
            }
            foreach ($post_data['type'] as $key => $value) {
                $type = $value;
            }
            //$action = $post_data['action'];
            $action = '';
            $createur = $the_user->ID;
            $date_creation = $now;
            $date_modification = '';

            if (!empty($msg)) {
                return array(
                    'code' => 'error',
                    'msg' => $msg,
                );
            } else {
                //process add workflow

                $return_add = self::add($nom, $societe, $createur, $par_defaut, $etat, $etape, $role, $type, $action, $date_creation, $date_modification);
            }
            if (!$return_add) {
                return array(
                    'code' => 'error',
                    'msg' => 'Erreur inconnu',
                );
            } else {
                //unset post
                unset($nom);
                unset($societe);
                unset($par_defaut);
                unset($etat);
                unset($etape);
                unset($role);
                unset($type);
                unset($action);
                unset($createur);
                unset($date_creation);
                unset($date_modification);
                return array(
                    'code' => 'updated',
                    'msg' => 'Enregistrement effectué avec succés.',
                );
            }

            // suppresion d'un workflow 

        } elseif (($_GET['action'] == "delete") && !empty($_GET['_wpnonce']) && !empty($_GET['id'])) {
            $nonce = wp_create_nonce('addr_delete_workflow' . absint($_GET['id']));


            if ($nonce != $_GET['_wpnonce']) {
                return array(
                    'code' => 'error',
                    'msg' => 'Action denied',
                );
            } else {
                //process delete term
                $return_update = self::delete(absint($_GET['id']));

                if ($return_update) {
                    //unset post
                    unset($_POST['id']);
                    unset($_POST['nom']);
                    unset($_POST['date_creation']);
                    unset($_GET['createur']);
                    unset($_GET['date_modification']);
                    unset($_GET['societe']);
                    unset($_GET['statut']);
                    unset($_GET['etape']);
                    unset($_GET['etat']);
                    unset($_GET['role']);
                    unset($_GET['type_ticket']);
                    unset($_GET['action']);

                    return array(
                        'code' => 'updated',
                        'msg' => 'Suppresion effectué avec succés.',
                    );
                }
            }
        } else {
            return false;
        }
    }

    // sauvegarde db

    public static function add($nom, $date_creation, $createur,  $societe, $statut, $etape, $etat, $role, $type_ticket, $action, $date_modification)
    {
        global $wpdb;

        $result = $wpdb->insert(TABLE_AXIAN_DDR_WORKFLOW, array(
            'nom' => $nom,
            'date_creation' => $date_creation,
            'createur' => $createur,
            'societe' => $societe,
            'statut' => $statut,
            'etape' => $etape,
            'etat' => $etat,
            'role' => $role,
            'type' => $type_ticket,
            'action' => $action,
            'date_modification' => $date_modification
        ));
        if ($result) {
            $workflow_id = $wpdb->insert_id;
            return $workflow_id;
        } else return $result;
    }

    public static function delete($id)
    {
        global $wpdb;
        $result = $wpdb->delete(TABLE_AXIAN_DDR_WORKFLOW, array('id' => $id));

        return $result;
    }
}
global $axian_ddr_workflow;
$axian_ddr_workflow = new AxianDDRWorkflow();
