<?php
/**
 * Template part for displaying the post author box
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! is_customize_preview() && ! super_awesome_theme_display_post_authorbox() ) {
	return;
}

$social_icons = super_awesome_theme( 'social_navigation' )->get_social_links_icons();

$social_links = array();

foreach ( wp_get_user_contact_methods() as $meta_key => $label ) {
	$icon  = '';
	$value = get_the_author_meta( $meta_key );

	if ( empty( $value ) ) {
		continue;
	}

	if ( 'twitter' === $meta_key && '@' === substr( $value, 0, 1 ) ) {
		$value = 'https://twitter.com/' . substr( $value, 1 );
	}

	if ( ! preg_match( '/^https?:/', $value ) ) {
		continue;
	}

	if ( in_array( $meta_key, $social_icons, true ) ) {
		$icon = $meta_key;
	} else {
		foreach ( $social_icons as $attr => $attr_icon ) {
			if ( false !== strpos( $value, $attr ) ) {
				$icon = $attr_icon;
				break;
			}
		}

		if ( empty( $icon ) ) {
			continue;
		}
	}

	$social_links[] = array(
		'url'   => $value,
		'label' => $label,
		'icon'  => $icon,
	);
}

?>
<div class="entry-authorbox">
	<?php if ( super_awesome_theme_display_post_authorbox() ) : ?>
		<div class="entry-authorbox-avatar">
			<?php
			/**
			 * Filters the author box avatar size.
			 *
			 * @since 1.0.0
			 *
			 * @param int $size The avatar height and width size in pixels.
			 */
			$author_bio_avatar_size = apply_filters( 'super_awesome_theme_authorbox_avatar_size', 96 );

			echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			?>
		</div>

		<div class="entry-authorbox-description">
			<h2 class="author-title">
				<span class="author-heading"><?php esc_html_e( 'Author:', 'super-awesome-theme' ); ?></span>
				<?php echo esc_html( get_the_author() ); ?>
			</h2>

			<p class="author-bio">
				<?php the_author_meta( 'description' ); ?>

				<?php if ( super_awesome_theme_display_author_posts_link() ) : ?>
					<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php
						/* translators: %s: author name */
						echo esc_html( sprintf( __( 'View all posts by %s', 'super-awesome-theme' ), get_the_author() ) );
						?>
					</a>
				<?php endif; ?>
			</p>

			<?php if ( ! empty( $social_links ) ) : ?>
				<ul class="author-social-links">
					<?php foreach ( $social_links as $social_link ) : ?>
						<li>
							<a href="<?php echo esc_url( $social_link['url'] ); ?>">
								<span class="screen-reader-text"><?php echo esc_html( $social_link['label'] ); ?></span>
								<?php echo super_awesome_theme_get_svg( $social_link['icon'] ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
