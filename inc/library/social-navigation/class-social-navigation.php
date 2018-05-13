<?php
/**
 * Super_Awesome_Theme_Social_Navigation class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing the social navigation.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Social_Navigation extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Internal storage for available social links icons.
	 *
	 * @since 1.0.0
	 * @var array|null
	 */
	protected $social_links_icons;

	/**
	 * Link before argument for the social navigation menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $link_before = '';

	/**
	 * Link after argument for the social navigation menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $link_after = '';

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Menus' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Icons' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Colors' );
	}

	/**
	 * Gets an array of supported social links (URL and icon name).
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
	 */
	public function get_social_links_icons() {
		if ( is_array( $this->social_links_icons ) ) {
			return $this->social_links_icons;
		}

		$this->social_links_icons = array(
			'behance.net'     => 'behance',
			'codepen.io'      => 'codepen',
			'deviantart.com'  => 'deviantart',
			'digg.com'        => 'digg',
			'docker.com'      => 'dockerhub',
			'dribbble.com'    => 'dribbble',
			'dropbox.com'     => 'dropbox',
			'mailto:'         => 'envelope',
			'facebook.com'    => 'facebook',
			'flickr.com'      => 'flickr',
			'foursquare.com'  => 'foursquare',
			'github.com'      => 'github',
			'plus.google.com' => 'google-plus',
			'instagram.com'   => 'instagram',
			'linkedin.com'    => 'linkedin',
			'medium.com'      => 'medium',
			'pscp.tv'         => 'periscope',
			'tel:'            => 'phone',
			'pinterest.com'   => 'pinterest',
			'getpocket.com'   => 'pocket',
			'reddit.com'      => 'reddit',
			'skype.com'       => 'skype',
			'skype:'          => 'skype',
			'slideshare.net'  => 'slideshare',
			'snapchat.com'    => 'snapchat',
			'soundcloud.com'  => 'soundcloud',
			'spotify.com'     => 'spotify',
			'stumbleupon.com' => 'stumbleupon',
			'tumblr.com'      => 'tumblr',
			'twitch.tv'       => 'twitch',
			'twitter.com'     => 'twitter',
			'vimeo.com'       => 'vimeo',
			'vine.co'         => 'vine',
			'vk.com'          => 'vk',
			'wordpress.org'   => 'wordpress',
			'wordpress.com'   => 'wordpress',
			'yelp.com'        => 'yelp',
			'youtube.com'     => 'youtube',
		);

		/**
		 * Filters the theme's supported social links icons.
		 *
		 * @since 1.0.0
		 *
		 * @param array $social_links_icons Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
		 */
		$this->social_links_icons = apply_filters( 'super_awesome_theme_social_links_icons', $this->social_links_icons );

		return $this->social_links_icons;
	}

	/**
	 * Checks whether the social navigation menu  is active (i.e. has content).
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the menu  is active, false otherwise.
	 */
	public function is_active() {
		return $this->get_dependency( 'menus' )->get_registered_menu( 'social' )->is_active();
	}

	/**
	 * Magic call method.
	 *
	 * Handles the Customizer registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_menu':
			case 'register_colors':
			case 'add_menu_social_icons':
			case 'print_color_style':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Registers the social navigation menu.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Menus $menus Menus handler instance.
	 */
	protected function register_menu( $menus ) {
		$icons = $this->get_dependency( 'icons' );

		$this->link_before = '<span class="screen-reader-text">';
		$this->link_after  = '</span>' . $icons->get_svg( 'chain' );

		$menus->register_menu( new Super_Awesome_Theme_Menu( 'social', array(
			Super_Awesome_Theme_Menu::PROP_TITLE       => __( 'Social Links Menu', 'super-awesome-theme' ),
			Super_Awesome_Theme_Menu::PROP_MENU_CLASS  => 'social-links-menu',
			Super_Awesome_Theme_Menu::PROP_LINK_BEFORE => $this->link_before,
			Super_Awesome_Theme_Menu::PROP_LINK_AFTER  => $this->link_after,
			Super_Awesome_Theme_Menu::PROP_DEPTH       => 1,
		) ) );
	}

	/**
	 * Registers social colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_colors() {
		$colors = $this->get_dependency( 'colors' );

		$colors->register_group( 'social_colors', __( 'Social Icon Colors', 'super-awesome-theme' ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'social_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP           => 'social_colors',
			Super_Awesome_Theme_Color::PROP_TITLE           => __( 'Social Icons Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT         => '#ffffff',
			Super_Awesome_Theme_Color::PROP_ACTIVE_CALLBACK => array( $this, 'is_active' ),
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'social_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP           => 'social_colors',
			Super_Awesome_Theme_Color::PROP_TITLE           => __( 'Social Icons Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT         => '#767676',
			Super_Awesome_Theme_Color::PROP_ACTIVE_CALLBACK => array( $this, 'is_active' ),
		) ) );

		$colors->register_color_style_callback( array( $this, 'print_color_style' ) );
	}

	/**
	 * Adjusts the social links menu to display SVG icons.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $item_output The menu item output.
	 * @param WP_Post $item        Menu item object.
	 * @param int     $depth       Depth of the menu.
	 * @param array   $args        wp_nav_menu() arguments.
	 * @return string $item_output The menu item output with social icon.
	 */
	protected function add_menu_social_icons( $item_output, $item, $depth, $args ) {
		if ( $this->link_before === $args->link_before && $this->link_after === $args->link_after ) {
			$social_icons = $this->get_social_links_icons();

			foreach ( $social_icons as $attr => $value ) {
				if ( false !== strpos( $item_output, $attr ) ) {
					return str_replace( $args->link_after, '</span>' . super_awesome_theme_get_svg( $value ), $item_output );
				}
			}
		}

		return $item_output;
	}

	/**
	 * Prints color styles for the social navigation.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Colors $colors The theme colors instance.
	 */
	protected function print_color_style( $colors ) {
		$social_text_color       = $colors->get( 'social_text_color' );
		$social_background_color = $colors->get( 'social_background_color' );

		if ( empty( $social_text_color ) || empty( $social_background_color ) ) {
			return;
		}

		$social_background_focus_color = $colors->util()->darken_color( $social_background_color, 25 );

		?>
		.social-navigation a,
		.social-navigation a:visited {
			color: <?php echo esc_attr( $social_text_color ); ?>;
		}

		.social-navigation a {
			background-color: <?php echo esc_attr( $social_background_color ); ?>;
		}

		.social-navigation a:hover,
		.social-navigation a:focus {
			color: <?php echo esc_attr( $social_text_color ); ?>;
			background-color: <?php echo esc_attr( $social_background_focus_color ); ?>;
		}
		<?php
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'init', array( $this, 'register_colors' ), 20, 0 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'add_menu_social_icons' ), 10, 4 );

		$menus = $this->get_dependency( 'menus' );
		$menus->on_init( array( $this, 'register_menu' ) );
	}
}
