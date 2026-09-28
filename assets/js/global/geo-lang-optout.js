/**
 * Remembers a switcher-driven language choice, so a French-IP visitor who
 * picks another language from the site's own switcher stops being forced
 * back to French on this browser.
 *
 * A cookie is the only signal inc/geo-language-banner.php trusts for this —
 * landing on a non-French URL any other way (a shared link, a bookmark)
 * must not count as opting out, or the very first forced redirect would
 * never happen.
 */
( function () {
	'use strict';

	if ( 'undefined' === typeof iflynepalGeoBanner ) {
		return;
	}

	var cookieName = iflynepalGeoBanner.cookieName;
	var forcedLang = iflynepalGeoBanner.forcedLang;

	document.addEventListener( 'click', function ( event ) {
		var link = event.target.closest( '.iflynepal-lang-switch__link' );

		if ( ! link ) {
			return;
		}

		var lang = link.getAttribute( 'lang' );

		if ( ! lang || lang === forcedLang ) {
			return;
		}

		var expires = new Date( Date.now() + 365 * 24 * 60 * 60 * 1000 ).toUTCString();
		var secure = 'https:' === window.location.protocol ? '; Secure' : '';

		document.cookie = cookieName + '=1; expires=' + expires + '; path=/; SameSite=Lax' + secure;
	} );
} )();
