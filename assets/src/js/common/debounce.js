/**
 * File debounce.js.
 *
 * Exports a function to debounce functionality.
 */

export default function debounce( func, wait, immediate ) {
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
