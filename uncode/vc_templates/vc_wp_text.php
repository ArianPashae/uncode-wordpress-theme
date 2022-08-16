<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $live_search
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Wp_Text
 */
$output = '';

extract(shortcode_atts(array(
	'title' => '',
	'text' => '',
	'el_id' => '',
	'el_class' => '',
	'use_widget_style' => '',
	'widget_style_no_separator' => '',
	'widget_collapse' => '',
	'widget_collapse_tablet' => '',
	'widget_style_title_typography' => '',
), $atts));

$atts['filter'] = true; // Hack to make sure that <p> added

$content = apply_filters( 'vc_wp_text_widget_shortcode', $content );
if ( strlen( $content ) > 0 ) {
	$atts['text'] = $content;
}

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$el_class = $this->getExtraClass( $el_class );

if ( $use_widget_style === 'yes' && $widget_style_no_separator === 'yes' ) {
	$el_class .= ' widget-no-separator';
}

if ( $use_widget_style === 'yes' && $widget_collapse === 'yes' ) {
	$el_class .= ' widget-mobile-collapse';

	if ( $widget_collapse_tablet === 'yes' ) {
		$el_class .= ' widget-tablet-collapse';
	} else {
		$el_class .= ' widget-no-tablet-collapse';
	}
}

if ( $use_widget_style === 'yes' && $widget_style_title_typography ) {
	$el_class .= ' widget-typography-' . $widget_style_title_typography;
}

$output = '<div class="vc_wp_text wpb_content_element' . esc_attr( $el_class ) . '" ' . $el_id . '>';
$type = 'WP_Widget_Text';
global $wp_widget_factory;
// to avoid unwanted warnings let's check before using widget
if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	$args = $use_widget_style === 'yes' ? uncode_get_default_widget_args( 'text' ) : array();
	the_widget( $type, $atts, $args );
	$widget = ob_get_clean();
	if ( $use_widget_style === 'yes' && $widget_collapse === 'yes' ) {
		$widget = uncode_add_default_widget_title( $widget, false, esc_html__( 'Text', 'uncode' ) );
	}
	$output .= $widget;
	$output .= '</div>';

	echo uncode_switch_stock_string( $output );
}
