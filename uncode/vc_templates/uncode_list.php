<?php
$el_id = $el_class = $larger = $icon = $icon_color = $css_animation = $animation_delay = $animation_speed = $ul_class = $output = '';
extract(shortcode_atts(array(
	'uncode_shortcode_id' => '',
	'el_id' => '',
	'el_class' => '',
	'larger' => '',
	'icon' => '',
	'icon_color' => '',
	'icon_color_type' => '',
	'icon_color_solid' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'uncode_list',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'icon_color'          => $icon_color,
		'icon_color_type'     => $icon_color_type,
		'icon_color_solid'    => $icon_color_solid,
		'icon_color_gradient' => false,
	)
) );

$icon_color = uncode_get_shortcode_color_attribute_value( 'icon_color', $uncode_shortcode_id, $icon_color_type, $icon_color, $icon_color_solid, false );

if ($icon !== '') {
	$icon = '<i class="'.esc_attr($icon).(($icon_color !== '') ? ' text-' . esc_attr( $icon_color ) .'-color' : '').'"></i>';
	$content = preg_replace('/<li>/', '<li>' . $icon, $content);
	$ul_class .= 'icons';
}

if ($larger === 'yes') {
	$ul_class .= ' text-lead';
} else if ($larger === 'small') {
	$ul_class .= ' text-small';
}

if ($ul_class !== '') {
	$content = preg_replace('/<ul>/', '<ul class="'.esc_attr( $ul_class ).'">', $content, 1);
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-list', $this->settings['base'], $atts );
$classes = array( $css_class );
$classes[] = trim( $this->getExtraClass( $el_class ) );

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

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

$output .= '<div class="uncode-wrapper ' . esc_attr( trim( implode( ' ', $classes ) ) ) . '" ' . implode( ' ', $div_data_attributes ) . $el_id . '>';
$output .= $content;
$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );
$output .= '</div>';

$output = preg_replace('/<p[^>]*><\/div>/', '</div>', $output);
$output = preg_replace('/<div (.*?)><\/p>/', '<div $1>', $output);

echo uncode_remove_p_tag($output);
