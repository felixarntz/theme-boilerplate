<?php
/**
 * Template part for displaying post taxonomy terms
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

$taxonomies = wp_list_filter( get_object_taxonomies( $post, 'objects' ), array(
	'public' => true,
) );

$terms = array();
foreach ( $taxonomies as $taxonomy ) {
	if ( ! super_awesome_theme_display_post_taxonomy_terms( $taxonomy->name ) ) {
		continue;
	}

	if ( 'post_tag' === $taxonomy->name ) {
		$class = 'tag-links term-links';
	} else {
		$class = str_replace( '_', '-', $taxonomy->name ) . ' term-links';
	}

	if ( $taxonomy->hierarchical ) {
		/* translators: %s: list of terms */
		$placeholder_text = __( 'Posted in %s', 'super-awesome-theme' );
	} else {
		/* translators: %s: list of terms */
		$placeholder_text = __( 'Tagged %s', 'super-awesome-theme' );
	}

	$separator = _x( ', ', 'list item separator', 'super-awesome-theme' );

	if ( 'category' === $taxonomy->name ) {
		$term_list = get_the_category_list( esc_html( $separator ), '', $post->ID );
	} elseif ( 'post_tag' === $taxonomy->name ) {
		$term_list = get_the_tag_list( '', esc_html( $separator ), '', $post->ID );
	} else {
		$term_list = get_the_term_list( $post->ID, $taxonomy->name, '', esc_html( $separator ), '' );
	}

	if ( empty( $term_list ) ) {
		continue;
	}

	$terms[] = array(
		'slug'             => $taxonomy->name,
		'class'            => $class,
		'placeholder_text' => $placeholder_text,
		'list'             => $term_list,
	);
}

?>
<div class="entry-terms">
	<?php foreach ( $terms as $taxonomy_terms ) : ?>
		<span class="<?php echo esc_attr( $taxonomy_terms['class'] ); ?>">
			<?php
			printf(
				esc_html( $taxonomy_terms['placeholder_text'] ),
				$taxonomy_terms['list'] // WPCS: XSS OK.
			);
			?>
		</span>
	<?php endforeach; ?>
</div>
