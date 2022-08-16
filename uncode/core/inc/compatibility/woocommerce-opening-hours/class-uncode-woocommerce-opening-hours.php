<?php
/**
 * WooCommerce Opening Hours support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if Yith Wishlist is active
if ( ! defined( 'OPENINGHOURS_VERSION' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_WooCommerce_Opening_Hours' ) ) :

/**
 * Uncode_WooCommerce_Opening_Hours Class
 */
class Uncode_WooCommerce_Opening_Hours {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_filter( 'openinghours_output_time_needed_error', '__return_false' );
	}
}

endif;

return new Uncode_WooCommerce_Opening_Hours();
