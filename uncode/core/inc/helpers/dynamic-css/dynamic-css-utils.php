<?php
/**
 * Dynamic CSS utils
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get complete data of a dynamic color attribute
 */
function uncode_get_dynamic_color_attr_data( $shortcode, $attr, $properties = array( 'bg', 'button', 'text', 'border', 'overlay' ) ) {
	$color_type       = uncode_get_dynamic_color_attr_value( $shortcode, $attr . '_type' );
	$is_gradient      = $color_type === 'uncode-gradient' ? true : false;
	$color_value_attr = $is_gradient ? $attr . '_gradient' : $attr . '_solid';
	$color_value      = uncode_get_dynamic_color_attr_value( $shortcode, $color_value_attr, $is_gradient );
	$color_key        = $attr . '-' . $shortcode['id'];

	$css = '';

	$css_value = uncode_get_dynamic_color_background_css_value( $color_key, $color_value, $is_gradient, $properties );

	if ( $css_value ) {
		$css = $css_value;
	}

	return $css;
}

/**
 * Get the value of a dynamic color attribute
 */
function uncode_get_dynamic_color_attr_value( $shortcode, $attr, $gradient = false ) {
	// Return early if we don't have any attribute
	if ( ! isset( $shortcode['attributes'] ) ) {
		return false;
	}

	$value = isset( $shortcode['attributes'][$attr] ) ? $shortcode['attributes'][$attr] : false;

	if ( $gradient ) {
		$value = str_replace( "``", '"', $value );
		$value = str_replace( "`{`{", '[{', $value );
		$value = str_replace( "}`}`", '}]', $value );

		$value_gradient = json_decode( $value );

		if ( isset( $value_gradient->css ) ) {
			$value = $value_gradient->css;
		}
	}

	return $value;
}

/**
 * Get the CSS value of a background
 */
function uncode_get_dynamic_color_background_css_value( $key, $color_value, $gradient, $properties ) {
	if ( ! $color_value ) {
		return false;
	}

	if ( $gradient ) {
		ob_start();
		uncode_print_style_custom_gradient_color_css( $key, $color_value );
		$css = ob_get_clean();
	} else {
		if ( is_array( $properties ) && in_array( 'overlay', $properties ) ) {
			$value     = str_replace( ';nb',';b', $color_value );
			$value     = str_replace( ';n}',';}', $value );
			$color_value_rgb = sscanf( $value, "#%02x%02x%02x" );
		} else {
			$color_value_rgb = false; // fake value, we won't use it
		}

		if ( is_array( $properties ) && in_array( 'button', $properties ) ) {
			global $front_background_colors;
			$uncode_option = get_option(ot_options_id());
			$cs_heading_color_light = $uncode_option['_uncode_heading_color_light'];
			$btn_outline = $front_background_colors[$cs_heading_color_light];
		} else {
			$btn_outline = false; // fake value, we won't use it
		}

		ob_start();
		uncode_print_style_custom_solid_color_css( $key, $color_value, $color_value_rgb, $btn_outline, $properties );
		$css = ob_get_clean();
	}

	return $css;
}

/**
 * Get the CSS value of a background
 */
function uncode_get_shortcode_color_attribute_value( $attr, $shortcode_id, $type, $palette, $solid, $gradient ) {
	if ( ! $shortcode_id ) {
		return $palette;
	}

	if ( $type === 'uncode-solid' ) {
		$new_color = $solid ? $attr . '-' . $shortcode_id : '';

		return $new_color;
	}  else if ( $type === 'uncode-gradient' ) {
		$new_color = $gradient ? $attr . '-' . $shortcode_id : '';

		return $new_color;
	}

	return $palette;
}

/**
 * Print inline CSS (frontend editor)
 */
function uncode_print_dynamic_colors_inline_style( $css ) {
	if ( function_exists('vc_is_page_editable') && vc_is_page_editable() && $css ) {
		$style = '<style type="text/css">' . $css . '</style>';
	} else {
		$style = '';
	}

	return $style;
}
