import SkipLinkFocusFix from './theme/skip-link-focus-fix';
import Navigation from './theme/navigation';
import CommentForm from './theme/comment-form';
import Modals from './theme/modals';
import Sticky from './theme/sticky';

( function( data ) {
	data = data || {};

	document.addEventListener( 'wp-custom-header-video-loaded', () => {
		document.body.addClass( 'has-header-video' );
	});

	data.components = {
		skipLinkFocusFix: new SkipLinkFocusFix(),
		navigation: new Navigation( 'site-navigation', data.navigation ),
		commentForm: new CommentForm( 'commentform', 'comments', data.comments ),
		modals: new Modals( '.modal' ),
		sticky: new Sticky( data.sticky ),
	};

	data.components.skipLinkFocusFix.initialize();
	data.components.navigation.initialize();
	data.components.commentForm.initialize();
	data.components.modals.initialize();
	data.components.sticky.initialize();
})( window.themeData );
