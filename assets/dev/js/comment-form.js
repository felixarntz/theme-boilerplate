/**
 * File comments.js.
 *
 * Handles comment submission via AJAX.
 */

class CommentForm {
	constructor( commentFormId, commentsId, options ) {
		this.commentForm = document.getElementById( commentFormId );
		this.comments    = document.getElementById( commentsId );
		this.options     = options || {};
	}

	initialize() {
		if ( ! this.commentForm ) {
			return;
		}

		if ( ! this.comments ) {
			return;
		}

		if ( 'function' !== typeof window.fetch || 'function' !== typeof window.FormData ) {
			return;
		}

		// TODO.
	}
}

/* Old code: function comments( themeData ) {
	var commentForm, comments, statusDiv, commentReplyLinks, currentList, i;

	if ( 'function' !== typeof window.fetch || 'function' !== typeof window.FormData ) {
		return;
	}

	commentForm = document.getElementById( 'commentform' );
	if ( ! commentForm ) {
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

	commentForm.insertBefore( statusDiv, commentForm.childNodes.item( 0 ) );

	commentReplyLinks = nodeListToArray( document.getElementsByClassName( 'comment-reply-link' ) );
	for ( i = 0; i < commentReplyLinks.length; i++ ) {
		commentReplyLinks[ i ].addEventListener( 'click', function() {
			var elem = this;

			do {
				elem = elem.parentElement;
			} while ( elem && ! elem.classList.contains( 'comment' ) );

			currentList = elem;
		});
	}

	commentForm.addEventListener( 'submit', function( evt ) {
		var formUrl, hasError, fields, field, name, value, i;

		evt.preventDefault();

		formUrl = commentForm.getAttribute( 'action' );
		if ( formUrl.indexOf( '?' ) > -1 ) {
			formUrl += '&is_ajax=true';
		} else {
			formUrl += '?is_ajax=true';
		}

		clearStatusNotice( statusDiv );
		clearFieldErrors( commentForm );

		hasError = false;

		fields = nodeListToArray( commentForm.querySelectorAll( 'input, textarea' ) );
		for ( i = 0; i < fields.length; i++ ) {
			field = fields[ i ];

			name = field.getAttribute( 'name' );
			value = field.value;

			if ( 'string' === typeof value ) {
				value = value.trim();
			} else {
				value = '';
			}

			if ( 'true' === field.getAttribute( 'aria-required' ) && ! value.length ) {
				addFieldError( field, themeData.i18n.required );

				hasError = true;
			} else if ( 'email' === name && value.length && ! validateEmail( value ) ) {
				addFieldError( field, themeData.i18n.emailInvalid );

				hasError = true;
			}
		}

		if ( hasError ) {
			addStatusNotice( statusDiv, 'error', themeData.i18n.error );

			return false;
		}

		addStatusNotice( statusDiv, 'info', themeData.i18n.processing );

		window.fetch( formUrl, {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			body: new window.FormData( commentForm ),
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
				var commentList, commentListHeading;

				clearStatusNotice( statusDiv );

				if ( result.success ) {
					addStatusNotice( statusDiv, 'success', result.status, true );

					if ( comments.querySelectorAll( 'ol.comment-list' ).length ) {
						commentList = comments.querySelector( 'ol.comment-list' );
					} else {
						commentList = document.createElement( 'ol' );
						commentList.classList.add( 'comment-list' );

						comments.insertBefore( commentList, comments.childNodes.item( 0 ) );

						commentListHeading = document.createElement( 'h2' );
						commentListHeading.classList.add( 'comments-title' );
						commentListHeading.innerHTML = themeData.i18n.commentsTitle;

						comments.insertBefore( commentListHeading, comments.childNodes.item( 0 ) );
					}

					if ( currentList ) {
						currentList.innerHTML = result.response + currentList.innerHTML;
					} else {
						commentList.innerHTML = commentList.innerHTML + result.response;
					}
				} else {
					addStatusNotice( statusDiv, 'error', result.status, true );
				}

				commentForm.querySelector( 'textarea[name="comment"]' ).value = '';
			})
			.catch( function() {
				clearStatusNotice( statusDiv );
				addStatusNotice( statusDiv, 'error', themeData.i18n.flood, true );
			});

		return false;
	});
}

function clearStatusNotice( wrap ) {
	var notices = nodeListToArray( wrap.childNodes );
	var i;

	for ( i = 0; i < notices.length; i++ ) {
		notices[ i ].parentElement.removeChild( notices[ i ] );
	}

	wrap.classList.remove( 'notice', 'notice-success', 'notice-info', 'notice-warning', 'notice-error' );
}

function clearFieldErrors( form ) {
	var errors = nodeListToArray( form.getElementsByClassName( 'field-notice' ) );
	var i;

	for ( i = 0; i < errors.length; i++ ) {
		errors[ i ].parentElement.removeChild( errors[ i ] );
	}
}

function addStatusNotice( wrap, type, message, setFocus ) {
	var className = 'notice-' + type;
	var notice = document.createElement( 'p' );

	notice.innerHTML = message;

	wrap.classList.add( 'notice', className );
	wrap.appendChild( notice );

	if ( setFocus ) {
		wrap.focus();
	}
}

function addFieldError( field, errorMessage ) {
	var id, error;

	id = field.getAttribute( 'id' );

	field.setAttribute( 'aria-describedby', id + '-field-error' );

	error = document.createElement( 'span' );
	error.setAttribute( 'id', id + '-field-error' );
	error.classList.add( 'field-notice', 'notice-error' );
	error.textContent = errorMessage;

	field.parentElement.appendChild( error );
}

function validateEmail( value ) {
	var filter = /^([\w-+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if ( filter.test( value ) ) {
		return true;
	}

	return false;
}

function nodeListToArray( nodeList ) {
	var nodeListArray = [];
	var i;

	for ( i = 0; i < nodeList.length; i++ ) {
		nodeListArray.push( nodeList.item( i ) );
	}

	return nodeListArray;
}*/

export default CommentForm;
