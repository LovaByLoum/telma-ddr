<?php
/**
 * Created by PhpStorm.
 * User: Narisoa
 * Date: 01/08/2016
 * Time: 10:09
 */
global $post;
$pageInscription = wp_get_post_by_template( "page-inscription.php", "" );
$linkLostPassword = wp_lostpassword_url();
$pagePostule = wp_get_post_by_template( "page-postuler-offre.php", "" );
$is_offre = ( $post->post_type == JM_POSTTYPE_OFFRE  && is_single( $post->ID ) ) ? true : false;
$linkRedirect = ( $is_offre ) ? get_permalink( $pagePostule->ID ) ."?po=" . $post->ID : get_permalink( $post->ID );
?>
<form name="loginform" id="loginform" action="<?php echo $linkRedirect; ?>" method="post">
	<?php if ( isset( $_POST['errors'] ) && !empty( $_POST['errors'] ) ):
			$errors = $_POST['errors'];?>
		<p class="login-username error">
		<?php   if ( isset( $errors["incorrect_password"] ) && !empty( $errors["incorrect_password"] ) ):
					$message = ( !empty( $errors["incorrect_password"][0] ) && $errors["incorrect_password"][0] == "<strong>ERREUR</strong>" ) ? "Mot de passe incorrect." : $errors["incorrect_password"][0];
		            echo $message;
			    elseif ( isset( $errors['invalid_username'] ) && !empty( $errors['invalid_username'] ) ):
					$message = ( !empty( $errors["invalid_username"][0] ) && $errors["invalid_username"][0] == "<strong>ERREUR</strong>" ) ? "Identifiant ou adresse de messagerie incorrect." : $errors["incorrect_password"][0];
					echo $message;
		        endif;?>
		</p>
	<?php endif;?>
	<p class="login-username data-error">
		<label for="user_login">Identifiant ou adresse de messagerie</label>
		<input type="text" name="custom_log" id="user_login" class="input_text <?php if ( !empty( $error ) && isset( $error['invalid_username'] ) && !empty( $error['invalid_username'] ) ):?>error<?php endif;?>" value="<?php echo $_POST['custom_log'];?>" size="20">
	</p>

	<p class="login-password">
		<label for="user_pass">Mot de passe</label>
		<input type="password" name="custom_pwd" id="user_pass" class="input_text <?php if ( !empty( $error ) && isset( $error['incorrect_password'] ) && !empty( $error['incorrect_password'] ) ):?>error<?php endif;?>" value="<?php echo $_POST['custom_pwd'];?>" size="20">
	</p>

	<p class="login-remember">
		<label>
			<input name="custom_rememberme" type="checkbox" id="rememberme" value="forever" <?php if ( isset( $_POST['custom_rememberme'] ) && $_POST['custom_rememberme'] == "forever" ):?>checked="checked"<?php endif;?>>
			Se souvenir de moi
		</label>
	</p>

	<p class="login-submit">
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr($linkRedirect); ?>" />
		<input type="submit" name="telmarh_connection" id="wp-submit" class="button-primary" value="Se connecter">
	</p>
    <?php wp_nonce_field("telmarh_connection", 'custom_connect_block_nonce');?>
	<p class="login-links">

        <a href="<?php echo get_permalink( $pageInscription->ID );?>" class="signup" title="S'inscrire">
            S'inscrire
        </a>
		<a href="<?php echo $linkLostPassword;?>" class="lostpassword"
		   title="Mot de passe oublié">
			Mot de passe oublié
		</a>
	</p>

</form>