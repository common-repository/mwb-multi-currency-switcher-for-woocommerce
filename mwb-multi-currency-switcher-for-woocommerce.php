<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Mwb_Multi_Currency_Switcher_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Multi Currency Switcher For WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/mwb-multi-currency-switcher-for-woocommerce/
 * Description:       MWB Multi Currency Switcher For WooCommerce is used to allow your site visitors to switch product price into different currencies.
 * Version:           1.2.1
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mwb-multi-currency-switcher-for-woocommerce
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Tested up to:      5.8.2
 * WC requires at least: 4.0
 * WC tested up to:   5.9
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
// To Activate plugin only when WooCommerce is active.

/**
 * Function to check for plugin activation.
 *
 * @param string $plugin_slug is the slug of the plugin.
 */
function mwb_multi_currency_switcher_is_plugin_active( $plugin_slug = '' ) {
	if ( empty( $plugin_slug ) ) {

		return;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}

	return in_array( $plugin_slug, $active_plugins ) || array_key_exists( $plugin_slug, $active_plugins );
}

/**
 * Checking whether the dependent plugin is active or not.
 */
function mwb_multi_currency_switcher_plugin_activation() {
	$activation['status']  = true;
	$activation['message'] = '';

	// If dependent plugin is not active.
	if ( ! mwb_multi_currency_switcher_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status']  = false;
		$activation['message'] = 'woo_inactive';
	}

	return $activation;

}

// The following code runs during the activation of the plugin.
$mwb_multi_currency_switcher_plugin_activation = mwb_multi_currency_switcher_plugin_activation();

if ( true === $mwb_multi_currency_switcher_plugin_activation['status'] ) {
	/**
	 * Define plugin constants.
	 *
	 * @since             1.0.0
	 */
	function define_mwb_multi_currency_switcher_for_woocommerce_constants() {

		mwb_multi_currency_switcher_for_woocommerce_constants( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION', '1.2.1' );
		mwb_multi_currency_switcher_for_woocommerce_constants( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		mwb_multi_currency_switcher_for_woocommerce_constants( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		mwb_multi_currency_switcher_for_woocommerce_constants( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		mwb_multi_currency_switcher_for_woocommerce_constants( 'MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'MWB Multi Currency Switcher for WooCommerce' );
	}


	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param   String $key    Key for contant.
	 * @param   String $value   value for contant.
	 * @since             1.0.0
	 */
	function mwb_multi_currency_switcher_for_woocommerce_constants( $key, $value ) {

		if ( ! defined( $key ) ) {
			define( $key, $value );
		}
	}


	/**
	 * The code that runs during plugin activation.
	 *
	 * @param [type] $network_wide is for multisite.
	 * @return void
	 */
	function activate_mwb_multi_currency_switcher_for_woocommerce( $network_wide ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce-activator.php';
		Mwb_Multi_Currency_Switcher_For_Woocommerce_Activator::mwb_multi_currency_switcher_for_woocommerce_activate( $network_wide );
		$mwb_mmcsfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_mmcsfw_active_plugin ) && ! empty( $mwb_mmcsfw_active_plugin ) ) {
			$mwb_mmcsfw_active_plugin['mwb-multi-currency-switcher-for-woocommerce'] = array(
				'plugin_name' => __( 'MWB Multi Currency Switcher For WooCommerce', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'active'      => '1',
			);
		} else {
			$mwb_mmcsfw_active_plugin = array();
			$mwb_mmcsfw_active_plugin['mwb-multi-currency-switcher-for-woocommerce'] = array(
				'plugin_name' => __( 'MWB Multi Currency Switcher For WooCommerce', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'active'      => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_mmcsfw_active_plugin );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-mwb-multi-currency-switcher-for-woocommerce-deactivator.php
	 */
	function deactivate_mwb_multi_currency_switcher_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce-deactivator.php';
		Mwb_Multi_Currency_Switcher_For_Woocommerce_Deactivator::mwb_multi_currency_switcher_for_woocommerce_deactivate();
		$mwb_mmcsfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_mmcsfw_deactive_plugin ) && ! empty( $mwb_mmcsfw_deactive_plugin ) ) {
			foreach ( $mwb_mmcsfw_deactive_plugin as $mwb_mmcsfw_deactive_key => $mwb_mmcsfw_deactive ) {
				if ( 'mwb-multi-currency-switcher-for-woocommerce' === $mwb_mmcsfw_deactive_key ) {
					$mwb_mmcsfw_deactive_plugin[ $mwb_mmcsfw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_mmcsfw_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'activate_mwb_multi_currency_switcher_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_mwb_multi_currency_switcher_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-multi-currency-switcher-for-woocommerce.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_mwb_multi_currency_switcher_for_woocommerce() {
		define_mwb_multi_currency_switcher_for_woocommerce_constants();

		$mwb_mmcsfw_plugin_standard = new Mwb_Multi_Currency_Switcher_For_Woocommerce();
		$mwb_mmcsfw_plugin_standard->mwb_mmcsfw_run();
		$GLOBALS['mwb_mmcsfw_obj'] = $mwb_mmcsfw_plugin_standard;

	}
	run_mwb_multi_currency_switcher_for_woocommerce();


	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_multi_currency_switcher_for_woocommerce_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since    1.0.0
	 * @param   Array $links    Settings link array.
	 */
	function mwb_multi_currency_switcher_for_woocommerce_settings_link( $links ) {

		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=mwb_multi_currency_switcher_for_woocommerce_menu' ) . '">' . __( 'Settings', 'mwb-multi-currency-switcher-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $links );
	}



	/**
	 * Scheduler for auto update rates with action scheduler.
	 *
	 * @version 1.0.0
	 */
	function mwb_mmcsfw_scheduler_log() {

		$schedules = array(
			'min15'      => 15 * MINUTE_IN_SECONDS,
			'min30'      => 30 * MINUTE_IN_SECONDS,
			'min45'      => 45 * MINUTE_IN_SECONDS,
			'hourly'     => HOUR_IN_SECONDS,
			'twicedaily' => HOUR_IN_SECONDS * 12,
			'daily'      => DAY_IN_SECONDS,
			'week'       => WEEK_IN_SECONDS,
			'month'      => WEEK_IN_SECONDS * 4,
			'min1'       => MINUTE_IN_SECONDS,
		);
		$timing    = get_option( 'mwb_mmcsfw_currency_rate_auto_update' );
		foreach ( $schedules as $key => $value ) {
			if ( $key === $timing ) {
				$timing = $value;
			}
		}

		if ( false === as_next_scheduled_action( 'mwb_mmcsfw_rate_update_action_schedule' ) ) {
			as_schedule_recurring_action( time(), $timing, 'mwb_mmcsfw_rate_update_action_schedule' );
		}
	}

	add_action( 'init', 'mwb_mmcsfw_scheduler_log' );

	/**
	 * Scheduled Action calling function
	 *
	 * @return void
	 */
	function mwb_mmcsfw_rate_update_action_schedule_data() {
		if ( ! class_exists( 'Mwb_Multi_Currency_Switcher_For_Woocommerce_Admin' ) ) {
			require plugin_dir_path( __FILE__ ) . 'admin/class-mwb-multi-currency-switcher-for-woocommerce-admin.php';
		}
		$mwb_mmcsfw_plugin_admin = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Admin( '', '' );
		$mwb_mmcsfw_plugin_admin->mwb_mmcsfw_rate_auto_update();

	}
	add_action( 'mwb_mmcsfw_rate_update_action_schedule', 'mwb_mmcsfw_rate_update_action_schedule_data' );

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param array  $links_array array containing the links to plugin.
	 * @param string $plugin_file_name plugin file name.
	 * @return array
	 */
	function mwb_multi_currency_switcher_for_woocommerce_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a href="https://demo.makewebbetter.com/mwb-multi-currency-switcher-for-woocommerce" target="_blank"><img src="' . esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">' . __( 'Demo', 'mwb-multi-currency-switcher-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href=" https://docs.makewebbetter.com/mwb-multi-currency-switcher-for-woocommerce/" target="_blank"><img src="' . esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">' . __( 'Documentation', 'mwb-multi-currency-switcher-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="https://support.makewebbetter.com/wordpress-plugins-knowledge-base/category/mwb-multi-currency-switcher-for-woocommerce/
			" target="_blank"><img src="' . esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">' . __( 'Support', 'mwb-multi-currency-switcher-for-woocommerce' ) . '</a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'mwb_multi_currency_switcher_for_woocommerce_custom_settings_at_plugin_tab', 10, 2 );

} else {

	// Deactivate the plugin if Woocommerce not active.
	add_action( 'admin_init', 'mwb_membership_plugin_activation_failure' );

	/**
	 * Deactivate the plugin.
	 */
	function mwb_membership_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	if ( is_multisite() ) {
		add_action( 'network_admin_notices', 'mwb_multi_currency_switcher_plugin_activation_notice' );
	} else {
		add_action( 'admin_notices', 'mwb_multi_currency_switcher_plugin_activation_notice' );
	}

	/**
	 * This function displays plugin activation error notices.
	 */
	function mwb_multi_currency_switcher_plugin_activation_notice() {

		global $mwb_multi_currency_switcher_plugin_activation;

		// To hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

		<?php if ( 'woo_inactive' === $mwb_multi_currency_switcher_plugin_activation['message'] ) { ?>

			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?><strong><?php esc_html_e( 'MWB Multi Currency Switcher For WooCommerce', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></strong><?php esc_html_e( '.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></p>
			</div>

			<?php
		}
	}
}



