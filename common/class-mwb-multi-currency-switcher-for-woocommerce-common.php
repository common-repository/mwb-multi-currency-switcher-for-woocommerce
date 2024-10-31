<?php
/**
 * The common functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace mwb_multi_currency_switcher_for_woocommerce_common.
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/common
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Multi_Currency_Switcher_For_Woocommerce_Common {

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
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'common/css/mwb-multi-currency-switcher-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function mwb_mmcsfw_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'common/js/mwb-multi-currency-switcher-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name . 'common',
			'mwb_mmcsfw_common_param',
			array(
				'ajaxurl'              => admin_url( 'admin-ajax.php' ),
				'nonce'                => wp_create_nonce( 'ajax-nonce' ),
				'message'              => __( 'First fill the currency code !!!', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'aggre_message'        => __( 'Select Aggregator !!!', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'geo_rules_saving_msg' => __( 'Geolocation Rules Settings saved !!', 'mwb-multi-currency-switcher-for-woocommerce' ),
				'Upload_image'         => __( 'Upload image', 'mwb-multi-currency-switcher-for-woocommerce' ),
			)
		);
		wp_enqueue_script( $this->plugin_name . 'common' );
	}


	/**
	 * This function sbp_change_product_price_display is used to display price.
	 *
	 * @param string $price The price of this plugin.
	 * @param string $product The current product object.
	 */
	public function mwb_mmcsfw_change_product_price_display( $price, $product ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $price;

		}
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( 'edit-product' === $screen->id ) {
				return $price;
			}
		}
		global $post; // is used to get post object for the current post.
		$_product                  = wc_get_product( $product->get_id() ); // Get current product data.
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
		$custom_product_type = apply_filters( 'mwb_currency_switcher_get_custom_product_type', $custom_product_type, $product->get_id() );
		if ( ! empty( $custom_product_type ) ) {
			$is_custom_product_type = true;
		}
		if ( ! empty( $_product ) ) {
			if ( $_product->is_type( 'simple' ) || $_product->is_type( 'external' ) || $is_custom_product_type ) {

				$mwb_regular = floatval( $_product->get_regular_price() ) * floatval( $round_price );
				$mwb_sales   = floatval( $_product->get_sale_price() ) * floatval( $round_price );

				$from_price_switcher = $mwb_regular;
				$to_price_switcher   = $mwb_sales;
			}
			if ( $_product->is_type( 'simple' ) || $_product->is_type( 'external' ) || $is_custom_product_type ) {
				if ( ! empty( $mwb_mmcsfw_interest ) ) {
					$from_price_switcher = $from_price_switcher + floatval( $mwb_mmcsfw_interest );
					if ( ! empty( $to_price_switcher ) ) {
						$to_price_switcher = $to_price_switcher + floatval( $mwb_mmcsfw_interest );
					}
				}
				$from_price_switcher = apply_filters( 'mwb_currency_switcher_simple_external_product_price_from', $from_price_switcher );
				$to_price_switcher   = apply_filters( 'mwb_currency_switcher_simple_external_product_price_to', $to_price_switcher );

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
		$currency = '';
		$symbol = '';
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			$currency = get_woocommerce_currency();
			$symbol = get_woocommerce_currency_symbol( $currency );
		} else {

			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$currency = WC()->session->get( 's_selected_currency' );
			}
			$symbol = mwb_mmcsfw_get_custom_currency_symbol( $currency );
		}
		$result = '';
		if ( ! empty( $_product ) ) {

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
				$to_price = number_format( floatval( $to_price ), $decimal, $decimal_separator, $thousand_separator );
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

		}return $result;
	}



	/**
	 * This my_actionssforshortcode is used to return content.
	 */
	public function mwb_mmcsfw_add_price_through_ajax() {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}
		if ( ! empty( $_POST['currency'] ) ) {
			$mwb_mmcsfw_currency_by_ajax = sanitize_text_field( wp_unslash( $_POST['currency'] ) );
			WC()->session->set( 's_selected_currency', $mwb_mmcsfw_currency_by_ajax );
			echo esc_html( $mwb_mmcsfw_currency_by_ajax );
		}
		wp_die();
	}

	/**
	 * This function is used to get currenct rates
	 */
	public function mwb_mmcsfw_admin_fetch_currency_rates() {

		$aggregator = '';
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}
		$mwb_default_currency = '';
		if ( ! empty( $_POST['Aggregator'] ) ) {
			$aggregator = sanitize_text_field( wp_unslash( $_POST['Aggregator'] ) ); // assigning variation id.
		}
		if ( ! empty( $_POST['currency_to_change'] ) ) {
			$mwb_currency_to_change = sanitize_text_field( wp_unslash( $_POST['currency_to_change'] ) ); // assigning variation id.
		}
		if ( ! empty( $_POST['Default'] ) ) {
			$mwb_default_currency = sanitize_text_field( wp_unslash( $_POST['Default'] ) ); // assigning variation id.
		}
		$val = $this->mwb_mmcsfw_admin_calculate_currency_rates( $aggregator, $mwb_default_currency, $mwb_currency_to_change );
		echo esc_attr( $val );
	}

	/**
	 * This function is calculate currency currenct rates.
	 *
	 * @param mixed $aggregator to calculate rates.
	 * @param mixed $mwb_default_currency default currency.
	 * @param mixed $mwb_currency_to_change to value.
	 */
	public function mwb_mmcsfw_admin_calculate_currency_rates( $aggregator, $mwb_default_currency, $mwb_currency_to_change ) {

		if ( ! empty( $aggregator ) ) {
			update_option( 'mwb_mmcsfw_currencies_aggregator', $aggregator );
		}
		global $wp_filesystem;  // global object of WordPress filesystem.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem(); // intialise new file system object.
		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_currencies_aggregator' );
		$request = '';
		switch ( $mwb_mmcsfw_currency_aggregator ) {
			case 'yahooapi':
				$date = time();
				if ( $mwb_default_currency === $mwb_currency_to_change ) {
					echo esc_attr( 1 );
					wp_die();
					return;
				}
				$yahoo_query_url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . $mwb_default_currency . $mwb_currency_to_change . '=X?symbol=' . $mwb_default_currency . $mwb_currency_to_change . '%3DX&period1=' . ( $date - 60 * 86400 ) . '&period2=' . $date . '&interval=1d&includePrePost=false&events=div%7Csplit%7Cearn&lang=en-US&region=US&corsDomain=finance.yahoo.com';
				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = $this->mwb_mmcsfw_get_url_contents( $yahoo_query_url );
				}
				$data   = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );
				$result = isset( $data['chart']['result'][0]['indicators']['quote'][0]['open'] ) ? $data['chart']['result'][0]['indicators']['quote'][0]['open'] : ( isset( $data['chart']['result'][0]['meta']['previousClose'] ) ? array( $data['chart']['result'][0]['meta']['previousClose'] ) : array() );

				if ( count( $result ) && is_array( $result ) ) {
					$request = end( $result );
				}
				if ( empty( $request ) ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}
				echo esc_attr( $request );
				wp_die();

				return;
				break;

			case 'bankeuropean':
				$url = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = $this->mwb_mmcsfw_get_url_contents( $url );
				}

				$currency_data = simplexml_load_string( $res );
				$rates         = array();
				$cube          = 'Cube';
				if ( empty( $currency_data->$cube->$cube ) ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
					break;
				}

				foreach ( $currency_data->$cube->$cube->$cube as $xml ) {
					$att                                      = (array) $xml->attributes();
					$rates[ $att['@attributes']['currency'] ] = floatval( $att['@attributes']['rate'] );
				}
				// ***

				if ( ! empty( $rates ) ) {

					if ( 'EUR' !== $mwb_default_currency ) {
						if ( 'EUR' !== $mwb_currency_to_change ) {
							if ( isset( $mwb_currency_to_change ) ) {
								$request = floatval( $rates[ $mwb_currency_to_change ] / $rates[ $mwb_default_currency ] );
							} else {
								$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
								$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
							}
						} else {
							$request = 1 / $rates[ $mwb_default_currency ];
						}
					} else {
						if ( 'EUR' !== $mwb_currency_to_change ) {
							$request = $rates[ $mwb_currency_to_change ];
						} else {
							$request = 1;
						}
					}
				} else {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}

				if ( ! $request ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}

				echo esc_attr( $request );
				wp_die();
				break;

			case 'romanieibank':
				$url = 'https://www.bnr.ro/nbrfxrates.xml';

				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$data_romaniei = $this->mwb_mmcsfw_get_url_contents( $url );
				}
				$mwb_mmcsfw_currency_data = simplexml_load_string( $data_romaniei );
				$rates                    = array();
				$multiplier               = array();
				$cube                     = 'Cube';
				$body                     = 'Body';
				$rate                     = 'Rate';
				if ( empty( $mwb_mmcsfw_currency_data->$body->$cube ) ) { // phpcs:ignore 
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
					break;
				}
				foreach ( $mwb_mmcsfw_currency_data->$body->$cube->$rate as $xml ) { // phpcs:ignore
					$att                                      = (array) $xml->attributes();
					$final['rate']                            = (string) $xml;
					$rates[ $att['@attributes']['currency'] ] = floatval( $final['rate'] );

					if ( count( $att['@attributes'] ) > 1 ) {
						if ( $att['@attributes']['multiplier'] ) {
							$multiplier[ $att['@attributes']['currency'] ] = $att['@attributes']['multiplier'];
						}
					}
				}
				// ***
				if ( ! empty( $rates ) ) {
					if ( 'RON' !== $mwb_default_currency ) {
						if ( 'RON' !== $mwb_currency_to_change ) {
							if ( isset( $mwb_currency_to_change ) ) {
								$request = 1 / floatval( $rates[ $mwb_currency_to_change ] / $rates[ $mwb_default_currency ] );
								$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
							} else {
								$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
								$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
							}
						} else {
							$request = 1 * ( $rates[ $mwb_default_currency ] );
							$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
						}
					} else {
						if ( 'RON' !== $mwb_currency_to_change ) {
							if ( $rates[ $mwb_currency_to_change ] < 1 ) {
								$request = 1 / $rates[ $mwb_currency_to_change ];
								$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
							} else {
								$request = $rates[ $mwb_currency_to_change ];
								$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
							}
						} else {
							$request = 1;
							$request = ! empty( $multiplier[ $mwb_currency_to_change ] ) ? $request * floatval( $multiplier[ $mwb_currency_to_change ] ) : $request;
						}
					}
				} else {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}
				// ***

				if ( ! $request ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}
				echo esc_attr( $request );
				wp_die();
				break;

			case 'bankofitaly':
				$mwb_mmcsfw_italybank_url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';

					$data_italy = $wp_filesystem->get_contents( $mwb_mmcsfw_italybank_url );

				// ***
				$mwb_mmcsfw_italy_data = json_decode( sanitize_text_field( wp_unslash( $data_italy ) ), true );
				if ( ! empty( $mwb_mmcsfw_italy_data ) ) {
					if ( 'UAH' != $mwb_default_currency ) {

						$def_cur_rate = 0;
						foreach ( $mwb_mmcsfw_italy_data as $item ) {
							if ( $item['cc'] == $mwb_default_currency ) {
								$def_cur_rate = $item['rate'];
								break;
							}
						}
						if ( ! $def_cur_rate ) {
							$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
							$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
							break;
						} elseif ( 'UAH' == $mwb_currency_to_change ) {
							$request = 1 * $def_cur_rate;
						}
						foreach ( $mwb_mmcsfw_italy_data as $item ) {
							if ( $item['cc'] == $mwb_currency_to_change ) {
								if ( 'UAH' != $mwb_currency_to_change ) {
									if ( isset( $mwb_currency_to_change ) ) {
										$request = 1 / floatval( $item['rate'] / $def_cur_rate );
									} else {
										$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
										$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
									}
								} else {
									$request = 1 * $def_cur_rate;
								}
							}
						}
					} else {
						if ( 'UAH' == $mwb_currency_to_change ) {
							foreach ( $mwb_mmcsfw_italy_data as $item ) {
								if ( $mwb_currency_to_change == $item['cc'] ) {
									$request = 1 / $item['rate'];
									break;
								}
							}
						} else {
							$request = 1;
						}
					}
				}
				if ( ! $request ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}
				echo esc_attr( $request );
				wp_die();
				break;

			case 'exchangerateapi':
				$exchange_currency = $mwb_currency_to_change;
				$query_url         = 'https://api.exchangerate.host/latest?base=' . $mwb_default_currency;

				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = $this->mwb_mmcsfw_get_url_contents( $query_url );
				}
				// ***
				$data    = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );
				$request = isset( $data['rates'][ $exchange_currency ] ) ? $data['rates'][ $exchange_currency ] : 0;

				if ( ! $request ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}

				echo esc_attr( $request );
				break;

			default:
				$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
				$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				break;
		}
		wp_die();

	}


	/**
	 * Saving of the template of edit option for currency table.
	 */
	public function mwb_mmcsfw_feature_saving_throgh_ajax() {
		global $mwb_mmcsfw_obj;
		$mwb_mmcsfw_option_flag = false;
		if ( ! isset( $_POST['ajax-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ajax-nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}

		if ( ! empty( $_POST['currency'] ) ) {
			$currency               = sanitize_text_field( wp_unslash( $_POST['currency'] ) ); // assigning variation id.
			$mwb_mmcsfw_option_flag = true;
		}

		update_option( 'mwb_mmcsfw_custom_flag_image_' . $currency, isset( $_POST['image'] ) ? sanitize_text_field( wp_unslash( $_POST['image'] ) ) : '' );

		update_option( 'mwb_mmcsfw_description_' . $currency, isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : '' );

		update_option( 'mwb_mmcsfw_cents_' . $currency, isset( $_POST['cents'] ) ? sanitize_text_field( wp_unslash( $_POST['cents'] ) ) : '' );

		update_option( 'mwb_mmcsfw_thousand_separator_' . $currency, isset( $_POST['thousand_separator'] ) ? sanitize_text_field( wp_unslash( $_POST['thousand_separator'] ) ) : '' );

		update_option( 'mwb_mmcsfw_decimal_separator_' . $currency, isset( $_POST['decimal_separator'] ) ? sanitize_text_field( wp_unslash( $_POST['decimal_separator'] ) ) : '' );

		update_option( 'mwb_mmcsfw_custom_symbol_' . $currency, isset( $_POST['symbol'] ) ? sanitize_text_field( wp_unslash( $_POST['symbol'] ) ) : '' );

		do_action( 'mwb_currency_switcher_saving_edit_option' );

		if ( $mwb_mmcsfw_option_flag ) {
			$mwb_mmcsfw_error_text = esc_html__( 'Id of some field is missing', 'mwb-multi-currency-switcher-for-woocommerce' );
			$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'error' );
		} else {
			$mwb_mmcsfw_error_text = esc_html__( 'Settings saved !', 'mwb-multi-currency-switcher-for-woocommerce' );
			$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'success' );
		}

		wp_die();
	}


	/**
	 * Get the template of edit option for currency table.
	 */
	public function mwb_mmcsfw_include_modal_data() {

		if ( ! isset( $_POST['ajax-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ajax-nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}
		if ( ! empty( $_POST['currency'] ) ) {
			$currency = sanitize_text_field( wp_unslash( $_POST['currency'] ) ); // assigning variation id.
		}
		if ( ! empty( $_POST['index'] ) ) {
			$index = sanitize_text_field( wp_unslash( $_POST['index'] ) ); // assigning variation id.
		}

		$template_name = 'admin/mwb-multi-currency-switcher-for-woocommerce-admin-currency-table-edit-tab.php';

		$args = array(
			'currency' => $currency,
			'index'    => $index,
		);

		ob_start();
		wc_get_template( $template_name, $args );
		$response['option-edit'] = ob_get_clean();
		wp_send_json( $response );

	}

	/**
	 * Save geolocation data according to country.
	 */
	public function mwb_mmcsfw_save_geolocation_data() {
		global $mwb_mmcsfw_obj;
		$mwb_mmcsfw_geo_flag = false;
		if ( ! isset( $_POST['ajax-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ajax-nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}

		$index = get_option( 'mwb_mmcsfw_number_of_currency' );

		for ( $i = 1; $i <= $index; $i++ ) {
				$currency = get_option( 'mwb_mmcsfw_text_currency_' . $i );
				update_option( ! empty( $_POST['array_geolocation_name'][ $i - 1 ] ) ? map_deep( wp_unslash( $_POST['array_geolocation_name'][ $i - 1 ] ), 'sanitize_text_field' ) : '', ! empty( $_POST['array_geolocation'][ $i - 1 ] ) ? map_deep( wp_unslash( $_POST['array_geolocation'][ $i - 1 ] ), 'sanitize_text_field' ) : '' );
		}

		if ( $mwb_mmcsfw_geo_flag ) {
			$mwb_mmcsfw_error_text = esc_html__( 'Id of some field is missing', 'mwb-multi-currency-switcher-for-woocommerce' );
			$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'error' );
		} else {
			$mwb_mmcsfw_error_text = esc_html__( 'Geolocation Rules Settings saved !', 'mwb-multi-currency-switcher-for-woocommerce' );
			$mwb_mmcsfw_obj->mwb_mmcsfw_plug_admin_notice( $mwb_mmcsfw_error_text, 'success' );
		}

		wp_die();
	}

	/**
	 * Get currency rate with the url.
	 *
	 * @param mixed $url to fetch data.
	 */
	public function mwb_mmcsfw_get_url_contents( $url ) {
		$request = wp_remote_get( $url );
		if ( is_wp_error( $request ) ) {
			return false; // Return false if error.
		}
		$body = wp_remote_retrieve_body( $request );
		return $body;
	}

	/** This my_actionssforshortcode is used to return content to the ajax calling  */
	public function mwb_mmcsfw_action_to_get_variation_price() {
		if ( ! isset( $_POST['ajax-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ajax-nonce'] ) ), 'ajax-nonce' ) ) {
				wp_die();
		}
		$selected_currency = '';
		if ( ! empty( $_POST['Variation_Id'] ) ) {
			$variation_id = sanitize_text_field( wp_unslash( $_POST['Variation_Id'] ) ); // assigning variation id.
		}
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$selected_currency = WC()->session->get( 's_selected_currency' );
		}
		$_product                  = wc_get_product( $variation_id ); // Get current product data.
		$switcher_default_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
		$from_price_switcher       = '';
		$to_price_switcher         = '';
		$currency_symbol           = '';
		$result                    = '';
		if ( empty( $selected_currency ) || empty( $switcher_default_currency ) ) {
			return;
		}
		if ( ! empty( $selected_currency ) ) {
			$mwb_mmcsfw_price    = get_option( 'mwb_mmcsfw_text_rate_' . $selected_currency );
			$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $selected_currency );
			$round_price         = round( $mwb_mmcsfw_price, 2 );
		}
		if ( ! empty( $selected_currency ) ) {
			if ( ! empty( get_option( 'mwb_mmcsfw_custom_symbol_' . $selected_currency ) ) ) {
				$currency_symbol = get_option( 'mwb_mmcsfw_custom_symbol_' . $selected_currency );
			} elseif ( ! empty( get_option( 'mwb_mmcsfw_symbol_' . $selected_currency )[0] ) ) {
				$currency_symbol = get_option( 'mwb_mmcsfw_symbol_' . $selected_currency );
			}
		}
		$from_price_switcher = floatval( $_product->get_regular_price() ) * floatval( $round_price );
		$to_price_switcher   = floatval( $_product->get_sale_price() ) * floatval( $round_price );
		if ( ! empty( $mwb_mmcsfw_interest ) ) {
			$from_price_switcher = $from_price_switcher + floatval( $mwb_mmcsfw_interest );
			if ( ! empty( $to_price_switcher ) ) {
				$to_price_switcher = $to_price_switcher + floatval( $mwb_mmcsfw_interest );
			}
		}
		$from_price_switcher = apply_filters( 'mwb_currency_switcher_ajax_variable_product_from', $from_price_switcher, $variation_id );
		$to_price_switcher   = apply_filters( 'mwb_currency_switcher_ajax_variable_product_to', $to_price_switcher, $variation_id );

		$mwb_multi_currency_switcher_for_woocommerce_common = new Mwb_Multi_Currency_Switcher_For_Woocommerce_Common( 'MWB Multi Currency Switcher for WooCommerce', '1.0.0' );
		$result = $mwb_multi_currency_switcher_for_woocommerce_common->add_position_to_the_currency( $_product, $from_price_switcher, $to_price_switcher, 'simple' );

		$is_result_return = false;
		$is_result_return = apply_filters( 'mwb_currency_switcher_ajax_is_result_return', $is_result_return );
		if ( false == $is_result_return ) {
			echo wp_kses_post( $result );
		}
		wp_die();
		// this is required to terminate immediately and return a proper response.
	}

}

