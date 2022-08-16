<?php
/**
 * Upsells related functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get upsells products IDs.
 */
function uncode_get_upsell_product_ids( $product_id ) {
	$product    = wc_get_product( $product_id );
	$upsell_ids = array();

	if ( ! $product ) {
		return $upsell_ids;
	}

	$upsell_ids = $product->get_upsell_ids();

	return $upsell_ids;
}

/**
 * Append a special class to the body when there are no upsells.
 */
function uncode_add_upsell_not_found_class( $classes ) {
	if ( is_product() ) {
		$product_id = get_the_ID();

		if ( $product_id > 0 ) {
			$upsells_ids = uncode_get_upsell_product_ids( $product_id );
			if ( ! ( is_array( $upsells_ids ) && count( $upsells_ids ) > 0 ) ) {
				$classes[] = 'no-product-upsells';
			}
		}
	}

	return $classes;
}
add_filter( 'body_class', 'uncode_add_upsell_not_found_class' );
