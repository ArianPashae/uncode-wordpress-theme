<?php

/**
 * Get the CSS rules from a string (without selectors)
 */
function uncode_get_custom_inline_css( $css ) {
	$internal_css = '';
	$css          = trim( $css );

	$regex = '/{([^}]*)}/m';
	preg_match_all( $regex, $css, $matches, PREG_SET_ORDER, 0 );

	if ( count( $matches ) ) {
		if ( isset( $matches[0] ) && is_array( $matches[0] ) ) {
			$match = $matches[0];

			if ( isset( $match[1] ) && $match[1] ) {
				$internal_css = $match[1];
			}
		}
	}

	$internal_css = str_replace( '!important', '', $internal_css );

	return $internal_css;
}

/**
 * Re-init some needed globals when we load (update)
 * a shortcode in the frontend editor.
 */
function uncode_setup_vc_frontend_globals() {
	global $register_adaptive_meta, $resize_image_quality;

	$adaptive_images        = ot_get_option('_uncode_adaptive');
	$register_adaptive_meta = ot_get_option('_uncode_adaptive_register_meta') === 'on' ? true : false;
	$dynamic_srcset_active  = $adaptive_images === 'off' && ot_get_option('_uncode_dynamic_srcset') === 'on' ? true : false;

	if ( $dynamic_srcset_active ) {
		$register_adaptive_meta = true;
	}

	$resize_image_quality = ot_get_option('_uncode_adaptive_quality');
}
add_action( 'vc_load_shortcode', 'uncode_setup_vc_frontend_globals' );

