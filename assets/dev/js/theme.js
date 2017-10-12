import skipLinkFocusFix from './skip-link-focus-fix';
import navigation from './navigation';
import comments from './comments';

( function( themeData ) {
	skipLinkFocusFix();
	navigation();
	comments( themeData.comments );
})( themeData );
