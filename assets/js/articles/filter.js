/**
 * Changing category without rebuilding the page around it.
 *
 * A category tab is a link to a term archive and a page number is a link to a
 * paged URL — both are real URLs, and with this file absent both are followed
 * as plain page loads and the archive works exactly as before. What this adds
 * is that following one in place: the section holding the tabs, the grid and
 * the pager is fetched, that one section is swapped for the one that came
 * back, and the URL is pushed onto the history.
 *
 * The point of it is the hero. On a page load the headline stages itself in a
 * word at a time and the still begins its drift again, which is right the first
 * time an archive is opened and wrong on every category change after it — the
 * visitor is a few feet down the page changing a filter, not arriving. Swapping
 * one section leaves the hero, its entrance and the scroll position alone.
 *
 * Everything the server decides is still decided by the server: the markup that
 * lands here was rendered by the same template as a full page load, so the
 * query, the per-page count, the pill's tab and the pager's shape all come back
 * already correct. Nothing here filters anything.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var SECTION_ID = 'articles';

	var section = document.getElementById( SECTION_ID );

	if ( ! section || ! window.fetch || ! window.DOMParser || ! window.history.pushState ) {
		return;
	}

	var gsap = window.gsap;
	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var parser = new DOMParser();
	var pending = null;

	/**
	 * Whether a URL is one this page can swap to.
	 *
	 * Same origin, and the same path root the archive lives under — anything
	 * else is left to the browser.
	 *
	 * @param {string} href Link target.
	 * @return {boolean}
	 */
	function swappable( href ) {
		var url;

		try {
			url = new URL( href, window.location.href );
		} catch ( e ) {
			return false;
		}

		return url.origin === window.location.origin
			&& url.href !== window.location.href;
	}

	/**
	 * Reveals whatever has just been put into the page.
	 *
	 * The cards carry `[data-anim]`, which `.gsap-ready [data-anim]` holds at
	 * zero opacity until motion.js tweens it — and motion.js has already run its
	 * batch over the elements that were here at load. Without this the swapped-in
	 * grid would be in the page and invisible.
	 *
	 * @param {Element} el The section that was swapped in.
	 * @return {void}
	 */
	function reveal( el ) {
		var items = el.querySelectorAll( '[data-anim]' );

		if ( ! gsap || ! document.documentElement.classList.contains( 'gsap-ready' ) ) {
			return;
		}

		if ( reduced ) {
			gsap.set( items, { opacity: 1, y: 0, clearProps: 'transform' } );

			return;
		}

		gsap.fromTo(
			items,
			{ opacity: 0, y: 18 },
			{
				opacity: 1,
				y: 0,
				duration: 0.5,
				stagger: 0.05,
				overwrite: true,
				clearProps: 'transform'
			}
		);
	}

	/**
	 * Puts a fetched section into the page in place of the one showing.
	 *
	 * @param {Document} doc    The parsed response.
	 * @param {boolean}  scroll Whether to bring the section's top into view.
	 * @return {void}
	 */
	function swap( doc, scroll ) {
		var next = doc.getElementById( SECTION_ID );

		if ( ! next ) {
			return;
		}

		var onTab = document.activeElement && document.activeElement.closest
			&& document.activeElement.closest( '.post-tab' );

		section.replaceWith( next );
		section = next;

		if ( doc.title ) {
			document.title = doc.title;
		}

		/*
		 * The body class differs between the post type archive and a term
		 * archive, and the stylesheet is entitled to use either.
		 */
		if ( doc.body && doc.body.className ) {
			document.body.className = doc.body.className;
		}

		if ( window.iflynepalArticleTabs ) {
			window.iflynepalArticleTabs.mount();
		}

		reveal( section );

		if ( window.ScrollTrigger ) {
			window.ScrollTrigger.refresh();
		}

		// Keyboard focus was on a tab that has just been thrown away.
		if ( onTab ) {
			var tab = section.querySelector( '.post-tab[aria-current="page"]' );

			if ( tab ) {
				tab.focus( { preventScroll: true } );
			}
		}

		if ( scroll ) {
			window.scrollTo( {
				top: section.getBoundingClientRect().top + window.scrollY - 90,
				behavior: reduced ? 'auto' : 'smooth'
			} );
		}
	}

	/**
	 * Fetches a URL and swaps its archive section in.
	 *
	 * On any failure the browser is sent to the URL instead, so a dropped
	 * connection or a redirect ends up where the link said rather than nowhere.
	 *
	 * @param {string}  href   URL to load.
	 * @param {boolean} push   Whether to add a history entry.
	 * @param {boolean} scroll Whether to scroll to the section afterwards.
	 * @return {void}
	 */
	function load( href, push, scroll ) {
		if ( pending ) {
			pending.abort();
		}

		pending = new AbortController();
		section.classList.add( 'is-swapping' );
		section.setAttribute( 'aria-busy', 'true' );

		window.fetch( href, {
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' },
			signal: pending.signal
		} )
			.then( function ( response ) {
				if ( ! response.ok ) {
					throw new Error( response.status );
				}

				return response.text();
			} )
			.then( function ( html ) {
				pending = null;

				if ( push ) {
					window.history.pushState( { iflynepalArchive: true }, '', href );
				}

				swap( parser.parseFromString( html, 'text/html' ), scroll );
			} )
			.catch( function ( error ) {
				if ( error && 'AbortError' === error.name ) {
					return;
				}

				pending = null;
				window.location.href = href;
			} )
			.finally( function () {
				if ( ! pending ) {
					section.classList.remove( 'is-swapping' );
					section.removeAttribute( 'aria-busy' );
				}
			} );
	}

	/*
	 * Delegated from the document, because the links live inside the section
	 * that is replaced — binding to them directly would last one swap.
	 */
	document.addEventListener( 'click', function ( event ) {
		if ( event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ) {
			return;
		}

		var link = event.target.closest && event.target.closest( '.post-tab, .post-pagination a' );

		if ( ! link || ! section.contains( link ) || link.target || link.hasAttribute( 'download' ) ) {
			return;
		}

		if ( link.getAttribute( 'aria-current' ) === 'page' || ! swappable( link.href ) ) {
			return;
		}

		event.preventDefault();

		// A category change is read where the visitor already is; a page change
		// replaces what they were reading, so it takes them back to the top.
		load( link.href, true, link.classList.contains( 'post-tab' ) === false );
	} );

	window.addEventListener( 'popstate', function () {
		load( window.location.href, false, false );
	} );

	/* ----------------------------------------------------- the search field */

	/*
	 * The cross inside the search field is the browser's own, and clearing the
	 * field is all it does — which leaves a visitor looking at an empty box and
	 * a page still filtered by what used to be in it. The `search` event is what
	 * that cross fires (and Escape with it), so an emptied field on a page that
	 * is a search does what the Clear search button beside it does.
	 */
	var input = document.getElementById( 'ifn-search-input' );

	if ( input && input.defaultValue ) {
		input.addEventListener( 'search', function () {
			if ( '' !== input.value ) {
				return;
			}

			var form = input.form;

			window.location.href = form && form.action ? form.action : window.location.pathname;
		} );
	}
}() );
