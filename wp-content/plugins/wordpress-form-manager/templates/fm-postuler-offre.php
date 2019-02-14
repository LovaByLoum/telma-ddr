<?php
/*
Template Name: Formulaire postuler un offre
Template Description: The default dislplay template for forms
Template Type: form

option: $showFormTitle, checkbox
	label: Show form title:
	default: checked
option: $showBorder, checkbox
	label: Show border:
	default: checked	
option: $labelPosition, select
	label: Label position:
	description: Labels can be placed to the left or above each field
	options: 'left' => 'Left', 'top' => 'Top'
	default: left
option: $labelWidth, text
	label: Label width (in pixels):
	description: Applies to checkboxes, and when labels are to the left
	default: 200

	
//////////////////////////////////////////////////////////////////////////////////////////

Below are the functions that can be used within a form display template:

fm_form_start(), fm_form_end() - These can be called (not echo'ed) to open and close the form, respectively.
fm_form_hidden() - Nonce and other hidden values required for the form; can be omitted if fm_form_end() is used.
fm_form_the_title() - The form's title

The following can be used in place of the fm_form_start() function:
fm_form_class() - The default form CSS class
fm_form_action() - The default form action
fm_form_ID() - Used for the opening form tag's 'name' and 'id' attributes.

fm_form_the_submit_btn() - A properly formed submit button
fm_form_submit_btn_name() - Submit button's 'name' attribute
fm_form_submit_btn_id() - Submit button's 'id' attribute
fm_form_submit_btn_text() - Submit button's 'value' attribute, as set in the form editor.
fm_form_submit_btn_script() - Validation script

fm_form_have_items() - Returns true if there are more items (used to loop through the form items, similar to have_posts() in wordpress themes)
fm_form_the_item() - Sets up the current item (similar to the_post() in wordpress themes)
fm_form_the_label() - The current item's label
fm_form_the_input() - The current item's input element
fm_form_the_nickname() - The current item's nickname

fm_form_is_separator() - Returns true if the current element is a horizontal line
fm_form_is_note() - Returns true if the current element is a note
fm_form_is_required() - Returns true if the current item is set as required
fm_form_item_type() - The current item's type

fm_form_get_item_input($nickname) - get an item's input by nickname
fm_form_get_item_label($nickname) - get an item's label by nickname

//////////////////////////////////////////////////////////////////////////////////////////

*/
global $fm_display, $current_user, $wpdb;
$form_items = array();
$form_required = array();
while(fm_form_have_items()): fm_form_the_item();
    $form_items[fm_form_the_nickname()] = fm_form_the_ID();
    $form_required[fm_form_the_nickname()] = fm_form_is_required();
endwhile;
$termCompetence = COffre::getCompetenceRequis(0);
$user = CUser::getById( $current_user->ID );
$postID = ( isset($_GET['po'] ) && !empty( $_GET['po'] ) ) ? $_GET['po'] : 0;
$competencesRequired = COffre::getCompetenceRequiredByPostId( $postID );
$termLinguistiques = ( isset( $competencesRequired['langue'] ) && !empty( $competencesRequired['langue'] ) ) ? $competencesRequired['langue'] : array();
$termInformatiques = ( isset( $competencesRequired['infos'] ) && !empty( $competencesRequired['infos'] ) ) ? $competencesRequired['infos'] : array();
$entrepriseId = get_post_meta( $postID, JM_META_SOCIETE_OFFRE_RELATION, true);
$entreprise = JM_Societe::getById( $entrepriseId );
$reference = get_post_meta( $postID, REFERENCE_OFFRE, true );
//$poste_actuel_variable= 'entreprise_user';
//$post_actuel = get_user_meta($user,ENTREPRISE_USER,true);
$POST = $wpdb->get_row("SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id='$user->id' AND meta_key='fonction_user' ");
$ENTREPRISE = $wpdb ->get_row("SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id='$user->id' AND meta_key='entreprise_user'");


//$POST_update = $wpdb->update($wpdb->prefix.usermeta,array('meta_value'=>$_POST['poste_nouv']),array('user_id' =>'$user->id'));
//$POST_update = $wpdb-> update();
//var_dump($POST_update);

                  //  var_dump($user->email);

?>
<div class="form-layout">
    <form enctype="multipart/form-data" method="post" action="<?php echo $fm_display->currentFormOptions['action'];?>" name="fm-form-<?php echo $fm_display->currentFormInfo['ID'];?>" id="fm-form-<?php echo $fm_display->currentFormInfo['ID'];?>" autocomplete="on" novalidate="novalidate">
        <!-- informations personnelles -->
    	<div class="control-group">
            <h4 class="head-accordion open">Informations personnelles</h4>
            <div class="head-accordion">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nom">Nom <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Nom" name="<?php echo $form_items['name_postule'];?>" id="nom" value="<?php echo $user->nom;?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prenom">Prénom <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Prénom" name="<?php echo $form_items['prenom_postule'];?>" id="prenom" value="<?php echo $user->prenom;?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Adresse email <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Email" name="<?php echo $form_items['email_postule'];?>" id="email" value="<?php echo $user->email;?>" readonly>
                    </div>

                </div>
            </div>
        </div>
        <!-- /informations personnelles -->

        <!-- Compétences Informatiques -->
        <?php if ( !empty( $termInformatiques ) && count( $termInformatiques ) > 0 ):?>
    	<div class="control-group">
            <div class="row">
                <div class="form-group col-md-6">
                    <h4 class="head-accordion open">Compétences Informatiques <span class="required">*</span></h4>
                    <?php if ( !empty( $termInformatiques[0] ) && count( $termInformatiques[0] ) > 0 ) : $i=1?>
                        <ul class="checkbox-item checkbox-list list-parent informatique">
                            <?php foreach ( $termInformatiques[0] as $term ):?>
                                <li>
                                    <label class="control control--checkbox <?php if ( count( $termInformatiques[0] ) == $i ):?>latest<?php endif;?>" >
                                        <input type="checkbox" value="<?php echo $term['id'];?>" name="compInfo[]" class="parent-infos" data-class="<?php echo $term['slug'];?>">
                                        <span class="control__indicator"></span>
                                        <span class="control__description"><?php echo $term['label'];?></span>
                                    </label>
                                    <?php if ( isset( $termInformatiques[$term['id']] ) && !empty( $termInformatiques[$term['id']] ) && count( $termInformatiques[$term['id']] ) > 0 ):?>
                                    <ul class="list-children radio-item">
                                        <?php foreach ( $termInformatiques[$term['id']] as $termChild ): ?>
                                            <li>
                                                <label class="control control--radio">
                                                    <input type="radio" value="<?php echo $termChild['id'];?>" name="<?php echo $term['slug'];?>[]" class="<?php echo $term['slug'] ;?>">
                                                    <span class="control__indicator"></span>
                                                    <span class="control__description"><?php echo $termChild['label'];?></span>
                                                </label>
                                            </li>
                                        <?php endforeach;?>
                                    </ul>
                                    <?php endif;?>
                                </li>
                            <?php   $i++; endforeach;?>
                        </ul>
                    <?php endif;?>
                </div>
            </div>
    	</div>
        <?php endif;?>
        <!-- /Compétences Informatiques -->

        <!-- Compétences linguistiques -->
    	<div class="control-group">
            <div class="row">
                <div class="form-group col-md-6">
                    <h4 class="head-accordion open">Compétences linguistiques <span class="required">*</span></h4>
                    <?php if ( !empty( $termLinguistiques ) && count( $termLinguistiques ) > 0 ):?>
                        <ul class="checkbox-item checkbox-list list-parent langue">
                        <?php foreach ( $termLinguistiques[0] as $termParent ) : ?>
                            <li>
                                <label class="control control--checkbox">
                                    <input type="checkbox" value="<?php echo $termParent['id'];?>" name="langue[]" class="parent" data-class="<?php echo $termParent['slug'];?>">
                                    <span class="control__indicator"></span>
                                    <span class="control__description"><?php echo $termParent['label'];?></span>
                                </label>
                                <?php if ( isset( $termLinguistiques[$termParent['id']] ) && !empty( $termLinguistiques[$termParent['id']] ) && count( $termLinguistiques[$termParent['id']] ) > 0 ) :?>
                                    <ul class="list-children">
                                    <?php foreach ( $termLinguistiques[$termParent['id']] as $termChild ):?>
                                        <li>
                                            <label class="control control--checkbox">
                                                <input type="checkbox" value="<?php echo $termChild['id'];?>" name="<?php echo sanitize_title( $termParent['name'] );?>[]" class="<?php echo $termParent['slug'];?>">
                                                <span class="control__indicator"></span>
                                                <span class="control__description"><?php echo $termChild['label'];?></span>
                                            </label>
                                        </li>
                                    <?php endforeach;?>
                                    </ul>
                                <?php endif;?>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    <?php  endif;?>
                </div>
            </div>
        </div>
        <!-- /Compétences linguistiques -->

        <!-- Vos motivations -->
    	<div class="control-group">
            <div class="form-group">
    			<h4 class="head-accordion open">Vos motivations <span class="required">*</span></h4>
    			<textarea name="<?php echo $form_items['message_postule'];?>" class="textarea-field form-control" placeholder="Vos motivations"></textarea>
            </div>
    	</div>
        <!-- /Vos motivations -->
        <!-- POSTE ACTUEL / ENTREPRISE ACTUELLE-->

        <h4 class="head-accordion open">Confirmation poste/société actuelle</h4>
        <div class="head-accordion">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nom">Société Actuelle<span class="required">*</span></label>

                    <input type="text" class="form-control" placeholder="Poste actuel" name="poste_actu" id="poste_actuel" value="<?php echo $ENTREPRISE->meta_value ;?>" readonly>

                </div>
                <div class="form-group col-md-6">
                    <label for="prenom">Poste actuel<span class="required">*</span></label>
                    <input type="text" class="form-control" placeholder="Entreprise actuelle" name="entreprise_actu" id="entreprise_actuelle" value="<?php echo $POST->meta_value;?>" readonly>
                </div>

            </div>
        </div>
        <!-- /POSTE ACTUEL / ENTREPRISE ACTUELLE-->
        <!-- **************MISE A JOUR POSTE ACTUEL / ENTREPRISE ACTUELLE**********************-->

        <h4 class="head-accordion open">Si il y a changement de poste/entreprise, veuillez inserer votre nouveau poste/entreprise </h4>
        <div class="head-accordion">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nom">Nouveau poste</label>

                    <input type="text" class="form-control" autocomplete="off" name="fonction_user" placeholder="Fonction" id="fonction" value="<?php echo $_POST['fonction_user'];?>"/>

                </div>
                <div class="form-group col-md-6">
                    <label for="prenom">Nouvelle entreprise</label>
                    <input type="text" class="form-control" autocomplete="off" name="entreprise_user" placeholder="Nom de l'entreprise" id="entreprise" value="<?php echo $_POST['entreprise_user'];?>"/>
                </div>

                <div class="form-group col-md-6">
                    <h4 class="head-accordion open">Collaborateur du groupe Axian?:</h4>
                    <div id="button_collab" style="display: block; float:left; width: 50px;">

                        <input type="checkbox" id="chekbox_oui" value="Oui" onclick="functionClick(this.value)"> <label for="chekbox_oui" style="width: 30px;">Oui</label>


                    </div>
                    <input id="textcacher" type="hidden" value="" name="<?php echo $form_items['axian_collab']; ?>">
                    <script type="text/javascript">
                        // function functionClick(valeur) {
                        //     jQuery("#textcacher").val(valeur);
                        // }
                        jQuery("#chekbox_oui").on("change",function () {
                           if (jQuery(this).prop("checked")){
                               jQuery("#textcacher").val('oui');
                           }
                           else {
                               jQuery("#textcacher").val('non');
                           }
                        });




                    </script>

                </div>
            </div>

<!--        <div class="control-group">-->
<!--            <div class="form-group">-->
<!--<!--                <h4 class="head-accordion open">groupe axian?(OUI/NON) </h4>-->
<!--<!--                <input type="text" name="--><?php ////echo $form_items['axian_collab'];?><!--<!--" class="textarea-field form-control" placeholder="axian groupe?"><input>-->
<!--<!--                <label>Collaborateur du groupe Axian : </label>-->
<!--<!--                <p>  <input type="checkbox" name="--><?php ////echo $form_items['collab']; ?><!--<!--" value="--><?php ////echo $form_items['collab']; ?><!--<!--" id="collab_1"><label for="collab_1">Oui</label></br>-->
<!--<!--                    <input type="checkbox" name="--><?php ////echo $form_items['collab']; ?><!--<!--" value="--><?php ////echo $form_items['collab']; ?><!--<!--" id="collab_2"><label for="collab_2">Non</label></p>-->
<!---->
<!--            </div>-->
<!--        </div>-->
        <!-- *****************************/MISE A JOURPOSTE ACTUEL / ENTREPRISE ACTUELLE***********************-->
        <!-- Pièces jointes -->
    	<div class="control-group">
            <h4 class="head-accordion open">Pièces jointes</h4>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10240000">
                    <input name="<?php echo $form_items['cv_postule'];?>" id="fileCv" type="file" class="form-control inputfile">
                    <!-- <label for="fileCv" class="input-file-trigger"><span>Mon CV *</span></label> -->
                   <!--  <em>(.doc, .rtf, .pdf, .docx)</em> -->
                    <span class="file-return cv"></span>
                </div>
                <div class="form-group col-md-6">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10240000">
                    <input name="<?php echo $form_items['lm_postule'];?>" id="fileLm" type="file" class="form-control inputfile">
                    <!-- <label for="fileLm" class="input-file-trigger"><span>Ma lettre de motivation *</span></label>
                    <em>(.doc, .rtf, .pdf, .docx)</em> -->
                    <span class="file-return lm"></span>
                </div>
            </div>
    	</div>
        <!-- /Pièces jointes -->

        <!-- Autres documents -->
    	<div class="control-group">
            <h4 class="head-accordion open">Autres documents</h4>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10240000">
                    <input name="<?php echo $form_items['autre_postule'];?>" id="fileAutre" type="file" class="form-control inputfile">
                    <!-- <label for="fileAutre" class="input-file-trigger"><span>Autres documents</span></label> -->
                    <!-- <em>(.doc, .rtf, .pdf, .docx)</em> -->
                    <span class="file-return autre"></span>
                </div>
            </div>
    	</div>
        <!-- /Autres documents -->

        <div class="submit-form">

<!--            <input type="button" name="fm_form_submit1" id="fm_form_submit1" class="button-postuler submit-button" data-toggle="modal" data-target="#confirm-submit" value="Valider" >-->
            <div class="bs-example">
                <!-- Button HTML (to Trigger Modal oui/non) -->
                <a href="#" class="btn btn-lg btn-primary">Valider</a>

                <!-- Modal HTML -->
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="top: 150px;">

                            <div class="modal-body">
                                <p>Confirmez-vous l’envoi de votre candidature ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="non" data-dismiss="modal">Non</button>
                                <input type="submit" name="fm_form_submit" id="fm_form_submit" class="button-postuler submit-button" value="Valider" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    	<input type="hidden" name="<?php echo $form_items['entreprise_postule']?>" value="<?php echo $entreprise->titre;?>">
    	<input type="hidden" name="<?php echo $form_items['ref_postule']?>" value="<?php echo $reference;?>">
    	<input type="hidden" name="fm_nonce" id="fm_nonce" value="<?php echo wp_create_nonce('fm-nonce');?>" />
    	<input type="hidden" name="fm_nonce" id="fm_nonce" value="<?php echo wp_create_nonce('fm-nonce');?>" />
    	<input type="hidden" name="fm_id" id="fm_id" value="<?php echo $fm_display->currentFormInfo['ID'];?>" />
    	<input type="hidden" name="fm_uniq_id" id="fm_uniq_id" value="fm-<?php echo uniqid();?>" />
    	<input type="hidden" name="fm_parent_post_id" id="fm_parent_post_id" value="<?php echo $postID;?>" />
    <?php echo fm_form_end(); ?>
</div>
        <!-- jQuery -->
<!--        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
        <!-- BS JavaScript -->
<!--        <script type="text/javascript" src="js/bootstrap.js"></script>-->
        <!-- Latest compiled and minified CSS -->
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9" crossorigin="anonymous"></script>

        <script type="text/javascript">
               jQuery(document).ready(function(){
                   jQuery(".btn").click(function(){
                       jQuery("#myModal").modal('show');
                   });
               });

               //  script modal   });
                jQuery(document).load(function () {
                    jQuery(".wonderplugin-box-container").hide();

                })

       </script>
        <style type="text/css">
            .bs-example{
                margin: 20px;
            }
            .non{
                border: none;
                color: #fff;
                cursor: pointer;
                font-size: 18px;
                height: 48px;
                min-width: 138px;
                padding: 10px 10px;
                text-align: center;
                text-transform: uppercase;
                background: #eee;

            }
            .non:hover {
                background:#f5f5f5;
            }
            .btn-primary{
                border: none;
                color: #fff;
                cursor: pointer;
                font-size: 18px;
                height: 48px;
                min-width: 138px;
                padding: 10px 10px;
                text-align: center;
                text-transform: uppercase;
                background: #c80f2d;
                }
            .btn-primary:hover{
                background-color:#e57e75!important; ;
            }
        </style>
