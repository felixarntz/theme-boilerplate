<?php
/**
 * Super_Awesome_Theme_Widget class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a widget.
 *
 * @since 1.0.0
 */
abstract class Super_Awesome_Theme_Widget extends WP_Widget {

	/**
	 * Type field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_TYPE = 'type';

	/**
	 * Default field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_DEFAULT = 'default';

	/**
	 * Title field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_TITLE = 'title';

	/**
	 * Description field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_DESCRIPTION = 'description';

	/**
	 * Sanitize callback field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_SANITIZE_CALLBACK = 'sanitize_callback';

	/**
	 * Choices field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_CHOICES = 'choices';

	/**
	 * Input attributes field argument name.
	 *
	 * @since 1.0.0
	 */
	const FIELD_ARG_INPUT_ATTRS = 'input_attrs';

	/**
	 * Identifier for the text field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_TEXT = 'text';

	/**
	 * Identifier for the textarea field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_TEXTAREA = 'textarea';

	/**
	 * Identifier for the number field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_NUMBER = 'number';

	/**
	 * Identifier for the select field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_SELECT = 'select';

	/**
	 * Identifier for the radio field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_RADIO = 'radio';

	/**
	 * Identifier for the checkbox field type.
	 *
	 * @since 1.0.0
	 */
	const FIELD_TYPE_CHECKBOX = 'checkbox';

	/**
	 * Registered fields for the widget.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Constructor.
	 *
	 * Sets the widget definition arguments.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$slug        = $this->get_slug_from_classname();
		$title       = $this->get_title();
		$description = $this->get_description();

		parent::__construct( 'super_awesome_theme_' . $slug, $title, array(
			'classname'                   => 'widget_' . $slug,
			'description'                 => $description,
			'customize_selective_refresh' => true,
		) );

		$this->add_fields();
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {
		$instance = $this->parse_defaults( $instance );

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$this->render( $instance );

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for the current instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for the current instance.
	 * @return array|bool Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		foreach ( $this->fields as $id => $args ) {
			$value = isset( $new_instance[ $id ] ) ? $new_instance[ $id ] : null;

			$new_instance[ $id ] = call_user_func( $args[ self::FIELD_ARG_SANITIZE_CALLBACK ], $value, $args );
		}

		return $new_instance;
	}

	/**
	 * Renders the widget settings form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current instance.
	 */
	public function form( $instance ) {
		$instance = $this->parse_defaults( $instance );

		?>
		<div class="widget-form-controls">
			<?php
			foreach ( $this->fields as $id => $args ) {
				$this->render_form_field( $id, $args, $instance[ $id ] );
			}
			?>
		</div>
		<?php
	}

	/**
	 * Renders a single field of the widget settings form.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id    Field identifier.
	 * @param array  $args  Field definition arguments.
	 * @param mixed  $value Current field value.
	 */
	protected function render_form_field( $id, $args, $value ) {
		$control_id     = $this->get_field_id( $id );
		$control_name   = $this->get_field_name( $id );
		$type           = $args[ self::FIELD_ARG_TYPE ];
		$title          = $args[ self::FIELD_ARG_TITLE ];
		$description    = $args[ self::FIELD_ARG_DESCRIPTION ];
		$input_attrs    = $args[ self::FIELD_ARG_INPUT_ATTRS ];
		$description_id = $control_id . '-description';

		if ( ! empty( $description ) ) {
			$input_attrs['aria-describedby'] = $description_id;
		}
		if ( ! empty( $input_attrs['required'] ) ) {
			$input_attrs['aria-required'] = 'true';
		}

		?>
		<?php if ( self::FIELD_TYPE_RADIO === $type ) : ?>
			<fieldset>
				<legend>
					<?php echo wp_kses_data( $title ); ?>
				</legend>
		<?php else : ?>
			<p>
			<?php if ( self::FIELD_TYPE_CHECKBOX !== $type ) : ?>
				<label for="<?php echo esc_attr( $control_id ); ?>">
					<?php echo wp_kses_data( $title ); ?>
				</label>
			<?php endif; ?>
		<?php endif; ?>
		<?php
		switch ( $type ) {
			case self::FIELD_TYPE_NUMBER:
				?>
				<input type="number" id="<?php echo esc_attr( $control_id ); ?>" name="<?php echo esc_attr( $control_name ); ?>" value="<?php echo esc_attr( $value ); ?>"<?php $this->attrs( $input_attrs ); ?> />
				<?php
				break;
			case self::FIELD_TYPE_CHECKBOX:
				?>
				<input type="checkbox" id="<?php echo esc_attr( $control_id ); ?>" name="<?php echo esc_attr( $control_name ); ?>"<?php checked( $value ); ?><?php $this->attrs( $input_attrs ); ?> />
				<?php
				break;
			case self::FIELD_TYPE_SELECT:
				?>
				<select id="<?php echo esc_attr( $control_id ); ?>" name="<?php echo esc_attr( $control_name ); ?>"<?php $this->attrs( $input_attrs ); ?>>
					<?php foreach ( $args[ self::FIELD_ARG_CHOICES ] as $choice_value => $choice_label ) : ?>
						<option value="<?php echo esc_attr( $choice_value ); ?>"<?php selected( $value, $choice_value ); ?>>
							<?php echo esc_html( $choice_label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<?php
				break;
			case self::FIELD_TYPE_RADIO:
				foreach ( $args[ self::FIELD_ARG_CHOICES ] as $choice_value => $choice_label ) {
					$choice_slug = sanitize_title( $choice_value );
					?>
					<input type="radio" id="<?php echo esc_attr( $control_id . '-' . $choice_slug ); ?>" name="<?php echo esc_attr( $control_name ); ?>"<?php checked( $value, $choice_value ); ?><?php $this->attrs( $input_attrs ); ?> />
					<label for="<?php echo esc_attr( $control_id . '-' . $choice_slug ); ?>">
						<?php echo wp_kses_data( $choice_label ); ?>
					</label>
					<?php
				}
				break;
			case self::FIELD_TYPE_TEXTAREA:
				?>
				<textarea id="<?php echo esc_attr( $control_id ); ?>" name="<?php echo esc_attr( $control_name ); ?>"<?php $this->attrs( $input_attrs ); ?>><?php echo esc_textarea( $value ); ?></textarea>
				<?php
				break;
			default:
				?>
				<input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $control_id ); ?>" name="<?php echo esc_attr( $control_name ); ?>" value="<?php echo esc_attr( $value ); ?>"<?php $this->attrs( $input_attrs ); ?> />
				<?php
		}
		?>
		<?php if ( ! empty( $description ) ) : ?>
			<span id="<?php echo esc_attr( $description_id ); ?>" class="description">
				<?php wp_kses_data( $description ); ?>
			</span>
		<?php endif; ?>
		<?php if ( self::FIELD_TYPE_RADIO === $type ) : ?>
			</fieldset>
		<?php else : ?>
			<?php if ( self::FIELD_TYPE_CHECKBOX === $type ) : ?>
				<label for="<?php echo esc_attr( $control_id ); ?>">
					<?php echo wp_kses_data( $title ); ?>
				</label>
			<?php endif; ?>
			</p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Adds a field for the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Field identifier.
	 * @param array  $args Field definition arguments.
	 */
	protected function add_field( $id, array $args = array() ) {
		if ( ! isset( $args[ self::FIELD_ARG_TYPE ] ) ) {
			$args[ self::FIELD_ARG_TYPE ] = self::FIELD_TYPE_TEXT;
		}

		if ( ! isset( $args[ self::FIELD_ARG_TITLE ] ) ) {
			$args[ self::FIELD_ARG_TITLE ] = '';
		}

		if ( ! isset( $args[ self::FIELD_ARG_DESCRIPTION ] ) ) {
			$args[ self::FIELD_ARG_DESCRIPTION ] = '';
		}

		if ( ! isset( $args[ self::FIELD_ARG_INPUT_ATTRS ] ) ) {
			$args[ self::FIELD_ARG_INPUT_ATTRS ] = array();
		}

		if ( in_array( $args[ self::FIELD_ARG_TYPE ], array( self::FIELD_TYPE_SELECT, self::FIELD_TYPE_RADIO ), true ) && ! isset( $args[ self::FIELD_ARG_CHOICES ] ) ) {
			$args[ self::FIELD_ARG_CHOICES ] = array();
		}

		if ( ! isset( $args[ self::FIELD_ARG_DEFAULT ] ) ) {
			switch ( $args[ self::FIELD_ARG_TYPE ] ) {
				case self::FIELD_TYPE_NUMBER:
					$args[ self::FIELD_ARG_DEFAULT ] = 0.0;
					break;
				case self::FIELD_TYPE_CHECKBOX:
					$args[ self::FIELD_ARG_DEFAULT ] = false;
					break;
				case self::FIELD_TYPE_SELECT:
				case self::FIELD_TYPE_RADIO:
					if ( ! empty( $args[ self::FIELD_ARG_CHOICES ] ) ) {
						$keys                            = array_keys( $args[ self::FIELD_ARG_CHOICES ] );
						$args[ self::FIELD_ARG_DEFAULT ] = $keys[0];
					} else {
						$args[ self::FIELD_ARG_DEFAULT ] = '';
					}
					break;
				default:
					$args[ self::FIELD_ARG_DEFAULT ] = '';
			}
		}

		if ( ! isset( $args[ self::FIELD_ARG_SANITIZE_CALLBACK ] ) ) {
			$args[ self::FIELD_ARG_SANITIZE_CALLBACK ] = array( $this, 'default_sanitize_callback' );
		}

		$this->fields[ $id ] = $args;
	}

	/**
	 * Prints an attribute string from a list of attributes and their values.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attrs Attributes as $attr => $value pairs.
	 */
	protected function attrs( $attrs ) {
		$output = '';

		foreach ( $attrs as $attr => $value ) {
			$output .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
		}

		echo $output; // WPCS: XSS OK.
	}

	/**
	 * Parses a widget instance with its default values.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current widget instance.
	 * @return array Valid widget instance with defaults filled as necessary.
	 */
	protected function parse_defaults( $instance ) {
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}

		foreach ( $this->fields as $id => $args ) {
			if ( ! isset( $instance[ $id ] ) ) {
				$instance[ $id ] = $args[ self::FIELD_ARG_DEFAULT ];
			}
		}

		return $instance;
	}

	/**
	 * Performs default sanitization on a field value, based on the field type.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to sanitize.
	 * @param array $args  Field definition arguments for the value sanitized.
	 * @return mixed Sanitized value.
	 */
	protected function default_sanitize_callback( $value, $args ) {
		switch ( $args[ self::FIELD_ARG_TYPE ] ) {
			case self::FIELD_TYPE_NUMBER:
				if ( isset( $args[ self::FIELD_ARG_INPUT_ATTRS ]['step'] ) && is_int( $args[ self::FIELD_ARG_INPUT_ATTRS ]['step'] ) ) {
					$value = (int) $value;
				} else {
					$value = (float) $value;
				}
				if ( isset( $args[ self::FIELD_ARG_INPUT_ATTRS ]['min'] ) && $value < $args[ self::FIELD_ARG_INPUT_ATTRS ]['min'] ) {
					$value = $args[ self::FIELD_ARG_INPUT_ATTRS ]['min'];
				}
				if ( isset( $args[ self::FIELD_ARG_INPUT_ATTRS ]['max'] ) && $value < $args[ self::FIELD_ARG_INPUT_ATTRS ]['max'] ) {
					$value = $args[ self::FIELD_ARG_INPUT_ATTRS ]['max'];
				}
				break;
			case self::FIELD_TYPE_CHECKBOX:
				$value = (bool) $value;
				break;
			case self::FIELD_TYPE_SELECT:
			case self::FIELD_TYPE_RADIO:
				$value = (string) $value;
				if ( ! isset( $args[ self::FIELD_ARG_CHOICES ][ $value ] ) ) {
					$value = $args[ self::FIELD_ARG_DEFAULT ];
				}
				break;
			case self::FIELD_TYPE_TEXTAREA:
				$value = trim( (string) $value );
				if ( ! current_user_can( 'unfiltered_html' ) ) {
					$value = wp_kses_post( $value );
				}
				break;
			default:
				$value = sanitize_text_field( trim( (string) $value ) );
		}

		if ( ! empty( $args[ self::FIELD_ARG_INPUT_ATTRS ]['required'] ) && empty( $value ) ) {
			$value = $args[ self::FIELD_ARG_DEFAULT ];
		}

		return $value;
	}

	/**
	 * Adds the commonly-used field for the widget title.
	 *
	 * @since 1.0.0
	 */
	protected function add_title_field() {
		$this->add_field( 'title', array(
			self::FIELD_ARG_TYPE  => self::FIELD_TYPE_TEXT,
			self::FIELD_ARG_TITLE => __( 'Title', 'super-awesome-theme' ),
		) );
	}

	/**
	 * Gets the title of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Title for the widget.
	 */
	protected abstract function get_title();

	/**
	 * Gets the description of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Description for the widget.
	 */
	protected abstract function get_description();

	/**
	 * Adds the available widget form fields.
	 *
	 * @since 1.0.0
	 */
	protected abstract function add_fields();

	/**
	 * Renders the widget for a given instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current widget instance.
	 */
	protected abstract function render( array $instance );

	/**
	 * Gets the widget slug from the class name.
	 *
	 * @since 1.0.0
	 *
	 * @return string Unprefixed widget slug.
	 */
	private function get_slug_from_classname() {
		$slug = str_replace( 'Super_Awesome_Theme_', '', get_class( $this ) );

		if ( 'Widget_' === substr( $slug, 0, 7 ) ) {
			$slug = substr( $slug, 7 );
		} elseif ( '_Widget' === substr( $slug, -7 ) ) {
			$slug = substr( $slug, 0, -7 );
		}

		return strtolower( $slug );
	}
}
