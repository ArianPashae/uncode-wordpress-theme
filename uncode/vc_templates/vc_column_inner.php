<?php

$output = $el_id = $el_class = $width = $column_width_use_pixel = $column_width_percent = $column_width_pixel = $style = $font_family = $limit_content = $uncell_style = $back_color = $back_image = $back_image_auto = $back_image_option = $back_repeat = $back_attachment = $back_position = $back_size = $overlay_color = $overlay_alpha = $overlay_color_blend = $position_vertical = $position_horizontal = $align_horizontal = $expand_height = $override_padding = $gutter_size = $style_back = $div_style = $spaced_cell = $mobile_height = $uncoltable_style = $desktop_visibility = $medium_visibility = $mobile_visibility = $align_medium = $align_mobile = $col_style = $uncol_style = $background_div = $zoom_width = $zoom_height = $shift_x = $shift_x_fixed = $shift_y_fixed = $shift_y = $shift_y_down = $shift_y_down_fixed = $z_index = $internal_width = $link_div = $sticky = $shadow = $shadow_darker = $radius = $css_animation = $animation_delay = $animation_speed = $is_carousel = $medium_width = $mobile_width = $col_perc_md = $col_perc_sm = $kburns = $preserve_border = $preserve_border_tablet = $preserve_border_mobile = $custom_inline_css = '';
extract(shortcode_atts(array(
	'uncode_shortcode_id' => '',
	'el_id' => '',
	'el_class' => '',
	'el_uncol_class' => '',
	'width' => '1/1',
	'column_width_use_pixel' => '',
	'column_width_percent' => '100',
	'column_width_pixel' => '',
	'limit_content' => '',
	'style' => '',
	'font_family' => '',
	'back_color' => '',
	'back_color_type' => '',
	'back_color_solid' => '',
	'back_color_gradient' => '',
	'back_image' => '',
	'back_image_auto' => '',
	'back_image_option' => '',
	'back_repeat' => '',
	'back_attachment' => '',
	'back_position' => 'center center',
	'back_size' => '',
	'parallax' => '',
	'kburns' => '',
	'overlay_color' => '',
	'overlay_color_type' => '',
	'overlay_color_solid' => '',
	'overlay_color_gradient' => '',
	'overlay_alpha' => '',
	'overlay_color_blend' => '',
	'position_vertical' => 'top',
	'position_horizontal' => 'center',
	'align_horizontal' => 'align_left',
	'expand_height' => '',
	'override_padding' => '',
	'column_padding' => '2',
	'gutter_size' => '3',
	'medium_width' => '',
	'mobile_width' => '',
	'mobile_height' => '',
	'desktop_visibility' => '',
	'medium_visibility' => '',
	'mobile_visibility' => '',
	'align_medium' => '',
	'align_mobile' => '',
	'zoom_width' => '',
	'zoom_height' => '',
	'shift_x' => '',
	'shift_x_fixed' => '',
	'shift_y' => '',
	'shift_y_fixed' => '',
	'shift_y_down' => '',
	'shift_y_down_fixed' => '',
	'z_index' => '',
	'css_animation' => '',
	'animation_delay' => '',
	'animation_speed' => '',
	'parallax_intensity' => '',
	'parallax_centered' => '',
	'sticky' => '',
	'link_to' => '',
	'shadow' => '',
	'shadow_darker' => '',
	'radius' => '',
	'css' => '',
	'border_color' => '',
	'border_color_type' => '',
	'border_color_solid' => '',
	'border_style' => '',
	'preserve_border' => '',
	'preserve_border_tablet' => '',
	'preserve_border_mobile' => '',
) , $atts));

if ( $el_id !== '' ) {
	$el_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$el_id = '';
}

$col_classes = array('wpb_column');
$uncol_classes = array(
	'uncol'
);
$uncoltable_classes = array(
	'uncoltable'
);
$uncell_classes = array(
	'uncell'
);
$uncont_classes = array(
	'uncont'
);
$div_data = array();

$el_class = $this->getExtraClass($el_class);
$el_uncol_class = $this->getExtraClass($el_uncol_class);

if ( $el_uncol_class !== '' ) {
	$uncol_classes[] = $el_uncol_class;
}

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'vc_column_inner',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'back_color'             => $back_color,
		'back_color_type'        => $back_color_type,
		'back_color_solid'       => $back_color_solid,
		'back_color_gradient'    => $back_color_gradient,
		'overlay_color'          => $overlay_color,
		'overlay_color_type'     => $overlay_color_type,
		'overlay_color_solid'    => $overlay_color_solid,
		'overlay_color_gradient' => $overlay_color_gradient,
		'border_color'           => $border_color,
		'border_color_type'      => $border_color_type,
		'border_color_solid'     => $border_color_solid,
		'border_color_gradient'  => false,
	)
) );

$back_color = uncode_get_shortcode_color_attribute_value( 'back_color', $uncode_shortcode_id, $back_color_type, $back_color, $back_color_solid, $back_color_gradient );
$overlay_color = uncode_get_shortcode_color_attribute_value( 'overlay_color', $uncode_shortcode_id, $overlay_color_type, $overlay_color, $overlay_color_solid, $overlay_color_gradient );
$border_color = uncode_get_shortcode_color_attribute_value( 'border_color', $uncode_shortcode_id, $border_color_type, $border_color, $border_color_solid, false );

global $vc_column_width, $vc_column_inner_width, $changer_back_color_row_inner, $changer_back_color_column_inner;

$vc_column_width = $vc_column_width == 0 ? 1 : $vc_column_width;
$vc_column_inner_width = $vc_column_inner_width == 0 ? 1 : $vc_column_inner_width;

$width_array = explode('/', $width);
$width_media = ((int) trim($width_array[0]) / trim($width_array[1])) * 12;
$vc_column_inner_width = $width_media / ( 12 / $vc_column_width );
$width = wpb_translateColumnWidthToSpan($width);

if ( substr_count( $content, '[vc_single_image' ) ) {
	$content = uncode_vc_replace_inner_single_width( $content, $width_media, 'vc_single_image' );
}

if ( substr_count( $content, '[vc_gallery' ) ) {
	$content = uncode_vc_replace_inner_single_width( $content, $width_media, 'vc_gallery' );
}

if ( substr_count( $content, '[uncode_index' ) ) {
	$content = uncode_vc_replace_inner_single_width( $content, $width_media, 'uncode_index' );
}

if ($position_vertical !== '') {
	$col_classes[] = 'pos-' . $position_vertical;
}
if ($position_horizontal !== '') {
	$col_classes[] = 'pos-' . $position_horizontal;
}
if ($align_horizontal !== '') {
	$col_classes[] = $align_horizontal;
}
if ($align_medium !== '') {
	$col_classes[] = $align_medium;
}
if ($align_mobile !== '') {
	$col_classes[] = $align_mobile;
}

if ($column_width_use_pixel === 'yes' && $column_width_pixel !== '') {
	$column_width_pixel = preg_replace("/[^0-9,.]/", "", $column_width_pixel);
	$column_width_pixel = 12 * round(($column_width_pixel) / 12);
	$internal_width = ' style="max-width:' . esc_attr( $column_width_pixel ) . 'px;"';
} else {
	if (!empty($column_width_percent) && $column_width_percent !== '100') {
		$internal_width = ' style="max-width:' . esc_attr( $column_width_percent ) . '%;"';
	}
}

global $metabox_data, $previous_blend, $is_cb;
if (isset($metabox_data['_uncode_specific_style'][0]) && $metabox_data['_uncode_specific_style'][0] !== '') {
	$general_style = $metabox_data['_uncode_specific_style'][0];
} else {
	$general_style = ot_get_option('_uncode_general_style');
}

if ($style === '') {
	$style = $general_style;
}

$uncol_classes[] = 'style-' . $style;
if ($font_family !== '') {
	$uncol_classes[] = $font_family;
}

if (!empty($mobile_height)) {
	$uncoltable_style .= 'min-height: ' . preg_replace("/[^0-9,.]/", "", $mobile_height) . 'px;';
}

if ( $back_image_auto === 'yes' && is_singular() && $is_cb ) {
	$featured_id = get_post_thumbnail_id(get_the_id());
	$featured_id = apply_filters( 'uncode_featured_image_id', $featured_id, get_the_id() );

	if ( $back_image_option === 'secondary' ) {
		$secondary_featured = uncode_get_secondary_featured_thumbnail_id(get_the_id());

		if ( $secondary_featured ) {
			$featured_id = $secondary_featured;
		}
	}

	if ( $featured_id ) {
		$back_image = $featured_id;
	}
}

if ($override_padding === 'yes') {
	switch ($column_padding) {
		case '0':
			$padding_class = 'no-block-padding';
		break;
		case '1':
			$padding_class = 'one-block-padding';
		break;
		case '2':
			$padding_class = 'single-block-padding';
		break;
		case '3':
			$padding_class = 'double-block-padding';
		break;
		case '4':
			$padding_class = 'triple-block-padding';
		break;
		case '5':
			$padding_class = 'quad-block-padding';
		break;
	}
} else {
	if ((empty($back_image) && empty($back_color))) {
		$padding_class = 'no-block-padding';
	} else {
		$padding_class = 'single-block-padding';
	}
}

if ($expand_height === 'yes') {
	$uncol_classes[] = 'unexpand';
}
if ($sticky === 'yes') {
	$uncol_classes[] = 'sticky-element sticky-sidebar';
}

if (substr_count($content, '[uncode_slider')) {
	//$is_carousel = true;
	$el_class.= ' column_container';
}

if ($this->settings['base'] == 'vc_column') {
	$col_classes[] = 'column_parent';
} else {
	$col_classes[] = 'column_child';
}

$temp_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts);
if ($temp_class !== '') {
	$col_classes[] = $temp_class;
}

if ($desktop_visibility === 'yes') {
	$col_classes[] = 'desktop-hidden';
}
if ($medium_visibility === 'yes') {
	$col_classes[] = 'tablet-hidden';
}
if ($mobile_visibility === 'yes') {
	$col_classes[] = 'mobile-hidden';
}

$temp_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ') , $this->settings['base'], $atts);
if ($temp_class !== '') {
	$uncell_classes[] = $temp_class;
}
if ( $preserve_border === 'yes' ) {
	if ( $preserve_border_tablet === 'yes' ) {
		$uncell_classes[] = 'vc_custom_preserve_tablet';
	}
	if ( $preserve_border_mobile === 'yes' ) {
		$uncell_classes[] = 'vc_custom_preserve_mobile';
	}
}

if ($border_color !== '') {
	$uncell_classes[] = 'border-' . $border_color . '-color';
	if ($border_style !== '') {
		$uncell_style = 'border-style: ' . $border_style . ';';
	}
}

if ( $css ) {
	$custom_inline_css = uncode_get_custom_inline_css( $css );
}

if ( $custom_inline_css ) {
	$uncell_style .= $custom_inline_css;
}

if ($uncell_style !== '') {
	$uncell_style = ' style="' . esc_attr( $uncell_style ) . '"';
}

global $row_cols_md_counter_inner, $row_cols_sm_counter_inner;

$col_perc_md = $col_perc_sm = 0;

switch ($medium_width) {
	case 1:
		$col_classes[] = 'col-md-16';
		$col_perc_md = 100/6;
	break;
	case 2:
		$col_classes[] = 'col-md-25';
		$col_perc_md = 25;
	break;
	case 3:
		$col_classes[] = 'col-md-33';
		$col_perc_md = 100/3;
	break;
	case 4:
		$col_classes[] = 'col-md-50';
		$col_perc_md = 50;
	break;
	case 5:
		$col_classes[] = 'col-md-66';
		$col_perc_md = 100/1.5;
	break;
	case 6:
		$col_classes[] = 'col-md-75';
		$col_perc_md = 75;
	break;
	case 7:
		$col_classes[] = 'col-md-100';
		$col_perc_md = 100;
	break;
}
if ( $row_cols_md_counter_inner >= 100 ) {
	$col_classes[] = 'col-md-clear';
}

switch ($mobile_width) {
	case 1:
		$col_classes[] = 'col-sm-16';
		$col_perc_sm = 100/6;
	break;
	case 2:
		$col_classes[] = 'col-sm-25';
		$col_perc_sm = 25;
	break;
	case 3:
		$col_classes[] = 'col-sm-33';
		$col_perc_sm = 100/3;
	break;
	case 4:
		$col_classes[] = 'col-sm-50';
		$col_perc_sm = 50;
	break;
	case 5:
		$col_classes[] = 'col-sm-66';
		$col_perc_sm = 100/1.5;
	break;
	case 6:
		$col_classes[] = 'col-sm-75';
		$col_perc_sm = 75;
	break;
	case 7:
		$col_classes[] = 'col-sm-100';
		$col_perc_sm = 100;
	break;
}
if ( $row_cols_sm_counter_inner >= 100 ) {
	$col_classes[] = 'col-sm-clear';
}

//addition go below class declaration
$row_cols_md_counter_inner = $row_cols_md_counter_inner + $col_perc_md;
$row_cols_sm_counter_inner = $row_cols_sm_counter_inner + $col_perc_sm;

if ($gutter_size === '') {
	$gutter_size = 3;
}

switch ($gutter_size) {
	case 0:
		$col_classes[] = 'no-internal-gutter';
		break;
	case 1:
		$col_classes[] = 'one-internal-gutter';
		break;
	case 2:
		$col_classes[] = 'half-internal-gutter';
		break;
	case 3:
	default:
		$col_classes[] = 'single-internal-gutter';
		break;
	case 4:
		$col_classes[] = 'double-internal-gutter';
		break;
	case 5:
		$col_classes[] = 'triple-internal-gutter';
		break;
	case 6:
		$col_classes[] = 'quad-internal-gutter';
		break;
}

$shadow_classes = '';
$radius_classes = $radius !== '' ? 'unradius-' . $radius : '';

if ($shadow !== '') {

	if ( $shadow_darker !== '' ) {
		$shadow = 'darker-' . $shadow;
	}
	$shadow_classes = 'unshadow-' . $shadow;

}

if ($internal_width !== '' && $this->settings['base'] == 'vc_column' && $width === 'vc_col-sm-12') {
	$uncont_classes[] = $padding_class;
	$uncont_classes[] = 'col-custom-width';
	if (!empty($back_color)) {
		$uncont_classes[] = 'style-' . $back_color . '-bg';
	}
	$uncont_classes[] = $shadow_classes;
	$uncont_classes[] = $radius_classes;
} else {
	$uncell_classes[] = $padding_class;
	if (!empty($back_color)) {
		$uncell_classes[] = 'style-' . $back_color . '-bg';
	}
	$uncell_classes[] = $shadow_classes;
	$uncell_classes[] = $radius_classes;
}

if ( $changer_back_color_row_inner && empty($back_color) ) {
	$div_data['data-skin-change'] = 'style-' . $style;
	$changer_back_color_column_inner = true;
} else {
	$changer_back_color_column_inner = false;
}

/** BEGIN - background construction **/
if (!empty($back_image) || $overlay_color !== '') {
	if ($parallax === 'yes' || $kburns !== '') {
		$back_size = 'cover';
		if ($parallax === 'yes') {
			$back_attachment = '';
			$uncell_classes[] = 'with-parallax';
		}
		if ($kburns === 'yes') {
			$uncell_classes[] = 'with-kburns';
		} elseif ($kburns === 'zoom') {
			$uncell_classes[] = 'with-zoomout';
		} elseif ($kburns === 'magnetic') {
			$uncell_classes[] = 'magnetic';
		}
	} else {
		if ($back_size === '') {
			$back_size = 'cover';
		}
	}

	if ($back_repeat === '') {
		$back_repeat = 'no-repeat';
	}

	$back_array = array (
		'background-image' => $back_image,
		'background-color' => $back_color,
		'background-repeat' => $back_repeat,
		'background-position' => $back_position,
		'background-size' => $back_size,
		'background-attachment' => $back_attachment,
	);

	$background_div_width = '';

	if ($column_width_use_pixel === 'yes' && $column_width_pixel !== '') {
		$column_width_pixel = preg_replace("/[^0-9,.]/", "", $column_width_pixel);
		$column_width_pixel = 12 * round(($column_width_pixel) / 12);
		$background_div_width .= 'max-width: ' . $column_width_pixel . 'px;';
	} else {
		if (!empty($column_width_percent) && $column_width_percent !== '100') {
			$background_div_width .= 'max-width: ' . $column_width_percent . '%;';
		}
	}
	if ($background_div_width !== '') {
		$background_div_width .= 'margin-left: auto; margin-right: auto;';
	}

	if ( $overlay_color_blend !== '' ) {
		$back_array['mix-blend-mode'] = $overlay_color_blend;
		$previous_blend = true;
	}

	$back_result_array = uncode_get_back_html($back_array, $overlay_color, $overlay_alpha, '', 'column');
	$background_div = $back_result_array['back_html'];
}

/** END - background construction **/

/** BEGIN - shift construction **/
if (($zoom_width != '0' && $zoom_width != '') || ($zoom_height != '0' && $zoom_height != '') || ($shift_x != '0' && $shift_x != '') || ($shift_y != '0' && $shift_y != '') || ($shift_y_down != '0' && $shift_y_down != '')) {
	switch ($zoom_width) {
		case 1:
			$uncol_classes[] = 'zoom_width_half';
		break;
		case 2:
			$uncol_classes[] = 'zoom_width_single';
		break;
		case 3:
			$uncol_classes[] = 'zoom_width_double';
		break;
		case 4:
			$uncol_classes[] = 'zoom_width_triple';
		break;
		case 5:
			$uncol_classes[] = 'zoom_width_quad';
		break;
	}
	switch ($zoom_height) {
		case 1:
			$uncol_classes[] = 'zoom_height_half';
		break;
		case 2:
			$uncol_classes[] = 'zoom_height_single';
		break;
		case 3:
			$uncol_classes[] = 'zoom_height_double';
		break;
		case 4:
			$uncol_classes[] = 'zoom_height_triple';
		break;
		case 5:
			$uncol_classes[] = 'zoom_height_quad';
		break;
	}
	switch ($shift_x) {
		case 1:
			$uncol_classes[] = 'shift_x_half';
		break;
		case 2:
			$uncol_classes[] = 'shift_x_single';
		break;
		case 3:
			$uncol_classes[] = 'shift_x_double';
		break;
		case 4:
			$uncol_classes[] = 'shift_x_triple';
		break;
		case 5:
			$uncol_classes[] = 'shift_x_quad';
		break;
		case -1:
			$uncol_classes[] = 'shift_x_neg_half';
		break;
		case -2:
			$uncol_classes[] = 'shift_x_neg_single';
		break;
		case -3:
			$uncol_classes[] = 'shift_x_neg_double';
		break;
		case -4:
			$uncol_classes[] = 'shift_x_neg_triple';
		break;
		case -5:
			$uncol_classes[] = 'shift_x_neg_quad';
		break;
	}
	switch ($shift_y) {
		case 1:
			$uncol_classes[] = 'shift_y_half';
		break;
		case 2:
			$uncol_classes[] = 'shift_y_single';
		break;
		case 3:
			$uncol_classes[] = 'shift_y_double';
		break;
		case 4:
			$uncol_classes[] = 'shift_y_triple';
		break;
		case 5:
			$uncol_classes[] = 'shift_y_quad';
		break;
		case -1:
			$uncol_classes[] = 'shift_y_neg_half';
		break;
		case -2:
			$uncol_classes[] = 'shift_y_neg_single';
		break;
		case -3:
			$uncol_classes[] = 'shift_y_neg_double';
		break;
		case -4:
			$uncol_classes[] = 'shift_y_neg_triple';
		break;
		case -5:
			$uncol_classes[] = 'shift_y_neg_quad';
		break;
	}

	switch ($shift_y_down) {
		case 1:
			$uncol_classes[] = 'shift_y_down_half';
		break;
		case 2:
			$uncol_classes[] = 'shift_y_down_single';
		break;
		case 3:
			$uncol_classes[] = 'shift_y_down_double';
		break;
		case 4:
			$uncol_classes[] = 'shift_y_down_triple';
		break;
		case 5:
			$uncol_classes[] = 'shift_y_down_quad';
		break;
		case -1:
			$uncol_classes[] = 'shift_y_down_neg_half';
		break;
		case -2:
			$uncol_classes[] = 'shift_y_down_neg_single';
		break;
		case -3:
			$uncol_classes[] = 'shift_y_down_neg_double';
		break;
		case -4:
			$uncol_classes[] = 'shift_y_down_neg_triple';
		break;
		case -5:
			$uncol_classes[] = 'shift_y_down_neg_quad';
		break;
	}
	if ($shift_x_fixed === 'yes') {
		$uncol_classes[] = 'shift_x_fixed';
	}
	if ($shift_y_fixed === 'yes') {
		$uncol_classes[] = 'shift_y_fixed';
	}
	if ($shift_y_down_fixed === 'yes') {
		$uncol_classes[] = 'shift_y_down_fixed';
	}
}

if ($shift_y_down != '0' && $shift_y_down != '') {
	$col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
}

if ($z_index !== '0' && $z_index !== '') {
	$col_classes[] = 'z_index_' . str_replace('-','neg_', $z_index);
}
/** END - shift construction **/

if ($css_animation !== '') {
	$uncol_classes[] = 'animate_when_almost_visible ' . $css_animation;
	if ($animation_delay !== '') {
		$div_data['data-delay'] = $animation_delay;
	}
	if ($animation_speed !== '') {
		$div_data['data-speed'] = $animation_speed;
	}
}

$uncell_div_data = '';

if ( $parallax_intensity !== '' ) {
	$uncell_classes[] .= ' parallax-el';
	$uncell_div_data = uncode_get_parallax_div_data( $parallax_intensity, $parallax_centered, true );
}

if ( $link_to !== '' && ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) ) {
	$link = vc_build_link( $link_to );
	if ($link['url'] !== '') {
		$link_div = '<a class="col-link custom-link" href="'.esc_url($link['url']).'" target="'.($link['target'] !== '' ? esc_attr( $link['target'] ) : '_self').'" title="' . esc_attr( $link['title'] ) . '"></a>';
	}
}

if ($uncoltable_style != '') {
	$uncoltable_style = ' style="' . esc_attr( $uncoltable_style ) . '"';
}

if ($is_carousel) {
	$output.= $content;
} else {
	if ( !function_exists('vc_is_page_editable') || !vc_is_page_editable() ) {
		global $uncode_row_child, $uncode_vc_block;
		if ( !$uncode_vc_block ) {
			$uncode_row_child -= $width_media;
			if ($uncode_row_child < 0) {
				$output.= '</div><div class="row-inner">';
				$uncode_row_child = 12;
				$uncode_row_child -= $width_media;
			}
		}
	}
	$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));
	$output.= '<div class="' . esc_attr(trim(implode(' ', $col_classes))) . '"' . $col_style . $el_id . '>';
	$output.= '<div class="' . esc_attr(trim(implode(' ', $uncol_classes))) . '"' . $uncol_style . ' '.implode(' ', $div_data_attributes).'>';
	$output.= '<div class="' . esc_attr(trim(implode(' ', $uncoltable_classes))) . '"' . $uncoltable_style . '>';
	$output.= '<div class="' . esc_attr(trim(implode(' ', $uncell_classes))) . '"'.$uncell_style.' ' . $uncell_div_data . '>';
	$output.= $background_div;
	$output.= '<div class="' . esc_attr(trim(implode(' ', $uncont_classes))) . '"' . $internal_width . '>';
	$output.= $content;
	$output.= '</div>';
	$output.= '</div>';
	$output.= '</div>';
	$output.= '</div>';
	$output.= $link_div;
	$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );
	$output.= '</div>';
}

echo uncode_remove_p_tag($output);
