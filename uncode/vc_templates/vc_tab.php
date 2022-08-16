<?php
global $history_tab, $first_tab_active, $product;
/** @var $this WPBakeryShortCode_VC_Tab */
$output = $title = $tab_id = $gutter_size = $first = $slug = $icon = $icon_position = $product_from_builder = $column_padding = '';
extract( shortcode_atts( array(
	'title' => '',
	'tab_id' => 0,
	'slug' => '',
	'gutter_size' => '2',
	'column_padding' => '2',
	'icon_position' => '',
	'product_from_builder' => '',
	'icon' => '',
), $atts ) );

$history_tag = $history_tab !== '' ? 'data-id' : 'id';

if ($first_tab_active) {
	$first = ' in active';
}
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'tab-pane fade' . $first, $this->settings['base'], $atts );

switch ($gutter_size) {
	case 0:
		$css_class .= ' no-internal-gutter';
	break;
	case 1:
		$css_class .= ' one-internal-gutter';
	break;
	case 2:
	default:
		$css_class .= ' half-internal-gutter';
	break;
	case 3:
		$css_class .= ' single-internal-gutter';
	break;
	case 4:
		$css_class .= ' double-internal-gutter';
	break;
	case 5:
		$css_class .= ' triple-internal-gutter';
	break;
	case 6:
		$css_class .= ' quad-internal-gutter';
	break;
}

switch ($column_padding) {
	case '0':
		$css_class .= ' no-block-padding';
	break;
	case '1':
		$css_class .= ' one-block-padding';
	break;
	case '2':
		$css_class .= ' single-block-padding';
	break;
	case '3':
		$css_class .= ' double-block-padding';
	break;
	case '4':
		$css_class .= ' triple-block-padding';
	break;
	case '5':
		$css_class .= ' quad-block-padding';
	break;
}

$tab_id = empty($tab_id) ? sanitize_title( $title ) : $tab_id;
$hash = $slug !== '' ? sanitize_title( $slug ) : 'tab-' . $tab_id;
$output .= '<div ' . esc_attr( $history_tag ) . '="' . esc_attr( $hash ) .'" class="' . esc_attr(trim($css_class)) . '">';
if ( $product || $product_from_builder ) {
	$output .= '<div class="product-tab">';
} else {
	$output .= '<div>';
}
$output .= ($content=='' || $content==' ') ? esc_html__("Empty tab. Edit page to add content here.", "uncode") : "\n\t\t\t\t" . $content;
$output .= '</div></div>';
$first_tab_active = false;

echo uncode_remove_p_tag($output);
