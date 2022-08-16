<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $el_id
 * Shortcode class
 * @var $this WPBakeryShortCode_Vc_Widget_sidebar
 */
$output = '';

extract(shortcode_atts(array(
	'title' => '',
	'sidebar_id' => '',
	'el_id' => '',
	'el_class' => '',
	'use_widget_style' => '',
	'widget_style_no_arrows' => '',
	'widget_collapse' => '',
	'widget_style_no_separator' => '',
	'widget_style_title_typography' => '',
), $atts));

if ( '' === $sidebar_id ) {
	return null;
}

$el_class = $this->getExtraClass( $el_class );

if ( $use_widget_style === 'yes' && $widget_style_no_arrows === 'yes' ) {
	$el_class .= ' widget-no-arrows';
}

if ( $use_widget_style === 'yes' && $widget_style_no_separator === 'yes' ) {
	$el_class .= ' widget-no-separator';
}

if ( $use_widget_style === 'yes' && $widget_collapse === 'yes' ) {
	$el_class .= ' widget-mobile-collapse';
}

if ( $use_widget_style === 'yes' && $widget_style_title_typography ) {
	$el_class .= ' widget-typography-' . $widget_style_title_typography;
}

ob_start();
dynamic_sidebar( $sidebar_id );
$sidebar_value = ob_get_contents();
ob_end_clean();

$sidebar_value = uncode_add_default_widget_title( $sidebar_value, true );

$sidebar_value = trim( $sidebar_value );
$sidebar_value = ( '<li' === substr( $sidebar_value, 0, 3 ) ) ? '<ul>' . $sidebar_value . '</ul>' : $sidebar_value;

if ( $use_widget_style === 'yes' ) {
	$sidebar_value = str_replace( 'widget-container', 'widget-container widget-style', $sidebar_value );
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_widgetised_column wpb_content_element' . $el_class, $this->settings['base'], $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$output = '<div ' . implode( ' ', $wrapper_attributes ) . ' class="' . esc_attr( $css_class ) . '">
		<div class="wpb_wrapper">
			' . wpb_widget_title( array(
	'title' => $title,
	'extraclass' => 'wpb_widgetised_column_heading',
) ) . '
			' . $sidebar_value . '
		</div>
	</div>
';

return $output;
