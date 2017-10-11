<?php
/**
 * The template for displaying the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

		<?php get_template_part( 'template-parts/footer/social-navigation' ); ?>

		<?php get_template_part( 'template-parts/footer/site-info' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
