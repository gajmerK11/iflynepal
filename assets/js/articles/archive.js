/**
 * The Articles archive's category tab row.
 *
 * What the design's script does to the row, kept: the white pill behind the
 * current tab is one element that is positioned over it rather than a
 * background on the tab itself, the current tab is scrolled to the middle of
 * the row, and the ends fade while there is more of the row to reach.
 *
 * What the design's script does in place of the server — filtering the grid,
 * paging it, rewriting the headline for a search — is not here. Two of those
 * three are a page load on the install; the third, changing category, is
 * fetched and swapped in by assets/js/articles/filter.js, which hands the new
 * row back to this file by calling the mount below again.
 *
 * Nothing here is required. With this file absent the current tab paints its
 * own pill, under `.post-tabs:not(.has-thumb)` in the stylesheet, and the row
 * scrolls plainly.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var gsap = window.gsap;
	var l10n = window.iflynepalArchiveL10n || { scrollLeft: 'Scroll categories left', scrollRight: 'Scroll categories right' };

	/*
	 * The row in the document right now. filter.js replaces the section these
	 * live in, so every one of them is re-read on each mount and nothing holds
	 * a reference to an element that has left the page.
	 */
	var row = null;
	var wrap = null;
	var thumb = null;
	var tabs = [];

	// The drawn scrollbar: its parts, and the wrap they were built in.
	var bar = null;
	var barTrack = null;
	var barThumb = null;
	var barSteps = [];
	var barWrap = null;
	var stepping = null;

	// How far a chevron moves the row: about one tab.
	var STEP = 180;

	/**
	 * The tab for the category being viewed.
	 *
	 * @return {Element|null} The current tab, or null when none is marked.
	 */
	function current() {
		for ( var i = 0; i < tabs.length; i++ ) {
			if ( tabs[ i ].getAttribute( 'aria-current' ) === 'page' ) {
				return tabs[ i ];
			}
		}

		return null;
	}

	/**
	 * Puts the pill behind the current tab.
	 *
	 * Measured with offsetLeft rather than getBoundingClientRect, so the row's
	 * own scroll position does not enter into it.
	 *
	 * @param {boolean} animate Whether to tween the pill into place.
	 * @return {void}
	 */
	function placeThumb( animate ) {
		var tab = current();

		if ( ! thumb || ! tab ) {
			return;
		}

		if ( gsap ) {
			gsap[ animate && ! reduced ? 'to' : 'set' ]( thumb, {
				x: tab.offsetLeft,
				width: tab.offsetWidth,
				duration: 0.5,
				ease: 'power3.out',
				overwrite: true
			} );

			return;
		}

		thumb.style.transform = 'translateX(' + tab.offsetLeft + 'px)';
		thumb.style.width = tab.offsetWidth + 'px';
	}

	/**
	 * Brings the current tab to the middle of the row.
	 *
	 * Scrolls the row itself rather than calling scrollIntoView, which would
	 * move the page as well.
	 *
	 * @return {void}
	 */
	function centreTab() {
		var tab = current();

		if ( ! tab ) {
			return;
		}

		row.scrollTo( {
			left: Math.max( 0, tab.offsetLeft - ( row.clientWidth - tab.offsetWidth ) / 2 ),
			behavior: 'auto'
		} );
	}

	/**
	 * Fades whichever end of the row still has tabs beyond it, and draws the
	 * scrollbar's thumb at the width and offset the row is scrolled to.
	 *
	 * The capsule is only given the room for a bar while it has more tabs than
	 * fit, so a short category list keeps the design's height exactly.
	 *
	 * @return {void}
	 */
	function edgeFades() {
		if ( ! row ) {
			return;
		}

		var max = row.scrollWidth - row.clientWidth;
		var scrollable = max > 4;

		wrap.classList.toggle( 'has-bar', scrollable );
		wrap.classList.toggle( 'fade-l', row.scrollLeft > 4 );
		wrap.classList.toggle( 'fade-r', row.scrollLeft < max - 4 );

		if ( ! barThumb || ! scrollable ) {
			return;
		}

		var track = barTrack.clientWidth;
		var width = Math.max( 28, track * ( row.clientWidth / row.scrollWidth ) );

		barThumb.style.width = width + 'px';
		barThumb.style.transform = 'translateX(' + ( ( track - width ) * ( row.scrollLeft / max ) ) + 'px)';

		barSteps.forEach( function ( step ) {
			var spent = Number( step.dataset.step ) < 0 ? row.scrollLeft <= 1 : row.scrollLeft >= max - 1;

			step.classList.toggle( 'is-off', spent );
			step.disabled = spent;
		} );
	}

	/**
	 * Moves the row a tab's width in one direction.
	 *
	 * @param {number} direction -1 for left, 1 for right.
	 * @return {void}
	 */
	function stepRow( direction ) {
		row.scrollBy( { left: direction * STEP, behavior: reduced ? 'auto' : 'smooth' } );
	}

	/**
	 * Scrolls the row to wherever along the track was pointed at.
	 *
	 * The point under the cursor is read as the middle of the thumb, which is
	 * what dragging a scrollbar does and what clicking one lands on.
	 *
	 * @param {number} clientX Pointer position.
	 * @return {void}
	 */
	function scrollToPointer( clientX ) {
		var track = barTrack.getBoundingClientRect();
		var width = barThumb.offsetWidth;
		var travel = track.width - width;

		if ( travel <= 0 ) {
			return;
		}

		var at = ( clientX - track.left - width / 2 ) / travel;

		row.scrollLeft = Math.min( 1, Math.max( 0, at ) ) * ( row.scrollWidth - row.clientWidth );
	}

	/**
	 * Builds the drawn scrollbar, once, into whichever wrap is in the document.
	 *
	 * It is put in the wrap rather than in the row: a child of the row would
	 * scroll with the tabs, and this has to stay where it is.
	 *
	 * @return {void}
	 */
	function mountBar() {
		if ( barWrap === wrap ) {
			return;
		}

		bar = wrap.querySelector( '.tab-scroll' );

		if ( ! bar ) {
			bar = document.createElement( 'div' );
			bar.className = 'tab-scroll';
			bar.innerHTML =
				'<button type="button" class="tab-scroll-step" data-step="-1">' +
					'<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>' +
				'</button>' +
				'<span class="tab-scroll-track"><i></i></span>' +
				'<button type="button" class="tab-scroll-step" data-step="1">' +
					'<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>' +
				'</button>';

			wrap.appendChild( bar );
		}

		barTrack = bar.querySelector( '.tab-scroll-track' );
		barThumb = bar.querySelector( '.tab-scroll-track i' );
		barSteps = Array.prototype.slice.call( bar.querySelectorAll( '.tab-scroll-step' ) );
		barWrap = wrap;

		/*
		 * The row is already reachable — every tab is a link in the tab order,
		 * and the row scrolls to whichever one is tabbed to. These two are the
		 * mouse's way of doing the same thing, so they are named for a screen
		 * reader but kept out of the tab order rather than sat in the middle of
		 * the category list as two more stops that lead nowhere new.
		 */
		barSteps.forEach( function ( step ) {
			var direction = Number( step.dataset.step );

			step.tabIndex = -1;
			step.setAttribute(
				'aria-label',
				direction < 0 ? l10n.scrollLeft : l10n.scrollRight
			);

			/*
			 * Held down, a chevron keeps going, the way a scrollbar's arrow
			 * does. The repeat is cleared on pointerup anywhere, not only on
			 * the button, so a pointer released off the edge of it still stops.
			 */
			step.addEventListener( 'pointerdown', function ( event ) {
				event.preventDefault();
				stepRow( direction );

				stepping = window.setInterval( function () {
					stepRow( direction );
				}, 220 );
			} );
		} );

		/*
		 * Pointer events rather than mouse, so a drag works with a trackpad, a
		 * pen and a touch screen alike; the capture keeps the drag alive when
		 * the cursor leaves the 4px track, which at this height it does.
		 */
		barTrack.addEventListener( 'pointerdown', function ( event ) {
			event.preventDefault();
			barTrack.classList.add( 'is-dragging' );
			barTrack.setPointerCapture( event.pointerId );

			// The row is `scroll-behavior:smooth`, which a drag cannot wait for.
			row.style.scrollBehavior = 'auto';

			scrollToPointer( event.clientX );
		} );

		barTrack.addEventListener( 'pointermove', function ( event ) {
			if ( barTrack.classList.contains( 'is-dragging' ) ) {
				scrollToPointer( event.clientX );
			}
		} );

		[ 'pointerup', 'pointercancel' ].forEach( function ( type ) {
			barTrack.addEventListener( type, function () {
				barTrack.classList.remove( 'is-dragging' );
				row.style.scrollBehavior = '';
			} );
		} );
	}

	/**
	 * Takes hold of whichever tab row is in the document.
	 *
	 * Safe to call again after the row has been replaced: the listeners it adds
	 * are on the row itself, which leaves with it.
	 *
	 * @return {void}
	 */
	function mount() {
		row = document.getElementById( 'ifn-archive-tabs' );

		if ( ! row ) {
			tabs = [];

			return;
		}

		wrap = row.parentNode;
		thumb = row.querySelector( '.tab-thumb' );
		tabs = Array.prototype.slice.call( row.querySelectorAll( '.post-tab' ) );

		row.classList.add( 'has-thumb' );
		mountBar();
		placeThumb( false );
		centreTab();
		edgeFades();

		row.addEventListener( 'scroll', edgeFades, { passive: true } );

		/*
		 * The pill leads the tab being moved to. Where the section is swapped
		 * in place this is the whole move, finished by the mount that follows;
		 * where the click is a plain page load it reads as the move beginning,
		 * and the next page places the pill under the new tab.
		 */
		if ( gsap && ! reduced && thumb ) {
			tabs.forEach( function ( tab ) {
				tab.addEventListener( 'click', function () {
					if ( tab.getAttribute( 'aria-current' ) === 'page' ) {
						return;
					}

					gsap.to( thumb, {
						x: tab.offsetLeft,
						width: tab.offsetWidth,
						duration: 0.5,
						ease: 'power3.out',
						overwrite: true
					} );
				} );
			} );
		}
	}

	window.addEventListener( 'resize', function () {
		placeThumb( false );
		edgeFades();
	} );

	// A chevron held down stops wherever the pointer is let go, on it or not.
	[ 'pointerup', 'pointercancel' ].forEach( function ( type ) {
		document.addEventListener( type, function () {
			if ( stepping ) {
				window.clearInterval( stepping );
				stepping = null;
			}
		} );
	} );

	/*
	 * The tabs are measured before the webfont has painted, at which point every
	 * label is a little wider or narrower than it will end up — so the pill and
	 * the centring are taken again once the faces have loaded.
	 */
	if ( document.fonts && document.fonts.ready && document.fonts.ready.then ) {
		document.fonts.ready.then( function () {
			placeThumb( false );
			centreTab();
			edgeFades();
		} ).catch( function () {} );
	}

	mount();

	// How filter.js hands a freshly swapped-in row over.
	window.iflynepalArticleTabs = { mount: mount };
}() );
