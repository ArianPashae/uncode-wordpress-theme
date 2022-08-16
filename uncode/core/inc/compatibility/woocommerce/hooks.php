<?php
/**
 * WooCommerce hooks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Reviews
 */
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
remove_action( 'woocommerce_review_meta', array( 'WC_Structured_Data', 'generate_review_data' ), 20 );
remove_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );

/**
 * Content Wrappers.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', array( 'WC_Structured_Data', 'generate_website_data' ), 30 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Breadcrumbs.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Archive descriptions.
 */
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

/**
 * Products Loop.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found' );

/**
 * Pagination after shop loops.
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

/**
 * Sidebar.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Product Loop Items.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * Subcategories.
 */
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

/**
 * Single Product.
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Activate thumbs on review order.
 */
add_action( 'woocommerce_review_order_before_cart_contents', 'uncode_woocommerce_activate_thumbs_on_order_review_table' ); // Checkout
add_action( 'woocommerce_order_details_before_order_table_items', 'uncode_woocommerce_activate_thumbs_on_order_details_table' ); // Thank You (and My Account)
add_action( 'before_woocommerce_pay', 'uncode_woocommerce_activate_thumbs_on_order_details_table' ); // Pay Order

if ( function_exists( 'woocommerce_output_all_notices' ) ) :
	/**
	 * Reset notice.
	 */
	add_action( 'wp_footer', 'woocommerce_output_all_notices' );
endif;

/**
 * Default add to cart template for 3rd party product types.
 */
add_action( 'uncode_woocommerce_add_to_cart', 'woocommerce_template_single_add_to_cart' );

add_action( 'wp', 'uncode_woocommerce_get_filters' );
if ( ! function_exists( 'uncode_woocommerce_get_filters' ) ) :
/**
 * Manages hooks in product builder.
 * @since Uncode 2.3.0
 */
function uncode_woocommerce_get_filters(){
	global $post;
	$product_header = uncode_get_product_header_cb();

	if ( $product_header ) {
		$header_cb = get_post($product_header);
		if ( is_object($header_cb) ) {
			$content_header = $header_cb->post_content;
			uncode_woocommerce_remove_product_summary_hooks( $content_header );
		}
	}

	$is_cb = uncode_get_content_cb();

	if ( $is_cb ) {
		$object_cb = get_post($is_cb);
		if ( is_object($object_cb) ) {
			$content_cb = $object_cb->post_content;
			uncode_woocommerce_remove_product_summary_hooks( $content_cb );
		}

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}
}
endif;

/**
 * Don't print inline terms page content if it has VC shortcodes.
 */
function uncode_woocommerce_disable_inline_terms_page_content() {
	$terms_page_id = wc_terms_and_conditions_page_id();

	if ( ! $terms_page_id ) {
		return;
	}

	$page = get_post( $terms_page_id );

	if (strpos( $page->post_content, 'vc_row') !== false) {
		remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
	}
}
add_action( 'woocommerce_checkout_before_terms_and_conditions', 'uncode_woocommerce_disable_inline_terms_page_content' );

/**
 * Print product structured data when using the page builder
 */
function uncode_woocommerce_product_structured_data_after_page_builder() {
	if ( apply_filters('uncode_woocommerce_print_product_structured_data_after_page_builder', true) ) {
		WC()->structured_data->generate_product_data();
	}
}
add_action( 'uncode_woocommerce_after_single_product_builder', 'uncode_woocommerce_product_structured_data_after_page_builder' );

/**
 * Remove product summary hooks when using dynamic modules
 */
function uncode_woocommerce_remove_product_summary_hooks( $content ) {
	preg_match_all( '/\[vc_custom_heading (.*?)auto_text=(.*?)\]/', $content, $heading_sh );
	if ( ! empty( $heading_sh[0] ) ) {
		foreach ( $heading_sh[0] as $heading_key => $heading_value ) {
			preg_match_all( '/auto_text=\"(.*?)\"/',$heading_value,$auto_txt );
			if ( $auto_txt[1][0] === 'yes' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			} elseif ( $auto_txt[1][0] === 'excerpt' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			} elseif ( $auto_txt[1][0] === 'price' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			}
		}
	}

	preg_match_all( '/\[vc_column_text (.*?)auto_text=(.*?)\]/', $content, $text_sh );
	if ( ! empty( $text_sh[0] ) ) {
		foreach ( $text_sh[0] as $text_key => $text_value ) {
			preg_match_all( '/auto_text=\"(.*?)\"/',$text_value,$text_val );
			if ( $text_val[1][0] === 'excerpt' || $text_val[1][0] === 'content' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
		}
	}

	preg_match_all( '/\[vc_button (.*?)dynamic=(.*?)\]/', $content, $button_sh );
	if ( ! empty( $button_sh[0] ) ) {
		foreach ( $button_sh[0] as $button_key => $button_value ) {
			preg_match_all( '/dynamic=\"(.*?)\"/',$button_value,$button_val );
			if ( $button_val[1][0] === 'add-to-cart' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
		}
	}

	preg_match_all( '/\[uncode_single_product_rating/', $content, $rating_sh );
	if ( ! empty( $rating_sh[0] ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	}

	preg_match_all( '/\[uncode_single_product_meta/', $content, $meta_sh );
	if ( ! empty( $meta_sh[0] ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	}

	preg_match_all( '/\[uncode_share/', $content, $share_sh );
	if ( ! empty( $share_sh[0] ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	}

	preg_match_all( '/\[uncode_woocommerce_wishlist/', $content, $share_sh );
	if ( ! empty( $share_sh[0] ) ) {
		remove_action( 'woocommerce_single_product_summary', 'uncode_add_wishlist_button_to_single_product', 32 );
	}
}

/**
 * Manage srcset in single product
 */
function uncode_single_product_manage_srcset( $attr ) {
	global $adaptive_images;
	if ( is_product() && $adaptive_images === 'on' ) {
	    if( isset( $attr['sizes'] ) )
	        unset( $attr['sizes'] );

	    if( isset( $attr['srcset'] ) )
	        unset( $attr['srcset'] );
	}

    return $attr;

 }
add_filter( 'wp_get_attachment_image_attributes', 'uncode_single_product_manage_srcset', 10 );
