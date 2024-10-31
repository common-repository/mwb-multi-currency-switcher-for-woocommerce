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

?>
<div class="mwb-overview__wrapper">
	<div class="mwb-overview__banner">
		<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/Currency Switcher for Woocommerce.png" alt="Overview banner image">
	</div>
	<div class="mwb-overview__content">
		<div class="mwb-overview__content-description">
			<h2><?php echo esc_html_e( 'What is MWB Multi Currency Switcher For WooCommerce?', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e(
					'MWB Multi Currency Switcher For WooCommerce is the plugin that allows merchants to provide multiple currencies on the WooCommerce store. This helps international users to view and pay for your products in their local currency. Using a currency switcher for WooCommerce will help you expand your business globally.',
					'mwb-multi-currency-switcher-for-woocommerce'
				);
				?>
			</p>
			<p>
				<?php
				esc_html_e(
					'The MWB Multi Currency Switcher For WooCommerce allows you to provide options for 3 currencies at a time to your users. This multi-currency converter also provides a user-friendly interface and design besides providing multi-lingual support.',
					'mwb-multi-currency-switcher-for-woocommerce'
				);
				?>
			</p>
			<h3><?php esc_html_e( 'With our MWB Multi-Currency Switcher for WooCommerce plugin, you can:', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
			<ul class="mwb-overview__features">
				<li>
				<?php

				if ( class_exists( 'Woocommerce_Multi_Currency_Switcher' ) ) {
					esc_html_e( 'Add functionality of unlimited currencies to your WooCommerce store for international users.', 'mwb-multi-currency-switcher-for-woocommerce' );

				} else {
						esc_html_e( 'Add functionality of three currencies to your WooCommerce store for international users.', 'mwb-multi-currency-switcher-for-woocommerce' );
				}
				?>
				</li>
				<li><?php esc_html_e( 'Add currency symbols and set the currency position.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Set custom thousand and decimal separators.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Synchronize currency with respect to the users’s geolocation.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Use of efficient aggregators for currency conversion without the need for an API key.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Set welcome currency for visitors.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Side switcher for more user friendly', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Flag of specific country will auto load and can also set custom flag.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></li>
				<?php	do_action( 'mwb_multi_currency_switcher_add_li_to_overview' ); ?>
			</ul>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h2>
		<div class="mwb-overview__keywords">
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/User-Friendly.jpg' ); ?>" alt="User-Friendly image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'User Friendly', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'The plugin allows a user-friendly interface for your customers. You can allow them to choose their currency easily by putting up convenient currency switcher formats such as a dropdown menu, side switcher, and country flags.',
								'mwb-multi-currency-switcher-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Local-Currency-Detection.jpg' ); ?>" alt="Local Currency Detection image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Local Currency Detection', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description"><?php echo esc_html_e( 'The multi-currency switcher allows you to detect the visitors’ IP and hence, set the native currency according to the GeoIP rule defined by the merchant.  ', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Custom-Price-Formats.jpg' ); ?>" alt="Custom Price Format image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Custom Price Formats', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'You can ensure price formats as per your choice by predefining the thousands and decimal separators. You also get to place the currency symbol and price on either side of your choice. ',
								'mwb-multi-currency-switcher-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Efficient-Currency-Aggregators.jpg' ); ?>" alt="Efficient Currency Aggregators image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Efficient Currency Aggregators', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'The multi-currency switcher allows for 5 currency aggregators enabling effective currency conversions. MWB multi-currency switcher plugin provides exclusivity in the fact that merchants do not need an API key for the currency aggregators. ',
								'mwb-multi-currency-switcher-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card mwb-card-support">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_MULTI_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Welcome-Currency.jpg' ); ?>" alt="Welcome Currency image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Welcome Currency', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'You can also set a default welcome currency for users. It helps them get a global perspective of your products. You can set a predefined currency for your customers irrespective of their location and allow them to switch currency as per their convenience.',
								'mwb-multi-currency-switcher-for-woocommerce'
							);
							?>
						</p>
					</div>
					<a href="https://makewebbetter.com/contact-us/" title=""></a>
				</div>
			</div>
		</div>
	</div>
</div>
