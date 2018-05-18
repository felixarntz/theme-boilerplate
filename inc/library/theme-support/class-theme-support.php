<?php
/**
 * Super_Awesome_Theme_Theme_Support class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class for managing theme support.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Theme_Support extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Added theme features.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $features = array();

	/**
	 * Gets the value registered as support for a given theme feature.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id String identifier for the theme feature.
	 * @return mixed Theme support value, or false if not supported.
	 */
	public function get( $id ) {
		if ( ! isset( $this->features[ $id ] ) ) {
			return false;
		}

		return $this->features[ $id ]->get_support();
	}

	/**
	 * Checks if a given theme feature is supported.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id String identifier for the theme feature.
	 * @return bool True if supported, false otherwise.
	 */
	public function has( $id ) {
		return isset( $this->features[ $id ] ) && $this->features[ $id ]->is_supported();
	}

	/**
	 * Adds a new theme feature and support for it.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Theme_Feature $feature Theme feature to add.
	 */
	public function add_feature( Super_Awesome_Theme_Theme_Feature $feature ) {
		$id = $feature->get_id();

		$this->features[ $id ] = $feature;
		$this->features[ $id ]->add_support();
	}

	/**
	 * Gets a theme feature.
	 *
	 * This method always returns a theme feature instance. It may not be supported though.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id String identifier for the theme feature.
	 * @return Super_Awesome_Theme_Theme_Feature Theme feature instance.
	 */
	public function get_feature( $id ) {
		if ( ! isset( $this->features[ $id ] ) ) {
			return new Super_Awesome_Theme_Theme_Feature( $id );
		}

		return $this->features[ $id ];
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
			case 'set_content_width':
			case 'register_default_features':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Sets the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @since 1.0.0
	 *
	 * @global int $content_width
	 */
	protected function set_content_width() {
		global $content_width;

		/**
		 * Filters the theme's content width.
		 *
		 * @since 1.0.0
		 *
		 * @param int $content_width The theme's content width.
		 */
		$content_width = apply_filters( 'super_awesome_theme_content_width', 640 ); // 640px is 40rem, which is the content maximum width.
	}

	/**
	 * Registers support for the default theme features.
	 *
	 * @since 1.0.0
	 */
	protected function register_default_features() {
		$boolean_features = array(
			'automatic-feed-links',
			'title-tag',
			'post-thumbnails',
			'customize-selective-refresh-widgets',
		);

		foreach ( $boolean_features as $feature_id ) {
			$this->add_feature( new Super_Awesome_Theme_Theme_Feature( $feature_id ) );
		}

		$args_features = array(
			'post-formats' => array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ),
			'html5'        => array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ),
		);

		foreach ( $args_features as $feature_id => $feature_args ) {
			$this->add_feature( new Super_Awesome_Theme_Args_Theme_Feature( $feature_id, $feature_args ) );
		}

		// TODO: Add theme support for starter content.

		add_editor_style();
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'set_content_width' ), 0, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_default_features' ), 10, 0 );
	}
}
