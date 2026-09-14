/**
 * The handwritten annotation beside the "A few good reasons" heading.
 *
 * Types its fixed part once and leaves it in place, then cycles the words
 * after it — typed, held, deleted, next word, forever. Both the fixed part
 * and the word list are the editor's own copy, read off the markup as a
 * plain string and a JSON array rather than hardcoded here, so nothing about
 * this file has to change when the Customizer fields do.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var host = document.getElementById( 'iflynepal-reasons-annot' );

	if ( ! host ) {
		return;
	}

	var staticEl = host.querySelector( '.iflynepal-reasons__annot-static' );
	var wordEl   = host.querySelector( '.iflynepal-reasons__annot-word' );

	if ( ! staticEl || ! wordEl ) {
		return;
	}

	var staticText = host.getAttribute( 'data-static' ) || '';
	var words      = [];

	try {
		words = JSON.parse( host.getAttribute( 'data-words' ) || '[]' );
	} catch ( e ) {
		words = [];
	}

	words = words.filter( function ( word ) { return 'string' === typeof word && word.length; } );

	if ( ! words.length ) {
		staticEl.textContent = staticText;
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	if ( reduced ) {
		staticEl.textContent = staticText;
		wordEl.textContent   = words[ 0 ];
		return;
	}

	var TYPE_MS   = 65;
	var DELETE_MS = 40;
	var HOLD_MS   = 1800;

	var typeInto = function ( el, text, onDone ) {
		var i = 0;

		( function step() {
			el.textContent = text.slice( 0, i );

			if ( i >= text.length ) {
				onDone();
				return;
			}

			i++;
			setTimeout( step, TYPE_MS );
		}() );
	};

	var deleteFrom = function ( el, text, onDone ) {
		var i = text.length;

		( function step() {
			el.textContent = text.slice( 0, i );

			if ( i <= 0 ) {
				onDone();
				return;
			}

			i--;
			setTimeout( step, DELETE_MS );
		}() );
	};

	var cycleWord = function ( index ) {
		var word = words[ index % words.length ];

		typeInto( wordEl, word, function () {
			setTimeout( function () {
				deleteFrom( wordEl, word, function () { cycleWord( index + 1 ); } );
			}, HOLD_MS );
		} );
	};

	typeInto( staticEl, staticText, function () { cycleWord( 0 ); } );
}() );
