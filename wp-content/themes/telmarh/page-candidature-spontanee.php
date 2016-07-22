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
		                        <?php echo apply_filters('the_content','[form form-spontanee]');?>
							</div>
						</article>
					</main>
	            </div>
		    </div>
		</div>
	</section>

<?php get_footer();