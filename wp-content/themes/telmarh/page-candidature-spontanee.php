<?php
/**
 * Template Name: Page candidature spontanée
 *
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
global $post;
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header(); ?>
	<section id="page-full-entry-content" class="spontaneous-form form-page">
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
				<?php echo apply_filters('the_content','[form form-spontanee]');?>
				<div class="form-layout">
					<?php if ( isset( $_POST['error']['error']  ) && $_POST['error']['error'] == 1 && isset( $_POST['error']['msg'] ) && !empty( $_POST['error']['msg'] ) ): ?>
                        <ul><?php echo $_POST['error']['msg'];?></ul>
                    <?php  endif;?>
					<form id="spontanee-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" autocomplete="off">
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
	        </div>
        </article>

	    <div class="grid grid-pad">
		    <div class="col-1-1">
	            <div id="primary" class="content-area">
	                <main id="main" class="site-main" role="main">
	                    <article class="status-publish hentry">
	                        <div>
								
								
		                        
							</div>
						</article>
					</main>
	            </div>
		    </div>
		</div>
	</section>

<?php get_footer();