<?php
$output = $vertical = $history = $target = $interval = $el_id = $el_class = $data_check_tab = $align = $width_100 = $border_100 = $typography = '';

global $history_tab, $first_tab_active, $product;

$first_tab_active = true;

extract( shortcode_atts( array(
	'vertical' => '',
	'history' => '',
	'target' => '',
	'align' => '',
	'width_100' => '',
	'border_100' => '',
	'el_id' => '',
	'el_class' => '',
	'product_from_builder' => '',
	'typography' => ''
), $atts ) );

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$history_tab = $history;

$el_class = $this->getExtraClass( $el_class );
$tabs_class = array();

$element = 'uncode-tabs';

// Extract tab titles
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();

if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}

switch ( $align ) {
	case 'left':
		$tabs_class[] = 'text-left';
		break;

	case 'right':
		$tabs_class[] = 'text-right';
		break;

	default:
		$tabs_class[] = 'text-center';
		break;
}

if ( $width_100 === 'yes' && $vertical !== 'yes' ) {
	$tabs_class[] = 'width-100';
}

if ( $border_100 === 'yes' && $vertical !== 'yes' ) {
	$el_class .= ' border-100';
}

$tabs_nav = '<div class="vc_tta-tabs-container';
if ($vertical === 'yes') {
	$tabs_nav .= ' vertical-tab-menu';
}

$tabs_nav .= '"><ul class="nav nav-tabs wpb_tabs_nav ui-tabs-nav vc_tta-tabs-list'.(($vertical === 'yes') ? ' tabs-left' : '') . ' ' . esc_attr(trim(implode(' ', $tabs_class))) . '">';
$counter = 0;
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts($tab[0]);

	$icon_left = $icon_right = '';
	$icon = isset( $tab_atts['icon'] ) ? $tab_atts['icon'] : '';
	$icon_position = isset( $tab_atts['icon_position'] ) ? $tab_atts['icon_position'] : '';
	if ( $icon !== '' ) {
		$icon = '<i class="' . esc_attr($icon) . ' icon-position-' . esc_attr($icon_position ? $icon_position : 'left') . '"></i>';
	}
	if ( $icon_position !== 'right' ) {
		$icon_left = $icon;
	} else {
		$icon_right = $icon;
	}

	if(isset($tab_atts['title'])) {
		if ( isset( $tab_atts['slug'] ) && $tab_atts['slug'] !== '' ) {
			$hash = sanitize_title( $tab_atts['slug'] );
		} else {
			$hash = 'tab-';
			if ( isset( $tab_atts['tab_id'] ) ) {
				$hash .= $tab_atts['tab_id'];
			} else {
				$hash .= sanitize_title( $tab_atts['title'] );
			}
		}
		$history_rend = $history !== '' ? ' data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"' : '';
		$tabs_nav .= '<li data-tab-id="' . esc_attr( $hash ) . '" data-tab-o-id="' . esc_attr( $tab_atts['tab_id'] ) . '" class="vc_tta-tab'.(($counter === 0) ? ' active' : '').'"><a href="#' . esc_attr( $hash ) . '" data-toggle="tab"' . $history_rend . '><span>' . $icon_left . $tab_atts['title'] . $icon_right . '</span></a></li>';
	}
	$counter++;
}
$tabs_nav .= '</ul>';
$tabs_nav .= '</div>';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

$wrapper_class = $product || $product_from_builder ? ' wootabs' : '';

if ( $typography === 'yes' ) {
	$wrapper_class .= ' default-typography';
}

$output .= '<div class="' . esc_attr($css_class) . '" data-interval="' . esc_attr($interval) . '" ' . $el_id . ' data-target="' . esc_attr( $target ) . '">';
$output .= '<div class="uncode-wrapper tab-container' . $wrapper_class . '">';
$output .= $tabs_nav;
if ($vertical === 'yes') {
	$output .= '<div class="vertical-tab-contents">';
}
$output .= '<div class="tab-content'.(($vertical === 'yes') ? ' vertical' : '').'">';
$output .= $content;
$output .= '</div>';
if ($vertical === 'yes') {
	$output .= '</div>';
}
$output .= '</div>';
$output .= '</div>';

echo uncode_remove_p_tag($output);
$history_tab = '';
