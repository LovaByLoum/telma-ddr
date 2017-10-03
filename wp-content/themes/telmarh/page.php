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
get_header();
$PageElement = CPage::getById($post->ID);
$slider_partenaire = $PageElement->slider_partenaire;
$frontpage_id = get_option( 'page_on_front' );
$blocPartenaires = CPage::getAllpartnerHp( $frontpage_id );
$blocPaves = CPage::getAllPavePage( $post->ID );
//echo '<br><br><br><br><br><br><br><br>paves: '.count($blocPaves);
?>
<section id="page-full-entry-content" class="page-standard">
    <figure class="alauneImg">
        <?php if ( isset( $image ) && !empty( $image ) ){?>
            <img src="<?php echo $image; ?>" alt="">
        <?php } else {?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/batiment.jpg" alt="">
        <?php }?>
    </figure>
    <div class="breadcrumb"><div class="container"><?php  get_breadcrumb(''); ?></div></div>
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

    <!-- slider -->
    <?php if ( !empty($slider_partenaire[0]) ): ?>
        <?php if ( isset( $blocPartenaires ) && !empty( $blocPartenaires ) ):?>
            <div class="panel-grid" id="pg-636-6">
                <div  class="panel-row-style">
                    <div class="panel-grid-cell" id="pgc-636-6-0">
                        <section id="home-clients" class="clients">
                            <?php if ( isset( $blocPartenaires['titre'] ) && !empty( $blocPartenaires['titre'] ) ):?>
                                <div class="grid grid-pad">
                                    <div class="col-1-1">
                                        <h3 class="widget-title">
                                            <?php echo $blocPartenaires['titre'];?>
                                        </h3>
                                    </div>
                                </div>
                            <?php  endif;?>
                            <?php if ( isset( $blocPartenaires['element'] ) && !empty( $blocPartenaires['element'] ) ):?>
                                <div class="grid grid-pad">
                                    <div class="col-1-1">
                                        <div class="client-carousel slick-initialized slick-slider">
                                            <div tabindex="0" aria-live="polite"
                                                 class="slick-list draggable">
                                                <div class="slick-track">
                                                    <?php foreach ( $blocPartenaires['element'] as $slider ):?>
                                                        <div>
                                                            <?php if ( isset( $slider->imageUrl ) && !empty( $slider->imageUrl ) ):?>
                                                                <a href="<?php echo $slider->link;?>" title="<?php echo $slider->name;?>">
                                                                    <div class="client-container">
                                                                        <img
                                                                            src="<?php echo $slider->imageUrl;?>"
                                                                            class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
                                                                            <?php if ( isset( $slider->imageTronque ) && !empty( $slider->imageTronque ) ):?>
                                                                                width="<?php echo $slider->imageTronque[0];?>"
                                                                                height="<?php echo $slider->imageTronque[1];?>"
                                                                            <?php endif;?>
                                                                        >
                                                                    </div>
                                                                </a>
                                                            <?php endif;?>
                                                        </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            <?php endif;?>
                        </section>
                    </div>
                </div>
            </div>
        <?php endif;?>
    <?php endif;?>
    <!-- fin slider -->

    <!-- picto -->
    <?php if ( !empty($blocPaves['element']) ): ?>
        <?php if ( isset( $blocPaves['element'] ) && !empty( $blocPaves['element'] ) ):?>
            <div class="container">
                <div class="grid-container">

                    <div class="grid-content">
                        <?php foreach ( $blocPaves['element'] as $pave): ?>
                            <?php if ( isset( $pave->bordure ) && !empty( $pave->bordure[0] ) ){?>
                                <div class="item-grid-grise">
                            <?php } else { ?>
                                    <div class="item-grid">
                            <?php } ?>
                                <img class="img-item" src="<?php echo $pave->imageUrl;?>" alt="<?php echo $pave->name;?>">
                            </div>

                        <?php endforeach; ?>
                    </div>


                </div>
            </div>
        <?php endif;?>
    <?php endif;?>
    <!-- fin picto -->


    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'telmarh' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->

    

<?php get_footer(); ?>