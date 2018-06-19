/**
 * File custom-header.customize-controls.js.
 *
 * Theme Customizer handling for additional Custom Header controls.
 */

( ( wp, data ) => {
	const api        = wp.customize;
	const { __, _x } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'branding_location', 'header_position', ( brandingLocation, headerPosition ) => {
			brandingLocation.transport = 'refresh';
			headerPosition.transport   = 'refresh';
		});

		api.control.add( new api.Control( 'branding_location', {
			section:     'title_tagline',
			label:       __( 'Display Location', 'super-awesome-theme' ),
			description: __( 'Specify where to display the site logo, title and tagline.', 'super-awesome-theme' ),
			type:        'radio',
			choices:     data.brandingLocationChoices,
		}) );

		api.control.add( new api.Control( 'header_position', {
			section:     'header_image',
			label:       _x( 'Position', 'custom header', 'super-awesome-theme' ),
			description: __( 'Specify where to display the header image or video.', 'super-awesome-theme' ),
			type:        'radio',
			choices:     data.headerPositionChoices,
		}) );

		api.control.add( new api.Control( 'header_textalign', {
			section: 'header_image',
			label:   _x( 'Text Alignment', 'custom header', 'super-awesome-theme' ),
			type:    'radio',
			choices: data.headerTextalignChoices,
		}) );
	});

} )( window.wp, window.themeCustomHeaderControlsData );
