import SkipLinkFocusFix from './skip-link-focus-fix';
import Navigation from './navigation';
import CommentForm from './comment-form';
import Modals from './modals';
import Sticky from './sticky';

window.themeData = window.themeData || {};

( function( themeData ) {
	themeData.components = {
		skipLinkFocusFix: new SkipLinkFocusFix(),
		navigation: new Navigation( 'site-navigation', themeData.navigation ),
		commentForm: new CommentForm( 'commentform', 'comments', themeData.comments ),
		modals: new Modals( '.modal' ),
		sticky: new Sticky( themeData.sticky ),
	};

	themeData.components.skipLinkFocusFix.initialize();
	themeData.components.navigation.initialize();
	themeData.components.commentForm.initialize();
	themeData.components.modals.initialize();
	themeData.components.sticky.initialize();
})( window.themeData );
