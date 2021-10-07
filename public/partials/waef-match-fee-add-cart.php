<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( class_exists( 'WAEF_advanced_extra_fees_Method' ) ) return; // Stop if the class already exists

/**
 * Class WAEF_advanced_extra_fees_Method.
 *
 * WooCommerce Advanced Extra Fees method class.
 *
 * @class		WAEF_advanced_extra_fees_Method
 * @author		idomit
 * @package		WooCommerce Advanced Extra Fees
 * @version		1.0.0
 */
class WAEF_advanced_extra_fees_Method {
        
        /**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->id                 = 'advanced_extra_fees';
		$this->title              = esc_html__( 'Advanced Fees (configurable per rate)', 'woocommerce-advanced-extra-fees' );
		$this->method_title       = esc_html__( 'Advanced Fees', 'woocommerce-advanced-extra-fees' );
		$this->method_description = esc_html__( 'Configure WooCommerce Advanced Extra Fees', 'woocommerce-advanced-extra-fees' );

		$this->init();

		do_action( 'Woocommerce_Advanced_Extra_Fees_method_init' );
	}


	/**
	 * Init.
	 *
	 * Initialize WAEF fees method.
	 *
	 * @since 1.0.0
	 */
	function init() {
        add_action('woocommerce_cart_calculate_fees', array( $this,'conditional_fee_add_to_cart'));
	}


	/**
	 * Match methods.
	 *
	 * Checks all created WAEF fees have a matching condition group.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $package List of shipping package data.
	 * @return array          List of all matched fees.
	 */
	public function waef_match_methods( $package ) {
		$matched_methods = array();
		$methods         = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'waef', 'orderby' => 'menu_order', 'order' => 'ASC' ) );

		foreach ( $methods as $method ) :

			$condition_groups = get_post_meta( $method->ID, '_waef_conditions', true );

			// Check if method conditions match
			$match = $this->waef_match_conditions( $condition_groups, $package );

			// Add match to array
			if ( true == $match ) :
				$matched_methods[] = $method->ID;
			endif;

		endforeach;
		return $matched_methods;

	}


	/**
	 * Match conditions.
	 *
	 * Check if conditions match, if all conditions in one condition group
	 * matches it will return TRUE and the shipping method will display.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $condition_groups List of condition groups containing their conditions.
	 * @param  array $package          List of shipping package data.
	 * @return BOOL                    TRUE if all the conditions in one of the condition groups matches true.
	 */
	public function waef_match_conditions( $condition_groups = array(), $package = array() ) {

		if ( empty( $condition_groups ) ) return false;

		foreach ( $condition_groups as $condition_group => $conditions ) :

			$match_condition_group = true;

			foreach ( $conditions as $condition ) :

				$condition = apply_filters( 'waef_match_condition_values', $condition );
				$match     = apply_filters( 'waef_match_condition_' . $condition['condition'], false, $condition['operator'], $condition['value'], $package );

				if ( false == $match ) :
					$match_condition_group = false;
				endif;

			endforeach;

			// return true if one condition group matches
			if ( true == $match_condition_group ) :
				return true;
			endif;

		endforeach;

		return false;

	}
	
	/**
	 * Calculate fees.
	 *
	 * Calculate the fees and set settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $package List containing all products for this method.
	 */
	public function conditional_fee_add_to_cart( $package ) {
        global $woocommerce;
		$this->matched_methods = $this->waef_match_methods( $package );
             
		if ( false == $this->matched_methods || ! is_array( $this->matched_methods )) return;

		foreach ( $this->matched_methods as $method_id ) :
			global $woocommerce;
			$match_details = get_post_meta( $method_id, '_waef_shipping_method', true );
			$label 			= $match_details['fees_title'];
			$this->cost			= $match_details['fees_cost'];
			$this->taxable			= $match_details['tax'];
			$rate = apply_filters( 'waef_shipping_rate', array(
				'id'       => $method_id,
				'label'    => ( null == $label ) ? esc_html__( 'Advance Extra Fees', 'woocommerce-advanced-extra-fees' ) : $label,
				'cost'     => $this->cost,
				'taxes'    => ( 'taxable' == $this->taxable ) ? true : false,
				'calc_tax' => 'per_order',
			), $package, $this );
					$percentage_sign = substr($rate['cost'], -1); 
					if($percentage_sign == '%'){
						$percentage = substr($rate['cost'], 0, -1);
						$surcharge_calc = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;
						$surcharge = $surcharge_calc / 100; 
                        $woocommerce->cart->add_fee($rate['label'], $surcharge ,$rate['taxes'], '');
					}else{
						$woocommerce->cart->add_fee($rate['label'], $rate['cost'],$rate['taxes'], '');
					}

		endforeach;

	}


	/**
	 * Hide shipping.
	 *
	 * Hide fees when regular or
	 * advanced shipping free shipping is available.
	 *
	 * @since 1.0.0
	 * @since 1.0.7 - Show all free Advanced Fees rates
	 *
	 * @param  array $available_methods
	 * @return array
	 */
	public function hide_all_shipping_when_free_is_available( $available_methods ) {

		if ( 'no' == $this->hide_shipping ) :
			return $available_methods;
		endif;

		$fees_costs = wp_list_pluck( (array) $available_methods, 'cost' );
		if ( in_array( 0, $fees_costs ) ) :
			foreach ( $available_methods as $key => $method ) :

				if ( 0 != $method->cost ) :
					unset( $available_methods[ $key ] );
				endif;

			endforeach;
		endif;

		return $available_methods;

	}

    
}