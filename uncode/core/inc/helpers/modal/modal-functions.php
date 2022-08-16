<?php
/**
 * Modal related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get modal wrapper.
 */
function uncode_modal_get_wrapper_markup( $sizes = array(), $container_classes = array(), $content_classes = array() ) {
	if ( is_array( $container_classes ) ) {
		$container_classes = implode( ' ', $container_classes );
	} else {
		$container_classes = '';
	}

	if ( is_array( $content_classes ) ) {
		$content_classes = implode( ' ', $content_classes );
	} else {
		$content_classes = '';
	}

	$max_width  = '1000px';
	$max_height = '700px';
	$height     = false;

	if ( is_array( $sizes ) ) {
		if ( isset( $sizes['max-width'] ) ) {
			$max_width = $sizes['max-width'] && $sizes['max-width'] ? $sizes['max-width'] : $max_width;
		}

		if ( isset( $sizes['max-height'] ) ) {
			$max_height = $sizes['max-height'] && $sizes['max-height'] ? $sizes['max-height'] : $max_height;
		}

		if ( isset( $sizes['height'] ) ) {
			$height = $sizes['height'] && $sizes['height'] ? 'height:' . $sizes['height'] : false;
			$container_classes .= ' auto-height';
		}
	}

	$html = '<div class="unmodal-overlay"></div><div class="unmodal ' . esc_attr( $container_classes ) . '" style="max-width:' . esc_attr( $max_width ) . ';max-height:' . esc_attr( $max_height ) . ';' . esc_attr( $height ) . '"><div class="unmodal-content-wrapper ' . esc_attr( $content_classes ) . '"><span class="unmodal-close"></span><div id="unmodal-content" class="unmodal-content quick-view-content"></div></div></div>';

	return $html;
}
