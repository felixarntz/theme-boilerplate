<?php
/**
 * The template for displaying the custom header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$header_textalign  = super_awesome_theme_get_setting( 'header_textalign' );
$branding_location = super_awesome_theme_get_setting( 'branding_location' );

?>
<div class="site-custom-header site-component <?php echo esc_attr( $header_textalign ); ?>">
	<div class="site-header-media">
		<?php the_custom_header_markup(); ?>
	</div>
	<div class="site-component-inner">
		<?php if ( 'header' === $branding_location ) : ?>
			<div class="site-branding">
				<?php get_template_part( 'template-parts/header/logo-and-title' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div><!-- .site-custom-header -->
