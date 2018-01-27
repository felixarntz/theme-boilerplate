<?php
/**
 * The template for displaying search forms
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$unique_id = esc_attr( uniqid( 'search-form-' ) );

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'super-awesome-theme' ); ?></span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'super-awesome-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo super_awesome_theme_get_svg( 'search' ); ?><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'super-awesome-theme' ); ?></span></button>
</form>
