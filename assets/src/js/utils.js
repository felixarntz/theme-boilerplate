/**
 * File utils.js.
 *
 * Contains utility functions used by theme functionality.
 */

export function findParent( element, selector ) {
	while ( element && element !== document ) {
		element = element.parentElement;

		if ( element.matches( selector ) ) {
			return element;
		}
	}

	return null;
}

export function debounce( func, wait, immediate ) {
	let timeout;

	return () => {
		const context = this;
		const args    = arguments;
		const later   = () => {
			timeout = null;
			if ( ! immediate ) {
				func.apply( context, args );
			}
		};
		const callNow = immediate && ! timeout;

		clearTimeout( timeout );
		timeout = setTimeout( later, wait );

		if ( callNow ) {
			func.apply( context, args );
		}
	};
}
