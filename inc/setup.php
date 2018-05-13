<?php
/**
 * Theme setup
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various WordPress features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	/**
	 * Filters the arguments for registering custom logo support.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Custom logo arguments.
	 */
	add_theme_support( 'custom-logo', apply_filters( 'super_awesome_theme_custom_logo_args', array(
		'height'      => 150,
		'width'       => 250,
		'flex-width'  => true,
	) ) );

	$custom_header_width  = super_awesome_theme_use_wrapped_layout() ? 1152 : 2560;
	$custom_header_height = super_awesome_theme_use_wrapped_layout() ? 460 : 1024;

	/**
	 * Filters the arguments for registering custom header support.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Custom header arguments.
	 */
	add_theme_support( 'custom-header', apply_filters( 'super_awesome_theme_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '404040',
		'width'                  => $custom_header_width,
		'height'                 => $custom_header_height,
		'flex-height'            => true,
		'wp-head-callback'       => 'super_awesome_theme_header_style',
		'video'                  => true,
	) ) );

	/**
	 * Filters the arguments for registering custom background support.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Custom background arguments.
	 */
	add_theme_support( 'custom-background', apply_filters( 'super_awesome_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// TODO: Add theme support for starter content.

	add_image_size( 'site-width', 1152, 9999 ); // Spans the site maximum width of 72rem, with unlimited height.
	add_image_size( 'content-width', 640, 9999 ); // Spans the content maximum width of 40rem, with unlimited height.

	set_post_thumbnail_size( 640, 360, true ); // 640px is 40rem, which is the site maximum width. 360px makes it 16:9 format.

	add_editor_style();
}
add_action( 'after_setup_theme', 'super_awesome_theme_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 *
 * @global int $content_width
 */
function super_awesome_theme_content_width() {
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
add_action( 'after_setup_theme', 'super_awesome_theme_content_width', 0 );

/**
 * Registers the theme's widget areas.
 *
 * @since 1.0.0
 */
function super_awesome_theme_register_widget_areas() {
	register_sidebar( array(
		'name'          => __( 'Top Bar', 'super-awesome-theme' ),
		'id'            => 'top',
		'description'   => __( 'Add widgets here to appear in a narrow bar at the very top of the screen.', 'super-awesome-theme' ),
		'before_widget' => '<div id="%1$s" class="inline-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="inline-widget-title">',
		'after_title'   => '</span>',
	) );

	register_sidebar( array(
		'name'          => __( 'Bottom Bar', 'super-awesome-theme' ),
		'id'            => 'bottom',
		'description'   => __( 'Add widgets here to appear in a narrow bar at the very bottom of the screen.', 'super-awesome-theme' ),
		'before_widget' => '<div id="%1$s" class="inline-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="inline-widget-title">',
		'after_title'   => '</span>',
	) );

	super_awesome_theme()->get_component( 'widgets' )->add_inline_widget_areas( array( 'top', 'bottom' ) );
}
add_action( 'widgets_init', 'super_awesome_theme_register_widget_areas' );

/**
 * Styles the header image and text.
 *
 * Header text color is handled manually with the other Customizer colors.
 *
 * @since 1.0.0
 */
function super_awesome_theme_header_style() {
	if ( display_header_text() ) {
		return;
	}

	?>
	<style type="text/css">
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	</style>
	<?php
}
