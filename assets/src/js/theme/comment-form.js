/**
 * File comments.js.
 *
 * Handles comment submission via AJAX.
 */

let currentList;

function clearStatusNotice( wrap ) {
	const notices = wrap.childNodes;

	Array.from( notices ).forEach( function( notice ) {
		notice.parentElement.removeChild( notice );
	});

	wrap.classList.remove( 'notice', 'notice-success', 'notice-info', 'notice-warning', 'notice-error' );
}

function clearFieldErrors( form ) {
	const errors = form.getElementsByClassName( 'field-notice' );

	Array.from( errors ).forEach( function( error ) {
		error.parentElement.removeChild( error );
	});
}

function addStatusNotice( wrap, type, message, setFocus ) {
	const className = 'notice-' + type;
	const notice = document.createElement( 'p' );

	notice.innerHTML = message;

	wrap.classList.add( 'notice', className );
	wrap.appendChild( notice );

	if ( setFocus ) {
		wrap.focus();
	}
}

function addFieldError( field, errorMessage ) {
	const error = document.createElement( 'span' );
	const id = field.getAttribute( 'id' );

	field.setAttribute( 'aria-describedby', id + '-field-error' );

	error.setAttribute( 'id', id + '-field-error' );
	error.classList.add( 'field-notice', 'notice-error' );
	error.textContent = errorMessage;

	field.parentElement.appendChild( error );
}

function validateEmail( value ) {
	const filter = /^([\w-+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if ( filter.test( value ) ) {
		return true;
	}

	return false;
}

class CommentForm {
	constructor( commentFormId, commentsId, options ) {
		this.commentForm = document.getElementById( commentFormId );
		this.comments    = document.getElementById( commentsId );
		this.options     = options || {};
	}

	initialize() {
		let statusDiv;

		if ( ! this.commentForm ) {
			return;
		}

		if ( ! this.comments ) {
			return;
		}

		if ( 'function' !== typeof window.fetch || 'function' !== typeof window.FormData ) {
			return;
		}

		statusDiv = this.createStatusDiv();

		this.initializeCommentReplyLinks( this.comments );
		this.initializeCommentForm( this.commentForm, this.comments, statusDiv );
	}

	createStatusDiv() {
		const statusDiv = document.createElement( 'div' );

		statusDiv.setAttribute( 'id', 'comment-status' );
		statusDiv.setAttribute( 'aria-live', 'assertive' );
		statusDiv.setAttribute( 'role', 'status' );
		statusDiv.setAttribute( 'tabindex', '-1' );

		return statusDiv;
	}

	initializeCommentReplyLinks( comments ) {
		let commentReplyLinks;

		if ( ! comments ) {
			return;
		}

		function setCurrentList() {
			let element = this;

			do {
				element = element.parentElement;
			} while ( element && ! element.classList.contains( 'comment' ) );

			currentList = element;
		}

		commentReplyLinks = comments.getElementsByClassName( 'comment-reply-link' );

		Array.from( commentReplyLinks ).forEach( function( commentReplyLink ) {
			commentReplyLink.addEventListener( 'click', setCurrentList );
		});
	}

	initializeCommentForm( commentForm, comments, statusDiv ) {
		const options = this.options;

		if ( ! commentForm ) {
			return;
		}

		if ( ! comments ) {
			return;
		}

		if ( ! statusDiv ) {
			return;
		}

		function preprocessResponse( response ) {
			let contentType;

			if ( 200 !== response.status ) {
				throw new Error( options.i18n.badResponse );
			}

			contentType = response.headers.get( 'content-type' );

			if ( ! contentType || ! contentType.includes( 'application/json' ) ) {
				throw new TypeError( options.i18n.invalidJson );
			}

			return response.json();
		}

		function handleResponseSuccess( result ) {
			let commentList, commentListHeading;

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
					commentListHeading.innerHTML = options.i18n.commentsTitle;

					comments.insertBefore( commentListHeading, comments.childNodes.item( 0 ) );
				}

				if ( currentList ) {
					currentList.innerHTML = currentList.innerHTML + result.response;
				} else {
					commentList.innerHTML = commentList.innerHTML + result.response;
				}
			} else {
				addStatusNotice( statusDiv, 'error', result.status, true );
			}

			currentList = undefined;
			commentForm.querySelector( 'textarea[name="comment"]' ).value = '';
		}

		function handleResponseError() {
			clearStatusNotice( statusDiv );
			addStatusNotice( statusDiv, 'error', options.i18n.flood, true );
		}

		function handleSubmission( e ) {
			const formUrl = commentForm.getAttribute( 'action' ) + ( commentForm.getAttribute( 'action' ).indexOf( '?' ) > -1 ? '&' : '?' ) + 'is_ajax=true';
			const fields = commentForm.querySelectorAll( 'input, textarea' );

			let hasError = false;

			e.preventDefault();

			clearStatusNotice( statusDiv );
			clearFieldErrors( commentForm );

			Array.from( fields ).forEach( function( field ) {
				const name = field.getAttribute( 'name' );
				const value = 'string' === typeof field.value ? field.value.trim() : '';

				if ( 'true' === field.getAttribute( 'aria-required' ) && ! value.length ) {
					addFieldError( field, options.i18n.required );

					hasError = true;
				} else if ( 'email' === name && value.length && ! validateEmail( value ) ) {
					addFieldError( field, options.i18n.emailInvalid );

					hasError = true;
				}
			});

			if ( hasError ) {
				addStatusNotice( statusDiv, 'error', options.i18n.error );

				return false;
			}

			addStatusNotice( statusDiv, 'info', options.i18n.processing );

			window.fetch( formUrl, {
				method: 'POST',
				mode: 'same-origin',
				credentials: 'same-origin',
				body: new window.FormData( commentForm ),
			})
				.then( preprocessResponse )
				.then( handleResponseSuccess )
				.catch( handleResponseError );

			return false;
		}

		commentForm.setAttribute( 'aria-live', 'polite' );
		commentForm.insertBefore( statusDiv, commentForm.childNodes.item( 0 ) );
		commentForm.addEventListener( 'submit', handleSubmission );
	}
}

export default CommentForm;
