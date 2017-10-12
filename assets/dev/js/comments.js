/**
 * File comments.js.
 *
 * Handles comment submission via AJAX.
 */

function comments( themeData ) {
	var commentForm, comments, statusDiv, commentReplyLinks, currentList, i;

	if ( 'function' !== typeof window.fetch ) {
		return;
	}

	commentForm = document.getElementById( 'commentform' );
	if ( ! $commentForm ) {
		return;
	}

	comments = document.getElementById( 'comments' );
	if ( ! comments ) {
		return;
	}

	commentForm.setAttribute( 'aria-live', 'polite' );

	statusDiv = document.createElement( 'div' );
	statusDiv.setAttribute( 'id', 'comment-status' );
	statusDiv.setAttribute( 'aria-live', 'assertive' );
	statusDiv.setAttribute( 'role', 'status' );
	statusDiv.setAttribute( 'tabindex', '-1' );

	commentForm.insertBefore( statusDiv, commentForm.childNodes[0] );

	commentReplyLinks = document.getElementsByClassName( 'comment-reply-link' );
	for ( i = 0; i < commentReplyLinks.length; i++ ) {
		commentReplyLinks[ i ].addEventListener( 'click', function() {
			var elem = this;

			do {
				elem = elem.parentElement;
			} while ( elem && ! elem.classList.contains( 'comment' ) );

			currentList = elem;
		});
	}

	commentForm.addEventListener( 'submit', function() {
		var formData, formUrl, hasError, fields, name, i;

		formData = {};
		formUrl = commentForm.getAttribute( 'action' );

		clearStatusNotices( statusDiv );
		clearFieldErrors( commentForm );

		hasError = false;

		fields = commentForm.querySelectorAll( 'input, textarea' );
		for ( i = 0; i < fields.length; i++ ) {
			name = fields[ i ].getAttribute( 'name' );

			if ( 'textarea' === fields[ i ].tagName.toLowerCase() ) {
				formData[ name ] = fields[ i ].value;
			} else {
				formData[ name ] = fields[ i ].getAttribute( 'value' );
			}

			if ( 'string' === typeof formData[ name ] ) {
				formData[ name ] = formData[ name ].trim();
			} else {
				formData[ name ] = '';
			}

			if ( 'true' === fields[ i ].getAttribute( 'aria-required' ) && ! formData[ name ].length ) {
				addFieldError( fields[ i ], themeData.i18n.required );

				hasError = true;
			} else if ( 'email' === name && formData[ name ].length && ! validateEmail( formData[ name ] ) ) {
				addFieldError( fields[ i ], themeData.i18n.emailInvalid );

				hasError = true;
			}
		}

		if ( hasError ) {
			addStatusNotice( statusDiv, 'comment-notice-error', themeData.i18n.error );

			return false;
		}

		addStatusNotice( statusDiv, 'comment-notice-processing', themeData.i18n.processing );

		window.fetch( formUrl, {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			body: formData, // TODO: Make this work.
		})
			.then( function( response ) {
				var contentType;

				if ( 200 !== response.status ) {
					throw new Error( themeData.i18n.badResponse );
				}

				contentType = response.headers.get( 'content-type' );

				if ( ! contentType || ! contentType.includes( 'application/json' ) ) {
					throw new TypeError( themeData.i18n.invalidJson );
				}

				return response.json();
			})
			.then( function( result ) {
				var commentList;

				clearStatusNotices( statusDiv );

				if ( result.success ) {
					addStatusNotice( statusDiv, 'comment-notice-success', result.status, true );

					if ( comments.querySelectorAll( 'ol.comment-list' ).length ) {
						commentList = comments.querySelector( 'ol.comment-list' );
					} else {
						commentList = document.createElement( 'ol' );
						commentList.classList.add( 'comment-list' );

						comments.appendChild( commentList );
					}

					if ( currentList ) {
						currentList.innerHTML = result.response + currentList.innerHTML;
					} else {
						commentList.innerHTML = commentList.innerHTML + result.response;
					}
				} else {
					addStatusNotice( statusDiv, 'comment-notice-error', result.status, true );
				}

				commentForm.querySelector( 'textarea[name="content"]' ).value = '';
			})
			.catch( function( error ) {
				clearStatusNotices( statusDiv );
				addStatusNotice( statusDiv, 'comment-notice-error', themeData.i18n.flood, true );
			});

		return false;
	});
}

function clearStatusNotices( wrap ) {
	var notices = wrap.getElementsByClassName( 'comment-notice' );

	for ( i = 0; i < notices.length; i++ ) {
		notices[ i ].parentElement.removeChild( notices[ i ] );
	}
}

function clearFieldErrors( form ) {
	var errors = form.getElementsByClassName( 'comment-field-error' );

	for ( i = 0; i < errors.length; i++ ) {
		errors[ i ].parentElement.removeChild( errors[ i ] );
	}
}

function addStatusNotice( wrap, className, message, setFocus ) {
	var notice = document.createElement( 'p' );

	notice.classList.add( 'comment-notice', className );
	notice.innerHTML = message;

	wrap.appendChild( notice );

	if ( setFocus ) {
		wrap.focus();
	}
}

function addFieldError( field, errorMessage ) {
	var id, error;

	id = field.getAttribute( 'id' );

	field.setAttribute( 'aria-describedby', id + '-error' );

	error = document.createElement( 'span' );
	error.setAttribute( 'id', id + '-error' );
	error.classList.add( 'comment-field-error' );
	error.textContent = errorMessage;

	field.parentElement.appendChild( error );
}

function validateEmail( value ) {
	var filter = /^([\w-\+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if ( filter.test( value ) ) {
		return true;
	}

	return false;
}

export default comments;
