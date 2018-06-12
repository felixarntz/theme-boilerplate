<?php
/**
 * The template for displaying the custom header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$header_textalign  = super_awesome_theme_get_setting( 'header_textalign' );
$branding_location = super_awesome_theme_get_setting( 'branding_location' );

$image_id = 0;
if ( super_awesome_theme_use_page_header() ) {
	if ( is_singular() ) {
		$support_slug = get_post_type();
		if ( 'attachment' === $support_slug ) {
			if ( wp_attachment_is( 'audio' ) ) {
				$support_slug .= ':audio';
			} elseif ( wp_attachment_is( 'video' ) ) {
				$support_slug .= ':video';
			}
		}

		if ( post_type_supports( $support_slug, 'thumbnail' ) && has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
		}
	} elseif ( is_home() && 'page' === get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) {
		$posts_page = get_option( 'page_for_posts' );
		if ( has_post_thumbnail( $posts_page ) ) {
			$image_id = get_post_thumbnail_id( $posts_page );
		}
	}

	/**
	 * Filters the page header image ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int Page header image ID. May be 0.
	 */
	$image_id = apply_filters( 'super_awesome_theme_get_page_header_image_id', $image_id );
}

?>
<div class="site-custom-header site-component <?php echo esc_attr( $header_textalign ); ?>">
	<div class="site-header-media">
		<?php
		if ( $image_id ) {
			?>
			<div class="site-page-header-image">
				<?php echo wp_get_attachment_image( $image_id, 'full-width', false, array( 'class' => '' ) ); ?>
			</div>
			<?php
		} else {
			the_custom_header_markup();
		}
		?>
	</div>
	<div class="site-component-inner">
		<?php
		if ( super_awesome_theme_use_page_header() ) {
			?>
			<div class="site-page-header-content">
				<?php get_template_part( 'template-parts/header/page-header-content' ); ?>
			</div>
			<?php
		} elseif ( 'header' === $branding_location ) {
			?>
			<div class="site-branding">
				<?php get_template_part( 'template-parts/header/logo-and-title' ); ?>
			</div>
			<?php
		}
		?>
	</div>
</div><!-- .site-custom-header -->
