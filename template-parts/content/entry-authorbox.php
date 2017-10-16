<?php
/**
 * Template part for displaying the post author box
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

// TODO: Put some useful content in here.
?>
<div class="entry-authorbox"<?php super_awesome_theme_customize_post_context() ?>>
	<?php if ( super_awesome_theme_display_post_authorbox() ) : ?>
		This post was written by an incredible author.
	<?php endif; ?>
</div>
