<?php
/**
 * WooCommerce filters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Change number or products per row to 3
 */
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}
add_filter('loop_shop_columns', 'loop_columns');

/**
 * Filter WC HTML price
 */
function uncode_price_html( $price, $product ){
	$price = str_replace( '<span class="amount">', '<span>', $price );
	if ( apply_filters( 'uncode_woocommerce_price_custom_heading', true ) ) {
		$price = '<ins class="h2">'.$price.'</ins>';
	}
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'uncode_price_html', 10, 2 );

/**
 * Filter WC HTML price (from to)
 */
function uncode_price_html_from_to($price, $from, $to, $instance) {
	$price = '<ins>' . ( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) . '</ins> <del>' . ( ( is_numeric( $from ) ) ? wc_price( $from ) : $from ) . '</del>';
	return $price;
}
add_filter( 'woocommerce_get_price_html_from_to', 'uncode_price_html_from_to', 10, 4 );

/**
 * Filter order button
 */
function uncode_woocommerce_order_button_html( $button ) {
	$button = str_replace('class="button', 'class="btn checkout-button btn-default btn-hidden', $button);
	return $button;
}
add_filter( 'woocommerce_order_button_html', 'uncode_woocommerce_order_button_html', 10, 1 );
add_filter( 'woocommerce_pay_order_button_html', 'uncode_woocommerce_order_button_html', 10, 1 );

/**
 * Add wrapper to received text
 */
function uncode_woocommerce_thankyou_order_received_text( $text ) {
	return '<span class="thank-you">' . $text . '</span>';
}
add_filter( 'woocommerce_thankyou_order_received_text', 'uncode_woocommerce_thankyou_order_received_text', 10, 1 );

/**
 * Add special class to submit reviews button
 */
function uncode_alter_woocommerce_comment_form_fields($fields){
	$fields['class_submit'] = 'submit btn btn-default';
	return $fields;
}
add_filter('woocommerce_product_review_comment_form_args','uncode_alter_woocommerce_comment_form_fields');

/**
 * Filter related products query
 */
function uncode_output_related_products_args( $args ) {
	$args['columns'] = 4;
	$args['posts_per_page'] = 12;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'uncode_output_related_products_args');

/**
 * Pass correct uai image to variation's thumb
 */
function uncode_woocommerce_available_variation( $variations ) {
	global $wpdb, $adaptive_images, $col_size_gl, $woocommerce_loop, $uncode_vc_index;

	$shop_single = wc_get_image_size( 'shop_single' );
	$crop = false;
	if ( is_array( $col_size_gl ) ) {
		$col_size = $col_size_gl['single_width'];
		$height_size = $col_size_gl['single_height'];
		$crop = $col_size_gl['crop'];
	} else {
		$col_size = ot_get_option('_uncode_product_media_size') == '' ? 6 : ot_get_option('_uncode_product_media_size');
		$height_size = null;
		if (isset($shop_single['crop']) && $shop_single['crop'] === 1) {
			$crop = true;
			$thumb_ratio = $shop_single['width'] / $shop_single['height'];
			$height_size = $col_size / $thumb_ratio;
		}
	}
	$th_shop_thumbnail = wc_get_image_size( 'shop_thumbnail' );
	$th_crop = false;
	if (isset($th_shop_thumbnail['crop']) && $th_shop_thumbnail['crop'] === 1) {
		$th_crop = true;
		$small_ratio = $th_shop_thumbnail['width'] / $th_shop_thumbnail['height'];
	}
	$get_media_url = (isset($variations['image_link'])) ? $variations['image_link'] : $variations['image']['url'];
	if (isset($get_media_url) && $get_media_url !== '') {
		$variations['image_link'] = $get_media_url;
		//$the_media = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid LIKE '%s'", '%'. $wpdb->esc_like( basename( $get_media_url ) ) . '%') );
		//$get_media_id = (isset($the_media->ID)) ? $the_media->ID : $the_media->id;
		$get_media_id = $variations['image_id'];
		if (isset($get_media_id) && $get_media_id !== '') {
			$image_attributes = uncode_get_media_info($get_media_id);
			$image_metavalues = unserialize($image_attributes->metadata);
			if ($image_attributes->post_mime_type === 'image/gif' || $image_attributes->post_mime_type === 'image/url') {
				$crop = false;
			}
			$image_resized = uncode_resize_image($image_attributes->id, $image_attributes->guid, $image_attributes->path, $image_metavalues['width'], $image_metavalues['height'], $col_size, $height_size, $crop);
			$variations['image_src'] = $image_resized['url'];
			$variations['image']['thumb_src'] = $image_resized['url'];
			$variations['image']['thumb_src_w'] = $col_size;
			$variations['image']['thumb_src_h'] = $height_size;
			if ( $adaptive_images === 'on' ) {
				$variations['uncode_image_path'] = $image_attributes->path;
				$variations['uncode_image_guid'] = $image_attributes->guid;
				$variations['data_uniqueid'] = $get_media_id.'-'.uncode_big_rand();
				$variations['data_width'] = $image_metavalues['width'];
				$variations['data_height'] = $image_metavalues['height'];
			} else {
				if ( function_exists('uncode_calc_img_srcset') ) {
					$img_src = wp_get_attachment_image_src( $get_media_id, 'woocommerce_gallery_thumbnail' );
					$img_url = $img_src ? $img_src[0] : false;
					$srcset_point = array(
						absint( $img_src[1] ),
						absint( $img_src[2] ),
					);
					$img_data = wp_get_attachment_metadata( $get_media_id );

					if ( isset($woocommerce_loop['name']) && $woocommerce_loop['name'] == 'related' || $uncode_vc_index || is_post_type_archive('product') ) {
						$variations['image']['thumb_srcset'] = '';
					} else {
						$variations['thumb_srcset'] = uncode_calc_img_srcset( $srcset_point, $img_url, $img_data, $get_media_id );
					}
				}
			}
			$small_image_resized = uncode_resize_image($image_attributes->id, $image_attributes->guid, $image_attributes->path, $image_metavalues['width'], $image_metavalues['height'], 2, ($th_crop ? 2 / $small_ratio : null), $th_crop);
			$variations['gallery_thumbnail_src'] = $small_image_resized['url'];
			$variations['image']['gallery_thumbnail_src'] = $small_image_resized['url'];
			$variations['image']['gallery_thumbnail_src_w'] = $small_image_resized['width'];
			$variations['image']['gallery_thumbnail_src_h'] = $small_image_resized['height'];
		}
	}
	$variations['image_srcset'] = $variations['image_sizes'] = '';
	return $variations;
}
add_filter( 'woocommerce_available_variation', 'uncode_woocommerce_available_variation', 101, 3 );

/**
 * Enable thumb zoom on demand
 */
if ( ! function_exists( 'uncode_woocommerce_single_product_zoom_enabled' ) ) :
	/**
	 * @since Uncode 1.6.0
	 */
	function uncode_woocommerce_single_product_zoom_enabled($return) {
		global $post;

		if ( !current_theme_supports( 'wc-product-gallery-zoom' ) ) {
			return false;
		}

		if ( ot_get_option('_uncode_product_enable_zoom') != 'on' ) {
			$return = false;
		}

		if ( !$post ) {
		    return $return;
		}

		$product_enable_zoom_meta = get_post_meta($post->ID, '_uncode_product_enable_zoom', 1);

		if ( $product_enable_zoom_meta === 'off' ) {
			$return = false;
		} elseif ( $product_enable_zoom_meta === 'on' ) {
			$return = true;
		}

		$product_cb = uncode_get_content_cb();

		if ( $product_cb ) {
			$object_cb = get_post($product_cb);
			if ( is_object($object_cb) ) {
				$content_cb = $object_cb->post_content;
				preg_match_all( '/\[uncode_single_product_gallery (.*?)\]/', $content_cb, $gallery_cb );
				if ( !empty($gallery_cb[0]) ) {
					preg_match_all('/zoom=\"yes\"/',$gallery_cb[0][0],$zoom_cb);
					if ( !empty($zoom_cb[0]) && $zoom_cb[0] !== '' ) {
						$return = false;
					} else {
						$return = true;
					}
				}
			}
		}

		$product_header = uncode_get_product_header_cb();

		if ( $product_header ) {
			$object_cb = get_post($product_header);
			if ( is_object($object_cb) ) {
				$content_cb = $object_cb->post_content;
				preg_match_all( '/\[uncode_single_product_gallery (.*?)\]/', $content_cb, $gallery_cb );
				if ( !empty($gallery_cb[0]) ) {
					preg_match_all('/zoom=\"yes\"/',$gallery_cb[0][0],$zoom_cb);
					if ( !empty($zoom_cb[0]) && $zoom_cb[0] !== '' ) {
						$return = false;
					} else {
						$return = true;
					}
				}
			}
		}

		$content = $post->post_content;

		if ( $content ) {
			preg_match_all( '/\[uncode_single_product_gallery (.*?)\]/', $content, $gallery );
			if ( !empty($gallery[0]) ) {
				preg_match_all('/zoom=\"yes\"/',$gallery[0][0],$zoom);
				if ( !empty($zoom[0]) && $zoom[0] !== '' ) {
					$return = false;
				} else {
					$return = true;
				}
			}
		}

	    return $return;
	}
endif;//uncode_woocommerce_single_product_zoom_enabled
add_filter( 'woocommerce_single_product_zoom_enabled', 'uncode_woocommerce_single_product_zoom_enabled' );

/**
 * Enable single product slider on demand
 */
if ( ! function_exists( 'uncode_woocommerce_single_product_slider_enabled' ) ) :
	/**
	 * @since Uncode 1.6.0
	 */
	function uncode_woocommerce_single_product_slider_enabled($return) {
		global $post;

		if ( !current_theme_supports( 'wc-product-gallery-slider' ) ) {
			return false;
		}

		if ( ot_get_option('_uncode_product_enable_slider') != 'on' ) {
			$return = false;
		}

		if ( !$post ) {
		    return $return;
		}

		$product_enable_slider_meta = get_post_meta($post->ID, '_uncode_product_enable_slider', 1);
		$product_enable_stack_meta = get_post_meta($post->ID, '_uncode_product_image_layout', 1);

		if ( $product_enable_slider_meta === 'off' ) {
			$return = false;
		} elseif ( $product_enable_slider_meta === 'on' ) {
			$return = true;
		}

		if ( ( ot_get_option('_uncode_product_image_layout') === 'stack' && $product_enable_stack_meta !== 'std' ) || $product_enable_stack_meta === 'stack' ) {
			$return = false;
		}

		$product_cb = uncode_get_content_cb();

		if ( $product_cb ) {
			$object_cb = get_post($product_cb);
			if ( is_object($object_cb) ) {
				$content_cb = $object_cb->post_content;
				preg_match_all( '/\[uncode_single_product_gallery (.*?)\]/', $content_cb, $gallery_cb );
				if ( !empty($gallery_cb[0]) ) {
					preg_match_all('/(layout=\"stack\"|carousel=\"yes\")/',$gallery_cb[0][0],$layout_cb);
					if ( !empty($layout_cb[0]) ) {
						$return = false;
					} else {
						$return = true;
					}
				}
			}
		}

		$product_header = uncode_get_product_header_cb();

		if ( $product_header ) {
			$object_cb = get_post($product_header);
			if ( is_object($object_cb) ) {
				$content_cb = $object_cb->post_content;
				preg_match_all( '/\[uncode_single_product_gallery (.*?)\]/', $content_cb, $gallery_cb );
				if ( !empty($gallery_cb[0]) ) {
					preg_match_all('/(layout=\"stack\"|carousel=\"yes\")/',$gallery_cb[0][0],$layout_cb);
					if ( !empty($layout_cb[0]) ) {
						$return = false;
					} else {
						$return = true;
					}
				}
			}
		}

	    return $return;
	}
endif;//uncode_woocommerce_single_product_slider_enabled

add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false' );

/**
 * Change number of products per page
 */
if ( ! function_exists( 'uncode_wc_shop_per_page' ) ) :
	/**
	 * @since Uncode 1.8.0
	 */
	function uncode_wc_shop_per_page() {
		$cols = get_option('posts_per_page');
		$def = ot_get_option('_uncode_product_index_ppp');
		if ( $def !== '0' ) {
			$cols = intval($def);
		}
		return $cols;
	}
endif;//uncode_wc_shop_per_page
add_filter( 'loop_shop_per_page', 'uncode_wc_shop_per_page', 20 );

/**
 * Add special class to add to cart buttons
 */
function uncode_filter_wc_loop_add_to_cart_args( $args, $product ) {
	$args['class'] .= ' alt btn btn-default';
	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'uncode_filter_wc_loop_add_to_cart_args', 10, 2 );

/**
 * Filter srcset size
 */
if ( ! function_exists( 'uncode_max_srcset_image_width' ) ) :
/**
 * @since Uncode 1.9.3
 */
function uncode_max_srcset_image_width() {
	$sizes = false;
	if ( function_exists('is_product') && is_product() ) {
		global $post, $limit_content_width, $metabox_data;
		$main_width = ot_get_option('_uncode_main_width');
		if ( isset($metabox_data['_uncode_specific_main_width_inherit'][0]) && $metabox_data['_uncode_specific_main_width_inherit'][0] != ''
			&&
			isset($metabox_data['_uncode_specific_main_width'][0]) && isset($metabox_data['_uncode_specific_main_width_inherit'][0])) {
			$main_width = unserialize($metabox_data['_uncode_specific_main_width'][0]);
		}
		if ((isset($main_width[0]) && $main_width[0] !== '') && (isset($main_width[1]) && $main_width[1] === 'px')) {
			$main_width = $main_width[0];
		} else {
			$main_width = false;
		}

		$col_size = ot_get_option('_uncode_product_media_size') == '' ? 6 : ot_get_option('_uncode_product_media_size');
		$col_size = ( get_post_meta($post->ID, '_uncode_product_media_size', 1) !== '' && get_post_meta($post->ID, '_uncode_product_media_size', 1) != 0 ) ? get_post_meta($post->ID, '_uncode_product_media_size', 1) : $col_size;

		if ( !$main_width || $limit_content_width === '' ) {
			$main_width = 2700;
		}

		$max_width = ( $main_width / 12 ) * $col_size;
	    $sizes = '(max-width: ' . $max_width . 'px) 100vw, ' . $max_width . 'px';
	}
	return $sizes;
}
endif;//uncode_max_srcset_image_width

/**
 * Pass custom srcset size
 */
if ( ! function_exists( 'uncode_get_attachment_image_attributes' ) ) :
	/**
	 * @since Uncode 1.9.3
	 */
	function uncode_get_attachment_image_attributes( $attr ) {
		$sizes = uncode_max_srcset_image_width();
		if ( $sizes !== false && $sizes !== '' ) {
			$attr['sizes'] = $sizes;
		}
		return $attr;
	}
endif;//uncode_get_attachment_image_attributes
//add_filter( 'wp_get_attachment_image_attributes', 'uncode_get_attachment_image_attributes' );

/**
 * Pass custom srcset size to variations
 */
if ( ! function_exists( 'uncode_woocommerce_available_variation_img_sizes' ) ) :
	/**
	 * @since Uncode 1.9.3
	 */
	function uncode_woocommerce_available_variation_img_sizes( $data, $product, $variation ) {
		$sizes = uncode_max_srcset_image_width();
		if ( $sizes !== false && $sizes !== '' ) {
			$data['image']['sizes'] = $sizes;
		}
		return $data;
	}
endif;//uncode_woocommerce_available_variation_img_sizes
add_filter( 'woocommerce_available_variation', 'uncode_woocommerce_available_variation_img_sizes', 10, 3 );

/**
 * Add custom wrapper to sale badge
 */
if ( ! function_exists( 'uncode_woocommerce_sale_flash' ) ) :
	/**
	 * @since Uncode 2.0.0
	 */
	function uncode_woocommerce_sale_flash($content, $post, $product){
	   $content = '<span class="font-ui">' . $content . '</span>';
	   return $content;
	}
endif;//uncode_woocommerce_sale_flash
add_filter('woocommerce_sale_flash', 'uncode_woocommerce_sale_flash', 10, 3);

/**
 * Add placeholders to WC fields (when missing)
 */
if ( ! function_exists( 'uncode_woocommerce_form_field_args' ) ) :
	function uncode_woocommerce_form_field_args( $args, $key, $value ) {
		if ( isset( $args[ 'label' ] ) &&  isset( $args[ 'type' ] ) ) {
			if ( $args[ 'type' ] === 'country' ) {
				$placeholder = array(
					'placeholder' => $args[ 'label' ]
				);

				if ( isset( $args[ 'custom_attributes' ] ) ) {
					$custom_attributes = $args[ 'custom_attributes' ];
					$args[ 'custom_attributes' ] = array_merge( $custom_attributes, $placeholder );
				} else {
					$args[ 'custom_attributes' ] = $placeholder;
				}
			}

			if ( isset( $args[ 'placeholder' ] ) ) {
				if ( $args[ 'label' ] && $args[ 'placeholder' ] === '' ) {
					switch ( $args[ 'type' ] ) {
						case 'text':
						case 'textarea':
						case 'tel':
						case 'email':
						case 'state':
						case 'country':
							$args[ 'placeholder' ] = $args[ 'label' ];
							break;
					}
				}
			}
		}

		return $args;
	}
endif;

/**
 * Add placeholders to WC fields (when missing) via custom filters
 */
function uncode_woocommerce_get_form_field_placeholder( $id ) {
	$placeholder = '';

	if ( ! apply_filters( 'uncode_woocommerce_activate_placeholders_on_inputs', false ) ) {
		return $placeholder;
	}

	switch ( $id ) {
		case 'username':
			$placeholder = __( 'Username', 'woocommerce' );
			break;

		case 'username-email':
			$placeholder = __( 'Username or email', 'woocommerce' );
			break;

		case 'password':
			$placeholder = __( 'Password', 'woocommerce' );
			break;

		case 'email':
			$placeholder = __( 'Email address', 'woocommerce' );
			break;

		case 'new-password':
			$placeholder = __( 'New password', 'woocommerce' );
			break;

		case 're-new-password':
			$placeholder = __( 'Re-enter new password', 'woocommerce' );
			break;

		case 'firstname':
			$placeholder = __( 'First name', 'woocommerce' );
			break;

		case 'lastname':
			$placeholder = __( 'Last name', 'woocommerce' );
			break;

		case 'display-name':
			$placeholder = __( 'Display name', 'woocommerce' );
			break;

		case 'edit-current-password':
			$placeholder = __( 'Current password (leave blank to leave unchanged)', 'woocommerce' );
			break;

		case 'edit-new-password':
			$placeholder = __( 'New password (leave blank to leave unchanged)', 'woocommerce' );
			break;

		case 'edit-confirm-password':
			$placeholder = __( 'Confirm new password', 'woocommerce' );
			break;
	}

	return $placeholder;
}

/**
 * Activate placeholders on demand
 */
function uncode_woocommerce_activate_placeholders_on_inputs() {
	add_filter( 'woocommerce_form_field_args', 'uncode_woocommerce_form_field_args', 10, 3 );
	add_filter( 'uncode_woocommerce_activate_placeholders_on_inputs', '__return_true' );
}

/**
 * Activate thumbs on order review table
 */
function uncode_woocommerce_activate_thumbs_on_order_review_table() {
	add_filter( 'woocommerce_cart_item_name', 'uncode_woocommerce_print_thumbs_on_order_review_table', 10, 3 );
	add_action( 'uncode_after_cart_item_data', 'uncode_close_product_item_text' );
	add_filter( 'woocommerce_cart_item_thumbnail', 'uncode_review_order_additional_quantity_badge', 10, 3 );
}

/**
 * Activate thumbs on order details table
 */
function uncode_woocommerce_activate_thumbs_on_order_details_table() {
	add_filter( 'woocommerce_order_item_name', 'uncode_woocommerce_print_thumbs_on_order_details_table', 10, 3 );
}

/**
 * Print the product thumb on order review table
 */
function uncode_woocommerce_print_thumbs_on_order_review_table( $name, $cart_item, $cart_item_key ) {
	$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
	$html      = $thumbnail . '<div class="product-item-text">' . $name;

	return $html;
}

/**
 * Print the product thumb on order details table
 */
function uncode_woocommerce_print_thumbs_on_order_details_table( $name, $item, $is_visible ) {
	$product   = $item->get_product();
	$thumbnail = $product->get_image();
	$html      = $thumbnail . $name;

	return $html;
}

/**
 * Print the quantity in relative position for Review Order
 */
function uncode_review_order_additional_quantity_badge( $thumbnail, $cart_item, $cart_item_key ) {
	return '<div class="product-item-thumb">' . $thumbnail . apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Close the additional div for FlexBox on Review Order
 */
function uncode_close_product_item_text() {
	echo '</div>';
}

/**
 * Change number of cross sells columns
 */
function uncode_woocommerce_cross_sells_columns( $columns ) {
	return 4;
}
add_filter( 'woocommerce_cross_sells_columns', 'uncode_woocommerce_cross_sells_columns' );

/**
 * Change limit of cross sells loop
 */
function uncode_woocommerce_cross_sells_total( $limit ) {
	return 4;
}
add_filter( 'woocommerce_cross_sells_total', 'uncode_woocommerce_cross_sells_total' );

/**
 * Wrap the "x" in product quantity with a span element
 */
function uncode_woocommerce_checkout_cart_item_quantity( $html, $cart_item, $cart_item_key ) {
	return ' <strong class="product-quantity"><span>&times;&nbsp;</span>' . sprintf( '%s', $cart_item['quantity'] ) . '</strong>';
}
add_filter( 'woocommerce_checkout_cart_item_quantity', 'uncode_woocommerce_checkout_cart_item_quantity', 10, 3 );


function uncode_woocommerce_order_item_quantity_html( $html ) {
	$html = str_replace( '&times;&nbsp;', '<span>&times;&nbsp;</span>', $html );

	return $html;
}
add_filter( 'woocommerce_order_item_quantity_html', 'uncode_woocommerce_order_item_quantity_html' );

if (!function_exists('uncode_product_additional_information_placeholder')) :
function uncode_product_additional_information_placeholder(){
?>
	<table class="woocommerce-product-attributes shop_attributes">
		<tbody>
			<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--placeholder">
				<th class="woocommerce-product-attributes-item__label"><?php esc_html_e( 'Placeholders', 'uncode' ); ?></th>
				<td class="woocommerce-product-attributes-item__value"><?php esc_html_e( 'All these entries are placeholders.', 'uncode' ); ?></td>
			</tr>
			<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--placeholder">
				<th class="woocommerce-product-attributes-item__label"><?php esc_html_e( 'Weight', 'uncode' ); ?></th>
				<td class="woocommerce-product-attributes-item__value"><?php esc_html_e( '25.00', 'uncode' ); ?></td>
			</tr>c
			<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--placeholder">
				<th class="woocommerce-product-attributes-item__label"><?php esc_html_e( 'Size', 'uncode' ); ?></th>
				<td class="woocommerce-product-attributes-item__value"><?php esc_html_e( '79 x 55 x 176', 'uncode' ); ?></td>
			</tr>
			<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--placeholder">
				<th class="woocommerce-product-attributes-item__label"><?php esc_html_e( 'Color', 'uncode' ); ?></th>
				<td class="woocommerce-product-attributes-item__value"><?php esc_html_e( 'Brown, Black', 'uncode' ); ?></td>
			</tr>
		</tbody>
	</table>
<?php
}
endif;

add_filter( 'woocommerce_product_tabs', 'uncode_woocommerce_product_tabs' );
function uncode_woocommerce_product_tabs( $tabs ) {
	global $product;

	if ( comments_open() ) {
		$show_count_class = $product->get_review_count() > 0 ? '' : ' hidden';
		$tabs['reviews'] = array(
			'title'    => __( 'Reviews', 'uncode' ) . sprintf( ' <span class="review-count' . $show_count_class . '">%d</span>', $product->get_review_count() ),
			'priority' => 30,
			'callback' => 'comments_template',
		);
	}

	return $tabs;
}

/**
 * Add a DIV to break display inline in some cases
 * @since Uncode 2.3.0
 */
if (!function_exists('uncode_wc_review_display_block')) :
	function uncode_wc_review_display_block(){
		echo '<div class="block-between"></div>';
	}
endif;
add_action( 'woocommerce_review_meta', 'uncode_wc_review_display_block', 11 );

/**
 * Add small class to add to add to cart button on demand
 */
function uncode_filter_add_to_cart_button_args( $args ) {
	$args['class'] .= ' btn-sm';

	return $args;
}

/**
 * When using dynamic headings, set the default title for
 * the thank you page and the pay for order page
 */
function uncode_woocommerce_dynamic_endpoint_titles( $title, $auto_text ) {
	if ( $auto_text ) {
		global $wp;

		// Pay order and thank you page
		if ( ! empty( $wp->query_vars['order-pay'] ) || isset( $wp->query_vars['order-received'] ) ) {
			$title = get_the_title();
		}
	}

	return $title;
}
add_filter( 'uncode_vc_custom_heading_content', 'uncode_woocommerce_dynamic_endpoint_titles', 10, 2 );
