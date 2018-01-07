<?php
/**
 * Template part for displaying attachment metadata
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$metadata = super_awesome_theme_get_attachment_metadata();

?>
<ul class="entry-attachment-meta">
	<?php foreach ( super_awesome_theme_get_attachment_metadata_fields() as $field => $label ) : ?>
		<?php if ( super_awesome_theme_display_attachment_metadata( $field ) ) : ?>
			<li class="<?php echo esc_attr( 'attachment-metadata-' . str_replace( '_', '-', $field ) ); ?>">
				<?php
				$output = $label . ': ';
				if ( ! empty( $metadata[ $field ] ) ) {
					$output .= $metadata[ $field ];
				} elseif ( ! empty( $metadata['image_meta'][ $field ] ) ) {
					$output .= $metadata['image_meta'][ $field ];
				}

				echo wp_kses( $output, array(
					'sup' => array(),
					'sub' => array(),
				) );
				?>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul><!-- .entry-attachment-meta -->
