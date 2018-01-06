<?php
/**
 * Customizer functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers Customizer functionality.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'super_awesome_theme_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'super_awesome_theme_customize_partial_blogdescription',
	) );

	/* Sidebar Settings */

	$wp_customize->add_section( 'sidebars', array(
		'title'           => __( 'Sidebars', 'super-awesome-theme' ),
		'priority'        => 105,
		'active_callback' => 'super_awesome_theme_allow_display_sidebar',
	) );

	$wp_customize->add_setting( 'sidebar_mode', array(
		'default'           => 'right-sidebar',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_mode',
	) );
	$wp_customize->add_control( 'sidebar_mode', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Mode', 'super-awesome-theme' ),
		'description' => __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_mode_choices(),
	) );

	$wp_customize->add_setting( 'sidebar_size', array(
		'default'           => 'medium',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_size',
	) );
	$wp_customize->add_control( 'sidebar_size', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Size', 'super-awesome-theme' ),
		'description' => __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );

	$wp_customize->add_setting( 'blog_sidebar_enabled', array(
		'default'           => '',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'blog_sidebar_enabled', array(
		'section'         => 'sidebars',
		'label'           => __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
		'description'     => __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
		'type'            => 'checkbox',
		'active_callback' => 'super_awesome_theme_allow_display_blog_sidebar',
	) );
	$wp_customize->selective_refresh->add_partial( 'blog_sidebar_enabled', array(
		'selector'            => '#sidebar',
		'render_callback'     => 'super_awesome_theme_customize_partial_blog_sidebar_enabled',
		'container_inclusive' => true,
	) );

	/* Content Type Settings */

	$wp_customize->add_panel( 'content_types', array(
		'title'    => __( 'Content Types', 'super-awesome-theme' ),
		'priority' => 140,
	) );

	$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
	foreach ( $public_post_types as $post_type ) {
		$wp_customize->add_section( 'content_type_' . $post_type->name, array(
			'panel'    => 'content_types',
			'title'    => $post_type->label,
		) );

		$wp_customize->add_setting( $post_type->name . '_show_date', array(
			'default'           => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $post_type->name . '_show_date', array(
			'section' => 'content_type_' . $post_type->name,
			'label'   => __( 'Show Date?', 'super-awesome-theme' ),
			'type'    => 'checkbox',
		) );
		$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_date', array(
			'selector'            => '.type-' . $post_type->name . ' .entry-meta',
			'render_callback'     => 'super_awesome_theme_customize_partial_entry_meta',
			'container_inclusive' => true,
			'type'                => 'SuperAwesomeThemePostPartial',
		) );

		if ( post_type_supports( $post_type->name, 'author' ) ) {
			$wp_customize->add_setting( $post_type->name . '_show_author', array(
				'default'           => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_author', array(
				'section' => 'content_type_' . $post_type->name,
				'label'   => __( 'Show Author Name?', 'super-awesome-theme' ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_author', array(
				'selector'            => '.type-' . $post_type->name . ' .entry-meta',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_meta',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}

		$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
			'public' => true,
		) );
		foreach ( $public_taxonomies as $taxonomy ) {
			$wp_customize->add_setting( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'default'           => '1',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'section' => 'content_type_' . $post_type->name,
				/* translators: %s: taxonomy plural label */
				'label'   => sprintf( _x( 'Show %s?', 'taxonomy', 'super-awesome-theme' ), $taxonomy->label ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'selector'            => '.type-' . $post_type->name . ' .entry-terms',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_terms',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}

		if ( post_type_supports( $post_type->name, 'author' ) ) {
			$wp_customize->add_setting( $post_type->name . '_show_authorbox', array(
				'default'           => 'post' === $post_type->name ? '1' : '',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_authorbox', array(
				'section' => 'content_type_' . $post_type->name,
				'label'   => __( 'Show Author Box?', 'super-awesome-theme' ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_authorbox', array(
				'selector'            => '.type-' . $post_type->name . ' .entry-authorbox',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_authorbox',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}
	}
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Renders the site title for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Renders the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Validates the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_mode( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_mode_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_mode_choices() {
	return array(
		'no-sidebar'    => __( 'No Sidebar', 'super-awesome-theme' ),
		'left-sidebar'  => __( 'Left Sidebar', 'super-awesome-theme' ),
		'right-sidebar' => __( 'Right Sidebar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_size( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_size_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_size_choices() {
	return array(
		'small'  => __( 'Small', 'super-awesome-theme' ),
		'medium' => __( 'Medium', 'super-awesome-theme' ),
		'large'  => __( 'Large', 'super-awesome-theme' ),
	);
}

/**
 * Renders the primary or blog sidebar for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blog_sidebar_enabled() {
	get_sidebar();
}

/**
 * Renders the entry metadata for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry metadata.
 */
function super_awesome_theme_customize_partial_entry_meta( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-meta', $post_type );
}

/**
 * Renders the entry terms for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry terms.
 */
function super_awesome_theme_customize_partial_entry_terms( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-terms', $post_type );
}

/**
 * Renders the entry author box for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry author box.
 */
function super_awesome_theme_customize_partial_entry_authorbox( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-authorbox', $post_type );
}

/**
 * Enqueues the script for the Customizer controls.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_controls_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-controls', get_theme_file_uri( '/assets/dist/js/customize-controls' . $min . '.js' ), array( 'customize-controls' ), SUPER_AWESOME_THEME_VERSION, true );
	wp_localize_script( 'super-awesome-theme-customize-controls', 'themeCustomizeData', array(
		'i18n' => array(
			'blogSidebarEnabledNotice' => __( 'This page doesn&#8217;t support the blog sidebar. Navigate to the blog page or another page that supports it.', 'super-awesome-theme' ),
		),
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'super_awesome_theme_customize_controls_js' );

/**
 * Enqueues the script for the Customizer preview.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_preview_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-preview', get_theme_file_uri( '/assets/dist/js/customize-preview' . $min . '.js' ), array( 'customize-preview', 'customize-selective-refresh' ), SUPER_AWESOME_THEME_VERSION, true );
	wp_localize_script( 'super-awesome-theme-customize-preview', 'themeCustomizeData', array(
		'sidebarModeChoices' => super_awesome_theme_customize_get_sidebar_mode_choices(),
		'sidebarSizeChoices' => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );
}
add_action( 'customize_preview_init', 'super_awesome_theme_customize_preview_js' );
