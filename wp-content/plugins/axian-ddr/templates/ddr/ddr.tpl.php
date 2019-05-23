<?php
global $axian_ddr;
if ( (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = $axian_ddr->getbyId(intval($_GET['id']));
}else $post_data = null;
$result = $axian_ddr->submit_ddr();
var_dump($_GET['action']);
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
    <?php if ( 'view' != $_GET['action'] ):?>
    <form action="<?php if (!is_null($post_data)) echo "?page=" . esc_attr( $_REQUEST['page'] )?>" id="" method="post" autocomplete="off">

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
        <?php if (!is_null($post_data)) :?>
            <input type="hidden" name="id" value="<?php echo intval($_GET['id']);?>" >
            <input type="hidden" name="etat" value="<?php echo $post_data['etat'];?>" >
            <?php if ( STATUS_DRAFT == $post_data['etat'] ):?>
            <input type="submit" name="publish-ddr" id="submit" class="button button-primary" value="Publier">
            <input type="submit" name="update-ddr" id="save" class="button" value="Enregistrer comme brouillon">
            <?php else : ?>
            <input type="submit" name="update-ddr" id="submit" class="button button-primary" value="Enregistrer">
            <?php endif;?>
        <?php else : ?>
            <input type="submit" name="submit-ddr" id="submit" class="button button-primary" value="Ajouter">
            <input type="submit" name="save-ddr" id="save" class="button" value="Enregistrer comme brouillon">
        <?php endif;?>
            <a href="?page=new-axian-ddr" class="btn btn-sm btn-outline-danger">Annuler</a>
        </p>


    </form>
    <?php else :?>


        <div class="card">
            <div class="card-header">
                DDR - <?php echo $post_data['id'];?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $post_data['title'];?></h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    <?php endif?>
</div>
    </div>
