<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAEF_Lite_Match_Conditions.
 *
 * The WAEF Match Conditions class handles the matching rules for fees.
 *
 * @class		WAEF_Lite_Match_Conditions
 * @author		idomit
 * @package 	WooCommerce Advanced Extra Fees
 * @version	1.0.0
 */
class WAEF_Lite_Match_Conditions {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'waef_match_condition_subtotal', array( $this, 'waef_match_condition_subtotal' ), 10, 4 );
		add_filter( 'waef_match_condition_subtotal_ex_tax', array( $this, 'waef_match_condition_subtotal_ex_tax' ), 10, 4 );
		add_filter( 'waef_match_condition_tax', array( $this, 'waef_match_condition_tax' ), 10, 4 );
		add_filter( 'waef_match_condition_quantity', array( $this, 'waef_match_condition_quantity' ), 10, 4 );
		add_filter( 'waef_match_condition_contains_product', array( $this, 'waef_match_condition_contains_product' ), 10, 4 );
		add_filter( 'waef_match_condition_coupon', array( $this, 'waef_match_condition_coupon' ), 10, 4 );
		add_filter( 'waef_match_condition_payment_gateway', array( $this, 'waef_match_condition_payment_gateway' ), 10, 4 );
		add_filter( 'waef_match_condition_weight', array( $this, 'waef_match_condition_weight' ), 10, 4 );
		add_filter( 'waef_match_condition_contains_shipping_class', array( $this, 'waef_match_condition_contains_shipping_class' ), 10, 4 );

		add_filter( 'waef_match_condition_zipcode', array( $this, 'waef_match_condition_zipcode' ), 10, 4 );
		add_filter( 'waef_match_condition_city', array( $this, 'waef_match_condition_city' ), 10, 4 );
		add_filter( 'waef_match_condition_state', array( $this, 'waef_match_condition_state' ), 10, 4 );
		add_filter( 'waef_match_condition_country', array( $this, 'waef_match_condition_country' ), 10, 4 );
		add_filter( 'waef_match_condition_role', array( $this, 'waef_match_condition_role' ), 10, 4 );

		add_filter( 'waef_match_condition_width', array( $this, 'waef_match_condition_width' ), 10, 4 );
		add_filter( 'waef_match_condition_height', array( $this, 'waef_match_condition_height' ), 10, 4 );
		add_filter( 'waef_match_condition_length', array( $this, 'waef_match_condition_length' ), 10, 4 );
		add_filter( 'waef_match_condition_stock', array( $this, 'waef_match_condition_stock' ), 10, 4 );
		add_filter( 'waef_match_condition_stock_status', array( $this, 'waef_match_condition_stock_status' ), 10, 4 );
		add_filter( 'waef_match_condition_category', array( $this, 'waef_match_condition_category' ), 10, 4 );

	}


	/**
	 * Subtotal.
	 *
	 * Match the condition value against the cart subtotal.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_subtotal( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		// Make sure its formatted correct
		$value = str_replace( ',', '.', $value );

		// WPML multi-currency support
		$value = apply_filters( 'wcml_shipping_price_amount', $value );

		$subtotal = WC()->cart->subtotal;

		if ( '==' == $operator ) :
			$match = ( $subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $subtotal <= $value );
		endif;

		return $match;

	}


	/**
	 * Subtotal excl. taxes.
	 *
	 * Match the condition value against the cart subtotal excl. taxes.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_subtotal_ex_tax( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		// Make sure its formatted correct
		$value = str_replace( ',', '.', $value );

		// WPML multi-currency support
		$value = apply_filters( 'wcml_shipping_price_amount', $value );

		$subtotal = WC()->cart->subtotal_ex_tax;

		if ( '==' == $operator ) :
			$match = ( $subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $subtotal <= $value );
		endif;


		return $match;

	}


	/**
	 * Taxes.
	 *
	 * Match the condition value against the cart taxes.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_tax( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		$taxes = array_sum( (array) WC()->cart->taxes );

		// WPML multi-currency support
		$value = apply_filters( 'wcml_shipping_price_amount', $value );

		if ( '==' == $operator ) :
			$match = ( $taxes == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $taxes != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $taxes >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $taxes <= $value );
		endif;

		return $match;

	}


	/**
	 * Quantity.
	 *
	 * Match the condition value against the cart quantity.
	 * This also includes product quantities.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_quantity( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		$quantity = 0;
                
		foreach ( $package->cart_contents as $item_key => $item ) :
			$quantity += $item['quantity'];
		endforeach;

		if ( '==' == $operator ) :
			$match = ( $quantity == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $quantity != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $quantity >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $quantity <= $value );
		endif;

		return $match;

	}


	/**
	 * Contains product.
	 *
	 * Matches if the condition value product is in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_contains_product( $match, $operator, $value, $package ) {

		foreach ( $package->cart_contents as $product ) :
			$product_ids[] = $product['product_id'];
		endforeach;

		if ( '==' == $operator ) :
			$match = ( in_array( $value, $product_ids ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $product_ids ) );
		endif;

		return $match;

	}


	/**
	 * Coupon.
	 *
	 * Match the condition value against the applied coupons.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_coupon( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		if ( '==' == $operator ) :
			$match = ( in_array( $value, WC()->cart->applied_coupons ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, WC()->cart->applied_coupons ) );
		endif;

		return $match;

	}

	/**
	 * Payment Gateway.
	 *
	 * Match the condition value against the applied payment gateway.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_payment_gateway( $match, $operator, $value, $package ) {

		// True until proven false
		if ( $operator == '!=' ) :
			$match = true;
		endif;
		global $woocommerce;
	    $available_gateways = $woocommerce->payment_gateways->get_available_payment_gateways();
	    $chosen_payment_method = '';

	    if ( ! empty( $value ) && !is_cart() ) {
	           // Chosen Method
	        if ( isset( $woocommerce->session->chosen_payment_method ) && isset( $available_gateways[ $woocommerce->session->chosen_payment_method ] ) ){
	            $chosen_payment_methods = $available_gateways[ $woocommerce->session->chosen_payment_method ];
	            if(!empty($chosen_payment_methods)){
		            foreach ( $chosen_payment_methods as $key => $chosen_payment_method ) :
		            	$payment_methods_id = '';
		            	if ($key == 'id') {
		            		$payment_methods_id = ! empty( $chosen_payment_method ) ? $chosen_payment_method : '';
		            	}
						if ( $operator == '==' ) :
							if ( $payment_methods_id  == $value ) :
								return true;
							endif;
						elseif ( $operator == '!=' ) :
							if ( $payment_methods_id  == $value ) :
								return false;
							endif;
						endif;

					endforeach;
				}
	        }
	    }

		return $match;

	}


	/**
	 * Weight.
	 *
	 * Match the condition value against the cart weight.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_weight( $match, $operator, $value, $package ) {

		$weight = 0;
		foreach ( $package->cart_contents as $key => $item ) :
			$weight += $item['data']->weight * $item['quantity'];
		endforeach;

		$value = (string) $value;

		// Make sure its formatted correct
		$value = str_replace( ',', '.', $value );

		if ( '==' == $operator ) :
			$match = ( $weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $weight <= $value );
		endif;

		return $match;

	}


	/**
	 * Shipping class.
	 *
	 * Matches if the condition value shipping class is in the cart.
	 *
	 * @since 1.0.1
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_contains_shipping_class( $match, $operator, $value, $package ) {

		// True until proven false
		if ( $operator == '!=' ) :
			$match = true;
		endif;

		foreach ( $package->cart_contents as $key => $product ) :

			$id      = ! empty( $product['variation_id'] ) ? $product['variation_id'] : $product['product_id'];
			$product = wc_get_product( $id );

			if ( $operator == '==' ) :
				if ( $product->get_shipping_class() == $value ) :
					return true;
				endif;
			elseif ( $operator == '!=' ) :
				if ( $product->get_shipping_class() == $value ) :
					return false;
				endif;
			endif;

		endforeach;

		return $match;

	}


/******************************************************
 * User conditions
 *****************************************************/


	/**
	 * Zipcode.
	 *
	 * Match the condition value against the users shipping zipcode.
	 *
	 * @since 1.0.0
	 * @since 1.0.9 - Add support for wildcards with asterisk (*)
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_zipcode( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->customer ) ) return $match;

		$user_zipcode = WC()->customer->get_shipping_postcode();

		// Prepare allowed values.
		$zipcodes = (array) preg_split( '/,+ */', $value );

		// Remove all non- letters and numbers
		foreach ( $zipcodes as $key => $zipcode ) :
			$zipcodes[ $key ] = preg_replace( '/[^0-9a-zA-Z\*]/', '', $zipcode );
		endforeach;

		if ( '==' == $operator ) :

			foreach ( $zipcodes as $zipcode ) :

				// @since 1.0.9 - Wildcard support (*)
				if ( strpos( $zipcode, '*' ) !== false ) :

					$user_zipcode = preg_replace( '/[^0-9a-zA-Z]/', '', $user_zipcode );
					$zipcode      = str_replace( '*', '', $zipcode );

					if ( empty( $zipcode ) ) continue;

					$parts = explode( '-', $zipcode );
					if ( count( $parts ) > 1 ) :
						$match = ( $user_zipcode >= min( $parts ) && $user_zipcode <= max( $parts ) );
					else :
						$match = preg_match( '/^' . preg_quote( $zipcode ) . '/i', $user_zipcode );
					endif;

				else :

					// BC when not using asterisk (wildcard)
					$match = ( (double) $user_zipcode == (double) $zipcode );

				endif;

				if ( $match == true ) {
					return true;
				}

			endforeach;

		elseif ( '!=' == $operator ) :

			// True until proven false
			$match = true;

			foreach ( $zipcodes as $zipcode ) :

				// @since 1.0.9 - Wildcard support (*)
				if ( strpos( $zipcode, '*' ) !== false ) :

					$user_zipcode = preg_replace( '/[^0-9a-zA-Z]/', '', $user_zipcode );
					$zipcode      = str_replace( '*', '', $zipcode );

					if ( empty( $zipcode ) ) continue;

					$parts = explode( '-', $zipcode );
					if ( count( $parts ) > 1 ) :
						$zipcode_match = ( $user_zipcode >= min( $parts ) && $user_zipcode <= max( $parts ) );
					else :
						$zipcode_match = preg_match( '/^' . preg_quote( $zipcode ) . '/i', $user_zipcode );
					endif;

					if ( $zipcode_match == true ) :
						return $match = false;
					endif;

				else :

					// BC when not using asterisk (wildcard)
					$zipcode_match = ( (double) $user_zipcode == (double) $zipcode );

					if ( $zipcode_match == true ) :
						return $match = false;
					endif;

				endif;

			endforeach;

		elseif ( '>=' == $operator ) :
			$match = ( (double) $user_zipcode >= (double) $value );
		elseif ( '<=' == $operator ) :
			$match = ( (double) $user_zipcode <= (double) $value );
		endif;

		return $match;

	}


	/**
	 * City.
	 *
	 * Match the condition value against the users shipping city.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_city( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->customer ) ) :
			return $match;
		endif;

		if ( '==' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( in_array( WC()->customer->get_shipping_city(), explode( ',', $value ) ) );
			else :
				$match = ( preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_city() ) );
			endif;

		elseif ( '!=' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( ! in_array( WC()->customer->get_shipping_city(), explode( ',', $value ) ) );
			else :
				$match = ( ! preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_city() ) );
			endif;

		endif;

		return $match;

	}


	/**
	 * State.
	 *
	 * Match the condition value against the users shipping state
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_state( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->customer ) ) :
			return $match;
		endif;

		$state = WC()->customer->get_shipping_country() . '_' . WC()->customer->get_shipping_state();

		if ( '==' == $operator ) :
			$match = ( $state == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $state != $value );
		endif;

		return $match;

	}


	/**
	 * Country.
	 *
	 * Match the condition value against the users shipping country.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_country( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->customer ) ) :
			return $match;
		endif;

		if ( '==' == $operator ) :
			$match = ( preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_country() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_country() ) );
		endif;

		return $match;

	}


	/**
	 * User role.
	 *
	 * Match the condition value against the users role.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_role( $match, $operator, $value, $package ) {

		global $current_user;

		if ( '==' == $operator ) :
			$match = ( array_key_exists( $value, $current_user->caps ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! array_key_exists( $value, $current_user->caps ) );
		endif;

		return $match;

	}


/******************************************************
 * Product conditions
 *****************************************************/


	/**
	 * Width.
	 *
	 * Match the condition value against the widest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_width( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) :
			return $match;
		endif;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_width ) :
				$width[] = ( get_post_meta( $product['data']->variation_id, '_width', true ) );
			else :
				$width[] = ( get_post_meta( $product['product_id'], '_width', true ) );
			endif;

		endforeach;

		$max_width = max( (array) $width );

		if ( '==' == $operator ) :
			$match = ( $max_width == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_width != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_width >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_width <= $value );
		endif;

		return $match;

	}


	/**
	 * Height.
	 *
	 * Match the condition value against the highest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_height( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) :
			return $match;
		endif;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_height ) :
				$height[] = ( get_post_meta( $product['data']->variation_id, '_height', true ) );
			else :
				$height[] = ( get_post_meta( $product['product_id'], '_height', true ) );
			endif;

		endforeach;

		$max_height = max( $height );

		if ( '==' == $operator ) :
			$match = ( $max_height == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_height != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_height >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_height <= $value );
		endif;

		return $match;

	}


	/**
	 * Length.
	 *
	 * Match the condition value against the lenghtiest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_length( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) :
			return $match;
		endif;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_length ) :
				$length[] = ( get_post_meta( $product['data']->variation_id, '_length', true ) );
			else :
				$length[] = ( get_post_meta( $product['product_id'], '_length', true ) );
			endif;

		endforeach;

		$max_length = max( $length );

		if ( '==' == $operator ) :
			$match = ( $max_length == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_length != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_length >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_length <= $value );
		endif;

		return $match;

	}


	/**
	 * Product stock.
	 *
	 * Match the condition value against all cart products stock.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_stock( $match, $operator, $value, $package ) {

		// Get all product stocks
		foreach ( $package->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_stock ) :
				$stock[] = ( get_post_meta( $product['data']->variation_id, '_stock', true ) );
			else :
				$stock[] = ( get_post_meta( $product['product_id'], '_stock', true ) );
			endif;

		endforeach;

		// Get lowest value
		$min_stock = min( $stock );

		if ( '==' == $operator ) :
			$match = ( $min_stock == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $min_stock != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $min_stock >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $min_stock <= $value );
		endif;

		return $match;

	}


	/**
	 * Stock status.
	 *
	 * Match the condition value against all cart products stock statuses.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_stock_status( $match, $operator, $value, $package ) {

		if ( '==' == $operator ) :

			$match = true;
			foreach ( $package->cart_contents as $product ) :

				if ( true == $product['data']->variation_has_stock ) :
					$stock_status = ( get_post_meta( $product['data']->variation_id, '_stock_status', true ) );
				else :
					$stock_status = ( get_post_meta( $product['product_id'], '_stock_status', true ) );
				endif;

				if ( $stock_status != $value ) :
					$match = false;
				endif;

			endforeach;

		elseif ( '!=' == $operator ) :

			$match = true;
			foreach ( $package->cart_contents as $product ) :

				if ( true == $product['data']->variation_has_stock ) :
					$stock_status = ( get_post_meta( $product['data']->variation_id, '_stock_status', true ) );
				else :
					$stock_status = ( get_post_meta( $product['product_id'], '_stock_status', true ) );
				endif;

				if ( $stock_status == $value ) :
					$match = false;
				endif;

			endforeach;

		endif;

		return $match;

	}


	/**
	 * Category.
	 *
	 * Match the condition value against all the cart products category.
	 * With this condition, all the products in the cart must have the given class.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_category( $match, $operator, $value, $package ) {
		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		$match = true;

		foreach (  WC()->cart->cart_contents as $product  ) :
			$product_id = $product['product_id']; 
			$terms = get_the_terms( $product_id, 'product_cat' );
			foreach ($terms as $term) {
			  $product_catids[] = $term->slug;
			}

		endforeach;
		if ( '==' == $operator ) :
			$match = ( in_array( $value, $product_catids ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $product_catids ) );
		endif;
		return $match;

	}


}
