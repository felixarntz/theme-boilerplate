<?php
/**
 * The template for displaying search forms
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$unique_id = uniqid( 'search-form-' );

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'super-awesome-theme' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'super-awesome-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit">
		<?php echo super_awesome_theme_get_svg( 'search' ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'super-awesome-theme' ); ?></span>
	</button>
</form>
