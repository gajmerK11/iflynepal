/**
 * Contact form validation and AJAX submission.
 *
 * Progressive enhancement: the form posts to admin-post.php and works without
 * this file at all — a page reload, a redirect, a notice in the markup. When
 * `iflynepalContactForm` (localized ajaxUrl) and `fetch` are both available,
 * a valid submit is sent to admin-ajax.php instead, using the same fields
 * admin-post.php would have received (the action name matches a
 * wp_ajax_/wp_ajax_nopriv_ hook, so nothing in the form markup has to change),
 * and the result is shown in place rather than by navigating.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var form = document.querySelector( '.iflynepal-contact-form' );

	if ( ! form ) {
		return;
	}

	var controls = form.querySelectorAll( '.iflynepal-contact-control' );
	var submit = form.querySelector( '.iflynepal-contact-submit' );

	function validate( control ) {
		var valid = control.checkValidity();
		control.classList.toggle( 'is-invalid', ! valid );
		control.classList.toggle( 'is-valid', valid );
	}

	Array.prototype.forEach.call( controls, function ( control ) {
		control.addEventListener( 'blur', function () { validate( control ); } );
		control.addEventListener( 'change', function () { validate( control ); } );
		control.addEventListener( 'input', function () {
			if ( control.classList.contains( 'is-invalid' ) || control.classList.contains( 'is-valid' ) ) {
				validate( control );
			}
		} );
	} );

	/*
	 * Everything past this point is the AJAX path. Without the localized
	 * config (the script failed to enqueue with it, somehow) or without
	 * fetch, the listener below still runs its validation but never calls
	 * preventDefault for a valid form, so it falls through to the ordinary
	 * POST.
	 */
	var canAjax = 'undefined' !== typeof iflynepalContactForm && window.fetch && window.FormData;
	var fadeTimer = null;

	/**
	 * Finds the server-rendered notice, or creates one in the same spot: right
	 * before the form, where the PHP template puts it after a redirect.
	 *
	 * @return {Element}
	 */
	function getNotice() {
		var notice = document.getElementById( 'iflynepal-contact-notice' );

		if ( notice ) {
			return notice;
		}

		notice = document.createElement( 'div' );
		notice.id = 'iflynepal-contact-notice';
		notice.setAttribute( 'role', 'status' );
		notice.setAttribute( 'tabindex', '-1' );
		form.parentNode.insertBefore( notice, form );

		return notice;
	}

	/**
	 * Shows one result and fades it out after a few seconds, the same as the
	 * server-rendered notice does on the pages this script never touches.
	 *
	 * @param {string} type    'success' or 'error'.
	 * @param {string} message The text to show.
	 * @return {void}
	 */
	function showNotice( type, message ) {
		var notice = getNotice();

		window.clearTimeout( fadeTimer );
		notice.style.transition = '';
		notice.style.opacity = '';
		notice.className = 'iflynepal-contact-notice iflynepal-contact-notice--' + type;
		notice.textContent = message;
		notice.focus();

		fadeTimer = window.setTimeout( function () {
			notice.style.transition = 'opacity .3s ease';
			notice.style.opacity = '0';

			window.setTimeout( function () {
				notice.remove();
			}, 300 );
		}, 6000 );
	}

	form.addEventListener( 'submit', function ( event ) {
		if ( ! form.checkValidity() ) {
			event.preventDefault();
			Array.prototype.forEach.call( controls, validate );

			var firstInvalid = form.querySelector( '.is-invalid' );

			if ( firstInvalid ) {
				firstInvalid.focus();
			}

			return;
		}

		if ( ! canAjax || ! submit ) {
			return;
		}

		event.preventDefault();

		var originalHtml = submit.innerHTML;

		submit.disabled = true;
		submit.textContent = iflynepalContactForm.sendingLabel;

		fetch( iflynepalContactForm.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: new URLSearchParams( new FormData( form ) )
		} )
			.then( function ( response ) { return response.json(); } )
			.then( function ( result ) {
				var data = result && result.data ? result.data : null;

				if ( ! data ) {
					showNotice( 'error', iflynepalContactForm.networkMessage );
					return;
				}

				showNotice( data.type, data.message );

				if ( result.success ) {
					form.reset();
					Array.prototype.forEach.call( controls, function ( control ) {
						control.classList.remove( 'is-valid', 'is-invalid' );
					} );
				}
			} )
			.catch( function () {
				showNotice( 'error', iflynepalContactForm.networkMessage );
			} )
			.then( function () {
				submit.disabled = false;
				submit.innerHTML = originalHtml;
			} );
	} );
}() );
