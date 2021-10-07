<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAEF_Lite_Ajax.
 *
 * Initialize the AJAX class.
 *
 * @class		WAEF_Lite_Ajax
 * @author		idomit
 * @package		WooCommerce Advanced Extra Fees
 * @version		1.0.0
 */
class WAEF_Lite_Ajax {


	/**
	 * Constructor.
	 *
	 * Add ajax actions in order to work.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Add elements
		add_action( 'wp_ajax_waef_add_condition', array( $this, 'waef_add_condition' ) );
		add_action( 'wp_ajax_waef_add_condition_group', array( $this, 'waef_add_condition_group' ) );

		// Update elements
		add_action( 'wp_ajax_waef_update_condition_value', array( $this, 'waef_update_condition_value' ) );
		add_action( 'wp_ajax_waef_update_condition_description', array( $this, 'waef_update_condition_description' ) );

		// Save shipping method ordering
		add_action( 'wp_ajax_waef_save_shipping_rates_table', array( $this, 'save_shipping_rates_table' ) );

	}


	/**
	 * Add condition.
	 *
	 * Create a new WAEF_Lite_Condition class and render.
	 *
	 * @since 1.0.0
	 */
	public function waef_add_condition() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		new WAEF_Lite_Condition( null, $_POST['group'] );
		wp_die();

	}


	/**
	 * Condition group.
	 *
	 * Render new condition group.
	 *
	 * @since 1.0.0
	 */
	public function waef_add_condition_group() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		?><div class='condition-group condition-group-<?php echo ($_POST['group']) ? $_POST['group'] : ''; ?>' data-group='<?php echo ($_POST['group']) ? $_POST['group'] : ''; ?>'>

			<p class='or-match'><?php esc_html_e( 'Or match all of the following rules to allow this shipping method:', 'woocommerce-advanced-extra-fees' );?></p><?php

			new WAEF_Lite_Condition( null, $_POST['group'] );

		?></div>

		<p class='or-text'><strong><?php esc_html_e( 'Or', 'woocommerce-advanced-extra-fees' ); ?></strong></p><?php

		wp_die();

	}


	/**
	 * Update values.
	 *
	 * Retreive and render the new condition values according to the condition key.
	 *
	 * @since 1.0.0
	 */
	public function waef_update_condition_value() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		waef_lite_condition_values( $_POST['id'], $_POST['group'], $_POST['condition'] );
		wp_die();

	}


	/**
	 * Update description.
	 *
	 * Render the corresponding description for the condition key.
	 *
	 * @since 1.0.0
	 */
	public function waef_update_condition_description() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		waef_lite_condition_description( $_POST['condition'] );
		wp_die();

	}


	/**
	 * Save order.
	 *
	 * Save the shipping method order.
	 *
	 * @since 1.0.4
	 */
	public function save_shipping_rates_table() {

		global $wpdb;

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		$args = wp_parse_args( $_POST['form'] );

		// Save order
		$menu_order = 0;
		foreach ( $args['sort'] as $sort ) :

			$wpdb->update(
				$wpdb->posts,
				array( 'menu_order' => $menu_order ),
				array( 'ID' => $sort ),
				array( '%d' ),
				array( '%d' )
			);

			$menu_order++;

		endforeach;

		wp_die();

	}


}
