<?php
global $axian_ddr;
global $current_user;
$user_demandeur = AxianDDRUser::getById($current_user->ID);

$is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
$the_ddr_id = null;

if ( $is_edit ){
    $the_ddr_id = intval($_GET['id']);
    $post_data = $axian_ddr->getbyId($the_ddr_id);
} else {
    $post_data = array(
       'author_id' => $current_user->ID
    );
}
$historiques = AxianDDRHistorique::getByDdrId(intval($_GET['id']));

$msg = $axian_ddr->process_ddr($the_ddr_id);

if ( isset($_GET['msg']) ){
    $msg = AxianDDR::manage_message($_GET['msg']);
}
?>
<?php if ( $msg ) : ?>
    <div class="notice <?php echo $msg['code'];?>">
        <p><?php echo $msg['msg'];?></p>
    </div>
<?php endif;?>

<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Demande de recrutement</h1>

    <hr class="wp-header-end">

    <div id="col-container" class="ddr-edit wp-clearfix">

        <form action="<?php
            if ( $is_edit ){
                echo 'admin.php?page=axian-ddr&action=view&id=' . $the_ddr_id;
            }
        ?>" method="post" autocomplete="off">


            <fieldset class="ddr-box-bordered">
                <legend>Demandeur</legend>

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
                            <p class="col-sm-9">
                                <strong>
                                    <?php
                                    if ( !empty($user_demandeur->manager) ){
                                        echo $user_demandeur->manager;
                                        $post_data['superieur_id'] = $user_demandeur->manager;
                                        axian_ddr_render_field(array(
                                            'type' => 'hidden',
                                            'name' => 'superieur_id'
                                        ), $post_data, false);
                                    } else {
                                        axian_ddr_render_field(array(
                                            'type' => 'autocompletion',
                                            'name' => 'superieur_id',
                                            'source' => 'user'
                                        ), $post_data, false);
                                    }
                                    ?>
                                </strong>
                            </p>
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
                <?php axian_ddr_render_field($axian_ddr->fields['demandeur'],$post_data);?>
            </fieldset>

            <fieldset class="ddr-box-bordered">
                <legend>Demande</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['titre'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['candidature'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['dernier_titulaire'],$post_data);?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['motif'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['date'],$post_data);?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['direction'],$post_data);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['departement'],$post_data);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['lieu'],$post_data);?>
                        </div>
                    </div>
                </div>

            </fieldset>

            <fieldset class="ddr-box-bordered">
                <legend>Annonce</legend>
                <i class="info">Une offre sera crée avec ces informations lorsque votre demande a entièrement été validé.</i>


            </fieldset>

            <fieldset class="validation-box ddr-box-bordered">
                <legend>Validation</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['attribution'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['type'],$post_data);?>
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
                            ), $post_data);?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="ddr-box-bordered">
                <legend>Historique</legend>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="libelle">Validateur</th>
                        <th class="libelle">Délégation</th>
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
                            <td valign="top">
                            </td>
                            <td><?php echo strftime("%d %b %Y", strtotime($value['date']));?></td>
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
                                Changement du programme
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </fieldset>

            <p class="submit-part">
                <?php if ( $is_edit ) :?>
                    <input type="hidden" name="id" value="<?php echo $the_ddr_id;?>" />
                    <input type="hidden" name="etat" value="<?php echo $post_data['etat'];?>" />

                    <input type="submit" name="submit-ddr" class="button button-primary" value="Soumettre"/>
                    <?php if ( DDR_STATUS_DRAFT == $post_data['etat'] ):?>
                        <input type="submit" name="save-draft" class="button" value="Enregistrer le brouillon"/>
                    <?php else : ?>
                        <input type="submit" name="update-ddr" class="button" value="Enregistrer"/>
                    <?php endif; ?>

                    <input type="submit" name="delete-ddr" class="button" value="Supprimer"/>
                <?php else : ?>
                    <input type="submit" name="submit-ddr" class="button button-primary" value="Soumettre"/>
                    <input type="submit" name="save-draft" class="button" value="Enregistrer comme brouillon"/>
                <?php endif;?>
                <a href="admin.php?page=axian-ddr-list" class="btn btn-sm btn-outline-danger">Annuler</a>
            </p>


        </form>
    </div>
</div>
