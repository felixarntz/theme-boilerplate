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
	 * @param string           $taxonomy Taxonomy slug.
	 * @param WP_Post|int|null $post     Optional. Post to check for. Default is the current post.
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
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_settings':
			case 'register_customize_controls':
				call_user_func_array( array( $this, $method ), $args );
				break;

			case 'add_singular_archive_post_classes':
				if ( empty( $args ) ) {
					return array();
				}
				$classes = $args[0];
				$post_id = $args[2];
				if ( is_singular( get_post_type( $post_id ) ) ) {
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
				$GLOBALS['post'] = $post;
				setup_postdata( $post );
				get_template_part( 'template-parts/content/' . str_replace( '_', '-', substr( $method, 8 ) ), $post->post_type );
				break;
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
			if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
				$boolean_settings[ $post_type->name . '_use_excerpt' ] = false;
			}

			$boolean_settings[ $post_type->name . '_show_date' ] = in_array( $post_type->name, array( 'post', 'attachment' ), true );

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_settings[ $post_type->name . '_show_author' ] = in_array( $post_type->name, array( 'post', 'attachment' ), true );
			}

			if ( 'attachment' === $post_type->name ) {
				foreach ( $this->attachment_metadata->get_fields() as $field => $label ) {
					$boolean_settings[ 'attachment_show_metadata_' . $field ] = true;
				}
			}

			$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
				'public' => true,
			) );
			foreach ( $public_taxonomies as $taxonomy ) {
				$boolean_settings[ $post_type->name . '_show_terms_' . $taxonomy->name ] = true;
			}

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_settings[ $post_type->name . '_show_authorbox' ] = 'post' === $post_type->name && is_multi_author();
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
	protected function register_customize_controls( $customizer ) {
		$customizer->add_panel( 'content_types', array(
			Super_Awesome_Theme_Customize_Panel::PROP_TITLE    => __( 'Content Types', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Panel::PROP_PRIORITY => 140,
		) );

		$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $public_post_types as $post_type ) {
			$boolean_controls = array();

			if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
				$boolean_controls[ $post_type->name . '_use_excerpt' ] = array(
					'label'           => __( 'Use Excerpt in archives?', 'super-awesome-theme' ),
					'selector'        => '.type-' . $post_type->name . '.archive-view .entry-content',
					'render_callback' => array( $this, 'partial_entry_content' ),
				);
			}

			$boolean_controls[ $post_type->name . '_show_date' ] = array(
				'label'           => __( 'Show Date?', 'super-awesome-theme' ),
				'selector'        => '.type-' . $post_type->name . ' .entry-meta',
				'render_callback' => array( $this, 'partial_entry_meta' ),
			);

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_controls[ $post_type->name . '_show_author' ] = array(
					'label'           => __( 'Show Author Name?', 'super-awesome-theme' ),
					'selector'        => '.type-' . $post_type->name . ' .entry-meta',
					'render_callback' => array( $this, 'partial_entry_meta' ),
				);
			}

			if ( 'attachment' === $post_type->name ) {
				foreach ( $this->attachment_metadata->get_fields() as $field => $label ) {
					$boolean_controls[ 'attachment_show_metadata_' . $field ] = array(
						/* translators: %s: metadata field label */
						'label'           => sprintf( _x( 'Show %s?', 'attachment metadata', 'super-awesome-theme' ), $label ),
						'selector'        => '.type-' . $post_type->name . ' .entry-attachment-meta',
						'render_callback' => array( $this, 'partial_entry_attachment_meta' ),
					);
				}
			}

			$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
				'public' => true,
			) );
			foreach ( $public_taxonomies as $taxonomy ) {
				$boolean_controls[ $post_type->name . '_show_terms_' . $taxonomy->name ] = array(
					/* translators: %s: taxonomy plural label */
					'label'           => sprintf( _x( 'Show %s?', 'taxonomy', 'super-awesome-theme' ), $taxonomy->label ),
					'selector'        => '.type-' . $post_type->name . ' .entry-terms',
					'render_callback' => array( $this, 'partial_entry_terms' ),
				);
			}

			if ( post_type_supports( $post_type->name, 'author' ) ) {
				$boolean_controls[ $post_type->name . '_show_authorbox' ] = array(
					'label'           => __( 'Show Author Box?', 'super-awesome-theme' ),
					'selector'        => '.type-' . $post_type->name . ' .entry-authorbox',
					'render_callback' => array( $this, 'partial_entry_authorbox' ),
				);
			}

			$customizer->add_section( 'content_type_' . $post_type->name, array(
				Super_Awesome_Theme_Customize_Section::PROP_PANEL => 'content_types',
				Super_Awesome_Theme_Customize_Section::PROP_TITLE => $post_type->label,
			) );

			foreach ( $boolean_controls as $id => $args ) {
				$customizer->add_control( $id, array(
					Super_Awesome_Theme_Customize_Control::PROP_SECTION => 'content_type_' . $post_type->name,
					Super_Awesome_Theme_Customize_Control::PROP_TITLE   => $args['label'],
					Super_Awesome_Theme_Customize_Control::PROP_TYPE    => Super_Awesome_Theme_Customize_Control::TYPE_CHECKBOX,
				) );

				$customizer->add_partial( $id, array(
					Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => $args['selector'],
					Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => $args['render_callback'],
					Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
					Super_Awesome_Theme_Customize_Partial::PROP_TYPE                => 'SuperAwesomeThemePostPartial',
				) );
			}
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'init', array( $this, 'register_settings' ), PHP_INT_MAX, 0 );
		add_filter( 'post_class', array( $this, 'add_singular_archive_post_classes' ), 10, 3 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_controls' ) );
	}
}
