/**
 * File customize-controls.js.
 *
 * Theme Customizer handling for the interface.
 */

( function() {

	wp.customize.bind( 'ready', function() {

		// Only show sidebar-related controls if a sidebar is enabled.
		wp.customize( 'sidebar_mode', function( setting ) {
			var toggleVisibility = function( control ) {
				var visibility = function() {
					if ( 'no-sidebar' === setting.get() ) {
						control.container.slideUp( 180 );
					} else {
						control.container.slideDown( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			};

			wp.customize.control( 'sidebar_size', toggleVisibility );
			wp.customize.control( 'blog_sidebar_enabled', toggleVisibility );
		});
	});
} )();
