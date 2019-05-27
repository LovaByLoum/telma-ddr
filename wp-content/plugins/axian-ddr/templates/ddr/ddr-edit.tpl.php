<?php
global $axian_ddr;
global $current_user;
$user_demandeur = AxianDDRUser::getById($current_user->ID);

if ( (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = $axian_ddr->getbyId(intval($_GET['id']));
} else {
    $post_data = array(
       'author_id' => $current_user->ID
    );
}
$result = $axian_ddr->submit_ddr();

?>
<?php if ( $result ) : ?>
    <div class="notice <?php echo $result['code'];?>">
        <p><?php echo $result['msg'];?></p>
    </div>
<?php endif;?>

<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Demande de recrutement</h1>

    <hr class="wp-header-end">

    <div id="col-container" class="ddr-edit wp-clearfix">

        <form action="<?php if (!is_null($post_data)) echo "?page=" . esc_attr( $_REQUEST['page'] )."&action=view&id=".$_GET['id']?>" id="" method="post" autocomplete="off">


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
                            <?php axian_ddr_render_field($axian_ddr->fields['type'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['candidature'],$post_data);?>
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
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['departement'],$post_data);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['lieu'],$post_data);?>
                        </div>
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['dernier_titulaire'],$post_data);?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['comment'],$post_data);?>
                        </div>
                    </div>
                </div>

            </fieldset>


            <fieldset class="validation-box ddr-box-bordered">
                <legend>Validation</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-field">
                            <?php axian_ddr_render_field($axian_ddr->fields['attribution'],$post_data);?>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="libelle">Validateur</th>
                        <th class="libelle">Délégation</th>
                        <th class="libelle">Date</th>
                        <th class="libelle">Etat</th>
                        <th class="libelle">Etape</th>
                        <th class="libelle">Commentaire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd">
                        <td valign="top">
                            Johary RANARIMANANA
                        </td>
                        <td valign="top">
                        </td>
                        <td>24/05/2019 18:03:34</td>
                        <td>
                            Annulation en cours
                        </td>
                        <td>
                            Validation SupÃ©rieur Hierarchique
                        </td>
                        <td>
                            Changement du programme
                        </td>
                    </tr>
                    <tr class="even">
                        <td valign="top">
                            Johary RANARIMANANA
                        </td>
                        <td valign="top">
                        </td>
                        <td>23/05/2019 13:17:12</td>
                        <td>
                            Validée
                        </td>
                        <td>
                            Validation Supérieur Hierarchique
                        </td>
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>

            </fieldset>


            <p>
            <?php if (!is_null($post_data)) :?>
                <input type="hidden" name="id" value="<?php echo intval($_GET['id']);?>" >
                <input type="hidden" name="etat" value="<?php echo $post_data['etat'];?>" >
                <?php if ( DDR_STATUS_DRAFT == $post_data['etat'] ):?>
                <input type="submit" name="publish-ddr" id="submit" class="button button-primary" value="Publier">
                <input type="submit" name="update-ddr" id="save" class="button" value="Enregistrer comme brouillon">
                <?php else : ?>
                <input type="submit" name="update-ddr" id="submit" class="button button-primary" value="Enregistrer">
                <?php endif;?>
            <?php else : ?>
                <input type="submit" name="submit-ddr" id="submit" class="button button-primary" value="Soumettre">
                <input type="submit" name="save-ddr" id="save" class="button" value="Enregistrer comme brouillon">
            <?php endif;?>
                <a href="?page=axian-ddr" class="btn btn-sm btn-outline-danger">Annuler</a>
            </p>


        </form>
    </div>
</div>
