<?php
/**
 * Cart functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Load custom cart JS file
 */
function uncode_woocommerce_enqueue_cart_script() {
	$scripts_prod_conf = uncode_get_scripts_production_conf();
	$resources_version = isset( $scripts_prod_conf[ 'resources_version' ] ) ? $scripts_prod_conf[ 'resources_version' ] : rand();
	$suffix            = isset( $scripts_prod_conf[ 'suffix' ] ) ? $scripts_prod_conf[ 'suffix' ] : '';
	$folder            = isset( $scripts_prod_conf[ 'folder' ] ) ? $scripts_prod_conf[ 'folder' ] : '';

	wp_enqueue_script( 'uncode-woocommerce-cart', get_template_directory_uri() . '/library/js/' . $folder . 'woocommerce-cart' . $suffix . '.js', array( 'jquery' ) , $resources_version, true );
}

/**
 * Get empty cart page ID if set.
 */
function uncode_woocommerce_get_empty_cart_page_id() {
	$empty_cart_page_id = get_option( 'uncode_woocommerce_empty_cart_page_id' );

	return $empty_cart_page_id;
}

/**
 * Get empty cart page URL if set.
 */
function uncode_woocommerce_get_empty_cart_page_url() {
	$url                = '';
	$empty_cart_page_id = uncode_woocommerce_get_empty_cart_page_id();

	if ( $empty_cart_page_id > 0 ) {
		$url = get_permalink( $empty_cart_page_id );
	}

	return $url;
}

/**
 * Redirect to custom empty cart page if set.
 */
function uncode_woocommerce_redirect_to_empty_cart_page() {
	if ( function_exists( 'vc_is_page_editable' ) && vc_is_page_editable() ) {
		return;
	}

	$empty_cart_page_url = uncode_woocommerce_get_empty_cart_page_url();

	if ( $empty_cart_page_url && is_cart() && WC()->cart->is_empty() ) {
		wp_safe_redirect( $empty_cart_page_url );
		exit;
	} else {
		$custom_empty_cart_page_id = uncode_woocommerce_get_empty_cart_page_id();

		if ( apply_filters( 'uncode_woocommerce_redirect_to_empty_cart_page', true ) && $custom_empty_cart_page_id > 0 && is_page( $custom_empty_cart_page_id ) && ! WC()->cart->is_empty() ) {
			wp_safe_redirect( wc_get_page_permalink( 'cart' ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'uncode_woocommerce_redirect_to_empty_cart_page' );
