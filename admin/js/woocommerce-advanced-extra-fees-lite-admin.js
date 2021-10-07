jQuery( function( $ ) {
	"use strict";
	// Add condition
	$( '#waef_conditions' ).on( 'click', '.condition-add', function() {

		var data = {
			action: 'waef_add_condition',
			group: $( this ).attr( 'data-group' ),
			nonce: waef.nonce
		};

		// Loading icon
		var loading_icon = '<div class="waef-condition-wrap loading"></div>';
		$( '.condition-group-' + data.group ).append( loading_icon ).children( ':last' ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group-' + data.group + ' .waef-condition-wrap.loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Delete condition
	$( '#waef_conditions' ).on( 'click', '.condition-delete', function() {
		"use strict";
		if ( $( this ).closest( '.condition-group' ).children( '.waef-condition-wrap' ).length == 1 ) {
			$( this ).closest( '.condition-group' ).fadeOut( 'normal', function() { $( this ).remove();	});
		} else {
			$( this ).closest( '.waef-condition-wrap' ).fadeOut( 'normal', function() { $( this ).remove(); });
		}

	});

	// Add condition group
	$( '#waef_conditions' ).on( 'click', '.condition-group-add', function() {
		"use strict";
		var condition_group_loading = '<div class="condition-group loading"></div>';

		// Display loading icon
		$( '.waef_conditions' ).append( condition_group_loading ).children( ':last').block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		var data = {
			action: 'waef_add_condition_group',
			group: 	parseInt( $( '.condition-group' ).length ),
			nonce: 	waef.nonce
		};

		// Insert condition group
		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group ~ .loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Update condition values
	$( '#waef_conditions' ).on( 'change', '.waef-condition', function () {
		"use strict";
		var data = {
			action: 		'waef_update_condition_value',
			id:				$( this ).attr( 'data-id' ),
			group:			$( this ).attr( 'data-group' ),
			condition: 		$( this ).val(),
			nonce: 			waef.nonce
		};

		var replace = '.waef-value-wrap-' + data.id;

		$( replace ).html( '<span style="width: 30%; border: 1px solid transparent; display: inline-block;">&nbsp;</span>' )
			.block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });
		$.post( ajaxurl, data, function( response ) {
			$( replace ).replaceWith( response );
		});

		// Update condition description
		var description = {
			action:		'waef_update_condition_description',
			condition: 	data.condition,
			nonce: 		waef.nonce
		};

		$.post( ajaxurl, description, function( description_response ) {
			$( replace + ' ~ .waef-description' ).replaceWith( description_response );
		})

	});

	// Sortable
	$( '.waef-table tbody' ).sortable({
		items:					'tr',
		handle:					'.sort',
		cursor:					'move',
		axis:					'y',
		scrollSensitivity:		40,
		forcePlaceholderSize: 	true,
		helper: 				'clone',
		opacity: 				0.65,
		placeholder: 			'wc-metabox-sortable-placeholder',
		start:function(event,ui){
			ui.item.css( 'background-color','#f6f6f6' );
		},
		stop:function(event,ui){
			ui.item.removeAttr( 'style' );
		},
		update: function(event, ui) {

			var table 	= $( this ).closest( 'table' );
			table.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
			// Update shipping method order
			var data = {
				action:	'waef_save_shipping_rates_table',
				form: 	$( this ).closest( 'form' ).serialize(),
				nonce: waef.nonce
			};

			$.post( ajaxurl, data, function( response ) {
				$( '.waef-table tbody tr:even' ).addClass( 'alternate' );
				$( '.waef-table tbody tr:odd' ).removeClass( 'alternate' );
				table.unblock();
			})
		}
	});
});