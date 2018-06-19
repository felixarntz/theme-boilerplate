<?php
/**
 * The template for displaying the primary site navigation bar
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$navbar = super_awesome_theme()->get_component( 'navbar' );

$branding_location = super_awesome_theme_get_setting( 'branding_location' );
$menu_slug         = $navbar->get_navigation_name();

$extra_class         = super_awesome_theme_get_setting( 'navbar_justify_content' );
$widgets_extra_class = '';
if ( $navbar->is_sticky_allowed() ) {
	$extra_class          = 'is-flex ' . $extra_class;
	$widgets_extra_class .= ' inline-widget-area';
}

if ( 'header' === $branding_location && super_awesome_theme_use_page_header() ) {
	$branding_location = 'navbar_left';
}

?>

<div id="site-navbar" class="site-navbar site-component <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php if ( 'navbar_right' !== $branding_location ) : ?>
			<?php if ( 'navbar_left' === $branding_location ) : ?>
				<div class="site-branding">
					<?php get_template_part( 'template-parts/header/logo-and-title' ); ?>
				</div><!-- .site-branding -->
			<?php elseif ( $navbar->is_sticky_allowed() && $navbar->is_sticky() ) : ?>
				<div class="site-branding sticky-content" aria-hidden="true">
					<?php
					super_awesome_theme_get_template_part(
						'template-parts/header/logo-and-title',
						null,
						array( 'skip_h1' => true )
					);
					?>
				</div><!-- .site-branding -->
			<?php endif; ?>
		<?php endif; ?>

		<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'super-awesome-theme' ); ?>">
			<button class="menu-toggle" aria-controls="site-navigation-content" aria-expanded="false">
				<?php
				echo super_awesome_theme_get_svg( 'bars' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				echo super_awesome_theme_get_svg( 'close' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				esc_html_e( 'Menu', 'super-awesome-theme' );
				?>
			</button>

			<div id="site-navigation-content" class="site-navigation-content">
				<div class="site-navigation-menu">
					<?php super_awesome_theme_render_menu( $menu_slug ); ?>
				</div>

				<?php if ( super_awesome_theme_is_widget_area_active( 'nav-extra' ) ) : ?>
					<div id="site-navigation-extra" class="site-navigation-extra<?php echo esc_attr( $widgets_extra_class ); ?>">
						<?php super_awesome_theme_render_widget_area( 'nav-extra' ); ?>
					</div><!-- #site-nav-extra -->
				<?php endif; ?>
			</div>
		</nav><!-- #site-navigation -->

		<?php if ( 'navbar_right' === $branding_location ) : ?>
			<div class="site-branding">
				<?php get_template_part( 'template-parts/header/logo-and-title' ); ?>
			</div><!-- .site-branding -->
		<?php endif; ?>
	</div>
</div><!-- #site-top-bar -->
