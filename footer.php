<?php
/**
 * The template for displaying the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>

		</div>
	</div><!-- #content -->

	<?php

	/**
	 * Fires before the theme's footer is printed.
	 *
	 * @since 1.0.0
	 */
	do_action( 'super_awesome_theme_before_footer' );
	?>

	<footer id="footer" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

		<?php get_template_part( 'template-parts/footer/social-navigation' ); ?>

		<?php get_template_part( 'template-parts/footer/footer-navigation' ); ?>

		<?php get_template_part( 'template-parts/footer/site-bottom-bar' ); ?>
	</footer><!-- #footer -->

	<?php

	/**
	 * Fires after the theme's footer has been printed.
	 *
	 * @since 1.0.0
	 */
	do_action( 'super_awesome_theme_after_footer' );
	?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
