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

	/*
	 * Mirrors the @media (max-width: 899px) breakpoint in input.css where the
	 * panel switches from the floating, hover-shown card to the in-line
	 * accordion. Only the accordion measures itself in JS — see setOpen().
	 */
	function isAccordionMode() {
		return window.matchMedia( '(max-width: 899px)' ).matches;
	}

	/**
	 * Opens or closes one dropdown.
	 *
	 * The accordion (narrow screens) has no intrinsic open height in CSS — it
	 * is driven by max-height, set here from the panel's own scrollHeight
	 * rather than a fixed guess. A fixed cap large enough for every menu left
	 * most of the collapse transition animating past empty space before the
	 * real content height was even reached, which is what made it look
	 * instant; measuring it means expand and collapse cover the same
	 * distance and the CSS transition plays out over its full duration both
	 * ways.
	 *
	 * The floating desktop card is the opposite case: it is never sized by
	 * max-height, only shown or hidden by opacity/visibility, so an inline
	 * max-height left over from a narrower viewport (this runs again on
	 * resize, nothing reloads it) would do nothing but clip its own
	 * background and border out from under the links sitting on top of it.
	 * Clearing the property back out is what keeps the two modes from
	 * bleeding into each other.
	 *
	 * @param {HTMLElement} item The nav item.
	 * @param {boolean}     open Whether it should be open.
	 * @return {void}
	 */
	function setOpen( item, open ) {
		var trigger = item.querySelector( '.iflynepal-nav-trigger' );
		var panel = item.querySelector( '.iflynepal-nav-panel' );

		item.classList.toggle( 'is-open', open );

		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', String( open ) );
		}

		if ( panel ) {
			panel.style.maxHeight = isAccordionMode()
				? ( open ? panel.scrollHeight + 'px' : '0px' )
				: '';
		}

		/*
		 * `:focus-within` is what keeps the panel open for a keyboard user
		 * (see the @media (min-width: 900px) rule in input.css). A mouse click
		 * on the trigger focuses it too, so without this, closing here only
		 * strips the `is-open` class — the trigger is still focused, so
		 * `:focus-within` alone keeps the panel visible and every "close"
		 * (outside click, Escape, another trigger) does nothing visible.
		 */
		if ( ! open && item.contains( document.activeElement ) ) {
			document.activeElement.blur();
		}
	}

	/**
	 * Closes every dropdown except the one passed, if any.
	 *
	 * Also force-closes them — see the click handler below for why a plain
	 * setOpen( item, false ) is not enough on a pointer device.
	 *
	 * @param {HTMLElement|null} except The one to leave alone.
	 * @return {void}
	 */
	function closeAll( except ) {
		items.forEach( function ( item ) {
			if ( item !== except ) {
				item.classList.add( 'force-closed' );
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

			/*
			 * A click and a hover both show the same panel with the same
			 * :hover / :is-open rules, so a closing click still has the
			 * mouse sitting right on the trigger — :hover is still true and
			 * would keep the panel up through its own rule. force-closed is
			 * a CSS-side veto for exactly that moment (see input.css); it is
			 * only ever set here, on a real click, and cleared the instant
			 * the pointer leaves or lands on the trigger again, so it never
			 * touches a plain hover open or close.
			 */
			item.classList.toggle( 'force-closed', ! open );
			setOpen( item, open );
		} );

		// A fresh hover always wins over whatever the last click left behind.
		item.addEventListener( 'mouseenter', function () {
			item.classList.remove( 'force-closed' );
		} );

		/*
		 * A click-opened panel used to stay open until a second click,
		 * unlike a hover-opened one — hover has no such rule, it just closes
		 * the moment the pointer leaves. Closing here too on mouseleave
		 * makes click behave the same way instead of two different rules for
		 * two ways of opening it. Clearing force-closed resets the item so
		 * the next hover — on this hover cycle or the next one — is judged
		 * on its own, not by how the panel was last closed.
		 */
		item.addEventListener( 'mouseleave', function () {
			item.classList.remove( 'force-closed' );
			setOpen( item, false );
		} );

		// Tabbing onto the trigger is its own open, not a leftover click-close.
		trigger.addEventListener( 'focus', function () {
			item.classList.remove( 'force-closed' );
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
