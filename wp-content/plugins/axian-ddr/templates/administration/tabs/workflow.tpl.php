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
        <h1 class="wp-heading-inline">Administration des workflows</h1>
        <div id="col-container" class="container">
            <div class="row" id="bloc_principale">
                <div class="col-xs-6">
                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="label_workflow" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-8 champ">
                                <input type="text" class="form-control" name="nom_workflow" id="label_workflow" placeholder="Nom du workflow">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-field form-required term-name-wrap" style="margin-left: 15px;">
                                <?php axian_ddr_render_field($axian_ddr_workflow->fields['societe'], $post_data); ?>
                            </div>

                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="defaultCheck1">
                                Par défaut
                            </label>
                            <input class="form-check-input" type="checkbox" value="1" name="par_defaut" id="par_defaut">
                        </div><br>
                        <button type="button" class="btn btn-secondary" id="ajout_etape" style="margin-top: 15px;">Ajouter une étape</button>
                        <div class="container " id="principale">
                            <div id="bloc-etape" class="container bloc_etape">
                                <button type="button" class="close-bloc" aria-label="Close" data-dismiss="bloc_etape">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="form-group row">
                                    <label for="label_workflow" class="col-sm-2 col-form-label">Etat</label>
                                    <div class="col-sm-8 champ">
                                        <select id="select_etat" name="etat[]" class="custom-select">
                                            <option value="brouillon" name="brouillon">Brouillon</option>
                                            <option value="valide" name="etat_valide">Validé</option>
                                            <option value="en_cours" name="en_cours">En cours</option>
                                            <option value="refuse" name="etat_refuse">Refusé</option>
                                            <option value="annule" name="etat_annule">Annulé</option>
                                            <option value="cloture" name="etat_cloture">Clôturé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="label_workflow" class="col-sm-2 col-form-label">Etape</label>
                                    <div class="col-sm-8 champ">
                                        <select id="select_etape" name="etape[]" class="custom-select">
                                            <option value="creation" name="creation">Création</option>
                                            <option value="validation1" name="validation1">Validation N1</option>
                                            <option value="validation2" name="validation2">Validation N2</option>
                                            <option value="validation3" name="validation3">Validation N3</option>
                                            <option value="validation3" name="validation4">Validation N4</option>
                                            <option value="publication" name="publication">Publication</option>
                                            <option value="fini" name="fini">Fini</option>
                                            <option value="annulation" name="annulation">Annulation</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <button type="button" class="btn btn-secondary btn-sm" id="ajout_role" style="margin-top: 15px;">Ajouter rôles</button>
                                </div>
                                <div class="container" id="bloc-roles">
                                    <div class="form-group row">
                                        <label for="label_workflow" class="col-sm-2 col-form-label">Role</label>
                                        <div class="col-sm-8 champ">
                                            <select id="select_etape" name="role[]" class="custom-select">
                                                <option value="manager" name="manager">Manager</option>
                                                <option value="assistante_direction" name="assistante_direction">Assistante de direction</option>
                                                <option value="assistante_rh" name="assistante_rh">Assistante RH</option>
                                                <option value="controleur_budget" name="controleur_budget">Controleur Budget</option>
                                                <option value="drh" name="drh">DRH</option>
                                                <option value="dg" name="dg">DG</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label_workflow" class="col-sm-2 col-form-label">Type</label>
                                        <div class="col-sm-8 champ">
                                            <select id="select_etape" name="type[]" class="custom-select">
                                                <option value="prevu" name="prevu">Prévu</option>
                                                <option value="non_prevu" name="non_prevu">Non prévu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label_workflow" class="col-sm-2 col-form-label">Actions</label>
                                        <div class="col-sm-8 champ">
                                            <select id="select_etape" name="action[]" class="custom-select" multiple>
                                                <option value="creer" name="creer">Créer</option>
                                                <option value="soumettre" name="soumettre">Soumettre</option>
                                                <option value="valider" name="valider">Valider</option>
                                                <option value="refuser" name="refuser">Refuser</option>
                                                <option value="cloturer" name="cloturer">Clôturer</option>
                                            </select>
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
        </div>
    </div>

<?php endif; ?>