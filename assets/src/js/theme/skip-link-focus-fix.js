/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */

function detectUserAgent() {
	const userAgents = [ 'webkit', 'opera', 'msie' ];
	let userAgent;

	for ( userAgent of userAgents ) {
		if ( navigator.userAgent.toLowerCase().indexOf( userAgent ) > -1 ) {
			return userAgent;
		}
	}

	return '';
}

class SkipLinkFocusFix {
	constructor() {
		this.userAgent = detectUserAgent();
	}

	initialize() {
		if ( ! this.userAgent.length ) {
			return;
		}

		if ( ! document.getElementById || ! window.addEventListener ) {
			return;
		}

		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
}

export default SkipLinkFocusFix;
