/**
 * The article page's own behaviour, ported from the approved design's script:
 * the reading bar, the share menu, the table of contents that follows the
 * reader, and the FAQ blocks opening on the same curve as the rest of the site.
 *
 * The page's motion — hero words, reveals, the header dock — is in
 * assets/js/articles/motion.js beside this.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var hasGsap = typeof window.gsap !== 'undefined';
	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var article = document.querySelector( '.post-content' );

	/* ---------------------------------------------------- reading progress
	   Measured across the post body rather than the whole page, so the bar is
	   full when the last FAQ is read, not when the footer is reached. */
	var bar = document.querySelector( '.read-progress' );

	var drawProgress = function () {
		if ( ! bar || ! article ) {
			return;
		}

		var rect = article.getBoundingClientRect();
		var span = rect.height - window.innerHeight * 0.6;
		var done = span > 0 ? ( window.innerHeight * 0.4 - rect.top ) / span : 0;

		bar.style.transform = 'scaleX(' + Math.min( 1, Math.max( 0, done ) ).toFixed( 4 ) + ')';
	};

	/* -------------------------------------------------- table of contents
	   The entry for the section being read is lit, worked out from scroll
	   position rather than IntersectionObserver so a section taller than the
	   screen still counts, and the index scrolls itself to keep that entry in
	   view. Both copies — the sidebar's and the one above the post on smaller
	   screens — are kept in step. */
	var tocLinks = Array.prototype.slice.call( document.querySelectorAll( '.index-list a' ) );
	var sections = [];

	tocLinks.forEach( function ( link ) {
		var el = document.getElementById( link.getAttribute( 'data-iflynepal-scroll' ) );

		if ( el && sections.indexOf( el ) === -1 ) {
			sections.push( el );
		}
	} );

	var LINE = 120;
	var holdSpy = null;

	var setCurrent = function ( target ) {
		tocLinks.forEach( function ( link ) {
			var on = link.getAttribute( 'data-iflynepal-scroll' ) === target.id;
			var was = link.classList.contains( 'is-current' );

			link.classList.toggle( 'is-current', on );

			if ( on ) {
				link.setAttribute( 'aria-current', 'true' );
			} else {
				link.removeAttribute( 'aria-current' );
			}

			if ( ! on || was ) {
				return;
			}

			var list = link.closest( '.index-list' );

			if ( list && list.scrollHeight > list.clientHeight ) {
				var top = link.offsetTop - list.offsetTop;

				if ( top < list.scrollTop || top + link.offsetHeight > list.scrollTop + list.clientHeight ) {
					list.scrollTo( { top: top - 8, behavior: reduced ? 'auto' : 'smooth' } );
				}
			}
		} );
	};

	var drawSpy = function () {
		if ( ! sections.length || holdSpy ) {
			return;
		}

		var current = sections[ 0 ];

		sections.forEach( function ( section ) {
			if ( section.getBoundingClientRect().top <= LINE ) {
				current = section;
			}
		} );

		// Once the post has been read to its end, the last section is the one.
		if ( article && article.getBoundingClientRect().bottom <= window.innerHeight ) {
			current = sections[ sections.length - 1 ];
		}

		setCurrent( current );
	};

	tocLinks.forEach( function ( link ) {
		link.addEventListener( 'click', function () {
			var target = document.getElementById( link.getAttribute( 'data-iflynepal-scroll' ) );

			if ( ! target ) {
				return;
			}

			// Lit at once, and held while the page glides there.
			setCurrent( target );
			clearTimeout( holdSpy );
			holdSpy = setTimeout( function () {
				holdSpy = null;
				drawSpy();
			}, 900 );
		} );
	} );

	var ticking = false;

	window.addEventListener( 'scroll', function () {
		if ( ticking ) {
			return;
		}

		ticking = true;

		window.requestAnimationFrame( function () {
			ticking = false;
			drawSpy();
			drawProgress();
		} );
	}, { passive: true } );

	window.addEventListener( 'resize', function () {
		drawSpy();
		drawProgress();
	} );

	drawSpy();
	drawProgress();

	/* -------------------------------------------------------- share menu */

	var shareBtn = document.getElementById( 'share-btn' );
	var shareMenu = document.getElementById( 'share-menu' );

	if ( shareBtn && shareMenu ) {
		var items = function () {
			return Array.prototype.slice.call( shareMenu.querySelectorAll( 'a, button' ) );
		};

		/*
		 * Focus only moves into the menu when it was opened from the keyboard;
		 * a pointer click leaves it where it is, so no ring lands on "Copy
		 * link".
		 */
		var openMenu = function ( open, byKey ) {
			shareMenu.classList.toggle( 'is-open', open );
			shareBtn.setAttribute( 'aria-expanded', String( open ) );

			if ( open && byKey ) {
				items()[ 0 ].focus( { preventScroll: true } );
			}
		};

		shareBtn.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			openMenu( ! shareMenu.classList.contains( 'is-open' ), e.detail === 0 );
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( shareMenu.classList.contains( 'is-open' ) && ! shareMenu.contains( e.target ) ) {
				openMenu( false );
			}
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && shareMenu.classList.contains( 'is-open' ) ) {
				openMenu( false );
				shareBtn.focus();
			}
		} );

		shareMenu.addEventListener( 'keydown', function ( e ) {
			if ( e.key !== 'ArrowDown' && e.key !== 'ArrowUp' ) {
				return;
			}

			e.preventDefault();

			var list = items();
			var i = list.indexOf( document.activeElement );

			list[ ( i + ( e.key === 'ArrowDown' ? 1 : list.length - 1 ) ) % list.length ].focus();
		} );

		var copyBtn = document.getElementById( 'share-copy' );

		if ( copyBtn ) {
			var label = copyBtn.querySelector( 'span' );
			var copied = label ? label.getAttribute( 'data-copied' ) : '';
			var idle = label ? label.textContent : '';

			copyBtn.addEventListener( 'click', function () {
				var url = copyBtn.getAttribute( 'data-url' );
				var done = function () {
					label.textContent = copied;
					setTimeout( function () {
						label.textContent = idle;
						openMenu( false );
					}, 1400 );
				};

				if ( navigator.clipboard && navigator.clipboard.writeText ) {
					navigator.clipboard.writeText( url ).then( done, done );
				} else {
					done();
				}
			} );
		}
	}

	/* --------------------------------------------------------------- FAQs
	   Core's Details blocks open on a height tween instead of snapping. The
	   summary still toggles the element natively when there is no GSAP. */
	if ( hasGsap && ! reduced ) {
		var gsap = window.gsap;

		Array.prototype.slice.call( document.querySelectorAll( '.post-faqs details' ) ).forEach( function ( item ) {
			var summary = item.querySelector( 'summary' );

			if ( ! summary ) {
				return;
			}

			var body = document.createElement( 'div' );

			body.className = 'faq-body';

			while ( summary.nextSibling ) {
				body.appendChild( summary.nextSibling );
			}

			item.appendChild( body );

			summary.addEventListener( 'click', function ( e ) {
				e.preventDefault();

				if ( item.hasAttribute( 'open' ) ) {
					gsap.to( body, {
						height: 0,
						opacity: 0,
						duration: 0.38,
						ease: 'power2.inOut',
						overwrite: true,
						onComplete: function () {
							item.removeAttribute( 'open' );
							gsap.set( body, { clearProps: 'height,opacity' } );
							drawSpy();
						}
					} );

					return;
				}

				item.setAttribute( 'open', '' );
				gsap.fromTo(
					body,
					{ height: 0, opacity: 0 },
					{
						height: 'auto',
						opacity: 1,
						duration: 0.45,
						ease: 'power2.out',
						overwrite: true,
						onComplete: function () {
							gsap.set( body, { clearProps: 'height,opacity' } );
							drawSpy();
						}
					}
				);
			} );
		} );
	}
}() );
