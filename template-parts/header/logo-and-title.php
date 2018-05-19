<?php
/**
 * The template for displaying the site logo and title in the header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$title       = get_bloginfo( 'name', 'display' );
$description = get_bloginfo( 'description', 'display' );

// The $data variable contains arbitrary data passed to the template.
$skip_h1 = isset( $data ) && ! empty( $data['skip_h1'] );

?>

<?php the_custom_logo(); ?>

<div class="site-branding-text">
	<?php if ( ! empty( $title ) || is_customize_preview() ) : ?>
		<?php if ( is_front_page() && is_home() && ! $skip_h1 ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $title; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $title; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></a></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $description ) || is_customize_preview() ) : ?>
		<p class="site-description"><?php echo $description; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></p>
	<?php endif; ?>
</div><!-- .site-branding-text -->
