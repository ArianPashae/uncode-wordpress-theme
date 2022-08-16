<?php
/**
 * Checkout functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Load custom checkout JS file
 */
function uncode_woocommerce_enqueue_checkout_script() {
	$scripts_prod_conf = uncode_get_scripts_production_conf();
	$resources_version = isset( $scripts_suffix_folder[ 'resources_version' ] ) ? $scripts_suffix_folder[ 'resources_version' ] : rand();
	$suffix            = isset( $scripts_suffix_folder[ 'suffix' ] ) ? $scripts_suffix_folder[ 'suffix' ] : '';
	$folder            = isset( $scripts_suffix_folder[ 'folder' ] ) ? $scripts_suffix_folder[ 'folder' ] : '';

	wp_enqueue_script( 'uncode-woocommerce-checkout', get_template_directory_uri() . '/library/js/' . $folder . 'woocommerce-checkout' . $suffix . '.js', array( 'jquery' ) , $resources_version, true );
}

/**
 * Append the hidden login form to the checkout page.
 * Just the original and unmodified WC form wrapped in a div.
 */
function uncode_woocommerce_checkout_login_form() {
	echo '<div class="uncode-wc-hidden-form uncode-wc-hidden-form--login" style="display:none !important">';
	woocommerce_login_form();
	echo '</div>';
}

/**
 * Wrap payment methods in a div in compact mode (start).
 */
function uncode_woocommerce_checkout_payment_methods_wrapper_begin() {
	echo '<div class="woocommerce-checkout-payment-wrapper">';
	echo '<strong>' . esc_html__( 'Payment method', 'uncode' ) . '</strong>';
}

/**
 * Wrap payment methods in a div in compact mode (end).
 */
function uncode_woocommerce_checkout_payment_methods_wrapper_end() {
	echo '</div>';
}

/**
 * Show customer details.
 */
function uncode_woocommerce_show_customer_details_before_table( $order_id ) {
	$order                 = wc_get_order( $order_id );
	$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();

	if ( $show_customer_details ) {
		wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) );
	}
}

/**
 * When the filter 'woocommerce_checkout_redirect_empty_cart' is false
 * if someone visits the checkout page, the checkout form is replaced by
 * a notice via AJAX. This function adds some padding.
 */
function uncode_woocommerce_update_order_review_fragments( $fragments ) {
	if ( isset( $fragments['form.woocommerce-checkout'] ) ) {
		$fragments['form.woocommerce-checkout'] = '<div class="woocommerce-session-expired-wrapper">' . $fragments['form.woocommerce-checkout'] . '</div>';
	}

	return $fragments;
}
add_filter( 'woocommerce_update_order_review_fragments', 'uncode_woocommerce_update_order_review_fragments' );
