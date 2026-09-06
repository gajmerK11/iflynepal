/**
 * Contact form validation enhancement.
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

	form.addEventListener( 'submit', function ( event ) {
		if ( form.checkValidity() ) {
			return;
		}

		event.preventDefault();
		Array.prototype.forEach.call( controls, validate );

		var firstInvalid = form.querySelector( '.is-invalid' );
		if ( firstInvalid ) {
			firstInvalid.focus();
		}
	} );
}() );

