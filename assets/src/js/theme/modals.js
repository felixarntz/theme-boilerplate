/**
 * File modals.js.
 *
 * Handles modals in an accessible way.
 */

class Modals {
	constructor( selector, options ) {
		this.modals  = Array.from( document.querySelectorAll( selector ) );
		this.options = options || {};
	}

	initialize() {
		if ( ! this.modals.length ) {
			return;
		}

		this.initializeModalOpenButtons();
		this.initializeModalCloseButtons();
		this.initializeModalEscape();
		this.initializeModalTraps();
	}

	initializeModalOpenButtons() {
		const open = this.openModal;

		this.modals.forEach( modal => {
			const openButtons = Array.from( document.querySelectorAll( '[data-toggle="modal"][data-target="#' + modal.getAttribute( 'id' ) + '"]' ) );

			function listenToOpen() {
				const id = this.getAttribute( 'id' );

				if ( id && id.length ) {
					modal.dataset.lastTrigger = '#' + id;
				}

				open( modal );
			}

			openButtons.forEach( button => {
				button.addEventListener( 'click', listenToOpen );
			});
		});
	}

	initializeModalCloseButtons() {
		const close = this.closeModal;

		this.modals.forEach( modal => {
			const closeButtons = Array.from( modal.querySelectorAll( '[data-dismiss="modal"]' ) );

			function listenToClose() {
				close( modal );

				if ( modal.dataset.lastTrigger ) {
					delete modal.dataset.lastTrigger;
				}
			}

			closeButtons.forEach( button => {
				button.addEventListener( 'click', listenToClose );
			});
		});
	}

	initializeModalEscape() {
		const close = this.closeModal;

		this.modals.forEach( modal => {
			modal.addEventListener( 'keyup', event => {
				if ( 27 === ( event.keyCode || event.which ) ) {
					close( modal );
				}
			});
		});
	}

	initializeModalTraps() {
		this.modals.forEach( modal => {
			const content        = modal.querySelector( '[role="document"]' );
			const focusables     = Array.from( modal.querySelectorAll( 'button, input, textarea, select' ) );
			const firstFocusable = focusables.length ? focusables[0] : undefined;
			const lastFocusable  = focusables.length ? focusables[ focusables.length - 1 ] : undefined;

			if ( firstFocusable ) {
				firstFocusable.addEventListener( 'keydown', event => {
					if ( event.shiftKey && 9 === ( event.keyCode || event.which ) ) {
						content.focus();
						event.preventDefault();
					}
				});
			}

			if ( lastFocusable ) {
				lastFocusable.addEventListener( 'keydown', event => {
					if ( ! event.shiftKey && 9 === ( event.keyCode || event.which ) ) {
						content.focus();
						event.preventDefault();
					}
				});
			}
		});
	}

	openModal( modal ) {
		const focusable = modal.querySelector( 'button, input, textarea, select' );

		modal.setAttribute( 'aria-hidden', 'false' );

		if ( focusable ) {
			focusable.focus();
		}
	}

	closeModal( modal ) {
		const trigger = modal.dataset.lastTrigger;

		modal.setAttribute( 'aria-hidden', 'true' );

		if ( trigger ) {
			document.querySelector( trigger ).focus();
		}
	}
}

export default Modals;
