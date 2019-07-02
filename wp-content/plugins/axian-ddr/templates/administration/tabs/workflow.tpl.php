<?php
global $axian_ddr_settings;
global $axian_ddr_administration;
global $axian_ddr_workflow;
global $ddr_workflow_process_msg;

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'workflow';
$user_demandeur = AxianDDRUser::getById($current_user->ID); // user connécté

if (( isset($_GET['action']) && $_GET['action'] == 'edit') && (isset($_GET['id']) && !empty($_GET['id']))) {
	$post_data = $axian_ddr_workflow->getById(intval($_GET['id']));
    $coche = isset($post_data['statut']) ? true : false;
    $etapes = unserialize($post_data['etape']);
} else {
    $post_data = null;
}


$is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
$is_new = isset($_GET['add']) ? true : false;
$is_list = !$is_edit && !$is_new;

if ( isset($_GET['msg']) ){
    $msg = AxianDDR::manage_message($_GET['msg']);
}

if ( !is_null($ddr_workflow_process_msg) ){
    $msg = $ddr_workflow_process_msg;
}

?>
<?php if ( $is_list ) : ?>

    <?php if ($msg) : ?>
        <div class="notice <?php echo $msg['code']; ?>">
            <p><?php echo $msg['msg']; ?></p>
        </div>
    <?php endif; ?>

    <div class="wrap nosubsub">

        <h1 class="wp-heading-inline">Administration des workflows</h1>

        <?php if (current_user_can(DDR_CAP_CAN_ADMIN_DDR)) : ?>
            <a href="?page=axian-ddr-admin&amp;tab=workflow&amp;add=new" class="page-title-action ajouter_workflow">Ajouter un workflow</a>
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
<?php elseif ( $is_new || $is_edit ) : ?>
    <?php $wid = isset($_GET['id']) ? $_GET['id'] : null;?>
    <?php if ($msg) : ?>
        <div class="notice <?php echo $msg['code']; ?>">
            <p><?php echo $msg['msg']; ?></p>
        </div>
    <?php endif; ?>

    <div class="wrap nosubsub">

        <div class="wrap">
            <h1 class="wp-heading-inline"><?php if ( $is_new ) :?>Ajouter un WorkFlow<?php else: ?>Modification du workflow N°<?php echo $wid;?><?php endif;?></h1>

            <form id="form-workflow-edit" action="" method="post" autocomplete="off">
                <div class="form-field-wrapper">
                    <label class="form-label">Nom *</label>
                    <div class="form-field">
                        <input type="text" class="form-control" name="nom" id="label_workflow" placeholder="Nom du workflow" style="width: 199px;" value="<?php echo isset($post_data['nom']) ? $post_data['nom'] : '';?>">
                    </div>
                </div>

                <div class="form-field-wrapper">
                    <label class="form-label">Société *</label>
                    <div class="form-field">
                        <?php axian_ddr_render_field($axian_ddr_workflow->fields['societe'], $post_data, false); ?>
                    </div>
                </div>

                <div class="form-field-wrapper">
                    <label class="form-label">Par défaut</label>
                    <div class="form-field">
                        <input class="form-check-input" type="checkbox" value="1" name="statut" id="par_defaut" <?php if ( isset($post_data['statut']) && $post_data['statut'] == 'par_defaut' ){ echo 'checked';} ;?>>
                    </div>
                </div>

                <div class="wrapper-etape-workflow">
                    <button type="button" class="btn btn-secondary ajout_etape">Ajouter une étape *</button>

                    <div class="wrapper-etape row">
                        <input type="hidden" class="bloc_etape_number" value="<?php echo sizeof($etapes);?>" />

                        <div class="bloc_etape item clone col-md-3 col-sm-4 col-xs-12">
                            <button type='button' class='remove-bloc' style="float: right;">x</button>

                            <div class="form-group form-field-wrapper">
                                <label class="form-label">Etat</label>
                                <div class="form-field">
                                    <select name="workflow[etat][_row_index_etape]" class="custom-select etat">
                                        <?php foreach (AxianDDR::$etats as $etat => $label) : ?>
                                            <option value="<?php echo $etat; ?>"><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-field-wrapper">
                                <label class="form-label">Etape</label>
                                <div class="form-field">
                                    <select name="workflow[etape][_row_index_etape]" class="custom-select etape">
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

                                        <button type='button' class='remove-bloc-role' style="float: right;">x</button>

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Rôle</label>
                                            <div class="form-field">
                                                <select name="workflow[roles][_row_index_etape][role][_row_index_role]" class="custom-select role">
                                                    <?php foreach (AxianDDRWorkflow::$acteurs as $role => $label) : ?>
                                                        <option value="<?php echo $role; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Type</label>
                                            <div class="form-field">
                                                <select name="workflow[roles][_row_index_etape][type][_row_index_role]" class="custom-select type">
                                                    <?php foreach (AxianDDRWorkflow::$types_demande as $type => $label) : ?>
                                                        <option value="<?php echo $type; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-field-wrapper">
                                            <label class="form-label">Actions</label>
                                            <div class="form-field">
                                                <select multiple name="workflow[roles][_row_index_etape][actions][_row_index_role][]" class="custom-select actions">
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


                        <!--items etape-->
                        <?php if ( !empty($etapes ) ):?>
                            <?php foreach ( $etapes as $key_etape_index => $bloc_etape ) : ?>
                                <div class="bloc_etape item col-md-3 col-sm-4 col-xs-12">
                                    <button type='button' class='remove-bloc' style="float: right;">x</button>

                                    <div class="form-group form-field-wrapper">
                                        <label class="form-label">Etat</label>
                                        <div class="form-field">
                                            <select name="workflow[etat][<?php echo $key_etape_index;?>]" class="custom-select etat">
                                                <?php foreach (AxianDDR::$etats as $etat => $label) : ?>
                                                    <option value="<?php echo $etat; ?>" <?php if($bloc_etape['etat']==$etat):?>selected="selected"<?php endif;?>><?php echo $label; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-field-wrapper">
                                        <label class="form-label">Etape</label>
                                        <div class="form-field">
                                            <select name="workflow[etape][<?php echo $key_etape_index;?>]" class="custom-select etape">
                                                <?php foreach (AxianDDR::$etapes as $etape => $label) : ?>
                                                    <option value="<?php echo $etape; ?>" <?php if($bloc_etape['etape']==$etape):?>selected="selected"<?php endif;?>><?php echo $label; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="roles-fields-wrapper">
                                        <button type="button" class="btn btn-secondary btn-sm ajout_role">Ajouter rôles</button>

                                        <div class="roles-wrapper">

                                            <input type="hidden" class="bloc_role_number" value="<?php echo sizeof($bloc_etape['acteur']);?>" />

                                            <div class="bloc_role item clone">

                                                <button type='button' class='remove-bloc-role' style="float: right;">x</button>

                                                <div class="form-group form-field-wrapper">
                                                    <label class="form-label">Rôle</label>
                                                    <div class="form-field">
                                                        <select name="workflow[roles][_row_index_etape][role][_row_index_role]" class="custom-select role">
                                                            <?php foreach (AxianDDRWorkflow::$acteurs as $role => $label) : ?>
                                                                <option value="<?php echo $role; ?>"><?php echo $label; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-field-wrapper">
                                                    <label class="form-label">Type</label>
                                                    <div class="form-field">
                                                        <select name="workflow[roles][_row_index_etape][type][_row_index_role]" class="custom-select type">
                                                            <?php foreach (AxianDDRWorkflow::$types_demande as $type => $label) : ?>
                                                                <option value="<?php echo $type; ?>"><?php echo $label; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-field-wrapper">
                                                    <label class="form-label">Actions</label>
                                                    <div class="form-field">
                                                        <select multiple name="workflow[roles][_row_index_etape][actions][_row_index_role][]" class="custom-select actions">
                                                            <?php foreach (AxianDDRWorkflow::$actions as $action => $label) : ?>
                                                                <option value="<?php echo $action; ?>"><?php echo $label; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--items role-->
                                            <?php
                                            $acteurs = $bloc_etape['acteur'];
                                            $key_role_index = 1;
                                            if ( !empty($acteurs ) ): ?>
                                                <?php foreach ( $acteurs as $current_acteur => $bloc_acteur ) : ?>
                                                    <div class="bloc_role item">

                                                        <button type='button' class='remove-bloc-role' style="float: right;">x</button>

                                                        <div class="form-group form-field-wrapper">
                                                            <label class="form-label">Rôle</label>
                                                            <div class="form-field">
                                                                <select name="workflow[roles][<?php echo $key_etape_index;?>][role][<?php echo $key_role_index;?>]" class="custom-select role">
                                                                    <?php foreach (AxianDDRWorkflow::$acteurs as $role => $label) : ?>
                                                                        <option value="<?php echo $role; ?>" <?php if($current_acteur==$role):?>selected="selected"<?php endif;?>><?php echo $label; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-field-wrapper">
                                                            <label class="form-label">Type</label>
                                                            <div class="form-field">
                                                                <select name="workflow[roles][<?php echo $key_etape_index;?>][type][<?php echo $key_role_index;?>]" class="custom-select type">
                                                                    <?php foreach (AxianDDRWorkflow::$types_demande as $type => $label) : ?>
                                                                        <option value="<?php echo $type; ?>" <?php if($bloc_acteur['type']==$type):?>selected="selected"<?php endif;?>><?php echo $label; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-field-wrapper">
                                                            <label class="form-label">Actions</label>
                                                            <div class="form-field">
                                                                <select multiple name="workflow[roles][<?php echo $key_etape_index;?>][actions][<?php echo $key_role_index;?>][]" class="custom-select actions">
                                                                    <?php foreach (AxianDDRWorkflow::$actions as $action => $label) : ?>
                                                                        <option value="<?php echo $action; ?>" <?php if( in_array($action,$bloc_acteur['action'])):?>selected="selected"<?php endif;?>><?php echo $label; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                <?php
                                                    $key_role_index++;
                                                endforeach;?>
                                            <?php endif;?>

                                        </div>

                                    </div>


                                </div>
                            <?php endforeach;?>
                        <?php endif;?>

                    </div>

                </div>

                <p class="submit">
                    <input type="submit" name="submit-workflow" id="submit-workflow" class="button button-primary confirm-before" value="<?php if ( $is_new ) :?>Ajouter<?php else: ?>Modifier<?php endif;?>">
                    <a href="?page=axian-ddr-admin&tab=workflow" class="btn btn-secondary confirm-before">Annuler</a>
                </p>
            </form>
        </div>

    </div>

    <!-- edit page -->
<?php endif; ?>