<?php
/**
 * Super_Awesome_Theme_AMP class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for handling AMP support.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_AMP extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Internal storage for whether the current context is an AMP endpoint.
	 *
	 * @since 1.0.0
	 * @var bool|null
	 */
	protected $is_amp_endpoint = null;

	/**
	 * Default key => value pairs to use for AMP state.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $state = array();

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Theme_Support' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Comments' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Navbar' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Sticky_Elements' );
	}

	/**
	 * Checks whether the current context is an AMP endpoint.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if an AMP endpoint, false otherwise.
	 */
	public function is_amp() {
		if ( ! did_action( 'parse_query' ) ) {
			return false;
		}

		if ( null === $this->is_amp_endpoint ) {
			$this->is_amp_endpoint = function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
		}

		return $this->is_amp_endpoint;
	}

	/**
	 * Gets the identifier for managing state in AMP.
	 *
	 * @since 1.0.0
	 *
	 * @return string Identifier of the amp-state tag.
	 */
	public function get_state_id() {
		return 'superAwesomeTheme';
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_support':
			case 'register_sanitizer':
			case 'maybe_prevent_scripts':
			case 'add_amp_indicator':
			case 'fix_header_video_body_class':
			case 'handle_sticky_elements':
			case 'print_state':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers theme support for 'amp'.
	 *
	 * @since 1.0.0
	 */
	protected function register_support() {
		$this->get_dependency( 'theme_support' )->add_feature( new Super_Awesome_Theme_Args_Theme_Feature(
			'amp',
			array(
				'comments_live_list' => true,
			)
		) );
	}

	/**
	 * Registers the theme-specific AMP sanitizer by filtering the available AMP sanitizers.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sanitizers AMP content sanitizers.
	 * @return array Filtered sanitizers.
	 */
	protected function register_sanitizer( array $sanitizers ) {
		if ( ! class_exists( 'Super_Awesome_Theme_AMP_Sanitizer' ) ) {
			require_once dirname( __FILE__ ) . '/class-amp-sanitizer.php';
		}

		$sanitizers['Super_Awesome_Theme_AMP_Sanitizer'] = array(
			'state_id' => $this->get_state_id(),
		);

		return $sanitizers;
	}

	/**
	 * Prevents scripts from being enqueued if in AMP context.
	 *
	 * @since 1.0.0
	 */
	protected function maybe_prevent_scripts() {
		if ( ! $this->is_amp() ) {
			return;
		}

		// Prevent the JS support detection script.
		remove_action( 'wp_head', array( $this->get_dependency( 'assets' ), 'print_detect_js_svg_support_script' ), 0 );

		// Prevent comment reply script from being enqueued.
		remove_action( 'wp_enqueue_scripts', array( $this->get_dependency( 'comments' ), 'maybe_enqueue_comment_reply_script' ), 20 );

		// Prevent any script from being enqueued.
		add_filter( 'super_awesome_theme_enqueue_script', '__return_false' );
	}

	/**
	 * Adds the AMP indicator lightning bolt by filtering the language attributes output.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output String containing a list of language attributes.
	 * @return string Filtered output.
	 */
	protected function add_amp_indicator( $output ) {
		return '⚡ ' . $output;
	}

	/**
	 * Replaces the 'has-header-video-loading' class with the 'has-header-video' class immediately.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes List of CSS classes to add to the body element.
	 * @return array Filtered CSS classes.
	 */
	protected function fix_header_video_body_class( $classes ) {
		$key = array_search( 'has-header-video-loading', $classes, true );

		if ( false !== $key ) {
			$classes[ $key ] = 'has-header-video';
		}

		return $classes;
	}

	/**
	 * Handles dynamic sticky content if in AMP context.
	 *
	 * The amp-position-observer tag is used to detect whether content should become sticky or not.
	 *
	 * @since 1.0.0
	 */
	protected function handle_sticky_elements() {

		// Skip for now since it is neither possible to set state nor animate position style based on position observer.
		if ( ! $this->is_amp() || true ) {
			return;
		}

		$sticky_elements = $this->get_dependency( 'sticky_elements' )->get_registered_sticky_elements();

		$state_id = $this->get_state_id();

		foreach ( $sticky_elements as $id => $sticky ) {
			if ( ! $sticky->get_setting()->get_value() ) {
				continue;
			}

			$selector = $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR );
			$location = $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_LOCATION );

			// The amp-position-observer can only deal with IDs.
			if ( '#' !== substr( $selector, 0, 1 ) ) {
				continue;
			}

			$state_property = implode( '', array_map( 'ucfirst', explode( '_', $id ) ) );
			$state_property = strtolower( substr( $state_property, 0, 1 ) ) . substr( $state_property, 1 ) . 'Sticky';

			$animation_id = 'make' . ucfirst( $state_property );

			$animation_data = array(
				'duration'   => '0.25s',
				'animations' => array(
					'selector' => $selector,
					'fill'     => 'both',
					'keyframes' => array(
						array(
							'position' => 'fixed',
							'right'    => 0,
							'left'     => 0,
							$location  => 0,
						),
					),
				),
			);

			?>
			<amp-animation id="<?php echo esc_attr( $animation_id ); ?>" layout="nodisplay">
				<script type="application/json">
					<?php echo wp_json_encode( $animation_data ); ?>
				</script>
			</amp-animation>
			<amp-position-observer target-id="<?php echo esc_attr( substr( $selector, 1 ) ); ?>"
				on="<?php echo esc_attr( "enter:{$animation_id}.start" ); ?>"
				layout="nodisplay"
			>
			</amp-position-observer>
			<?php
		}
	}

	/**
	 * Prints the amp-state tag containing the default state if in AMP context.
	 *
	 * @since 1.0.0
	 */
	protected function print_state() {
		if ( ! $this->is_amp() ) {
			return;
		}

		$this->state = array(
			'mobileMenuExpanded' => $this->get_dependency( 'navbar' )->is_side(),
			'sideNavbarExpanded' => ! $this->get_dependency( 'navbar' )->is_side(),
		);

		?>
		<amp-state id="<?php echo esc_attr( $this->get_state_id() ); ?>">
			<script type="application/json">
				<?php echo wp_json_encode( $this->state ); ?>
			</script>
		</amp-state>
		<?php
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_support' ), 10, 0 );
		add_filter( 'amp_content_sanitizers', array( $this, 'register_sanitizer' ), 10, 1 );
		add_action( 'wp', array( $this, 'maybe_prevent_scripts' ), 10, 0 );
		add_filter( 'language_attributes', array( $this, 'add_amp_indicator' ), 10, 1 );
		add_filter( 'body_class', array( $this, 'fix_header_video_body_class' ), 11, 1 );
		add_action( 'wp_footer', array( $this, 'handle_sticky_elements' ), 0, 0 );
		add_action( 'wp_footer', array( $this, 'print_state' ), 10, 0 );
	}
}
