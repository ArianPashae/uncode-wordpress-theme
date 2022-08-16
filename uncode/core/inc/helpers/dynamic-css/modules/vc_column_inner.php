<?php
/**
 * Column Inner CSS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Generate the CSS for the module
 */
function uncode_get_dynamic_colors_css_for_shortcode_vc_column_inner( $shortcode, $custom_color_keys ) {
	$accepted_keys = array(
		'back_color'    => array( 'bg' ),
		'overlay_color' => array( 'bg' ),
		'border_color'  => array( 'border' ),
	);

	$css = '';

	$shortcode['type'] = 'vc_column';

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
