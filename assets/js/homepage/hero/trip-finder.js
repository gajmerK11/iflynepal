/**
 * Trip-finder pickers: keeps each summary in step with what is checked,
 * keeps the open list inside the hero rather than bleeding into the section
 * below it, and closes a list on an outside click.
 *
 * Drives both fields in the picker — "I want to" (checkboxes, several types
 * at once) and "I have" (radios, one duration) — from the one loop: neither
 * needs anything the other doesn't, once "close this field when a radio is
 * picked" is the one place they differ.
 *
 * None of it is load-bearing. <details>/<summary> is a real disclosure
 * widget the browser already opens, closes and makes keyboard accessible on
 * its own (their shared name="iflynepal-hero-finder-picker" is what keeps
 * only one open at a time, natively, with no JS at all), and the <form
 * method="get"> they sit in submits and builds ?types[]=…&days=… without any
 * of this running — see template-parts/home/hero-section.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

document.addEventListener( 'DOMContentLoaded', function () {
	var form = document.getElementById( 'iflynepal-hero-finder' );

	if ( ! form ) {
		return;
	}

	var pickers  = form.querySelectorAll( 'details.iflynepal-hero__finder-field' );
	var heroCopy = document.querySelector( '.iflynepal-hero__copy' );
	var heroEl   = document.querySelector( '.iflynepal-hero' );

	if ( ! pickers.length ) {
		return;
	}

	var selectedLabel = ( window.iflynepalHeroFinder && window.iflynepalHeroFinder.selected ) || '%d selected';

	pickers.forEach( function ( picker ) {
		var valueEl = picker.querySelector( '.iflynepal-hero__finder-value' );
		var inputs  = picker.querySelectorAll( 'input[type="checkbox"], input[type="radio"]' );
		var list    = picker.querySelector( '.iflynepal-hero__finder-list' );

		if ( ! valueEl || ! inputs.length ) {
			return;
		}

		var placeholder = valueEl.getAttribute( 'data-placeholder' ) || valueEl.textContent;

		// A radio group is one choice: picking it is "done", so the panel closes.
		var isSingleChoice = 'radio' === inputs[ 0 ].type;

		function updateValue() {
			var labels = [];

			inputs.forEach( function ( input ) {
				if ( ! input.checked ) {
					return;
				}

				var label = input.closest( 'label' );

				if ( label ) {
					labels.push( label.textContent.trim() );
				}
			} );

			if ( 0 === labels.length ) {
				valueEl.textContent = placeholder;
			} else if ( 1 === labels.length ) {
				valueEl.textContent = labels[ 0 ];
			} else {
				valueEl.textContent = selectedLabel.replace( '%d', labels.length );
			}
		}

		inputs.forEach( function ( input ) {
			input.addEventListener( 'change', function () {
				updateValue();

				if ( isSingleChoice ) {
					picker.open = false;
				}
			} );
		} );

		// Native <details> has no "click outside to close" of its own.
		document.addEventListener( 'click', function ( event ) {
			if ( picker.open && ! picker.contains( event.target ) ) {
				picker.open = false;
			}
		} );

		/*
		 * Keeps the open list fully on screen AND fully inside the hero
		 * section, whichever edge is nearer — never past the visible window,
		 * and never past the hero's own bottom into whatever comes after it.
		 *
		 * Neither edge alone is enough on its own:
		 *
		 * - Signed in, not scrolled: WordPress's admin bar pushes <body> down
		 *   32px (`margin-top: 32px`, core's own behaviour), so the hero —
		 *   `min-height: 100dvh`, i.e. still exactly one window tall — has its
		 *   own bottom edge sitting 32px below the visible window. Clamping to
		 *   the hero's rect alone would let the list sit 32px into that
		 *   overhang, which is off-screen and needs a scroll to see even
		 *   though the list is technically "inside the hero".
		 * - Scrolled down, hero partly gone: the hero's bottom edge has moved
		 *   up the screen, but the browser's visible window is exactly as
		 *   tall as ever. Clamping to window.innerHeight alone (the fix for
		 *   the bug above) stops tracking that the hero's edge is now
		 *   somewhere well above the bottom of the window — the list would
		 *   happily overflow past the hero into the section below it, which
		 *   is the bug this replaced.
		 *
		 * Math.min of the two is correct in both situations at once, and in
		 * between: whichever edge is currently the tighter constraint wins.
		 *
		 * The hero centres its content with plain flex `align-items: center`
		 * (input.css), and the list is `position: absolute` so it never adds to
		 * the hero's own height — which is exactly why it can run past either
		 * boundary on a short window with nothing pushing back. There is no
		 * fixed pixel value that fixes every screen or scroll position, so this
		 * measures the actual overflow each time the list opens (and on resize
		 * or scroll while it is open) and nudges the WHOLE hero-copy block —
		 * title, actions, proof, the finder itself — up by exactly that much
		 * with one transform, so the list stays exactly as far below the title
		 * as it always is; nothing above it changes shape or spacing, it simply
		 * sits a little higher when either edge is close. transform is used
		 * rather than a margin because it never fights the flex centring that
		 * placed the block in the first place — it moves the result, not the
		 * layout that produced it.
		 */
		function keepListWithinHero() {
			if ( ! list || ! heroCopy ) {
				return;
			}

			var limit = window.innerHeight;

			if ( heroEl ) {
				limit = Math.min( limit, heroEl.getBoundingClientRect().bottom );
			}

			var overflow = list.getBoundingClientRect().bottom - limit;

			// A little clearance even when it technically already fits.
			var BUFFER = 16;

			heroCopy.style.transform = overflow > -BUFFER ? 'translateY(-' + Math.ceil( overflow + BUFFER ) + 'px)' : '';
		}

		function resetHeroPosition() {
			if ( heroCopy ) {
				heroCopy.style.transform = '';
			}
		}

		picker.addEventListener( 'toggle', function () {
			if ( picker.open ) {
				keepListWithinHero();
			} else {
				resetHeroPosition();
			}
		} );

		window.addEventListener( 'resize', function () {
			if ( picker.open ) {
				keepListWithinHero();
			}
		} );

		// The hero's own bottom edge moves with the page, not just the window.
		window.addEventListener(
			'scroll',
			function () {
				if ( picker.open ) {
					keepListWithinHero();
				}
			},
			{ passive: true }
		);
	} );
} );
