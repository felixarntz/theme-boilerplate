<?php
/**
 * Theme setup
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
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
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) ) );

	/**
	 * Filters the arguments for registering custom header support.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Custom header arguments.
	 */
	add_theme_support( 'custom-header', apply_filters( 'super_awesome_theme_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'super_awesome_theme_header_style',
	) ) );

	// TODO: Include video header support.

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

	// TODO: Add image sizes.

	// TODO: Add editor style.
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
	$content_width = apply_filters( 'super_awesome_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'super_awesome_theme_content_width', 0 );

/**
 * Registers the theme's nav menus.
 *
 * @since 1.0.0
 */
function super_awesome_theme_register_nav_menus() {
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'super-awesome-theme' ),
	) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_register_nav_menus', 11 );

/**
 * Registers the theme's widget areas.
 *
 * @since 1.0.0
 */
function super_awesome_theme_register_widget_areas() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'super-awesome-theme' ),
		'id'            => 'primary',
		'description'   => esc_html__( 'The primary sidebar will be displayed on the side of your main content.', 'super-awesome-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'super-awesome-theme' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'If enabled, the blog sidebar will be displayed on the side of your blog content.', 'super-awesome-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'super_awesome_theme_register_widget_areas' );

/**
 * Styles the header image and text.
 *
 * @since 1.0.0
 */
function super_awesome_theme_header_style() {
	$header_text_color = get_header_textcolor();

	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	?>
	<style type="text/css">
	<?php if ( ! display_header_text() ) : ?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php else : ?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
