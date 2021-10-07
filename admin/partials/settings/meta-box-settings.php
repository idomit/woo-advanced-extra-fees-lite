<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WAEF meta box settings.
 *
 * Display the shipping settings in the meta box.
 *
 * @author		multisquares
 * @package		WooCommerce Advanced Extra Fees Lite
 * @version		1.0.0
 */

wp_nonce_field( 'waef_settings_meta_box', 'waef_settings_meta_box_nonce' );

global $post;
$settings = get_post_meta( $post->ID, '_waef_shipping_method', true );

?><div class='waef waef_settings waef_meta_box waef_settings_meta_box'>

	<p class='waef-option'>

		<label for='fees_title'><?php _e( 'Fees title', 'woocommerce-advanced-extra-fees' ); ?></label>
		<input type='text' class='' id='fees_title' name='_waef_shipping_method[fees_title]' style='width: 190px;'
			value='<?php echo esc_attr( @$settings['fees_title'] ); ?>' placeholder='<?php _e( 'e.g. Advanced Extra Fees', 'woocommerce-advanced-extra-fees' ); ?>'>

	</p>


	<p class='waef-option'>

		<label for='cost'><?php _e( 'Fees cost', 'woocommerce-advanced-extra-fees' ); ?></label>
		<span class='waef-currency'><?php echo get_woocommerce_currency_symbol(); ?></span>
		<input type='text' step='any' class='wc_input_price' id='cost' name='_waef_shipping_method[fees_cost]'
			value='<?php echo esc_attr( wc_format_localized_price( @$settings['fees_cost'] ) ); ?>' placeholder='<?php _e( 'Fees cost', 'woocommerce-advanced-extra-fees' ); ?>'>

	</p>
	<p class='waef-option'>

		<label for='tax'><?php _e( 'Tax status', 'woocommerce-advanced-extra-fees' ); ?></label>
		<select name='_waef_shipping_method[tax]' style='width: 189px;'>
			<option value='taxable' <?php @selected( $settings['tax'], 'taxable' ); ?>><?php _e( 'Taxable', 'woocommerce-advanced-extra-fees' ); ?></option>
			<option value='not_taxable' <?php @selected( $settings['tax'], 'not_taxable' ); ?>><?php _e( 'Not taxable', 'woocommerce-advanced-extra-fees' ); ?></option>
		</select>

	</p><?php

	do_action( 'waef_after_meta_box_settings', $settings );

?></div>
