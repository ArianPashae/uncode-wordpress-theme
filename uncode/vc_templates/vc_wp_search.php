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
 * @var $this WPBakeryShortCode_VC_Wp_Search
 */
$title = $el_id = $el_class = $live_search = '';
$output = '';

extract(shortcode_atts(array(
	'title' => '',
	'live_search' => '',
	'el_id' => '',
	'el_class' => '',
	'use_widget_style' => '',
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

$output = '<div class="vc_wp_search wpb_content_element' . esc_attr( $el_class ) . (($live_search === 'yes') ? ' uncode-live-search' : '') . '" ' . $el_id . '>';
$type = 'WP_Widget_Search';
global $wp_widget_factory, $use_live_search;
// to avoid unwanted warnings let's check before using widget
if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	if ($live_search === 'yes') {
		$use_live_search = 'yes';
	} else {
		$use_live_search = 'no';
	}
	$args = $use_widget_style === 'yes' ? uncode_get_default_widget_args( 'search' ) : array();
	the_widget( $type, $atts, $args );
	$widget = ob_get_clean();
	if ( $use_widget_style === 'yes' && $widget_collapse === 'yes' ) {
		$widget = uncode_add_default_widget_title( $widget, false, esc_html__( 'Search', 'uncode' ) );
	}
	$output .= $widget;
	$use_live_search = '';
	$output .= '</div>';

	echo uncode_switch_stock_string( $output );
} else {
	echo esc_html( $this->debugComment( 'Widget ' . $type . 'Not found in : vc_wp_search' ) );
}
// TODO: make more informative if wp is in debug mode
