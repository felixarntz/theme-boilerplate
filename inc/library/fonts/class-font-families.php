<?php
/**
 * Super_Awesome_Theme_Font_Families class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the available font families.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Font_Families extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered theme font families.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $families = array();

	/**
	 * Internal flag for whether families need to be re-sorted.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private $sorted_dirty = false;

	/**
	 * Registers a theme font family.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Font_Family $family Font family to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_family( Super_Awesome_Theme_Font_Family $family ) {
		$id = $family->get_prop( Super_Awesome_Theme_Font_Family::PROP_ID );

		if ( isset( $this->families[ $id ] ) ) {
			return false;
		}

		$this->families[ $id ] = $family;
		$this->sorted_dirty    = true;

		return true;
	}

	/**
	 * Gets a registered font family.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this font family.
	 * @return Super_Awesome_Theme_Font_Family Registered font family instance.
	 *
	 * @throws Super_Awesome_Theme_Font_Family_Not_Registered_Exception Thrown when $id does not identify a registered font family.
	 */
	public function get_registered_family( $id ) {
		if ( ! isset( $this->families[ $id ] ) ) {
			throw Super_Awesome_Theme_Font_Family_Not_Registered_Exception::from_id( $id );
		}

		return $this->families[ $id ];
	}

	/**
	 * Gets the registered font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array Font family objects.
	 */
	public function get_registered_families() {
		return $this->get_sorted_families();
	}

	/**
	 * Gets the available font family choices.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_family_choices() {
		return array_map( array( $this, 'family_to_choice' ), $this->get_sorted_families() );
	}

	/**
	 * Gets the available font weight choices.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_weight_choices() {
		return array(
			'100' => _x( 'Ultra-Light', 'font weight', 'super-awesome-theme' ),
			'200' => _x( 'Light', 'font weight', 'super-awesome-theme' ),
			'300' => _x( 'Book', 'font weight', 'super-awesome-theme' ),
			'400' => _x( 'Normal', 'font weight', 'super-awesome-theme' ),
			'500' => _x( 'Medium', 'font weight', 'super-awesome-theme' ),
			'600' => _x( 'Semi-Bold', 'font weight', 'super-awesome-theme' ),
			'700' => _x( 'Bold', 'font weight', 'super-awesome-theme' ),
			'800' => _x( 'Extra-Bold', 'font weight', 'super-awesome-theme' ),
			'900' => _x( 'Ultra-Bold', 'font weight', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets the available font groups.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where identifiers are the keys, and labels are the values.
	 */
	public function get_groups() {
		return array(
			Super_Awesome_Theme_Font_Family::GROUP_SYSTEM     => _x( 'System', 'font group', 'super-awesome-theme' ),
			Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF => _x( 'Sans-Serif', 'font group', 'super-awesome-theme' ),
			Super_Awesome_Theme_Font_Family::GROUP_SERIF      => _x( 'Serif', 'font group', 'super-awesome-theme' ),
			Super_Awesome_Theme_Font_Family::GROUP_MONOSPACE  => _x( 'Monospace', 'font group', 'super-awesome-theme' ),
		);
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_default_families':
			case 'filter_font_family_stack':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers the default font families.
	 *
	 * @since 1.0.0
	 */
	protected function register_default_families() {
		$families = array(

			// System fonts.
			new Super_Awesome_Theme_Font_Family( 'system', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'System Font', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen-Sans', 'Ubuntu', 'Cantarell', 'Helvetica Neue', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SYSTEM,
			) ),

			// Sans-serif fonts.
			new Super_Awesome_Theme_Font_Family( 'arial', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Arial', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Arial', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'comic_sans_ms', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Comic Sans MS', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Comic Sans MS', 'cursive', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'impact', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Impact', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Impact', 'Charcoal', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'helvetica_neue', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Helvetica Neue', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'libre_franklin', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Libre Franklin', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Libre Franklin', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'tahoma', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Tahoma', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Tahoma', 'Geneva', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'trebuchet_ms', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Trebuchet MS', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Trebuchet MS', 'Helvetica', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'verdana', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Verdana', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Verdana', 'Geneva', 'sans-serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SANS_SERIF,
			) ),

			// Serif fonts.
			new Super_Awesome_Theme_Font_Family( 'georgia', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Georgia', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Georgia', 'serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'palatino_linotype', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Palatino Linotype', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Palatino Linotype', 'Book Antiqua', 'Palatino', 'serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SERIF,
			) ),
			new Super_Awesome_Theme_Font_Family( 'times_new_roman', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Times New Roman', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Times New Roman', 'Times', 'serif' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_SERIF,
			) ),

			// Monospace fonts.
			new Super_Awesome_Theme_Font_Family( 'consolas', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Consolas', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Consolas', 'Andale Mono', 'DejaVu Sans Mono', 'monospace' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_MONOSPACE,
			) ),
			new Super_Awesome_Theme_Font_Family( 'courier_new', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Courier New', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Courier New', 'Courier', 'monospace' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_MONOSPACE,
			) ),
			new Super_Awesome_Theme_Font_Family( 'lucida_console', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Lucida Console', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Lucida Console', 'Monaco', 'monospace' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_MONOSPACE,
			) ),
			new Super_Awesome_Theme_Font_Family( 'monaco', array(
				Super_Awesome_Theme_Font_Family::PROP_LABEL => _x( 'Monaco', 'font family', 'super-awesome-theme' ),
				Super_Awesome_Theme_Font_Family::PROP_STACK => array( 'Monaco', 'Consolas', 'Andale Mono', 'DejaVu Sans Mono', 'monospace' ),
				Super_Awesome_Theme_Font_Family::PROP_GROUP => Super_Awesome_Theme_Font_Family::GROUP_MONOSPACE,
			) ),
		);

		array_walk( $families, array( $this, 'register_family' ) );
	}

	/**
	 * Filters the font family stack string to use in CSS.
	 *
	 * @since 1.0.0
	 *
	 * @param string $stack Font family stack string to use in CSS, or empty string.
	 * @param string $id    Font family identifier to look for, or empty string.
	 * @return string Font family stack string found, or pass-through value of $stack.
	 */
	protected function filter_font_family_stack( $stack, $id ) {
		if ( ! empty( $id ) && isset( $this->families[ $id ] ) ) {
			return $this->families[ $id ]->get_stack_string();
		}

		return $stack;
	}

	/**
	 * Transforms a font family object into its label.
	 *
	 * Used as an `array_map()` callback.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Font_Family $family Font family to transform.
	 * @return string Label for the font family.
	 */
	private function family_to_choice( Super_Awesome_Theme_Font_Family $family ) {
		return $family->get_prop( Super_Awesome_Theme_Font_Family::PROP_LABEL );
	}

	/**
	 * Sorts the registered font families as necessary and returns them.
	 *
	 * This essentially lazy-sorts the available families by their label. It should
	 * be used instead of accessing the $families property directly.
	 *
	 * @since 1.0.0
	 *
	 * @return array Font family objects, sorted by their label.
	 */
	private function get_sorted_families() {
		if ( $this->sorted_dirty ) {
			uasort( $this->families, array( $this, 'sort_families_compare_callback' ) );
			$this->sorted_dirty = false;
		}

		return $this->families;
	}

	/**
	 * Sorts font family objects alphabetically by their label.
	 *
	 * Used as an `uasort()` callback.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Font_Family $a Font family to compare.
	 * @param Super_Awesome_Theme_Font_Family $b Other font family to compare.
	 * @return int -1 if first family has priority, 1 if second family has priority, 0 otherwise.
	 */
	private function sort_families_compare_callback( Super_Awesome_Theme_Font_Family $a, Super_Awesome_Theme_Font_Family $b ) {
		$label_a = $a->get_prop( Super_Awesome_Theme_Font_Family::PROP_LABEL );
		$label_b = $b->get_prop( Super_Awesome_Theme_Font_Family::PROP_LABEL );

		if ( $label_a === $label_b ) {
			return 0;
		}

		return 0 > strcmp( $label_a, $label_b ) ? -1 : 1;
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_default_families' ), 0, 0 );
		add_filter( 'super_awesome_theme_font_family_choices', array( $this, 'get_family_choices' ) );
		add_filter( 'super_awesome_theme_font_weight_choices', array( $this, 'get_weight_choices' ) );
		add_filter( 'super_awesome_theme_font_family_stack', array( $this, 'filter_font_family_stack' ), 10, 2 );
	}
}
