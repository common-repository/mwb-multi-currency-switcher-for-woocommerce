<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $mwb_mmcsfw_obj;
?>




<div class="mwb_currency_switcher_table_wrapper">
	<table id="mwb_currency_switcher_table" class="display mwb_currency_switcher-widget-table" name="mwb_currency_switcher_table">
	<thead>
		<tr class="mwb_currency_switcher_heading_row">
			<th><?php esc_html_e( 'Shortcode Name ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Description ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Code for use', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>

			<?php do_action( 'mwb_currency_switcher_currency_add_table_heading_option_shortcode' ); ?>
		</tr>
		</thead>
		<tbody>
		<tr class="mwb_currency_switcher_content_row">
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'Currency Switcher Dropdown', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'This shortcode will add currency dropdown and selected currency flag and will also change the value of the page where it is applied', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"><?php esc_html_e( ' [currency_switcher_dropdown]', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>

			</tr>
			<tr class="mwb_currency_switcher_content_row">
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'Currency Converter', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'This shortcode will allow you to convert currency and see value of the currency at the real time', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"><?php esc_html_e( ' [currency_converter]', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>

			</tr>
			<?php do_action( 'mwb_currency_switcher_currency_add_table_tr_shortcode' ); ?>
			</tbody>
		</table>
	</div>





	<div class="mwb_currency_switcher_table_wrapper">
	<table id="mwb_currency_switcher_table" class="display mwb_currency_switcher-widget-table" name="mwb_currency_switcher_table">
	<thead>
		<tr class="mwb_currency_switcher_heading_row">
			<th><?php esc_html_e( 'Widget Name ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Description ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Demo', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>

			<?php do_action( 'mwb_currency_switcher_currency_add_table_heading_option_widget' ); ?>
		</tr>
		</thead>
		<tbody>
		<tr class="mwb_currency_switcher_content_row">
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'Currency Switcher Dropdown', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"> <?php esc_html_e( 'This widget will add currency dropdown, selected currency flag and will also change the value of the page when it is applied.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </td>
				<td class="mwb_currency_switcher_checkbox_wrap"> <img src=" <?php echo esc_attr( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/widget_currency_switcher.png' ); ?> " alt="Widget image"> </td>

			</tr>
			<?php do_action( 'mwb_currency_switcher_currency_add_table_tr_widget' ); ?>
			</tbody>			
	</table>
	</div>
