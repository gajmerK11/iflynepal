/**
 * Trip-finder picker: keeps the "I want to" summary in step with what is
 * checked, keeps the open checklist inside the hero rather than bleeding
 * into the section below it, and closes the list on an outside click.
 *
 * None of it is load-bearing. The <details>/<summary> element is a real
 * disclosure widget the browser already opens, closes and makes keyboard
 * accessible on its own, and the <form method="get"> it sits in submits and
 * builds ?types[]=… without any of this running — see
 * template-parts/home/hero-section.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

document.addEventListener( 'DOMContentLoaded', function () {
	var picker = document.getElementById( 'iflynepal-hero-finder-types' );

	if ( ! picker ) {
		return;
	}

	var valueEl  = picker.querySelector( '.iflynepal-hero__finder-value' );
	var boxes    = picker.querySelectorAll( 'input[type="checkbox"]' );
	var list     = picker.querySelector( '.iflynepal-hero__finder-list' );
	var heroCopy = document.querySelector( '.iflynepal-hero__copy' );

	if ( ! valueEl || ! boxes.length ) {
		return;
	}

	var placeholder   = valueEl.getAttribute( 'data-placeholder' ) || valueEl.textContent;
	var selectedLabel = ( window.iflynepalHeroFinder && window.iflynepalHeroFinder.selected ) || '%d selected';

	function updateValue() {
		var labels = [];

		boxes.forEach( function ( box ) {
			if ( ! box.checked ) {
				return;
			}

			var label = box.closest( 'label' );

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

	boxes.forEach( function ( box ) {
		box.addEventListener( 'change', updateValue );
	} );

	// Native <details> has no "click outside to close" of its own.
	document.addEventListener( 'click', function ( event ) {
		if ( picker.open && ! picker.contains( event.target ) ) {
			picker.open = false;
		}
	} );

	/*
	 * Keeps the open checklist fully on screen — its bottom edge included —
	 * without a scroll, rather than bleeding past whatever is visible.
	 *
	 * 🔴 The boundary is `window.innerHeight`, the literal visible window,
	 * NOT the hero element's own box. An earlier version measured against
	 * `.iflynepal-hero`'s bounding rect instead, which is wrong for anyone
	 * signed in: WordPress's admin bar pushes `<body>` down 32px
	 * (`margin-top: 32px`, core's own behaviour), so the hero — `min-height:
	 * 100dvh`, i.e. still exactly one window tall — has its BOTTOM edge sitting
	 * 32px below the visible window too. The list could be entirely "inside
	 * the hero" by that measurement and still need a 32px scroll to see its
	 * own bottom edge. window.innerHeight has no such blind spot: it is
	 * always the true visible area, admin bar or any other fixed chrome
	 * included, so this is correct signed out, signed in, or under anything
	 * else that pushes the page down in the future.
	 *
	 * The hero centres its content with plain flex `align-items: center`
	 * (input.css), and the list is `position: absolute` so it never adds to
	 * the hero's own height — which is exactly why it can run past the
	 * bottom of the screen on a short window with nothing pushing back.
	 * There is no fixed pixel value that fixes every screen, so this
	 * measures the actual overflow each time the list opens (and on resize
	 * while it is open) and nudges the WHOLE hero-copy block — title,
	 * actions, proof, the finder itself — up by exactly that much with one
	 * transform, so the list stays exactly as far below the title as it
	 * always is; nothing above it changes shape or spacing, it simply sits a
	 * little higher on a tight screen. transform is used rather than a
	 * margin because it never fights the flex centring that placed the
	 * block in the first place — it moves the result, not the layout that
	 * produced it.
	 */
	function keepListWithinHero() {
		if ( ! list || ! heroCopy ) {
			return;
		}

		var overflow = list.getBoundingClientRect().bottom - window.innerHeight;

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
} );
