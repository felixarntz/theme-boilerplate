/**
 * File wp-i18n.js.
 *
 * Implements i18n functions for WordPress in JavaScript through a
 * `wp.i18n` object. Only writes the object if it is not already set.
 */

import {
	setLocaleData,
	getI18n,
	__,
	_x,
	_n,
	_nx,
	sprintf,
} from '@wordpress/i18n';

( ( wp ) => {

	wp = wp || {};

	if ( wp.i18n ) {
		return;
	}

	wp.i18n = {
		setLocaleData,
		getI18n,
		__,
		_x,
		_n,
		_nx,
		sprintf,
	};

} )( window.wp );
