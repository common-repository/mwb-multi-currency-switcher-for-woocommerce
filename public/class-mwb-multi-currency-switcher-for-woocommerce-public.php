<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace mwb_multi_currency_switcher_for_woocommerce_public.
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Multi_Currency_Switcher_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_public_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'public/css/mwb-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'public-css', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'public/css/mwb-multi-currency-switcher-for-woocommerce-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_public_enqueue_scripts() {
		$default_currency = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$default_currency = WC()->session->get( 's_selected_currency' );
		}
		wp_register_script( $this->plugin_name, MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'public/js/mwb-multi-currency-switcher-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'mmcsfw_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );
		wp_register_script( 'public-js', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'public/js/mwb-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			'public-js',
			'mmcsfw_public_param_js',
			array(
				'ajaxurl'             => admin_url( 'admin-ajax.php' ),
				'nonce'               => wp_create_nonce( 'ajax-nonce' ),
				'switcher_background' => get_option( 'mwb_mmcsfw_main_color' ),
				'currency_background' => get_option( 'mwb_mmcsfw_hover_color' ),
				'currency_text'       => get_option( 'mwb_mmcsfw_currency_color' ),
				'description_color'   => get_option( 'mwb_mmcsfw_currency_description_color' ),
				'switcher_position'   => get_option( 'mmcsfw_radio_ddl_side_switcher_position' ),
				'default_currency'    => $default_currency,
			)
		);
		wp_enqueue_script( 'public-js' );

		if ( function_exists( 'is_product' ) && is_product() ) {
			wp_enqueue_script( 'woocommerce-ajax-add-to-cart', plugin_dir_url( __FILE__ ) . 'assets/ajax-add-to-cart.js', array( 'jquery' ), $this->version, true );
		}
	}

	/**
	 * Return the currency according to country rates
	 *
	 * @param array $cart The all data of cart.
	 */
	public function mwb_mmcsfw_woocommerce_before_calculate_totals_oncart( $cart ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}

		if ( is_cart() || is_checkout() ) {

				global $woocommerce;
				$default_price = '';
				$decimal       = '';
				$new_price = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$default_price = WC()->session->get( 's_selected_currency' );

			}
			global $woocommerce;

			foreach ( $cart->cart_contents as $key => $value ) {

				$new_price = $this->mwb_mmcsfw_get_price_of_product( $value['data']->get_price(), $value['data']->get_id() );

				$value['data']->set_price( floatval( $new_price ) );
			}
		}
	}

	/**
	 * Return the currency according to country rates for the mini cart
	 *
	 * @param mixed $price to get the price of products.
	 * @param array $cart_item     All data of cart.
	 * @param array $cart_item_key Data for cart_item_key .
	 */
	public function mwb_mmcsfw_change_minicart_item_price( $price, $cart_item, $cart_item_key ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $price;
		}

		if ( ! is_cart() ) {

			$mwb_minicart_selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$mwb_minicart_selected_currency = WC()->session->get( 's_selected_currency' );
			}
			if ( ! empty( $mwb_minicart_selected_currency ) ) {
				$decimal = get_option( 'mwb_mmcsfw_decimial_' . $mwb_minicart_selected_currency );
				$cents   = get_option( 'mwb_mmcsfw_cents_' . $mwb_minicart_selected_currency );

				if ( empty( $decimal ) ) {
					$decimal = 0;
				}
				if ( 'hide' === $cents ) {
					$decimal = 0;
				}
			}
			if ( ! empty( $mwb_minicart_selected_currency ) ) {
				$mcs_price = get_option( 'mwb_mmcsfw_text_rate_' . $mwb_minicart_selected_currency );
				$new_price = floatval( $cart_item['data']->get_price() * round( $mcs_price, $decimal ) );
				$new_price = apply_filters( 'mwb_currency_switcher_minicart_product_fixed_price', $new_price, $cart_item['data']->get_id() );

				return $new_price;
			} else {
				return $price;
			}
		} else {
			return $price;
		}
	}

	/**
	 * Hide payment methods according to currency
	 *
	 * @param array $gateways All gateways present in plugin.
	 */
	public function mwb_mmcsfw_hide_gateways( $gateways ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $gateways;
		}

		$default_price = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$default_price = WC()->session->get( 's_selected_currency' );
		}
		if ( 'INR' === $default_price ) {
			// Disable gateway paypal if currency is.
			unset( $gateways['paypal'] );
		}
		return $gateways;
	}

	/**
	 * Filter currency symbol according to country
	 *
	 * @param array $currency_symbol symbol of currenct currency.
	 * @param array $currency        currrennt currency.
	 */
	public function mwb_mmcsfw_add_custom_symbol( $currency_symbol, $currency ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $currency_symbol;
		}

		$custom_page = false;
		$custom_page = apply_filters( 'mwb_currency_switcher_is_custom_page', $custom_page );

		if ( is_shop() || is_cart() || is_checkout() || is_product() || is_wc_endpoint_url( 'order-received' ) || is_ajax() || $custom_page ) {
			$selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}

			if ( ! empty( $selected_currency ) ) {
				if ( ! empty( get_option( 'mwb_mmcsfw_custom_symbol_' . $selected_currency ) ) ) {
					$currency_symbol = get_option( 'mwb_mmcsfw_custom_symbol_' . $selected_currency );
				} elseif ( ! empty( get_option( 'mwb_mmcsfw_symbol_' . $selected_currency )[0] ) ) {
					$currency_symbol = get_option( 'mwb_mmcsfw_symbol_' . $selected_currency );
				}
			}
			return $currency_symbol;
		}
		return $currency_symbol;
	}

	/**
	 *  Check user country according to ip address and set default country currency
	 */
	public function mwb_mmcsfw_check_user_country_acc_ipaddress() {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$mwb_mmcsfw_geoip_rules = get_option( 'mmcsfw_radio_switch_geoip_rules' );
		$mwb_country_ip         = false;
		if ( ! empty( $_GET['currency_name'] ) ) {
			WC()->session->set( 's_selected_currency', sanitize_text_field( wp_unslash( $_GET['currency_name'] ) ) );
			return;
		}
		if ( is_shop() ) {
			if ( isset( $_COOKIE['mwb_mmcsfw_cookie_datas'] ) ) {
				$list = explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['mwb_mmcsfw_cookie_datas'] ) ) );
				if ( '1' === $list['0'] ) {
					if ( 'on' === $mwb_mmcsfw_geoip_rules ) {
						if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
							$mwb_mmcfw_country_code = $this->mwb_mmcsfw_get_ip_info( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ), 'CountryCode' );
						}

						$user_country_code = $mwb_mmcfw_country_code;
						$index             = get_option( 'mwb_mmcsfw_number_of_currency' );
						for ( $i = 1; $i <= $index; $i++ ) {
							$currency    = get_option( 'mwb_mmcsfw_text_currency_' . $i, false );
							$geocurrency = get_option( 'mwb_mmcsfw_select_geolocation_' . $currency );
							if ( ! empty( $geocurrency ) ) {
								$geocurrency_length = Count( $geocurrency );
								$geo_currency       = '';
								for ( $j = 0; $j < $geocurrency_length; $j++ ) {
									if ( $geocurrency[ $j ] === $user_country_code ) {
										$mwb_country_ip                  = true;
										WC()->session->set( 's_selected_currency', $currency );
										$geo_currency                    = $currency;
										if ( $geo_currency !== $list['1'] ) {
											WC()->session->set( 's_selected_currency', $geo_currency );
											$list['1'] = $geo_currency;
											return;
										} else {
												WC()->session->set( 's_selected_currency', $list['1'] );
										}
										return;
									}
								}
							}
						}
					} else {
						$welcome_currency = get_option( 'mwb_mmcsfw_select_welcome_currency' );
						if ( ! empty( $welcome_currency ) ) {
							if ( $welcome_currency != $list['2'] && ! empty( $welcome_currency ) ) {
								WC()->session->set( 's_selected_currency', $welcome_currency );
								$list['2']                       = $welcome_currency;
							} else {
								WC()->session->set( 's_selected_currency', $list['2'] );
							}
						} else {
							WC()->session->set( 's_selected_currency', get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ) );
						}
					}
				}
				return;
			}
			if ( 'on' === $mwb_mmcsfw_geoip_rules ) {
				$mwb_mmcfw_country_code = $this->mwb_mmcsfw_get_ip_info( sanitize_text_field( wp_unslash( isset( $_SERVER['REMOTE_ADDR'] ) ) ), 'CountryCode' ); // fetch the user country code.
				update_option( 'mwb_mmcsfw_country_code_acc_user_ip_address', $mwb_mmcfw_country_code );
				$user_country_code = get_option( 'mwb_mmcsfw_country_code_acc_user_ip_address' );
				$index             = get_option( 'mwb_mmcsfw_number_of_currency' );
				for ( $i = 1; $i <= $index; $i++ ) {
					$currency    = get_option( 'mwb_mmcsfw_text_currency_' . $i, false );
					$geocurrency = get_option( 'mwb_mmcsfw_select_geolocation_' . $currency );
					if ( ! empty( $geocurrency ) ) {
						$geocurrency_length = Count( $geocurrency );
						$geo_currency       = '';
						for ( $j = 0; $j < $geocurrency_length; $j++ ) {
							if ( $geocurrency[ $j ] === $user_country_code ) {
								$mwb_country_ip                  = true;
								WC()->session->set( 's_selected_currency', $currency );
								$geo_currency                    = $currency;
							}
						}
						$data = array(
							'isfirsttimevisit' => '1,',
							'geo_currency'     => $geo_currency . ',',
							'welcome_currency' => ',',
						);
						$var  = implode( $data );
						setcookie( 'mwb_mmcsfw_cookie_datas', $var, time() + 30 * 24 * 60 * 60 ); // Setting a cookie.
					}
				}
			} elseif ( false === $mwb_country_ip ) {
				if ( get_option( 'mwb_mmcsfw_select_welcome_currency' ) !== '0' ) {
					$currency = get_option( 'mwb_mmcsfw_select_welcome_currency' );
					WC()->session->set( 's_selected_currency', $currency );
					$data = array(
						'isfirsttimevisit' => '1,',
						'geo_currency'     => ',',
						'welcome_currency' => $currency . ',',
					);
					$var  = implode( $data );
					setcookie( 'mwb_mmcsfw_cookie_datas', $var, time() + 30 * 24 * 60 * 60 ); // Setting a cookie.
				} else {
					WC()->session->set( 's_selected_currency', get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ) );
				}
			}
		}
	}

	/**
	 *  Function used to fetch country according to ip.
	 *
	 * @param  string $ip of the user.
	 * @param  string $purpose or the different features.
	 * @version 1.0.0
	 */
	public function mwb_mmcsfw_get_ip_info( $ip = null, $purpose = 'location' ) {
		$mwb_mmcsfw_output = null;
		$mwb_mmcsfw_ip = '';
		global $wp_filesystem;  // global object of WordPress filesystem.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem(); // intialise new file system object.
		if ( filter_var( $ip, FILTER_VALIDATE_IP ) === false ) {
			if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
					$mwb_mmcsfw_ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
			}
		}
		$purpose = str_replace( array( 'name', '\n', '\t', ' ', '-', '_' ), null, strtolower( trim( $purpose ) ) );
		$support = array( 'country', 'countrycode', 'state', 'region', 'city', 'location', 'address' );
		if ( filter_var( $ip, FILTER_VALIDATE_IP ) && in_array( $purpose, $support ) ) {
			$_mwb_mmcsfw_ipdata    = @json_decode( sanitize_text_field( wp_unslash( $wp_filesystem->get_contents( 'http://www.geoplugin.net/json.gp?ip=' . $mwb_mmcsfw_ip ) ) ) ); // retrieve the file data.
			$geoplugin_countrycode = 'geoplugin_countryCode';
			$mwb_mmcsfw_output     = @$_mwb_mmcsfw_ipdata->$geoplugin_countrycode;
		}
		return $mwb_mmcsfw_output;
	}

	/**
	 * Change the currency position.
	 *
	 * @return position.
	 */
	public function mwb_mmcsfw_change_currency_position_cart() {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$mwb_position_selected_currency = '';
		if ( ! empty( WC()->session ) && WC()->session->__isset( 's_selected_currency' ) ) {
			$mwb_position_selected_currency = WC()->session->get( 's_selected_currency' );
		}
		$position = get_option( 'mwb_mmcsfw_position_' . $mwb_position_selected_currency );
		return $position;
	}

	/**
	 * Change the thousand separator.
	 *
	 * @param [type] $get_option to get separator.
	 * @return thousand separator;
	 */
	public function mwb_mmcsfw_custom_wc_get_price_thousand_separator( $get_option ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$mwb_thousand_selected_currency = '';
		if ( ! empty( WC()->session ) && WC()->session->__isset( 's_selected_currency' ) ) {
			$mwb_thousand_selected_currency = WC()->session->get( 's_selected_currency' );
		}
		$thousand_separator = get_option( 'mwb_mmcsfw_thousand_separator_' . $mwb_thousand_selected_currency );

		if ( empty( $thousand_separator ) ) {
			$thousand_separator = ',';
		}
		return $thousand_separator;
	}

	/**
	 * Change variable poduct price.
	 *
	 * @param [type] $price the price of the product.
	 * @param [type] $from lowest price.
	 * @param [type] $to highest price.
	 * @return string
	 */
	public function mwb_mmcsfw_change_price_range_for_variation( $price, $from, $to ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $price;
		}
		global $post; // is used to get post object for the current post.

		$_product = wc_get_product( $post->ID ); // Get current product data.

		if ( ! empty( $_product ) ) {

			$selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}
			$switcher_default_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
			$from_price_switcher       = '';
			$to_price_switcher         = '';
			if ( empty( $selected_currency ) || empty( $switcher_default_currency ) ) {
				return $price;
			}

			if ( ! empty( $selected_currency ) ) {
				$mwb_mmcsfw_price    = get_option( 'mwb_mmcsfw_text_rate_' . $selected_currency );
				$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $selected_currency );
				$round_price         = round( $mwb_mmcsfw_price, 2 );
			}

			$from_price = floatval( $from ) * floatval( $round_price );
			$to_price   = floatval( $to ) * floatval( $round_price );

			$from_price_switcher = $from_price;
			$to_price_switcher   = $to_price;

			if ( ! empty( $mwb_mmcsfw_interest ) ) {
				$from_price_switcher = $from_price_switcher + floatval( $mwb_mmcsfw_interest );
				if ( ! empty( $to_price_switcher ) ) {
					$to_price_switcher = $to_price_switcher + floatval( $mwb_mmcsfw_interest );
				}
			}
			$from_price_switcher = apply_filters( 'mwb_currency_switcher_variable_product_range_from', $from_price_switcher, $round_price, $mwb_mmcsfw_interest );
			$to_price_switcher   = apply_filters( 'mwb_currency_switcher_variable_product_range_to', $to_price_switcher, $round_price, $mwb_mmcsfw_interest );

			$mwb_multi_currency_switcher_for_woocommerce_common = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Common( 'MWB Multi Currency Switcher for WooCommerce', '1.0.0' );
			$result = $mwb_multi_currency_switcher_for_woocommerce_common->add_position_to_the_currency( $_product, $from_price_switcher, $to_price_switcher, '' );

			echo wp_kses_post( $result );
		}
	}

	/**
	 * Function to add side switcher.
	 *
	 * @return void
	 */
	public function mwb_mmcsfw_add_side_switcher() {

		$index              = get_option( 'mwb_mmcsfw_number_of_currency' );
		$flag               = false;
		$side_switcher_html = '';
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		if ( is_wc_endpoint_url( 'order-received' ) ) {
			return;
		}
		if ( get_option( 'mmcsfw_radio_switch_advance_hide_switcher_checkout' ) === 'on' ) {
			if ( is_checkout() ) {
				$flag = true;
			}
		}
		if ( get_option( 'mmcsfw_radio_switch_advance_hide_switcher_shop' ) === 'on' ) {
			if ( is_shop() ) {
				$flag = true;
			}
		}
		if ( get_option( 'mmcsfw_radio_switch_advance_hide_switcher_cart' ) === 'on' ) {
			if ( is_cart() ) {
				$flag = true;
			}
		}

		$is_product = false;
		$is_product = apply_filters( 'mwb_currency_switcher_show_side_switcher_on_product', $is_product );
		if ( true == $is_product ) {
			$flag = $is_product;
		}
		if ( false === $flag ) {
				$switcher_position = get_option( 'mmcsfw_radio_ddl_side_switcher_position' );
			if ( empty( $switcher_position ) ) {
				$switcher_position = 'mwb-switcher-right';
			}
				$side_switcher_switch = get_option( 'mmcsfw_radio_switch_side_switcher_style' );
			if ( 'on' === $side_switcher_switch ) {
				$side_switcher_html  = apply_filters( 'mwb_currency_switcher_side_switcher_before_html', $side_switcher_html );
				$side_switcher_html .= '<div class="mwb-cs__side-switcher mwb-switcher-' . $switcher_position . '">';
				$count               = 0;
				for ( $i = 1; $i <= $index; $i++ ) {
					$currency = esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
					$selected_currency = ! empty( $_GET['currency_name'] ) ? sanitize_text_field( wp_unslash( $_GET['currency_name'] ) ) : '';
					if ( empty( $selected_currency ) ) {
						if ( WC()->session->__isset( 's_selected_currency' ) ) {
							$selected_currency = WC()->session->get( 's_selected_currency' );
						}
					}

					if ( $selected_currency == $currency ) {
						$selected_currency = 'selected-currency';
					} else {
						$selected_currency = '';
					}
					$side_switcher_description = get_option( 'mwb_mmcsfw_description_' . $currency );
					if ( empty( $side_switcher_description ) ) {
						$side_switcher_description = esc_html( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) . ' ' . esc_html__( 'Currency', 'mwb-multi-currency-switcher-for-woocommerce' );
					}
					if ( ! empty( $currency ) ) {
						++$count;
					}
					if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
						break;
					}
					if ( ! empty( $currency ) ) {
						$shapes_selected     = get_option( 'mmcsfw_radio_ddl_side_switcher_style' );
						$side_switcher_shape = apply_filters( 'mwb_multi_currency_switcher_side_switcher_shapes', $shapes_selected );
						if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) ) {
							$side_switcher_shape = 'mwb-circle';
						}
						$side_switcher_html .= '<div class="' . $selected_currency . ' mwb-cs__sidepopup-wrap ' . $side_switcher_shape . ' " data-currency="' . $currency . '" >';
						$side_switcher_html .= '<div class="mwb-cs__currency-tag">' . $currency . '</div><p>' . $side_switcher_description . '</p></div>';
					}
				}
				$side_switcher_html .= '</div>';
				$side_switcher_html  = apply_filters( 'mwb_currency_switcher_side_switcher_after_html', $side_switcher_html );

				echo wp_kses_post( $side_switcher_html );
			}
		}
	}

	/**
	 * Functon to register widget of switcher.
	 *
	 * @return void
	 */
	public function mwb_mmcsfw_register_currency_switcher_widget() {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		register_widget( 'Mwb_Mmcsfw_Currency_Switcher_Widget' );
	}

	/**
	 * Functon to add shortcode.
	 *
	 * @return void
	 */
	public function mwb_mmcsfw_add_shortcode() {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$default_woocommerce_currency = get_option( 'mwb_mmcsfw_backup_woocommerce_currency' );
		if ( ! empty( $default_woocommerce_currency ) ) {
			update_option( 'woocommerce_currency', $default_woocommerce_currency );
		}
		add_shortcode( 'currency_switcher_dropdown', array( $this, 'mwb_mmcsfw_currency_converter' ) );
		add_shortcode( 'currency_converter', array( $this, 'mwb_mmcsfw_currency_currency_converter_shortcode' ) );
	}

	/**
	 * It is used to convert currency on the page function.
	 */
	public function mwb_mmcsfw_currency_converter() {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$selected_currency = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$selected_currency = WC()->session->get( 's_selected_currency' );
		}

		?>
	<br>
	<select id="currency_switcher" class="currency_switcher_ddl" onchange="getpageprice()" name="currency_switcher" value="<?php echo esc_attr( $selected_currency ); ?>">

		<?php
		$index = get_option( 'mwb_mmcsfw_number_of_currency' );
		$flag  = false;
		$count = 0;
		for ( $i = 1; $i <= $index; $i++ ) {
			echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
			if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
				++$count;
			}
			if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
				break;
			}
			if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
				?>
		<option value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?>"
								<?php
								if ( get_option( 'mwb_mmcsfw_text_currency_' . $i ) === $selected_currency ) {
									echo 'selected=selected';
								} else {
									echo '';}
								?>
		> <?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?> </option>
				<?php
			}
		}
		?>

	</select>

		<div id="show_flag">
		<?php

		for ( $i = 1; $i <= $index; $i++ ) {
			$selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}
			$currency = esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) );
			if ( get_option( 'mwb_mmcsfw_text_currency_' . $i ) === $selected_currency ) {

				if ( ! empty( get_option( 'mwb_mmcsfw_flag_' . $i ) ) ) {

					$src = 'https://flagcdn.com/48x36/' . strtolower( substr( ( get_option( 'mwb_mmcsfw_text_currency_' . $currency ) ), 0, -1 ) ) . '.png';
				}
				if ( ! empty( get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency ) ) ) {

					$src = get_option( 'mwb_mmcsfw_custom_flag_image_' . $currency );
				}
			}
		}
		if ( ! empty( $src ) ) {

			echo '<img src="' . esc_attr( $src ) . '">';
		}

		?>
		</div><br>
		<?php

	}

	/**
	 * Filter coupon according to currency
	 *
	 * @param array $discount           All discount present in coupon.
	 * @param array $discounting_amount amount of discount.
	 * @param array $cart_item          items in cart.
	 * @param array $single             single value.
	 * @param array $instance           have all data of discount.
	 */
	public function mwb_mmcsfw_filter_woocommerce_coupon_get_discount_amount( $discount, $discounting_amount, $cart_item, $single, $instance ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $discount;
		}
		$count = 0;

		$supported_coupon_type = apply_filters( 'mwb_currency_switcher_set_supported_coupon_type', array( 'fixed_product' ) );
		if ( in_array( $instance->get_discount_type(), $supported_coupon_type ) ) {

			$default_price = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$default_price = WC()->session->get( 's_selected_currency' );
			}
			if ( ! empty( $default_price ) ) {
				$mcs_price = get_option( 'mwb_mmcsfw_text_rate_' . $default_price );

				$decimal = get_option( 'mwb_mmcsfw_decimial_' . $default_price );
				$cents   = get_option( 'mwb_mmcsfw_cents_' . $default_price );
				if ( empty( $decimal ) ) {
					$decimal = 0;
				}
				if ( 'hide' === $cents ) {
					$decimal = 0;
				}
				if ( 0 === $decimal ) {
					$discount  = floatval( $instance->get_amount() * round( $mcs_price, 2 ) );
				} else {
					$discount  = floatval( $instance->get_amount() * round( $mcs_price, $decimal ) );
				}
				$discount = floatval( apply_filters( 'mwb_currency_switcher_set_coupon_discount', $discount, $instance->get_id() ) );
				return $discount;
			}
		} else {
			$discount = apply_filters( 'mwb_currency_switcher_set_coupon_discount_percentage', $discount, $instance );

		}
		return $discount;
	}

	/**
	 * Set Shippin price according to currencies.
	 *
	 * @param [type] $rates are the shipping rates.
	 * @param [type] $package are the shipping packages.
	 * @return [type]
	 */
	public function mwb_mmcsfw_custom_shipping_costs( $rates, $package ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $rates;
		}
		$default_price = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$default_price = WC()->session->get( 's_selected_currency' );
		}
		if ( ! empty( $default_price ) ) {
			$mcs_price = get_option( 'mwb_mmcsfw_text_rate_' . $default_price );
			$decimal   = get_option( 'mwb_mmcsfw_decimial_' . $default_price );
			$cents     = get_option( 'mwb_mmcsfw_cents_' . $default_price );

			if ( empty( $decimal ) ) {
				$decimal = 0;
			}
			if ( 'hide' === $cents ) {
				$decimal = 0;
			}

			foreach ( $rates as $rate_key => $rate ) {
				// Excluding free shipping methods.

				if ( 'free_shipping' !== $rate->method_id ) {

					if ( 0 === $decimal ) {
						$rates[ $rate_key ]->cost = floatval( $rates[ $rate_key ]->cost * round( $mcs_price, 2 ) );
					} else {
						$rates[ $rate_key ]->cost = floatval( $rates[ $rate_key ]->cost * round( $mcs_price, $decimal ) );
					}
					$rates[ $rate_key ]->cost = apply_filters( 'mwb_currency_switcher_set_shipping_cost', $rates[ $rate_key ]->cost );
				}
			}
		}
		return $rates;
	}


	/**
	 * Functon to add shortcode of currency converter.
	 *
	 * @return void
	 */
	public function mwb_mmcsfw_currency_currency_converter_shortcode() {
		?>
		<div class="currency_switcher_main_wrap currency_switcher_widget_wrap">
			<div class="currency_switcher_select_wrap currency_switcher_select1_wrap">
				<select id="currency_switcher_1"  name="currency_switcher_1" >

					<option value=""><?php echo esc_html__( '--Select Any--', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></option>
					<?php

					$index = get_option( 'mwb_mmcsfw_number_of_currency' );
					$flag  = false;
					$count = 0;
					for ( $i = 1; $i <= $index; $i++ ) {

						if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
							++$count;
						}
						if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
							break;
						}
						if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
							?>
						<option value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?>" > <?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?> </option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div class="currency_switcher_select_wrap currency_switcher_select2_wrap">
				<select id="currency_switcher_2"  name="currency_switcher_2" >
				<option value=""><?php echo esc_html__( '--Select Any--', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></option>
					<?php
					$index = get_option( 'mwb_mmcsfw_number_of_currency' );
					$flag  = false;
					$count = 0;
					for ( $i = 1; $i <= $index; $i++ ) {

						if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
							++$count;
						}
						if ( ! class_exists( 'Woocommerce_Multi_Currency_Switcher' ) && 4 == $count ) {
							break;
						}
						if ( ! empty( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ) ) {
							?>
						<option value="<?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?>"> <?php echo esc_attr( get_option( 'mwb_mmcsfw_text_currency_' . $i ) ); ?> </option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div class="currency_switcher_converted_price">
				<input type="text" id="show_converted_price"/>
			</div>
			<div class="currency_switcher_converted_btn_wrap">
				<input type="button" class="currency_switcher_converted_btn" onclick="gettableprice()"  value="<?php echo esc_attr__( 'Convert Currency', 'woocommerce-multi-currency-switcher' ); ?>">
			</div>
		</div>
		<?php
	}

	/**
	 * Set Order currency.
	 *
	 * @param mixed $thank_you_title title for thank you.
	 * @param mixed $order current order.
	 */
	public function mwb_mmcsfw_calculate_order_table_value( $thank_you_title, $order ) {
		$selected_currency = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$selected_currency = WC()->session->get( 's_selected_currency' );
		}
		if ( ! empty( $order ) ) {
			update_post_meta( $order->get_id(), '_order_currency', $selected_currency );
		}
	}

	/**
	 * Set default currency after payment.
	 *
	 * @param mixed $currency to get currenct currency.
	 */
	public function mwb_mmcsfw_change_woocommerce_currency_at_checkout( $currency ) {

		if ( is_checkout() ) {
			$selected_currency = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				update_option( 'mwb_mmcsfw_backup_woocommerce_currency', $currency );
				$currency = WC()->session->get( 's_selected_currency' );
			}
		} else {
			$currency = get_option( 'mwb_mmcsfw_backup_woocommerce_currency' );
		}
		return $currency;
	}


	/**
	 * Set fixed coupon amount.
	 *
	 * @param mixed $coupon to set fixed coupon amount.
	 */
	public function mwb_mmcsfw_woocommerce_coupon_loaded( $coupon ) {

		$supported_coupon_type = apply_filters( 'mwb_currency_switcher_supported_coupon_type', array( 'fixed_cart' ) );
		if ( in_array( $coupon->get_discount_type(), $supported_coupon_type ) ) {

			$default_price = '';
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$default_price = WC()->session->get( 's_selected_currency' );
			}
			if ( ! empty( $default_price ) ) {
				$mcs_price = get_option( 'mwb_mmcsfw_text_rate_' . $default_price );

				$decimal = get_option( 'mwb_mmcsfw_decimial_' . $default_price );
				$cents   = get_option( 'mwb_mmcsfw_cents_' . $default_price );
				if ( empty( $decimal ) ) {
					$decimal = 0;
				}
				if ( 'hide' === $cents ) {
					$decimal = 0;
				}
				if ( $coupon->get_minimum_amount() ) {
					$amount = mwb_mmcsfw_admin_fetch_currency_rates_from_base_currency( '', $coupon->get_minimum_amount() );
					$coupon->set_minimum_amount( $amount );

				}
				if ( $coupon->get_maximum_amount() ) {
					$amount = mwb_mmcsfw_admin_fetch_currency_rates_from_base_currency( '', $coupon->get_maximum_amount() );
					$coupon->set_maximum_amount( $amount );
				}

				if ( 0 === $decimal ) {
					$discount = floatval( $coupon->get_amount() * round( $mcs_price, 2 ) );
				} else {
					$discount = floatval( $coupon->get_amount() * round( $mcs_price, $decimal ) );
				}
			}
			$discount = apply_filters( 'mwb_currency_switcher_set_coupon_discount', $discount, $coupon->get_id() );

			$coupon->set_amount( $discount );
		}

		return $coupon;
	}

	/**
	 * This function sbp_change_product_price_display is used to display price.
	 *
	 * @param string $price The price of this plugin.
	 * @param object $product is the current product object.
	 */
	public function mwb_mmcsfw_change_product_price_display( $price, $product ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $price;
		}
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( ! empty( $screen ) ) {
				if ( 'edit-product' === $screen->id ) {
					return $price;
				}
			}
		}
		$fixed_from_price = '';
		$fixed_to_price = '';
		global $post; // is used to get post object for the current post.
		$_product                  = $product; // Get current product data.
		$selected_currency = '';

		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$selected_currency = WC()->session->get( 's_selected_currency' );
		}
		$switcher_default_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
		$from_price_switcher       = '';
		$to_price_switcher         = '';
		if ( empty( $selected_currency ) || empty( $switcher_default_currency ) ) {
			return $price;
		}

		if ( ! empty( $selected_currency ) ) {
			$mwb_mmcsfw_price    = get_option( 'mwb_mmcsfw_text_rate_' . $selected_currency );
			$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $selected_currency );
			$round_price         = round( $mwb_mmcsfw_price, 2 );
		}
		$is_custom_product_type = false;
		$custom_product_type = '';
		$custom_product_type = apply_filters( 'mwb_currency_switcher_get_custom_product_type', $custom_product_type, $_product->get_id() );
		if ( ! empty( $custom_product_type ) ) {
			$is_custom_product_type = true;
		}

		if ( ! empty( $_product ) ) {
			if ( $_product->is_type( 'simple' ) || $_product->is_type( 'external' ) || $is_custom_product_type ) {

				$mwb_regular = floatval( $_product->get_regular_price() ) * floatval( $round_price );
				$mwb_sales   = floatval( $_product->get_sale_price() ) * floatval( $round_price );

				$from_price_switcher = $mwb_regular;
				$to_price_switcher   = $mwb_sales;

				if ( ! empty( $mwb_mmcsfw_interest ) ) {
					$from_price_switcher = $from_price_switcher + floatval( $mwb_mmcsfw_interest );
					if ( ! empty( $to_price_switcher ) ) {
						$to_price_switcher = $to_price_switcher + floatval( $mwb_mmcsfw_interest );
					}
				}
				$fixed_from_price = apply_filters( 'mwb_currency_switcher_simple_external_product_price_from', $from_price_switcher );
				$fixed_to_price   = apply_filters( 'mwb_currency_switcher_simple_external_product_price_to', $to_price_switcher );

				if ( ! empty( $fixed_from_price ) ) {
					$from_price_switcher = $fixed_from_price;
					if ( ! empty( $fixed_to_price ) ) {
						$to_price_switcher = $fixed_to_price;
					} else {
						$to_price_switcher = '';
					}
				}
				$result = $this->add_position_to_the_currency( $_product, $from_price_switcher, $to_price_switcher, $custom_product_type );
				return $result;
			}
		}
		return $price;
	}

	/**
	 * This function add_position_to_the_currency is used to set currency position.
	 *
	 * @param mixed $_product type of product.
	 * @param mixed $from_price price that indicates from for simple and min for variable.
	 * @param mixed $to_price price that indicates to for simple and max for variable.
	 * @param mixed $custom type of currency.
	 */
	public function add_position_to_the_currency( $_product, $from_price, $to_price, $custom ) {

		$symbol = get_woocommerce_currency_symbol();
		$currency = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$currency = WC()->session->get( 's_selected_currency' );
		}
		$decimal            = get_option( 'mwb_mmcsfw_decimial_' . $currency );
		$thousand_separator = get_option( 'mwb_mmcsfw_thousand_separator_' . $currency );
		$decimal_separator  = get_option( 'mwb_mmcsfw_decimal_separator_' . $currency );
		$cents              = get_option( 'mwb_mmcsfw_cents_' . $currency );

		if ( empty( $decimal ) ) {
			$decimal = 0;
		}
		if ( empty( $thousand_separator ) ) {
			$thousand_separator = ',';
		}
		if ( empty( $decimal_separator ) ) {

			$decimal_separator = '.';
		}
		if ( 'hide' === $cents ) {
			round( $from_price );
			$decimal = 0;
			if ( ! empty( $to_price ) ) {
				round( $to_price );
			}
		}
		$from_price = number_format( $from_price, $decimal, $decimal_separator, $thousand_separator );
		if ( ! empty( $to_price ) ) {
			$to_price = number_format( $to_price, $decimal, $decimal_separator, $thousand_separator );
		}
		$position = get_option( 'mwb_mmcsfw_position_' . $currency );

		if ( 'left' === $position || 'left_space' === $position ) {

			if ( $_product->is_type( 'simple' ) || $_product->is_type( 'external' ) || 'simple' === $custom ) {

				if ( empty( $to_price ) ) {

					$result = ' <span class="price">' . $symbol;
					if ( 'left_space' === $position ) {
						$result .= '&nbsp;';
					}
					$result .= $from_price . '</span>';
				} else {

					$result = '<span class="price"> ';
					if ( ! empty( $to_price ) ) {
						$result .= ' <del><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' . $symbol . '</span> ';
						if ( 'left_space' === $position ) {
							$result .= '&nbsp;';
						}
						$result .= $from_price . '</bdi></span></del>  <ins>';

						$result .= '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' . $symbol . '</span>';
						if ( 'left_space' === $position ) {
							$result .= '&nbsp;';
						}
						$result .= $to_price . '</bdi></span> ';
						if ( ! empty( $to_price ) ) {
							$result .= '</ins>';
						}
						$result .= '</span>';
					}
				}
			} else {

				$result = '<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' . $symbol . '</span>';
				if ( 'left_space' === $position ) {
					$result .= '&nbsp;';
				}
				$result .= $from_price . '</bdi></span> – <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"> ' . $symbol . '</span>';
				if ( 'left_space' === $position ) {
					$result .= '&nbsp;';
				}
				$result .= $to_price . '</bdi></span></span>';
			}
		} elseif ( 'right' === $position || 'right_space' === $position ) {

			if ( $_product->is_type( 'simple' ) || $_product->is_type( 'external' ) || 'simple' === $custom ) {
				if ( empty( $to_price ) ) {

					$result  = ' <span class="price">';
					$result .= $from_price;
					if ( 'right_space' === $position ) {
						$result .= '&nbsp;';
					}
					$result .= $symbol . '</span>';
				} else {

					$result = '<span class="price">   ';
					if ( ! empty( $to_price ) ) {
						$result .= ' <del><span class="woocommerce-Price-amount amount"><bdi> ' . $from_price;
						if ( 'right_space' === $position ) {
							$result .= '&nbsp;';
						}
						$result .= ' <span class="woocommerce-Price-currencySymbol">' . $symbol . '</span></bdi></span></del> <ins>';

						$result .= '<span class="woocommerce-Price-amount amount"><bdi>' . $to_price;
						if ( 'right_space' === $position ) {
							$result .= '&nbsp;';
						}
						$result .= '<span class="woocommerce-Price-currencySymbol">' . $symbol . '</span></bdi></span>';
						if ( ! empty( $to_price ) ) {
							$result .= '</ins>';
						}
						$result .= '</span>';
					}
				}
			} else {

				$result = '<span class="price"><span class="woocommerce-Price-amount amount"><bdi>' . $from_price;

				if ( 'right_space' === $position ) {
					$result .= '&nbsp;';
				}
				$result .= ' <span class="woocommerce-Price-currencySymbol">' . $symbol . '</span></bdi></span> – <span class="woocommerce-Price-amount amount"><bdi>' . $to_price;
				if ( 'right_space' === $position ) {
					$result .= '&nbsp;';
				}
				$result .= '<span class="woocommerce-Price-currencySymbol">' . $symbol . '</span></bdi></span></span>';
			}
		}

		$result = apply_filters( 'mwb_mmcsfw_price_after_custom_format', $result );
		return $result;
	}

	/**
	 * Function used to convert product price into price according to currency.
	 *
	 * @param [type] $product_price is the price of currenct product.
	 * @param [type] $product_id is the id of current product.
	 * @return mixed
	 */
	public function mwb_mmcsfw_get_price_of_product( $product_price = '', $product_id = '' ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $product_price;
		}
		$other_product_price = '';

		$other_product_price = apply_filters( 'mmcsfw_get_product_price_of_member', $other_product_price, $product_id );
		if ( ! empty( $other_product_price ) ) {
			return $other_product_price;
		}
		$price = '';
		$default_price = '';
		$decimal       = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$default_price = WC()->session->get( 's_selected_currency' );
		}
		if ( ! empty( $default_price ) ) {
			$decimal = get_option( 'mwb_mmcsfw_decimial_' . $default_price );
			$cents   = get_option( 'mwb_mmcsfw_cents_' . $default_price );
			update_option( 'woocommerce_price_num_decimals', $decimal );
			if ( empty( $decimal ) ) {
				$decimal = 0;
			}
			if ( 'hide' === $cents ) {
				$decimal = 0;
			}
		}

		if ( ! empty( $default_price ) ) {
			$mwb_price           = get_option( 'mwb_mmcsfw_text_rate_' . $default_price );
			$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $default_price );

			if ( 0 === $decimal ) {
				$new_price = floatval( $product_price * round( $mwb_price, 2 ) );
			} else {
				$new_price = floatval( $product_price * round( $mwb_price, $decimal ) );
			}
			if ( ! empty( $mwb_mmcsfw_interest ) ) {
				$new_price = $new_price + $mwb_mmcsfw_interest;
			}

			if ( get_option( 'mmcsfw_radio_switch_custom_product', true ) == 'on' ) {
				$new_price = apply_filters( 'mwb_currency_switcher_cart_product_fixed_price', $new_price, $product_id );
			}

			$price = floatval( $new_price );
		}

		return $price;
	}

	/**
	 * Function used to change mini cart price.
	 *
	 * @param [type] $price is the product price.
	 * @param [type] $product is the current product.
	 * @return mixed
	 */
	public function mwb_mmcsfw_change_woocommerce_cart_product_price( $price, $product ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $price;
		}
		if ( did_action( 'woocommerce_add_to_cart' ) > 0 ) {
			return $price;
		}

		if ( is_cart() ) {
			return $price;
		}

		$all_product_price = 0;

		$price = $this->mwb_mmcsfw_get_price_of_product( $product->get_price(), $product->get_id() );

		update_post_meta( $product->get_id(), 'mwb_mmcsfw_price_mini_cart', $price );

		return wc_price( $price );
	}


	/**
	 * Function used to update mini cart sub total.
	 *
	 * @param [type] $cart_subtotal is the total of sub cart.
	 * @param [type] $compound is the compound value.
	 * @param [type] $instance is the current instance.
	 * @return mixed
	 */
	public function mwb_mmcsfw_modifiy_cart_total( $cart_subtotal, $compound, $instance ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $cart_subtotal;
		}
		if ( did_action( 'woocommerce_add_to_cart' ) > 0 ) {
			return $cart_subtotal;
		}

		if ( is_cart() ) {
			return $cart_subtotal;
		}
		$all_product_price = 0;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$product_id = ! empty( $cart_item['product_id'] ) ? $cart_item['product_id'] : $cart_item['variation_id'];
			if ( ! empty( $cart_item['variation_id'] ) ) {
				$product_id = $cart_item['variation_id'];
			}
			$price = floatval( get_post_meta( $product_id, 'mwb_mmcsfw_price_mini_cart', true ) );
			$cart_quantity = $cart_item['quantity'];

			$all_product_price = $all_product_price + ( $price * $cart_quantity );

		}
		$cart_subtotal = wc_price( $all_product_price );

		return $cart_subtotal;
	}
}
