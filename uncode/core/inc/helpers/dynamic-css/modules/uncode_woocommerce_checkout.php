<?php
/**
 * WC Checkout CSS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Generate the CSS for the module
 */
function uncode_get_dynamic_colors_css_for_shortcode_uncode_woocommerce_checkout( $shortcode, $custom_color_keys ) {
	$accepted_keys = array(
		'checkout_form_back_color'     => array( 'bg' ),
		'order_payment_back_color'     => array( 'bg' ),
		'checkout_button_button_color' => array( 'button', 'text' ),
	);

	$css = '';

	foreach ( $custom_color_keys as $custom_color_key ) {
		if ( ! array_key_exists( $custom_color_key, $accepted_keys ) ) {
			continue;
		}

		$css_value = uncode_get_dynamic_color_attr_data( $shortcode, $custom_color_key, $accepted_keys[$custom_color_key] );

		if ( $css_value ) {
			$css .= $css_value;
		}
	}

	return $css;
}
