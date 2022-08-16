<?php
/**
 * Badge functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Prin menu badge item.
 */
function uncode_print_menu_badge_item( $item ) {
	global $front_background_colors;

	$badge_html = '';

	if ( ! empty( $item->badge_text ) ) {
		$badge_color     = isset( $item->badge_color ) && $item->badge_color ? $item->badge_color : 'accent';
		$badge_color_exa = '';
		$classes         = array( 'font-ui' );
		$style_text      = '';
		$style_bg        = '';

		if ( substr( $item->badge_color, 0, 1 ) === "#" ) {
			$badge_color_exa = sanitize_hex_color( $item->badge_color );
			$style_text          .= 'color:' . $badge_color_exa . ';';
		} else {
			if ( isset( $front_background_colors[$item->badge_color] ) ) {
				$badge_color_exa = $front_background_colors[$item->badge_color];
				$classes[]       = 'text-' . $item->badge_color . '-color';
			}
		}

		if ( $badge_color_exa ) {
			$badge_color_exa     = str_replace( ';nb',';b',$badge_color_exa );
			$badge_color_exa     = str_replace( ';n}',';}',$badge_color_exa );
			$badge_color_exa_rgb = sscanf( $badge_color_exa, "#%02x%02x%02x" );

			if ( $badge_color_exa_rgb && is_array( $badge_color_exa_rgb ) && isset( $badge_color_exa_rgb[0] ) && isset( $badge_color_exa_rgb[1] ) && isset( $badge_color_exa_rgb[2] ) ) {
				$style_bg .= 'background: rgba(' . $badge_color_exa_rgb[0] . ', ' . $badge_color_exa_rgb[1] . ', ' . $badge_color_exa_rgb[2] . ', .2) !important;';

			}

			$badge_html = '<span class="menu-badge ' . esc_attr( trim( implode( ' ', $classes ) ) ) . '" style="' . esc_attr( $style_text ) . '"><span class="menu-badge__text" style="' . esc_attr( $style_bg ) . '">' . esc_html( $item->badge_text ) . '</span></span>';
		}
	}

	return $badge_html;
}
