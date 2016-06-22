<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage beapi
 * @since beapi 1.0
 * @author : Netapsys
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">


			<div id="site-generator">
				<?php do_action( 'beapi_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'beapi' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'beapi' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'beapi' ), 'WordPress' ); ?></a>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>