/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

( function( $ ) {

	// Site title.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to,
				} );
			}
		} );
	} );

	// Sidebar mode.
	wp.customize( 'sidebar_mode', function( value ) {
		value.bind( function( to ) {
			var classes = Object.keys( themeCustomizeData.sidebarModeChoices );
			var index   = classes.indexOf( to );

			if ( index > -1 ) {
				classes.splice( index, 1 );

				$( 'body' ).removeClass( classes.join( ' ' ) ).addClass( to );
			}
		} );
	} );

	// Sidebar size.
	wp.customize( 'sidebar_size', function( value ) {
		value.bind( function( to ) {
			var classes = Object.keys( themeCustomizeData.sidebarSizeChoices ).map(function(setting) {
				return 'sidebar-' + setting;
			});
			var index;

			to = 'sidebar-' + to;
			index = classes.indexOf( to );

			if ( index > -1 ) {
				classes.splice( index, 1 );

				$( 'body' ).removeClass( classes.join( ' ' ) ).addClass( to );
			}
		} );
	} );
} )( jQuery );
