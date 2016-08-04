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
global $post;
get_header(); ?>
<section id="page-full-entry-content">
    <div class="grid grid-pad">
	    <div class="col-1-1">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <article class="status-publish hentry">
                        <div>
							<?php if ( isset( $post->post_title ) && !empty( $post->post_title ) ):?>
								<header class="entry-header">
		                            <h1 class="entry-title">
			                            <?php echo $post->post_title;?>
		                            </h1>
		                            <!-- .entry-meta -->
	                            </header>
							<?php endif;?>
							<div class="entry-content">
                                <?php echo apply_filters("the_content", $post->post_content );?>
                            </div>
	                        <form id="nous_contacter" method="post">
		                        <div class="control-group">
                                    <h4 class="head-accordion open">Informations personnelles</h4>
                                    <div class="head-accordion">
                                        <p class="col-1-2 form-field">
                                            <label for="name">Nom <span class="required">*</span></label>
                                            <input type="text" placeholder="Nom" name="name" id="name" value="<?php echo $_POST['name'];?>" autocomplete="off">
                                        </p>
                                        <p class="col-1-2 form-field">
                                            <label for="surname">Prénom <span class="required">*</span></label>
                                            <input type="text" placeholder="Prénom" name="surname" id="surname" value="<?php echo $_POST['surname'];?>" autocomplete="off">
                                        </p>
                                        <p class="col-1-2 form-field">
                                            <label for="email">Adresse email <span class="required">*</span></label>
                                            <input type="text" placeholder="Adresse email" name="email" id="email" value="<?php echo $_POST['email'];?>" autocomplete="off">
                                        </p>
                                        <p class="col-1-2 form-field">
                                            <label for="num_phone">Numéro de téléphone</label>
                                            <input type="text" placeholder="Numéro de téléphone" name="num_phone" id="num_phone" value="<?php echo $_POST['num_phone'];?>" autocomplete="off">
                                        </p>
                                    </div>
                                </div>
		                        <div class="control-group">
	                                <div class="col-1-1 form-field">
	                                    <h5 class="head-accordion open">Votre Message <span class="required">*</span></h5>
	                                    <textarea name="message" placeholder="Votre message"><?php echo $_POST['message'];?></textarea>
	                                </div>
	                            </div>
		                        <input type="submit" name="nous_contacter" class="btn_contacter" value="Valider">
	                        </form>
                        </div>
                    </article>
                </main>
            </div>
	    </div>
    </div>
</section>
<?php get_footer();