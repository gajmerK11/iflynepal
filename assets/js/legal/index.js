/**
 * Legal documents: marks which clause the reader is in, inside the sticky
 * index beside the document.
 *
 * Shared by every page built on the `iflynepal-legal-*` furniture — Terms &
 * Conditions, Cookie, Privacy and Sustainability Policy today — which is why it finds the index by its
 * class rather than by a per-page id. One index per page; the first one found
 * is it.
 *
 * The links are ordinary fragment links and still navigate without this file;
 * what it adds is the "you are here" mark, keeping that entry in view inside
 * the index's own scroller, and a glide to the clause instead of the browser's
 * one-frame jump.
 *
 * ⚠️ A scroll position rather than an IntersectionObserver, unlike the About
 * Nepal index bar (assets/js/about-country/index-bar.js). A clause here can be
 * taller than the viewport — the Terms page's clause 02 is — and while it fills
 * the screen it never crosses an intersection boundary, so an observer leaves
 * it unmarked the whole time it is being read. Asking "which clause has its top
 * above the reading line" answers correctly at any height.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var index = document.querySelector( '.iflynepal-legal-index__list' );

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
		 * A long index does not fit, so it scrolls on its own. Only
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
		 * even though what follows it has pushed its top back above the line.
		 */
		if ( window.innerHeight + window.scrollY >= document.body.scrollHeight - 2 ) {
			reading = clauses[ clauses.length - 1 ];
		}

		mark( reading );
	}

	window.addEventListener(
		'scroll',
		function () {
			if ( ticking || gliding ) {
				return;
			}

			ticking = true;
			window.requestAnimationFrame( update );
		},
		{ passive: true }
	);

	window.addEventListener( 'resize', update );

	/* ----------------------------------------------------------------- glide */

	var header = document.getElementById( 'iflynepal-header' );

	/*
	 * How far below the header a clause comes to rest. It has to stay under
	 * the 24px gap between cards in .iflynepal-legal-body: any more and the
	 * foot of the clause above shows in the strip under the header, which is
	 * exactly what landing on a clause should not do. Matches the sticky
	 * index's resting place, so the two cards line up when the glide stops.
	 *
	 * ⚠️ The CSS scroll-margin-top on .iflynepal-legal-clause and the sticky
	 * top of .iflynepal-legal-index are this same number plus the docked
	 * header (70px), for the no-JavaScript and arrive-by-URL cases. Change
	 * one, change all three.
	 */
	var REST_GAP = 16;

	// Set while the glide runs, so the scroll handler cannot walk the mark
	// through every clause the page passes on the way.
	var gliding = false;
	var frame = 0;

	/**
	 * A clause's distance from the top of the document, as laid out.
	 *
	 * ⚠️ offsetTop, not getBoundingClientRect(). The reveal in
	 * assets/js/sections/reveal.js holds each card 26px low until it scrolls
	 * into view, and a rect measures that transform — so a glide aimed at a
	 * card still waiting to rise stopped 26px past it, and the card then rose
	 * under the header. offsetTop ignores transforms and reads where the card
	 * will settle.
	 *
	 * @param {Element} el The element to measure.
	 * @return {number} Its top edge, in document pixels.
	 */
	function documentTop( el ) {
		var top = 0;

		while ( el ) {
			top += el.offsetTop;
			el = el.offsetParent;
		}

		return top;
	}

	/**
	 * Where the page has to be for this clause to rest under the header.
	 *
	 * Asked afresh on every frame rather than once at the click: the header
	 * shrinks from 92px to 70px as it docks, and it docks during the glide
	 * whenever the reader starts from the top of the page.
	 *
	 * @param {Element} clause The clause being travelled to.
	 * @return {number} The scrollY to end at.
	 */
	function restingY( clause ) {
		var under = header ? header.getBoundingClientRect().bottom : 0;
		var y = documentTop( clause ) - Math.max( under, 0 ) - REST_GAP;
		var max = document.documentElement.scrollHeight - window.innerHeight;

		return Math.min( Math.max( y, 0 ), max );
	}

	/**
	 * Eases in and out, so the page neither lurches off nor slams to a stop.
	 *
	 * @param {number} t Progress, 0 to 1.
	 * @return {number} Eased progress.
	 */
	function easeInOutCubic( t ) {
		return t < 0.5 ? 4 * t * t * t : 1 - Math.pow( -2 * t + 2, 3 ) / 2;
	}

	/**
	 * Ends a glide early when the reader takes the page back.
	 *
	 * @return {void}
	 */
	function abandon() {
		if ( ! gliding ) {
			return;
		}

		window.cancelAnimationFrame( frame );
		gliding = false;
		update();
	}

	[ 'wheel', 'touchstart', 'keydown', 'mousedown' ].forEach( function ( type ) {
		window.addEventListener( type, abandon, { passive: true } );
	} );

	/**
	 * Scrolls the page to one clause.
	 *
	 * A hand-rolled tween rather than scrollIntoView({ behavior: 'smooth' }):
	 * the browser's smooth scroll fixes its destination when it starts, so the
	 * header docking part-way through leaves the clause 22px off where it was
	 * meant to stop, and its duration cannot be set.
	 *
	 * @param {Element} clause The clause to bring into view.
	 * @return {void}
	 */
	function glideTo( clause ) {
		window.cancelAnimationFrame( frame );

		var from = window.scrollY;
		var distance = Math.abs( restingY( clause ) - from );

		if ( reduced || distance < 2 ) {
			window.scrollTo( 0, restingY( clause ) );
			return;
		}

		// Longer trips take longer, within bounds: a neighbour is a flick, the
		// far end of the document still arrives in about a second.
		var duration = Math.min( 1100, Math.max( 520, distance * 0.45 ) );
		var start = null;

		gliding = true;

		frame = window.requestAnimationFrame( function step( now ) {
			if ( null === start ) {
				start = now;
			}

			var progress = Math.min( ( now - start ) / duration, 1 );

			window.scrollTo( 0, from + ( restingY( clause ) - from ) * easeInOutCubic( progress ) );

			if ( progress < 1 ) {
				frame = window.requestAnimationFrame( step );
				return;
			}

			gliding = false;
		} );
	}

	/*
	 * Clicking an entry marks it at once rather than waiting for the scroll,
	 * then glides there. The address still gains the fragment, so the link a
	 * reader copies afterwards opens on that clause.
	 */
	links.forEach( function ( link ) {
		link.addEventListener( 'click', function ( event ) {
			var id = link.getAttribute( 'href' ).slice( 1 );
			var clause = document.getElementById( id );

			if ( ! clause ) {
				return;
			}

			event.preventDefault();
			mark( clause );
			glideTo( clause );

			if ( window.history && window.history.pushState ) {
				window.history.pushState( null, '', '#' + id );
			}

			/*
			 * Keyboard and screen-reader users are carried to the clause as
			 * well, as the plain fragment link would have done. preventScroll,
			 * or the focus call would jump the page and cut the glide short.
			 */
			if ( ! clause.hasAttribute( 'tabindex' ) ) {
				clause.setAttribute( 'tabindex', '-1' );
			}

			clause.focus( { preventScroll: true } );
		} );
	} );

	update();
}() );
