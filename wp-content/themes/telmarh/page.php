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

<section id="page-full-entry-content">
    <div class="grid grid-pad">
        <div class="col-11-12">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">

	                <article id="post-<?php the_ID(); ?>">
	                	<header class="entry-header">
	                		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	                	</header><!-- .entry-header -->

	                	<div class="entry-content">
			                <?php if ( isset( $post->post_content ) && !empty( $post->post_content ) ):?>
				                <?php echo $post->post_content;?>
							<?php endif;?>
	                	</div><!-- .entry-content -->

	                	<footer class="entry-footer">
	                		<?php edit_post_link( __( 'Edit', 'telmarh' ), '<span class="edit-link">', '</span>' ); ?>
	                	</footer><!-- .entry-footer -->
	                </article><!-- #post-## -->

                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- col-9-12 -->
    </div><!-- grid -->
</section><!-- page-entry-content -->

<?php get_footer(); ?>