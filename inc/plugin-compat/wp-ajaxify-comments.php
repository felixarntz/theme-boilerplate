<?php
/**
 * WP Ajaxify Comments compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

function super_awesome_theme_ajaxify_comments_warning() {
	// TODO.
}
add_action( 'admin_notices', 'super_awesome_theme_ajaxify_comments_warning' );
