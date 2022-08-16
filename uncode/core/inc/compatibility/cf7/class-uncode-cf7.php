<?php
/**
 * Uncode CF7 support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Return early if CF7 is not active
if ( ! class_exists( 'WPCF7' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_CF7_Support' ) ) :

/**
 * Uncode_CF7_Support Class
 */
class Uncode_CF7_Support {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Filter CF7 class
		add_filter( 'shortcode_atts_wpcf7', array( $this, 'form_class' ), 10, 4 );
	}

	/**
	 * Filter form class
	 */
	public function form_class( $out, $pairs, $atts, $shortcode ) {
		$input_class = isset( $atts[ 'html_class' ] ) && $atts[ 'html_class' ] ? $atts[ 'html_class' ] : false;

		if ( $input_class ) {
			if ( $input_class === 'default-background' || $input_class === 'no-labels-background' ) {
				$out[ 'html_class' ] = 'input-background';

				if ( $input_class === 'no-labels-background' ) {
					$out[ 'html_class' ] .= ' form-no-labels';
				}

			} else if ( $input_class === 'default-underline' || $input_class === 'no-labels-underline' ) {
				$out[ 'html_class' ] = 'input-underline';

				if ( $input_class === 'no-labels-underline' ) {
					$out[ 'html_class' ] .= ' form-no-labels';
				}
			} else if ( $input_class === 'no-labels-default' ) {
				$out[ 'html_class' ] .= ' form-no-labels';
			}
		}

		return $out;
	}
}

endif;

return new Uncode_CF7_Support();
