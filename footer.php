<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress_Theme
 */

?>

		</div><!-- #content -->

    </div><!-- #page -->

	<footer id="footer" class="site-footer">
		<div class="container site-info">
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'wp-theme' ), 'wp-theme', '<a href="http://www.websightdesigns.com/">websightdesigns</a>' ); ?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>