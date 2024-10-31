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

?>


<?php
$index = get_option( 'mwb_mmcsfw_number_of_currency' );
if ( empty( $index ) ) {
	esc_html_e( 'Please first set the currency in the currency tab !!', 'mwb-multi-currency-switcher-for-woocommerce' );
	return;
}
	$countries_obj = new WC_Countries();
	$countries     = $countries_obj->__get( 'countries' );
?>

<div class="geolocation_div">
<?php

do_action( 'mwb_currency_switcher_add_geolocation_option_before_table' );
?>
	<table id="mwb_mmcsfw_table">
	<?php
	$count = 0;
	for ( $i = 1; $i <= $index; $i++ ) {
		$currency           = get_option( 'mwb_mmcsfw_text_currency_' . $i, false );
		$countries_selected = get_option( 'mwb_mmcsfw_select_geolocation_' . $currency );
		$flag               = true;
		if ( empty( $currency ) ) {

			?>
						<?php
						if ( 1 === $i ) {
							esc_html_e( 'Please first set the currency in the currency tab !!', 'mwb-multi-currency-switcher-for-woocommerce' );
						}
						$flag = false;
						?>
				<?php
		}
		if ( true === $flag ) {
			++$count;
			if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
				break;
			}
			?>
		<tr class="geolocation-currency-row">
			<td>
				<label class="mwb-form-label">
					<?php echo esc_html( $currency ); ?> 
				</label>
				<select class="form-control mwb_geo_currency_index_<?php echo esc_attr( $i ); ?>" index="<?php echo esc_attr( $i ); ?>" onchange="validategeocountry(this)" id="mwb_mmcsfw_select_geolocation_<?php echo esc_attr( $currency ); ?>" multiple="mwb_mmcsfw_select_geolocation_<?php echo esc_attr( $currency ); ?>">

						<?php foreach ( $countries as $key => $value ) : ?>
				<option 
							<?php
							if ( ! empty( $countries_selected ) ) {
									echo( in_array( $key, $countries_selected ) ? 'selected=""' : '' );
							}
							?>

				value = "<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
				</select> 
			</td>
		</tr>
			<?php
		}
	}
			do_action( 'mwb_currency_switcher_add_geolocation_option_before_save_button' );
	?>
		<tr>
		<td class="geolocation_save_button_wrap">
				<input type="button" value="<?php esc_attr_e( 'Save', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>" class="mdc-button mdc-button--raised mdc-ripple-upgraded" onclick="mwb_mmcsfw_geolocation_saving_throgh_ajax(this)">
			</td>
		</tr>
		<?php
			do_action( 'mwb_currency_switcher_add_geolocation_option_after_save_button' );
		?>
	</table>
	<?php

			do_action( 'mwb_currency_switcher_add_geolocation_option_after_table' );
	?>
</div>
<b class="mmcsfw_hint"><?php esc_html_e( 'Note', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>:</b>
<?php esc_html_e( 'To enable this feature go to Advance Settings and Enable Geolocation rules', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>
