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

	<footer id="colophon" class="site-footer" role="contentinfo"></footer><!-- #colophon -->
</div><!-- #page -->
<script src="<?php echo get_template_directory_uri()?>/js/library/jquery.validate.min.js"></script>
<script src="<?php echo get_template_directory_uri()?>/js/library/validate.methods.js"></script>
<?php wp_footer(); ?>

</body>
</html>
