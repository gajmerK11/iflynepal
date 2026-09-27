/**
 * Fills in and reveals the France geo-language banner, over AJAX.
 *
 * The page itself — including on production, behind a full-page cache that
 * serves the same HTML to every guest for up to a week — only ever ships a
 * static, hidden, identical-for-everyone container (see
 * inc/geo-language-banner.php). The actual decision — is this visitor in
 * France, have they seen this before — can only be made against the live
 * request, so it happens here, straight after load, against admin-ajax.php,
 * which every caching plugin excludes from the page cache by design.
 *
 * A visitor who has already been shown the banner once carries the cookie
 * that says so; checking for it here skips the request entirely rather than
 * asking the server a question whose answer is already known.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	if ( typeof iflynepalGeoBanner === 'undefined' ) {
		return;
	}

	var config = iflynepalGeoBanner;

	if ( document.cookie.indexOf( config.cookieName + '=' ) !== -1 ) {
		return;
	}

	var banner = document.getElementById( 'iflynepal-geo-banner' );

	if ( ! banner ) {
		return;
	}

	var body = new URLSearchParams( {
		action: 'iflynepal_geo_banner',
		nonce: config.nonce,
		post_id: config.postId
	} );

	fetch( config.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body } )
		.then( function ( response ) { return response.json(); } )
		.then( function ( result ) {
			if ( ! result || ! result.success || ! result.data || ! result.data.show ) {
				return;
			}

			var data = result.data;
			var text = banner.querySelector( '#iflynepal-geo-banner-text' );
			var link = banner.querySelector( '#iflynepal-geo-banner-switch' );

			if ( text ) {
				text.textContent = config.textTemplate.replace( '%s', data.language_name );
			}

			if ( link ) {
				link.href = data.url;
				link.textContent = config.switchLabel;
			}

			banner.hidden = false;

			var dismiss = banner.querySelector( '[data-iflynepal-geo-dismiss]' );

			if ( dismiss ) {
				dismiss.addEventListener( 'click', function () {
					banner.hidden = true;
				} );
			}
		} )
		.catch( function () {} );
}() );
