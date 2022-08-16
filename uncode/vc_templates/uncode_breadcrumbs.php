<?php
$el_id = $el_class = $text_lead = $separator = $wc_breadcrumbs = $desktop_visibility = $medium_visibility = $mobile_visibility = $css_animation = $animation_delay = $animation_speed = $navigation_index = '';
extract(shortcode_atts(array(
	'text_lead' => '',
	'separator' => 'slash',
	'wc_breadcrumbs' => '',
	'desktop_visibility' => '',
	'medium_visibility' => '',
	'mobile_visibility' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
	'el_id' => '',
	'el_class' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$classes = array();
$classes[] = 'uncode_breadcrumbs_wrap';
$classes[] = trim($this->getExtraClass( $el_class ));

if ($separator !== '') {
	$classes[] = 'bc-separator-' . $separator . '';
}

if ( $text_lead === 'yes' ) {
	$classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$classes[] = 'module-text-small';
}

if ($desktop_visibility === 'yes') {
	$classes[] = 'desktop-hidden';
}
if ($medium_visibility === 'yes') {
	$classes[] = 'tablet-hidden';
}
if ($mobile_visibility === 'yes') {
	$classes[] = 'mobile-hidden';
}

$div_data = array();
if ($css_animation !== '') {
	$classes[] = $css_animation . ' animate_when_almost_visible';
	if ($animation_delay !== '') {
		$div_data['data-delay'] = $animation_delay;
	}
	if ($animation_speed !== '') {
		$div_data['data-speed'] = $animation_speed;
	}
}

$post_type = uncode_get_current_post_type();
if (isset($metabox_data['_uncode_specific_navigation_index'][0]) && $metabox_data['_uncode_specific_navigation_index'][0] !== '') {
	$navigation_index = $metabox_data['_uncode_specific_navigation_index'][0];
} else {
	$navigation_index = ot_get_option('_uncode_' . $post_type . '_navigation_index');
}

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

if ( $wc_breadcrumbs === 'yes' && function_exists('woocommerce_breadcrumb') ) {
	$bc_args = array(
		'delimiter'   => false,
		'wrap_before' => '<div class="' . esc_attr(trim(implode( ' ', $classes ))) . '" '.implode(' ', $div_data_attributes). $el_id . '><ol class="breadcrumb breadcrumb-module">',
		'wrap_after'  => '</ol></div>',
		'before'      => '<li>',
		'after'       => '</li>',
	);
	woocommerce_breadcrumb($bc_args);
} else {
	echo '<div class="' . esc_attr(trim(implode( ' ', $classes ))) . '" '.implode(' ', $div_data_attributes). $el_id . '>';
	echo uncode_breadcrumbs( $navigation_index, 'module' );
	echo '</div>';
}
