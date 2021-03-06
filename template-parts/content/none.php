<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>

<?php get_template_part( 'template-parts/header/generic-page-header' ); ?>

<div class="nothing-found-content">
	<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) {
		?>

		<p>
			<?php
			printf(
				wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'super-awesome-theme' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
			?>
		</p>

		<?php
	} elseif ( is_search() ) {
		?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'super-awesome-theme' ); ?></p>

		<?php
		get_search_form();
	} else {
		?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'super-awesome-theme' ); ?></p>

		<?php
		get_search_form();
	}
	?>
</div><!-- .nothing-found-content -->
