<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 15/05/19
 * Time: 09:20
 * To change this template use File | Settings | File Templates.
 */

//render fields
function axian_ddr_render_field( $field, $post_data = null, $label = true, $display_value_only = false ){
    if ( is_null($post_data) ) $post_data = $_POST;

    if ( preg_match('#.*?\[(.*?)\]\[(.*?)\]#', $field['name'], $matches) ){
        $current_value = (isset($post_data[$matches[2]]) ? $post_data[$matches[2]] : '' );
    }elseif ( preg_match('#.*?\[(.*?)\]#', $field['name'], $matches) ){
        $current_value = (isset($post_data[$matches[1]]) ? $post_data[$matches[1]] : '' );
    } else {
        $current_value = (isset($post_data[$field['name']]) ? $post_data[$field['name']] : '' );
    }

    if ( $display_value_only ){
        ?>
        <?php if ( $label ): ?><label class="col-sm-5"><?php echo $field['label'];?> :</label><?php endif;?>

        <?php
        echo '<div class="col-sm-7">';
        switch ( $field['type'] ){
            case 'text' :
            case 'checkbox' :
            case 'radio' :
            case 'wysiwyg' :
            case 'textarea' :
                echo $current_value;
                break;
            case 'date' :
                $current_value = axian_ddr_convert_to_dateformat($current_value);
                echo $current_value;
                break;
            case 'post_select':
            case 'taxonomy_select':
            case 'select':
                if ( $field['type'] == 'post_select' ){
                    $posts = get_posts(array('post_type' => $field['post_type'], 'numberposts' => -1));
                    foreach ( $posts as $p ){
                        $field['options'][$p->ID] = $p->post_title;
                    }
                }

                if ( $field['type'] == 'taxonomy_select' ){
                    $args = 'hierarchical=0&taxonomy='. $field['taxonomy'] .'&hide_empty=0&orderby=id&parent=0';
                    $terms = get_terms($field['taxonomy'], $args);
                    foreach ( $terms as $term ){
                        $field['options'][$term->term_id] = $term->name;
                    }
                }

                echo $field['options'][$current_value];
                break;
            case 'autocompletion' :
                ?>
                <span data-source="<?php echo $field['source'];?>" class="ddr-autocompletion"></span>
                <input type="hidden" value="<?php echo $current_value;?>" class="ddr-autocompletion-hidden"/>
                <?php
                break;
            case 'taxonomy_checkboxes':
                $args = 'hierarchical=1&taxonomy='.$field['taxonomy'].'&hide_empty=0&orderby=id';
                $terms = get_terms($field['taxonomy'], $args);
                $glue = '';
                if ( !empty($current_value) && is_array($current_value) ){
                    foreach ( $terms as $term ){
                        if ( in_array($term->term_id, $current_value ) ){
                            echo $glue . $term->name;
                            $glue = ', ';
                        }
                    }
                }
                break;
            case 'file':
                ?>
                <a href="<?php echo axian_ddr_get_file($current_value);?>" target="_blank" title="Télécharger"><i class="dashicons-before dashicons-media-document"></i> Télécharger</a>
                <?php
                break;
            default:
                echo $current_value;
        }
        echo '</div>';
    } else {
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
            case 'post_select':
            case 'taxonomy_select':
            case 'select':

                if ( $field['type'] == 'post_select' ){
                    $posts = get_posts(array('post_type' => $field['post_type'], 'numberposts' => -1));
                    foreach ( $posts as $p ){
                        $field['options'][$p->ID] = $p->post_title;
                    }
                    $field['search'] = true;
                }

                if ( $field['type'] == 'taxonomy_select' ){
                    $args = 'hierarchical=0&taxonomy='. $field['taxonomy'] .'&hide_empty=0&orderby=id&parent=0';
                    $terms = get_terms($field['taxonomy'], $args);
                    foreach ( $terms as $term ){
                        $field['options'][$term->term_id] = $term->name;
                    }
                    $field['search'] = true;
                }

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
                $current_value = axian_ddr_convert_to_dateformat($current_value);
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
                <input type="text" id="<?php echo $field['name'];?>" value="" <?php if(isset($field['validateur']))echo 'data-validateur="'.$field['validateur'].'"'?> data-source="<?php echo $field['source'];?>" class="ddr-autocompletion regular-text form-control <?php echo $field['class'];?>"/>
                <input type="hidden" value="<?php echo $current_value;?>" class="ddr-autocompletion-hidden" name="<?php echo $field['name'];?>"/>
                <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
                <?php
                break;
            case 'taxonomy_checkboxes':
                $current_value = isset($post_data[$field['taxonomy']]) ? $post_data[$field['taxonomy']] : array();
                ?>
                <?php if ( $label ): ?><label><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>

                <div class="ddr-taxonomy-tree">
                    <?php
                    echo axian_ddr_taxonomy_checkboxes_tree($field['taxonomy'], 0, $field['name'], $current_value );
                    ?>
                </div>
                <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
                <?php
                break;
            case 'file':
                ?>
                <?php if ( $label ): ?><label for="<?php echo $field['name'];?>"><?php echo $field['label'];?><?php if (  $field['required'] ) : ?>&nbsp;<span style="color:red;">*</span><?php endif;?></label><?php endif;?>
                <?php if ( isset($current_value) && !empty($current_value) ) : ?>
                    <div class="ddr-file-value-wrapper">
                        <a href="<?php echo axian_ddr_get_file($current_value);?>" target="_blank" title="Télécharger"><i class="dashicons-before dashicons-media-document"></i> Télécharger</a>
                        <input type="hidden" name="<?php echo $field['name'];?>" value="<?php echo $current_value;?>"/>
                        <a class="remove-ddr-file" href="#<?php echo $field['name'];?>" title="Supprimer"><i class="dashicons-before dashicons-no"></i></a>
                    </div>
                    <noscript>
                        <input name="<?php echo $field['name'];?>" type="file" id="<?php echo $field['name'];?>" class="regular-text form-control <?php echo $field['class'];?>" accept="<?php echo $field['accept'];?>"/>
                        <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
                    </noscript>
                <?php else : ?>
                    <input name="<?php echo $field['name'];?>" type="file" id="<?php echo $field['name'];?>" class="regular-text form-control <?php echo $field['class'];?>" accept="<?php echo $field['accept'];?>"/>
                    <?php if ( isset($field['description']) && !empty($field['description']) ) : ?><p><?php echo $field['description'];?></p><?php endif;?>
                <?php endif;?>
                <?php
                break;
        }
    }
}

function axian_ddr_taxonomy_checkboxes_tree( $taxonomy='', $parent = 0, $name, $current_values = array() ){
    $args = 'hierarchical=1&taxonomy='.$taxonomy.'&hide_empty=0&orderby=id&parent=' . $parent;
    $terms = get_terms($taxonomy, $args);
    $output = '<ul>';
    if(count($terms)>0){
        foreach ($terms as $term) {
            $output .= '<li>';
            $output .=  '<label><input type="checkbox" name="' . $name . '[]" value="' . $term->term_id . '" ' . (in_array($term->term_id, $current_values) ? 'checked' : '' ) . '/> ' . $term->name . '</label>';
            $output .=  axian_ddr_taxonomy_checkboxes_tree($taxonomy, $term->term_id, $name, $current_values);
            $output .= '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
}

//validate fields
function axian_ddr_validate_fields( $object, $post_data = null ){
    $msg = '';
    if ( is_null($post_data) ) $post_data = $_POST;
    if ( isset($object->fields) ){
        foreach ( $object->fields as $id => $field ){
            //check required
            if ( $field['required'] == true && isset($post_data[$field['name']]) && empty($post_data[$field['name']]) ){
                $msg .= 'Le champ "' . $field['label'] . '" est requis.<br>';
            }

            //file validation
            if ( $field['type'] == 'file' ){
                //required
                if ( isset($field['required']) ){
                    if( $_FILES["file"]["size"] == 0 ) {
                        $msg .= 'Le fichier "' . $field['label'] . '" est requis.<br>';
                    }
                }

                //extension
                if ( isset($field['mimetype']) ){
                    if( isset($_FILES['file']['type']) && !empty($_FILES['file']['type']) && !in_array($_FILES['file']['type'], $field['mimetype']) ) {
                        $msg .= 'Le format du fichier "' . $field['label'] . '" est invalide.<br>';
                    }
                }

                //size
                if ( isset($field['max_size']) ){
                    if ( isset($_FILES['file']['size']) && !empty($_FILES['file']['size']) && $_FILES['file']['size'] >= $field['max_size'] ) {
                        $msg .= 'Le poid du fichier "' . $field['label'] . '" est trop gros.<br>';
                    }
                }

            }
        }
    }

    return $msg;
}

function axian_ddr_process_file( $object ){
    $upload_dir_path = wp_upload_dir();
    $ddr_file_path = $upload_dir_path['basedir'] . DIRECTORY_SEPARATOR . 'ddr-files';
    if ( !is_dir($ddr_file_path) ){
        @mkdir($ddr_file_path);
    }
    $htaccessfilepath = $ddr_file_path . DIRECTORY_SEPARATOR . '.htaccess';
    if ( !file_exists($htaccessfilepath) ) {
        $htfile		 = @fopen($htaccessfilepath, 'w');
        $htoutput	 = "deny from all";
        @fwrite($htfile, $htoutput);
        @fclose($htfile);
    }

    $files_path = array();
    foreach ( $object->fields as $id => $field ){
        if ( $field['type'] == 'file' ){
            $post_data = isset($_FILES) && isset($_FILES[$field['name']]) ? $_FILES[$field['name']] : null;
            $original_name = $post_data['name'];
            $pi = pathinfo($original_name);
            $filename = uniqid().uniqid().'.'.$pi['extension'];
            if ( isset($post_data['tmp_name']) && !empty($post_data['tmp_name']) ){
                $filepath = $ddr_file_path . DIRECTORY_SEPARATOR . $filename;
                $return = move_uploaded_file($post_data['tmp_name'], $filepath );
                if ( 0 == intval($return) ){
                    return 'Erreur lors de l\'envoi du fichier "' . $field['label'] . '".<br>';
                } else {
                    $files_path[$field['name']] = $filename;
                }
            }
        }
    }

    return $files_path;
}

function axian_ddr_get_file( $filename ){
    return AXIAN_DDR_URL . 'entrypoint/download.php?file=' . base64_encode($filename);
}

function axian_ddr_convert_to_dateformat($date){
    if ( preg_match('#([0-9]{4})-([0-9]{2})-([0-9]{2})#', $date, $matches) ){
        $date = $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    return $date;
}

function axian_ddr_convert_to_mysql_date($date){
    if ( preg_match('#([0-9]{2})/([0-9]{2})/([0-9]{4})#', $date, $matches) ){
        $date = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
    }
    return $date;
}

function axian_ddr_convert_to_human_datetime($datetime){
    return strftime("%d %b %Y %H:%M:%S", strtotime($datetime) );
}

function axian_ddr_convert_to_human_date($date){
    return strftime("%d %b %Y", strtotime($date) );
}