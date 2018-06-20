/**
 * File navbar.js.
 *
 * Handles toggling the navbar.
 */

class Navbar {
	constructor( containerId, options ) {
		this.container = document.querySelector( '#' + containerId );
		this.options   = options || {};
	}

	initialize() {
		if ( ! this.container ) {
			return;
		}

		const button = this.container.querySelector( 'button.site-navbar-toggle' );

		this.initializeNavbarToggle( button );
	}

	initializeNavbarToggle( button ) {
		const container = this.container;

		if ( ! button ) {
			container.classList.add( 'toggled' );
			return;
		}

		button.onclick = function() {
			const result = container.classList.toggle( 'toggled' );

			if ( result ) {
				button.setAttribute( 'aria-expanded', 'true' );
			} else {
				button.setAttribute( 'aria-expanded', 'false' );
			}
		};
	}
}

export default Navbar;
