<?php
/**
 * page d'administration option du thème
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

global $telmarh_options_settings, $telmarh_options;

if ( ! isset( $_REQUEST['settings-updated'] ) )
  $_REQUEST['settings-updated'] = false;

?>
<div class="telmarh-themes">
  <form method="post" action="options.php" id="form-option" class="theme_option_ft">
    <div class="telmarh-header">
      <div class="logo">
        <img src="<?php echo get_template_directory_uri();?>/theme-options/images/logo.png" alt="telmarh theme options" />
        <h1>telmarh theme options</h1>
      </div>
      <div class="header-right">
        <h1> <?php _e( 'Theme Options', 'telmarh' ) ?> </h1>
        <div class='btn-save'>
          <input type='submit' class='button-primary' value='<?php _e('Enregistrer','telmarh') ?>' />
        </div>
      </div>
    </div>

    <div class="telmarh-details">
      <div class="telmarh-options">

        <div class="right-box">
          <div class="nav-tab-wrapper">
            <ul>
              <?php foreach ( $telmarh_options_settings as $tab => $fields ) :?>
              <li><a id="options-group-<?php echo sanitize_title($tab); ?>-tab" class="nav-tab" title="<?php echo $tab; ?>" href="#options-group-<?php echo sanitize_title($tab); ?>"><?php echo $tab; ?></a></li>
              <?php endforeach;?>
            </ul>
          </div>
        </div>
        <div class="right-box-bg"></div>

        <div class="postbox left-box">
          <!--======================== F I N A L - - T H E M E - - O P T I O N ===================-->
          <?php settings_fields( 'telmarh_options' );?>

          <?php foreach ( $telmarh_options_settings as $tab => $fields ) :?>
            <div id="options-group-<?php echo sanitize_title($tab); ?>" class="group telmarh-inner-tabs">
              <h3><?php echo $tab; ?></h3>
              <?php foreach ( $fields as $name => $field ):?>
                <div class="section theme-tabs">
                  <a class="heading telmarh-inner-tab" href="javascript:void(0)"><?php echo $field['label']; ?></a>
                  <div class="telmarh-inner-tab-group">
                    <div class="ft-control">
                      <?php
                      switch ( $field['type'] ){
                        case 'image' :
                          ?>
                          <input id="<?php echo sanitize_title($field['label']); ?>" class="upload" type="text" name="telmarh_theme_options[<?php echo $name; ?>]"
                                 value="<?php if(!empty($telmarh_options[$name])) { echo esc_url($telmarh_options[$name]); } ?>" placeholder="<?php _e('Aucun fichier','telmarh'); ?>" />
                          <input id="upload_image_button" class="upload-button button" type="button" value="<?php _e('Upload','telmarh'); ?>" />
                          <div class="screenshot" id="<?php echo $name; ?>-image">
                            <?php if(!empty($telmarh_options[$name])) { echo "<img src='".esc_url($telmarh_options[$name])."' />
                          <a class='remove-image'></a>"; } ?>
                          </div>
                          <?php
                          break;
                        case 'text' :
                          ?>
                          <div class="explain"><?php echo $field['description']; ?></div>
                          <input size="36" type="text" id="<?php echo $name;?>-text" class="of-input" name="telmarh_theme_options[<?php echo $name;?>]"  value="<?php if(!empty($telmarh_options[$name])) { echo esc_attr($telmarh_options[$name]); } ?>">
                          <?php
                          break;
                        case 'textarea':
                          ?>
                          <div class="explain"><?php echo $field['description']; ?></div>
                          <textarea name="telmarh_theme_options[<?php echo $name;?>]" rows="6" id="<?php echo $name;?>-text" class="of-input"><?php if(!empty($telmarh_options[$name])) { echo esc_attr($telmarh_options[$name]); } ?></textarea>
                          <?php
                          break;
                        case 'date':
                          break;
                        case 'select':
                          ?>
                          <div class="explain"><?php echo $field['description']; ?></div>
                          <select name="telmarh_theme_options[<?php echo $name;?>]" id="<?php echo $name;?>-select">
                            <option>Séléctionnez</option>
                            <?php foreach( $field['options'] as $value => $label):?>
                              <option value="<?php echo $value; ?>" <?php if ( $telmarh_options[$name] == $value ) echo 'selected=selected'?>><?php echo $label; ?></option>
                            <?php endforeach;?>
                          </select>
                          <?php
                          break;
                        case 'url':
                          ?>
                          <div class="explain"><?php echo $field['description']; ?></div>
                          <input size="36" id="<?php echo $name;?>-text" class="of-input" name="telmarh_theme_options[<?php echo $name;?>]" type="text" value="<?php if(!empty($telmarh_options[$name])) { echo esc_url($telmarh_options[$name]); } ?>" />
                          <?php
                          break;
                          case 'choice':
                              if(isset($field['options']['expanded']) && $field['options']['expanded'] === true &&
                                  isset($field['options']['multiple']) && $field['options']['multiple'] === false &&
                                  isset($field['options']['choices']) && is_array($field['options']['choices'])
                              ):

                              ?>
                              <div class="explain"><?php echo $field['description']; ?></div>
                                  <?php $i=0; foreach( $field['options']['choices'] as $value => $label): $i++;?>
                                      <input id="<?php echo $name.$i;?>-radio" class="of-input" name="telmarh_theme_options[<?php echo $name;?>]" type="radio" value="<?php echo $value; ?>" <?php if ( $telmarh_options[$name] == $value ) echo 'checked=checked'?> />
                                      <label for="<?php echo $name.$i;?>-radio"><?php echo $label;?></label>
                                  <?php endforeach;?>
                              <?php endif;
                              break;
                        default:
                      }
                      ?>


                    </div>
                  </div>
                </div>

              <?php endforeach;?>
            </div>
          <?php endforeach;?>

        <!--======================== F I N A L - - T H E M E - - O P T I O N S ===================-->
        </div>
      </div>
    </div>

    <div class="telmarh-footer">
      <ul>
        <li class="btn-save"><input type="submit" class="button-primary" value="<?php _e('Enregistrer','telmarh'); ?>" /></li>
      </ul>
    </div>

  </form>
</div>
<div class="save-options"><h2><?php _e('Options sauvegardés avec succés.','telmarh'); ?></h2></div>