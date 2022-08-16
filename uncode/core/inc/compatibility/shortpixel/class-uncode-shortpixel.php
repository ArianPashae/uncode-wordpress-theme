<?php
/**
 * ShortPixel support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if ShortPixel is active
if ( ! class_exists( 'WPShortPixel' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_ShortPixel' ) ) :

/**
 * Uncode_ShortPixel Class
 */
class Uncode_ShortPixel {

	/**
	 * Construct.
	 */
	public function __construct() {
		if ( ! defined( 'SHORTPIXEL_CUSTOM_THUMB_INFIXES' ) ) {
			define( 'SHORTPIXEL_CUSTOM_THUMB_INFIXES', '-uai' );
		}
	}
}

endif;

return new Uncode_ShortPixel();
