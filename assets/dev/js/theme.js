import SkipLinkFocusFix from './skip-link-focus-fix';
import Navigation from './navigation';
import comments from './comments';

window.themeData = window.themeData || {};

( function( themeData ) {
	themeData.components = {
		skipLinkFocusFix: new SkipLinkFocusFix(),
		navigation: new Navigation( 'site-navigation', themeData.navigation ),
	};

	comments( themeData.comments || {} );

	themeData.components.skipLinkFocusFix.initialize();
	themeData.components.navigation.initialize();
})( window.themeData );
