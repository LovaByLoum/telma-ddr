<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package telmarh
 */
global $telmarh_options;
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
    	<div class="grid grid-pad">
		    <div class="col-1-1">
                <div class="menu-footer">
                    <?php echo CMenu::renderMenuFooter();?>
                </div><!-- .site-info -->
            </div>
        </div>
		<?php if ( isset( $telmarh_options['copyright'] ) && !empty( $telmarh_options['copyright'] ) ):?>
		<div class="grid grid-pad">
			<div class="col-1-1">
				<p class="copy-right">
					<?php echo $telmarh_options['copyright'];?>
				</p>
			</div>
		</div>
		<?php endif;?>
	</footer><!-- #colophon -->
</div><!-- #page -->
<script src="<?php echo get_template_directory_uri()?>/js/library/jquery.validate.min.js"></script>
<script src="<?php echo get_template_directory_uri()?>/js/library/validate.methods.js"></script>
<?php wp_footer(); ?>

</body>
</html>
