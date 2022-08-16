<?php
/**
 * Show error messages
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

?>

<?php if ( is_product() ) : ?>
<div class="woocommerce-error row-container row-message">
	<div class="row-parent limit-width double-top-padding no-bottom-padding">
<?php endif; ?>

		<ul class="woocommerce-error-list woocommerce-error wc-notice" role="alert">
			<?php foreach ( $messages as $message ) : ?>
				<li<?php echo function_exists( 'wc_get_notice_data_attr' ) ? wc_get_notice_data_attr( $message ) : ''; ?>>
					<?php
						echo wc_kses_notice( $message );
					?>
				</li>
			<?php endforeach; ?>
		</ul>

<?php if ( is_product() ) : ?>
	</div>
</div>
<?php endif; ?>
