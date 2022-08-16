<?php
/**
 * SRCSET images related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get srcset image class.
 */
function uncode_get_srcset_async_class( $options = array() ) {
	$class   = ' ';
	$classes = array( 'srcset-async', 'srcset-auto' );

	if ( is_array( $options ) ) {
		if ( isset( $options['is_isotope'] ) && $options['is_isotope'] ) {
			$classes[] = 'srcset-on-layout';
		} else if ( isset( $options['is_carousel'] ) && $options['is_carousel'] ) {
			$classes[] = 'srcset-on-layout';
		} else if ( isset( $options['is_justified'] ) && $options['is_justified'] ) {
			$classes[] = 'srcset-on-layout';
		}
	}

	$class .= implode( ' ', $classes );

	return $class;
}

/**
 * Get srcset background class.
 */
function uncode_get_srcset_bg_async_class( $async_data = array() ) {
	$class   = ' ';
	$classes = array( 'srcset-bg' );

	if ( isset( $async_data['do_replace'] ) && $async_data['do_replace'] ) {
		$classes[] = 'srcset-bg-async';
	} else if ( isset( $async_data['string'] ) && $async_data['string'] ) {
		$classes[] = 'srcset-bg-generate-img';
	}

	$class .= implode( ' ', $classes );

	return $class;
}

/**
 * Get srcset image data.
 */
function uncode_get_srcset_async_data( $block_data, $src_sizes, $id, $media_attributes, $resized_image, $orig_w, $orig_h, $single_w, $single_h, $crop, $fixed = null ) {
	$resized_w           = isset( $resized_image['width'] ) ? $resized_image['width'] : $orig_w;
	$resized_h           = isset( $resized_image['height'] ) ? $resized_image['height'] : $orig_h;
	$srcset              = wp_get_attachment_image_srcset( $id, array( $resized_w, $resized_h ) );
	$missing_breakpoints = uncode_get_srcset_missing_breakpoints( $src_sizes, $srcset, $resized_w );

	// Build srcset attribute
	$srcset_attr            = $srcset ? sprintf( ' data-srcset="%s"', esc_attr( $srcset ) ) : '';
	$srcset_placeholder_img = uncode_get_srcset_placeholder_svg( $resized_w, $resized_h );
	$srcset_placeholder     = $srcset ? sprintf( ' srcset="%s"', $srcset_placeholder_img ) : '';

	// Enable lazy loading
	$loading_attr = uncode_dynamic_srcset_lazy_loading_enabled() ? 'lazy' : '';

	// Disable lazy on justified galleries
	if ( is_array( $block_data ) && isset( $block_data['block_gallery_type'] ) && $block_data['block_gallery_type'] === 'justified' ) {
		$loading_attr = '';
	}

	// Data
	$async_data = array(
		'no_bp'              => $missing_breakpoints,
		'bp'                 => $src_sizes,
		'uniqueid'           => $id . '-' . uncode_big_rand(),
		'guid'               => is_array( $media_attributes->guid ) ? $media_attributes->guid['url'] : $media_attributes->guid,
		'path'               => $media_attributes->path,
		'width'              => $orig_w,
		'height'             => $orig_h,
		'singlew'            => $single_w,
		'singleh'            => $single_h,
		'crop'               => $crop,
		'loading'            => $loading_attr,
		'srcset'             => $srcset,
		'srcset_placeholder' => $srcset_placeholder_img,
	);

	// Append webp data
	$srcset_webp = false;

	if ( isset( $block_data['activate_webp'] ) && $block_data['activate_webp'] ) {
		if ( $media_attributes->post_mime_type === 'image/jpeg' || $media_attributes->post_mime_type === 'image/png' ) {
			$mime = str_replace( 'image/', '', $media_attributes->post_mime_type );

			if ( $mime === 'jpeg' ) {
				$srcset_webp = str_replace( '.jpeg', '.webp', $srcset );
				$srcset_webp = str_replace( '.jpg', '.webp', $srcset );
			} else {
				$srcset_webp = str_replace( '.png', '.webp', $srcset );
			}

			$srcset_webp = apply_filters( 'uncode_webp_path_string', $srcset_webp, $mime );

			$async_data['mime']        = $mime;
			$async_data['srcset_webp'] = $srcset_webp;
		}
	}

	// Build complete string
	$srcset_data_string                  = uncode_get_async_srcset_data_string( $async_data );
	$async_data['string_without_srcset'] = $srcset_data_string;
	$async_data['string']                = $srcset_data_string . $srcset_attr . $srcset_placeholder;

	if ( $srcset_webp ) {
		$async_data['string'] .= ' data-srcset-webp="' . esc_attr( $srcset_webp ) . '"';
	}

	return $async_data;
}

/**
 * Get srcset background data.
 */
function uncode_get_srcset_bg_async_data( $dynamic_srcset_bg_mobile_size, $media_attributes, $resized_image, $orig_w, $orig_h, $bg_data ) {
	// Data
	$async_data = array(
		'do_replace' => false
	);

	// Build data attribute
	if ( isset( $resized_image['url'] ) && $dynamic_srcset_bg_mobile_size > 0 && $orig_w > $dynamic_srcset_bg_mobile_size ) {
		$media_id  = $media_attributes->id;
		$thumbnail = uncode_get_attachment_image_src( $media_id, array( $dynamic_srcset_bg_mobile_size, 0 ) );

		if ( is_array( $thumbnail ) && isset( $thumbnail[0] ) && $thumbnail[0] ) {
			// Thumb found
			$async_data['background-image']        = apply_filters( 'wp_get_attachment_url', $resized_image['url'], $media_id );
			$async_data['mobile-background-image'] = apply_filters( 'uncode_url_for_resize', $thumbnail[0] );
			$async_data['do_replace']              = true;

			if ( isset( $bg_data ) && isset( $bg_data['activate_webp'] ) && $bg_data['activate_webp'] ) {
				if ( $media_attributes->post_mime_type === 'image/jpeg' || $media_attributes->post_mime_type === 'image/png' ) {
					$mime = str_replace( 'image/', '', $media_attributes->post_mime_type );

					$async_data['mime'] = $mime;

					if ( $mime === 'jpeg' ) {
						$bg_webp = str_replace( '.jpeg', '.webp', $async_data['background-image'] );
						$bg_webp = str_replace( '.jpg', '.webp', $async_data['background-image'] );
						$mobile_bg_webp = str_replace( '.jpeg', '.webp', $async_data['mobile-background-image'] );
						$mobile_bg_webp = str_replace( '.jpg', '.webp', $async_data['mobile-background-image'] );
					} else {
						$bg_webp = str_replace( '.png', '.webp', $async_data['background-image'] );
						$mobile_bg_webp = str_replace( '.png', '.webp', $async_data['mobile-background-image'] );
					}

					$bg_webp        = apply_filters( 'uncode_webp_path_string', $bg_webp, $mime );
					$mobile_bg_webp = apply_filters( 'uncode_webp_path_string', $mobile_bg_webp, $mime );

					$async_data['background-image-webp']        = $bg_webp;
					$async_data['mobile-background-image-webp'] = $mobile_bg_webp;
				}
			}
		} else {
			// Append data for the async resize
			$async_data['uniqueid'] = $media_id . '-' . uncode_big_rand();
			$async_data['guid']     = is_array( $media_attributes->guid ) ? $media_attributes->guid['url'] : $media_attributes->guid;
			$async_data['path']     = $media_attributes->path;
			$async_data['width']    = $orig_w;
			$async_data['height']   = $orig_h;
		}
	}

	// Build complete string
	$srcset_data_string = uncode_get_async_bg_data_string( $async_data );
	$async_data['string'] = $srcset_data_string;

	return $async_data;
}

/**
 * Build img async data string from configuration.
 */
function uncode_get_async_srcset_data_string( $async_data ) {
	$srcset_data_string = ' data-no-bp="' . implode( ',', $async_data['no_bp'] ) . '" data-bp="' . implode( ',', $async_data['bp'] ) . '" data-uniqueid="' . $async_data['uniqueid'] . '" data-guid="' . $async_data['guid'] . '" data-path="' . $async_data['path'] . '" data-width="' . $async_data['width'] . '" data-height="' . $async_data['height'] . '" data-singlew="' . $async_data['singlew'] . '" data-singleh="' . $async_data['singleh'] . '" data-crop="' . $async_data['crop'] . '" loading="' . $async_data['loading'] . '"';

	if ( isset( $async_data['mime'] ) ) {
		$srcset_data_string .= ' data-mime="' . $async_data['mime'] . '"';
	}

	return $srcset_data_string;
}

/**
 * Build bg async data string from configuration.
 */
function uncode_get_async_bg_data_string( $async_data ) {
	$async_data_string = '';

	if ( isset( $async_data['background-image'] ) && $async_data['background-image'] ) {
		$async_data_string .= ' data-background-image="' . $async_data['background-image'] . '"';
	}

	if ( isset( $async_data['mobile-background-image'] ) && $async_data['mobile-background-image'] ) {
		$async_data_string .= ' data-mobile-background-image="' . $async_data['mobile-background-image'] . '"';
	}

	if ( isset( $async_data['uniqueid'] ) && $async_data['uniqueid'] ) {
		$async_data_string .= ' data-uniqueid="' . $async_data['uniqueid'] . '"';
	}

	if ( isset( $async_data['guid'] ) && $async_data['guid'] ) {
		$async_data_string .= ' data-guid="' . $async_data['guid'] . '"';
	}

	if ( isset( $async_data['path'] ) && $async_data['path'] ) {
		$async_data_string .= ' data-path="' . $async_data['path'] . '"';
	}

	if ( isset( $async_data['width'] ) && $async_data['width'] ) {
		$async_data_string .= ' data-width="' . $async_data['width'] . '"';
	}

	if ( isset( $async_data['height'] ) && $async_data['height'] ) {
		$async_data_string .= ' data-height="' . $async_data['height'] . '"';
	}

	if ( isset( $async_data['mime'] ) && $async_data['mime'] ) {
		$async_data_string .= ' data-mime="' . $async_data['mime'] . '"';
	}

	if ( isset( $async_data['background-image-webp'] ) && $async_data['background-image-webp'] ) {
		$async_data_string .= ' data-background-image-webp="' . $async_data['background-image-webp'] . '"';
	}

	if ( isset( $async_data['mobile-background-image-webp'] ) && $async_data['mobile-background-image-webp'] ) {
		$async_data_string .= ' data-mobile-background-image-webp="' . $async_data['mobile-background-image-webp'] . '"';
	}

	return $async_data_string;
}

/**
 * Enable native lazy loading when dynamic_srcset_is_active.
 */
function uncode_dynamic_srcset_lazy_loading_enabled() {
	return apply_filters( 'uncode_dynamic_srcset_lazy_loading_enabled', true );
}

/**
 * Get picture HTML.
 */
function uncode_get_picture_html( $post_id, $id, $src, $alt, $width, $height, $class, $async_data ) {
	ob_start();

	$async_data_string      = isset( $async_data[ 'string_without_srcset' ] ) ? $async_data[ 'string_without_srcset' ] : '';
	$srcset                 = isset( $async_data[ 'srcset' ] ) ? $async_data[ 'srcset' ] : '';
	$srcset_webp            = isset( $async_data[ 'srcset_webp' ] ) ? $async_data[ 'srcset_webp' ] : '';
	$srcset_placeholder_img = isset( $async_data[ 'srcset_placeholder' ] ) ? $async_data[ 'srcset_placeholder' ] : '';
	$loading_attr           = isset( $async_data[ 'loading' ] ) ? $async_data[ 'loading' ] : '';
	?>
	<picture class="<?php echo esc_attr( $class ); ?> uncode-picture-element" <?php echo uncode_switch_stock_string( $async_data_string ); ?>>
		<?php do_action( 'uncode_picture_before_source', $id, array( $width, $height ), $post_id ); ?>

		<?php if ( $srcset ) : ?>
			<source class="uncode-picture-source" data-srcset="<?php echo esc_attr( $srcset ); ?>" srcset="<?php echo esc_attr( $srcset_placeholder_img ); ?>" <?php echo uncode_switch_stock_string( $srcset_webp ) ? 'data-srcset-webp="' . esc_attr( $srcset_webp ) . '"' : ''; ?>>
		<?php endif; ?>

		<?php do_action( 'uncode_picture_after_source', $id, array( $width, $height ), $post_id ); ?>

		<img class="uncode-picture-image" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>" loading="<?php echo esc_attr( $loading_attr ); ?>" />
	</picture>
	<?php
	$picture_cover = ob_get_clean();
	$picture_cover = apply_filters( 'uncode_metro_picture_thumbnail_html', $picture_cover, $id, array( $width, $height ), $post_id );

	return $picture_cover;
}

/**
 * Generate a transparent (encoded) SVG.
 */
function uncode_get_srcset_placeholder_svg( $width, $height ) {
	if ( function_exists( 'uncode_core_get_srcset_placeholder_svg' ) ) {
		$svg = uncode_core_get_srcset_placeholder_svg( $width, $height );
	} else {
		$svg = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg4MCIgaGVpZ2h0PSIxOTIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0wIDBoMXYxSDB6IiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=';
	}

	return $svg;
}

/**
 * Find missing breakpoints from the srcset value.
 */
function uncode_get_srcset_missing_breakpoints( $breakpoints, $srcset, $target_w ) {
	$missing_breakpoints = array();

	if ( is_array( $breakpoints ) ) {
		foreach ( $breakpoints as $breakpoint ) {
			if ( $breakpoint > $target_w ) {
				continue;
			}

			if ( strpos( $srcset, $breakpoint . 'w' ) === false ) {
				$missing_breakpoints[] = $breakpoint;
			}
		}
	}

	$missing_breakpoints = apply_filters( 'uncode_get_srcset_missing_breakpoints', $missing_breakpoints, $breakpoints, $srcset );

	return $missing_breakpoints;
}

/**
 * Async code that regenerates the missing srcset sizes.
 */
function uncode_regenerate_srcset_async() {
	if ( isset( $_POST[ 'nonce_srcset_async' ] ) ) {
		// Check nonce if enabled
		if ( apply_filters( 'uncode_enable_nonce_adaptive_images', false ) && ! wp_verify_nonce( $_POST[ 'nonce_srcset_async' ], 'uncode-nonce_srcset-async-nonce' ) ) {
			// Invalid nonce
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Invalid nonce.', 'uncode' )
				)
			);
		}

		$posted_images  = isset( $_POST[ 'images' ] ) ? $_POST[ 'images' ] : array();
		$resize_quality = isset( $_POST[ 'resize_quality' ] ) ? $_POST[ 'resize_quality' ] : 90;

		$async_data = array(
			'resize_quality'    => $resize_quality,
			'register_metadata' => true
		);

		// Sanitize data
		$posted_images = uncode_sanitize_adaptive_async_data( $posted_images );

		// Hold possible errors during generation
		$regeneration_errors = array();

		// Hold processed images ID
		$processed_images = array();

		// Loop through images
		foreach ( $posted_images as $posted_image ) {
			$breakpoints_to_regenerate = array();

			if ( isset( $posted_image['missingbp'] ) && $posted_image['missingbp'] ) {
				$breakpoints = explode( ',', $posted_image['missingbp'] );

				foreach ( $breakpoints as $breakpoint ) {
					$media_id = explode( '-', $posted_image[ 'unique' ] );
					$media_id = $media_id[ 0 ];

					// Pass breakpoint value
					$async_data['async_srcset_size'] = absint( $breakpoint );

					// Resize image
					$resized = uncode_resize_image( $media_id, $posted_image[ 'url' ], $posted_image[ 'path' ], $posted_image[ 'origwidth' ], $posted_image[ 'origheight' ], $posted_image[ 'singlew' ], $posted_image[ 'singleh' ], $posted_image[ 'crop' ], $posted_image[ 'fixed' ], true, $async_data );

					// Save error for later
					if ( isset( $resized['error'] ) ) {
						$regeneration_errors[] = $resized['error'];
					} else {
						$processed_images[] = array(
							'id'       => $media_id,
							'new_crop' => isset( $resized['new_crop'] ) && $resized['new_crop'] ? true : false,
							'unique'   => $posted_image[ 'unique' ]
						);
					}
				}
			}
		}

		$response = array(
			'images' => $processed_images,
			'errors' => $regeneration_errors
		);

	    wp_send_json_success($response);

	} else {
		// Invalid data
		wp_send_json_error(
			array(
				'message' => esc_html__( 'Empty data.', 'uncode' )
			)
		);
	}
}
add_action( 'wp_ajax_regenerate_srcset_async', 'uncode_regenerate_srcset_async' );
add_action( 'wp_ajax_nopriv_regenerate_srcset_async', 'uncode_regenerate_srcset_async' );

/**
 * Async code that regenerates the mobile version of BGs.
 */
function uncode_regenerate_srcset_bg_async() {
	if ( isset( $_POST[ 'nonce_srcset_async' ] ) ) {
		// Check nonce if enabled
		if ( apply_filters( 'uncode_enable_nonce_adaptive_images', false ) && ! wp_verify_nonce( $_POST[ 'nonce_srcset_async' ], 'uncode-nonce_srcset-async-nonce' ) ) {
			// Invalid nonce
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Invalid nonce.', 'uncode' )
				)
			);
		}

		$posted_images  = isset( $_POST[ 'images' ] ) ? $_POST[ 'images' ] : array();
		$resize_quality = isset( $_POST[ 'resize_quality' ] ) ? $_POST[ 'resize_quality' ] : 90;
		$mobile_size    = isset( $_POST[ 'mobile_size' ] ) ? absint( $_POST[ 'mobile_size' ] ) : false;

		if ( ! ( $mobile_size > 0 ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Invalid mobile breakpoint size.', 'uncode' )
				)
			);
		}

		$async_data = array(
			'resize_quality'    => $resize_quality,
			'register_metadata' => true,
			'async_srcset_size' => $mobile_size
		);

		// Sanitize data
		$posted_images = uncode_sanitize_adaptive_async_data( $posted_images );

		// Hold possible errors during generation
		$regeneration_errors = array();

		// Hold processed images ID
		$processed_images = array();

		// Loop through images
		foreach ( $posted_images as $posted_image ) {
			$media_id = explode( '-', $posted_image[ 'unique' ] );
			$media_id = $media_id[0];

			// Resize image
			$resized = uncode_resize_image( $media_id, $posted_image[ 'url' ], $posted_image[ 'path' ], $posted_image[ 'origwidth' ], $posted_image[ 'origheight' ], 12, null, false, null, true, $async_data );

			// Save error for later
			if ( isset( $resized['error'] ) ) {
				$regeneration_errors[] = $resized['error'];
			} else {
				$processed_images[] = array(
					'id'       => $media_id,
					'new_crop' => isset( $resized['new_crop'] ) && $resized['new_crop'] ? true : false,
					'unique'   => $posted_image[ 'unique' ]
				);
			}
		}

		$response = array(
			'images' => $processed_images,
			'errors' => $regeneration_errors
		);

	    wp_send_json_success($response);

	} else {
		// Invalid data
		wp_send_json_error(
			array(
				'message' => esc_html__( 'Empty data.', 'uncode' )
			)
		);
	}
}
add_action( 'wp_ajax_regenerate_srcset_bg_async', 'uncode_regenerate_srcset_bg_async' );
add_action( 'wp_ajax_nopriv_regenerate_srcset_bg_async', 'uncode_regenerate_srcset_bg_async' );
