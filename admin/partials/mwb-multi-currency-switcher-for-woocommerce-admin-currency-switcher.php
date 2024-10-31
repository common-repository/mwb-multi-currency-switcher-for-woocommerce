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

?>

<div class="mwb-loader-overlay">
	<div class="mwb-loader-spinner">
		<span class="mwb-spinner">
		<?php
		$gif_image = esc_attr( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/loader.gif' );
		$gif_image = apply_filters( 'mwb_multi_currency_switcher_loader_gif', $gif_image );
		?>
			<img src=" <?php echo esc_attr( $gif_image ); ?> ">
		</span>
	</div>
</div>
<div class="mwb_currency_switcher_table_wrapper">
	<table id="mwb_currency_switcher_table" name="mwb_currency_switcher_table" class="display" >
	<thead>
		<tr class="mwb_currency_switcher_heading_row">
			<th><?php esc_html_e( 'Default', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Currency Code', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>
			<th><?php esc_html_e( 'Symbol', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Position', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>
			<th> <?php esc_html_e( 'Rate and Interest', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </th>
			<th><?php esc_html_e( 'Decimal', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>
			<th><?php esc_html_e( 'Flag', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>
			<th><?php esc_html_e( 'Edit', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </th>
			<?php do_action( 'mwb_currency_switcher_currency_add_table_heading_option' ); ?>
		</tr>
		</thead>
		<tbody>
		<?php
		$index = get_option( 'mwb_mmcsfw_number_of_currency' );

		$count = 0;
		if ( empty( $index ) ) {
			$index = 3;
			update_option( 'mwb_mmcsfw_text_currency_checkbox', '1' );
			update_option( 'mwb_mmcsfw_number_of_currency', '3' );
			update_option( 'mwb_mmcsfw_text_currency_1', get_woocommerce_currency() );
			update_option( 'mwb_mmcsfw_text_rate_1', '1' );
			update_option( 'mwb_mmcsfw_flag_1', get_woocommerce_currency() );
		}
		for ( $i = 1; $i <= $index; $i++ ) {
			$currency = get_option( 'mwb_mmcsfw_text_currency_' . $i );

				++$count;

			if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
				break;
			}
			?>
			<tr class="mwb_currency_switcher_content_row">
				<td class="mwb_currency_switcher_checkbox_wrap"> 
					<input type="radio" class="currency_radio" value="<?php echo esc_attr( $i ); ?>" id="<?php echo esc_attr( $i ); ?>" name="mwb_mmcsfw_checkbox" 
					<?php

					if ( get_option( 'mwb_mmcsfw_text_currency_checkbox' ) == $i ) {
						echo 'checked="checked"';
					}
					?>
					>
					<label for="<?php echo esc_attr( $i ); ?>"></label>
				</td>
				<td class="mwb_currency_switcher_text_currency_wrap"> 
					<input type="text" class="mwb_mmcsfw_text_currency_input" placeholder="<?php esc_html_e( 'Set Currency', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>" id="mwb_mmcsfw_text_currency_<?php echo esc_attr( $i ); ?>" name="mwb_mmcsfw_text_currency_<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $currency ); ?>"> 
				</td>
				<td class="mwb_currency_switcher_symbol_wrap">
					<select class="mwb-drop-down mwb-symbol" id="mwb_mmcsfw_symbol_<?php echo esc_attr( $i ); ?>" name="mwb_mmcsfw_symbol_<?php echo esc_attr( $i ); ?>" title="<?php esc_html_e( 'Money signs', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>">
						<?php foreach ( $currency_symbols as $symbol ) : ?>
							<?php

							if ( ! empty( get_option( 'mwb_mmcsfw_custom_symbol_' . $currency ) ) ) {
								$custom_symbol = esc_attr( get_option( 'mwb_mmcsfw_custom_symbol_' . $currency ) );
								?>
								<option value="<?php echo esc_attr( md5( $symbol ) ); ?>" > <?php echo esc_attr( $symbol ); ?> </option>
								<?php
							} else {
								?>
								<option value="<?php echo esc_attr( md5( $symbol ) ); ?>" values="<?php echo esc_attr( md5( $symbol ) ); ?>" 
									<?php
									if ( get_option( 'mwb_mmcsfw_symbol_' . $i ) == md5( $symbol ) ) {
										echo 'selected=selected';
									}
									?>
									><?php echo esc_attr( $symbol ); ?></option> <?php } ?>


									<?php
								endforeach;

						if ( ! empty( get_option( 'mwb_mmcsfw_custom_symbol_' . $currency ) ) ) {
							?>
									<option value = "<?php echo esc_attr( $custom_symbol ); ?>" selected="selected" values="<?php echo esc_attr( $custom_symbol ); ?>"> <?php echo esc_html( $custom_symbol ); ?> </option>
									<?php
						}
						?>
							</select>
						</td>
						<td class="mwb_currency_switcher_position_wrap">
							<select class="mwb-mmcsfw-dropdown-position" name="mwb_mmcsfw_position_<?php echo esc_attr( $i ); ?>" title="Select symbol position">
								<option value="left" 
								<?php
								if ( get_option( 'mwb_mmcsfw_position_' . $i ) === 'left' ) {
									echo 'selected="selected"';
								}
								?>
								>   <?php esc_html_e( '$P - left', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </option>
								<option value="right" 
								<?php
								if ( get_option( 'mwb_mmcsfw_position_' . $i ) === 'right' ) {
									echo 'selected="selected"';
								}
								?>
								>  <?php esc_html_e( 'P$ - right', 'mwb-multi-currency-switcher-for-woocommerce' ); ?>  </option>
								<option value="left_space" 
								<?php
								if ( get_option( 'mwb_mmcsfw_position_' . $i ) === 'left_space' ) {
									echo 'selected="selected"';
								}
								?>
								>  <?php esc_html_e( '$ P - left space', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </option>
								<option value="right_space" 
								<?php
								if ( get_option( 'mwb_mmcsfw_position_' . $i ) === 'right_space' ) {
									echo 'selected="selected"';
								}
								?>
								>   <?php esc_html_e( 'P $ - right space', 'mwb-multi-currency-switcher-for-woocommerce' ); ?> </option>
							</select>
						</td>
						<td class="mwb_currency_switcher_ri_wrap" id="td_<?php echo esc_attr( $i ); ?>"> 
							<div class="mwb_currency_switcher_ri_wrapper">
								<input type="text" class="mwb_mmcsfw_text_rate_input" id="mwb_mmcsfw_text_rate_<?php echo esc_attr( $i ); ?>" name="mwb_mmcsfw_text_rate_<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_text_rate_' . $i ) ); ?>"> + 
								<input type="text" class="mwb_mmcsfw_interest_input" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_interest_' . $i ) ); ?>" name="mwb_mmcsfw_interest_<?php echo esc_attr( $i ); ?>" id="mwb_mmcsfw_interest_<?php echo esc_attr( $i ); ?>"> 
								<a onclick="getrate(this,<?php echo esc_attr( $i ); ?>)" class="mwb_mmcsfw_text_rate_loader">
									<span><i class="fas fa-sync-alt"></i></span> 
								</a> 
							</div>
						</td>
						<td class="mwb_currency_switcher_decimal_wrap"> <input type="number" class="mwb_mmcsfw_decimial_input" id="mwb_mmcsfw_decimial_<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_decimial_' . $i ) ); ?>" name="mwb_mmcsfw_decimial_<?php echo esc_attr( $i ); ?>"> 
						</td>
						<td class="mwb_currency_switcher_flag_wrap"> 
							<span id="mwb_mmcsfw_flag_<?php echo esc_attr( $i ); ?>" class="mwb_currency_switcher_flag" value="" onclick="mwb_automic_detect_flag(<?php echo esc_attr( $i ); ?>)" value="" name="mwb_mmcsfw_flag_<?php echo esc_attr( $i ); ?>" >
							<?php
							$flag_src = '';
							if ( ! empty( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) ) {

								$flag_src = esc_attr( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) );
							} elseif ( ! empty( get_option( 'mwb_mmcsfw_flag_' . $i ) ) ) {
								$flag_src = esc_attr( 'https://flagcdn.com/256x192/' . strtolower( substr( ( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ), 0, -1 ) ) . '.png' );
							} else {
								$flag_src = esc_attr( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/flags/blank.png' );
							}
							?>
							<img src="<?php echo esc_attr( $flag_src ); ?>" id="mwb_img_<?php echo esc_attr( $i ); ?>" alt="Country flag" name="mwb_mmcsfw_img_<?php echo esc_attr( $i ); ?>"> 
							</span>
						</td>
						<td class="mwb_currency_switcher_edit_wrap"> 
							<button type="button" onclick="set_modal_data_acc_currency(this,'<?php	echo esc_attr( $currency ); ?>',<?php echo esc_attr( $i ); ?>)" class="mwb_currency_switcher_edit_btn btn btn-info btn-lg"><i class="fas fa-pen"></i>
							</button>  
						</td>
						<?php do_action( 'mwb_currency_switcher_currency_add_table_td_option', $currency, $i ); ?>
					</tr>

							<?php

		}
		?>
				</tbody>
					</table>
				</div>
					<div class="mwb_modal_body_currency_wrap">
						<div class="mwb_modal_body_currency_content">
							<button type="button" class="mwb-modal-close"><span>&times;</span></button>
							<div class="mwb_modal_body_currency" id="mwb_modal_body_currency">
							</div>
						</div>
					</div>

