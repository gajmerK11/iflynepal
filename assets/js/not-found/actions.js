/**
 * The "Go back" action on the Not Found page.
 *
 * Two jobs, both of them enhancement. The button is hidden by the stylesheet
 * and revealed by the class this file puts on the document element, so a
 * visitor without scripting never gets a control that cannot work; and the
 * click is handled here rather than by an inline `onclick`, which the theme
 * does not use and a content security policy would block.
 *
 * The listener is on the document rather than on the button, so it survives the
 * Customizer re-rendering the actions on every keystroke.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	/*
	 * history.length counts this page too, so a tab opened straight onto a dead
	 * URL reads 1 and there is nothing to go back to. Revealing the button in
	 * that case would be the dead control this file exists to avoid.
	 */
	if ( window.history.length < 2 ) {
		return;
	}

	document.documentElement.classList.add( 'iflynepal-has-history' );

	document.addEventListener( 'click', function ( event ) {
		var target = event.target;

		if ( ! target || ! target.closest ) {
			return;
		}

		var button = target.closest( '[data-iflynepal-history-back]' );

		if ( ! button ) {
			return;
		}

		event.preventDefault();
		window.history.back();
	} );
}() );
