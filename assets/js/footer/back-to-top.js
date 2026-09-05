/**
 * Back-to-top button.
 *
 * The button ships hidden and is only revealed once the page has been scrolled
 * far enough for it to have a job, so it never sits on screen as a control that
 * does nothing. With JavaScript off it stays hidden, which is the right answer:
 * nothing would be listening for the click.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var button = document.getElementById( 'iflynepal-back-to-top' );

	if ( ! button ) {
		return;
	}

	// Roughly half a viewport: far enough that the top is genuinely out of
	// reach, near enough that the button arrives before it is wanted.
	var showAfter = 400;
	var ticking = false;

	/**
	 * Shows or hides the button for the current scroll position.
	 *
	 * @return {void}
	 */
	function update() {
		ticking = false;
		button.hidden = window.scrollY <= showAfter;
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

	button.addEventListener( 'click', function () {
		var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		window.scrollTo( {
			top: 0,
			behavior: reduced ? 'auto' : 'smooth'
		} );
	} );

	// The page can load part-scrolled, on a refresh or a fragment link.
	update();
}() );
