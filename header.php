<?php
/**
 * The template for displaying the header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'super-awesome-theme' ); ?></a>

<div id="page" class="site">

	<?php get_template_part( 'template-parts/header/site-top-bar' ); ?>

	<header id="header" class="site-header">
		<?php

		/**
		 * Fires before the theme's header is printed.
		 *
		 * @since 1.0.0
		 */
		do_action( 'super_awesome_theme_before_header' );
		?>

		<?php get_template_part( 'template-parts/header/site-custom-header' ); ?>

		<?php

		/**
		 * Fires after the theme's header has been printed.
		 *
		 * @since 1.0.0
		 */
		do_action( 'super_awesome_theme_after_header' );
		?>
	</header><!-- #header -->

	<?php get_template_part( 'template-parts/header/site-navbar' ); ?>

	<div id="content" class="site-content site-component is-flex">
		<div class="site-component-inner">
