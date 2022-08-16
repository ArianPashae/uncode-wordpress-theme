<?php
$output = $title = $interval = $history = $target = $el_id = $el_class = $collapsible = $active_tab = $history = $sign = $history_tab = $typography = '';

global $history_tab;

extract(shortcode_atts(array(
	'title' => '',
	'interval' => 0,
	'history' => '',
	'target' => '',
	'el_id' => '',
	'el_class' => '',
	'collapsible' => 'no',
	'active_tab' => '1',
	'history' => '',
	'sign' => '',
	'typography' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$history_tab = $history;

$el_unique_id = 'accordion_' . rand();
preg_match_all('/vc_accordion_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE);
$accordion_tab = array();
if (isset($matches[0])) {
	$accordion_tab = $matches[0];
}
$counter = 1;
foreach ($accordion_tab as $tab) {
	if ($counter == $active_tab) {
		$content = str_replace($tab[0], $tab[0] . ' id="' . esc_attr( $el_unique_id ) . '" active="1"', $content);
	} else {
		$content = str_replace($tab[0], $tab[0] . ' id="' . esc_attr( $el_unique_id ) . '"', $content);
	}
	$counter++;
}

$el_class = $this->getExtraClass($el_class);
if ( $sign !== '' ) {
	$el_class .= ' ' . $sign . '-signed';
}
if ( $typography === 'yes' ) {
	$el_class .= ' default-typography';
}

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-accordion wpb_accordion wpb_content_element ' . $el_class, $this->settings['base'], $atts);

$output = '<div class="' . esc_attr(trim($css_class)) . '" data-collapsible="' . esc_attr( $collapsible ) . '" data-target="' . esc_attr( $target ) . '" data-active-tab="' . esc_attr( $active_tab ) . '" ' . $el_id . '>
		<div class="panel-group wpb_wrapper wpb_accordion_wrapper" id="' . esc_attr( $el_unique_id ) . '" role="tablist" aria-multiselectable="true">
' . wpb_widget_title( array(
	'title' => $title,
	'extraclass' => 'wpb_accordion_heading',
) ) . '
' . $content . '
		</div>
	</div>';

echo uncode_remove_p_tag($output);
$history_tab = '';
