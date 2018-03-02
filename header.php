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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'super-awesome-theme' ); ?></a>

<div id="page" class="site">
	<header id="header" class="site-header">
		<?php get_template_part( 'template-parts/header/site-branding' ); ?>

		<?php get_template_part( 'template-parts/header/site-navigation' ); ?>
	</header><!-- #header -->

	<div id="content" class="site-content">
