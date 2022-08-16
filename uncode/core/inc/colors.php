<?php

global $UNCODE_COLORS, $front_background_colors, $uncode_colors, $uncode_colors_flat, $uncode_colors_flat_array, $uncode_colors_w_transp;

function uncode_define_global_colors() {
	global $UNCODE_COLORS, $front_background_colors, $uncode_colors, $uncode_colors_flat, $uncode_colors_flat_array, $uncode_colors_w_transp;

	$UNCODE_COLORS = array(

		array(
			'value' => 'accent',
			'label' => esc_html__('Accent', 'uncode')
		) ,

	);

	$retrieve_options = get_option( ot_options_id() );
	$custom_colors_list = (isset($retrieve_options['_uncode_custom_colors_list'])) ? $retrieve_options['_uncode_custom_colors_list'] : '';

	if (isset($custom_colors_list) && is_array($custom_colors_list))
	{
		$single_array = array();
		foreach ($custom_colors_list as $key => $value)
		{
			$single_array['value'] = $value['_uncode_custom_color_unique_id'];
			$single_array['label'] = $value['title'];
			$single_array['mono'] = isset($value['_uncode_custom_color_regular']) ? $value['_uncode_custom_color_regular'] : '';
			$UNCODE_COLORS[] = $single_array;
		}
	}

	/**
	 * Build arrays for the backend
	 */

	$uncode_colors = array();
	$uncode_colors_flat = array();
	$uncode_colors_flat_array = array('accent');

	foreach ((array)$UNCODE_COLORS as $key => $value)
	{
		if (isset($value['disabled']) && $value['disabled'])
		{
			$uncode_color = array(
				'" disabled="disabled',
				$value['label']
			);
		}
		else
		{
			$uncode_color = array(
				$value['value'],
				$value['label']
			);
		}
		array_push($uncode_colors, $uncode_color);

		if ( isset($value['mono']) && $value['mono'] == 'on' ) {
			$uncode_colors_flat_array[] = $value['value'];
			$uncode_color_flat = $uncode_color;
			array_push($uncode_colors_flat, $uncode_color_flat);
		}

	}

	$uncode_colors_w_transp = array_merge(array(
		array(
			'transparent',
			'Transparent'
		)
	) , $uncode_colors);

	array_unshift($uncode_colors, array(
		'',
		esc_html__( 'Select…', 'uncode' )
	));

	array_unshift($uncode_colors_flat, array(
		'',
		esc_html__( 'Select…', 'uncode' )
	));

	array_unshift($uncode_colors_w_transp, array(
		'',
		esc_html__( 'Select…', 'uncode' )
	));

	/**
	 * Build array for the frontend
	 */

	$front_background_colors = array(
		'transparent' => 'transparent',
	);

	if (isset($custom_colors_list) && is_array($custom_colors_list))
	{
		foreach ($custom_colors_list as $key => $value)
		{
			if (isset($value['_uncode_custom_color_regular']) && $value['_uncode_custom_color_regular'] === 'off') {
				$value_gradient = json_decode($value['_uncode_custom_color_gradient']);
				if (isset($value_gradient->css)) {
					$front_background_colors[$value['_uncode_custom_color_unique_id']] = $value_gradient->css;
				} else {
					$front_background_colors[$value['_uncode_custom_color_unique_id']] = '';
				}
			} else $front_background_colors[$value['_uncode_custom_color_unique_id']] = $value['_uncode_custom_color'];
		}
	}

	if (isset($retrieve_options['_uncode_accent_color']) && $retrieve_options['_uncode_accent_color'] !== '')
	{
		$front_background_colors['accent'] = $front_background_colors[$retrieve_options['_uncode_accent_color']];
	}

}
add_action('init', 'uncode_define_global_colors');

/**
 * Print the CSS of a custom color
 */
function uncode_print_style_custom_colors_css( $key, $value, $value_rgb, $btn_outline ) {
	if ( strpos( $value, 'background' ) !== false ) {
		uncode_print_style_custom_gradient_color_css( $key, $value );
	} else {
		uncode_print_style_custom_solid_color_css( $key, $value, $value_rgb, $btn_outline );
	}
}

/**
 * Print the CSS of a custom solid color
 */
function uncode_print_style_custom_solid_color_css( $key, $value, $value_rgb, $btn_outline, $properties = array( 'bg', 'button', 'text', 'border', 'overlay' ) ) {
	// Background
	if ( is_array( $properties ) && in_array( 'bg', $properties ) ) {
		echo "\n" . '.style-' . $key . '-bg { background-color: ' . $value . '; }';
	}

	// Button
	if ( is_array( $properties ) && in_array( 'button', $properties ) ) {
		if ( function_exists('uncode_darken_color')) {
			$darken_value = uncode_darken_color( $value );
		} else {
			$darken_value = $value;
		}

		if ($key !== 'white') {
			echo "\n" . '.btn-' . $key . ' { color: #ffffff !important; background-color: ' . $value . ' !important; border-color: ' . $value . ' !important; }';
		} else {
			echo "\n" . '.btn-' . $key . ' { color: #1a1b1c !important; background-color: ' . $value . ' !important; border-color: ' . $value . ' !important; }';
		}
		echo "\n" . '.btn-' . $key . ':not(.btn-hover-nobg):not(.icon-animated):hover, .btn-' . $key . ':not(.btn-hover-nobg):not(.icon-animated):focus, .btn-' . $key . ':not(.btn-hover-nobg):not(.icon-animated):active { background-color: transparent !important; border-color: ' . $value . ' !important;}';
		echo "\n" . '.btn-' . $key . '.btn-flat:not(.btn-hover-nobg):hover, .btn-' . $key . '.btn-flat:not(.btn-hover-nobg):focus, .btn-' . $key . '.btn-flat:active { background-color: ' . $darken_value . ' !important; border-color: ' . $darken_value . ' !important;}';
		echo "\n" . '.btn-' . $key . ':not(.btn-flat):not(.btn-hover-nobg):not(.icon-animated):not(.btn-text-skin):hover, .btn-' . $key . ':not(.btn-flat):not(.btn-hover-nobg):not(.icon-animated):not(.btn-text-skin):focus, .btn-' . $key . ':not(.btn-flat):not(.btn-hover-nobg):not(.icon-animated):not(.btn-text-skin):active { color: ' . $value . ' !important; }';
		echo "\n" . '.btn-' . $key . '.btn-outline { background-color: transparent !important; border-color: ' . $value . ' !important; }';
		echo "\n" . '.btn-' . $key . '.btn-outline:not(.btn-text-skin) { color: ' . $value . ' !important; }';
		echo "\n" . '.btn-' . $key . '.btn-outline:not(.btn-hover-nobg):hover, .btn-' . $key . '.btn-outline:not(.btn-hover-nobg):focus, btn-' . $key . '.btn-outline:active { background-color: ' . $value . ' !important; border-color: ' . $value . ' !important; }';
		echo "\n" . '.btn-' . $key . '.btn-outline:not(.btn-hover-nobg):not(.btn-text-skin):not(.icon-animated):hover, .btn-' . $key . '.btn-outline:not(.btn-hover-nobg):not(.btn-text-skin):not(.icon-animated):focus, btn-' . $key . '.btn-outline:active { color: #ffffff !important; }';
		echo "\n" . '.style-light .btn-' . $key . '.btn-text-skin.btn-outline, .style-light .btn-' . $key . '.btn-text-skin:not(.btn-outline):hover, .style-light .btn-' . $key . '.btn-text-skin:not(.btn-outline):focus, .style-light .btn-' . $key . '.btn-text-skin:not(.btn-outline):active { color: ' . $btn_outline . ' !important; }';
		echo "\n" . '.style-light .btn-' . $key . '.btn-text-skin.btn-outline:hover, .style-light .btn-' . $key . '.btn-text-skin.btn-outline:focus, .style-light .btn-' . $key . '.btn-text-skin.btn-outline:active { color: #ffffff !important; }';
		echo "\n" . '.style-light .style-dark .btn-' . $key . '.btn-text-skin.btn-outline, .style-light .style-dark .btn-' . $key . '.btn-text-skin:not(.btn-outline):hover, .style-light .style-dark .btn-' . $key . '.btn-text-skin:not(.btn-outline):focus, .style-light .style-dark .btn-' . $key . '.btn-text-skin:not(.btn-outline):active { color: #ffffff !important; }';
		echo "\n" . '.style-light .style-dark .btn-' . $key . '.btn-text-skin.btn-outline:hover, .style-light .style-dark .btn-' . $key . '.btn-text-skin.btn-outline:focus, .style-light .style-dark .btn-' . $key . '.btn-text-skin.btn-outline:active { color: ' . $btn_outline . ' !important; }';
	}

	// Text
	if ( is_array( $properties ) && in_array( 'text', $properties ) ) {
		echo "\n" . '.text-' . $key . '-color { color: ' . $value . ' !important; fill: ' . $value . ' !important; }';
	}

	// Border
	if ( is_array( $properties ) && in_array( 'border', $properties ) ) {
		echo "\n" . '.border-' . $key . '-color { border-color: ' . $value . ' !important; }';
	}

	// Overlay
	if ( is_array( $properties ) && in_array( 'overlay', $properties ) ) {
		if ( $value_rgb && is_array($value_rgb) && isset($value_rgb[0]) && $value_rgb[0] !== '' ) {
			echo "\n" . '.tmb-overlay-gradient-top .style-' . $key . '-bg { background-color: transparent !important; background-image: linear-gradient(to bottom, ' . $value . ' 0%, rgba(' . $value_rgb[0] . ', ' . $value_rgb[1] . ', ' . $value_rgb[2] . ', 0) 50%) !important;}';
			echo "\n" . '.tmb-overlay-gradient-bottom .style-' . $key . '-bg:not(.tmb-term-evidence) { background-color: transparent !important; background-image: linear-gradient(to top, ' . $value . ' 0%, rgba(' . $value_rgb[0] . ', ' . $value_rgb[1] . ', ' . $value_rgb[2] . ', 0) 50%) !important;}';
		} else {
			echo "\n" . '.tmb-overlay-gradient-top .style-' . $key . '-bg { background-color: transparent !important; }';
			echo "\n" . '.tmb-overlay-gradient-bottom .style-' . $key . '-bg:not(.tmb-term-evidence) { background-color: transparent !important; }';
		}
	}
}

/**
 * Print the CSS of a custom gradient color
 */
function uncode_print_style_custom_gradient_color_css( $key, $value, $properties = array( 'bg', 'button', 'text', 'border' ) ) {
	// Background
	if ( is_array( $properties ) && in_array( 'bg', $properties ) ) {
		echo "\n" . '.style-' . $key . '-bg { ' . $value . ' }';
	}

	// Button
	if ( is_array( $properties ) && in_array( 'button', $properties ) ) {
		echo "\n" . '.btn-' . $key . ' { color: #ffffff !important; ' . $value . str_replace('background','border-image',$value) . '}';
	}

	// Border
	// if ( is_array( $properties ) && in_array( 'border', $properties ) ) {
	// 	echo "\n" . '.border-' . $key . '-color {'.str_replace('background','border-image',$value).'}';
	// }

	// Text
	if ( is_array( $properties ) && in_array( 'text', $properties ) ) {
		preg_match_all("/rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/i", $value, $matches);
		if (isset($matches[0][0])) {
			echo "\n" . '.text-' . $key . '-color > * { color: '.$matches[0][0].' !important; }';
		}
		echo "\n" . '.text-' . $key . '-color > * { -webkit-text-fill-color: transparent !important; -webkit-background-clip: text !important; '.$value.' }';
		echo "\n" . '.text-' . $key . '-color > * { background: none !important \0/IE9; }';
		echo "\n" . '@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) { .text-' . $key . '-color > * { background: none !important; } }';
	}
}
