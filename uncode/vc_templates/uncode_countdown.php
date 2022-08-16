<?php
$title = $el_id = $el_class = $date = $font = $weight = $height = $size = $separator = $transform = $text = $icon = $output = $css_animation = $animation_delay = $animation_speed = '';
extract(shortcode_atts(array(
	'title' => '',
	'el_id' => '',
	'el_class' => '',
	'date' => '',
	'font' => '',
	'weight' => '',
	'height' => '',
	'size' => 'h2',
	'separator' => '',
	'transform' => '',
	'text' => '',
	'icon' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-countdown', $this->settings['base'], $atts );
$container_classes = array( $css_class );
$container_classes[] = trim( $this->getExtraClass( $el_class ) );

$classes = array();
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

if ($font !== '') {
	$classes[] = $font;
}
if ($size !== '') {
	$classes[] = $size;
}
if ($weight !== '') {
	$classes[] = 'font-weight-' . $weight;
}
if ($height !== '') {
	$classes[] = $height;
}
if ($transform !== '') {
	$classes[] = 'text-' . $transform;
}

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

$output .= '<div class="uncode-wrapper '.esc_attr( trim( implode( ' ', $container_classes ) ) ).'" '.implode(' ', $div_data_attributes). $el_id .'>';
$output .= '<p>';
$output .= '<span class="countdown '.esc_attr(trim(implode(' ', $classes))).'" data-uncode-countdown="'.esc_attr($date).'">000 '.esc_html__('days','uncode').' 00 '.esc_html__('hours','uncode').' 00 '.esc_html__('minutes','uncode').' 00 '.esc_html__('seconds','uncode').'</span>';
$output .= '</p>';
if ($separator === 'yes') {
	$output .= '<hr class="separator-break separator-accent" />';
}
if ($text !== '') {
	$output .= '<div class="counter-text"><p>'.$text.'</p></div>';
}
$output .= '</div>';

echo uncode_remove_p_tag($output);
