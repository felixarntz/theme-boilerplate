<?php
/**
 * Super_Awesome_Theme_Content_Types class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing content type-specific behavior.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Content_Types extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Attachment metadata handler.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Attachment_Metadata
	 */
	private $attachment_metadata;

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
	}

	/**
	 * Gets the post type from the current context.
	 *
	 * @since 1.0.0
	 *
	 * @return string Post type, or empty string if no post type could be detected.
	 */
	public function detect_post_type() {
		switch ( true ) {
			case is_front_page():
				if ( is_home() ) {
					return 'post';
				}
				return 'page';
			case is_singular():
				return get_post_type();
			case is_home():
				return 'post';
			case is_category():
			case is_tag():
			case is_tax():
				$term = get_queried_object();
				if ( $term ) {
					$taxonomy = get_taxonomy( $term->taxonomy );
					if ( $taxonomy && ! empty( $taxonomy->object_type ) && count( $taxonomy->object_type ) === 1 ) {
						return reset( $taxonomy->object_type );
					}
				}
				break;
			default:
				$post_types = get_query_var( 'post_type' );
				if ( ! empty( $post_types ) ) {
					if ( is_array( $post_types ) ) {
						return reset( $post_types );
					}
					return $post_types;
				}
		}

		return '';
	}

	/**
	 * Checks whether page headers should be used for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string|null $post_type Optional. Post type to check. Default is null, so the
	 *                               post type will be automatically detected if possible.
	 * @return bool True if page headers should be used, false otherwise.
	 */
	public function should_use_page_header( $post_type = null ) {
		if ( null === $post_type ) {
			$post_type = $this->detect_post_type();
		}

		$use_page_header = false;
		if ( ! empty( $post_type ) && ! is_front_page() ) {
			$use_page_header = $this->get_dependency( 'settings' )->get( $post_type . '_use_page_header' );
		}

		/**
		 * Filters whether a page header should be used for the current context.
		 *
		 * By default, this depends on the setting for the post type currently queried.
		 *
		 * @since 1.0.0
		 *
		 * @param bool   $use_page_header Whether to use a page header.
		 * @param string $post_type       Current post type, or empty string if none detected.
		 */
		return apply_filters( 'super_awesome_theme_use_page_header', $use_page_header, $post_type );
	}

	/**
	 * Checks whether post format templates should be used for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if post format templates should be used, false otherwise.
	 */
	public function should_use_post_format_templates( $post_type ) {
		if ( ! post_type_supports( $post_type, 'post-formats' ) ) {
			return false;
		}

		$result = 'post' === $post_type ? true : false;

		/**
		 * Filters whether to use post format templates for a post type.
		 *
		 * If you set this to true, you must ensure there is at least a `template-parts/content/content-{$posttype}.php` file
		 * present in the theme.
		 *
		 * @since 1.0.0
		 *
		 * @param bool   $result    Whether to use post format templates. Default is true for type 'post', false otherwise.
		 * @param string $post_type Post type slug.
		 */
		return apply_filters( 'super_awesome_theme_use_post_format_templates', $result, $post_type );
	}

	/**
	 * Checks whether the navigation to the previous and next post should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if the post navigation should be displayed, false otherwise.
	 */
	public function should_display_post_navigation( $post_type ) {
		if ( 'post' === $post_type ) {
			return true;
		}

		$post_type_object = get_post_type_object( $post_type );
		if ( ! $post_type_object ) {
			return false;
		}

		return (bool) $post_type_object->has_archive;
	}

	/**
	 * Checks whether comments should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if comments should be displayed, false otherwise.
	 */
	public function should_display_post_comments( $post_type ) {
		return post_type_supports( $post_type, 'comments' );
	}

	/**
	 * Checks whether the excerpt should be used for a post instead of its content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if the excerpt should be used, false otherwise.
	 */
	public function should_use_post_excerpt( $post_type ) {
		if ( ! post_type_supports( $post_type, 'excerpt' ) ) {
			return false;
		}

		return $this->get_dependency( 'settings' )->get( $post_type . '_use_excerpt' );
	}

	/**
	 * Checks whether the date should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if the date should be displayed, false otherwise.
	 */
	public function should_display_post_date( $post_type ) {
		return $this->get_dependency( 'settings' )->get( $post_type . '_show_date' );
	}

	/**
	 * Checks whether the author name should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if the author name should be displayed, false otherwise.
	 */
	public function should_display_post_author( $post_type ) {
		if ( ! post_type_supports( $post_type, 'author' ) ) {
			return false;
		}

		return $this->get_dependency( 'settings' )->get( $post_type . '_show_author' );
	}

	/**
	 * Checks whether the terms of a specific taxonomy should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $taxonomy  Taxonomy slug.
	 * @param string $post_type Post type to check.
	 * @return bool True if the terms of a specific taxonomy should be displayed, false otherwise.
	 */
	public function should_display_post_taxonomy_terms( $taxonomy, $post_type ) {
		return $this->get_dependency( 'settings' )->get( $post_type . '_show_terms_' . $taxonomy );
	}

	/**
	 * Checks whether the author box should be displayed for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to check.
	 * @return bool True if the author box should be displayed, false otherwise.
	 */
	public function should_display_post_authorbox( $post_type ) {
		if ( ! post_type_supports( $post_type, 'author' ) ) {
			return false;
		}

		return $this->get_dependency( 'settings' )->get( $post_type . '_show_authorbox' );
	}

	/**
	 * Retrieves the attachment metadata handler.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Attachment_Metadata Attachment metadata handler.
	 */
	public function attachment_metadata() {
		return $this->attachment_metadata;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the action and filter hook callbacks as well as the necessary Customizer partials.
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
			case 'register_settings':
			case 'register_customize_partials':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
				call_user_func_array( array( $this, $method ), $args );
				break;

			case 'add_content_type_body_classes':
				if ( empty( $args ) ) {
					return;
				}

				$classes = $args[0];

				$post_type = $this->detect_post_type();
				if ( ! empty( $post_type ) ) {
					$classes[] = 'is-post-type-' . $post_type;
				}

				if ( $this->should_use_page_header() ) {
					$classes[] = 'has-page-header';
				}

				return $classes;

			case 'add_singular_archive_post_classes':
				if ( empty( $args ) ) {
					return array();
				}
				$classes = $args[0];
				$post_id = $args[2];
				if ( is_singular( get_post_type( $post_id ) ) && (int) $GLOBALS['wp_the_query']->get_queried_object_id() === (int) $post_id ) {
					$classes[] = 'singular-view';
				} else {
					$classes[] = 'archive-view';
				}
				return $classes;

			case 'partial_entry_content':
			case 'partial_entry_meta':
			case 'partial_entry_attachment_meta':
			case 'partial_entry_terms':
			case 'partial_entry_authorbox':
				if ( empty( $args ) || empty( $args[1]['post_id'] ) ) {
					return;
				}
				$post = get_post( $args[1]['post_id'] );
				if ( ! $post ) {
					return;
				}
				$GLOBALS['post'] = $post; // phpcs:ignore WordPress.Variables.GlobalVariables.OverrideProhibited
				setup_postdata( $post );
				get_template_part( 'template-parts/content/' . str_replace( '_', '-', substr( $method, 8 ) ), $post->post_type );
				break;
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers settings for all registered content types and their behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings                  = $this->get_dependency( 'settings' );
		$this->attachment_metadata = new Super_Awesome_Theme_Attachment_Metadata( $settings );

		$boolean_settings = array();

		$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $public_post_types as $post_type ) {
			$boolean_settings[ $post_type->name . '_use_page_header' ] = false;

			if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
				$boolean_settings[ $post_type->name . '_use_excerpt' ] = false;
			}

			$boolean_settings[ $post_type->name . '_show_date' ] = in_array( $post_type->name, array( 'post', 'attachment' ), true );

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_settings[ $post_type->name . '_show_author' ]    = in_array( $post_type->name, array( 'post', 'attachment' ), true );
				$boolean_settings[ $post_type->name . '_show_authorbox' ] = 'post' === $post_type->name && is_multi_author();
			}

			$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
				'public' => true,
			) );
			foreach ( $public_taxonomies as $taxonomy ) {
				$boolean_settings[ $post_type->name . '_show_terms_' . $taxonomy->name ] = true;
			}

			if ( 'attachment' === $post_type->name ) {
				foreach ( $this->attachment_metadata->get_fields() as $field => $label ) {
					$boolean_settings[ 'attachment_show_metadata_' . $field ] = true;
				}
			}
		}

		foreach ( $boolean_settings as $id => $default ) {
			$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting(
				$id,
				array( Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => $default )
			) );
		}
	}

	/**
	 * Registers Customizer controls, sections and a panel for all registered content types and their behavior.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_partials( $customizer ) {
		$customizer->add_panel( 'content_types', array(
			Super_Awesome_Theme_Customize_Panel::PROP_TITLE    => __( 'Content Types', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Panel::PROP_PRIORITY => 140,
		) );

		$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $public_post_types as $post_type ) {
			if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
				$customizer->add_partial( $post_type->name . '_archive_content', array(
					Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => array( $post_type->name . '_use_excerpt' ),
					Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '.type-' . $post_type->name . '.archive-view .entry-content',
					Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'partial_entry_content' ),
					Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
					Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
					Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
				) );
			}

			$entry_meta_settings = array( $post_type->name . '_show_date' );
			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$entry_meta_settings[] = $post_type->name . '_show_author';
			}

			$customizer->add_partial( $post_type->name . '_entry_meta', array(
				Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => $entry_meta_settings,
				Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '.type-' . $post_type->name . ' .entry-meta',
				Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'partial_entry_meta' ),
				Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
				Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
				Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
			) );

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_controls[ $post_type->name . '_show_authorbox' ] = array(
					'label'           => __( 'Show Author Box?', 'super-awesome-theme' ),
					'selector'        => '.type-' . $post_type->name . ' .entry-authorbox',
					'render_callback' => array( $this, 'partial_entry_authorbox' ),
				);

				$customizer->add_partial( $post_type->name . '_entry_authorbox', array(
					Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => array( $post_type->name . '_show_authorbox' ),
					Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '.type-' . $post_type->name . ' .entry-authorbox',
					Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'partial_entry_authorbox' ),
					Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
					Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
					Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
				) );
			}

			$entry_terms_settings = array();

			$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
				'public' => true,
			) );
			foreach ( $public_taxonomies as $taxonomy ) {
				$entry_terms_settings[] = $post_type->name . '_show_terms_' . $taxonomy->name;
			}

			if ( ! empty( $entry_terms_settings ) ) {
				$customizer->add_partial( $post_type->name . '_entry_terms', array(
					Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => $entry_terms_settings,
					Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '.type-' . $post_type->name . ' .entry-terms',
					Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'partial_entry_terms' ),
					Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
					Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
					Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
				) );
			}

			if ( 'attachment' === $post_type->name ) {
				$entry_attachment_meta_settings = array();
				foreach ( $this->attachment_metadata->get_fields() as $field => $label ) {
					$entry_attachment_meta_settings[] = 'attachment_show_metadata_' . $field;
				}

				if ( ! empty( $entry_attachment_meta_settings ) ) {
					$customizer->add_partial( $post_type->name . '_entry_attachment_meta', array(
						Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => $entry_attachment_meta_settings,
						Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '.type-' . $post_type->name . ' .entry-attachment-meta',
						Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'partial_entry_attachment_meta' ),
						Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
						Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
						Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
					) );
				}
			}
		}
	}

	/**
	 * Registers scripts for the Customizer controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_controls_js( $assets ) {
		$data = array(
			'postTypes' => array(),
		);

		$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $public_post_types as $post_type ) {
			$post_type_data = array(
				'slug'        => $post_type->name,
				'label'       => $post_type->label,
				'supports'    => array_keys( array_filter( get_all_post_type_supports( $post_type->name ) ) ),
				'taxonomies'  => array(),
				'extraFields' => array(),
			);

			$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
				'public' => true,
			) );
			foreach ( $public_taxonomies as $taxonomy ) {
				$post_type_data['taxonomies'][] = array(
					'slug'  => $taxonomy->name,
					'label' => $taxonomy->label,
				);
			}

			if ( 'attachment' === $post_type->name ) {
				foreach ( $this->attachment_metadata->get_fields() as $field => $label ) {
					$post_type_data['extraFields'][] = array(
						'slug'  => 'attachment_show_metadata_' . $field,

						/* translators: %s: field label */
						'label' => sprintf( _x( 'Show %s?', 'attachment metadata', 'super-awesome-theme' ), $label ),
					);
				}
			}

			$data['postTypes'][] = $post_type_data;
		}

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-content-types-customize-controls',
			get_theme_file_uri( '/assets/dist/js/content-types.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeContentTypesControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Registers scripts for the Customizer preview.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_preview_js( $assets ) {
		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-content-types-customize-preview',
			get_theme_file_uri( '/assets/dist/js/content-types.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview', 'customize-selective-refresh' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
			)
		) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'init', array( $this, 'register_settings' ), PHP_INT_MAX, 0 );
		add_filter( 'body_class', array( $this, 'add_content_type_body_classes' ), 10, 1 );
		add_filter( 'post_class', array( $this, 'add_singular_archive_post_classes' ), 10, 3 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_partials' ) );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
