<?php
global $axian_ddr;
if ( ( $_GET['action'] == 'edit' ) && (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = $axian_ddr->getbyId(intval($_GET['id']));
}else $post_data = null;
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

    <div id="col-container" class="wp-clearfix">
    <form action="" id="" method="post" autocomplete="off">

        <!--demandeur & type-->
        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['demandeur'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['type'],$post_data);?>
            </div>
        </div>
        <!--demandeur & type-->

        <!--titre poste & direction-->
        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['titre'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['direction'],$post_data);?>
            </div>
        </div>
        <!--titre poste & direction-->

        <!--description du parc-->
        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['superieur'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['departement'],$post_data);?>
            </div>

        </div>

        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['motif'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['lieu'],$post_data);?>
            </div>

        </div>

        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['dernier_titulaire'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['candidature'],$post_data);?>
            </div>

        </div>

        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['attribution'],$post_data);?>
            </div>
            <div class="form-field form-required term-name-wrap form-group col-md-6">
                <?php axian_ddr_render_field($axian_ddr->fields['date'],$post_data);?>
            </div>

        </div>

        <div class="form-row">
            <div class="form-field form-required term-name-wrap form-group col-md-12">
                <?php axian_ddr_render_field($axian_ddr->fields['comment'],$post_data);?>
            </div>
        </div>

        <p>
            <input type="submit" name="submit-ddr" id="submit" class="button button-primary" value="Ajouter">
            <input type="submit" name="save-ddr" id="save" class="button" value="Enregistrer comme brouillon">
            <a href="?page=new-axian-ddr" class="btn btn-sm btn-outline-danger">Annuler</a>
        </p>


    </form>
</div>
    </div>
