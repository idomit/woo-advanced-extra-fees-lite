<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Value field.
 *
 * Display the value field, the type and values depend on the condition.
 *
 * @since 1.0.0
 *
 * @param mixed  $id            ID of the current condition.
 * @param mixed  $group         Group the condition belongs to.
 * @param string $condition     Condition.
 * @param string $current_value Current condition value.
 */
function waef_lite_condition_values( $id, $group = 0, $condition = 'subtotal', $current_value = '' ) {

	// Defaults
	$values = array( 'placeholder' => '', 'min' => '', 'max' => '', 'field' => 'text', 'options' => array(), 'class' => '' );

	switch ( $condition ) :

		default:
		case 'subtotal' :
			$values['field'] = 'text';
			break;
		case 'contains_product' :

			$values['field'] = 'select';

			$products = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'product', 'order' => 'asc', 'orderby' => 'title' ) );
			foreach ( $products as $product ) :
				$values['options'][ $product->ID ] = $product->post_title;
			endforeach;

			break;

		
		/**************************************************************
		 * User details
		 *************************************************************/

		case 'country' :

			$values['field'] 	= 'select';
			$values['options'] 	= WC()->countries->get_allowed_countries() + WC()->countries->get_shipping_countries();

			break;

		/**************************************************************
		 * Product
		 *************************************************************/

		case 'stock_status' :

			$values['field'] = 'select';
			$values['options'] = array(
				'instock'    => __( 'In stock', 'woocommerce' ),
				'outofstock' => __( 'Out of stock', 'woocommerce' ),
			);

			break;

	endswitch;

	$values = apply_filters( 'waef_values', $values, $condition );

	?><span class='waef-value-wrap waef-value-wrap-<?php echo $id; ?>'><?php

		switch ( $values['field'] ) :

			case 'text' :

				$classes = is_array( $values['class'] ) ? implode( ' ', array_map( 'sanitize_html_class', $values['class'] ) ) : sanitize_html_class( $values['class'] );
				?><input type='text' class='waef-value <?php echo $classes; ?>' name='_waef_conditions[<?php echo absint( $group ); ?>][<?php echo absint( $id ); ?>][value]'
					placeholder='<?php echo esc_attr( $values['placeholder'] ); ?>' value='<?php echo esc_attr( $current_value ); ?>'><?php

				break;

			case 'number' :

				$classes = is_array( $values['class'] ) ? implode( ' ', array_map( 'sanitize_html_class', $values['class'] ) ) : sanitize_html_class( $values['class'] );
				?><input type='text' class='waef-value <?php echo $classes; ?>' name='_waef_conditions[<?php echo absint( $group ); ?>][<?php echo absint( $id ); ?>][value]'
					min='<?php echo esc_attr( $values['min'] ); ?>' max='<?php echo esc_attr( $values['max'] ); ?>' placeholder='<?php echo esc_attr( $values['placeholder'] ); ?>'
					value='<?php echo esc_attr( $current_value ); ?>'><?php

				break;

			case 'select' :

				$classes = is_array( $values['class'] ) ? implode( ' ', array_map( 'sanitize_html_class', $values['class'] ) ) : sanitize_html_class( $values['class'] );
				?><select class='waef-value <?php echo $classes; ?>' name='_waef_conditions[<?php echo absint( $group ); ?>][<?php echo absint( $id ); ?>][value]'><?php

					foreach ( $values['options'] as $key => $value ) :

						if ( ! is_array( $value ) ) :
							?><option value='<?php echo esc_attr( $key ); ?>' <?php selected( $key, $current_value ); ?>><?php echo esc_attr( $value ); ?></option><?php
						else :
							?><optgroup label='<?php echo esc_attr( $key ); ?>'><?php
								foreach ( $value as $k => $v ) :
									?><option value='<?php echo esc_attr( $k ); ?>' <?php selected( $k, $current_value ); ?>><?php echo esc_attr( $v ); ?></option><?php
								endforeach;
							?></optgroup><?php

						endif;

					endforeach;

					if ( empty( $values['options'] ) ) :
						?><option readonly disabled><?php
							_e( 'There are no options available', 'woocommerce-advanced-extra-fees' );
						?></option><?php
					endif;

				?></select><?php

				break;

			default :
				do_action( 'waef_condition_value_field_type_' . $values['field'], $values, $id, $group, $condition, $current_value );
				break;

		endswitch;

	?></span><?php

}
