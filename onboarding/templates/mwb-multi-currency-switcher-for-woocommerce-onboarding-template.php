<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Multi_Currency_Switcher_For_Woocommerce
 * @subpackage Mwb_Multi_Currency_Switcher_For_Woocommerce/admin/onboarding
 */

global $mwb_mmcsfw_obj;
$mwb_mmcsfw_onboarding_form_fields = apply_filters( 'mwb_mmcsfw_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $mwb_mmcsfw_onboarding_form_fields ) ) : ?>
	<div class="mwb-mmcsfw-dialog mdc-dialog mdc-dialog--scrollable">
		<div class="mwb-mmcsfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-mmcsfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-mmcsfw-on-boarding-close-btn">
						<a href="#"><span class="mmcsfw-close-form material-icons mwb-mmcsfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-mmcsfw-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'mwb-multi-currency-switcher-for-woocommerce' ) . esc_html_e( 'MakeWebBetter' ); ?> </h3>
					<p class="mwb-mmcsfw-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></p>

					<form action="#" method="post" class="mwb-mmcsfw-on-boarding-form">
						<?php
						$mwb_mmcsfw_onboarding_html = $mwb_mmcsfw_obj->mwb_mmcsfw_plug_generate_html( $mwb_mmcsfw_onboarding_form_fields );
						echo esc_html( $mwb_mmcsfw_onboarding_html );
						?>
						<div class="mwb-mmcsfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-mmcsfw-on-boarding-form-submit mwb-mmcsfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-mmcsfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-mmcsfw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-mmcsfw-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'mwb-multi-currency-switcher-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
