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
$mwb_mmcsfw_genaral_settings = apply_filters( 'mwb_mmcsfw_advance_tab_settings_array', array() );

?>
<form action="" method="POST" class="mwb-mmcsfw-advance-section-form">
	<div class="mmcsfw-secion-wrap">
		<?php
		wp_nonce_field( 'currency-switcher-advance-nounce', 'mwb-mmcsfw-currency-switcher-advance-nonce' );
			do_action( 'mwb_currency_switcher_add_advance_tab_settings_before' );
			$mwb_mmcsfw_general_html = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_genaral_settings );
			echo esc_html( $mwb_mmcsfw_general_html );
			$mwb_mmcsfw_advane_image_src = '';
			$mwb_mmcsfw_advane_image_src = apply_filters( 'mwb_mmcsfw_advance_tab_image_src', $mwb_mmcsfw_advane_image_src );

		?>
<?php
			$mwb_mmcsfw_genaral_settings = apply_filters( 'mmcsfw_advance_tab_settings_button_array', array() );
			$mwb_mmcsfw_general_html     = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_genaral_settings );
			echo esc_html( $mwb_mmcsfw_general_html );
			do_action( 'mwb_currency_switcher_add_advance_tab_settings_after' );
?>
	</div>
</form>

