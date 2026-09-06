/**
 * Primary navigation dropdowns.
 *
 * On a wide screen the panel also opens on hover, which is CSS — this file is
 * what makes it work by keyboard and by touch, where there is no hover to
 * speak of. The trigger is a button, so it is reachable and operable either
 * way; all that is added here is the open state, and closing again.
 *
 * With this file absent the panels stay shut on touch, and the CSS hover rule
 * still opens them on a pointer device.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var nav = document.getElementById( 'iflynepal-nav' );

	if ( ! nav ) {
		return;
	}

	var items = Array.prototype.slice.call(
		nav.querySelectorAll( '.iflynepal-nav-item' )
	);

	if ( ! items.length ) {
		return;
	}

	/**
	 * Opens or closes one dropdown.
	 *
	 * @param {HTMLElement} item The nav item.
	 * @param {boolean}     open Whether it should be open.
	 * @return {void}
	 */
	function setOpen( item, open ) {
		var trigger = item.querySelector( '.iflynepal-nav-trigger' );

		item.classList.toggle( 'is-open', open );

		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', String( open ) );
		}
	}

	/**
	 * Closes every dropdown except the one passed, if any.
	 *
	 * @param {HTMLElement|null} except The one to leave alone.
	 * @return {void}
	 */
	function closeAll( except ) {
		items.forEach( function ( item ) {
			if ( item !== except ) {
				setOpen( item, false );
			}
		} );
	}

	items.forEach( function ( item ) {
		var trigger = item.querySelector( '.iflynepal-nav-trigger' );

		if ( ! trigger ) {
			return;
		}

		trigger.addEventListener( 'click', function () {
			var open = 'true' !== trigger.getAttribute( 'aria-expanded' );

			closeAll( item );
			setOpen( item, open );
		} );
	} );

	// A click anywhere else closes whatever is open.
	document.addEventListener( 'click', function ( event ) {
		if ( ! event.target.closest( '.iflynepal-nav-item' ) ) {
			closeAll( null );
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' !== event.key ) {
			return;
		}

		var open = nav.querySelector( '.iflynepal-nav-item.is-open' );

		if ( ! open ) {
			return;
		}

		var trigger = open.querySelector( '.iflynepal-nav-trigger' );

		closeAll( null );

		if ( trigger ) {
			trigger.focus();
		}
	} );

	/*
	 * Tabbing out of a panel closes it. Checked on the next tick because at the
	 * moment focus leaves, the element receiving it is not yet focused.
	 */
	nav.addEventListener( 'focusout', function () {
		window.setTimeout( function () {
			items.forEach( function ( item ) {
				if ( ! item.contains( document.activeElement ) ) {
					setOpen( item, false );
				}
			} );
		}, 0 );
	} );
}() );
