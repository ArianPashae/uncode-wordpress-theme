<?php
/**
 * Adpative images functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get default breakpoints.
 */
function uncode_get_default_breakpoint_sizes() {
	return '258,516,720,1032,1440,2064,2880';
}

add_action( 'wp_ajax_get_adaptive_async', 'uncode_get_adaptive_async' );
add_action( 'wp_ajax_nopriv_get_adaptive_async', 'uncode_get_adaptive_async' );

function uncode_get_adaptive_async() {
	if ( isset( $_POST[ 'nonce_adaptive_images' ] ) ) {
		// Check nonce if enabled
		if ( apply_filters( 'uncode_enable_nonce_adaptive_images', false ) && ! wp_verify_nonce( $_POST[ 'nonce_adaptive_images' ], 'uncode-adaptive-images-nonce' ) ) {
			// Invalid nonce
			wp_send_json_error();
		}

		$posted_images     = isset( $_POST[ 'images' ] ) ? $_POST[ 'images' ] : array();
		$ai_breakpoints    = isset( $_POST[ 'ai_breakpoints' ] ) ? $_POST[ 'ai_breakpoints' ] : uncode_get_default_breakpoint_sizes();
		$resize_quality    = isset( $_POST[ 'resize_quality' ] ) ? $_POST[ 'resize_quality' ] : 90;
		$register_metadata = isset( $_POST[ 'register_metadata' ] ) ? $_POST[ 'register_metadata' ] : false;

		$async_data = array(
			'ai_breakpoints'    => $ai_breakpoints,
			'resize_quality'    => $resize_quality,
			'register_metadata' => $register_metadata
		);

		// Sanitize data
		$posted_images = uncode_sanitize_adaptive_async_data( $posted_images );
		$images        = array();

		foreach( $posted_images as $d ){
			$media_id              = explode( '-', $d[ 'unique' ] );
			$media_id              = $media_id[ 0 ];
			$resized               = uncode_resize_image( $media_id, $d[ 'url' ], $d[ 'path' ], $d[ 'origwidth' ], $d[ 'origheight' ], $d[ 'singlew' ], $d[ 'singleh' ], $d[ 'crop' ], $d[ 'fixed' ], array('images' => $d[ 'images' ], 'screen' => $d[ 'screen' ] ), $async_data );
			$resized[ 'id' ]       = $media_id;
			$resized[ 'unique' ]   = $d[ 'unique' ];
			$resized[ 'new_crop' ] = isset( $resized['new_crop'] ) && $resized['new_crop'] ? true : false;
			$images[]              = $resized;
		}

		$response = array(
	        'images' => $images
	    );

	    wp_send_json_success($response);

	} else {
		// Invalid data
		wp_send_json_error();
	}
}

/**
 * Sanitize posted async_data
 */
function uncode_sanitize_adaptive_async_data( $data ) {
	$sanitized_data = array();

	$data = json_decode( stripslashes( $data ) );

	foreach ( $data as $value ) {
		$sanitized_data[] = uncode_sanitize_adaptive_async_image( $value );
	}

	return $sanitized_data;
}

/**
 * Loop through each image object and sanitize it
 */
function uncode_sanitize_adaptive_async_image( $data ) {
	$image_data = array();

	foreach ( $data as $key => $value ) {
		if ( $key == 'unique' ) {
			$image_data[ 'unique' ] = sanitize_text_field( $value );
		} else if ( $key == 'url' ) {
			$image_data[ 'url' ] = esc_url( $value );
		} else if ( $key == 'path' ) {
			$image_data[ 'path' ] = sanitize_text_field( $value );
		} else if ( $key == 'singlew' ) {
			$image_data[ 'singlew' ] = sanitize_text_field( $value );
		} else if ( $key == 'singleh' ) {
			$image_data[ 'singleh' ] = sanitize_text_field( $value );
		} else if ( $key == 'origwidth' ) {
			$image_data[ 'origwidth' ] = absint( $value );
		} else if ( $key == 'origheight' ) {
			$image_data[ 'origheight' ] = absint( $value );
		} else if ( $key == 'crop' ) {
			$image_data[ 'crop' ] = $value ? absint( $value ) : null;
		} else if ( $key == 'fixed' ) {
			$image_data[ 'fixed' ] = $value ? sanitize_text_field( $value ) : null;
		} else if ( $key == 'screen' ) {
			$image_data[ 'screen' ] = absint( $value );
		} else if ( $key == 'images' ) {
			$image_data[ 'images' ] = absint( $value );
		} else if ( $key == 'missingbp' ) {
			$image_data[ 'missingbp' ] = sanitize_text_field( $value );
		}
	}

	return $image_data;
}

/**
 * Disable srcset with adaptive images
 */
if ( ! function_exists( 'uncode_disable_wp_responsive_images' ) ) :
/**
 * @since Uncode 2.3.0.3
 */
function uncode_disable_wp_responsive_images() {
	global $adaptive_images;
	if ( $adaptive_images === 'on' ) {
		return 1;
	}
}
endif;//uncode_disable_wp_responsive_images
add_filter('max_srcset_image_width', 'uncode_disable_wp_responsive_images');

/**
 * Get adaptive async class
 */
function uncode_get_adaptive_async_class( $options = array() ) {
	global $adaptive_images, $adaptive_images_async, $adaptive_images_async_blur;

	// The class that activates the async
	$adaptive_async_class = ' adaptive-async';

	// Blur effect
	$no_blur = false;
	if ( isset( $options['no_blur'] ) && $options['no_blur'] === true ) {
		$no_blur = true;
	}
	if ( $adaptive_images_async_blur === 'on' && ! $no_blur ) {
		$adaptive_async_class .= ' async-blurred';
	}

	return $adaptive_async_class;
}

/**
 * Get adaptive async data
 */
function uncode_get_adaptive_async_data( $id, $media_attributes, $orig_w, $orig_h, $single_w, $single_h, $crop, $fixed = null ) {
	$adaptive_async_data = ' data-uniqueid="' . $id . '-' . uncode_big_rand() . '" data-guid="' . ( is_array( $media_attributes->guid ) ? $media_attributes->guid['url'] : $media_attributes->guid ) . '" data-path="' . $media_attributes->path . '" data-width="' . $orig_w . '" data-height="' . $orig_h . '" data-singlew="' . $single_w . '" data-singleh="' . $single_h . '" data-crop="' . $crop . '"';

	if ( isset( $fixed ) ) {
		$adaptive_async_data .= 'data-fixed="' . $fixed . '"';
	}

	return $adaptive_async_data;
}
