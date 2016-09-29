<?php
/**
 * The template for displaying all single posts.
 *
 * @package telmarh
 */
global $post;
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
                            <?php if ( has_post_thumbnail() ) : // check if the post has a Post Thumbnail assigned to it.?>
                                <img src="<?php the_post_thumbnail_url("medium");?>" class="archive-img wp-post-image">
                            <?php endif;  ?>
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
