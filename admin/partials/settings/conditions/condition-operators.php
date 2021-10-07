<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Operator dropdown.
 *
 * Display a list of operators.
 *
 * @since 1.0.0
 *
 * @param mixed  $id            ID of the current condition.
 * @param mixed  $group         Group the (condition) operator belongs to.
 * @param string $current_value Current operator value.
 */
function waef_lite_condition_operator( $id, $group = 0, $current_value = '==' ) {

	$operators = array(
		'==' => __( 'Equal to', 'woocommerce-advanced-extra-fees' ),
		'!=' => __( 'Not equal to', 'woocommerce-advanced-extra-fees' ),
		'>=' => __( 'Greater or equal to', 'woocommerce-advanced-extra-fees' ),
		'<=' => __( 'Less or equal to ', 'woocommerce-advanced-extra-fees' ),
	);
	$operators = apply_filters( 'waef_operators', $operators );

	?><span class='waef-operator-wrap waef-operator-wrap-<?php echo absint( $id ); ?>'>

		<select class='waef-operator' name='_waef_conditions[<?php echo absint( $group ); ?>][<?php echo absint( $id ); ?>][operator]'><?php

			foreach ( $operators as $key => $value ) :
				?><option value='<?php echo esc_attr( $key ); ?>' <?php selected( $key, $current_value ); ?>><?php echo esc_html( $value ); ?></option><?php
			endforeach;

		?></select>

	</span><?php

}
