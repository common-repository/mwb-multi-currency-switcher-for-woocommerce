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

$currency_name  = '';
$currency_name  = esc_html( $currency );
$currency_name .= esc_html__( ' Currency', 'mwb-multi-currency-switcher-for-woocommerce' );


?>


<div class="other_features_acc_to_currency">
	<h4> 
		<?php
		echo esc_html( $currency );
		echo esc_html__( ' Currency', 'mwb-multi-currency-switcher-for-woocommerce' );
		?>
	</h4>
	<table>
		<tr>
			<td>
				<label> 
					<?php
					echo esc_html__( 'Custom Symbol', 'mwb-multi-currency-switcher-for-woocommerce' );
					?>
				</label>
				<input type="text" id="mwb_mmcsfw_custom_symbol_<?php echo esc_attr( $currency ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_custom_symbol_' . $currency ) ); ?>">
			</td>
		</tr>
		<tr>
			<td> 
				<label>
					<?php
					echo esc_html__( 'Custom Flag', 'mwb-multi-currency-switcher-for-woocommerce' );
					?>
				</label>
				<a href="#" class="mwb_mmcsfw_custom_flag_image">

				<?php
				if ( ! empty( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) ) {
					echo '<img class="mwb-template-image" src="' . esc_attr( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) . '">';
				} else {
					echo esc_html__( 'Upload image', 'mwb-multi-currency-switcher-for-woocommerce' );
				}
				?>

			</a>
			<span style="color: red;">	
				<?php
				echo esc_html__( 'only jpg, jpeg and png image format allowed.', 'mwb-multi-currency-switcher-for-woocommerce' );
				?>
			</span>
			<?php
			if ( ! empty( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) ) {
				?>
				<a href="#" class="mwb_mmcsfw_custom_flag_image-rmv" ><?php echo esc_html__( 'Remove image', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></a>
				<?php
			} else {
				?>

			<a href="#" class="mwb_mmcsfw_custom_flag_image-rmv" ><?php echo esc_html__( 'Remove image', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></a>

				<?php
			}
			?>

			<input type="hidden" id="mwb_mmcsfw_custom_flag_image-img" value="">
		</td>
	</tr>
	<tr>

		<td>
			<label>
				<?php
				echo esc_html__( 'Thousand separator', 'mwb-multi-currency-switcher-for-woocommerce' );
				?>
			</label>
			<input type="text" id="mwb_mmcsfw_thousand_separator_<?php echo esc_attr( $currency ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_thousand_separator_' . $currency ) ); ?>"> </td>
	</tr>
	<tr>

		<td>
			<label>
				<?php
				echo esc_html__( 'Decimal separator', 'mwb-multi-currency-switcher-for-woocommerce' );
				?>
			</label>
			<input type="text" id="mwb_mmcsfw_decimal_separator_<?php echo esc_attr( $currency ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_decimal_separator_' . $currency ) ); ?>"> </td>
	</tr>
	<tr>

		<td>
			<label>
				<?php
				echo esc_html__( 'cents', 'mwb-multi-currency-switcher-for-woocommerce' );
				?>
			</label>
			<select id="mwb_mmcsfw_cents_<?php echo esc_attr( $currency ); ?>">
				<option value="show" 
				<?php
				if ( get_option( 'mwb_mmcsfw_cents_' . $currency ) == 'show' ) {
					echo 'selected=selected';
				}
				?>
				><?php echo esc_html__( 'Show', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></option>
				<option value="hide" 
				<?php
				if ( get_option( 'mwb_mmcsfw_cents_' . $currency ) === 'hide' ) {
					echo 'selected=selected';
				}
				?>
				><?php echo esc_html__( 'Hide', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></option>
			</select>
		</td>
	</tr>
	<tr>

		<td>
			<label>
				<?php
				echo esc_html__( 'Description', 'mwb-multi-currency-switcher-for-woocommerce' );
				?>
			</label>
			<input type="text" maxlength="15" placeholder="<?php echo esc_html( $currency_name ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_description_' . $currency ) ); ?>" id="mwb_mmcsfw_description_<?php echo esc_attr( $currency ); ?>"> </td>
	</tr>
</table>
<table>
	<tr>
		<td class="mwb_modal_currency_button_td"><input type="button"class="mdc-button mdc-button--raised mdc-ripple-upgraded" value="save" onclick="mwb_mmcsfw_feature_saving_throgh_ajax('<?php echo esc_attr( $currency ); ?>')"></td>
	</tr>
</table>
</div>
