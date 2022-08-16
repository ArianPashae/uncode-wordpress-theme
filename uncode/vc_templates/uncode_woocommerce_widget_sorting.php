<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$output = '';

extract(shortcode_atts(array(
	'title' => '',
	'hide_title' => '',
	'el_id' => '',
	'el_class' => '',
	'use_widget_style' => '',
	'widget_style_no_arrows' => '',
	'widget_collapse' => '',
	'widget_collapse_tablet' => '',
	'widget_style_no_separator' => '',
	'widget_style_title_typography' => '',
), $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

if ( $hide_title === 'yes' ) {
	$atts['title'] = '!';
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

	if ( $widget_collapse_tablet === 'yes' ) {
		$el_class .= ' widget-tablet-collapse';
	} else {
		$el_class .= ' widget-no-tablet-collapse';
	}
}

if ( $use_widget_style === 'yes' && $widget_style_title_typography ) {
	$el_class .= ' widget-typography-' . $widget_style_title_typography;
}

$output = '<div class="uncode_woocommerce_widget uncode_woocommerce_widget--sorting wpb_content_element' . esc_attr( $el_class ) . '" ' . $el_id . '>';
$type = 'Uncode_WC_Widget_Sorting';
global $wp_widget_factory;
// to avoid unwanted warnings let's check before using widget
if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	$args = $use_widget_style === 'yes' ? uncode_get_default_widget_args( 'sorting' ) : array();
	the_widget( $type, $atts, $args );
	$widget = ob_get_clean();
	if ( $use_widget_style === 'yes' && $widget_collapse === 'yes' ) {
		$widget = uncode_add_default_widget_title( $widget, false, esc_html__( 'Sort products', 'uncode' ) );
	}
	$output .= $widget;
	$output .= '</div>';

	echo uncode_switch_stock_string( $output );
}
