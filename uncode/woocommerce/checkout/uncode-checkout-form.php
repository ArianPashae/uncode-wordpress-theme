<?php
/**
 * Checkout form template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php if ( $checkout->get_checkout_fields() ) : ?>

	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

	<div class="col2-set" id="customer_details">
		<div class="col-1">
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
		</div>

		<div class="col-2">
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

<?php endif; ?>
