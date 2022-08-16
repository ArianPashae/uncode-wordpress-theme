<?php
extract(
	shortcode_atts(
		array(
			'uncode_shortcode_id' => '',
			'element_type' => '',
			'position' => '',
			'fixed' => '',
			'flip' => '',
			'text_align' => '',
			'vertical_text_h_pos' => '',
			'vertical_text_v_pos' => '',
			'z_index' => '',
			'text_font' => '',
			'text_size' => '',
			'text_weight' => '',
			'text_transform' => '',
			'text_height' => '',
			'text_space' => '',
			'text_italic' => '',
			'text_color' => '',
			'text_color_type' => '',
			'text_color_solid' => '',
			'text_color_gradient' => '',
			'socials_size' => '',
			'difference' => '',
			'show_after_scroll' => '',
			'hide_on_bottom' => '',
			'show_on_top' => '',
			'desktop_visibility' => '',
			'medium_visibility' => '',
			'mobile_visibility' => '',
			'el_id' => '',
			'el_class' => '',
		),
		$atts
	)
);

// Extra settings
$el_id    = $el_id ? $el_id : false;
$el_class = $el_class ? $el_class : false;

// Custom ID
if ( $el_id ) {
	$container_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$container_id = '';
}

// Custom classes
$container_classes = array( 'vertical-text' );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

if ( $element_type !== 'social' ) {
	$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
		'type'       => 'uncode_vertical_text',
		'id'         => $uncode_shortcode_id,
		'attributes' => array(
			'text_color'            => $text_color,
			'text_color_type'       => $text_color_type,
			'text_color_solid'      => $text_color_solid,
			'text_color_gradient'   => $text_color_gradient,
		)
	) );

	// Text color
	$text_color = uncode_get_shortcode_color_attribute_value( 'text_color', $uncode_shortcode_id, $text_color_type, $text_color, $text_color_solid, $text_color_gradient );

	if ( $text_color !== '' ) {
		$container_classes[] = 'text-' . $text_color . '-color';
	}


	// Font family
	if ( $text_font !== '' ) {
		$container_classes[] = $text_font;
	}

	// Text size
	if ( $text_size !== '' ) {
		$container_classes[] = $text_size;

		if ($text_size === 'bigtext') {
			$container_classes[] = 'heading-bigtext';
		}
	}

	// Line height
	if ( $text_height !== '' ) {
		$container_classes[] = $text_height;
	}

	// Letter spacing
	if ( $text_space !== '' ) {
		$container_classes[] = $text_space;
	}

	// Font weight
	if ( $text_weight !== '' ) {
		$container_classes[] = 'font-weight-' . $text_weight;
	}

	// Text transform
	if ( $text_transform !== '' ) {
		$container_classes[] = 'text-' . $text_transform;
	}

	// Font style
	if ( $text_italic !== '' ) {
		$container_classes[] = 'text-italic';
	}

	// Flip?
	$container_classes[] = $flip === 'yes' ? 'vertical-text--flip' : 'vertical-text--noflip';
}

if ( $element_type === 'social' ) {
	$container_classes[] = 'vertical-text--social';

	$socials = apply_filters( 'uncode_vc_socials', ot_get_option( '_uncode_social_list', '', false, true ) );
	$social_output = '';

	if ( isset( $socials ) && ! empty( $socials ) && count( $socials ) > 0 ) {
		foreach ( $socials as $index => $social ) {
			if ( $social['_uncode_social'] !== '' ) {
				$icon_class      = $socials_size !== '' ? 'social-icon--lead' : '';
				$social_rel      = apply_filters( 'uncode_social_link_rel', '' );
				$social_rel_html = $social_rel !== '' ? ' rel="' . esc_attr( $social_rel ) . '"' : '';
				$social_output   .= '<div class="social-icon '. $icon_class . '"><a href="'.esc_url($social['_uncode_link']).'" target="_blank"' . $social_rel_html . '><i class="'.esc_attr($social['_uncode_social']).'"></i></a></div>';
			}
		}
	}
}

// Position
$position = $position === 'right' ? 'right' : 'left';
$container_classes[] = 'vertical-text--' . $position;

// Fixed?
if ( $fixed === 'yes' ) {
	$container_classes[] = 'vertical-text--fixed';

	// Add shift classes for body frame
	if ( $position === 'left' ) {
		$container_classes[] = 'vertical-text--shift-left';
	} else {
		$container_classes[] = 'vertical-text--shift-right';
	}

	if ( $text_align === 'top' ) {
		$container_classes[] = 'vertical-text--shift-top';
	} else if ( $text_align === 'bottom' ) {
		$container_classes[] = 'vertical-text--shift-bottom';
	}
}

// Alignment
$text_align = $text_align ? $text_align : 'center';
$container_classes[] = 'vertical-text--' . $text_align;

// Horizontal shift
$shift_to_add = $position === 'right' ? '_right' : '';

switch ( $vertical_text_h_pos ) {
	case 1:
		$container_classes[] = 'shift' . $shift_to_add . '_x_half';
	break;
	case 2:
		$container_classes[] = 'shift' . $shift_to_add . '_x_single';
	break;
	case 3:
		$container_classes[] = 'shift' . $shift_to_add . '_x_double';
	break;
	case 4:
		$container_classes[] = 'shift' . $shift_to_add . '_x_triple';
	break;
	case 5:
		$container_classes[] = 'shift' . $shift_to_add . '_x_quad';
	break;
	case -1:
		$container_classes[] = 'shift' . $shift_to_add . '_x_neg_half';
	break;
	case -2:
		$container_classes[] = 'shift' . $shift_to_add . '_x_neg_single';
	break;
	case -3:
		$container_classes[] = 'shift' . $shift_to_add . '_x_neg_double';
	break;
	case -4:
		$container_classes[] = 'shift' . $shift_to_add . '_x_neg_triple';
	break;
	case -5:
		$container_classes[] = 'shift' . $shift_to_add . '_x_neg_quad';
	break;
}

// Vertical shift
if ( $text_align === 'top' || $text_align === 'bottom' ) {
	if ( $text_align === 'top' ) {
		$padding_to_add = 'bottom';

		if ( $flip === 'yes' || $element_type === 'social' ) {
			$padding_to_add = 'top';
		}
	} else {
		$padding_to_add = 'top';

		if ( $flip === 'yes' || $element_type === 'social' ) {
			$padding_to_add = 'bottom';
		}
	}

	switch ( $vertical_text_v_pos ) {
		case 1:
			$container_classes[] = 'half-block-' . $padding_to_add. '-padding';
		break;
		case 2:
			$container_classes[] = 'single-block-' . $padding_to_add. '-padding';
		break;
		case 3:
			$container_classes[] = 'double-block-' . $padding_to_add. '-padding';
		break;
		case 4:
			$container_classes[] = 'triple-block-' . $padding_to_add. '-padding';
		break;
		case 5:
			$container_classes[] = 'quad-block-' . $padding_to_add. '-padding';
		break;
	}
}

// Z-index
if ( $fixed !== 'yes' && $z_index !== '0' && $z_index !== '' ) {
	$container_classes[] = 'z_index_' . str_replace( '-','neg_', $z_index );
}

// Difference
if ( $fixed === 'yes' && $difference === 'yes' ) {
	$container_classes[] = 'vertical-text--difference';
}

// Show on top?
if ( $fixed === 'yes' && $show_on_top === 'yes' ) {
	$container_classes[] = 'vertical-text--vis-show-top';
}

// Show after scroll?
if ( $fixed === 'yes' && $show_on_top !== 'yes' && $show_after_scroll === 'yes' ) {
	$container_classes[] = 'vertical-text--vis-after-scroll';
}

// Hide on bottom?
if ( $fixed === 'yes' && $show_on_top !== 'yes' && $hide_on_bottom === 'yes' ) {
	$container_classes[] = 'vertical-text--vis-hide-bottom';
}

// Responsive visibility
if ($desktop_visibility === 'yes') {
	$container_classes[] = 'desktop-hidden';
}
if ($medium_visibility === 'yes') {
	$container_classes[] = 'tablet-hidden';
}
if ($mobile_visibility === 'yes') {
	$container_classes[] = 'mobile-hidden';
}

$output.= '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '">';

if ( $element_type !== 'social' ) {
	$output.= uncode_remove_p_tag( $content );
	$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );
} else {
	$output.= uncode_remove_p_tag( $social_output );
}

$output.= '</div>';

echo uncode_switch_stock_string( $output );
