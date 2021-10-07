<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/includes
 * @author     IDOMIT <info@idomit.com>
 */
class Woocommerce_Advanced_Extra_Fees_Lite {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_Advanced_Extra_Fees_Lite_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOOCOMMERCE_ADVANCED_EXTRA_FEES_LITE_VERSION' ) ) {
			$this->version = WOOCOMMERCE_ADVANCED_EXTRA_FEES_LITE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woocommerce-advanced-extra-fees-lite';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Advanced_Extra_Fees_Lite_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Advanced_Extra_Fees_Lite_i18n. Defines internationalization functionality.
	 * - Woocommerce_Advanced_Extra_Fees_Lite_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_Advanced_Extra_Fees_Lite_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-advanced-extra-fees-lite-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-advanced-extra-fees-lite-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-advanced-extra-fees-lite-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-advanced-extra-fees-lite-public.php';

		$this->loader = new Woocommerce_Advanced_Extra_Fees_Lite_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Advanced_Extra_Fees_Lite_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Advanced_Extra_Fees_Lite_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		global $pagenow;
		$plugin_admin = new Woocommerce_Advanced_Extra_Fees_Lite_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] == 'waef'){
	        
	        do_action( 'Woocommerce_Advanced_Extra_Fees_method_init' );
	    }       
	    // Add to WC Screen IDs to load scripts.
		$this->loader->add_filter( 'woocommerce_screen_ids', $plugin_admin, 'add_waef_screen_ids'  );
                
		// Enqueue scripts
		// $this->loader->add_action( 'admin_enqueue_scripts',$plugin_admin, 'admin_enqueue_scripts'  );
                
        // Register post type
		$this->loader->add_action( 'init', $plugin_admin, 'waef_register_post_type' );

		// Add/save meta boxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'waef_post_type_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'waef_save_meta' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'waef_save_condition_meta' );

		// Edit user notices
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'waef_custom_post_type_messages'  );

		// Redirect after delete
		$this->loader->add_action( 'load-edit.php', $plugin_admin, 'waef_redirect_after_trash' );

        // Keep WC menu open while in WAEF edit screen
		$this->loader->add_action( 'admin_head', $plugin_admin, 'menu_highlight' );
		
		if ( 'plugins.php' == $pagenow ) :
			// Plugins page
			$this->loader->add_filter( 'plugin_action_links_' . WCPOA_LITE_PLUGIN_BASENAME , $plugin_admin,  'waef_lite_add_plugin_action_links', 10, 2 );
		endif;
		if ( isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] == 'waef' || 'plugins.php' == $pagenow ) :
			$this->loader->add_action( 'init', $plugin_admin, 'waef_add_plugin_notice' );
		endif;
		// Admin Menu
		$this->loader->add_action( 'admin_menu',  $plugin_admin, 'add_waef_menu_item' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_Advanced_Extra_Fees_Lite_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'waef_fees_method' );
		$this->loader->add_action( 'init', $plugin_public, 'waef_fees_match_method' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Advanced_Extra_Fees_Lite_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
