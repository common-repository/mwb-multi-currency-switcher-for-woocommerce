<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, && two examples hooks for how to
 * enqueue the admin-specific stylesheet && JavaScript.
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Multi_Currency_Switcher_For_Woocommerce_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class && set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwb_mmcsfw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( ! empty( $screen->id ) && 'makewebbetter_page_mwb_multi_currency_switcher_for_woocommerce_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-mmcsfw-select2-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-multi-currency-switcher-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-mmcsfw-meterial-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-mmcsfw-meterial-css2', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-mmcsfw-meterial-lite', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-mmcsfw-meterial-icons-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/', array(), time(), 'all' );
			wp_enqueue_script( 'mwb-datatables', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables.net/js/jquery.dataTables.min.js', array(), time(), false );
			wp_enqueue_style( $this->plugin_name . '-admin-global', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-multi-currency-switcher-for-woocommerce-admin-global.css', array( 'mwb-mmcsfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-multi-currency-switcher-for-woocommerce-admin.scss', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-fontawesome-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/all.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-admin-min-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
			wp_enqueue_media();
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwb_mmcsfw_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();

		if ( ! empty( $screen->id ) && 'makewebbetter_page_mwb_multi_currency_switcher_for_woocommerce_menu' === $screen->id || 'shop_coupon' === $screen->id || 'woocommerce_page_wc-settings' === $screen->id ) {
			wp_enqueue_script( 'mwb-mmcsfw-select2', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-multi-currency-switcher-for-woocommerce-select2.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-mmcsfw-metarial-js', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-mmcsfw-metarial-js2', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-mmcsfw-metarial-lite', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-fontawesome-js', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/fontawesome.min.js', array(), time(), false );
			wp_register_script( $this->plugin_name . 'admin-js', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-multi-currency-switcher-for-woocommerce-admin.js', array( 'jquery', 'mwb-mmcsfw-select2', 'mwb-mmcsfw-metarial-js', 'mwb-mmcsfw-metarial-js2', 'mwb-mmcsfw-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'mwb_mmcsfw_admin_param',
				array(
					'ajaxurl'               => admin_url( 'admin-ajax.php' ),
					'reloadurl'             => admin_url( 'admin.php?page=mwb_multi_currency_switcher_for_woocommerce_menu' ),
					'mmcsfw_gen_tab_enable' => get_option( 'mmcsfw_radio_switch_demo' ),
					'regular_price'         => __( 'Regular price', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'sales_price'           => __( 'Sales price', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'currency'              => __( ' Currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'coupon_currency'       => __( 'Coupon Amount', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'path_image'            => MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL,
					'alert_currency_code'   => __( 'Please Enter 3 letters of Country Code !!! ', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no_currency_code'      => __( 'No currency available!!', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'confirm_msg'      => __( 'Hi! In the free version of MWB Multi Currency Switcher For WooCommerce  you can operate with ANY of the 3 currencies! For more currencies upgrade to the premium version?', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'Already_added'      => __( 'Already added', 'mwb-multi-currency-switcher-for-woocommerce' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );

			// Adding mwb-admin.js js to the page.
			wp_register_script( 'admin-script', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script(
				'admin-script',
				'mcs_adminjs_param',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'ajax-nonce' ),

				)
			);
			wp_enqueue_script( 'admin-script' );
			wp_enqueue_media(); // Enqueue these default WordPress file.
		}

		if ( 'product' == $screen->id ) {
			wp_register_script( $this->plugin_name . 'admin-js', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-multi-currency-switcher-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'mwb_mmcsfw_admin_param',
				array(
					'ajaxurl'               => admin_url( 'admin-ajax.php' ),
					'reloadurl'             => admin_url( 'admin.php?page=mwb_multi_currency_switcher_for_woocommerce_menu' ),
					'mmcsfw_gen_tab_enable' => get_option( 'mmcsfw_radio_switch_demo' ),
					'regular_price'         => __( 'Regular price', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'sales_price'           => __( 'Sales price', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'currency'              => __( ' Currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'coupon_currency'       => __( 'Coupon Amount', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'path_image'            => MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL,
					'alert_currency_code'   => __( 'Please Enter 3 letters of Country Code !!! ', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no_currency_code'      => __( 'No currency available!!', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'confirm_msg'      => __( 'Hi! In the free version of MWB Multi Currency Switcher For WooCommerce  you can operate with ANY of the 3 currencies! For more currencies upgrade to the premium version?', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'Already_added'      => __( 'Already added', 'mwb-multi-currency-switcher-for-woocommerce' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
	}

	/**
	 * Adding settings menu for MWB Multi Currency Switcher for WooCommerce.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter' ), __( 'MakeWebBetter' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/MWB_Grey-01.svg', 15 );
			$mwb_mmcsfw_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $mwb_mmcsfw_menus ) && ! empty( $mwb_mmcsfw_menus ) ) {
				foreach ( $mwb_mmcsfw_menus as $mwb_mmcsfw_key => $mwb_mmcsfw_value ) {
					add_submenu_page( 'mwb-plugins', $mwb_mmcsfw_value['name'], $mwb_mmcsfw_value['name'], 'manage_options', $mwb_mmcsfw_value['menu_link'], array( $mwb_mmcsfw_value['instance'], $mwb_mmcsfw_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * MWB Multi Currency Switcher for WooCommerce mwb_mmcsfw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function mwb_mmcsfw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'MWB Multi Currency Switcher For WooCommerce', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'slug'      => 'mwb_multi_currency_switcher_for_woocommerce_menu',
			'menu_link' => 'mwb_multi_currency_switcher_for_woocommerce_menu',
			'instance'  => $this,
			'function'  => 'mwb_mmcsfw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * MWB Multi Currency Switcher for WooCommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			include MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * MWB Multi Currency Switcher for WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_options_menu_html() {

		include_once MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-multi-currency-switcher-for-woocommerce-admin-dashboard.php';
	}

	/**
	 * MWB Multi Currency Switcher for WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwb_mmcsfw_settings_general_button Settings fields.
	 */
	public function mwb_mmcsfw_admin_general_settings_page_save_button( $mwb_mmcsfw_settings_general_button ) {

		$mwb_mmcsfw_settings_general_button = array(

			array(
				'type'        => 'button',
				'id'          => 'mmcsfw_button_demo',
				'button_text' => __( 'Save', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'class'       => 'mmcsfw-button-class',
			),
		);
		$mwb_mmcsfw_settings_general_button = apply_filters( 'mwb_currency_switcher_general_settings_after_save_button', $mwb_mmcsfw_settings_general_button );
		return $mwb_mmcsfw_settings_general_button;

	}

	/**
	 * MWB Multi Currency Switcher for WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwb_mmcsfw_settings_side_switcher Settings fields.
	 */
	public function mwb_mmcsfw_admin_side_switcher_settings_page( $mwb_mmcsfw_settings_side_switcher ) {

		$mwb_mmcsfw_settings_side_switcher = array(
			array(
				'title'       => __( 'Enable Side Switcher', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable to see switcher at the front-end ', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_side_switcher_style',
				'name'        => 'mmcsfw_radio_switch_side_switcher_style',
				'value'       => get_option( 'mmcsfw_radio_switch_side_switcher_style' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Switcher Style', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'mmcsfw_radio_ddl_side_switcher_style',
				'name'        => 'mmcsfw_radio_ddl_side_switcher_style',
				'value'       => get_option( 'mmcsfw_radio_ddl_side_switcher_style' ),
				'class'       => 'mcs-select-class mcs_select_aggregator',
				'placeholder' => __( 'Select Demo', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'options'     => $this->mwb_mmcsfw_get_style_side_switcher_tab(),
			),
			array(
				'title'       => __( 'Switcher Position', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'mmcsfw_radio_ddl_side_switcher_position',
				'name'        => 'mmcsfw_radio_ddl_side_switcher_position',
				'value'       => get_option( 'mmcsfw_radio_ddl_side_switcher_position' ),
				'class'       => 'mcs-select-class mcs_select_aggregator',
				'placeholder' => __( 'Select Demo', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'options'     => $this->mwb_mmcsfw_get_position_side_switcher_tab(),
			),
		);
		$mwb_mmcsfw_settings_side_switcher = apply_filters( 'mwb_currency_switcher_side_switcher_setting_after_save_button', $mwb_mmcsfw_settings_side_switcher );
		return $mwb_mmcsfw_settings_side_switcher;
	}

	/**
	 * MWB Multi Currency Switcher for WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwb_mmcsfw_settings_general_button Settings fields.
	 */
	public function mwb_mmcsfw_admin_side_switcher_button_settings( $mwb_mmcsfw_settings_general_button ) {

		$mwb_mmcsfw_settings_general_button = array(
			array(
				'type'        => 'button',
				'id'          => 'mmcsfw_button_side_switcher_tab',
				'button_text' => __( 'Save', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'class'       => 'mmcsfw-button-class',
			),
		);
		$mwb_mmcsfw_settings_general_button = apply_filters( 'mwb_currency_switcher_side_switcher_settings_after_save_button', $mwb_mmcsfw_settings_general_button );
		return $mwb_mmcsfw_settings_general_button;

	}


	/**
	 * Get position options for side switcher tab.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_mmcsfw_get_position_side_switcher_tab() {
		$mwb_mmcsfw_side_switcher_position = array(
			''      => __( 'Select option', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'left'  => __( 'Left', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'right' => __( 'Right', 'mwb-multi-currency-switcher-for-woocommerce' ),
		);
		return apply_filters( 'mmcsfw_get_side_switcher_position', $mwb_mmcsfw_side_switcher_position );
	}


	/**
	 * Get style options for side switcher tab.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_mmcsfw_get_style_side_switcher_tab() {
		$mwb_mmcsfw_side_switcher_style = array(
			'Roll' => __( 'Roll Block', 'mwb-multi-currency-switcher-for-woocommerce' ),
		);
		return apply_filters( 'mmcsfw_get_side_switcher_style', $mwb_mmcsfw_side_switcher_style );
	}


	/**
	 * MWB Multi Currency Switcher for WooCommerce save advance tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_admin_save_side_switcher_settings() {
		global $mwb_mmcsfw_obj;
		$mwb_mmcsfw_gen_flag = false;
		if ( isset( $_POST['mwb-mmcsfw-currency-switcher-side-switcher-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb-mmcsfw-currency-switcher-side-switcher-nonce'] ) ), 'currency-switcher-side-switcher-nounce' ) ) {
				wp_die();
			}
		}
		if ( isset( $_POST['mmcsfw_button_side_switcher_tab'] ) ) {
			update_option( 'mwb_mmcsfw_hover_color', isset( $_POST['mwb_mmcsfw_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_hover_color'] ) ) : '' );
			update_option( 'mwb_mmcsfw_main_color', isset( $_POST['mwb_mmcsfw_main_color'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_main_color'] ) ) : '' );
			update_option( 'mwb_mmcsfw_currency_color', isset( $_POST['mwb_mmcsfw_currency_color'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_currency_color'] ) ) : '' );
			update_option( 'mwb_mmcsfw_currency_description_color', isset( $_POST['mwb_mmcsfw_currency_description_color'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_currency_description_color'] ) ) : '' );
			update_option( 'mmcsfw_radio_ddl_side_switcher_style', isset( $_POST['mmcsfw_radio_ddl_side_switcher_style'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_ddl_side_switcher_style'] ) ) : '' );
			update_option( 'mmcsfw_radio_ddl_side_switcher_position', isset( $_POST['mmcsfw_radio_ddl_side_switcher_position'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_ddl_side_switcher_position'] ) ) : '' );
			update_option( 'mmcsfw_radio_switch_side_switcher_style', isset( $_POST['mmcsfw_radio_switch_side_switcher_style'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_side_switcher_style'] ) ) : '' );

			if ( isset( $_POST['mmcsfw_button_side_switcher_tab'] ) ) {

				if ( $mwb_mmcsfw_gen_flag ) {
					$mwb_mmcsfw_error_text = esc_html__( 'Id of some field is missing', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'error' );
				} else {
					$mwb_mmcsfw_error_text = esc_html__( 'Side Switcher Settings saved !', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'success' );
				}
				do_action( 'mwb_currency_switcher_side_switcher_setting_saving' );

			}
		}
	}

	/**
	 * MWB Multi Currency Switcher for WooCommerce admin advance tab page.
	 *
	 * @since 1.0.0
	 * @param array $mwb_mmcsfw_settings_advance_tab_button Settings fields.
	 */
	public function mwb_mmcsfw_admin_advance_tab_settings_page( $mwb_mmcsfw_settings_advance_tab_button ) {

		$mwb_mmcsfw_settings_advance_tab_button1 = array(
			array(
				'title'       => __( 'Select Welcome Currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'mwb_mmcsfw_select_welcome_currency',
				'name'        => 'mwb_mmcsfw_select_welcome_currency',
				'value'       => get_option( 'mwb_mmcsfw_select_welcome_currency' ),
				'class'       => 'mcs-select-class mcs_select_aggregator',
				'placeholder' => __( 'Select Demo', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'options'     => $this->mwb_mmcsfw_get_currency_advance_tab(),
			),
			array(
				'title'       => __( 'Hide Side Switcher on Shop Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide switcher on the shop page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_switcher_shop',
				'name'        => 'mmcsfw_radio_switch_advance_hide_switcher_shop',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_switcher_shop' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Hide Widget on shop Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide widget on the shop page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_widget_shop',
				'name'        => 'mmcsfw_radio_switch_advance_hide_widget_shop',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_widget_shop' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Hide Side Switcher on Cart Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide switcher on the cart page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_switcher_cart',
				'name'        => 'mmcsfw_radio_switch_advance_hide_switcher_cart',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_switcher_cart' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Hide Widget on Cart Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide widget on the cart page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_widget_cart',
				'name'        => 'mmcsfw_radio_switch_advance_hide_widget_cart',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_widget_cart' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Hide Side Switcher on Checkout Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide switcher on the checkout page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_switcher_checkout',
				'name'        => 'mmcsfw_radio_switch_advance_hide_switcher_checkout',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_switcher_checkout' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Hide Widget on Checkout Page', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Hide widget on the checkout page for any of your reason', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_advance_hide_widget_checkout',
				'name'        => 'mmcsfw_radio_switch_advance_hide_widget_checkout',
				'value'       => get_option( 'mmcsfw_radio_switch_advance_hide_widget_checkout' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Geolocation Rules', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable GeoIP rules for visitors', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_geoip_rules',
				'name'        => 'mmcsfw_radio_switch_geoip_rules',
				'value'       => get_option( 'mmcsfw_radio_switch_geoip_rules' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
		);
		$mwb_mmcsfw_settings_advance_tab_button1  = apply_filters( 'mwb_currency_switcher_advance_settings_after_geo_rules', $mwb_mmcsfw_settings_advance_tab_button1 );
		$mwb_mmcsfw_settings_advance_tab_button_2 = array(
			array(
				'title'       => __( 'Enable Custom Price for Product', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable To set a custom price for the product according to currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_custom_product',
				'name'        => 'mmcsfw_radio_switch_custom_product',
				'value'       => get_option( 'mmcsfw_radio_switch_custom_product' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Custom Coupon for Product', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable To set custom coupon according to currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_custom_coupon',
				'name'        => 'mmcsfw_radio_switch_custom_coupon',
				'value'       => get_option( 'mmcsfw_radio_switch_custom_coupon' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Shipping Price for Product', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable To set custom shipping price according to currency', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_custom_shipping',
				'name'        => 'mmcsfw_radio_switch_custom_shipping',
				'disabled'    => 'disabled',
				'value'       => get_option( 'mmcsfw_radio_switch_custom_shipping' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'type'        => 'button',
				'id'          => 'mmcsfw_button_advance_tab',
				'button_text' => __( 'Save', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'class'       => 'mmcsfw-button-class',
			),
		);
		$mwb_mmcsfw_settings_advance_tab_button   = array_merge( $mwb_mmcsfw_settings_advance_tab_button1, $mwb_mmcsfw_settings_advance_tab_button_2 );
		$mwb_mmcsfw_settings_advance_tab_button   = apply_filters( 'mwb_currency_switcher_advance_settings_after_save_button', $mwb_mmcsfw_settings_advance_tab_button );
		return $mwb_mmcsfw_settings_advance_tab_button;
	}



	/**
	 * Get currency options for advance tab.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_mmcsfw_get_currency_advance_tab() {
		$welcome_currency = get_option( 'mwb_mmcsfw_select_welcome_currency' );

		$index = get_option( 'mwb_mmcsfw_number_of_currency' );

		if ( empty( $index ) ) {
			$currency_array = array( '--No option found--' );
		} else {
			if ( empty( $welcome_currency ) ) {
				$currency_array = array( '--Select any option--' );
			} else {
				$currency_array = array();
			}
		}
		$count = 0;
		for ( $i = 1; $i <= $index; $i++ ) {

			$currency = esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
			if ( ! empty( $currency ) ) {
				++$count;
			}
			if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
				break;
			}
			if ( ! empty( $currency ) ) {
				$currency_array[ $currency ] = $currency;
			}
		}

		$selected_welcome_currency = get_option( 'mwb_mmcsfw_select_welcome_currency' );

		if ( ! in_array( $selected_welcome_currency, $currency_array, true ) ) {

			update_option( 'mwb_mmcsfw_select_welcome_currency', get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ) );
		}

		return apply_filters( 'mmcsfw_get_currency_option', $currency_array );
	}



	/**
	 * MWB Multi Currency Switcher for WooCommerce save advance tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_admin_save_advance_tab_settings() {
		global $mwb_mmcsfw_obj;
		$mwb_mmcsfw_gen_flag = false;
		if ( isset( $_POST['mwb-mmcsfw-currency-switcher-advance-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb-mmcsfw-currency-switcher-advance-nonce'] ) ), 'currency-switcher-advance-nounce' ) ) {
				wp_die();
			}
		}

		if ( isset( $_POST['mmcsfw_button_advance_tab'] ) ) {
			update_option( 'mmcsfw_radio_switch_geoip_rules', isset( $_POST['mmcsfw_radio_switch_geoip_rules'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_geoip_rules'] ) ) : '' );
			update_option( 'mmcsfw_radio_switch_advance_hide_switcher_shop', isset( $_POST['mmcsfw_radio_switch_advance_hide_switcher_shop'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_switcher_shop'] ) ) : '' );
			update_option( 'mmcsfw_radio_switch_advance_hide_widget_shop', isset( $_POST['mmcsfw_radio_switch_advance_hide_widget_shop'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_widget_shop'] ) ) : '' );

			update_option( 'mmcsfw_radio_switch_advance_hide_switcher_cart', isset( $_POST['mmcsfw_radio_switch_advance_hide_switcher_cart'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_switcher_cart'] ) ) : '' );
			update_option( 'mmcsfw_radio_switch_advance_hide_widget_cart', isset( $_POST['mmcsfw_radio_switch_advance_hide_widget_cart'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_widget_cart'] ) ) : '' );

			update_option( 'mmcsfw_radio_switch_advance_hide_switcher_checkout', isset( $_POST['mmcsfw_radio_switch_advance_hide_switcher_checkout'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_switcher_checkout'] ) ) : '' );
			update_option( 'mmcsfw_radio_switch_advance_hide_widget_checkout', isset( $_POST['mmcsfw_radio_switch_advance_hide_widget_checkout'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_advance_hide_widget_checkout'] ) ) : '' );
			update_option( 'mwb_mmcsfw_select_welcome_currency', isset( $_POST['mwb_mmcsfw_select_welcome_currency'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_select_welcome_currency'] ) ) : '' );

			if ( isset( $_POST['mmcsfw_button_advance_tab'] ) ) {

				if ( $mwb_mmcsfw_gen_flag ) {
					$mwb_mmcsfw_error_text = esc_html__( 'Id of some field is missing', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'error' );
				} else {
					$mwb_mmcsfw_error_text = esc_html__( 'Advance Settings saved !', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'success' );
				}
				do_action( 'mwb_currency_switcher_advance_setting_saving' );

			}
		}
	}


	/**
	 * MWB Multi Currency Switcher for WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwb_mmcsfw_settings_general Settings fields.
	 */
	public function mwb_mmcsfw_admin_general_settings_page( $mwb_mmcsfw_settings_general ) {

		$mwb_mmcsfw_settings_general = array(
			array(
				'title'       => __( 'Enable Plugin Functionality ', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable plugin to start the functionality.', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'id'          => 'mmcsfw_radio_switch_demo',
				'value'       => get_option( 'mmcsfw_radio_switch_demo' ),
				'class'       => 'mmcsfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'mwb-multi-currency-switcher-for-woocommerce' ),
					'no'  => __( 'NO', 'mwb-multi-currency-switcher-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Select Currency  Aggregator', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'mwb_mmcsfw_select_aggregator',
				'name'        => 'mwb_mmcsfw_select_aggregator',
				'value'       => get_option( 'mwb_mmcsfw_select_aggregator' ),
				'class'       => 'mcs-select-class mcs_select_aggregator',
				'placeholder' => __( 'Select Demo', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'options'     => $this->mwb_mmcsfw_get_aggregators(),
			),
			array(
				'title'       => __( 'Currency rate auto-update', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'mwb_mmcsfw_currency_rate_auto_update',
				'name'        => 'mwb_mmcsfw_currency_rate_auto_update',
				'value'       => get_option( 'mwb_mmcsfw_currency_rate_auto_update' ),
				'class'       => 'mcs-select-class mcs_select_aggregator',
				'placeholder' => __( 'Select Demo', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'options'     => apply_filters(
					'mmcsfw_get_auto_update_option',
					array(
						''           => __( 'Select option', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'min1'       => __( 'Every minute', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'min15'      => __( 'Every 15 minutes', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'min30'      => __( 'Every 30 minutes', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'min45'      => __( 'Every 45 minutes', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'hourly'     => __( 'Every Hour', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'twicedaily' => __( 'Twice Daily', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'daily'      => __( 'Daily', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'week'       => __( 'Weekly', 'mwb-multi-currency-switcher-for-woocommerce' ),
						'month'      => __( 'Monthly', 'mwb-multi-currency-switcher-for-woocommerce' ),
					)
				),
			),
		);
		$mwb_mmcsfw_settings_general = apply_filters( 'mwb_currency_switcher_general_settings', $mwb_mmcsfw_settings_general );
		return $mwb_mmcsfw_settings_general;
	}

	/**
	 * Get aggregator options function.
	 *
	 * @return array
	 */
	public function mwb_mmcsfw_get_aggregators() {
		$aggregator = array(
			''                => __( 'Select option', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'yahooapi'        => __( 'Yahoo Finance API', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'romanieibank'    => __( 'www.bnr.ro (Bank of romaniei)', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'bankeuropean'    => __( 'The Free Currency Converter by European Central Bank', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'bankofitaly'     => __( 'Bank of Italy', 'mwb-multi-currency-switcher-for-woocommerce' ),
			'exchangerateapi' => __( 'Exchange rate', 'mwb-multi-currency-switcher-for-woocommerce' ),
		);
		return apply_filters( 'mwb_mmcsfw_get_aggregators', $aggregator );
	}


	/**
	 * MWB Multi Currency Switcher for WooCommerce save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_admin_save_tab_settings() {

		global $mwb_mmcsfw_obj;

		if ( isset( $_POST['mwb-mmcsfw-currency-switcher-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb-mmcsfw-currency-switcher-nonce'] ) ), 'currency-switcher-nounce' ) ) {
				wp_die();
			}
		}

		if ( isset( $_POST['mmcsfw_button_demo'] ) ) {
			$rate_update = get_option( 'mwb_mmcsfw_currency_rate_auto_update' );
			if ( isset( $_POST['mwb_mmcsfw_currency_rate_auto_update'] ) ) {
				$_rate_update_post = sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_currency_rate_auto_update'] ) );
			}
			if ( $_rate_update_post !== $rate_update ) {
				As_unschedule_action( 'mwb_mmcsfw_rate_update_action_schedule' );
			}
			$mwb_mmcsfw_gen_flag         = false;
			$mwb_mmcsfw_genaral_settings = apply_filters( 'mwb_mmcsfw_general_settings_array', array() );
			$mwb_mmcsfw_button_index     = array_search( 'submit', array_column( $mwb_mmcsfw_genaral_settings, 'type' ), true );
			if ( isset( $mwb_mmcsfw_button_index ) && ( null === $mwb_mmcsfw_button_index || '' === $mwb_mmcsfw_button_index ) ) {
				$mwb_mmcsfw_button_index = array_search( 'button', array_column( $mwb_mmcsfw_genaral_settings, 'type' ), true );
			}
			if ( isset( $mwb_mmcsfw_button_index ) && '' !== $mwb_mmcsfw_button_index ) {
				unset( $mwb_mmcsfw_genaral_settings[ $mwb_mmcsfw_button_index ] );
				if ( is_array( $mwb_mmcsfw_genaral_settings ) && ! empty( $mwb_mmcsfw_genaral_settings ) ) {
					foreach ( $mwb_mmcsfw_genaral_settings as $mwb_mmcsfw_genaral_setting ) {
						if ( isset( $mwb_mmcsfw_genaral_setting['id'] ) && '' !== $mwb_mmcsfw_genaral_setting['id'] ) {
							if ( isset( $_POST[ $mwb_mmcsfw_genaral_setting['id'] ] ) ) {
								update_option( $mwb_mmcsfw_genaral_setting['id'], sanitize_text_field( wp_unslash( $_POST[ $mwb_mmcsfw_genaral_setting['id'] ] ) ) );
							} else {
								update_option( $mwb_mmcsfw_genaral_setting['id'], '' );
							}
						} else {
							$mwb_mmcsfw_gen_flag = true;
						}
					}
				}
				if ( $mwb_mmcsfw_gen_flag ) {
					$mwb_mmcsfw_error_text = esc_html__( 'Id of some field is missing', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'error' );
				} else {
					$mwb_mmcsfw_error_text = esc_html__( 'Currency Settings saved !', 'mwb-multi-currency-switcher-for-woocommerce' );
					$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'success' );
				}
				do_action( 'mwb_mmcsfw_currency_switcher_general_setting_saving' );

			}
		}
	}



	/**
	 * MWB Multi Currency Switcher for WooCommerce save currency tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_saving_of_general_settings() {

		if ( isset( $_POST['mwb-mmcsfw-currency-switcher-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb-mmcsfw-currency-switcher-nonce'] ) ), 'currency-switcher-nounce' ) ) {
				wp_die();
			}
		}
		if ( isset( $_POST['mwb_mmcsfw_checkbox'] ) ) {
			update_option( 'mwb_mmcsfw_text_currency_checkbox', sanitize_text_field( wp_unslash( $_POST['mwb_mmcsfw_checkbox'] ) ) );
		}

		update_option( 'mmcsfw_radio_switch_demo', isset( $_POST['mmcsfw_radio_switch_demo'] ) ? sanitize_text_field( wp_unslash( $_POST['mmcsfw_radio_switch_demo'] ) ) : '' ); // phpcs:ignore.

		$index = get_option( 'mwb_mmcsfw_number_of_currency' );

		$flag  = false;
		$count = 0;
		for ( $i = 1; $i <= $index; $i++ ) {

				$currency_name = isset( $_POST[ 'mwb_mmcsfw_text_currency_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_text_currency_' . $i ] ) ) : '';
			if ( ! empty( $currency_name ) ) {
				$count++;
			}
				update_option( 'mwb_mmcsfw_text_currency_' . $i, isset( $currency_name ) ? $currency_name : '' );
				update_option( 'mwb_mmcsfw_text_currency_' . $currency_name, isset( $currency_name ) ? $currency_name : '' );
				update_option( 'mwb_mmcsfw_flag_' . $i, isset( $currency_name ) ? sanitize_text_field( $currency_name ) : '' );
				update_option( 'mwb_mmcsfw_flag_' . $currency_name, isset( $currency_name ) ? sanitize_text_field( $currency_name ) : '' );

				update_option( 'mwb_mmcsfw_text_rate_' . $i, isset( $_POST[ 'mwb_mmcsfw_text_rate_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_text_rate_' . $i ] ) ) : '' );
				update_option( 'mwb_mmcsfw_text_rate_' . $currency_name, isset( $_POST[ 'mwb_mmcsfw_text_rate_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_text_rate_' . $i ] ) ) : '' );
				update_option( 'mwb_mmcsfw_position_' . $i, isset( $_POST[ 'mwb_mmcsfw_position_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_position_' . $i ] ) ) : '' );
				update_option( 'mwb_mmcsfw_position_' . $currency_name, isset( $_POST[ 'mwb_mmcsfw_position_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_position_' . $i ] ) ) : '' );

				update_option( 'mwb_mmcsfw_decimial_' . $i, isset( $_POST[ 'mwb_mmcsfw_decimial_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_decimial_' . $i ] ) ) : '' );
				update_option( 'mwb_mmcsfw_decimial_' . $currency_name, isset( $_POST[ 'mwb_mmcsfw_decimial_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_decimial_' . $i ] ) ) : '' );

				update_option( 'mwb_mmcsfw_interest_' . $i, isset( $_POST[ 'mwb_mmcsfw_interest_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_interest_' . $i ] ) ) : '' );
				update_option( 'mwb_mmcsfw_interest_' . $currency_name, isset( $_POST[ 'mwb_mmcsfw_interest_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_interest_' . $i ] ) ) : '' );

				update_option( 'mwb_mmcsfw_symbol_' . $i, isset( $_POST[ 'mwb_mmcsfw_symbol_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_symbol_' . $i ] ) ) : '' );
				$this->mwb_mmcsfw_update_symbol_acc_currency( $currency_name, isset( $_POST[ 'mwb_mmcsfw_symbol_' . $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_mmcsfw_symbol_' . $i ] ) ) : '' );
		}

		update_option( 'mwb_mmcsfw_number_of_currency', $count < 3 ? 3 : $count );

		do_action( 'mwb_currency_switcher_custom_general_setting_saving' );
	}


	/**
	 *  Update currency symbol
	 *
	 * @param mixed  $currency_name .
	 * @param string $symbol of the currency.
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_update_symbol_acc_currency( $currency_name, $symbol ) {

		$currency_symbols = array(
			'&#36;',
			'&euro;',
			'&yen;',
			'&#1088;&#1091;&#1073;.',
			'&#1075;&#1088;&#1085;.',
			'&#8361;',
			'&#84;&#76;',
			'د.إ',
			'&#2547;',
			'&#82;&#36;',
			'&#1083;&#1074;.',
			'&#107;&#114;',
			'&#82;',
			'&#75;&#269;',
			'&#82;&#77;',
			'kr.',
			'&#70;&#116;',
			'Rp',
			'Rs',
			'&#8377;',
			'Kr.',
			'&#8362;',
			'&#8369;',
			'&#122;&#322;',
			'&#107;&#114;',
			'&#67;&#72;&#70;',
			'&#78;&#84;&#36;',
			'&#3647;',
			'&pound;',
			'lei',
			'&#8363;',
			'&#8358;',
			'Kn',
			'-----',
		);
		$currency_symbols = apply_filters( 'mwb_currency_switcher_currency_symbols', $currency_symbols );
		if ( ! empty( $symbol ) ) {
			foreach ( $currency_symbols as $symbol_value ) {

				if ( md5( $symbol_value ) === $symbol ) {
					update_option( 'mwb_mmcsfw_symbol_' . $currency_name, $symbol_value );
				}
			}
		}

	}


	/**
	 *  Locate  template file.
	 *
	 * @name    mwb_locate_woocommerce_template.
	 * @param mixed $template are the template to return.
	 * @param mixed $template_name is the template name.
	 * @param mixed $template_path path of the template.
	 * @version 1.0.0.
	 */
	public function mwb_mmcsfw_locate_woocommerce_template( $template, $template_name, $template_path ) {

		$wc_path     = WC()->template_path() . $template_name;
		$theme_path  = '/' . $template_name;
		$plugin_path = MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH . 'templates/' . $template_name;

		$located = locate_template(
			array(
				$wc_path,
				$theme_path,
				$plugin_path,
			)
		);

		if ( ! $located && file_exists( $plugin_path ) ) {

			$located = apply_filters( 'mwb_plugin_constant_locate_template', $plugin_path, $template_path );
		} else {

			$located = apply_filters( 'mwb_plugin_constant_locate_template', $located, $template_path );
		}

		return $located ? $located : $template;
	}


	/**
	 * Auto update rates with action scheduler.
	 *
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_rate_auto_update() {

		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_select_aggregator' );
		$switcher_default_currency      = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
		$index                          = get_option( 'mwb_mmcsfw_number_of_currency' );
		global $wp_filesystem;  // global object of WordPress filesystem.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem(); // intialise new file system object.
		for ( $i = 1; $i <= $index; $i++ ) {
			$currency_to_change = get_option( 'mwb_mmcsfw_text_currency_' . $i, false );
			switch ( $mwb_mmcsfw_currency_aggregator ) {
				case 'yahooapi':
					$date = time();

					if ( $currency_to_change === $switcher_default_currency ) {
						update_option( 'mwb_mmcsfw_text_rate_' . $i, '1' );
						update_option( 'mwb_mmcsfw_text_rate_' . $currency_to_change, '1' );
						break;
					}
					$mwb_mmcsfw_query_url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . $switcher_default_currency . $currency_to_change . '=X?symbol=' . $switcher_default_currency . $currency_to_change . '%3DX&period1=' . ( $date - 60 * 86400 ) . '&period2=' . $date . '&interval=1d&includePrePost=false&events=div%7Csplit%7Cearn&lang=en-US&region=US&corsDomain=finance.yahoo.com';

					if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
						$res = $this->mwb_mmcsfw_get_url_contents( $mwb_mmcsfw_query_url );
					}
					$data   = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );
					$result = ! empty( $data['chart']['result'][0]['indicators']['quote'][0]['open'] ) ? $data['chart']['result'][0]['indicators']['quote'][0]['open'] : ( isset( $data['chart']['result'][0]['meta']['previousClose'] ) ? array( $data['chart']['result'][0]['meta']['previousClose'] ) : array() );

					if ( count( $result ) && is_array( $result ) ) {
						$request = end( $result );
					}
					if ( empty( $request ) ) {
						// if currency not found.
						$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					}
					update_option( 'mwb_mmcsfw_text_rate_' . $i, $request );
					update_option( 'mwb_mmcsfw_text_rate_' . $currency_to_change, $request );

					break;

				case 'bankeuropean':
					$url = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

					if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
						$res = $this->mwb_mmcsfw_get_url_contents( $url );
					}

					$currency_data = simplexml_load_string( $res );
					$rates         = array();
					$cube          = 'Cube';
					if ( empty( $currency_data->$cube->$cube ) ) { // phpcs:ignore
						$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
						break;
					}

					foreach ( $currency_data->$cube->$cube->$cube as $xml ) { // phpcs:ignore
						$att                                      = (array) $xml->attributes();
						$rates[ $att['@attributes']['currency'] ] = floatval( $att['@attributes']['rate'] );
					}

					if ( ! empty( $rates ) ) {

						if ( 'EUR' !== $switcher_default_currency ) {
							if ( 'EUR' !== $currency_to_change ) {
								if ( isset( $currency_to_change ) ) {
									$request = floatval( $rates[ $currency_to_change ] / $rates[ $switcher_default_currency ] );
								} else {
									$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
									$request .= sprintf( esc_html( '%s' ), $currency_to_change );
								}
							} else {
								$request = 1 / $rates[ $switcher_default_currency ];
							}
						} else {
							if ( 'EUR' !== $switcher_default_currency ) { // phpcs:ignore.
								$request = $rates[ $currency_to_change ];
							} else {
								$request = 1;
							}
						}
					} else {
						$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					}

					if ( ! $request ) {
						$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					}
					update_option( 'mwb_mmcsfw_text_rate_' . $i, $request );
					update_option( 'mwb_mmcsfw_text_rate_' . $currency_to_change, $request );

					break;

				case 'romanieibank':
					$url = 'https://www.bnr.ro/nbrfxrates.xml';

					if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
						$data_romaniei = $this->mwb_mmcsfw_get_url_contents( $url );
					}
					$mwb_mmcsfw_currency_data = simplexml_load_string( $data_romaniei );
					$rates                    = array();
					$multiplier               = array();
					$cube                     = 'Cube';
					$body                     = 'Body';
					$rate                     = 'Rate';
					if ( empty( $mwb_mmcsfw_currency_data->$body->$cube ) ) { // phpcs:ignore 
						$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
						break;
					}
					foreach ( $mwb_mmcsfw_currency_data->$body->$cube->$rate as $xml ) { // phpcs:ignore
						$att                                      = (array) $xml->attributes();
						$final['rate']                            = (string) $xml;
						$rates[ $att['@attributes']['currency'] ] = floatval( $final['rate'] );

						if ( $att['@attributes']['multiplier'] ) {
							$multiplier[ $att['@attributes']['currency'] ] = $att['@attributes']['multiplier'];
						}
					}
					// ***
					if ( ! empty( $rates ) ) {
						if ( 'RON' !== $mwb_default_currency ) {
							if ( 'RON' !== $mwb_currency_to_change ) {
								if ( isset( $mwb_currency_to_change ) ) {
									$request = 1 / floatval( $rates[ $mwb_currency_to_change ] / $rates[ $mwb_default_currency ] );
									$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
								} else {
									$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
									$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
								}
							} else {
								$request = 1 * ( $rates[ $mwb_default_currency ] );
								$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
							}
						} else {
							if ( 'RON' !== $mwb_currency_to_change ) {
								if ( $rates[ $mwb_currency_to_change ] < 1 ) {
									$request = 1 / $rates[ $mwb_currency_to_change ];
									$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
								} else {
									$request = $rates[ $mwb_currency_to_change ];
									$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
								}
							} else {
								$request = 1;
								$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
							}
						}
					} else {
						$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
					}
					// ***

					if ( ! $request ) {
						$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
					}
					echo esc_attr( $request );
					wp_die();
					break;

				case 'bankofitaly':
					$mwb_mmcsfw_italybank_url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';

						$data_italy = $wp_filesystem->get_contents( $mwb_mmcsfw_italybank_url );

					// ***
					$mwb_mmcsfw_italy_data = json_decode( sanitize_text_field( wp_unslash( $data_italy ) ), true );
					if ( ! empty( $mwb_mmcsfw_italy_data ) ) {
						if ( 'UAH' != $switcher_default_currency ) {

							$def_cur_rate = 0;
							foreach ( $mwb_mmcsfw_italy_data as $item ) {
								if ( $item['cc'] == $switcher_default_currency ) {
									$def_cur_rate = $item['rate'];
									break;
								}
							}
							if ( ! $def_cur_rate ) {
								$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
								$request .= sprintf( esc_html( '%s' ), $currency_to_change );
								break;
							} elseif ( 'UAH' == $currency_to_change ) {
								$request = 1 * $def_cur_rate;
							}
							foreach ( $mwb_mmcsfw_italy_data as $item ) {
								if ( $item['cc'] == $currency_to_change ) {
									if ( 'UAH' != $currency_to_change ) {
										if ( isset( $currency_to_change ) ) {
											$request = 1 / floatval( $item['rate'] / $def_cur_rate );
										} else {
											$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
											$request .= sprintf( esc_html( '%s' ), $currency_to_change );
										}
									} else {
										$request = 1 * $def_cur_rate;
									}
								}
							}
						} else {
							if ( 'UAH' == $currency_to_change ) {
								foreach ( $mwb_mmcsfw_italy_data as $item ) {
									if ( $currency_to_change == $item['cc'] ) {
										$request = 1 / $item['rate'];
										break;
									}
								}
							} else {
								$request = 1;
							}
						}
					}
					if ( ! $request ) {
						$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					}

					update_option( 'mwb_mmcsfw_text_rate_' . $i, $request );
					update_option( 'mwb_mmcsfw_text_rate_' . $currency_to_change, $request );

					break;

				case 'exchangerateapi':
					$exchange_currency = $currency_to_change;
					$query_url         = 'https://api.exchangerate.host/latest?base=' . $switcher_default_currency;

					if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
						$res = $this->mwb_mmcsfw_get_url_contents( $query_url );
					}

					$data    = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );
					$request = isset( $data['rates'][ $exchange_currency ] ) ? $data['rates'][ $exchange_currency ] : 0;

					if ( ! $request ) {
						$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
						$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					}
					update_option( 'mwb_mmcsfw_text_rate_' . $i, $request );
					update_option( 'mwb_mmcsfw_text_rate_' . $currency_to_change, $request );

					break;

				default:
					$request  = esc_html__( 'no data for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $currency_to_change );
					break;
			}
		}

	}

	/**
	 * Remote method to get data.
	 *
	 * @param mixed $url to fetch data.
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_get_url_contents( $url ) {
		$request = wp_remote_get( $url );
		if ( is_wp_error( $request ) ) {
			return false; // Return false if error.
		}
		$body = wp_remote_retrieve_body( $request );
		return $body;
	}

	/**
	 * Scheduler for auto update rates with action scheduler.
	 *
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_scheduler_log() {

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

	/**
	 * Load currency options
	 *
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_load_currency_settings_in_general_tab() {
		wp_nonce_field( 'currency-switcher-nounce', 'mwb-mmcsfw-currency-switcher-nonce' );
		require_once MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-multi-currency-switcher-for-woocommerce-admin-currency-switcher.php';

	}


	/**
	 * Functon to register widget of switcher.
	 *
	 * @return void
	 */
	public function mwb_mmcsfw_register_currency_switcher_widget() {
		register_widget( 'Mwb_Mmcsfw_Currency_Switcher_Widget' );

	}

}

