/**
 * Shrinks the single article/news hero's headline to whatever font-size — up
 * to the CSS clamp()'s own ceiling — keeps it inside two lines.
 *
 * The clamp() in articles.css/news.css sizes the headline for the viewport,
 * not for the title's own length: a short title sits well inside two lines at
 * that size, but a long one ("Why Remote Himalayan Villages Are Perfect for
 * Mindful Living Experiences?") ran to four. There is no way to ask CSS alone
 * for "the largest size that still fits N lines" — line count is exactly the
 * one thing font-size and text-wrap interact to produce, which is why this
 * has to measure.
 *
 * Runs before assets/js/articles/motion.js registers this script as a
 * dependency for (both are enqueued together in inc/enqueue.php), so the
 * headline is already at its fitted size by the time that script's GSAP
 * timeline reads its word spans' positions for the entrance stagger — sizing
 * it after would mean animating from the wrong offsets.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var heading = document.getElementById( 'hero-title' );

	if ( ! heading ) {
		return;
	}

	var MAX_LINES = 2;

	/*
	 * "Accommodate within two rows" is the constraint the fit exists to meet;
	 * "maximum possible font size" only ranks which of the sizes that satisfy
	 * it wins. A floor exists only so a pathological title (measured: this
	 * one, at 375px, needs 19px before two lines is even reachable — a single
	 * long word keeps forcing a third down to about 20px) cannot shrink to
	 * something unreadably small chasing two rows that never arrive; below
	 * this a title simply keeps its third line instead.
	 */
	var MIN_FONT_SIZE = 18;

	/*
	 * The heading's height never lands on a clean N × line-height — measured
	 * directly, a genuine 2-line state here reads 2.2–2.3×, a genuine 1-line
	 * state 1.2–1.3×, the same ~0.2–0.3 line of overhead however many lines
	 * there are (box leading around each line, not a partial extra line). A
	 * strict "taller than 2 × line-height" check reads that overhead as a
	 * standing 3rd line and never stops shrinking; rounding the ratio instead
	 * absorbs it, the same way it would for any other font's own metrics.
	 */
	function currentLines() {
		var lineHeight = parseFloat( getComputedStyle( heading ).lineHeight );

		return Math.round( heading.scrollHeight / lineHeight );
	}

	function fit() {
		// Clears any size a previous call left, so this always measures against
		// the clamp()'s own value for the current viewport, not last time's.
		heading.style.fontSize = '';

		/*
		 * articles.css/news.css cap the heading at 20–22ch for readability —
		 * a sensible width for a title that already fits, but self-defeating
		 * for one that does not: ch is relative to the element's own
		 * font-size, so shrinking the font shrinks the cap right along with
		 * it and the character budget per line never actually grows. Lifted
		 * for the duration of the fit so a smaller size can do what it is
		 * here to do; .hero-copy's own max-width (1180px, fixed) is still
		 * what bounds the line in practice.
		 */
		heading.style.maxWidth = 'none';

		var fontSize = parseFloat( getComputedStyle( heading ).fontSize );

		while ( currentLines() > MAX_LINES && fontSize > MIN_FONT_SIZE ) {
			fontSize -= 1;
			heading.style.fontSize = fontSize + 'px';
		}
	}

	fit();

	var resizeTimer;

	window.addEventListener( 'resize', function () {
		clearTimeout( resizeTimer );
		resizeTimer = setTimeout( fit, 150 );
	} );
}() );
