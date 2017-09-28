<?php
/**
 * Template Name: Page lostpassword
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post,$fmdb, $fm_globals;
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
if ( is_user_logged_in() ) {
  wp_redirect( get_site_url() );
  exit;
}
get_header();?>
    <section id="page-full-entry-content" class="page-standard">
    <figure class="alauneImg">
      <?php if (isset($image) && !empty($image)) { ?>
          <img src="<?php echo $image; ?>" alt="">
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
                <form name="page-lostpassword" id="page-lostpassword" action="<?php echo get_permalink( $post->ID ); ?>" method="post">
                  <?php if (isset($_POST['errors']) && !empty($_POST['errors'])):
                    $errors = $_POST['errors']; ?>
                      <p class="login-username error">
                        <?php if (isset($errors["incorrect_login"]) && !empty($errors["incorrect_login"])):
                          $message = (!empty($errors["incorrect_login"][0]) && $errors["incorrect_login"][0] == "<strong>ERREUR</strong>") ? " l’identifiant ou l’adresse de messagerie n’est pas valide." : $errors["incorrect_login"][0];
                          echo $message;
                        endif; ?>
                      </p>
                  <?php endif; ?>
                    <p class="login-password">
                        <label for="lostpassword">Identifiant ou adresse de messagerie</label>
                        <input type="text" name="custom_email_name" id="custom_email_name"
                               class="input_text <?php if (!empty($error) && isset($error['incorrect_login']) && !empty($error['incorrect_login'])): ?>error<?php endif; ?>"
                               value="<?php echo $_POST['custom_email_name']; ?>"
                               size="20">
                    </p>

                    <p class="login-submit">
                        <input type="hidden" name="redirect_to"
                               value=""/>
                        <input type="submit" name="telmarh_lostpassword_page"
                               id="wp-submit" class="button-primary"
                               value="Générer un mot de passe">
                    </p>
                </form>
            </div><!-- .entry-content -->
        </div>
    </article>
<?php get_footer();