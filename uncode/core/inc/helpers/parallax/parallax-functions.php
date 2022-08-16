<?php
/**
 * Parallax functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get parallax data from settings.
 */
function uncode_get_parallax_div_data( $speed, $centered, $implode = false ) {
	$div_data = array();

	if ( $centered !== 'yes' ) {
		$div_data['data-rellax-percentage'] = '0.5';
	}

	switch ( $speed ) {
		case 1:
			$div_data['data-rellax-speed'] = '0.5';
			break;

		case 2:
			$div_data['data-rellax-speed'] = '1';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '0.5';
				$div_data['data-rellax-mobile-speed'] = '0.5';
			}
			break;

		case 3:
			$div_data['data-rellax-speed'] = '2';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '0.5';
				$div_data['data-rellax-mobile-speed'] = '0.5';
			}
			break;

		case 4:
			$div_data['data-rellax-speed'] = '3';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '1';
				$div_data['data-rellax-mobile-speed'] = '1';
			}
			break;

		case 5:
			$div_data['data-rellax-speed'] = '4';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '1.5';
				$div_data['data-rellax-mobile-speed'] = '1.5';
			}
			break;

		case 6:
			$div_data['data-rellax-speed'] = '5';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '2';
				$div_data['data-rellax-mobile-speed'] = '2';
			}
			break;

		case 7:
			$div_data['data-rellax-speed'] = '6';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '2';
				$div_data['data-rellax-mobile-speed'] = '2';
			}
			break;

		case 8:
			$div_data['data-rellax-speed'] = '7';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '2.5';
				$div_data['data-rellax-mobile-speed'] = '2.5';
			}
			break;

		case 9:
			$div_data['data-rellax-speed'] = '8';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '2.5';
				$div_data['data-rellax-mobile-speed'] = '2.5';
			}
			break;

		case 10:
			$div_data['data-rellax-speed'] = '9';
			if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {
				$div_data['data-rellax-xs-speed'] = '3';
				$div_data['data-rellax-mobile-speed'] = '3';
			}
			break;

		default:
			$div_data['data-rellax-speed'] = '0.5';
			break;

	}

	if ( apply_filters( 'uncode_mobile_parallax_animation_allowed', false ) ) {

	}

	if ( $implode ) {
		$div_data_attributes = array_map( function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys( $div_data ) );
		$div_data = implode( ' ', $div_data_attributes );
	}

	return $div_data;
}
