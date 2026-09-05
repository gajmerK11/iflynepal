/**
 * Back-to-top button.
 *
 * The button ships hidden and is only revealed once the page has been scrolled
 * past the hero and a little way into the sections below it, so it never sits
 * on screen as a control that does nothing. With JavaScript off it stays
 * hidden, which is the right answer: nothing would be listening for the click.
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

	/*
	 * How far down the button appears, measured in viewports rather than in
	 * pixels.
	 *
	 * CloudColleague uses a flat 400px, which does not travel to this theme:
	 * the hero fills the whole viewport, so 400px is still inside it on every
	 * screen, and the button arrived over the headline before the visitor had
	 * reached any content. One and a half viewports clears the hero and lands a
	 * little way into the sections below it.
	 *
	 * Read on each update rather than cached, so rotating a phone or resizing a
	 * window re-measures without a listener of its own — innerHeight is cheap,
	 * and this only runs on an animation frame.
	 */
	var showAfterViewports = 1.5;
	var ticking = false;

	/**
	 * Shows or hides the button for the current scroll position.
	 *
	 * @return {void}
	 */
	function update() {
		ticking = false;
		button.hidden = window.scrollY <= window.innerHeight * showAfterViewports;
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
