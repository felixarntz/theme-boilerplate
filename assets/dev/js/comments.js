/**
 * File comments.js.
 *
 * Handles comment submission via AJAX.
 */

function comments() {
	var commentForm, statusDiv, list;

	commentForm = document.getElementById( 'commentform' );
	if ( ! $commentForm ) {
		return;
	}

	commentForm.setAttribute( 'aria-live', 'polite' );

	statusDiv = document.createElement( 'div' );
	statusDiv.setAttribute( 'id', 'comment-status' );
	statusDiv.setAttribute( 'aria-live', 'assertive' );
	statusDiv.setAttribute( 'role', 'status' );
	statusDiv.setAttribute( 'tabindex', '-1' );

	commentForm.insertBefore( statusDiv, commentForm.firstChild );

	document.getElementsByClassName( 'comment-reply-link' ).addEventListener( 'click', function() {
		list = this.parent.getAttribute( 'id' );
	});

	commentForm.addEventListener( 'submit', function() {
		var formData, formUrl, errors, hasError, fields, id, i;

		formData = {};
		formUrl = commentForm.getAttribute( 'action' );

		errors = commentForm.getElementsByClassName( 'comment-error' ) + commentForm.getElementsByClassName( 'comment-field-error' );
		for ( i = 0; i < errors.length; i++ ) {
			errors[ i ].parent.removeChild( errors[ i ] );
		}

		hasError = false;

		fields = commentForm.getElementsByTagName( 'input' ) + commentForm.getElementsByTagName( 'textarea' );
		for ( i = 0; i < fields.length; i++ ) {
			id = fields[ i ].getAttribute( 'id' );

			if ( 'textarea' === fields[ i ].tagName.toLowerCase() ) {
				formData[ id ] = fields[ i ].text;
			} else {
				formData[ id ] = fields[ i ].getAttribute( 'value' );
			}
		}
	});
}

function validateEmail( value ) {
	var filter = /^([\w-\+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if ( filter.test( value ) ) {
		return true;
	}

	return false;
}

export default comments;
