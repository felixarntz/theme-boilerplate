<?php
/**
 * Template part for displaying a post header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( is_singular( get_post_type() ) && (int) get_the_ID() === (int) get_queried_object_id() && super_awesome_theme_use_page_header() ) {
	return;
}

$support_slug = get_post_type();
if ( 'attachment' === $support_slug ) {
	if ( wp_attachment_is( 'audio' ) ) {
		$support_slug .= ':audio';
	} elseif ( wp_attachment_is( 'video' ) ) {
		$support_slug .= ':video';
	}
}

?>
<header class="entry-header">

	<?php
	get_template_part( 'template-parts/content/entry-title', get_post_type() );
	get_template_part( 'template-parts/content/entry-meta', get_post_type() );

	if ( post_type_supports( $support_slug, 'thumbnail' ) && has_post_thumbnail() ) {
		?>
		<div class="wp-post-image-wrap">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php
	}
	?>

</header><!-- .entry-header -->
