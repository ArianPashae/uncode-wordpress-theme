<?php
/**
 * Image related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check if a size exists in the attachment meta and add it.
 */
function uncode_recheck_attachment_meta( $media_id, $width, $height, $url, $cropped_img_url ) {
	// Check meta only when the admin is logged in
	if ( ! ( current_user_can( 'administrator' ) && is_user_logged_in() ) ) {
		return;
	}

	// Return early via filter
	if ( apply_filters( 'uncode_skip_srcset_attachment_meta_check', false ) ) {
		return;
	}

	$meta         = wp_get_attachment_metadata( $media_id );
	$mime         = get_post_mime_type( $media_id );
	$file_info    = pathinfo( $url );
	$cropped_info = pathinfo( $cropped_img_url );

	$media_data_key = $file_info[ 'filename' ] . '-uai_' . $width . 'x' . $height . '.' . $file_info[ 'extension' ];
	$media_data_key = apply_filters( 'uncode_ai_meta_data_key_name', $media_data_key );

	if ( isset( $meta['sizes'] ) && isset( $meta['sizes'][$media_data_key] ) ) {
		return;
	}

	$meta['sizes'][$media_data_key] = array(
		'file'      => $cropped_info['basename'],
		'width'     => $width,
		'height'    => $height,
		'mime-type' => $mime,
	);

	wp_update_attachment_metadata( $media_id, $meta );
}

/**
 * Remove auto srcset attr added by WordPress.
 */
function uncode_remove_img_tag_add_srcset_and_sizes_attr() {
	return false;
}
