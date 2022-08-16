<?php
/**
 * My Account functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get login page ID if set.
 */
function uncode_woocommerce_get_login_page_id() {
	$login_page_id = get_option( 'uncode_woocommerce_my_account_login_page_id' );

	return $login_page_id;
}

/**
 * Get login page URL if set.
 */
function uncode_woocommerce_get_login_page_url() {
	$url           = '';
	$login_page_id = uncode_woocommerce_get_login_page_id();

	if ( $login_page_id > 0 ) {
		$url = get_permalink( $login_page_id );
	}

	return $url;
}

/**
 * Redirect to custom login page if set.
 */
function uncode_woocommerce_redirect_to_login_page() {
	if ( function_exists( 'vc_is_page_editable' ) && vc_is_page_editable() ) {
		return;
	}

	$login_page_url = uncode_woocommerce_get_login_page_url();

	if ( $login_page_url && is_account_page() ) {
		global $wp;

		if ( ! is_null( WC()->cart ) && ! is_user_logged_in() && ! isset( $wp->query_vars['lost-password'] ) ) {
			wp_safe_redirect( $login_page_url );
			exit;
		}
	} else {
		$custom_login_page_id = uncode_woocommerce_get_login_page_id();

		if ( apply_filters( 'uncode_woocommerce_redirect_to_login_page', true ) && $custom_login_page_id > 0 && is_page( $custom_login_page_id ) && is_user_logged_in() ) {
			wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'uncode_woocommerce_redirect_to_login_page' );

/**
 * Set the "is_account_page()" conditional to true
 * when we have a custom account forms module
 */
function uncode_woocommerce_is_account_page( $is_account_page ) {
	if ( function_exists( 'wc_post_content_has_shortcode' ) && wc_post_content_has_shortcode( 'uncode_woocommerce_account_forms' ) ) {
		$is_account_page = true;
	}

	return $is_account_page;
}
add_filter( 'woocommerce_is_account_page', 'uncode_woocommerce_is_account_page' );
