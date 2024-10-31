<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/includes
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
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Multi_Currency_Switcher_For_Woocommerce {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Mwb_Multi_Currency_Switcher_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $mwb_mmcsfw_onboard    To initializsed the object of class onboard.
	 */
	protected $mwb_mmcsfw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( defined( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.2.1';
		}

		$this->plugin_name = __( 'mwb-multi-currency-switcher-for-woocommerce', 'mwb-multi-currency-switcher-for-woocommerce' );

		$this->mwb_multi_currency_switcher_for_woocommerce_dependencies();
		$this->mwb_multi_currency_switcher_for_woocommerce_locale();
		if ( is_admin() ) {
			$this->mwb_multi_currency_switcher_for_woocommerce_admin_hooks();
		} else {
			$this->mwb_multi_currency_switcher_for_woocommerce_public_hooks();
		}
		$this->mwb_multi_currency_switcher_for_woocommerce_common_hooks();

		$this->mwb_multi_currency_switcher_for_woocommerce_api_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_Multi_Currency_Switcher_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_Multi_Currency_Switcher_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Mwb_Multi_Currency_Switcher_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Mwb_Multi_Currency_Switcher_For_Woocommerce_Common. Defines all hooks for the common area.
	 * - Mwb_Multi_Currency_Switcher_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-multi-currency-switcher-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.

			if ( is_dir( plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'Mwb_Multi_Currency_Switcher_For_Woocommerce_Onboarding_Steps' ) ) {
				include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce-onboarding-steps.php';
			}

			if ( class_exists( 'Mwb_Multi_Currency_Switcher_For_Woocommerce_Onboarding_Steps' ) ) {
				$mwb_mmcsfw_onboard_steps = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwb-multi-currency-switcher-for-woocommerce-public.php';
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/dependency/class-mwb-multi-currency-switcher-for-woocommerce-dependency.php';
		}
		// The class responsible for defining all actions that occur in the public-facing side of the site.
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/dependency/class-mwb-multi-currency-switcher-for-woocommerce-dependency.php';

		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-mwb-multi-currency-switcher-for-woocommerce-rest-api.php';
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-mwb-mmcsfw-currency-switcher-widget.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-mwb-multi-currency-switcher-for-woocommerce-common.php';

		/**
		 * This class responsible for widet at front end functionality
		 * of the plugin.
		 */

		$this->loader = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_Multi_Currency_Switcher_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_locale() {
		$plugin_i18n = new Mwb_Multi_Currency_Switcher_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_admin_hooks() {

		$mwb_mmcsfw_plugin_admin = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Admin( $this->mwb_mmcsfw_get_plugin_name(), $this->mwb_mmcsfw_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_enqueue_scripts' );

		// Add settings menu for MWB Multi Currency Switcher for WooCommerce.
		$this->loader->add_action( 'admin_menu', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_options_page' );
		$this->loader->add_action( 'admin_menu', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_submenu_page', 15 );
		$this->loader->add_filter( 'mwb_mmcsfw_general_settings_array', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_general_settings_page', 10 );
		$this->loader->add_filter( 'mwb_mmcsfw_side_switcher_settings_array', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_side_switcher_settings_page', 10 );
		$this->loader->add_filter( 'mwb_mmcsfw_side_switcher_settings_array_button', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_side_switcher_button_settings', 10 );
		$this->loader->add_filter( 'mwb_mmcsfw_general_settings_array_for_save_buttton', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_general_settings_page_save_button', 10 );
		$this->loader->add_filter( 'mwb_mmcsfw_advance_tab_settings_array', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_advance_tab_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_save_tab_settings' );
		$this->loader->add_action( 'admin_init', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_save_advance_tab_settings' );
		$this->loader->add_action( 'admin_init', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_admin_save_side_switcher_settings' );
		$this->loader->add_filter( 'woocommerce_locate_core_template', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_locate_woocommerce_template', 10, 3 );
		$this->loader->add_filter( 'woocommerce_locate_template', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_locate_woocommerce_template', 10, 3 );
		// Schedule for suto update.

		// Auto update rates.
		$this->loader->add_action( 'mwb_mmcsfw_rate_update_action_schedule', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_rate_auto_update' );
		$this->loader->add_action( 'mwb_mmcsfw_currency_switcher_general_setting_saving', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_saving_of_general_settings' );
		$this->loader->add_filter( 'mwb_mmcsfw_currency_switcher_add_currency_settings', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_load_currency_settings_in_general_tab' );
		$this->loader->add_action( 'widgets_init', $mwb_mmcsfw_plugin_admin, 'mwb_mmcsfw_register_currency_switcher_widget' );

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_common_hooks() {
		$mwb_mmcsfw_plugin_common = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Common( $this->mwb_mmcsfw_get_plugin_name(), $this->mwb_mmcsfw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_common_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_common_enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_common_enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_nopriv_mwb_mmcsfw_add_price_through_ajax', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_add_price_through_ajax' );
		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_add_price_through_ajax', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_add_price_through_ajax' );

		$this->loader->add_action( 'wp_ajax_nopriv_mwb_mmcsfw_admin_fetch_currency_rates', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_admin_fetch_currency_rates' );
		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_admin_fetch_currency_rates', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_admin_fetch_currency_rates' );

		$this->loader->add_action( 'wp_ajax_nopriv_mwb_mmcsfw_feature_saving_throgh_ajax', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_feature_saving_throgh_ajax' );
		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_feature_saving_throgh_ajax', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_feature_saving_throgh_ajax' );

		$this->loader->add_action( 'wp_ajax_nopriv_mwb_mmcsfw_include_modal_data', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_include_modal_data' );
		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_include_modal_data', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_include_modal_data' );

		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_save_geolocation_data', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_save_geolocation_data' );
		$this->loader->add_action( 'wp_ajax_mwb_mmcsfw_action_to_get_variation_price', $mwb_mmcsfw_plugin_common, 'mwb_mmcsfw_action_to_get_variation_price' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_public_hooks() {
		$mwb_mmcsfw_plugin_public = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Public( $this->mwb_mmcsfw_get_plugin_name(), $this->mwb_mmcsfw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_public_enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_woocommerce_before_calculate_totals_oncart', 98 );
		$this->loader->add_filter( 'woocommerce_available_payment_gateways', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_hide_gateways' );
		$this->loader->add_filter( 'woocommerce_currency_symbol', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_add_custom_symbol', 10, 2 );
		// Detect country code.
		$this->loader->add_action( 'template_redirect', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_check_user_country_acc_ipaddress', 99 );
		$this->loader->add_filter( 'pre_option_woocommerce_currency_pos', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_change_currency_position_cart' );
		$this->loader->add_filter( 'wc_get_price_thousand_separator', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_custom_wc_get_price_thousand_separator', 10, 1 );
		$this->loader->add_filter( 'woocommerce_format_price_range', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_change_price_range_for_variation', 10, 3 );
		$this->loader->add_action( 'wp_head', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_add_side_switcher' );
		$this->loader->add_action( 'widgets_init', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_register_currency_switcher_widget' );
		$this->loader->add_action( 'init', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_add_shortcode' );
		$this->loader->add_action( 'woocommerce_thankyou_order_received_text', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_calculate_order_table_value', 99, 2 );
		$this->loader->add_filter( 'woocommerce_coupon_get_discount_amount', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_filter_woocommerce_coupon_get_discount_amount', 9999, 5 );
		$this->loader->add_filter( 'woocommerce_package_rates', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_custom_shipping_costs', 20, 2 );
		$this->loader->add_action( 'woocommerce_currency', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_change_woocommerce_currency_at_checkout', 10, 1 );
		$this->loader->add_action( 'woocommerce_coupon_loaded', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_woocommerce_coupon_loaded', 9999 );
		$this->loader->add_filter( 'woocommerce_get_price_html', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_change_product_price_display', 10, 2 );
		$this->loader->add_filter( 'woocommerce_cart_product_price', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_change_woocommerce_cart_product_price', 10, 2 );
		$this->loader->add_filter( 'woocommerce_cart_subtotal', $mwb_mmcsfw_plugin_public, 'mwb_mmcsfw_modifiy_cart_total', 10, 3 );

	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function mwb_multi_currency_switcher_for_woocommerce_api_hooks() {

		$mwb_mmcsfw_plugin_api = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Rest_Api( $this->mwb_mmcsfw_get_plugin_name(), $this->mwb_mmcsfw_get_version() );

		$this->loader->add_action( 'rest_api_init', $mwb_mmcsfw_plugin_api, 'mwb_mmcsfw_add_endpoint' );
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_run() {
		$this->loader->mwb_mmcsfw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function mwb_mmcsfw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Mwb_Multi_Currency_Switcher_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function mwb_mmcsfw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Mwb_Multi_Currency_Switcher_For_Woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function mwb_mmcsfw_get_onboard() {
		return $this->mwb_mmcsfw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function mwb_mmcsfw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_mmcsfw_plug tabs.
	 *
	 * @return Array       An key=>value pair of MWB Multi Currency Switcher for WooCommerce tabs.
	 */
	public function mwb_mmcsfw_plug_default_tabs() {

		$mwb_mmcsfw_default_tabs = array();
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-overview'] = array(
			'title' => esc_html__( 'Overview', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-overview',
		);
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-general'] = array(
			'title' => esc_html__( 'Currency Settings', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-general',
		);
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-admin-currency-advance-tab'] = array(
			'title' => esc_html__( 'Advanced Settings', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-admin-currency-advance-tab',
		);
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-admin-currency-geolocation-tab'] = array(
			'title' => esc_html__( 'Geolocation Rules', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-admin-currency-geolocation-tab',
		);
		$mwb_mmcsfw_default_tabs = apply_filters( 'mwb_mmcsfw_plugin_standard_admin_settings_tabs_after_geo', $mwb_mmcsfw_default_tabs );
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-admin-currency-side-switcher'] = array(
			'title' => esc_html__( 'Side Switcher', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-admin-currency-side-switcher',
		);
		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-plugin-currency-shortcodes'] = array(
			'title' => esc_html__( 'Shortcodes And Widgets', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-plugin-currency-shortcodes',
		);
		$mwb_mmcsfw_default_tabs = apply_filters( 'mwb_mmcsfw_plugin_standard_admin_settings_tabs_before_system_status', $mwb_mmcsfw_default_tabs );

		$mwb_mmcsfw_default_tabs['mwb-multi-currency-switcher-for-woocommerce-system-status'] = array(
			'title' => esc_html__( 'System Status', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'name'  => 'mwb-multi-currency-switcher-for-woocommerce-system-status',
		);

		return $mwb_mmcsfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since 1.0.0
	 * @param string $path   path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_mmcsfw_plug_load_template( $path, $params = array() ) {
		$mmcsfw_file_path = $path;

		if ( file_exists( $mmcsfw_file_path ) ) {
			include $mmcsfw_file_path;
		} else {

			/* translators: %s: file path */
			$mwb_mmcsfw_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'mwb-multi-currency-switcher-for-woocommerce' ), $mmcsfw_file_path );
			$this->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param string $mwb_mmcsfw_message Message to display.
	 * @param string $type           notice type, accepted values - error/update/update-nag.
	 * @since 1.0.0
	 */
	public static function mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_message, $type = 'error' ) {

		$mwb_mmcsfw_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$mwb_mmcsfw_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$mwb_mmcsfw_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$mwb_mmcsfw_classes .= 'notice-success is-dismissible';
				break;

			default:
				$mwb_mmcsfw_classes .= 'notice-error is-dismissible';
		}

		$mwb_mmcsfw_notice  = '<div class="' . esc_attr( $mwb_mmcsfw_classes ) . ' mwb-errorr-8">';
		$mwb_mmcsfw_notice .= '<p>' . esc_html( $mwb_mmcsfw_message ) . '</p>';
		$mwb_mmcsfw_notice .= '</div>';

		echo wp_kses_post( $mwb_mmcsfw_notice );
	}


	/**
	 * Show WordPress and server info.
	 *
	 * @return Array $mwb_mmcsfw_system_data       returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_mmcsfw_plug_system_status() {
		global $wpdb;
		$mwb_mmcsfw_system_status    = array();
		$mwb_mmcsfw_wordpress_status = array();
		$mwb_mmcsfw_system_data      = array();

		// Get the web server.
		$mwb_mmcsfw_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$mwb_mmcsfw_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the server's IP address.
		$mwb_mmcsfw_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$mwb_mmcsfw_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$mwb_mmcsfw_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the server path.
		$mwb_mmcsfw_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the OS.
		$mwb_mmcsfw_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get WordPress version.
		$mwb_mmcsfw_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get and count active WordPress plugins.
		$mwb_mmcsfw_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// See if this site is multisite or not.
		$mwb_mmcsfw_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'mwb-multi-currency-switcher-for-woocommerce' ) : __( 'No', 'mwb-multi-currency-switcher-for-woocommerce' );

		// See if WP Debug is enabled.
		$mwb_mmcsfw_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'mwb-multi-currency-switcher-for-woocommerce' ) : __( 'No', 'mwb-multi-currency-switcher-for-woocommerce' );

		// See if WP Cache is enabled.
		$mwb_mmcsfw_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'mwb-multi-currency-switcher-for-woocommerce' ) : __( 'No', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$mwb_mmcsfw_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the number of published WordPress posts.
		$mwb_mmcsfw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get PHP memory limit.
		$mwb_mmcsfw_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the PHP error log path.
		$mwb_mmcsfw_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'mwb-multi-currency-switcher-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$mwb_mmcsfw_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get PHP max post size.
		$mwb_mmcsfw_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$mwb_mmcsfw_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$mwb_mmcsfw_system_status['php_architecture'] = '64-bit';
		} else {
			$mwb_mmcsfw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$mwb_mmcsfw_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Show the number of processes currently running on the server.
		$mwb_mmcsfw_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the memory usage.
		$mwb_mmcsfw_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$mwb_mmcsfw_system_status['is_windows'] = true;
			$mwb_mmcsfw_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'mwb-multi-currency-switcher-for-woocommerce' );
		}

		// Get the memory limit.
		$mwb_mmcsfw_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );

		// Get the PHP maximum execution time.
		$mwb_mmcsfw_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'mwb-multi-currency-switcher-for-woocommerce' );
		$mwb_mmcsfw_system_data['php']                      = $mwb_mmcsfw_system_status;
		$mwb_mmcsfw_system_data['wp']                       = $mwb_mmcsfw_wordpress_status;

		return $mwb_mmcsfw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param string $mwb_mmcsfw_components html to display.
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_components = array() ) {
		if ( is_array( $mwb_mmcsfw_components ) && ! empty( $mwb_mmcsfw_components ) ) {
			foreach ( $mwb_mmcsfw_components as $mwb_mmcsfw_component ) {
				if ( ! empty( $mwb_mmcsfw_component['type'] ) && ! empty( $mwb_mmcsfw_component['id'] ) ) {
					switch ( $mwb_mmcsfw_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>
						<div class="mwb-form-group mwb-mmcsfw-<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
									<?php
										echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
									?>
														</label>
													</div>
													<div class="mwb-form-group__control">
														<label class="mdc-text-field mdc-text-field--outlined">
															<span class="mdc-notched-outline">
																<span class="mdc-notched-outline__leading"></span>
																<span class="mdc-notched-outline__notch">
																	<?php if ( 'number' != $mwb_mmcsfw_component['type'] ) { ?>
																		<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?></span>
																	<?php } ?>
																</span>
																<span class="mdc-notched-outline__trailing"></span>
															</span>
															<input class="mdc-text-field__input <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" type="<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>" value="<?php echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_attr( $mwb_mmcsfw_component['value'] ) : '' ); ?>" placeholder="<?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?>">
														</label>
														<div class="mdc-text-field-helper-line">
															<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></div>
														</div>
													</div>
												</div>
												<?php
							break;
						case 'password':
							?>
												<div class="mwb-form-group">
													<div class="mwb-form-group__label">
														<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
															<?php
															echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
															?>
														</label>
													</div>
													<div class="mwb-form-group__control">
														<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
															<span class="mdc-notched-outline">
																<span class="mdc-notched-outline__leading"></span>
																<span class="mdc-notched-outline__notch">
																</span>
																<span class="mdc-notched-outline__trailing"></span>
															</span>
															<input class="mdc-text-field__input <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?> mwb-form__password" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" type="<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>" value="<?php echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_attr( $mwb_mmcsfw_component['value'] ) : '' ); ?>" placeholder="<?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?>">
															<i id="mwb-password-hidden-id" class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
														</label>
														<div class="mdc-text-field-helper-line">
															<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></div>
														</div>
													</div>
												</div>
												<?php
							break;

						case 'textarea':
							?>
												<div class="mwb-form-group">
													<div class="mwb-form-group__label">
														<label class="mwb-form-label" for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>">
															<?php
																echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
															?>
																				</label>
																			</div>
																			<div class="mwb-form-group__control">
																				<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea" for="text-field-hero-input">
																					<span class="mdc-notched-outline">
																						<span class="mdc-notched-outline__leading"></span>
																						<span class="mdc-notched-outline__notch">
																							<span class="mdc-floating-label"><?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?></span>
																						</span>
																						<span class="mdc-notched-outline__trailing"></span>
																					</span>
																					<span class="mdc-text-field__resizer">
																						<textarea class="mdc-text-field__input <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" placeholder="<?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?>">
																							<?php
																								echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_textarea( $mwb_mmcsfw_component['value'] ) : '' ); // WPCS: XSS ok.
																							?>
																							</textarea>
																						</span>
																					</label>

																				</div>
																			</div>

																			<?php
							break;

						case 'select':
						case 'multiselect':
							?>
																			<div class="mwb_form_select_wrapper mwb-form-group">
																				<div class="mwb-form-group__label">
																					<label class="mwb-form-label" for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>">
																							<?php
																								echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
																							?>
																					</label>
																				</div>
																				<div class="mwb-form-group__control">
																					<div class="mwb-form-select">
																						<select id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : '' ); ?><?php echo ( 'multiselect' === $mwb_mmcsfw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $mwb_mmcsfw_component['type'] ? 'multiple="multiple"' : ''; ?>>
																							<?php
																							foreach ( $mwb_mmcsfw_component['options'] as $mwb_mmcsfw_key => $mwb_mmcsfw_val ) {
																								?>
																								<option value="<?php echo esc_attr( $mwb_mmcsfw_key ); ?>" 
																									<?php
																									if ( is_array( $mwb_mmcsfw_component['value'] ) ) {
																										selected( in_array( (string) $mwb_mmcsfw_key, $mwb_mmcsfw_component['value'], true ), true );
																									} else {
																										selected( $mwb_mmcsfw_component['value'], (string) $mwb_mmcsfw_key );
																									}
																									?>
																									>
																									<?php echo esc_html( $mwb_mmcsfw_val ); ?>
																								</option>
																								<?php
																							}
																							?>
																						</select>
																						<label class="mdl-textfield__label" for="octane"><?php echo esc_html( $mwb_mmcsfw_component['description'] ); ?><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></label>
																					</div>
																				</div>
																			</div>
																		<?php
							break;

						case 'checkbox':
							?>
																		<div class="mwb-form-group">
																			<div class="mwb-form-group__label">
																				<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
																					<?php
																						echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
																					?>
														</label>
													</div>
													<div class="mwb-form-group__control mwb-pl-4">
														<div class="mdc-form-field">
															<div class="mdc-checkbox">
																<input name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" type="checkbox" class="mdc-checkbox__native-control <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" value="<?php echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_attr( $mwb_mmcsfw_component['value'] ) : '' ); ?>" <?php checked( $mwb_mmcsfw_component['value'], '1' ); ?> />
																<div class="mdc-checkbox__background">
																	<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
																		<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
																	</svg>
																	<div class="mdc-checkbox__mixedmark"></div>
																</div>
																<div class="mdc-checkbox__ripple"></div>
															</div>
															<label for="checkbox-1"><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></label>
														</div>
													</div>
												</div>
												<?php
							break;

						case 'radio':
							?>
												<div class="mwb-form-group ">
													<div class="mwb-form-group__label">
														<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
															<?php
															echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
															?>
														</label>
													</div>
													<div class="mwb-form-group__control mwb-pl-4">
														<div class="mwb-flex-col">
															<?php
															foreach ( $mwb_mmcsfw_component['options'] as $mwb_mmcsfw_radio_key => $mwb_mmcsfw_radio_val ) {
																?>
																<div class="mdc-form-field">
																	<div class="mdc-radio">
																		<input name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" value="<?php echo esc_attr( $mwb_mmcsfw_radio_key ); ?>" type="radio" class="mdc-radio__native-control <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" <?php checked( $mwb_mmcsfw_radio_key, $mwb_mmcsfw_component['value'] ); ?>>
																		<div class="mdc-radio__background">
																			<div class="mdc-radio__outer-circle"></div>
																			<div class="mdc-radio__inner-circle"></div>
																		</div>
																		<div class="mdc-radio__ripple"></div>
																	</div>
																	<label for="radio-1"><?php echo esc_html( $mwb_mmcsfw_radio_val ); ?></label>
																</div>
																<?php
															}
															?>
														</div>
													</div>
													</div>
												<?php
							break;

						case 'radio-switch':
							?>

												<div class="mwb-form-group">
													<div class="mwb-form-group__label">
														<label for="" class="mwb-form-label">
															<?php
															echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
															?>
								</label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $mwb_mmcsfw_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" role="switch" aria-checked="
											<?php
											if ( 'on' == $mwb_mmcsfw_component['value'] ) {
												echo 'true';
											} else {
												echo 'false';
											}
											?>
											" <?php checked( $mwb_mmcsfw_component['value'], 'on' ); ?>>
										</div>
									</div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'button':
							?>
						<div class="mwb_form_submit_btn_wrapper mwb-form-group">
							<div class="mwb-form-group__control mwb_currency_form_submit_btn">
								<button class="mdc-button mdc-button--raised" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>"><?php echo ( ! empty( $mwb_mmcsfw_component['button_text'] ) ? esc_html( $mwb_mmcsfw_component['button_text'] ) : '' ); ?></span>
								</button>
							</div>	

						</div>
							<?php
							break;

						case 'multi':
							?>
						<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
									<?php
															echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
									?>
														</label>
													</div>
													<div class="mwb-form-group__control">
														<?php
														foreach ( $mwb_mmcsfw_component['value'] as $component ) {
															?>
															<label class="mdc-text-field mdc-text-field--outlined">
																<span class="mdc-notched-outline">
																	<span class="mdc-notched-outline__leading"></span>
																	<span class="mdc-notched-outline__notch">
																		<?php if ( 'number' != $component['type'] ) { ?>
																			<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?></span>
																		<?php } ?>
																	</span>
																	<span class="mdc-notched-outline__trailing"></span>
																</span>
																<input class="mdc-text-field__input <?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $component['id'] ); ?>" type="<?php echo esc_attr( $component['type'] ); ?>" value="<?php echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_attr( $mwb_mmcsfw_component['value'] ) : '' ); ?>" placeholder="<?php echo ( ! empty( $mwb_mmcsfw_component['placeholder'] ) ? esc_attr( $mwb_mmcsfw_component['placeholder'] ) : '' ); ?>" <?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>>
															</label>
														<?php } ?>
														<div class="mdc-text-field-helper-line">
															<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></div>
														</div>
													</div>
												</div>
												<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
												<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>">
													<div class="mwb-form-group__label">
														<label for="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="mwb-form-label">
															<?php
															echo ( ! empty( $mwb_mmcsfw_component['title'] ) ? esc_html( $mwb_mmcsfw_component['title'] ) : '' ); // WPCS: XSS ok.
															?>
														</label>
													</div>
													<div class="mwb-form-group__control">
														<label class="mdc-text-field mdc-text-field--outlined">
															<input class="<?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" type="<?php echo esc_attr( $mwb_mmcsfw_component['type'] ); ?>" value="<?php echo ( ! empty( $mwb_mmcsfw_component['value'] ) ? esc_attr( $mwb_mmcsfw_component['value'] ) : '' ); ?>" <?php echo esc_html( ( 'date' === $mwb_mmcsfw_component['type'] ) ? 'max=' . gmdate( 'Y-m-d', strtotime( gmdate( 'Y-m-d', mktime() ) . ' + 365 day' ) ) . ' min=' . gmdate( 'Y-m-d' ) . '' : '' ); ?>>
														</label>
														<div class="mdc-text-field-helper-line">
															<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( ! empty( $mwb_mmcsfw_component['description'] ) ? esc_attr( $mwb_mmcsfw_component['description'] ) : '' ); ?></div>
														</div>
													</div>
												</div>
													<?php
							break;

						case 'submit':
							?>
												<tr valign="top">
													<td scope="row">
														<input type="submit" class="button button-primary" name="<?php echo ( ! empty( $mwb_mmcsfw_component['name'] ) ? esc_html( $mwb_mmcsfw_component['name'] ) : esc_html( $mwb_mmcsfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwb_mmcsfw_component['id'] ); ?>" class="<?php echo ( ! empty( $mwb_mmcsfw_component['class'] ) ? esc_attr( $mwb_mmcsfw_component['class'] ) : '' ); ?>" value="<?php echo esc_attr( $mwb_mmcsfw_component['button_text'] ); ?>" />
													</td>
												</tr>
												<?php
							break;

						default:
							break;
					}
				}
			}
		}

	}
}
