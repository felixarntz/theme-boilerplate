<?php
/**
 * The template for displaying the primary site navigation bar
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$branding_location = get_theme_mod( 'branding_location', 'above_navbar' );
$menu_slug         = super_awesome_theme_get_navigation_name();
$extra_class       = get_theme_mod( 'navbar_justify_content', 'space-between' );

?>

<div id="site-navbar" class="site-navbar site-component is-flex <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php if ( 'navbar_right' !== $branding_location ) : ?>
			<?php if ( 'navbar_left' === $branding_location ) : ?>
				<div class="site-branding">
					<?php get_template_part( 'template-parts/header/logo-and-title' ); ?>
				</div><!-- .site-branding -->
			<?php elseif ( (bool) get_theme_mod( 'sticky_navbar', false ) ) : ?>
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
				echo super_awesome_theme_get_svg( 'bars' ); // WPCS: XSS OK.
				echo super_awesome_theme_get_svg( 'close' ); // WPCS: XSS OK.
				esc_html_e( 'Menu', 'super-awesome-theme' );
				?>
			</button>

			<div id="site-navigation-content" class="site-navigation-content">
				<div class="site-navigation-menu">
					<?php
					wp_nav_menu( array(
						'theme_location' => $menu_slug,
						'menu_id'        => 'primary-menu',
						'container'      => false,
					) );
					?>
				</div>

				<?php if ( is_active_sidebar( 'nav-extra' ) || is_customize_preview() ) : ?>
					<div id="site-navigation-extra" class="site-navigation-extra inline-widget-area">
						<?php dynamic_sidebar( 'nav-extra' ); ?>
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
