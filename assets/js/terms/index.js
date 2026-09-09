/**
 * Terms & Conditions: marks which clause the reader is in, inside the sticky
 * index beside the document.
 *
 * The links are ordinary fragment links and still navigate without this file;
 * what it adds is the "you are here" mark and keeping that entry in view inside
 * the index's own scroller.
 *
 * ⚠️ A scroll position rather than an IntersectionObserver, unlike the About
 * Nepal index bar (assets/js/about-country/index-bar.js). A clause here can be
 * taller than the viewport — clause 02 is — and while it fills the screen it
 * never crosses an intersection boundary, so an observer leaves it unmarked the
 * whole time it is being read. Asking "which clause has its top above the
 * reading line" answers correctly at any height.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var index = document.getElementById( 'iflynepal-terms-index' );

	if ( ! index ) {
		return;
	}

	var links = Array.prototype.slice.call(
		index.querySelectorAll( '.iflynepal-legal-index__link' )
	);

	if ( ! links.length ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var clauses = [];
	var byId = {};

	links.forEach( function ( link ) {
		var id = link.getAttribute( 'href' ).slice( 1 );
		var clause = document.getElementById( id );

		if ( ! clause ) {
			return;
		}

		byId[ id ] = link;
		clauses.push( clause );
	} );

	if ( ! clauses.length ) {
		return;
	}

	var current = null;

	/**
	 * Moves the mark onto one clause's entry, and scrolls the index to it.
	 *
	 * @param {Element} clause The clause being read.
	 * @return {void}
	 */
	function mark( clause ) {
		if ( current === clause.id || ! byId[ clause.id ] ) {
			return;
		}

		current = clause.id;

		links.forEach( function ( link ) {
			link.classList.remove( 'is-here' );
			link.removeAttribute( 'aria-current' );
		} );

		var link = byId[ clause.id ];

		link.classList.add( 'is-here' );
		link.setAttribute( 'aria-current', 'true' );

		/*
		 * Fourteen entries do not all fit, so the index scrolls on its own. Only
		 * nudge it when the active entry is actually outside it — and only the
		 * index, never the page, which is why this is arithmetic on scrollTop
		 * rather than scrollIntoView.
		 */
		if ( index.scrollHeight <= index.clientHeight ) {
			return;
		}

		var top = link.offsetTop - index.offsetTop;

		if ( top < index.scrollTop || top + link.offsetHeight > index.scrollTop + index.clientHeight ) {
			index.scrollTo( {
				top: top - 8,
				behavior: reduced ? 'auto' : 'smooth'
			} );
		}
	}

	var ticking = false;

	/**
	 * Finds the clause being read and marks it.
	 *
	 * @return {void}
	 */
	function update() {
		ticking = false;

		// Just under the docked header, where a reader's eye actually is.
		var line = 140;
		var reading = clauses[ 0 ];

		clauses.forEach( function ( clause ) {
			if ( clause.getBoundingClientRect().top <= line ) {
				reading = clause;
			}
		} );

		/*
		 * At the very bottom of the page the last clause is the one being read,
		 * even though the closing card has pushed its top back above the line.
		 */
		if ( window.innerHeight + window.scrollY >= document.body.scrollHeight - 2 ) {
			reading = clauses[ clauses.length - 1 ];
		}

		mark( reading );
	}

	window.addEventListener(
		'scroll',
		function () {
			if ( ticking ) {
				return;
			}

			ticking = true;
			window.requestAnimationFrame( update );
		},
		{ passive: true }
	);

	window.addEventListener( 'resize', update );

	// Clicking an entry marks it at once rather than waiting for the scroll.
	links.forEach( function ( link ) {
		link.addEventListener( 'click', function () {
			var clause = document.getElementById( link.getAttribute( 'href' ).slice( 1 ) );

			if ( clause ) {
				mark( clause );
			}
		} );
	} );

	update();
}() );
