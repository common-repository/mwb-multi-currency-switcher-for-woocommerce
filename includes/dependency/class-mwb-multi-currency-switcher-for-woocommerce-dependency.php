<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/includes/dependency
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_admin_fetch_currency_rates_to_base_currency' ) ) {
	/**
	 * This function is used to get currenct rates mwb_mmcsfw_admin_fetch_currency_rates_to_base_currency.
	 *
	 * @param mixed $from_currency for default currency.
	 * @param mixed $amount_to_change for convert currency to base currency.
	 */
	function mwb_mmcsfw_admin_fetch_currency_rates_to_base_currency( $from_currency, $amount_to_change ) {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}

		if ( empty( $from_currency ) ) {
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$from_currency = WC()->session->get( 's_selected_currency' );
			}
		}
		if ( empty( $to_currency ) ) {
			$to_currency = get_woocommerce_currency();
		}

		if ( ! empty( $to_currency ) ) {
			$decimal = get_option( 'mwb_mmcsfw_decimial_' . $to_currency );
			$cents   = get_option( 'mwb_mmcsfw_cents_' . $to_currency );

			if ( empty( $decimal ) ) {
				$decimal = 0;
			}
			if ( 'hide' === $cents ) {
				$decimal = 0;
			}
		}
		$converted_rates = '';
		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_select_aggregator' );

		if ( ! empty( $fixed_amount ) ) {
			$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $to_currency );
			if ( ! empty( $mwb_mmcsfw_interest ) ) {
				$converted_rates = $converted_rates + $mwb_mmcsfw_interest;
			}
		}
		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_select_aggregator' );
		$fixed_amount    = get_option( 'mwb_mmcsfw_text_rate_' . $from_currency );
		if ( 0 === $decimal ) {
			$converted_rates = floatval( $amount_to_change / round( $fixed_amount, 2 ) );
		} else {
			$converted_rates = floatval( $amount_to_change / round( $fixed_amount, $decimal ) );
		}

		return $converted_rates;
	}
}


// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_get_base_currency' ) ) {
	/**
	 * This function is used to get currenct currency.
	 */
	function mwb_mmcsfw_get_base_currency() {
		$mwb_selected_currenct_currency = get_woocommerce_currency();
		return $mwb_selected_currenct_currency;
	}
}

// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_get_custom_currency_symbol' ) ) {
	/**
	 * This function is used to get currenct currency.
	 *
	 * @param mixed $selected_currency is the selected currency.
	 */
	function mwb_mmcsfw_get_custom_currency_symbol( $selected_currency ) {

		$currency_symbol = '';
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return get_woocommerce_currency();
		}
		if ( empty( $selected_currency ) ) {
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}
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
}



// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_get_custom_currency_symbol' ) ) {
	/**
	 * This function is used to get currenct currency.
	 */
	function mwb_mmcsfw_get_custom_currency_symbol() {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return get_woocommerce_currency_symbol( get_woocommerce_currency() );
		}
		if ( empty( $selected_currency ) ) {
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$selected_currency = WC()->session->get( 's_selected_currency' );
			}
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
}


// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_get_currenct_currency' ) ) {
		/**
		 * This function is used to get currenct currency.
		 */
	function mwb_mmcsfw_get_currenct_currency() {
		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return;
		}
		$mwb_selected_currenct_currency = '';
		if ( WC()->session->__isset( 's_selected_currency' ) ) {
			$mwb_selected_currenct_currency = WC()->session->get( 's_selected_currency' );
		} else {
			$mwb_selected_currenct_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
		}
		return $mwb_selected_currenct_currency;
	}
}



// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
	/**
	 * Remote method to get data.
	 *
	 * @param mixed $url to fetch data.
	 * @version 1.0.0
	 */
	function mwb_mmcsfw_get_url_contents( $url ) {
		$request = wp_remote_get( $url );
		if ( is_wp_error( $request ) ) {
			return false; // Return false if error.
		}
		$body = wp_remote_retrieve_body( $request );
		return $body;
	}
}
// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_admin_fetch_currency_rates_from_base_currency' ) ) {
	/**
	 * This function is used to get currenct rates.
	 *
	 * @param mixed $to_currency for active currency.
	 * @param mixed $amount_to_change is the amount by user.
	 */
	function mwb_mmcsfw_admin_fetch_currency_rates_from_base_currency( $to_currency = '', $amount_to_change = '' ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $amount_to_change;
		}
		if ( empty( $amount_to_change ) || 0 != $amount_to_change ) {
			return $amount_to_change;
		}
		$from_currency = get_woocommerce_currency();
		if ( empty( $to_currency ) ) {
			if ( WC()->session->__isset( 's_selected_currency' ) ) {
				$to_currency = WC()->session->get( 's_selected_currency' );
			}
		}

		if ( empty( $to_currency ) ) {
			$to_currency = get_option( 'mwb_mmcsfw_text_currency_' . get_option( 'mwb_mmcsfw_text_currency_checkbox' ) ); // Default currenct in switcher tab.
		}

		if ( ! empty( $to_currency ) ) {
			$decimal = get_option( 'mwb_mmcsfw_decimial_' . $to_currency );
			$cents   = get_option( 'mwb_mmcsfw_cents_' . $to_currency );

			if ( empty( $decimal ) ) {
				$decimal = 0;
			}
			if ( 'hide' === $cents ) {
				$decimal = 0;
			}
		}

		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_select_aggregator' );

		$converted_rates = '';
		$fixed_amount = floatval( get_option( 'mwb_mmcsfw_text_rate_' . $to_currency ) );

		if ( 0 !== $decimal ) {
			$converted_rates = floatval( $amount_to_change ) * round( $fixed_amount, $decimal );
		} else {
			$converted_rates = floatval( $amount_to_change ) * round( $fixed_amount, 2 );
		}

		if ( ! empty( $fixed_amount ) ) {
			$mwb_mmcsfw_interest = get_option( 'mwb_mmcsfw_interest_' . $to_currency );
			if ( ! empty( $mwb_mmcsfw_interest ) ) {
				$converted_rates = $converted_rates + $mwb_mmcsfw_interest;
			}
		}

		return $converted_rates;
	}
}


// Check if function exists.
if ( ! function_exists( 'mwb_mmcsfw_admin_calculate_currency_rates_for_wallet' ) ) {

	/**
	 * This function is calculate currency currenct rates.
	 *
	 * @param mixed $aggregator to calculate rates.
	 * @param mixed $mwb_default_currency default currency.
	 * @param mixed $mwb_currency_to_change to value.
	 */
	function mwb_mmcsfw_admin_calculate_currency_rates_for_wallet( $aggregator, $mwb_default_currency, $mwb_currency_to_change ) {

		if ( get_option( 'mmcsfw_radio_switch_demo' ) !== 'on' ) {
			return $mwb_currency_to_change;
		}

		if ( ! empty( $aggregator ) ) {
			update_option( 'mwb_mmcsfw_select_aggregator', $aggregator );
		}
		global $wp_filesystem;  // global object of WordPress filesystem.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem(); // intialise new file system object.
		$mwb_mmcsfw_currency_aggregator = get_option( 'mwb_mmcsfw_select_aggregator' );
		switch ( $mwb_mmcsfw_currency_aggregator ) {
			case 'yahooapi':
				$date = time();
				if ( $mwb_default_currency === $mwb_currency_to_change ) {
					$request = esc_html__( '1' );
					return $request;
				}
				$yql_query_url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . $mwb_default_currency . $mwb_currency_to_change . '=X?symbol=' . $mwb_default_currency . $mwb_currency_to_change . '%3DX&period1=' . ( $date - 60 * 86400 ) . '&period2=' . $date . '&interval=1d&includePrePost=false&events=div%7Csplit%7Cearn&lang=en-US&region=US&corsDomain=finance.yahoo.com';
				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = mwb_mmcsfw_get_url_contents( $yql_query_url );
				}
				$data = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );

				$result = isset( $data['chart']['result'][0]['indicators']['quote'][0]['open'] ) ? $data['chart']['result'][0]['indicators']['quote'][0]['open'] : ( isset( $data['chart']['result'][0]['meta']['previousClose'] ) ? array( $data['chart']['result'][0]['meta']['previousClose'] ) : array() );

				if ( count( $result ) && is_array( $result ) ) {
					$request = end( $result );
				}
				if ( empty( $request ) ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}

				return $request;

			case 'bankeuropean':
				$url = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = mwb_mmcsfw_get_url_contents( $url );
				}

				$currency_data = simplexml_load_string( $res );
				$rates         = array();
				$cube          = 'Cube';
				if ( empty( $currency_data->$cube->$cube ) ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
					return $request;
				}

				foreach ( $currency_data->$cube->$cube->$cube as $xml ) { // phpcs:ignore
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

				return $request;

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
					if ( $att['@attributes']['multiplier'] ) {
						$multiplier[ $att['@attributes']['currency'] ] = $att['@attributes']['multiplier'];
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
				return $request;

			case 'exchangerateapi':
				$exchange_currency = $mwb_currency_to_change;
				$query_url         = 'https://api.exchangerate.host/latest?base=' . $mwb_default_currency;

				if ( function_exists( 'mwb_mmcsfw_get_url_contents' ) ) {
					$res = mwb_mmcsfw_get_url_contents( $query_url );
				}
				// ***
				$data    = json_decode( sanitize_text_field( wp_unslash( $res ) ), true );
				$request = isset( $data['rates'][ $exchange_currency ] ) ? $data['rates'][ $exchange_currency ] : 0;

				if ( ! $request ) {
					$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
					$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				}

				return $request;

			default:
				$request  = esc_html__( 'no data available for ', 'mwb-multi-currency-switcher-for-woocommerce' );
				$request .= sprintf( esc_html( '%s' ), $mwb_currency_to_change );
				break;
		}

	}
}
