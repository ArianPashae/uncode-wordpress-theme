<?php
/**
 * Yith Wishlist support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if WP Rocket is active
if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_WP_Rocket' ) ) :

/**
 * Uncode_WP_Rocket Class
 */
class Uncode_WP_Rocket {

	/**
	 * Construct.
	 */
	public function __construct() {
		add_filter( 'uncode_lazyload_type', array( $this, 'append_lazyload_check' ) );
	}

	/**
	 * Remove options in General tab.
	 */
	public function append_lazyload_check() {
		if ( get_rocket_option( 'lazyload' ) ) {
			return 'rocket';
		}

		return false;
	}
}

endif;

return new Uncode_WP_Rocket();
