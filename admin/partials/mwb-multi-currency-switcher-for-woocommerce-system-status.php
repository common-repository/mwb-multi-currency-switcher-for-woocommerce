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
// Template for showing information about system status.
global $mwb_mmcsfw_obj;
$mwb_mmcsfw_default_status    = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_system_status();
$mwb_mmcsfw_wordpress_details = is_array( $mwb_mmcsfw_default_status['wp'] ) && ! empty( $mwb_mmcsfw_default_status['wp'] ) ? $mwb_mmcsfw_default_status['wp'] : array();
$mwb_mmcsfw_php_details       = is_array( $mwb_mmcsfw_default_status['php'] ) && ! empty( $mwb_mmcsfw_default_status['php'] ) ? $mwb_mmcsfw_default_status['php'] : array();
?>
<div class="mwb-mmcsfw-table-wrap">
	<div class="mwb-col-wrap">
		<div id="mwb-mmcsfw-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-mmcsfw-table mdc-data-table__table mwb-table" id="mwb-mmcsfw-wp">
					<thead>
						<tr class="mdc-data-table__table-head-row">
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Variables', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Values', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwb_mmcsfw_wordpress_details ) && ! empty( $mwb_mmcsfw_wordpress_details ) ) { ?>
							<?php foreach ( $mwb_mmcsfw_wordpress_details as $wp_key => $wp_value ) { ?>
								<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
									<tr class="mdc-data-table__row mdc-data-table__table-data-row">
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_key ); ?></td>
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_value ); ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="mwb-col-wrap">
		<div id="mwb-mmcsfw-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-mmcsfw-table mdc-data-table__table mwb-table" id="mwb-mmcsfw-sys">
					<thead>
						<tr class="mdc-data-table__table-head-row">
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Variables', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Values', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwb_mmcsfw_php_details ) && ! empty( $mwb_mmcsfw_php_details ) ) { ?>
							<?php foreach ( $mwb_mmcsfw_php_details as $php_key => $php_value ) { ?>
								<tr class="mdc-data-table__row mdc-data-table__table-data-row">
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_key ); ?></td>
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_value ); ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
