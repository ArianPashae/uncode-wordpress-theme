<?php
global $product, $is_cb;

$output = $el_id = $el_class = $css = $border_color = $border_style = $text_lead = $el_style = $css_animation = $animation_delay = $animation_speed = $auto_text = $custom_inline_css = '';

extract(shortcode_atts(array(
	'uncode_shortcode_id' => '',
	'el_id' => '',
	'el_class' => '',
	'text_lead' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
	'parallax_intensity' => '',
	'parallax_centered' => '',
	'css' => '',
	'border_color' => '',
	'border_color_type' => '',
	'border_color_solid' => '',
	'border_style' => '',
	'auto_text' => '',
	'text_color' => '',
	'text_color_type' => '',
	'text_color_solid' => '',
	'text_color_gradient' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode_text_column' . $el_class . vc_shortcode_custom_css_class($css, ' ') , $this->settings['base'], $atts);

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'vc_column_text',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'text_color'            => $text_color,
		'text_color_type'       => $text_color_type,
		'text_color_solid'      => $text_color_solid,
		'text_color_gradient'   => $text_color_gradient,
		'border_color'          => $border_color,
		'border_color_type'     => $border_color_type,
		'border_color_solid'    => $border_color_solid,
		'border_color_gradient' => false,
	)
) );

$text_color = uncode_get_shortcode_color_attribute_value( 'text_color', $uncode_shortcode_id, $text_color_type, $text_color, $text_color_solid, $text_color_gradient );
$border_color = uncode_get_shortcode_color_attribute_value( 'border_color', $uncode_shortcode_id, $border_color_type, $border_color, $border_color_solid, false );

if ($border_color !== '') {
    $css_class .= ' border-' . $border_color . '-color';
    if ($border_style !== '') {
    	$el_style = 'border-style: ' . $border_style . ';';
    }
}

if ( $css ) {
	$custom_inline_css = uncode_get_custom_inline_css( $css );
}

if ( $custom_inline_css ) {
	$el_style .= $custom_inline_css;
}

if ($el_style !== '') {
	$el_style = ' style="' . esc_attr( $el_style ) . '"';
}

if ($text_lead === 'yes') {
	$css_class .= ' text-lead';
} else if ($text_lead === 'small') {
	$css_class .= ' text-small';
}

if ($text_color !== '') {
	$css_class .= ' text-' . $text_color . '-color';
}

$div_data = array();
if ($css_animation !== '') {
	if ( $css_animation === 'parallax' ) {
		$css_class .= ' parallax-el';
		$div_data = array_merge( $div_data, uncode_get_parallax_div_data( $parallax_intensity, $parallax_centered ) );
	} else {
		$css_class .= ' ' . $css_animation . ' animate_when_almost_visible';
		if ($animation_delay !== '') {
			$div_data['data-delay'] = $animation_delay;
		}
		if ($animation_speed !== '') {
			$div_data['data-speed'] = $animation_speed;
		}
	}
}

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

$output.= '<div class="' . esc_attr(trim($css_class)) . '" '.implode(' ', $div_data_attributes) . $el_style . $el_id . '>';
$post_type = uncode_get_current_post_type();
if ( $auto_text === 'excerpt' && $post_type != 'uncodeblock' ) {
	$the_excerpt = uncode_custom_dynamic_heading_in_content('subtitle');
	if ( ! $is_cb && $product ) {
		$the_excerpt = apply_filters( 'woocommerce_short_description', $the_excerpt );
	}
	$content = $the_excerpt;
} elseif ( $auto_text === 'content' && $post_type != 'uncodeblock' && $is_cb ) {
	$content = apply_filters( 'the_content', get_the_content());
}

$output.= uncode_the_content($content);
$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );
$output.= '</div>';

echo uncode_switch_stock_string( $output );
