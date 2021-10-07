<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.idomit.com/
 * @since             1.0.0
 * @package           Woocommerce_Advanced_Extra_Fees_Lite
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Advanced Extra Fees Lite
 * Plugin URI:        https://www.idomit.com/
 * Description:       WooCommerce Advanced Extra Fees Lite Plugins allows you to configure advanced fees conditions with <strong>conditional logic!</strong>
 * Version:           1.0.21
 * Author:            IDOMIT
 * Author URI:        https://www.idomit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-advanced-extra-fees-lite
 * Domain Path:       /languages
 * WC tested up to:   5.7.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOCOMMERCE_ADVANCED_EXTRA_FEES_LITE_VERSION', '1.0.21' );

if (!defined('WCPOA_LITE_PLUGIN_BASENAME')) {
    define('WCPOA_LITE_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-lite-activator.php
 */
function activate_woocommerce_advanced_extra_fees_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite-activator.php';
	Woocommerce_Advanced_Extra_Fees_Lite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-lite-deactivator.php
 */
function deactivate_woocommerce_advanced_extra_fees_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite-deactivator.php';
	Woocommerce_Advanced_Extra_Fees_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_advanced_extra_fees_lite' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_advanced_extra_fees_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_advanced_extra_fees_lite() {

	$plugin = new Woocommerce_Advanced_Extra_Fees_Lite();
	$plugin->run();

}
run_woocommerce_advanced_extra_fees_lite();
