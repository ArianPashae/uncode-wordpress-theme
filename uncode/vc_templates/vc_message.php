<?php

$output = $message_color = $el_id = $el_class = $css_animation = $animation_delay = $animation_speed = '';
extract(shortcode_atts(array(
	'uncode_shortcode_id' => '',
	'message_color' => '',
	'message_color_type' => '',
	'message_color_solid' => '',
	'message_color_gradient' => '',
	'el_id' => '',
	'el_class' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
), $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$el_class = $this->getExtraClass($el_class);

$class = "";
$div_data = array();

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'vc_message',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'message_color'          => $message_color,
		'message_color_type'     => $message_color_type,
		'message_color_solid'    => $message_color_solid,
		'message_color_gradient' => $message_color_gradient,
	)
) );

$message_color = uncode_get_shortcode_color_attribute_value( 'message_color', $uncode_shortcode_id, $message_color_type, $message_color, $message_color_solid, $message_color_gradient );

$message_color = ( $message_color !== '') ? ' style-'.$message_color . '-bg' : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_content_element' . $class . $el_class, $this->settings['base'], $atts );

if ($css_animation !== '') {
	$css_class .= 'animate_when_almost_visible ' . $css_animation;
	if ($animation_delay !== '') {
		$div_data['data-delay'] = $animation_delay;
	}
	if ($animation_speed !== '') {
		$div_data['data-speed'] = $animation_speed;
	}
}

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

?>
<div class="<?php echo esc_attr($css_class); ?>" <?php echo implode(' ', $div_data_attributes); ?> <?php echo uncode_switch_stock_string( $el_id ); ?>>
	<div class="messagebox_text<?php echo esc_attr($message_color); ?>"><?php echo uncode_remove_p_tag($content, true); ?></div>
	<?php echo uncode_print_dynamic_colors_inline_style( $inline_style_css ); ?>
</div>
