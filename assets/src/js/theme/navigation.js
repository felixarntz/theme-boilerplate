/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

class Navigation {
	constructor( containerId, options ) {
		this.container = document.querySelector( '#' + containerId );
		this.options   = options || {};
	}

	initialize() {
		if ( ! this.container ) {
			return;
		}

		const menu   = this.container.querySelector( 'ul.menu' );
		const button = this.container.querySelector( 'button.menu-toggle' );

		this.initializeMenuFocus( menu );
		this.initializeSubmenuFocus( menu );
		this.initializeDropdownMenus( menu );
		this.initializeMenuToggle( button, menu );
	}

	initializeMenuFocus( menu ) {
		let links;

		if ( ! menu ) {
			return;
		}

		if ( ! menu.classList.contains( 'nav-menu' ) ) {
			menu.classList.add( 'nav-menu' );
		}

		function toggleFocus() {
			let element = this;

			while ( ! element.classList.contains( 'nav-menu' ) ) {
				if ( 'li' === element.tagName.toLowerCase() ) {
					element.classList.toggle( 'focus' );
				}

				element = element.parentElement;
			}
		}

		links = menu.getElementsByTagName( 'a' );

		Array.from( links ).forEach( function( link ) {
			link.addEventListener( 'focus', toggleFocus, true );
			link.addEventListener( 'blur', toggleFocus, true );
		});
	}

	initializeSubmenuFocus( menu ) {
		let parentLinks;

		if ( ! menu ) {
			return;
		}

		if ( ! window.ontouchstart ) {
			return;
		}

		function touchStartFocus( e ) {
			const menuItem = this.parentNode;

			let menuItemSiblings;

			if ( ! menuItem.classList.contains( 'focus' ) ) {
				e.preventDefault();

				menuItemSiblings = menuItem.parentNode.children;
				menuItemSiblings.forEach( function( menuItemSibling ) {
					if ( menuItem === menuItemSibling ) {
						return;
					}

					menuItemSibling.classList.remove( 'focus' );
				});

				menuItem.classList.add( 'focus' );
			} else {
				menuItem.classList.remove( 'focus' );
			}
		}

		parentLinks = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		Array.from( parentLinks ).forEach( function( parentLink ) {
			parentLink.addEventListener( 'touchstart', touchStartFocus, false );
		});
	}

	initializeDropdownMenus( menu ) {
		const options = this.options;

		let parentLinks;

		if ( ! menu ) {
			return;
		}

		function toggleDropdownMenu( e ) {
			const screenReaderText = this.getElementsByClassName( 'screen-reader-text' )[0];

			e.preventDefault();

			this.classList.toggle( 'toggled' );
			this.nextElementSibling.classList.toggle( 'toggled' );

			if ( 'false' === this.getAttribute( 'aria-expanded' ) ) {
				this.setAttribute( 'aria-expanded', 'true' );
			} else {
				this.setAttribute( 'aria-expanded', 'false' );
			}

			if ( options.i18n.expand === screenReaderText.textContent ) {
				screenReaderText.textContent = options.i18n.collapse;
			} else {
				screenReaderText.textContent = options.i18n.expand;
			}
		}

		parentLinks = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		Array.from( parentLinks ).forEach( function( parentLink ) {
			const dropdownToggle = document.createElement( 'button' );
			const screenReaderText = document.createElement( 'span' );

			dropdownToggle.classList.add( 'dropdown-toggle' );
			dropdownToggle.innerHTML = options.icon;
			dropdownToggle.appendChild( screenReaderText );

			screenReaderText.classList.add( 'screen-reader-text' );

			if ( parentLink.parentNode.classList.contains( 'current-menu-ancestor' ) ) {
				dropdownToggle.classList.add( 'toggled' );
				dropdownToggle.setAttribute( 'aria-expanded', 'true' );
				screenReaderText.textContent = options.i18n.collapse;

				parentLink.parentNode.getElementsByClassName( 'sub-menu' )[0].classList.add( 'toggled' );
			} else {
				dropdownToggle.setAttribute( 'aria-expanded', 'false' );
				screenReaderText.textContent = options.i18n.expand;
			}

			dropdownToggle.onclick = toggleDropdownMenu;

			if ( parentLink.nextSibling ) {
				parentLink.parentNode.insertBefore( dropdownToggle, parentLink.nextSibling );
			} else {
				parentLink.parentNode.appendChild( dropdownToggle );
			}
		});
	}

	initializeMenuToggle( button, menu ) {
		const container = this.container;

		if ( ! button ) {
			container.classList.add( 'toggled' );
			return;
		}

		if ( ! menu ) {
			button.style.display = 'none';
			return;
		}

		button.onclick = function() {
			const result = container.classList.toggle( 'toggled' );

			if ( result ) {
				button.setAttribute( 'aria-expanded', 'true' );
			} else {
				button.setAttribute( 'aria-expanded', 'false' );
			}
		};
	}
}

export default Navigation;
