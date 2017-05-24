<?php
/**
 * Template Name: Page nous Contacter
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post, $current_user, $telmarh_options;
$nonce = wp_create_nonce( "wp_nonce_contact" );
$user = CUser::getById( $current_user->ID );
$name       = ( is_user_logged_in() ) ? $user->nom : ( ( isset( $_POST['nom_contact'] ) && !empty( $_POST['nom_contact'] ) ) ? $_POST['nom_contact'] : "" );
$prenom     = ( is_user_logged_in() ) ? $user->prenom : ( ( isset( $_POST['surname_contact'] ) && !empty( $_POST['surname_contact'] ) ) ? $_POST['surname_contact'] : "" );
$email      = ( is_user_logged_in() ) ? $user->email : ( ( isset( $_POST['email_contact'] ) && !empty( $_POST['email_contact'] ) ) ? $_POST['email_contact'] : "" );
$num_phone  = ( is_user_logged_in() ) ? $user->phone_number : ( ( isset( $_POST['num_phone'] ) && !empty( $_POST['num_phone'] ) ) ? $_POST['num_phone'] : "" );
$response   = ( isset( $telmarh_options['option_reponse_form'] ) && !empty( $telmarh_options['option_reponse_form'] ) ) ? $telmarh_options['option_reponse_form'] : "Merci ! Vos informations ont bien été envoyées.";
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header(); ?>
<section id="page-full-entry-content" class="contact-form form-page">
    <header class="entry-header">
        <div class="container">
            <?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
                <h1 class="entry-title"><?php echo $post->post_title;?></h1>
            <?php endif;?>
            <div class="entry-content">
                <?php echo apply_filters("the_content", $post->post_content );?>
            </div>
        </div>
    </header>

    <article class="content-area main-content" id="primary">
        <div class="status-publish hentry container">
            <?php if ( isset( $_POST['error'] ) && isset( $_POST['error']['error'] ) && $_POST['error']['error'] == 0 && empty($_POST['error']['msg']) ):?>
                <p class="response"><?php echo $response;?></p>
            <?php else :?>
                <div class="form-layout">
                    <form id="nous_contacter" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" autocomplete="off">
                        <?php if ( isset( $_POST['error']['error']  ) && $_POST['error']['error'] == 1 && isset( $_POST['error']['msg'] ) && !empty( $_POST['error']['msg'] ) ): ?>
                            <ul><?php echo $_POST['error']['msg'];?></ul>
                        <?php  endif;?>
                        <div class="control-group">
                            <h4 class="head-accordion open">Informations personnelles</h4>
                            <div class="head-accordion">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nom_contact">Nom <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Nom" name="nom_contact" id="nom_contact" value="<?php echo $name;?>" autocomplete="off" <?php if ( is_user_logged_in() && !empty( $name ) ):?>readonly="true"<?php endif;?> >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="surname_contact">Prénom <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Prénom" name="surname_contact" id="surname_contact" value="<?php echo $prenom;?>" autocomplete="off" <?php if ( is_user_logged_in() && !empty( $prenom ) ):?>readonly="true"<?php endif;?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email_contact">Adresse email <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Adresse email" name="email_contact" id="email_contact" value="<?php echo $email;?>" autocomplete="off"  <?php if ( is_user_logged_in() && !empty( $email ) ):?>readonly="true"<?php endif;?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="num_phone">Numéro de téléphone</label>
                                        <input type="text" class="form-control" placeholder="Numéro de téléphone" name="num_phone" id="num_phone" value="<?php echo $num_phone;?>" autocomplete="off" <?php if ( is_user_logged_in() && !empty( $num_phone ) ):?>readonly="true"<?php endif;?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <h5 class="head-accordion open">Votre Message <span class="required">*</span></h5>
                                    <textarea name="message" class="form-control" placeholder="Votre message"><?php echo $_POST['message'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="wp_nonce_contact" value="<?php echo $nonce;?>">
                        <input type="hidden" name="action" value="wp_nous_contacter">
                        <div class="submit-form">
                            <input type="submit" name="telmarh_init_nous_contacter" class="btn_contacter submit-button" value="Valider">
                        </div>
                    </form>
                </div>
            <?php endif;?>
        </div>
    </article>
</section>
<?php get_footer();