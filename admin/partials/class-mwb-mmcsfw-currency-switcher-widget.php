<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/public/partials
 */

/**
 * Class for widget creation.
 */
class Mwb_Mmcsfw_Currency_Switcher_Widget extends WP_Widget {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'mwb_mmcsfw_currency_switcher_widget',
			// Widget name will appear in UI.
			__( 'Currency Switcher Widget', 'mwb-multi-currency-switcher-for-woocommerce' ),
			// Widget description.
			array( 'description' => __( 'Widget for currency conversion', 'mwb-multi-currency-switcher-for-woocommerce' ) )
		);
	}

	/**
	 * Widget function
	 *
	 * @param [type] $args argiuments.
	 * @param [type] $instance are instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( 'on' !== get_option( 'mmcsfw_radio_switch_demo' ) ) {
			return;

		}
		if ( is_wc_endpoint_url( 'order-received' ) ) {
			return;
		}
		if ( is_checkout() ) {
			if ( get_option( 'mmcsfw_radio_switch_advance_hide_widget_checkout' ) == 'on' ) {
				return;
			}
		}
		if ( get_option( 'mmcsfw_radio_switch_advance_hide_widget_shop' ) === 'on' ) {
			if ( is_shop() ) {
				return;
			}
		}
		if ( get_option( 'mmcsfw_radio_switch_advance_hide_widget_cart' ) === 'on' ) {
			if ( is_cart() ) {
				return;
			}
		}
		if ( is_shop() || is_cart() || is_product() || is_checkout() ) {

			// before and after widget arguments are defined by themes.
			esc_attr( $args['before_widget'] );
			if ( ! empty( $title ) ) {
				esc_attr( $args['before_title'] . $title . $args['after_title'] );
			}
			$selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}
			if ( empty( $selected_currency ) ) {
				$welcome_currency = get_option( 'mwb_mmcsfw_select_welcome_currency' );
				if ( ! empty( $welcome_currency ) ) {
					$selected_currency = $welcome_currency;
				} else {
					$selected_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
				}
			}

			// This is where you run the code and display the output.
			?><h4 class="mwb-currency-switcher-widget-title">
			<?php
			echo esc_attr__( 'Currency Switcher !!!', 'mwb-multi-currency-switcher-for-woocommerce' );
			?>
		</h4>
		<select id="currency_switcher" class="currency_switcher_ddl" onchange="getpageprice(this)" name="currency_switcher" value="<?php echo esc_attr( $selected_currency ); ?>">
			<?php
			$count = 0;
			$index = get_option( 'mwb_mmcsfw_number_of_currency' );
			for ( $i = 1; $i <= $index; $i++ ) {

				$currency = esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
				if ( ! empty( $currency ) ) {
					++$count;
				}
				if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
					break;
				}
				if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {

					?>
						<option   value="<?php echo esc_attr( $currency ); ?>" 
					<?php

					if ( $currency == $selected_currency ) {
						echo 'selected=selected';
					} else {
						echo '';}
					?>
							> <?php echo esc_html( $currency ); ?> </option>
					<?php
				}
			}
			?>
</select>
<div id="show_flag">
			<?php
			for ( $i = 1; $i <= $index; $i++ ) {

				$currency = esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
				if ( get_option( 'mwb_mmcsfw_text_currency_' . $i ) == $selected_currency ) { // phpcs:ignore

					if ( ! empty( get_option( 'mwb_mmcsfw_flag_' . $i ) ) ) {
						$src = 'https://flagcdn.com/48x36/' . strtolower( substr( ( get_option( 'mwb_mmcsfw_text_currency_' . $currency ) ), 0, -1 ) ) . '.png';
					}
					if ( ! empty( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) ) {
						$src = get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency );
					}
					if ( ! empty( $src ) ) {
						echo '<img src=" ' . esc_attr( $src ) . ' ">';

					} else {
						$src = 'https://flagcdn.com/48x36/' . strtolower( substr( ( get_option( 'mwb_mmcsfw_text_currency_' . $currency ) ), 0, -1 ) ) . '.png';
					}
				}
			}
			?>
	</div>
			<?php
		}
		?>
		<?php
		esc_attr( $args['after_widget'] );
	}

	/**
	 * Widget Backend .
	 *
	 * @param [type] $instance are instance in widget.
	 * @return void
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'mwb-multi-currency-switcher-for-woocommerce' );
		}
		// Widget admin form.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_attr__( 'Title:', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}
		/**
		 * Updating widget replacing old instances with new.
		 *
		 * @param [type] $new_instance new value.
		 * @param [type] $old_instance old value.
		 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	// Class mwb_currency_switcher_widget ends here.
}
