/**
 * About Nepal index bar: marks which chapter the reader is in.
 *
 * The links themselves are ordinary fragment links and still navigate without
 * this file; what it adds is the "you are here" state, the smooth glide to a
 * clicked chapter, and scrolling the active link into view when the bar is too
 * narrow to show them all.
 *
 * An IntersectionObserver rather than a scroll handler: the question is which
 * chapter is on screen, which is what the observer answers directly, and it
 * costs nothing between crossings.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var bar = document.getElementById( 'iflynepal-country-index' );

	if ( ! bar || ! window.IntersectionObserver ) {
		return;
	}

	var links = Array.prototype.slice.call(
		bar.querySelectorAll( '.iflynepal-country-index__link' )
	);

	if ( ! links.length ) {
		return;
	}

	var byId = {};
	var sections = [];
	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	links.forEach( function ( link ) {
		var id = link.getAttribute( 'href' ).slice( 1 );
		var section = document.getElementById( id );

		if ( ! section ) {
			return;
		}

		byId[ id ] = link;
		sections.push( section );

		/*
		 * A plain fragment link jumps instantly; the whole point of a "you are
		 * here" bar is that moving to a new "here" should be seen. `scrollIntoView`
		 * honours the chapter's own `scroll-margin-top`, so it already clears the
		 * docked header and the bar without any offset math here.
		 */
		link.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			section.scrollIntoView( {
				behavior: reduced ? 'auto' : 'smooth',
				block: 'start'
			} );
		} );
	} );

	var current = null;

	/**
	 * Moves the active mark onto one chapter's link.
	 *
	 * @param {string} id Chapter id.
	 * @return {void}
	 */
	function mark( id ) {
		if ( current === id || ! byId[ id ] ) {
			return;
		}

		current = id;

		links.forEach( function ( link ) {
			link.classList.remove( 'is-here' );
			link.removeAttribute( 'aria-current' );
		} );

		byId[ id ].classList.add( 'is-here' );
		byId[ id ].setAttribute( 'aria-current', 'true' );

		/*
		 * Keep the active link in view on a narrow screen, where the row
		 * scrolls. `nearest` so it only moves when the link is actually off
		 * the edge, and only the bar scrolls — never the page.
		 */
		if ( bar.scrollWidth > bar.clientWidth ) {
			byId[ id ].scrollIntoView( {
				behavior: 'smooth',
				block: 'nearest',
				inline: 'nearest'
			} );
		}
	}

	/*
	 * The band the "current" chapter is decided in: from just under the docked
	 * header and the bar itself, down to the middle of the viewport. A chapter
	 * counts as current once its top reaches that band, which is what a reader
	 * would say too.
	 */
	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					mark( entry.target.id );
				}
			} );
		},
		{ rootMargin: '-140px 0px -50% 0px' }
	);

	sections.forEach( function ( section ) {
		observer.observe( section );
	} );
}() );
