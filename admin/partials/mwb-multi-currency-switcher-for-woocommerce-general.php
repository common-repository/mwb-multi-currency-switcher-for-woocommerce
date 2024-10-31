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
$mwb_mmcsfw_genaral_settings = apply_filters( 'mwb_mmcsfw_general_settings_array', array() );

?>
<!--  template file for admin settings. -->
<div class="mwb_form_add_currency-btn">
	<button type="button" class="mdc-button mdc-button--raised"><i class="fas fa-plus"></i><b> <?php esc_html_e( 'Add Currency', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></b></i>
	</button>
</div>
<form action="" method="POST" class="mwb-mmcsfw-gen-section-form mwb-mmcsfw-gen-section-form-main">
	<div class="mmcsfw-secion-wrap">
		<?php
		if ( ! empty( $mwb_mmcsfw_genaral_settings ) ) {
			$mwb_mmcsfw_general_html = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_genaral_settings );
		}
		do_action( 'mwb_mmcsfw_currency_switcher_add_currency_settings' );
		echo esc_html( $mwb_mmcsfw_general_html );
		?>
		<br>
		<?php
		$mwb_mmcsfw_genaral_settings_button = apply_filters( 'mwb_mmcsfw_general_settings_array_for_save_buttton', array() );
		$mwb_mmcsfw_general_html_button     = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_genaral_settings_button );
		echo esc_html( $mwb_mmcsfw_general_html_button );
		?>
	</div>
	<b class="mmcsfw_hint"><?php esc_html_e( 'Note', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>:</b>
	&nbsp;<?php esc_html_e( 'Currency Code will be 3 letters of the respective country. You can refer to this link for currency code ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>:-<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes"> <?php esc_html_e( 'Get Currency Code', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </a>
	<br>
	<b class="mmcsfw_hint"><?php esc_html_e( 'Note', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>:</b>
	<?php esc_html_e( 'Flags will load automatically when you enter the currency code.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>
	<br>
</form>

