<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php

	global $limit_content_width, $page_custom_width, $show_body_title, $product, $metabox_data;

	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		ob_start();
		echo get_the_password_form();
		$the_content = ob_get_clean();
		echo uncode_get_row_template($the_content, ' limit-width', '', ot_get_option('_uncode_general_style'), '', 'quad', true, 'quad', 'style="max-width:801px; margin: auto"');
		return;
	}

	$_uncode_thumb_layout = ot_get_option('_uncode_product_image_layout');
	$_uncode_thumb_layout = get_post_meta($post->ID, '_uncode_product_image_layout', 1) !== '' ? get_post_meta($post->ID, '_uncode_product_image_layout', 1) : $_uncode_thumb_layout;

	$sticky_col = ot_get_option('_uncode_product_sticky_desc');
	$sticky_col = get_post_meta($post->ID, '_uncode_product_sticky_desc', 1) !== '' ? get_post_meta($post->ID, '_uncode_product_sticky_desc', 1) : $sticky_col;

	$col_size = ot_get_option('_uncode_product_media_size') == '' ? 6 : ot_get_option('_uncode_product_media_size');
	$col_size = ( get_post_meta($post->ID, '_uncode_product_media_size', 1) !== '' && get_post_meta($post->ID, '_uncode_product_media_size', 1) != 0 ) ? get_post_meta($post->ID, '_uncode_product_media_size', 1) : $col_size;

	$col_class = $_uncode_thumb_layout === 'stack' && $sticky_col === 'on' ? ' sticky-element sticky-sidebar' : '';

?>

<?php
	global $is_cb;
	$product_cb = $is_cb = uncode_get_content_cb();
	$show_content = true;

	if ( $product_cb ) {

		$show_content = false;

		$product_cb = apply_filters( 'wpml_object_id', $product_cb, 'post', true );
		$product_cb_post_content = get_post_field('post_content', $product_cb);

		$cb_edit_link = vc_frontend_editor()->getInlineUrl( '', $product_cb );

		// Check if we have a content block created with VC
		$has_vc_row = strpos( $product_cb_post_content, '[vc_row' ) !== false ? true : false;

		$product_cb_content = '';

		$product_cb_content .= $product_cb_post_content;

		$product_cb_content = preg_replace('#\s(unlock_row)="([^"]+)"#', ' unlock_row="yes"', $product_cb_content);
		$product_cb_content = preg_replace('#\s(unlock_row_content)="([^"]+)"#', ' unlock_row_content="yes"', $product_cb_content);
		$product_cb_counter = substr_count($product_cb_content, 'unlock_row_content');

		if ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) {

			$product_cb_content .= '<div class="vc_controls-element vc_controls vc_controls-content_block"><div
				class="vc_controls-cc"><a
					class="vc_control-btn vc_element-name vc_control-btn-edit" data-control="edit" href="' . esc_url( $cb_edit_link ) . '" target="_blank" title="' . esc_html__( 'Edit Content Block', 'uncode' ) . '"><span class="vc_btn-content">' . esc_html__( 'Product Content Block', 'uncode' ) . '<span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-mode_edit"></i></span></span></a></div></div>';

		}

		echo uncode_remove_p_tag($product_cb_content);

		do_action( 'uncode_woocommerce_after_single_product_builder' );

		$is_cb = false;

	}

	if ( ( ot_get_option('_uncode_product_select_content') === 'none' && ( !isset($metabox_data['_uncode_specific_select_content'][0]) || $metabox_data['_uncode_specific_select_content'][0] === '' )
		|| ( isset($metabox_data['_uncode_specific_select_content'][0]) && $metabox_data['_uncode_specific_select_content'][0] == 'none' ) ) ) {
		$show_content = false;
	}

	if ( ( ot_get_option('_uncode_product_select_content') === 'description' && ( !isset($metabox_data['_uncode_specific_select_content'][0]) || $metabox_data['_uncode_specific_select_content'][0] === '' )
		|| ( isset($metabox_data['_uncode_specific_select_content'][0]) && $metabox_data['_uncode_specific_select_content'][0] == 'description' ) ) ) {
		$show_content = false;
		global $limit_content_width;
		$description_content = uncode_get_the_content();
		if (has_shortcode($description_content, 'vc_row')) {
			echo apply_filters('the_content', $description_content);
		} else {
			echo uncode_get_row_template( apply_filters('the_content', $description_content), '', $limit_content_width, '', '', false, true, true, $page_custom_width );
		}
	}

	if ( $show_content ) {
?>
<div <?php function_exists('wc_product_class') ? wc_product_class( '', $product ) : post_class(); ?>>
	<div class="row-container">
		<div class="row row-parent col-std-gutter double-top-padding double-bottom-padding <?php echo esc_attr($limit_content_width); ?>" <?php echo wp_kses_post( $page_custom_width ); ?>>
			<div class="row-inner">
				<div class="col-lg-<?php echo intval($col_size); ?>">
					<div class="uncol">
						<div class="uncoltable">
							<div class="uncell">
								<div class="uncont">
									<?php
									do_action( 'woocommerce_before_single_product_summary' );
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-<?php echo ( 12 - intval($col_size) ); ?>">
					<div class="uncol<?php echo esc_attr($col_class); ?>">
						<div class="uncoltable">
							<div class="uncell">
								<div class="uncont">
									<?php
									if ($show_body_title === false) {
										uncode_woocommerce_hide_product_title();
									}
									do_action( 'woocommerce_single_product_summary' );
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	global $limit_content_width;
	ob_start();
	woocommerce_output_product_data_tabs();
	woocommerce_upsell_display();
	$the_content = ob_get_clean();
	echo uncode_get_row_template($the_content, '', '', '', '', false, false, false);

	$has_content_block_after = false;

	$page_content_block_after = (isset($metabox_data['_uncode_specific_content_block_after'][0])) ? $metabox_data['_uncode_specific_content_block_after'][0] : '';

	if ($page_content_block_after === '') {
		$generic_content_block_after = ot_get_option('_uncode_product_content_block_after');
		$content_block_after = $generic_content_block_after !== '' ? $generic_content_block_after : false;
		$has_content_block_after = $content_block_after !== false && $content_block_after !== 'none' ? true : false;
	} else {
		$content_block_after = $page_content_block_after;
		$has_content_block_after = $content_block_after !== 'none' && $content_block_after !== 'default' ? true : false;
	}

	$content_block_after = $content_block_after === null ? false : $content_block_after;

	ob_start();

	if ( ! $has_content_block_after && $content_block_after !== 'none' && apply_filters( 'uncode_show_woocommerce_related_products', true ) ) {
		woocommerce_output_related_products();
	}

	/**
	 * woocommerce_after_single_product_summary hook.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );

	$the_content = ob_get_clean();

	if ( ! $has_content_block_after && $content_block_after !== 'none' ) {
		echo uncode_get_row_template($the_content, '', $limit_content_width, '', ' row-related', false, true, true, $page_custom_width);
	}

} else {
	do_action( 'woocommerce_after_single_product_summary' );
}

do_action( 'woocommerce_after_single_product' );
?>
