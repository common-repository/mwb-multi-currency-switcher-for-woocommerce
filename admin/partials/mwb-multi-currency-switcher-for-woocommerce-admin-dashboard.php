<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $mwb_mmcsfw_obj;
do_action( 'mwb_multi_currency_switcher_admin_dashboard_before_active_tab' );
$mwb_mmcsfw_active_tab   = isset( $_GET['mmcsfw_tab'] ) ? sanitize_key( $_GET['mmcsfw_tab'] ) : 'mwb-multi-currency-switcher-for-woocommerce-general';
$mwb_mmcsfw_default_tabs = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_default_tabs();

?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
	<div class="mwb-image-wrapper">
	<img class='mwb-logo-currency' src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/MWB_3600x3600.png" alt="logo image">
		<h1 class="mwb-header-title"><?php echo esc_attr__( 'MWB MULTI CURRENCY SWITCHER FOR WOOCOMMERCE', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h1>
		</div>
		<div class="mwb-header-ds-wrapper">
			<a href="https://docs.makewebbetter.com/mwb-multi-currency-switcher-for-woocommerce/" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></a>
			<span>|</span>
			<a href="https://makewebbetter.com/contact-us/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></a>
		</div>
	</div>
</header>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<button class="btn-nav-mob-dropdown-toggle" type="button">
		<?php esc_html_e( 'Select', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>
	</button>
	<nav class="mwb-navbar mwb-navbar-desktop">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $mwb_mmcsfw_default_tabs ) && ! empty( $mwb_mmcsfw_default_tabs ) ) {

				foreach ( $mwb_mmcsfw_default_tabs as $mwb_mmcsfw_tab_key => $mwb_mmcsfw_default_tabs ) {

					$mwb_mmcsfw_tab_classes = 'mwb-link ';

					if ( ! empty( $mwb_mmcsfw_active_tab ) && $mwb_mmcsfw_active_tab === $mwb_mmcsfw_tab_key ) {
						$mwb_mmcsfw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $mwb_mmcsfw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mwb_multi_currency_switcher_for_woocommerce_menu' ) . '&mmcsfw_tab=' . esc_attr( $mwb_mmcsfw_tab_key ) ); ?>" class="<?php echo esc_attr( $mwb_mmcsfw_tab_classes ); ?>"><?php echo esc_html( $mwb_mmcsfw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>
	<section class="mwb-section">
		<div>
			<?php
			do_action( 'mwb_mmcsfw_before_general_settings_form' );
			if ( empty( $mwb_mmcsfw_active_tab ) ) {
				$mwb_mmcsfw_active_tab = 'mwb_mmcsfw_plug_general';
			}
			$mwb_mmcsfw_tab_content_path = MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/' . $mwb_mmcsfw_active_tab . '.php';
			if ( class_exists( 'Woocommerce_Multi_Currency_Switcher' ) ) {
				$mwb_mmcsfw_tab_content_path = apply_filters( 'mwb_mmcsfw_plugin_standard_admin_settings__active_tabs_name', $mwb_mmcsfw_active_tab, $mwb_mmcsfw_tab_content_path );
			}
			$mwb_mmcsfw_obj->mwb_mmcsfw_plug_load_template( $mwb_mmcsfw_tab_content_path );

			do_action( 'mwb_mmcsfw_after_general_settings_form' );
			?>
		</div>
	</section>
