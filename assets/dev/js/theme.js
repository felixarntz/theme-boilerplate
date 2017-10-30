import skipLinkFocusFix from './skip-link-focus-fix';
import Navigation from './navigation';
import comments from './comments';

window.themeData = window.themeData || {};

( function( themeData ) {
	themeData.components = {
		navigation: new Navigation( 'site-navigation', themeData.navigation ),
	};

	skipLinkFocusFix();
	comments( themeData.comments || {} );

	themeData.components.navigation.initialize();
})( window.themeData );
