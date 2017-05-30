<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package telmarh
 */

global $post;
$idImage = get_post_thumbnail_id($post->ID);
$image = wp_get_attachment_image_src( $idImage, "full" );
get_header(); ?>

<section id="page-full-entry-content" class="page-standard">
    <figure class="alauneImg">
        <?php if ( isset( $image ) && !empty( $image ) ){?>
            <img src="<?php echo $image; ?>" alt="">
        <?php } else {?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
        <?php }?>
    </figure>
    <header class="entry-header">
        <div class="container">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </div>
    </header>

    <article id="post-<?php the_ID(); ?>">
        <div class="container">
            <div class="entry-content">
                <?php if ( isset( $post->post_content ) && !empty( $post->post_content ) ):?>
                    <?php echo $post->post_content;?>
                <?php endif;?>
            </div><!-- .entry-content -->
        </div>
    </article>

    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'telmarh' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->

    

<?php get_footer(); ?>