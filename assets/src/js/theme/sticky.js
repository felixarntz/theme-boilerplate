/**
 * File sticky.js.
 *
 * Handles stickiness of components which should always be visible by fixing them at the
 * top or bottom of the screen.
 */

class Sticky {
	constructor( options ) {
		let stickToTopIds, stickToBottomIds;

		this.options   = options || {};

		stickToTopIds    = this.options.stickToTopIds || [];
		stickToBottomIds = this.options.stickToBottomIds || [];

		if ( 'object' !== typeof stickToTopIds || 'undefined' === typeof stickToTopIds.length ) {
			stickToTopIds = [ stickToTopIds ];
		}
		if ( 'object' !== typeof stickToBottomIds || 'undefined' === typeof stickToBottomIds.length ) {
			stickToBottomIds = [ stickToBottomIds ];
		}

		this.pageWrap                = document.getElementById( 'page' );
		this.stickToTopContainers    = stickToTopIds
			.map( id => document.getElementById( id ) )
			.filter( container => container );
		this.stickToBottomContainers = stickToBottomIds
			.reverse()
			.map( id => document.getElementById( id ) )
			.filter( container => container );
	}

	initialize() {
		const context = this;

		if ( ! this.stickToTopContainers.length && ! this.stickToBottomContainers.length ) {
			return;
		}

		this.stickToTopOffsets    = this.stickToTopContainers.map( container => container.offsetTop );
		this.stickToBottomOffsets = this.stickToBottomContainers.map( container => container.offsetTop + container.offsetHeight );

		function checkStickyContainers() {
			context.checkStickyContainers();
		}

		this.checkStickyContainers();
		window.addEventListener( 'scroll', checkStickyContainers );
		window.addEventListener( 'resize', checkStickyContainers );
	}

	checkStickyContainers() {
		const pageWrap      = this.pageWrap;
		const topOffsets    = this.stickToTopOffsets;
		const bottomOffsets = this.stickToBottomOffsets;

		let toolbarOffset = this.getToolbarOffset();
		let topOffset     = 0;
		let bottomOffset  = 0;

		pageWrap.style.paddingTop = `${topOffset}px`;

		this.stickToTopContainers.forEach( ( container, index ) => {
			if ( window.scrollY >= topOffsets[ index ] - topOffset ) {
				container.style.top = `${( toolbarOffset + topOffset )}px`;
				if ( ! container.classList.contains( 'is-sticky' ) ) {
					container.classList.add( 'is-sticky', 'is-sticky-top' );
				}

				topOffset += container.offsetHeight;
			} else {
				if ( container.classList.contains( 'is-sticky' ) ) {
					container.classList.remove( 'is-sticky', 'is-sticky-top' );
				}
				container.style.top = 'auto';
			}

			pageWrap.style.paddingTop = `${topOffset}px`;
		});

		pageWrap.style.paddingBottom = `${( topOffset + bottomOffset )}px`;

		this.stickToBottomContainers.forEach( ( container, index ) => {
			if ( window.scrollY <= bottomOffsets[ index ] ) {
				container.style.bottom = `${bottomOffset}px`;
				if ( ! container.classList.contains( 'is-sticky' ) ) {
					container.classList.add( 'is-sticky', 'is-sticky-bottom' );
				}

				bottomOffset += container.offsetHeight;
			} else {
				if ( container.classList.contains( 'is-sticky' ) ) {
					container.classList.remove( 'is-sticky', 'is-sticky-bottom' );
				}
				container.style.bottom = 'auto';
			}

			pageWrap.style.paddingBottom = `${( topOffset + bottomOffset )}px`;
		});
	}

	getToolbarOffset() {
		const toolbar = document.getElementById( 'wpadminbar' );

		if ( ! toolbar ) {
			if ( document.body.classList.contains( 'admin-bar' ) ) {

				// If the toolbar is not yet rendered but will be shortly, fall back to WordPress defaults.
				if ( document.body.clientWidth <= 782 ) {
					return 46;
				}
				return 32;
			}

			return 0;
		}

		return toolbar.offsetHeight;
	}
}

export default Sticky;
