/**
 * The cross inside the archive search field, made to mean what it looks like.
 *
 * The cross is the browser's own, drawn inside `input[type="search"]`, and
 * clearing the field is all it does — which leaves a visitor looking at an
 * empty box and a page still filtered by what used to be in it. The `search`
 * event is what that cross fires, and Escape in the field with it, so an
 * emptied field on a page that is a search does what the Clear search button
 * beside it does.
 *
 * Both archives carry the same field under the same id, so both load this.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var input = document.getElementById( 'ifn-search-input' );

	// `defaultValue` is the value attribute: set only on a page that is a search.
	if ( ! input || ! input.defaultValue ) {
		return;
	}

	input.addEventListener( 'search', function () {
		if ( '' !== input.value ) {
			return;
		}

		var form = input.form;

		window.location.href = form && form.action ? form.action : window.location.pathname;
	} );
}() );
