<?php global $axian_ddr;?>

<h2>Demande de recrutement</h2>
<form action="" id="" autocomplete="off">

    <!--name & prenom-->
    <div class="form-row">
        <div class="form-field form-required term-name-wrap form-group col-md-6">
            <?php axian_ddr_render_field($axian_ddr->fields['demandeur'],$post_data);?>
        </div>
        <div class="form-field form-required term-name-wrap form-group col-md-6">
            <?php axian_ddr_render_field($axian_ddr->fields['type'],$post_data);?>
        </div>
    </div>
    <!--name & prenom-->

    <!--société & pays-->
    <div class="form-row">
        <div class="form-field form-required term-name-wrap form-group col-md-6">
            <?php axian_ddr_render_field($axian_ddr->fields['direction'],$post_data);?>
        </div>
        <div class="form-field form-required term-name-wrap form-group col-md-6">
            <?php axian_ddr_render_field($axian_ddr->fields['titre'],$post_data);?>
         </div>
     </div>
     <!--société & pays-->
 </div>

 <!--description du parc-->
 <div class="form-row">
    <div class="form-field form-required term-name-wrap form-group col-md-12">
        <?php axian_ddr_render_field($axian_ddr->fields['departement'],$post_data);?>
    </div>
    <!--projet-->


     <p class="submit">
         <input type="submit" name="submit-term" id="submit" class="button button-primary" value="Ajouter">
     </p>
    <p class="nb">* champ obligatoire</p>

</form>