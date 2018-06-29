<?php
/**
 * Super_Awesome_Theme_Font_Customize_Control class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a font Customizer control.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Font_Customize_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'super_awesome_theme_font';

	/**
	 * Enqueues scripts and styles for the control.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'selectWoo', get_theme_file_uri( "/assets/vendor/selectWoo/dist/js/selectWoo.full{$min}.js" ), array( 'jquery' ), '1.0.2', true );
		wp_enqueue_style( 'selectWoo', get_theme_file_uri( "/assets/vendor/selectWoo/dist/css/selectWoo{$min}.css" ), array(), '1.0.2' );
		wp_add_inline_style( 'selectWoo', '.select2-container.select2-container--open { z-index: 1000000; }' );
	}

	/**
	 * Prevents rendering the control content from PHP, as it iss rendered via JS on load.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}

	/**
	 * Renders a JS template for the control content.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
		<# var defaultValue = '#RRGGBB', defaultValueAttr = '',
			isHueSlider = data.mode === 'hue';
		if ( data.defaultValue && _.isString( data.defaultValue ) && ! isHueSlider ) {
			if ( '#' !== data.defaultValue.substring( 0, 1 ) ) {
				defaultValue = '#' + data.defaultValue;
			} else {
				defaultValue = data.defaultValue;
			}
			defaultValueAttr = ' data-default-color=' + defaultValue; // Quotes added automatically.
		} #>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<fieldset>
				<legend class="screen-reader-text">{{{ data.label }}}</legend>

				<label for="customize-control-font-family-{{{ data.id }}}"><?php esc_html_e( 'Font Family', 'super-awesome-theme' ); ?></label>
				<select {{{ data.inputAttrs }}} id="customize-control-font-family-{{{ data.id }}}" data-setting-property="family" placeholder="<?php esc_attr_e( 'Select Font Family', 'super-awesome-theme' ); ?>"></select>

				<label for="customize-control-font-weight-{{{ data.id }}}"><?php esc_html_e( 'Font Weight', 'super-awesome-theme' ); ?></label>
				<select {{{ data.inputAttrs }}} id="customize-control-font-weight-{{{ data.id }}}" data-setting-property="weight" placeholder="<?php esc_attr_e( 'Select Font Weight', 'super-awesome-theme' ); ?>"></select>

				<label for="customize-control-font-size-{{{ data.id }}}"><?php esc_html_e( 'Font Size', 'super-awesome-theme' ); ?></label>
				<input type="number" min="0.5" max="3.0" step="0.1" {{{ data.inputAttrs }}} id="customize-control-font-size-{{{ data.id }}}" data-setting-property="size"></select>
			</fieldset>
		</div>
		<?php
	}
}
