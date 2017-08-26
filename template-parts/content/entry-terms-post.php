<?php
/**
 * Template part for displaying post taxonomy terms
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

$separator = _x( ', ', 'list item separator', 'super-awesome-theme' );

$terms = array(
	array(
		'slug'             => 'category',
		'class'            => 'category-links term-links',
		/* translators: %s: list of terms */
		'placeholder_text' => __( 'Posted in %s', 'super-awesome-theme' ),
		'list'             => get_the_category_list( esc_html( $separator ), '', $post->ID ),
	),
	array(
		'slug'             => 'post_tag',
		'class'            => 'tag-links term-links',
		/* translators: %s: list of terms */
		'placeholder_text' => __( 'Tagged %s', 'super-awesome-theme' ),
		'list'             => get_the_tag_list( '', esc_html( $separator ), '', $post->ID ),
	),
);

?>
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
