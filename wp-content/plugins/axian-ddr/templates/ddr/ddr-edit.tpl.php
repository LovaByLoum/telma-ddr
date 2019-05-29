<?php
global $axian_ddr;
global $current_user;
global $ddr_process_msg;

$user_demandeur = AxianDDRUser::getById($current_user->ID);

$is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
$is_create = !isset($_GET['id']) && !isset($_GET['action']);
$is_view = isset($_GET['id']) && isset($_GET['action']) && 'view' == $_GET['action'] && $_GET['id'] > 0;

$the_ddr_id = null;
$offre_data = array();

if ( $is_edit || $is_view ){
    $the_ddr_id = intval($_GET['id']);
    $post_data = AxianDDR::getbyId($the_ddr_id);

    if ( !empty($post_data['offre_data']) ){
        $offre_data = unserialize($post_data['offre_data']);
    }

} elseif ( $is_create ) {
    $post_data = array(
        'author_id' => $current_user->ID,
        'etape' => DDR_STEP_CREATE
    );
}

//permission
if ( $is_edit ){
    if ( !current_user_can(DDR_CAP_CAN_EDIT_OTHERS_DDR) && current_user_can(DDR_CAP_CAN_EDIT_DDR) && $current_user->ID != $post_data['author_id'] ){
        wp_die('Action non autorisée');
    }
} elseif ( $is_view ){
    if ( !current_user_can(DDR_CAP_CAN_VIEW_OTHERS_DDR) && current_user_can(DDR_CAP_CAN_VIEW_DDR) && $current_user->ID != $post_data['author_id'] ){
        wp_die('Action non autorisée');
    }
} elseif ( $is_create ) {
    if ( !current_user_can(DDR_CAP_CAN_CREATE_DDR) ){
        wp_die('Action non autorisée');
    }
}

$historiques = AxianDDRHistorique::getByDDRId(intval($_GET['id']));
$offres = new AxianDDROffre();
?>

<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Demande de recrutement <?php if ($is_edit || $is_view){ echo ' / DDR-' . $the_ddr_id; } ?></h1>

    <?php
    if ( !is_null($ddr_process_msg) ){
        $msg = $ddr_process_msg;
    }
    if ( isset($_GET['msg']) ){
        $msg = AxianDDR::manage_message($_GET['msg']);
    }
    ?>
    <?php if ( isset($msg) ) : ?>
        <div class="notice <?php echo $msg['code'];?>">
            <p><?php echo $msg['msg'];?></p>
        </div>
    <?php endif;?>
    <hr class="wp-header-end">

    <?php if ( $is_edit || $is_view ): ?>
        <br>
        <div class="ddr-summary res row">
            <div class="col-md-6">
                <p><label class="col-sm-3">N° Demande :</label><strong><?php echo 'DDR-' . $the_ddr_id;;?></strong></p>
                <p><label class="col-sm-3">Etat :</label><strong><?php echo AxianDDR::$etats[$post_data['etat']];?></strong></p>
                <p><label class="col-sm-3">Etape :</label><strong><?php echo AxianDDR::$etapes[$post_data['etape']];?></strong></p>
            </div>
            <div class="col-md-6">
                <p><label class="col-sm-3">Créé le :</label><strong><?php echo axian_ddr_convert_to_human_datetime($post_data['created']);?></strong></p>
                <?php if ( !empty($post_data['modified']) ) : ?>
                    <p><label class="col-sm-3">Modifié le :</label><strong><?php echo axian_ddr_convert_to_human_datetime($post_data['modified']);?></strong></p>
                <?php endif;?>
                <p><label class="col-sm-3">Type :</label><strong><?php echo AxianDDR::$types_demande[$post_data['type']];?></strong></p>
            </div>
        </div>
    <?php endif;?>


    <div id="col-container" class="ddr-edit wp-clearfix">

        <form action="" method="post" autocomplete="off">


            <fieldset class="ddr-box-bordered">
                <legend>Initiateur</legend>

                <div class="res row">
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="form-group row">
                            <label class="col-sm-3">Nom&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->display_name;?></strong></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Fonction&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->titre;?> <?php echo $user_demandeur->description;?></strong></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">E-mail&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->email;?></strong></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Tél.&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->mobile;?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-6">
                        <div class="form-group row">
                            <label class="col-sm-3">Classification&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->classification;?></strong></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Superieur immédiat&nbsp;:</label>
                            <div class="col-sm-9">
                                <strong>
                                    <?php
                                    if ( !empty($user_demandeur->manager) ){
                                        echo $user_demandeur->manager;
                                        $post_data['superieur_id'] = $user_demandeur->manager;
                                        axian_ddr_render_field(array(
                                            'type' => 'hidden',
                                            'name' => 'superieur_id'
                                        ), $post_data, false, $is_view);
                                    } else {
                                        axian_ddr_render_field(array(
                                            'type' => 'autocompletion',
                                            'name' => 'superieur_id',
                                            'source' => 'user'
                                        ), $post_data, false, $is_view);
                                    }
                                    ?>
                                </strong>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Société&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->company;?></strong></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Département&nbsp;:</label>
                            <p class="col-sm-9"><strong><?php echo $user_demandeur->departement;?></strong></p>
                        </div>
                    </div>
                </div>

                <?php if ( $is_edit ) : ?>
                <?php axian_ddr_render_field($axian_ddr->fields['demandeur'],$post_data, true);?>
                <?php endif;?>

            </fieldset>

            <fieldset class="ddr-box-bordered">
                <legend>Demande</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['titre'],$post_data, true, $is_view);?>
                        </div>
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['candidature'],$post_data, true, $is_view);?>
                        </div>
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['dernier_titulaire'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['motif'],$post_data, true, $is_view);?>
                        </div>
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['date'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['direction'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['departement'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field row">
                            <?php axian_ddr_render_field($axian_ddr->fields['lieu'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                </div>

            </fieldset>

            <fieldset class="ddr-box-bordered">
                <legend>Annonce</legend>
                <i class="info">Une offre sera crée avec ces informations lorsque votre demande a entièrement été validé.</i>
                <br>
                <br>
                <div class="form-row">

                    <div class="form-group row">
                        <div class="form-field col-md-4 row">
                            <?php axian_ddr_render_field($offres->fields['mission'], $offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field col-md-4 row">
                            <?php axian_ddr_render_field($offres->fields['responsabilite'],$offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field col-md-4 row">
                            <?php axian_ddr_render_field($offres->fields['qualite'],$offre_data, true, $is_view);?>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-3<?php endif;?> col-md-6 ddr-box-bordered row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_DOMAINE_ETUDE], $offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-3<?php endif;?> col-md-6 ddr-box-bordered row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_LOCALISATION], $offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-3<?php endif;?> col-md-6 ddr-box-bordered row" >
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_TYPE_CONTRAT], $offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-3<?php endif;?> col-md-6 ddr-box-bordered row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_DEPARTEMENT], $offre_data, true, $is_view);?>
                        </div>
                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-3<?php endif;?> col-md-6 ddr-box-bordered row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_COMPETENCE_REQUISES], $offre_data, true, $is_view);?>
                        </div>

                        <div class="form-field <?php if ( $is_view ): ?>col-lg-6<?php else :?>col-lg-8<?php endif;?> col-md-6">
                            <div class="form-field row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_ANNEE_EXPERIENCE], $offre_data, true, $is_view);?>
                            </div>

                            <div class="form-field row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_CRITICITE], $offre_data, true, $is_view);?>
                            </div>

                            <div class="form-field row">
                            <?php axian_ddr_render_field($offres->fields[JM_TAXONOMIE_NIVEAU_ETUDE], $offre_data, true, $is_view);?>
                            </div>

                            <div class="form-field row">
                            <?php axian_ddr_render_field($offres->fields[JM_POSTTYPE_SOCIETE], $offre_data, true, $is_view);?>
                            </div>

                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="validation-box ddr-box-bordered">
                <legend>Validation</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['attribution'],$post_data, true);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['type'],$post_data, true, $is_view);?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field(array(
                                'label' => 'Commentaire',
                                'type' => 'textarea',
                                'name' => 'comment',
                                'cols' => '40',
                                'rows' => '4'
                            ), $post_data, true);?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <?php if ( ! empty($historiques) ) : ?>
            <fieldset class="ddr-box-bordered">
                <legend>Historique</legend>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="libelle">Utilisateur</th>
                        <th class="libelle">Date</th>
                        <th class="libelle">Etat avant</th>
                        <th class="libelle">Etat après</th>
                        <th class="libelle">Etape</th>
                        <th class="libelle">Commentaire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($historiques as $key => $value):?>
                        <tr class=" <?php echo ($key % 2 == 0) ? 'odd' : 'even';?> ">
                            <td valign="top">
                                <?php echo $value['display_name'];?>
                            </td>
                            <td><?php echo axian_ddr_convert_to_human_datetime($value['date']);?></td>
                            <td>
                                <?php echo AxianDDR::$etats[$value['etat_avant']];?>
                            </td>
                            <td>
                                <?php echo AxianDDR::$etats[$value['etat_apres']];?>
                            </td>
                            <td>
                                <?php echo AxianDDR::$etapes[$value['etape']];?>
                            </td>
                            <td>
                                <?php echo $value['comment'];?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </fieldset>
            <?php endif;?>

            <?php
            $current_workflow_etape = AxianDDRWorkflow::getWorkflowInfoBy($post_data['etape']);
            ?>
            <p class="submit-part">
                <input type="hidden" name="etape" value="<?php echo $post_data['etape'];?>" />
                <input type="hidden" name="next_etat" value="<?php echo $current_workflow_etape['next_etat'];?>" />
                <input type="hidden" name="next_etape" value="<?php echo $current_workflow_etape['next_etape'];?>" />
                <?php if ( $is_edit ) :?>
                    <input type="hidden" name="id" value="<?php echo $the_ddr_id;?>" />
                    <input type="hidden" name="etat" value="<?php echo $post_data['etat'];?>" />

                    <?php if ( in_array(DDR_ACTION_SUBMIT, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_SUBMIT_DDR) ) : ?>
                        <input type="submit" name="submit-ddr" class="button button-primary" value="Soumettre"/>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if ( in_array(DDR_ACTION_VALIDATE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_VALIDATE_DDR) ) : ?>
                            <input type="submit" name="validate-ddr" class="button button-primary" value="Valider"/>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if ( in_array(DDR_ACTION_REFUSE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_REFUSE_DDR) ) : ?>
                            <input type="submit" name="refuse-ddr" class="button button-primary" value="Refuser"/>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if ( in_array(DDR_ACTION_CLOSE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_CLOSE_DDR) ) : ?>
                            <input type="submit" name="cloture-ddr" class="button button-primary" value="Clôturer"/>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if ( DDR_STATUS_DRAFT == $post_data['etat'] ):?>

                        <?php if ( in_array(DDR_ACTION_CREATE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                            <?php if ( current_user_can(DDR_CAP_CAN_CREATE_DDR) ) : ?>
                                <input type="submit" name="save-draft" class="button" value="Enregistrer le brouillon"/>
                            <?php endif;?>
                        <?php endif;?>

                    <?php else : ?>

                        <?php if ( in_array(DDR_ACTION_UPDATE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                            <?php if ( current_user_can(DDR_CAP_CAN_EDIT_OTHERS_DDR) || ( current_user_can(DDR_CAP_CAN_EDIT_DDR) && $current_user->ID == $post_data['author_id'] ) ) : ?>
                                <input type="submit" name="update-ddr" class="button" value="Enregistrer"/>
                            <?php endif;?>
                        <?php endif;?>

                    <?php endif; ?>

                    <?php if ( in_array(DDR_ACTION_DELETE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_DELETE_OTHERS_DDR) || ( current_user_can(DDR_CAP_CAN_DELETE_DDR) && $current_user->ID == $post_data['author_id'] ) ) : ?>
                        <input type="submit" name="delete-ddr" class="button" value="Supprimer"/>
                        <?php endif;?>
                    <?php endif;?>

                <?php elseif ( $is_create ) : ?>

                    <?php if ( in_array(DDR_ACTION_SUBMIT, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_SUBMIT_DDR) ) : ?>
                        <input type="submit" name="submit-ddr" class="button button-primary" value="Soumettre"/>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if ( in_array(DDR_ACTION_CREATE, $current_workflow_etape['workflow_info']['action']) && AxianDDRWorkflow::isUserInCurrentEtape($post_data['etape']) ) :?>
                        <?php if ( current_user_can(DDR_CAP_CAN_CREATE_DDR) ) : ?>
                        <input type="submit" name="save-draft" class="button" value="Enregistrer comme brouillon"/>
                        <?php endif;?>
                    <?php endif;?>

                <?php endif;?>
                <a href="admin.php?page=axian-ddr-list" class="btn btn-sm btn-outline-danger">Annuler</a>
            </p>


        </form>
    </div>
</div>
