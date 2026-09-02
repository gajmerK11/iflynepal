/**
 * Turns a fixed run of Customizer controls into an add/remove list.
 *
 * The Customizer has no repeater. Every slot is therefore registered in PHP up
 * front, and this hides the ones that are empty behind an "Add" button so the
 * panel shows only as many fields as there is content. Removing a slot clears
 * its setting, which is what the render side reads as "skip this one".
 *
 * The code itself is panel-agnostic; it lives under hero/ because the hero's
 * trust points are the only list using it so far. Move it up a level the first
 * time a second section needs one. Which settings form a list is decided by the
 * caller, e.g. trust-points.js alongside this file.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( $, api ) {
	'use strict';

	window.iflynepalCustomizer = window.iflynepalCustomizer || {};

	/**
	 * Builds the add/remove UI over a run of settings.
	 *
	 * @since 1.0.0
	 *
	 * @param {Object}   config             Configuration.
	 * @param {string[]} config.settings    Setting IDs, in display order.
	 * @param {string}   config.anchor      Setting ID of the control the Add button sits under.
	 * @param {string}   config.addLabel    Text for the Add button.
	 * @param {string}   config.maxMessage  Text shown once every slot is in use.
	 * @param {string}   config.removeLabel Text for a Remove button. %d is the slot number.
	 * @param {number}   [config.minVisible] Slots always shown, even when empty. Defaults to 0.
	 * @return {void}
	 */
	window.iflynepalCustomizer.repeater = function ( config ) {
		var slots = [];
		var minVisible = config.minVisible || 0;
		var anchorControl = api.control( config.anchor );

		config.settings.forEach( function ( id, index ) {
			var control = api.control( id );

			if ( control ) {
				slots.push( {
					number: index + 1,
					id: id,
					$container: control.container
				} );
			}
		} );

		if ( ! slots.length || ! anchorControl ) {
			return;
		}

		var $anchor = anchorControl.container;

		var $add = $( '<button>', {
			type: 'button',
			'class': 'button button-secondary',
			text: config.addLabel
		} ).css( { margin: '8px 0 4px', display: 'block', width: '100%' } );

		var $message = $( '<p>', { text: config.maxMessage } ).css( {
			color: '#666',
			fontSize: '11px',
			margin: '2px 0 8px',
			display: 'none'
		} );

		/**
		 * Whether a slot currently holds anything.
		 *
		 * @param {Object} slot Slot.
		 * @return {boolean} True when the setting has a value.
		 */
		function isFilled( slot ) {
			var setting = api( slot.id );

			return !! setting && String( setting.get() ).trim() !== '';
		}

		/**
		 * Moves the Add button below the last slot on show.
		 *
		 * @return {void}
		 */
		function reposition() {
			var $last = $anchor;

			slots.forEach( function ( slot ) {
				if ( slot.$container.is( ':visible' ) ) {
					$last = slot.$container;
				}
			} );

			$last.after( $message ).after( $add );
		}

		/**
		 * Reflects the current count in the Add button, the limit notice and the
		 * Remove buttons.
		 *
		 * Remove is withdrawn from the last slots standing once the list is down
		 * to minVisible, so a section that the design requires content in cannot
		 * be emptied entirely.
		 *
		 * @return {void}
		 */
		function syncLimit() {
			var $visible = slots.filter( function ( slot ) {
				return slot.$container.is( ':visible' );
			} );

			$add.toggle( $visible.length < slots.length );
			$message.toggle( $visible.length >= slots.length );

			var removable = $visible.length > minVisible;

			$visible.forEach( function ( slot ) {
				slot.$container.find( '.iflynepal-repeater-remove' ).toggle( removable );
			} );
		}

		/**
		 * Gives a slot its Remove button, once.
		 *
		 * @param {Object} slot Slot.
		 * @return {void}
		 */
		function addRemoveButton( slot ) {
			if ( slot.$container.find( '.iflynepal-repeater-remove' ).length ) {
				return;
			}

			var $remove = $( '<button>', {
				type: 'button',
				'class': 'iflynepal-repeater-remove button button-link-delete',
				text: '✕ ' + config.removeLabel.replace( '%d', slot.number )
			} ).css( { marginTop: '4px', fontSize: '11px', display: 'block' } );

			slot.$container.append( $remove );

			$remove.on( 'click', function () {
				api( slot.id ).set( '' );
				slot.$container.hide();
				reposition();
				syncLimit();
			} );
		}

		/**
		 * Shows a slot and wires its Remove button.
		 *
		 * @param {Object} slot Slot.
		 * @return {void}
		 */
		function show( slot ) {
			slot.$container.show();
			addRemoveButton( slot );
		}

		slots.forEach( function ( slot ) {
			slot.$container.hide();
		} );

		/*
		 * Show every slot up to the last one holding content, so a gap left by a
		 * removed middle bullet stays visible and editable rather than vanishing.
		 */
		var lastFilled = 0;

		slots.forEach( function ( slot, index ) {
			if ( isFilled( slot ) ) {
				lastFilled = index + 1;
			}
		} );

		var initial = Math.max( lastFilled, minVisible );

		for ( var i = 0; i < initial; i++ ) {
			show( slots[ i ] );
		}

		reposition();
		syncLimit();

		$add.on( 'click', function () {
			for ( var n = 0; n < slots.length; n++ ) {
				if ( slots[ n ].$container.is( ':hidden' ) ) {
					show( slots[ n ] );
					break;
				}
			}

			reposition();
			syncLimit();
		} );
	};
}( jQuery, wp.customize ) );
