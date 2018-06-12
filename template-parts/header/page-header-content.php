<?php
/**
 * The template for displaying page header content
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

switch ( true ) {
	case is_404():
		?>
		<h1><?php esc_html_e( 'Not Found', 'super-awesome-theme' ); ?></h1>
		<?php
		break;

	case is_search():
		?>
		<h1>
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'super-awesome-theme' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
		<?php
		break;

	case is_front_page():
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$title = get_the_title( get_option( 'page_on_front' ) );
			if ( ! empty( $title ) ) {
				?>
				<h1><?php echo $title; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></h1>
				<?php
			}
		}
		break;

	case is_home():
		$title = get_the_title( get_option( 'page_for_posts' ) );
		if ( ! empty( $title ) ) {
			?>
			<h1><?php echo $title; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></h1>
			<?php
		}
		break;

	case is_archive():
		the_archive_title( '<h1>', '</h1>' );
		the_archive_description( '<div>', '</div>' );
		break;

	case ! have_posts():
		?>
		<h1><?php esc_html_e( 'Nothing Found', 'super-awesome-theme' ); ?></h1>
		<?php
		break;

	case is_singular():
		get_template_part( 'template-parts/content/entry-title', get_post_type() );
		get_template_part( 'template-parts/content/entry-meta', get_post_type() );
		break;
}
