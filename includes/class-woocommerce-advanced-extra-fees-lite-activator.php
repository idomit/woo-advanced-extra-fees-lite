<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 * @author     IDOMIT <info@idomit.com>
 */
class Woocommerce_Advanced_Extra_Fees_Lite_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		set_transient( '_welcome_screen_activation_redirect_data', true, 30 );
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            wp_die("<strong> WooCommerce Advanced Extra Fees Lite</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . esc_url(get_admin_url(null, 'plugins.php')) . "'>Plugins page</a>.");
	        wp_die(
		        sprintf( "<strong>%s</strong> %s <strong>%s</strong> <a href='%s'>%s</a>",
			        esc_html__( 'WooCommerce Advanced Extra Fees Lite', 'woocommerce-advanced-extra-fees' ),
			        esc_html__( 'Plugin requires', 'woocommerce-advanced-extra-fees' ),
			        esc_html__( 'WooCommerce', 'woocommerce-advanced-extra-fees' ),
			        esc_url( get_admin_url( null, 'plugins.php' ) ),
			        esc_html__( 'Plugins page', 'woocommerce-advanced-extra-fees' )
		        )
	        );
        }
	}

}
