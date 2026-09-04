/**
 * The FAQ accordion.
 *
 * The open state is a class on the item, and the stylesheet alone is enough to
 * show and hide the answer — so with JavaScript off every answer is visible and
 * readable rather than locked shut. This file adds the toggling, and the height
 * tween when GSAP is present and motion is welcome.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-guides' );

	if ( ! section ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var gsap = window.gsap;
	var animate = ! reduced && 'undefined' !== typeof gsap;

	/*
	 * Only once the toggling is actually wired does the stylesheet start
	 * collapsing closed answers. Until then they are all open.
	 */
	section.classList.add( 'is-interactive' );

	Array.prototype.forEach.call(
		section.querySelectorAll( '.iflynepal-guides__faq-question' ),
		function ( button ) {
			var item = button.closest( '.iflynepal-guides__faq-item' );
			var answer = item.querySelector( '.iflynepal-guides__faq-answer' );

			if ( ! answer ) {
				return;
			}

			if ( animate && item.classList.contains( 'is-open' ) ) {
				gsap.set( answer, { height: 'auto', paddingBottom: 20 } );
			}

			button.addEventListener( 'click', function () {
				var isOpen = item.classList.toggle( 'is-open' );

				button.setAttribute( 'aria-expanded', String( isOpen ) );

				if ( ! animate ) {
					return;
				}

				gsap.killTweensOf( answer );

				if ( isOpen ) {
					gsap.set( answer, { height: 'auto', paddingBottom: 20 } );
					gsap.from( answer, { height: 0, paddingBottom: 0, duration: 0.45, ease: 'power2.out' } );
				} else {
					gsap.to( answer, { height: 0, paddingBottom: 0, duration: 0.35, ease: 'power2.in' } );
				}
			} );
		}
	);
}() );
