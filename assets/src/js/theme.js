import SkipLinkFocusFix from './skip-link-focus-fix';
import Navigation from './navigation';
import CommentForm from './comment-form';

window.themeData = window.themeData || {};

( function( themeData ) {
	themeData.components = {
		skipLinkFocusFix: new SkipLinkFocusFix(),
		navigation: new Navigation( 'site-navigation', themeData.navigation ),
		commentForm: new CommentForm( 'commentform', 'comments', themeData.comments ),
	};

	themeData.components.skipLinkFocusFix.initialize();
	themeData.components.navigation.initialize();
	themeData.components.commentForm.initialize();
})( window.themeData );
