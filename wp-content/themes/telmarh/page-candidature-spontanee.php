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
	<figure class="alauneImg">
        <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.png" alt="">
    </figure>
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
        </div>
    </article>
</section>
<?php get_footer();