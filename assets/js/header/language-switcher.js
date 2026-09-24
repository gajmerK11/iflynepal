/**
 * Language switcher dropdown.
 *
 * Mirrors navigation.js's toggle pattern: aria-expanded drives the state,
 * Escape and an outside click both close it, and a click on a link inside
 * closes it on the way out.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var root = document.querySelector( '.iflynepal-lang-switch' );

	if ( ! root ) {
		return;
	}

	var toggle = root.querySelector( '.iflynepal-lang-switch__toggle' );
	var list = root.querySelector( '.iflynepal-lang-switch__list' );

	if ( ! toggle || ! list ) {
		return;
	}

	/**
	 * Opens or closes the dropdown and keeps the button's state in sync.
	 *
	 * @param {boolean} open Whether the dropdown should be open.
	 */
	function setOpen( open ) {
		root.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', String( open ) );
		list.hidden = ! open;

		if ( open ) {
			document.addEventListener( 'keydown', onKeydown );
			document.addEventListener( 'click', onOutsideClick );
		} else {
			document.removeEventListener( 'keydown', onKeydown );
			document.removeEventListener( 'click', onOutsideClick );
		}
	}

	/**
	 * Closes the dropdown on Escape and returns focus to the toggle.
	 *
	 * @param {KeyboardEvent} event Key event.
	 */
	function onKeydown( event ) {
		if ( event.key === 'Escape' ) {
			setOpen( false );
			toggle.focus();
		}
	}

	/**
	 * Closes the dropdown when a click lands outside it.
	 *
	 * @param {MouseEvent} event Click event.
	 */
	function onOutsideClick( event ) {
		if ( ! root.contains( event.target ) ) {
			setOpen( false );
		}
	}

	toggle.addEventListener( 'click', function () {
		setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
	} );
}() );
