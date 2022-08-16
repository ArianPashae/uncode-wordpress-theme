<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$el_id = $el_class = $inline = $text_lead = '';
extract(shortcode_atts(array(
	'el_id' => '',
	'el_class' => '',
	'text_lead' => '',
	'inline' => ''
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$post_type = uncode_get_current_post_type();
if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) {
	global $product;
	if ( ! $product ) {
		$product = uncode_populate_post_object();
	}
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-single-product-meta', $this->settings['base'], $atts );

$classes = array( $css_class );
$classes[] = trim( $this->getExtraClass( $el_class ) );

$post_type = uncode_get_current_post_type();
if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) {
	$classes[] = 'woocommerce';
}

if ($text_lead === 'yes') {
	$vc_text_lead = 'text-lead';
} else if ($text_lead === 'small') {
	$vc_text_lead = 'text-small';
} else {
	$vc_text_lead = '';
}

if ( $inline == 'yes' ) {
	$classes[] = 'inline-meta';
}

$output = '<div class="uncode-wrapper '.esc_attr( trim( implode( ' ', $classes ) ) ).'" '.$el_id . '>';
	$templ_arr = array(
		'vc_shortcode' => true,
		'vc_text_lead' => $vc_text_lead,
		'vc_inline_meta' => $inline,
	);
	ob_start();
	wc_get_template( 'single-product/meta.php', $templ_arr );
	$output .= ob_get_clean();
$output .= '</div>';

echo uncode_remove_p_tag($output);
