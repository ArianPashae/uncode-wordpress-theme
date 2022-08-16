<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$layout = $lightbox = $zoom = $zoom_mobile = $columns = $carousel = $el_id = $el_class = $gutter_thumb = $gutter_thumb_2 = $images_size = $data_gutter = $gutter_size = $inner_padding = $nav = $dots_inside = $product_badges = $css_animation = $animation_delay = $animation_speed = $div_data = '';
extract(shortcode_atts(array(
	'layout' => '',
	'lightbox' => '',
	'zoom' => '',//filtered with preg_match_all() in uncode/core/inc/compatibility/woocommerce/filters.php
	'zoom_mobile' => '',
	'columns' => '',
	'carousel' => '',//filtered with preg_match_all() in uncode/core/inc/compatibility/woocommerce/filters.php
	'el_id' => '',
	'el_class' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
	'gutter_thumb' => '2',
	'gutter_thumb_2' => '2',
	'gutter_size' => '3',
	'inner_padding' => '',
	'nav' => 'thumbs',
	'dots_inside' => '',
	'images_size' => '',
	'product_badges' => 'yes',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-single-product-gallery', $this->settings['base'], $atts );

if ($css_animation !== '') {
	$css_class .= ' animate_when_almost_visible ' . $css_animation;
	if ($animation_delay !== '') {
		$div_data .= ' data-delay="' . esc_attr( $animation_delay ) . '"';
	}
	if ($animation_speed !== '') {
		$div_data .= ' data-speed="' . esc_attr( $animation_speed ) . '"';
	}
}

$classes = array( $css_class );
$classes[] = trim( $this->getExtraClass( $el_class ) );

if ( $inner_padding !== '' ) {
	$classes[] = 'inner-padding';
}

switch ($gutter_thumb_2) {
	case 0:
		$vc_padding = 'no-th-padding';
		break;
	case 1:
		$vc_padding = 'one-th-padding';
		break;
	case 3:
		$vc_padding = 'single-th-padding';
		break;
	case 4:
		$vc_padding = 'double-th-padding';
		break;
	case 2:
	default:
		$vc_padding = 'half-th-padding';
		break;
}

switch ($gutter_thumb) {
	case 0:
		$classes[] = 'no-dots-gutter';
		$data_gutter = '0';
		break;
	case 1:
		$classes[] = 'one-dots-gutter';
		$data_gutter = '1';
		break;
	case 3:
		$classes[] = 'single-dots-gutter';
		$data_gutter = '18';
		break;
	case 4:
		$classes[] = 'double-dots-gutter';
		$data_gutter = '36';
		break;
	case 2:
	default:
		$classes[] = 'half-dots-gutter';
		$data_gutter = '9';
		break;
}

switch ($gutter_size) {
	case 0:
		$vc_margin = 'no-bottom-margin';
		break;
	case 1:
		$vc_margin = 'one-bottom-margin';
		break;
	case 2:
		$vc_margin = 'half-bottom-margin';
		break;
	case 4:
		$vc_margin = 'double-bottom-margin';
		break;
	case 5:
		$vc_margin = 'triple-bottom-margin';
		break;
	case 6:
		$vc_margin = 'quad-bottom-margin';
		break;
	case 3:
	default:
		$vc_margin = 'single-bottom-margin';
		break;
}

if ( $nav === 'dots' ) {
	if ( $dots_inside == 'yes' ) {
		$classes[] = 'owl-dots-inside';
	} else {
		$classes[] = 'owl-dots-outside';
	}
}

$post_type = uncode_get_current_post_type();
if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) {
	$classes[] = 'woocommerce';
}

if ( $zoom != 'yes' && $zoom_mobile == 'yes' ) {
	$classes[] = 'no-zoom-mobile';
}

$output .= '<div class="uncode-wrapper '.esc_attr( trim( implode( ' ', $classes ) ) ).'" '.$el_id . ' data-gutter="' . esc_attr($data_gutter) . '" data-dots="' . esc_attr( $nav == 'dots' ? 'true' : 'false' ) . '"' . $div_data . '>';
	$images_arr = array(
		'vc_thumb_layout' => $layout,
		'vc_columns' => $columns,
		'vc_nav' => $nav,
		'vc_lightbox' => $lightbox,
		'vc_ratio' => $images_size,
		'vc_padding' => $vc_padding,
	);
	if ( $layout == 'stack' ) {
		$images_arr['vc_margin'] = $vc_margin;
	}
	ob_start();
	if ( $product_badges == 'yes' ) {
		if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type !== 'product' ) {
			echo '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>';
		} else {
			woocommerce_show_product_sale_flash();
		}
	}
	wc_get_template( 'single-product/product-image.php', $images_arr );
	$output .= ob_get_clean();
$output .= '</div>';

echo uncode_remove_p_tag($output);
