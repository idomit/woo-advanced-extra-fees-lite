<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 * @author     IDOMIT <info@idomit.com>
 */
class Woocommerce_Advanced_Extra_Fees_Lite_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-advanced-extra-fees-lite',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
