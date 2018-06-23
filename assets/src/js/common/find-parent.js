/**
 * File find-parent.js.
 *
 * Exports a function to get a specific parent element of an element.
 */

export default function findParent( element, selector ) {
	while ( element && element !== document ) {
		element = element.parentElement;

		if ( element.matches( selector ) ) {
			return element;
		}
	}

	return null;
}
