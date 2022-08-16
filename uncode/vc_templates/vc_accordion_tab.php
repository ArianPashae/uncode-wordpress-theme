<?php
global $history_tab;
$output = $title = $id = $active = $tab_id = $slug = $icon = $icon_position = $column_padding = $column_padding = '';

extract(shortcode_atts(array(
	'title' => esc_html__("Section", "uncode"),
	'id' => '',
	'active' => '',
	'tab_id' => '',
	'slug' => '',
	'icon' => '',
	'icon_position' => '',
	'gutter_size' => '2',
	'column_padding' => '2',
), $atts));

if ( $tab_id === '' ) {
	$create_id = preg_replace('/[^A-Za-z0-9\-]/', '', sanitize_title($title)) . '-' . uncode_big_rand();
} else {
	$create_id = $tab_id;
}

$icon_left = $icon_right = '';
if ( $icon !== '' ) {
	$icon = '<i class="' . esc_attr($icon) . ' icon-position-' . esc_attr($icon_position ? $icon_position : 'left') . '"></i>';
}
if ( $icon_position !== 'right' ) {
	$icon_left = $icon;
} else {
	$icon_right = $icon;
}

$hash = $slug !== '' ? sanitize_title( $slug ) : $create_id;

$history_rend = $history_tab !== '' ? ' data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"' : '';
$history_tag = $history_tab !== '' ? 'data-id' : 'id';
$body_class = '';

switch ($gutter_size) {
	case 0:
		$body_class .= ' no-internal-gutter';
	break;
	case 1:
		$body_class .= ' one-internal-gutter';
	break;
	case 2:
	default:
		$body_class .= ' half-internal-gutter';
	break;
	case 3:
		$body_class .= ' single-internal-gutter';
	break;
	case 4:
		$body_class .= ' double-internal-gutter';
	break;
	case 5:
		$body_class .= ' triple-internal-gutter';
	break;
	case 6:
		$body_class .= ' quad-internal-gutter';
	break;
}

switch ($column_padding) {
	case '0':
		$body_class .= ' no-block-padding';
	break;
	case '1':
		$body_class .= ' one-block-padding';
	break;
	case '2':
		$body_class .= ' single-block-padding';
	break;
	case '3':
		$body_class .= ' double-block-padding';
	break;
	case '4':
		$body_class .= ' triple-block-padding';
	break;
	case '5':
		$body_class .= ' quad-block-padding';
	break;
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'panel panel-default wpb_accordion_section group', $this->settings['base'], $atts );
$output .= '<div class="'.esc_attr(trim($css_class)).'">';
$output .= '<div class="panel-heading wpb_accordion_header ui-accordion-header" role="tab">';
$output .= '<p class="panel-title'.($active ? ' active' : '').'"><a data-toggle="collapse" data-parent="#'.$id.'" href="#'.$hash.'"' . $history_rend . '>' . $icon_left . '<span>' . $title . '</span>' . $icon_right . '</a></p>';
$output .= '</div>';
$output .= '<div ' . esc_attr( $history_tag ) . '="' . esc_attr( $hash ) . '" class="panel-collapse collapse'.($active ? ' in' : '').'" role="tabpanel">';
$output .= '<div class="panel-body wpb_accordion_content ui-accordion-content' .  $body_class . '">';
$output .= ($content=='' || $content==' ') ? esc_html__("Empty section. Edit page to add content here.", "uncode") : "\n\t\t\t\t\t\t" . $content;
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo uncode_remove_p_tag($output);
