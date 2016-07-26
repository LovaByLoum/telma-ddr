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
global $fm_display, $current_user;
$form_items = array();
$form_required = array();
while(fm_form_have_items()): fm_form_the_item();
    $form_items[fm_form_the_nickname()] = fm_form_the_ID();
    $form_required[fm_form_the_nickname()] = fm_form_is_required();
endwhile;
$termInformatiques = get_term_children( ID_TAXONOMIE_INFORMATIQUE, JM_TAXONOMIE_COMPETENCE_REQUISES );
$termCompetence = COffre::getCompetenceRequis(0);
$termLinguistiques = $termCompetence[ID_TAXONOMIE_LINGUISTIQUES];
$user = CUser::getById( $current_user->ID );
$postID = ( isset($_GET['po'] ) && !empty( $_GET['po'] ) ) ? $_GET['po'] : 0;
$entrepriseId = get_post_meta( $postID, JM_META_SOCIETE_OFFRE_RELATION, true);
$entreprise = JM_Societe::getById( $entrepriseId );
$reference = get_post_meta( $postID, REFERENCE_OFFRE, true );
?>
<form enctype="multipart/form-data" method="post" action="<?php echo $fm_display->currentFormOptions['action'];?>" name="fm-form-<?php echo $fm_display->currentFormInfo['ID'];?>" id="fm-form-<?php echo $fm_display->currentFormInfo['ID'];?>" autocomplete="on" novalidate="novalidate">
	<div class="control-group">
        <h4 class="head-accordion open">Informations personnelles</h4>
        <div class="head-accordion">
            <div class="col-1-2 form-field">
				<label for="nom">Nom<span class="required">*</span></label>
                <input type="text" placeholder="Nom" name="<?php echo $form_items['name_postule'];?>" id="nom" value="<?php echo $user->nom;?>" readonly>
            </div>
            <div class="col-1-2 form-field">
                <label for="prenom">Prénom <span class="required">*</span></label>
                <input type="text" placeholder="Prénom" name="<?php echo $form_items['prenom_postule'];?>" id="prenom" value="<?php echo $user->prenom;?>" readonly>
            </div>
	        <div class="col-1-2 form-field">
		        <label for="email">Adresse email <span class="required">*</span></label>
                <input type="text" placeholder="Email" name="<?php echo $form_items['email_postule'];?>" id="email" value="<?php echo $user->email;?>" readonly>
	        </div>
        </div>
    </div>
	<div class="control-group">
		<div class="col-1-1 form-field">
		    <div class="col-1-2">
			<h5 class="head-accordion open">Compétences Informatiques<span class="required">*</span></h5>
				<?php if ( !empty( $termInformatiques ) && count( $termInformatiques ) > 0 ) :
						$i=1?>
					<?php foreach ( $termInformatiques as $termId ):
							$term = get_term_by( "id", $termId, JM_TAXONOMIE_COMPETENCE_REQUISES );?>
		                <label class="control control--checkbox <?php if ( count( $termInformatiques ) == $i ):?>latest<?php endif;?>"><?php echo $term->name;?>
							<input type="checkbox"  value="<?php echo $termId;?>" name="compInfo[]">
							<div class="control__indicator"></div>
						</label>
					<?php   $i++;
							endforeach;?>
				<?php endif;?>
		    </div>
		</div>
	</div>
	<div class="control-group">
        <div class="col-1-1 form-field">
	        <div class="col-1-2">
	        <h5 class="head-accordion open">Compétences linguistiques<span class="required">*</span></h5>
	        <?php if ( !empty( $termLinguistiques ) && count( $termLinguistiques ) > 0 ):?>
		        <ul class="list-parent">
		        <?php foreach ( $termLinguistiques[0] as $termParent ) :?>
			        <li>
			        <label class="control control--checkbox"><?php echo $termParent['name'];?>
		                <input type="checkbox"  value="<?php echo $termParent['id'];?>" name="langue[]" class="parent" data-class="<?php echo sanitize_title( $termParent['name'] );?>">
		                <div class="control__indicator"></div>
		            </label>
			        <?php if ( isset( $termLinguistiques[$termParent['id']] ) && !empty( $termLinguistiques[$termParent['id']] ) && count( $termLinguistiques[$termParent['id']] ) > 0 ) :?>
				        <ul class="list-children">
				        <?php foreach ( $termLinguistiques[$termParent['id']][0] as $termChild ):?>
					        <li>
						        <label class="control control--radio"><?php echo $termChild['name'];?>
		                            <input type="radio"  value="<?php echo $termChild['id'];?>" name="<?php echo sanitize_title( $termParent['name'] );?>" class="<?php echo sanitize_title( $termParent['name'] );?>">
		                            <div class="control__indicator"></div>
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
	<div class="control-group">
		<div class="col-1-1 form-field">
			<h5 class="head-accordion open">Votre Message</h5>
			<textarea name="<?php echo $form_items['message_postule'];?>" placeholder="Votre message"></textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="col-1-1 form-field">
			<h5 class="head-accordion open">Pièces jointes</h5>
			<div class="col-1-2">
				<input type="hidden" name="MAX_FILE_SIZE" value="10240000">
				<input name="<?php echo $form_items['cv_postule'];?>" id="fileCv" type="file" class="inputfile">
				<label for="fileCv" class="input-file-trigger"><span>Mon CV *</span></label>
				<span class="file-return cv"></span>
			</div>
			<div class="col-1-2">
				<input type="hidden" name="MAX_FILE_SIZE" value="10240000">
				<input name="<?php echo $form_items['lm_postule'];?>" id="fileLm" type="file" class="inputfile">
				<label for="fileLm" class="input-file-trigger"><span>Ma lettre de motivation *</span></label>
				<span class="file-return lm"></span>

			</div>
		</div>
	</div>
	<div class="control-group">
		<div class="col-1-1 form-field">
			<h5 class="head-accordion open">Autres documents </h5>
			<div class="col-1-2">
				<input type="hidden" name="MAX_FILE_SIZE" value="10240000">
				<input name="<?php echo $form_items['autre_postule'];?>" id="fileAutre" type="file" class="inputfile">
				<label for="fileAutre" class="input-file-trigger"><span>Autres documents</span></label>
				<span class="file-return"></span>
			</div>
		</div>
	</div>
	<input type="submit" name="fm_form_submit" id="fm_form_submit" class="submit" value="Valider" >
	<input type="hidden" name="<?php echo $form_items['entreprise_postule']?>" value="<?php echo $entreprise->titre;?>">
	<input type="hidden" name="<?php echo $form_items['ref_postule']?>" value="<?php echo $reference;?>">
	<input type="hidden" name="fm_nonce" id="fm_nonce" value="<?php echo wp_create_nonce('fm-nonce');?>" />
	<input type="hidden" name="fm_nonce" id="fm_nonce" value="<?php echo wp_create_nonce('fm-nonce');?>" />
	<input type="hidden" name="fm_id" id="fm_id" value="<?php echo $fm_display->currentFormInfo['ID'];?>" />
	<input type="hidden" name="fm_uniq_id" id="fm_uniq_id" value="fm-<?php echo uniqid();?>" />
	<input type="hidden" name="fm_parent_post_id" id="fm_parent_post_id" value="<?php echo $postID;?>" />
<?php echo fm_form_end(); ?>
