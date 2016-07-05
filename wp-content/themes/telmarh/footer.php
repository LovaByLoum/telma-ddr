<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package telmarh
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
    	<div class="grid grid-pad">
		    <div class="col-9-12 tri-clear">
                <div class="menu-footer">
                    <?php echo CMenu::renderMenuFooter();?>
                </div><!-- .site-info -->
            </div>
        	<div class="col-3-12">
                <div class="site-info">
                    <?php if ( get_theme_mod( 'telmarh_footerid' ) ) : ?>
        				<?php echo esc_html( get_theme_mod( 'telmarh_footerid' )); // footer id ?>
					<?php else : ?>  
    					<?php printf( __( 'Theme: %1$s by %2$s', 'telmarh' ), 'telmarh', '<a href="http://modernthemes.net" rel="designer">modernthemes.net</a>' ); ?>
					<?php endif; ?> 
                </div><!-- .site-info -->
        	</div>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
