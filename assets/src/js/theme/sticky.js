/**
 * File sticky.js.
 *
 * Handles stickiness of components which should always be visible by fixing them at the
 * top or bottom of the screen.
 */

class Sticky {
	constructor( options ) {
		let selectors;

		this.stickToTopSelectors = [];
		this.stickToBottomSelectors = [];

		this.options = options || {};

		selectors = Object.keys( this.options );
		selectors.forEach( selector => {
			switch ( true ) {
				case 'top' === this.options[ selector ]:
					this.stickToTopSelectors.push( selector );
					break;
				case 'bottom' === this.options[ selector ]:
					this.stickToBottomSelectors.push( selector );
					break;
			}
		});

		this.pageWrap                = document.getElementById( 'page' );
		this.stickToTopContainers    = this.stickToTopSelectors
			.map( selector => document.querySelector( selector ) )
			.filter( container => container )
			.sort( ( a, b ) => a.offsetTop < b.offsetTop ? -1 : 1 );
		this.stickToBottomContainers = this.stickToBottomSelectors
			.map( selector => document.querySelector( selector ) )
			.filter( container => container )
			.sort( ( a, b ) => a.offsetTop < b.offsetTop ? -1 : 1 )
			.reverse();
	}

	initialize() {
		const context = this;

		this.initializeHeaderSiteBranding();

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

	initializeHeaderSiteBranding() {
		const headerSiteBranding = document.querySelector( '.site-custom-header .site-branding' );
		const offset             = headerSiteBranding ? ( headerSiteBranding.offsetTop ? headerSiteBranding.offsetTop : ( headerSiteBranding.offsetParent ? headerSiteBranding.offsetParent.offsetTop : 0 ) ) : 0;

		if ( ! headerSiteBranding ) {
			return;
		}

		function checkHeaderSiteBranding() {
			if ( window.scrollY >= offset ) {
				document.body.classList.add( 'scrolled-past-header-site-branding' );
				return;
			}

			document.body.classList.remove( 'scrolled-past-header-site-branding' );
		}

		checkHeaderSiteBranding();
		window.addEventListener( 'scroll', checkHeaderSiteBranding );
		window.addEventListener( 'resize', checkHeaderSiteBranding );
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

	addRemoveStickyContainer( selector, location, remove ) {
		const container = document.querySelector( selector );
		let selectorsHandle, containersHandle, offsetsHandle, exists;
		if ( 'top' === location ) {
			selectorsHandle  = 'stickToTopSelectors';
			containersHandle = 'stickToTopContainers';
			offsetsHandle    = 'stickToTopOffsets';
		} else if ( 'bottom' === location ) {
			selectorsHandle  = 'stickToBottomSelectors';
			containersHandle = 'stickToBottomContainers';
			offsetsHandle    = 'stickToBottomOffsets';
		}

		if ( ! container || ! selectorsHandle || ! containersHandle || ! offsetsHandle ) {
			return;
		}

		exists = this[ selectorsHandle ].includes( selector );
		if ( ! remove && exists || remove && ! exists ) {
			return;
		}

		this.pageWrap.style.removeProperty( 'padding-top' );
		this[ containersHandle ].forEach( container => {
			container.classList.remove( 'is-sticky', 'is-sticky-top', 'is-sticky-bottom' );
			container.style.removeProperty( 'top' );
			container.style.removeProperty( 'bottom' );
		});

		if ( remove ) {
			this[ selectorsHandle ].splice( this[ selectorsHandle ].findIndex( item => item === selector ), 1 );
			this[ containersHandle ].splice( this[ containersHandle ].findIndex( item => item === container ), 1 );
		} else {
			this[ selectorsHandle ].push( selector );
			this[ containersHandle ].push( container );
		}

		this[ containersHandle ] = this[ containersHandle ].sort( ( a, b ) => a.offsetTop < b.offsetTop ? -1 : 1 );
		if ( 'bottom' === location ) {
			this[ containersHandle ] = this[ containersHandle ].reverse();
		}

		this[ offsetsHandle ] = this[ containersHandle ].map( container => container.offsetTop + ( 'bottom' === location ? container.offsetHeight : 0 ) );

		this.checkStickyContainers();
	}
}

export default Sticky;
