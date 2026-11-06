/**
 * Legal pages, Customizer side: the formatting toolbar and the add/remove lists.
 *
 * The toolbar wraps the selected text of a rich-text control in the matching
 * tag. The lists (Sustainability Policy > On this page / Our commitment) are
 * described in PHP and walked here with the shared repeater.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( $, api ) {
	'use strict';

	/**
	 * Replaces the textarea's selection and tells the Customizer it changed.
	 *
	 * @param {HTMLTextAreaElement} area  Textarea.
	 * @param {string}              value New text for the selection.
	 * @param {number}              start Selection start.
	 * @param {number}              end   Selection end.
	 * @return {void}
	 */
	function replaceSelection( area, value, start, end ) {
		area.value = area.value.slice( 0, start ) + value + area.value.slice( end );
		area.focus();
		area.setSelectionRange( start, start + value.length );
		$( area ).trigger( 'input' ).trigger( 'change' );
	}

	/**
	 * Turns each non-empty line of the selection into a list item.
	 *
	 * @param {string} text Selected text.
	 * @param {string} tag  'ul' or 'ol'.
	 * @return {string} List markup.
	 */
	function toList( text, tag ) {
		var lines = ( text || 'Item' ).split( /\n/ ).map( function ( line ) {
			return line.replace( /^\s*(?:[-*\u2022]|\d+[.)])\s+/, '' ).trim();
		} ).filter( Boolean );

		return '<' + tag + '>\n' + lines.map( function ( line ) {
			return '<li>' + line + '</li>';
		} ).join( '\n' ) + '\n</' + tag + '>';
	}

	$( document ).on( 'click', '.iflynepal-rich__btn', function ( event ) {
		event.preventDefault();

		var area = $( this ).closest( '.iflynepal-rich' ).find( 'textarea' )[ 0 ];
		var cmd = $( this ).data( 'cmd' );
		var start = area.selectionStart;
		var end = area.selectionEnd;
		var text = area.value.slice( start, end );
		var tags = { bold: 'strong', italic: 'em', underline: 'u' };
		var url;

		if ( tags[ cmd ] ) {
			replaceSelection( area, '<' + tags[ cmd ] + '>' + ( text || 'text' ) + '</' + tags[ cmd ] + '>', start, end );
		} else if ( 'link' === cmd ) {
			url = window.prompt( 'Link address (https://… or /page/)', 'https://' ); // eslint-disable-line no-alert

			if ( url ) {
				replaceSelection( area, '<a href="' + url.replace( /"/g, '%22' ) + '">' + ( text || 'link text' ) + '</a>', start, end );
			}
		} else if ( 'ul' === cmd || 'ol' === cmd ) {
			replaceSelection( area, toList( text, cmd ), start, end );
		} else if ( 'clear' === cmd ) {
			replaceSelection( area, text.replace( /<[^>]*>/g, '' ), start, end );
		}
	} );

	api.bind( 'ready', function () {
		var config = window.iflynepalLegalLists;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		config.lists.forEach( function ( list ) {
			var slots = [];

			for ( var i = 1; i <= list.max; i++ ) {
				slots.push( list.patterns.map( function ( pattern ) {
					return pattern.replace( '%d', i );
				} ) );
			}

			window.iflynepalCustomizer.repeater( {
				slots: slots,
				anchor: list.anchor,
				addLabel: list.addLabel,
				maxMessage: list.maxMessage,
				removeLabel: list.removeLabel,

				// A media control stores an attachment ID, which is 0 rather than "" when empty.
				emptyValue: function ( id ) {
					return /_icon$/.test( id ) ? 0 : '';
				}
			} );
		} );
	} );
}( jQuery, wp.customize ) );
