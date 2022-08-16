<?php

$el_id = $el_class = $inline = $text_lead = $info_content = '';
extract(shortcode_atts(array(
	'el_id' => '',
	'el_class' => '',
	'text_lead' => '',
	'inline' => ''
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}
global $post;

$post_type = uncode_get_current_post_type();
if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) {
	$post_object = uncode_populate_post_object('portfolio');
} else {
	if ( $post_type !== 'portfolio' ) {
		return;
	}
	$post_object = $post;
}

$portfolio_details = ot_get_option('_uncode_portfolio_details');

if (!empty($portfolio_details) && $post_object) {

	foreach ($portfolio_details as $key => $value) {
		$portfolio_detail = get_post_meta( $post_object->ID, $value['_uncode_portfolio_detail_unique_id'], true );

		if ($portfolio_detail !== '') {
			$get_url = parse_url($portfolio_detail);
			$portfolio_detail = str_replace(' rel="nofollow"', "", make_clickable($portfolio_detail));
			if (isset($get_url['host'])) {
				$portfolio_detail = preg_replace('/<a(.+?)>.+?<\/a>/i','<a$1 target="_blank">'.$get_url['host'].'</a>',$portfolio_detail);
			} else {
				$portfolio_detail = preg_replace('/^(?!.*( target=)).*<a /','<a target="_blank" ',$portfolio_detail);
			}
			$info_content.= '<span class="detail-container"><span class="detail-label">' . $value['title'] . '</span><span class="detail-value">' . $portfolio_detail . '</span></span>';
		}
	}
	if ($info_content !== '') {
		$info_content = '<p>' . $info_content . '</p>';
	}
} else {
	$info_content = '<p>
		<span class="detail-container">
			<span class="detail-label">' . esc_html__( 'Client', 'uncode' ) . '</span>
			<span class="detail-value">' . esc_html__( 'Client placeholder', 'uncode' ) . '</span>
		</span>
		<span class="detail-container">
			<span class="detail-label">' . esc_html__( 'Services', 'uncode' ) . '</span>
			<span class="detail-value">' . esc_html__( 'Services placeholder', 'uncode' ) . '</span>
		</span>
		<span class="detail-container">
			<span class="detail-label">' . esc_html__( 'Year', 'uncode' ) . '</span>
			<span class="detail-value">' . esc_html__( 'Year placeholder', 'uncode' ) . '</span>
		</span>
	</p>';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uncode-portfolio-details', $this->settings['base'], $atts );

$classes = array( $css_class );
$classes[] = trim( $this->getExtraClass( $el_class ) );

if ($text_lead === 'yes') {
	$classes[] = 'text-lead';
} else if ($text_lead === 'small') {
	$classes[] = 'text-small';
}

if ( $inline == 'yes' ) {
	$classes[] = 'inline-meta';
}

$output = '<div class="uncode-wrapper '.esc_attr( trim( implode( ' ', $classes ) ) ).'" '.$el_id . '>';
	$output .= $info_content;
$output .= '</div>';

echo uncode_remove_p_tag($output);
