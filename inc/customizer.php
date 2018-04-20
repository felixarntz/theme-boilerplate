<?php
/**
 * Customizer functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
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

	/* Core Adjustments */

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

	/* Site Identity Settings */

	$wp_customize->add_setting( 'branding_location', array(
		'default'           => 'header',
		'transport'         => 'refresh',
		'validate_callback' => 'super_awesome_theme_customize_validate_branding_location',
	) );
	$wp_customize->add_control( 'branding_location', array(
		'section'     => 'title_tagline',
		'label'       => __( 'Display Location', 'super-awesome-theme' ),
		'description' => __( 'Specify where to display the site logo, title and tagline.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_branding_location_choices(),
	) );

	/* Colors */

	$wp_customize->add_setting( 'text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'section'  => 'colors',
		'label'    => __( 'Text Color', 'super-awesome-theme' ),
		'priority' => 3,
	) ) );

	$wp_customize->get_control( 'background_color' )->priority = 4;

	$wp_customize->add_setting( 'wrap_background_color', array(
		'default'              => '',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrap_background_color', array(
		'section'         => 'colors',
		'label'           => __( 'Wrap Background Color', 'super-awesome-theme' ),
		'priority'        => 4,
		'active_callback' => 'super_awesome_theme_use_wrapped_layout',
	) ) );

	$wp_customize->add_setting( 'link_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'section'  => 'colors',
		'label'    => __( 'Link Color', 'super-awesome-theme' ),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'button_text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_text_color', array(
		'section'  => 'colors',
		'label'    => __( 'Button Text Color', 'super-awesome-theme' ),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'button_background_color', array(
		'default'              => '#e6e6e6',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_background_color', array(
		'section'  => 'colors',
		'label'    => __( 'Button Background Color', 'super-awesome-theme' ),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'button_primary_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_text_color', array(
		'section'  => 'colors',
		'label'    => __( 'Primary Button Text Color', 'super-awesome-theme' ),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'button_primary_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_background_color', array(
		'section'  => 'colors',
		'label'    => __( 'Primary Button Background Color', 'super-awesome-theme' ),
		'priority' => 5,
	) ) );

	$wp_customize->get_control( 'header_textcolor' )->priority = 9;

	$wp_customize->add_setting( 'header_background_color', array(
		'default'              => '',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color', array(
		'section'         => 'colors',
		'label'           => __( 'Header Background Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_needs_header_background',
	) ) );

	$wp_customize->add_setting( 'navbar_text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Navbar Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'navbar_link_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_link_color', array(
		'section' => 'colors',
		'label'   => __( 'Navbar Link Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'navbar_background_color', array(
		'default'              => '#eeeeee',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_background_color', array(
		'section' => 'colors',
		'label'   => __( 'Navbar Background Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'top_bar_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Top Bar Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'top_bar_link_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_link_color', array(
		'section' => 'colors',
		'label'   => __( 'Top Bar Link Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'top_bar_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_background_color', array(
		'section' => 'colors',
		'label'   => __( 'Top Bar Background Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'bottom_bar_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Bottom Bar Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'bottom_bar_link_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_link_color', array(
		'section' => 'colors',
		'label'   => __( 'Bottom Bar Link Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'bottom_bar_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_background_color', array(
		'section' => 'colors',
		'label'   => __( 'Bottom Bar Background Color', 'super-awesome-theme' ),
	) ) );

	/* Header Media */

	$wp_customize->add_setting( 'header_position', array(
		'default'           => 'above_navbar',
		'transport'         => 'refresh',
		'validate_callback' => 'super_awesome_theme_customize_validate_header_position',
	) );
	$wp_customize->add_control( 'header_position', array(
		'section'     => 'header_image',
		'label'       => _x( 'Position', 'custom header', 'super-awesome-theme' ),
		'description' => __( 'Specify where to display the header image or video.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_header_position_choices(),
	) );

	$wp_customize->add_setting( 'header_textalign', array(
		'default'           => 'text-center',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_header_textalign',
	) );
	$wp_customize->add_control( 'header_textalign', array(
		'section' => 'header_image',
		'label'   => _x( 'Text Alignment', 'custom header', 'super-awesome-theme' ),
		'type'    => 'radio',
		'choices' => super_awesome_theme_customize_get_header_textalign_choices(),
	) );

	/* Widget Settings */

	if ( is_admin() ) {
		super_awesome_theme_customize_register_widget_area_settings();
	} else {
		add_action( 'wp', 'super_awesome_theme_customize_register_widget_area_settings' );
	}

	/* Content Type Settings */

	$wp_customize->add_panel( 'content_types', array(
		'title'    => __( 'Content Types', 'super-awesome-theme' ),
		'priority' => 140,
	) );

	$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
	foreach ( $public_post_types as $post_type ) {
		if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
			$wp_customize->add_setting( $post_type->name . '_use_excerpt', array(
				'default'   => '',
				'transport' => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_use_excerpt', array(
				'section' => 'content_type_' . $post_type->name,
				'label'   => __( 'Use Excerpt in archives?', 'super-awesome-theme' ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_use_excerpt', array(
				'selector'            => '.type-' . $post_type->name . '.archive-view .entry-content',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_excerpt',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}

		$wp_customize->add_section( 'content_type_' . $post_type->name, array(
			'panel' => 'content_types',
			'title' => $post_type->label,
		) );

		$wp_customize->add_setting( $post_type->name . '_show_date', array(
			'default'   => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
			'transport' => 'postMessage',
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
				'default'   => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
				'transport' => 'postMessage',
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

		if ( 'attachment' === $post_type->name ) {
			foreach ( super_awesome_theme_get_attachment_metadata_fields() as $field => $label ) {
				$wp_customize->add_setting( 'attachment_show_metadata_' . $field, array(
					'default'   => '1',
					'transport' => 'postMessage',
				) );
				$wp_customize->add_control( 'attachment_show_metadata_' . $field, array(
					'section' => 'content_type_' . $post_type->name,
					/* translators: %s: metadata field label */
					'label'   => sprintf( __( 'Show %s?', 'super-awesome-theme' ), $label ),
					'type'    => 'checkbox',
				) );
				$wp_customize->selective_refresh->add_partial( 'attachment_show_metadata_' . $field, array(
					'selector'            => '.type-' . $post_type->name . ' .entry-attachment-meta',
					'render_callback'     => 'super_awesome_theme_customize_partial_entry_attachment_meta',
					'container_inclusive' => true,
					'type'                => 'SuperAwesomeThemePostPartial',
				) );
			}
		}

		$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
			'public' => true,
		) );
		foreach ( $public_taxonomies as $taxonomy ) {
			$wp_customize->add_setting( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'default'   => '1',
				'transport' => 'postMessage',
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
				'default'   => 'post' === $post_type->name ? '1' : '',
				'transport' => 'postMessage',
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

	/* Customizer-generated CSS */

	$wp_customize->selective_refresh->add_partial( 'super_awesome_theme_customizer_styles', array(
		'settings'            => array(
			'header_textcolor',
			'header_background_color',
			'text_color',
			'link_color',
			'wrap_background_color',
			'button_text_color',
			'button_background_color',
			'button_primary_text_color',
			'button_primary_background_color',
			'navbar_text_color',
			'navbar_link_color',
			'navbar_background_color',
			'top_bar_text_color',
			'top_bar_link_color',
			'top_bar_background_color',
			'bottom_bar_text_color',
			'bottom_bar_link_color',
			'bottom_bar_background_color',
		),
		'selector'            => '#super-awesome-theme-customizer-styles',
		'render_callback'     => 'super_awesome_theme_customize_partial_styles',
		'container_inclusive' => false,
		'fallback_refresh'    => false,
	) );
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Registers additional Customizer functionality for widget areas.
 *
 * @since 1.0.0
 *
 * @global WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register_widget_area_settings() {
	global $wp_customize;

	$wp_customize->add_section( 'widget_areas', array(
		'panel'    => 'widgets',
		'title'    => __( 'Widget Area Settings', 'super-awesome-theme' ),
		'priority' => -1,
	) );

	$wp_customize->add_setting( 'sidebar_mode', array(
		'default'           => 'right-sidebar',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_mode',
	) );
	$wp_customize->add_control( 'sidebar_mode', array(
		'section'         => 'widget_areas',
		'label'           => __( 'Sidebar Mode', 'super-awesome-theme' ),
		'description'     => __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
		'type'            => 'radio',
		'choices'         => super_awesome_theme_customize_get_sidebar_mode_choices(),
		'active_callback' => 'super_awesome_theme_allow_display_sidebar',
	) );

	$wp_customize->add_setting( 'sidebar_size', array(
		'default'           => 'medium',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_size',
	) );
	$wp_customize->add_control( 'sidebar_size', array(
		'section'         => 'widget_areas',
		'label'           => __( 'Sidebar Size', 'super-awesome-theme' ),
		'description'     => __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
		'type'            => 'radio',
		'choices'         => super_awesome_theme_customize_get_sidebar_size_choices(),
		'active_callback' => 'super_awesome_theme_allow_display_sidebar',
	) );

	$wp_customize->add_setting( 'blog_sidebar_enabled', array(
		'default'   => '',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control( 'blog_sidebar_enabled', array(
		'section'         => 'widget_areas',
		'label'           => __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
		'description'     => __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
		'type'            => 'checkbox',
		'active_callback' => 'super_awesome_theme_allow_display_blog_sidebar',
	) );
	$wp_customize->selective_refresh->add_partial( 'blog_sidebar_enabled', array(
		'selector'            => '#sidebar',
		'render_callback'     => 'get_sidebar',
		'container_inclusive' => true,
	) );

	$wp_customize->add_setting( 'top_bar_justify_content', array(
		'default'           => 'space-between',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_bar_justify_content',
	) );
	$wp_customize->add_control( 'top_bar_justify_content', array(
		'section'     => 'widget_areas',
		'label'       => __( 'Top Bar Justify Content', 'super-awesome-theme' ),
		'description' => __( 'Specify how the widgets in the top bar are aligned.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_bar_justify_content_choices(),
	) );

	$wp_customize->add_setting( 'bottom_bar_justify_content', array(
		'default'           => 'space-between',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_bar_justify_content',
	) );
	$wp_customize->add_control( 'bottom_bar_justify_content', array(
		'section'     => 'widget_areas',
		'label'       => __( 'Bottom Bar Justify Content', 'super-awesome-theme' ),
		'description' => __( 'Specify how the widgets in the bottom bar are aligned.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_bar_justify_content_choices(),
	) );

	$footer_widget_area_count   = super_awesome_theme_get_footer_widget_area_count();
	$footer_widget_area_choices = array( _x( 'None', 'widget area dropdown', 'super-awesome-theme' ) );
	for ( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
		/* translators: %s: widget area number */
		$footer_widget_area_choices[] = sprintf( __( 'Footer %s', 'super-awesome-theme' ), number_format_i18n( $i ) );
	}
	$wp_customize->add_setting( 'wide_footer_widget_area', array(
		'default'              => 0,
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'wide_footer_widget_area', array(
		'section'     => 'widget_areas',
		'label'       => __( 'Wide Footer Column', 'super-awesome-theme' ),
		'description' => __( 'If you like to reserve more space for one of your footer widget columns, you can select that one here.', 'super-awesome-theme' ),
		'type'        => 'select',
		'choices'     => $footer_widget_area_choices,
	) );
}

/**
 * Prints styles generated through the Customizer.
 *
 * @since 1.0.0
 */
function super_awesome_theme_print_customizer_styles() {
	$text_color                            = get_theme_mod( 'text_color', '#404040' );
	$text_focus_color                      = super_awesome_theme_darken_color( $text_color, 25 );
	$text_light_color                      = super_awesome_theme_lighten_color( $text_color, 100 );
	$link_color                            = get_theme_mod( 'link_color', '#21759b' );
	$link_focus_color                      = super_awesome_theme_darken_color( $link_color, 25 );
	$header_text_color                     = get_header_textcolor();
	$header_text_focus_color               = 'blank' !== $header_text_color ? super_awesome_theme_darken_color( $header_text_color, 25 ) : '';
	$header_background_color               = get_theme_mod( 'header_background_color', '' );
	$wrap_background_color                 = get_theme_mod( 'wrap_background_color', '' );
	$button_text_color                     = get_theme_mod( 'button_text_color', '#404040' );
	$button_background_color               = get_theme_mod( 'button_background_color', '#e6e6e6' );
	$button_background_focus_color         = super_awesome_theme_darken_color( $button_background_color, 25 );
	$button_primary_text_color             = get_theme_mod( 'button_primary_text_color', '#ffffff' );
	$button_primary_background_color       = get_theme_mod( 'button_primary_background_color', '#21759b' );
	$button_primary_background_focus_color = super_awesome_theme_darken_color( $button_primary_background_color, 25 );
	$navbar_text_color                     = get_theme_mod( 'navbar_text_color', '#404040' );
	$navbar_link_color                     = get_theme_mod( 'navbar_link_color', '#21759b' );
	$navbar_link_focus_color               = super_awesome_theme_darken_color( $navbar_link_color, 25 );
	$navbar_background_color               = get_theme_mod( 'navbar_background_color', '#eeeeee' );
	$top_bar_text_color                    = get_theme_mod( 'top_bar_text_color', '#ffffff' );
	$top_bar_link_color                    = get_theme_mod( 'top_bar_link_color', '#ffffff' );
	$top_bar_link_focus_color              = super_awesome_theme_darken_color( $top_bar_link_color, 25 );
	$top_bar_background_color              = get_theme_mod( 'top_bar_background_color', '#21759b' );
	$bottom_bar_text_color                 = get_theme_mod( 'bottom_bar_text_color', '#ffffff' );
	$bottom_bar_link_color                 = get_theme_mod( 'bottom_bar_link_color', '#ffffff' );
	$bottom_bar_link_focus_color           = super_awesome_theme_darken_color( $bottom_bar_link_color, 25 );
	$bottom_bar_background_color           = get_theme_mod( 'bottom_bar_background_color', '#21759b' );

	?>
	<style id="super-awesome-theme-customizer-styles" type="text/css">
		<?php if ( ! empty( $text_color ) && ! empty( $text_focus_color ) && ! empty( $text_light_color ) ) : ?>
			body,
			button,
			input,
			select,
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"],
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			input[type="number"],
			input[type="tel"],
			input[type="range"],
			input[type="date"],
			input[type="month"],
			input[type="week"],
			input[type="time"],
			input[type="datetime"],
			input[type="datetime-local"],
			input[type="color"],
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"]:focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			input[type="number"]:focus,
			input[type="tel"]:focus,
			input[type="range"]:focus,
			input[type="date"]:focus,
			input[type="month"]:focus,
			input[type="week"]:focus,
			input[type="time"]:focus,
			input[type="datetime"]:focus,
			input[type="datetime-local"]:focus,
			input[type="color"]:focus,
			textarea:focus {
				color: <?php echo esc_attr( $text_focus_color ); ?>;
			}

			::-webkit-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			::-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-ms-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			abbr,
			acronym {
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			hr,
			.wp-block-separator {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			tr {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			blockquote {
				color: <?php echo esc_attr( $text_color ); ?>;
				border-left-color: <?php echo esc_attr( $text_color ); ?>;
			}

			.wp-block-pullquote {
				border-top-color: <?php echo esc_attr( $text_color ); ?>;
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			blockquote cite,
			blockquote footer,
			.wp-block-quote cite,
			.wp-block-quote footer,
			.wp-block-pullquote cite,
			.wp-block-pullquote footer {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $link_color ) && ! empty( $link_focus_color ) ) : ?>
			a,
			a:visited {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			a:hover,
			a:focus,
			a:active {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}

			button.button-link,
			input[type="button"].button-link,
			input[type="reset"].button-link,
			input[type="submit"].button-link,
			.button.button-link {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			button.button-link:hover,
			button.button-link:focus,
			input[type="button"].button-link:hover,
			input[type="button"].button-link:focus,
			input[type="reset"].button-link:hover,
			input[type="reset"].button-link:focus,
			input[type="submit"].button-link:hover,
			input[type="submit"].button-link:focus,
			.button.button-link:hover,
			.button.button-link:focus {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $header_text_color ) && ! empty( $header_text_focus_color ) ) : ?>
			.site-custom-header {
				color: <?php echo esc_attr( $header_text_color ); ?>;
			}

			.site-custom-header a,
			.site-custom-header a:visited {
				color: <?php echo esc_attr( $header_text_color ); ?>;
			}

			.site-custom-header a:hover,
			.site-custom-header a:focus,
			.site-custom-header a:active {
				color: <?php echo esc_attr( $header_text_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $header_background_color ) ) : ?>
			.site-custom-header {
				background-color: <?php echo esc_attr( $header_background_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( super_awesome_theme_use_wrapped_layout() && ! empty( $wrap_background_color ) ) : ?>
			.site {
				background-color: <?php echo esc_attr( $wrap_background_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $button_text_color ) && ! empty( $button_background_color ) && ! empty( $button_background_focus_color ) ) : ?>
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			.button {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			button:hover,
			button:focus,
			input[type="button"]:hover,
			input[type="button"]:focus,
			input[type="reset"]:hover,
			input[type="reset"]:focus,
			input[type="submit"]:hover,
			input[type="submit"]:focus,
			.button:hover,
			.button:focus {
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}

			.wp-block-button .wp-block-button__link {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			.wp-block-button .wp-block-button__link:hover,
			.wp-block-button .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $button_primary_text_color ) && ! empty( $button_primary_background_color ) && ! empty( $button_primary_background_focus_color ) ) : ?>
			button.button-primary,
			input[type="button"].button-primary,
			input[type="reset"].button-primary,
			input[type="submit"].button-primary,
			.button.button-primary {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			button.button-primary:hover,
			button.button-primary:focus,
			input[type="button"].button-primary:hover,
			input[type="button"].button-primary:focus,
			input[type="reset"].button-primary:hover,
			input[type="reset"].button-primary:focus,
			input[type="submit"].button-primary:hover,
			input[type="submit"].button-primary:focus,
			.button.button-primary:hover,
			.button.button-primary:focus {
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link:hover,
			.wp-block-button.button-primary .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $navbar_text_color ) && ! empty( $navbar_background_color ) ) : ?>
			.site-navbar {
				color: <?php echo esc_attr( $navbar_text_color ); ?>;
				background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
			}

			.js .site-navbar .site-navigation .site-navigation-content {
				background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
			}

			<?php if ( ! empty( $navbar_link_color ) && ! empty( $navbar_link_focus_color ) ) : ?>
				.site-navbar a,
				.site-navbar a:visited {
					color: <?php echo esc_attr( $navbar_link_color ); ?>;
				}

				.site-navbar a:hover,
				.site-navbar a:focus,
				.site-navbar a:active {
					color: <?php echo esc_attr( $navbar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ! empty( $top_bar_text_color ) && ! empty( $top_bar_background_color ) ) : ?>
			.site-top-bar {
				color: <?php echo esc_attr( $top_bar_text_color ); ?>;
				background-color: <?php echo esc_attr( $top_bar_background_color ); ?>;
			}

			<?php if ( ! empty( $top_bar_link_color ) && ! empty( $top_bar_link_focus_color ) ) : ?>
				.site-top-bar a,
				.site-top-bar a:visited {
					color: <?php echo esc_attr( $top_bar_link_color ); ?>;
				}

				.site-top-bar a:hover,
				.site-top-bar a:focus,
				.site-top-bar a:active {
					color: <?php echo esc_attr( $top_bar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ! empty( $bottom_bar_text_color ) && ! empty( $bottom_bar_background_color ) ) : ?>
			.site-bottom-bar {
				color: <?php echo esc_attr( $bottom_bar_text_color ); ?>;
				background-color: <?php echo esc_attr( $bottom_bar_background_color ); ?>;
			}

			<?php if ( ! empty( $bottom_bar_link_color ) && ! empty( $bottom_bar_link_focus_color ) ) : ?>
				.site-bottom-bar a,
				.site-bottom-bar a:visited {
					color: <?php echo esc_attr( $bottom_bar_link_color ); ?>;
				}

				.site-bottom-bar a:hover,
				.site-bottom-bar a:focus,
				.site-bottom-bar a:active {
					color: <?php echo esc_attr( $bottom_bar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'super_awesome_theme_print_customizer_styles' );

/**
 * Renders the Customizer styles for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_styles() {
	ob_start();
	super_awesome_theme_print_customizer_styles();
	$output = ob_get_clean();

	echo preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $output ); // WPCS: XSS OK.
}

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
 * Checks whether the header background color control is needed.
 *
 * It isn't necessary when either a header image or header video is set.
 *
 * @since 1.0.0
 *
 * @return bool True if header background control should be active, false otherwise.
 */
function super_awesome_theme_needs_header_background() {
	return ! has_header_image() && ! has_header_video();
}

/**
 * Validates the 'branding_location' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_branding_location( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_branding_location_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'branding_location' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_branding_location_choices() {
	return array(
		'header'       => __( 'In front of the header image', 'super-awesome-theme' ),
		'navbar_left'  => __( 'On the left inside the navigation bar', 'super-awesome-theme' ),
		'navbar_right' => __( 'On the right inside the navigation bar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'header_position' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_header_position( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_header_position_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'header_position' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_header_position_choices() {
	return array(
		'above_navbar' => __( 'Above the navigation bar', 'super-awesome-theme' ),
		'below_navbar' => __( 'Below the navigation bar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'header_textalign' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_header_textalign( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_header_textalign_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'header_textalign' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_header_textalign_choices() {
	return array(
		'text-left'   => _x( 'Left', 'alignment', 'super-awesome-theme' ),
		'text-center' => _x( 'Center', 'alignment', 'super-awesome-theme' ),
		'text-right'  => _x( 'Right', 'alignment', 'super-awesome-theme' ),
	);
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
 * Validates the 'top_bar_justify_content' and 'bottom_bar_justify_content' customizer settings.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_bar_justify_content( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_bar_justify_content_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'top_bar_justify_content' and 'bottom_bar_justify_content' customizer settings.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_bar_justify_content_choices() {
	return array(
		'space-between' => _x( 'Space Between', 'alignment', 'super-awesome-theme' ),
		'centered'      => _x( 'Centered', 'alignment', 'super-awesome-theme' ),
	);
}

/**
 * Renders the excerpt for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry metadata.
 */
function super_awesome_theme_customize_partial_entry_excerpt( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-content', $post_type );
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
 * Renders the entry attachment metadata for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry metadata.
 */
function super_awesome_theme_customize_partial_entry_attachment_meta( $partial, $context ) {
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-attachment-meta' );
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
		'inlineSidebars' => super_awesome_theme_get_inline_sidebars(),
		'inlineWidgets'  => super_awesome_theme_get_inline_widgets(),
		'i18n'           => array(
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
		'headerTextalignChoices'   => super_awesome_theme_customize_get_header_textalign_choices(),
		'sidebarModeChoices'       => super_awesome_theme_customize_get_sidebar_mode_choices(),
		'sidebarSizeChoices'       => super_awesome_theme_customize_get_sidebar_size_choices(),
		'barJustifyContentChoices' => super_awesome_theme_customize_get_bar_justify_content_choices(),
	) );
}
add_action( 'customize_preview_init', 'super_awesome_theme_customize_preview_js' );
