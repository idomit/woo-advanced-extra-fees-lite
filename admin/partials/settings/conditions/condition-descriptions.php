<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Descriptions.
 *
 * Display a description icon + tooltip on hover.
 *
 * @since 1.0.0
 *
 * @param string $condition Current condition to display the description for.
 */
function waef_lite_condition_description( $condition ) {

	$descriptions = array(
		'state'                   => __( 'States must be installed in WC', 'woocommerce-advanced-extra-fees' ),
		'weight'                  => __( 'Weight calculated on all the cart contents', 'woocommerce-advanced-extra-fees' ),
		'length'                  => __( 'Compared to lengthiest product in cart', 'woocommerce-advanced-extra-fees' ),
		'width'                   => __( 'Compared to widest product in cart', 'woocommerce-advanced-extra-fees' ),
		'height'                  => __( 'Compared to highest product in cart', 'woocommerce-advanced-extra-fees' ),
		'stock_status'            => __( 'All products in cart must match stock status', 'woocommerce-advanced-extra-fees' ),
		'category'                => __( 'All products in cart must match category', 'woocommerce-advanced-extra-fees' ),
		'contains_product'        => __( 'Cart must contain one of this product, other products are allowed', 'woocommerce-advanced-extra-fees' ),
		'contains_shipping_class' => __( 'Cart must contain at least one product with the selected shipping class', 'woocommerce-advanced-extra-fees' ),
	);
	$descriptions = apply_filters( 'waef_descriptions', $descriptions );

	// Display description
	if ( ! isset( $descriptions[ $condition ] ) ) :
		?><span class='waef-description no-description'></span><?php
		return;
	endif;

	?><span class='waef-description <?php echo $condition; ?>-description'>

		<div class='description'>

			<img class='waef_tip' src='<?php echo WC()->plugin_url(); ?>/assets/images/help.png' height='24' width='24' />

			<div class='waef_desc'><?php
				echo wp_kses_post( $descriptions[ $condition ] );
			?></div>

		</div>

	</span><?php

}
