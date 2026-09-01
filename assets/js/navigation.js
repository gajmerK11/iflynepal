/**
 * Primary navigation toggle.
 *
 * Kept out of the hero bundle so every template gets a working mobile menu
 * without loading the animation library.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var toggle = document.getElementById( 'iflynepal-menu-toggle' );
	var nav = document.getElementById( 'iflynepal-nav' );

	if ( ! toggle || ! nav ) {
		return;
	}

	/**
	 * Opens or closes the panel and keeps the button's state in sync.
	 *
	 * @param {boolean} open Whether the panel should be open.
	 */
	function setOpen( open ) {
		nav.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', String( open ) );
		toggle.setAttribute(
			'aria-label',
			open ? toggle.dataset.labelClose : toggle.dataset.labelOpen
		);

		if ( open ) {
			document.addEventListener( 'keydown', onKeydown );
		} else {
			document.removeEventListener( 'keydown', onKeydown );
		}
	}

	/**
	 * Closes the panel on Escape and returns focus to the toggle.
	 *
	 * @param {KeyboardEvent} event Key event.
	 */
	function onKeydown( event ) {
		if ( event.key === 'Escape' ) {
			setOpen( false );
			toggle.focus();
		}
	}

	toggle.addEventListener( 'click', function () {
		setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	// Delegated: any link inside the panel closes it on the way out.
	nav.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( 'a' ) ) {
			setOpen( false );
		}
	} );
}() );
