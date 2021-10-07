<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Conditions dropdown.
 *
 * Display a list of conditions.
 *
 * @since 1.0.0
 *
 * @param mixed  $id            ID of the current condition.
 * @param mixed  $group         Group the condition belongs to.
 * @param string $current_value Current condition value.
 */
function waef_lite_condition_conditions( $id, $group = 0, $current_value = 'subtotal' ) {

	$conditions = array(
		esc_html__( 'Cart', 'woocommerce-advanced-extra-fees' ) => array(
			'subtotal'                => esc_html__( 'Subtotal', 'woocommerce-advanced-extra-fees' ),
			'subtotal_ex_tax_pro'         => esc_html__( 'Subtotal ex. taxes (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'tax_pro'                     => esc_html__( 'Tax (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'quantity_pro'                => esc_html__( 'Quantity (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'contains_product'        => esc_html__( 'Contains product', 'woocommerce-advanced-extra-fees' ),
			'coupon_pro'                  => esc_html__( 'Coupon (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'payment_gateway_pro'         => esc_html__( 'Payment Gateway (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'weight_pro'                  => esc_html__( 'Weight (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'contains_shipping_class_pro' => esc_html__( 'Contains shipping class (Available on pro)', 'woocommerce-advanced-extra-fees' ),
		),
		esc_html__( 'User Details', 'woocommerce-advanced-extra-fees' ) => array(
			'zipcode_pro' => esc_html__( 'Zipcode (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'city_pro'    => esc_html__( 'City (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'state_pro'   => esc_html__( 'State (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'country' => esc_html__( 'Country', 'woocommerce-advanced-extra-fees' ),
			'role_pro'    => esc_html__( 'User role (Available on pro)', 'woocommerce-advanced-extra-fees' ),
		),
		esc_html__( 'Product', 'woocommerce-advanced-extra-fees' ) => array(
			'width_pro'        => esc_html__( 'Width (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'height_pro'       => esc_html__( 'Height (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'length_pro'       => esc_html__( 'Length (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'stock_pro'        => esc_html__( 'Stock (Available on pro)', 'woocommerce-advanced-extra-fees' ),
			'stock_status' => esc_html__( 'Stock status', 'woocommerce-advanced-extra-fees' ),
			'category_pro'     => esc_html__( 'Category (Available on pro)', 'woocommerce-advanced-extra-fees' ),
		),
	);
	$conditions = apply_filters( 'waef_conditions', $conditions );


	?><span class='waef-condition-wrap waef-condition-wrap-<?php echo absint( $id ); ?>'>

		<select class='waef-condition' data-group='<?php echo absint( $group ); ?>' data-id='<?php echo absint( $id ); ?>'
			name='_waef_conditions[<?php echo absint( $group ); ?>][<?php echo absint( $id ); ?>][condition]'><?php

			foreach ( $conditions as $option_group => $values ) :

				?><optgroup label='<?php echo esc_attr( $option_group ); ?>'><?php

				foreach ( $values as $key => $value ) :
					$disabled = '';
					if (strpos($key, 'pro') !== false) {
						$disabled = 'disabled';
					}
					?><option value='<?php echo esc_attr( $key ); ?>' <?php selected( $key, $current_value ); echo $disabled ?> ><?php echo esc_html( $value ); ?></option><?php
				endforeach;
				
				?></optgroup><?php

			endforeach;

		?></select>

	</span><?php

}
