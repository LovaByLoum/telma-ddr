<?php
global $axian_ddr_settings;
global $axian_ddr_administration;
global $axian_ddr_workflow;
$result = AxianDDRWorkflow::submit_workflow();
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'workflow';
$user_demandeur = AxianDDRUser::getById($current_user->ID); // user connécté

$post_data = null;

$isNew = isset($_GET['add']) ? true : false;
?>
<?php if (!$isNew) : ?>
    <?php if ($result) : ?>
        <div class="notice <?php echo $result['code']; ?>">
            <p><?php echo $result['msg']; ?></p>
        </div>
        !<?php endif; ?>


    <div class="wrap nosubsub">

        <h1 class="wp-heading-inline">Administration des workflows</h1>
        <?php if (current_user_can(DDR_CAP_CAN_CREATE_DDR)) : ?>
            <a href="?page=axian-ddr-admin&amp;tab=workflow&amp;add=new" class="page-title-action ajouter_workflow">Ajouter un workflow</a>
        <?php endif; ?>

        <?php if (isset($_GET['msg'])) :
            $msg = AxianDDR::manage_message($_GET['msg']) ?>
            <div class="notice <?php echo $msg['code']; ?>">
                <p><?php echo $msg['msg']; ?></p>
            </div>
        <?php endif; ?>
        <hr class="wp-header-end">
        <br>
        <form method="post" action="">
            <?php
            $list_term = new AxianDDRWorkflowList();
            $list_term->prepare_items();
            $list_term->display();
            ?>

        </form>



    </div><!-- .wrap -->
<?php else : ?>
    <div class="wrap nosubsub">


        <div class="wrap">
            <h1 class="wp-heading-inline">Administration des workflows</h1>

            <form id="form-workflow-edit" action="" method="post" autocomplete="off">
                <div class="form-field-wrapper">
                    <label class="form-label">Nom</label>
                    <div class="form-field">
                        <input type="text" class="form-control" name="nom_workflow" id="label_workflow" placeholder="Nom du workflow">
                    </div>
                </div>

                <div class="form-field-wrapper">
                    <label class="form-label">Société</label>
                    <div class="form-field">
                        <?php axian_ddr_render_field($axian_ddr_workflow->fields['societe'], $post_data, false); ?>
                    </div>
                </div>

                <div class="form-field-wrapper">
                    <label class="form-label">Par défaut</label>
                    <div class="form-field">
                        <input class="form-check-input" type="checkbox" value="1" name="par_defaut" id="par_defaut">
                    </div>
                </div>

                <div class="wrapper-etape-workflow">
                    <button type="button" class="btn btn-secondary ajout_etape">Ajouter une étape</button>

                    <div class="wrapper-etape row">
                        <input type="hidden" class="bloc_etape_number" value="0" />

                        <div class="bloc_etape item clone col-md-3 col-sm-4 col-xs-12">
                            <div style="float:right;">
                                <button type="button" class="close-bloc btn btn-default" style="height:30px;width:30px; float:right; background: tomato;">
                                    <span aria-hidden="true" style="text-align: center;"> &times;&nbsp;&nbsp;</span>
                                </button>
                            </div>

                            <div class="form-group form-field-wrapper">
                                <label class="form-label">Etat</label>
                                <div class="form-field">
                                    <select name="workflow[etat][_row_index_etape]" class="custom-select">
                                        <?php foreach (AxianDDR::$etats as $etat => $label) : ?>
                                            <option value="<?php echo $etat; ?>"><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-field-wrapper">
                                <label class="form-label">Etape</label>
                                <div class="form-field">
                                    <select name="workflow[etape][_row_index_etape]" class="custom-select">
                                        <?php foreach (AxianDDR::$etapes as $etape => $label) : ?>
                                            <option value="<?php echo $etape; ?>"><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="roles-fields-wrapper">
                                <button type="button" class="btn btn-secondary btn-sm ajout_role">Ajouter rôles</button>

                                <div class="roles-wrapper">
                                    <input type="hidden" class="bloc_role_number" value="0" />
                                    <div class="bloc_role item clone">

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Rôle</label>
                                            <div class="form-field">
                                                <select name="workflow[roles][_row_index_etape][role][_row_index_role]" class="custom-select">
                                                    <?php foreach (AxianDDRWorkflow::$acteurs as $role => $label) : ?>
                                                        <option value="<?php echo $role; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Type de demande</label>
                                            <div class="form-field">
                                                <select name="workflow[roles][_row_index_etape][type][_row_index_role]" class="custom-select">
                                                    <?php foreach (AxianDDRWorkflow::$types_demande as $type => $label) : ?>
                                                        <option value="<?php echo $type; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Actions</label>
                                            <div class="form-field">
                                                <select multiple name="workflow[roles][_row_index_etape][actions][_row_index_role][]" class="custom-select">
                                                    <?php foreach (AxianDDRWorkflow::$actions as $action => $label) : ?>
                                                        <option value="<?php echo $action; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>


                        </div>


                    </div>

                </div>

                <p class="submit">
                    <input type="submit" name="submit-workflow" id="submit-workflow" class="button button-primary" value="Créer le workflow">
                </p>
            </form>
        </div>


    </div>

<?php endif; ?>