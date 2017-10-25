<?php
/**
 * Template Name: Page login
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post,$fmdb, $fm_globals;
if ( is_user_logged_in() ) {
    wp_redirect( get_site_url() );
    exit;
}
$pageInscription = wp_get_post_by_template( "page-inscription.php", "" );
$linkLostPassword = wp_lostpassword_url();
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header();?>
    <section id="page-full-entry-content" class="page-standard">
    <figure class="alauneImg">
      <?php if (isset($image) && !empty($image)) { ?>
          <img src="<?php echo $image[0]; ?>" alt="background">
      <?php } else { ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg"
               alt="">
      <?php } ?>
    </figure>
    <header class="entry-header">
        <div class="container">
          <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </div>
    </header>

    <article id="post-<?php the_ID(); ?>">
        <div class="container">
            <div class="entry-content">
              <?php if ( isset( $post->post_content ) && !empty( $post->post_content ) ):?>
                <?php echo $post->post_content;?>
              <?php endif;?>
                <form name="page-loginform" id="page-loginform" action="<?php echo get_permalink( $post->ID ); ?>" method="post">
                  <?php if (isset($_POST['errors']) && !empty($_POST['errors'])):
                    $errors = $_POST['errors']; ?>
                      <p class="login-username-page error">
                        <?php if (isset($errors["incorrect_password"]) && !empty($errors["incorrect_password"])):
                          $message = (!empty($errors["incorrect_password"][0]) && $errors["incorrect_password"][0] == "<strong>ERREUR</strong>") ? "Mot de passe incorrect." : $errors["incorrect_password"][0];
                          echo $message;
                        elseif (isset($errors['invalid_username']) && !empty($errors['invalid_username'])):
                          $message = (!empty($errors["invalid_username"][0]) && $errors["invalid_username"][0] == "<strong>ERREUR</strong>") ? "Identifiant ou adresse de messagerie incorrect." : $errors["incorrect_password"][0];
                          echo $message;
                        endif; ?>
                      </p>
                  <?php endif; ?>
                    <p class="login-username-page data-error">
                        <label for="user_login">Identifiant ou adresse de
                            messagerie </label>
                        <input type="text" name="custom_log_page" id="user_login"
                               class="input_text <?php if (!empty($error) && isset($error['invalid_username']) && !empty($error['invalid_username'])): ?>error<?php endif; ?>"
                               value="<?php echo $_POST['custom_log_page']; ?>"
                               size="20">
                    </p>

                    <p class="login-password">
                        <label for="user_pass">Mot de passe</label>
                        <input type="password" name="custom_pwd_page" id="user_pass"
                               class="input_text <?php if (!empty($error) && isset($error['incorrect_password']) && !empty($error['incorrect_password'])): ?>error<?php endif; ?>"
                               value="<?php echo $_POST['custom_pwd_page']; ?>"
                               size="20">
                    </p>

                    <p class="login-remember">
                        <label>
                            <input name="custom_rememberme" type="checkbox"
                                   id="rememberme" value="forever"
                                   <?php if (isset($_POST['custom_rememberme']) && $_POST['custom_rememberme'] == "forever"): ?>checked="checked"<?php endif; ?>>
                                   <span class="uncheck-bg"><span class="check-bg"></span></span>
                            Se souvenir de moi
                        </label>
                    </p>
                    <?php wp_nonce_field("telmarh_connection_page", 'custom_connect_nonce');?>
                    <p class="login-submit">
                        <input type="hidden" name="redirect_to"
                               value=""/>
                        <input type="submit" name="telmarh_connection_page"
                               id="wp-submit" class="button-primary"
                               value="Se connecter">
                    </p>

                    <p class="login-links">

                        <a href="<?php echo get_permalink($pageInscription->ID); ?>"
                           class="signup" title="S'inscrire">
                            S'inscrire
                        </a>
                        <a href="<?php echo $linkLostPassword; ?>"
                           class="lostpassword"
                           title="Mot de passe oublié">
                            Mot de passe oublié
                        </a>
                    </p>

                </form>
            </div><!-- .entry-content -->
        </div>
    </article>
<?php get_footer();