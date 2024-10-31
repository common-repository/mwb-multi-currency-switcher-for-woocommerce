<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
$mwb_mmcsfw_side_switcher_settings = apply_filters( 'mwb_mmcsfw_side_switcher_settings_array', array() );


?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-mmcsfw-advance-section-form">
	<div class="mmcsfw-secion-wrap">
		<?php
		wp_nonce_field( 'currency-switcher-side-switcher-nounce', 'mwb-mmcsfw-currency-switcher-side-switcher-nonce' );
			do_action( 'mwb_currency_switcher_add_side_switcher_tab_settings_before' );
			$mwb_mmcsfw_side_switcher_settings = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_side_switcher_settings );
			echo esc_html( $mwb_mmcsfw_side_switcher_settings );
		?>
	<div class="mwb-form-group mwb-mmcsfw-text">
		<div class="mwb-form-group__label">
			<?php esc_html_e( 'Switcher Background Color', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>
		</div>
		<div class="mwb-form-group__control">								
		<input type="color" id="mwb_mmcsfw_main_color" name="mwb_mmcsfw_main_color" value="<?php echo ! empty( esc_attr( get_option( 'mwb_mmcsfw_main_color' ) ) ) ? esc_attr( get_option( 'mwb_mmcsfw_main_color' ) ) : esc_attr( '#f5f5f5' ); ?>">	
		</div>
	</div>

	<div class="mwb-form-group mwb-mmcsfw-text">
		<div class="mwb-form-group__label">
			<?php esc_html_e( 'Currency Background Color', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>

		</div>
		<div class="mwb-form-group__control">								
			<input type="color" id="mwb_mmcsfw_hover_color" name="mwb_mmcsfw_hover_color" value="<?php echo ! empty( esc_attr( get_option( 'mwb_mmcsfw_hover_color' ) ) ) ? esc_attr( get_option( 'mwb_mmcsfw_hover_color' ) ) : esc_attr( '#2196f3' ); ?>">

		</div>
	</div>

	<div class="mwb-form-group mwb-mmcsfw-text">
		<div class="mwb-form-group__label">
			<?php esc_html_e( 'Currency Text Color', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>

		</div>
		<div class="mwb-form-group__control">								
			<input type="color" id="mwb_mmcsfw_currency_color" name="mwb_mmcsfw_currency_color" value="<?php echo ! empty( esc_attr( get_option( 'mwb_mmcsfw_currency_color' ) ) ) ? esc_attr( get_option( 'mwb_mmcsfw_currency_color' ) ) : esc_attr( '#fff' ); ?>">

		</div>
	</div>

	<div class="mwb-form-group mwb-mmcsfw-text">
		<div class="mwb-form-group__label">
			<?php esc_html_e( 'Currency Description Text Color', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>

		</div>
		<div class="mwb-form-group__control">								
			<input type="color" id="mwb_mmcsfw_currency_description_color" name="mwb_mmcsfw_currency_description_color" value="<?php echo ! empty( esc_attr( get_option( 'mwb_mmcsfw_currency_description_color' ) ) ) ? esc_attr( get_option( 'mwb_mmcsfw_currency_description_color' ) ) : esc_attr( '#3F4756' ); ?>">

		</div>
	</div>

<?php

			$mwb_mmcsfw_side_switcher_settings = apply_filters( 'mwb_mmcsfw_side_switcher_settings_array_button', array() );

			$mwb_mmcsfw_side_switcher_settings = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_side_switcher_settings );
			echo esc_html( $mwb_mmcsfw_side_switcher_settings );
			do_action( 'mwb_currency_switcher_add_side_switcher_tab_settings_after' );
?>
	</div>
</form>

<?php
if ( empty( get_option( 'mmcsfw_radio_ddl_side_switcher_position' ) ) ) {
	update_option( 'mmcsfw_radio_ddl_side_switcher_position', 'right' );
}
