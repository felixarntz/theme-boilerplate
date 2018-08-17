<?php
/**
 * WooCommerce compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Registers support for various WooCommerce features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'super_awesome_theme_woocommerce_setup', 11 );

/**
 * Registers the shop sidebar.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_register_sidebar() {
	$sidebar_description = __( 'Add widgets here to appear in the sidebar for shop content.', 'super-awesome-theme' );
	if ( ! get_theme_mod( 'shop_sidebar_enabled' ) ) {
		// If core allowed simple HTML here, a link to the respective customizer control would surely help.
		$sidebar_description .= ' ' . __( 'You need to enable the sidebar in the Customizer first.', 'super-awesome-theme' );
	}

	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'super-awesome-theme' ),
		'id'            => 'shop',
		'description'   => $sidebar_description,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'super_awesome_theme_woocommerce_register_sidebar', 11 );

/**
 * Adds an inline stylesheet to the main stylesheet to load the WooCommerce star font.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_enqueue_scripts() {
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'super-awesome-theme-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'super_awesome_theme_woocommerce_enqueue_scripts', 11 );

/**
 * Registers WooCommerce sidebar settings.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_register_settings() {
	$settings = super_awesome_theme( 'settings' );

	$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting(
		'shop_sidebar_enabled',
		array( Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => false )
	) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_woocommerce_register_settings', 10, 0 );

/**
 * Sets a flag so that the shop sidebar control is rendered in the Customizer.
 *
 * @since 1.0.0
 *
 * @param array $data Associative data array to pass to the script.
 * @return array Filtered array.
 */
function super_awesome_theme_woocommerce_set_sidebar_control_flag( $data ) {
	$data['displayShopSidebarEnabledSetting'] = true;

	return $data;
}
add_filter( 'super_awesome_theme_sidebar_controls_data', 'super_awesome_theme_woocommerce_set_sidebar_control_flag', 10, 1 );

/**
 * Registers WooCommerce sidebar Customizer partial.
 *
 * @since 1.0.0
 *
 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
 */
function super_awesome_theme_woocommerce_customize_register( $customizer ) {
	$customizer->add_partial( 'shop_sidebar_enabled', array(
		Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '#sidebar',
		Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => 'get_sidebar',
		Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
	) );
}
super_awesome_theme( 'customizer' )->on_init( 'super_awesome_theme_woocommerce_customize_register' );

/**
 * Overrides the name of the sidebar to display on the current page, if necessary.
 *
 * @since 1.0.0
 *
 * @param string $sidebar_name Sidebar name.
 * @return string Modified sidebar name.
 */
function super_awesome_theme_woocommerce_maybe_override_sidebar_name( $sidebar_name ) {
	if ( get_theme_mod( 'shop_sidebar_enabled' ) && is_woocommerce() ) {
		return 'shop';
	}

	return $sidebar_name;
}
add_filter( 'super_awesome_theme_get_sidebar_name', 'super_awesome_theme_woocommerce_maybe_override_sidebar_name' );

/**
 * Overrides whether the current page should be displayed in distraction-free mode, if necessary.
 *
 * @since 1.0.0
 *
 * @param bool $distraction_free Condition result.
 * @return bool Modified condition result.
 */
function super_awesome_theme_woocommerce_maybe_set_distraction_free( $distraction_free ) {
	if ( is_cart() || is_checkout() ) {
		return true;
	}

	return $distraction_free;
}
add_filter( 'super_awesome_theme_is_distraction_free', 'super_awesome_theme_woocommerce_maybe_set_distraction_free' );

/**
 * Adds a 'woocommerce-active' class to the body tag.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the body element.
 * @return array Modified classes.
 */
function super_awesome_theme_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'super_awesome_theme_woocommerce_active_body_class' );

/**
 * Filters the products to show per page.
 *
 * @since 1.0.0
 *
 * @return int Number of products.
 */
function super_awesome_theme_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'super_awesome_theme_woocommerce_products_per_page' );

/**
 * Filters the product gallery thumnbail columns.
 *
 * @since 1.0.0
 *
 * @return int Number of columns.
 */
function super_awesome_theme_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'super_awesome_theme_woocommerce_thumbnail_columns' );

/**
 * Filters the default loop columns on product archives.
 *
 * @since 1.0.0
 *
 * @return int Number of products per row.
 */
function super_awesome_theme_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'super_awesome_theme_woocommerce_loop_columns' );

/**
 * Filters the related products arguments.
 *
 * @since 1.0.0
 *
 * @param array $args Related products arguments.
 * @return array Modified related products arguments.
 */
function super_awesome_theme_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'super_awesome_theme_woocommerce_related_products_args' );

/**
 * Prints the product columns wrapper opening tag.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_product_columns_wrapper() {
	$columns = super_awesome_theme_woocommerce_loop_columns();

	echo '<div class="columns-' . absint( $columns ) . '">';
}
add_action( 'woocommerce_before_shop_loop', 'super_awesome_theme_woocommerce_product_columns_wrapper', 40 );

/**
 * Prints the product columns wrapper closing tag.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_product_columns_wrapper_close() {
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop', 'super_awesome_theme_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Prints the opening tags of the wrapper for all WooCommerce content.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_wrapper_before() {
	?>
	<main id="main" class="site-main">
	<?php
}
add_action( 'woocommerce_before_main_content', 'super_awesome_theme_woocommerce_wrapper_before' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );

/**
 * Prints the closing tags of the wrapper for all WooCommerce content.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_wrapper_after() {
	?>
	</main><!-- #main -->
	<?php
}
add_action( 'woocommerce_after_main_content', 'super_awesome_theme_woocommerce_wrapper_after' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

// Call the regular sidebar template instead of the WooCommerce one.
add_action( 'woocommerce_sidebar', 'get_sidebar' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

/**
 * Renders a cart link.
 *
 * Displays a link to the cart including the number of items present and the cart total.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_cart_link() {
	$subtotal = WC()->cart->get_cart_subtotal();
	$count    = WC()->cart->get_cart_contents_count();

	?>
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'super-awesome-theme' ); ?>">
		<span class="amount">
			<?php echo wp_kses_data( $subtotal ); ?>
		</span>
		<span class="count">
			<?php
			echo wp_kses_data( sprintf(
				/* translators: %s: number of items in the cart */
				_n( '%s item', '%s items', $count, 'super-awesome-theme' ),
				number_format_i18n( $count )
			) );
			?>
		</span>
	</a>
	<?php
}

/**
 * Displays the cart content for the header.
 *
 * @since 1.0.0
 */
function super_awesome_theme_woocommerce_header_cart() {
	if ( is_cart() ) {
		$class = 'current-menu-item';
	} else {
		$class = '';
	}
	?>
	<ul id="site-header-cart" class="site-header-cart">
		<li class="<?php echo esc_attr( $class ); ?>">
			<?php super_awesome_theme_woocommerce_cart_link(); ?>
		</li>
		<li>
			<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
			?>
		</li>
	</ul>
	<?php
}
add_action( 'super_awesome_theme_after_site_navigation', 'super_awesome_theme_woocommerce_header_cart' );

/**
 * Filters the cart fragments.
 *
 * Ensures cart contents update when products are added to the cart via AJAX.
 *
 * @since 1.0.0
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 */
function super_awesome_theme_woocommerce_cart_link_fragment( $fragments ) {
	ob_start();
	super_awesome_theme_woocommerce_cart_link();
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'super_awesome_theme_woocommerce_cart_link_fragment' );
