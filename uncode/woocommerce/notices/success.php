<?php
/**
 * Show messages
 *
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ) {
	return;
}

$uncode_woocommerce_atc_notify = ot_get_option('_uncode_woocommerce_atc_notify');
$uncode_woocommerce_atc_notify = ot_get_option('_uncode_woocommerce_cart') === 'on' ? $uncode_woocommerce_atc_notify : '';
$uncode_show_notice            = $uncode_woocommerce_atc_notify !== 'minicart';
$uncode_show_notice            = is_account_page() ? true : $uncode_show_notice;
?>

<?php foreach ( $messages as $message ) : ?>
	<?php $message = str_replace('button wc-forward', 'button wc-forward btn-link', $message); ?>

	<?php if ( apply_filters( 'uncode_show_woocommerce_success_notice', $uncode_show_notice ) ) { ?>
		<?php if ( is_product() ) { ?>
		<div class="row-container row-message">
			<div class="row-parent limit-width double-top-padding no-bottom-padding">
		<?php } ?>

				<div class="woocommerce-message wc-notice" role="alert"<?php echo function_exists( 'wc_get_notice_data_attr' ) ? wc_get_notice_data_attr( $message ) : ''; ?>>
					<?php
						echo wc_kses_notice( $message );
					?>
				</div>

		<?php if ( is_product() ) { ?>
			</div>
		</div>
		<?php } ?>
	<?php } ?>
<?php endforeach; ?>
