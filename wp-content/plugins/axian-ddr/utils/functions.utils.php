<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 15/05/19
 * Time: 09:20
 * To change this template use File | Settings | File Templates.
 */

//render fields
function axian_ddr_render_field( $field, $post_data = null, $label = true ){
    if ( is_null($post_data) ) $post_data = $_POST;

    $current_value = (isset($post_data[$field['name']]) ? $post_data[$field['name']] : '' );
    switch ( $field['type'] ){
        case 'text' :
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <input name="<?php echo $field['name'];?>" type="text" id="<?php echo $field['name'];?>" value="<?php echo $current_value;?>" class="regular-text form-control <?php echo $field['class'];?>"/>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'checkbox' :
        case 'radio' :
            ?>
            <?php foreach ( $field['options'] as $val => $lib):?>
                <label for="<?php echo $field['name'];?>-<?php echo $val;?>" class="<?php echo $field['class'];?>"><?php echo $lib;?>
                    <input name="<?php echo $field['name'];?>[]" type="<?php echo $field['type'];?>" id="<?php echo $field['name'];?>-<?php echo $val;?>" value="<?php echo $val;?>" <?php if( $current_value == $val ):?>checked<?php endif;?>   />
                </label>
            <?php endforeach;?>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'select':
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <select name="<?php echo $field['name'];?>" id="<?php echo $field['id'];?>" class="form-control <?php if ( $field['search'] == true ) : ?>chosen-select<?php endif;?> <?php if ( $field['add'] == true ) : ?>chosen-select-add<?php endif;?> <?php echo $field['class'];?>" tabindex="2" data-placeholder=" <?php echo $field['placeholder'];?>">
                <?php foreach ( $field['options'] as  $val => $lib):?>
                    <option value="<?php echo $val;?>" <?php if ( $val ==  $current_value ): ?>selected<?php endif;?>><?php echo $lib;?></option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'date' :
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <input name="<?php echo $field['name'];?>" type="text" id="<?php echo $field['name'];?>" value="<?php echo $current_value;?>" class="regular-text datepicker <?php echo $field['class'];?>" placeholder="DD/MM/YYYY" readonly/>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'wysiwyg' :
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <?php
            wp_editor(
                $current_value,
                $field['name']
            );
            ?>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'textarea' :
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <textarea name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>" rows="<?php echo $field['rows'];?>" cols="<?php echo $field['cols'];?>" class="form-control <?php echo $field['class'];?>"><?php echo $current_value;?></textarea>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
        case 'hidden' :
            ?>
            <input type="hidden" name="<?php echo $field['name'];?>" value="<?php echo $current_value;?>"/>
            <?php
            break;
        case 'autocompletion' :
            ?>
            <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
            <input type="text" id="<?php echo $field['name'];?>" value="" data-source="<?php echo $field['source'];?>" class="ddr-autocompletion regular-text form-control <?php echo $field['class'];?>"/>
            <input type="hidden" value="<?php echo $current_value;?>" class="ddr-autocompletion-hidden" name="<?php echo $field['name'];?>"/>
            <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
            <?php
            break;
    }

}

//validate fields
function axian_ddr_validate_fields( $object, $post_data = null ){
    $msg = '';
    if ( is_null($post_data) ) $post_data = $_POST;
    if ( isset($object->fields) ){
        foreach ( $object->fields as $id => $field ){
            //check required
            if ( $field['required'] == true && isset($post_data[$field['name']]) && empty($post_data[$field['name']]) ){
                $msg .= 'Le champs "' . $field['label'] . '" est requis(e)<br>';
            }

            //
        }
    }

    return $msg;
}