/**
 * Hero ambient sound.
 *
 * Opt-in, never automatic. Browsers reject unmuted playback that no one asked
 * for, and WCAG 1.4.2 requires a stop control for audio that runs longer than
 * three seconds, so the only way this makes noise is a click. The file is not
 * downloaded until that click, which keeps it free for everyone else.
 *
 * Once on, it follows the hero: it stops when the section is scrolled past and
 * when the tab is hidden, and picks up again on the way back.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var audio = document.getElementById( 'iflynepal-hero-audio' );
	var toggle = document.getElementById( 'iflynepal-hero-audio-toggle' );
	var hero = document.querySelector( '.iflynepal-hero' );

	if ( ! audio || ! toggle || ! hero ) {
		return;
	}

	// Remembered per visitor, per browser. Never leaves the device.
	var STORAGE_KEY = 'iflynepalHeroAudio';

	// Ambient, not foreground. Full volume over a hero is startling.
	var TARGET_VOLUME = 0.35;
	var FADE_MS = 900;

	// What the visitor has asked for, regardless of what is playing right now.
	var wanted = false;

	var inView = true;
	var requested = false;
	var fadeFrame = null;

	/**
	 * Reads the remembered preference.
	 *
	 * Storage throws outright in some privacy modes, so every access is guarded
	 * and a failure simply means "off".
	 *
	 * @return {boolean} Whether sound was on last time.
	 */
	function readPreference() {
		try {
			return window.localStorage.getItem( STORAGE_KEY ) === 'on';
		} catch ( e ) {
			return false;
		}
	}

	/**
	 * Remembers the preference.
	 *
	 * @param {boolean} on Whether sound is on.
	 * @return {void}
	 */
	function writePreference( on ) {
		try {
			window.localStorage.setItem( STORAGE_KEY, on ? 'on' : 'off' );
		} catch ( e ) {}
	}

	/**
	 * Points the button at its current state, for both sighted and screen
	 * reader users.
	 *
	 * @param {boolean} on Whether sound is on.
	 * @return {void}
	 */
	function paint( on ) {
		toggle.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
		toggle.setAttribute(
			'aria-label',
			on ? toggle.getAttribute( 'data-label-on' ) : toggle.getAttribute( 'data-label-off' )
		);
		toggle.classList.toggle( 'is-on', on );
	}

	/**
	 * Ramps the volume, so sound arrives and leaves rather than snapping.
	 *
	 * @param {number}   target Volume to reach, 0 to 1.
	 * @param {Function} [done] Called once the ramp finishes.
	 * @return {void}
	 */
	function fadeTo( target, done ) {
		if ( fadeFrame ) {
			window.cancelAnimationFrame( fadeFrame );
			fadeFrame = null;
		}

		/*
		 * A hidden tab produces no animation frames, so a ramp would hang here
		 * and never reach its callback. Jump straight to the end instead.
		 */
		if ( document.hidden ) {
			audio.volume = target;

			if ( done ) {
				done();
			}

			return;
		}

		var from = audio.volume;
		var startedAt = null;

		function step( now ) {
			if ( null === startedAt ) {
				startedAt = now;
			}

			var progress = Math.min( ( now - startedAt ) / FADE_MS, 1 );

			audio.volume = from + ( target - from ) * progress;

			if ( progress < 1 ) {
				fadeFrame = window.requestAnimationFrame( step );
				return;
			}

			fadeFrame = null;

			if ( done ) {
				done();
			}
		}

		fadeFrame = window.requestAnimationFrame( step );
	}

	/**
	 * Starts playback, fetching the file on first use.
	 *
	 * @return {Promise<boolean>} Whether playback actually began.
	 */
	function start() {
		if ( ! requested ) {
			audio.load();
			requested = true;
		}

		audio.volume = 0;

		var attempt = audio.play();

		// Older browsers return nothing rather than a promise.
		if ( ! attempt || ! attempt.then ) {
			fadeTo( TARGET_VOLUME );
			return Promise.resolve( true );
		}

		return attempt.then( function () {
			fadeTo( TARGET_VOLUME );
			return true;
		} ).catch( function () {
			return false;
		} );
	}

	/**
	 * Fades out, then pauses.
	 *
	 * @return {void}
	 */
	function stop() {
		fadeTo( 0, function () {
			audio.pause();
		} );
	}

	/*
	 * The button does nothing without this script, so it ships hidden and is
	 * revealed here.
	 */
	toggle.hidden = false;

	toggle.addEventListener( 'click', function () {
		wanted = ! wanted;
		writePreference( wanted );
		paint( wanted );

		if ( wanted && inView ) {
			start();
			return;
		}

		stop();
	} );

	/*
	 * A visitor who turned sound on last time gets it back — but only if the
	 * browser allows it. A first load with no prior interaction is usually
	 * refused, and that refusal is not an error: the button simply stays off
	 * and one click starts it.
	 */
	if ( readPreference() ) {
		start().then( function ( playing ) {
			wanted = playing;
			paint( playing );
		} );
	}

	/*
	 * Sound belongs to the hero. Once it is scrolled away there is nothing on
	 * screen it relates to, so it stops rather than following the visitor down
	 * the page.
	 */
	if ( 'IntersectionObserver' in window ) {
		new window.IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					inView = entry.isIntersecting;

					if ( ! wanted ) {
						return;
					}

					if ( inView ) {
						start();
						return;
					}

					stop();
				} );
			},
			{ threshold: 0 }
		).observe( hero );
	}

	// Nobody wants sound from a tab they are not looking at.
	document.addEventListener( 'visibilitychange', function () {
		if ( document.hidden ) {
			if ( ! audio.paused ) {
				audio.pause();
			}

			return;
		}

		if ( wanted && inView ) {
			start();
		}
	} );
}() );
