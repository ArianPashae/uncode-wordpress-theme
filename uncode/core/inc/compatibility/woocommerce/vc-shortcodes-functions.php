<?php
/**
 * VC related functions used in shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Transform int size to a grid value
 */
function uncode_woocommerce_get_grid_col_size( $size ) {
	$default_sizes= array(
		1  => '1/12',
		2  => '1/6',
		3  => '1/4',
		4  => '1/3',
		5  => '5/12',
		6  => '1/2',
		7  => '7/12',
		8  => '2/3',
		9  => '3/4',
		10 => '5/6',
		11 => '11/12',
	);

	if ( isset( $default_sizes[ $size ] ) ) {
		$size = $default_sizes[ $size ];
	} else {
		$size = '2/3';
	}

	return $size;
}

/**
 * Inject HTML classes
 */
function uncode_woocommerce_inject_classes( $html, $args ) {
	if ( isset( $args[ 'id' ] ) ) {
		switch ( $args[ 'id' ] ) {
			case 'cart':
				// titles
				if ( isset( $args[ 'title' ] ) && is_array( $args[ 'title' ] ) ) {
					$h2_classes = implode( ' ', $args[ 'title' ] );
					$html = str_replace( '<h2', '<h2 class="' . esc_attr( $h2_classes ) . '"', $html );
				}

				// buttons
				if ( isset( $args[ 'button' ] ) && is_array( $args[ 'button' ] ) ) {
					$button_classes = implode( ' ', $args[ 'button' ] );
					$html           = str_replace( 'btn-default', '', $html );
					$html           = str_replace( 'checkout-button', 'checkout-button ' . esc_attr( $button_classes ), $html );
				}

				$html = str_replace( 'UNCODE_INJECTOR_PLACEHOLDER', json_encode( $args ), $html );

				break;

			case 'checkout':
				// titles
				if ( isset( $args[ 'title' ] ) && is_array( $args[ 'title' ] ) ) {
					$h3_classes = implode( ' ', $args[ 'title' ] );
					$html = str_replace( '<h3', '<h3 class="' . esc_attr( $h3_classes ) . '"', $html );
				}

				// buttons
				if ( isset( $args[ 'button' ] ) && is_array( $args[ 'button' ] ) ) {
					$button_classes = implode( ' ', $args[ 'button' ] );
					$html           = str_replace( 'btn-hidden', '', $html );
					$html           = str_replace( 'btn-default', '', $html );
					$html           = str_replace( 'checkout-button', 'checkout-button ' . esc_attr( $button_classes ), $html );
				}

				$html = str_replace( 'UNCODE_INJECTOR_PLACEHOLDER', json_encode( $args ), $html );

				break;

			case 'pay-order':
				// buttons
				if ( isset( $args[ 'button' ] ) && is_array( $args[ 'button' ] ) ) {
					$button_classes = implode( ' ', $args[ 'button' ] );
					$html           = str_replace( 'btn-hidden', '', $html );
					$html           = str_replace( 'btn-default', '', $html );
					$html           = str_replace( 'checkout-button', 'checkout-button ' . esc_attr( $button_classes ), $html );
				}

				break;

			case 'order-received':
				// titles
				if ( isset( $args[ 'title' ] ) && is_array( $args[ 'title' ] ) ) {
					$h3_classes = implode( ' ', $args[ 'title' ] );
					$html = str_replace( '<h3', '<h3 class="' . esc_attr( $h3_classes ) . '"', $html );
					$html = str_replace( '<h2', '<h2 class="' . esc_attr( $h3_classes ) . '"', $html );
				}

				break;
		}
	}

	return $html;
}

/**
 * Alter default WC conditional functions so is_cart() and is_checkout()
 * will be true when using our custom WC modules on multiple pages
 */
function uncode_woocommerce_conditional_functions() {
	if ( is_page() ) {
		$page_id = get_queried_object_id();

		if ( $page_id > 0 ) {
			$post            = get_post( $page_id );
			$post_content    = isset( $post->post_content ) ? $post->post_content : false;
			$shortcode_found = false;

			// Check default content
			$shortcode_found = uncode_woocommerce_activate_wc_constants( $post_content );

			if ( $shortcode_found ) {
				return;
			}

			// Check content blocks in content
			if ( strpos( $post_content, '[uncode_block' ) !== false ) {
				$regex = '/\[uncode_block(.*?)\]/';
				$regex_attr = '/(.*?)=\"(.*?)\"/';
				preg_match_all( $regex, $post_content, $matches, PREG_SET_ORDER );

				foreach ( $matches as $key => $value ) {
					if (isset( $value[ 1 ] ) ) {
						preg_match_all( $regex_attr, trim( $value[ 1 ] ), $matches_attr, PREG_SET_ORDER );

						foreach ( $matches_attr as $key_attr => $value_attr ) {
							if ( 'id' === trim( $value_attr[ 1 ] ) ) {
								$cb_id           = $value_attr[ 2 ];
								$uncode_block    = get_post_field( 'post_content', $cb_id );
								$shortcode_found = uncode_woocommerce_activate_wc_constants( $uncode_block );

								if ( $shortcode_found ) {
									return;
								}
							}
						}
					}
				}
			}

			// Get post meta
			$metabox_data = get_post_meta( $page_id );

			// Check content blocks in header
			if ( isset( $metabox_data[ '_uncode_header_type' ][ 0 ] ) && $metabox_data[ '_uncode_header_type' ][ 0 ] === 'header_uncodeblock' ) {
				if ( isset( $metabox_data[ '_uncode_blocks_list' ][ 0 ] ) && $metabox_data[ '_uncode_blocks_list' ][ 0 ] !== '' ) {
					$cb_id           = $metabox_data[ '_uncode_blocks_list' ][ 0 ];
					$uncode_block    = get_post_field( 'post_content', $cb_id );
					$shortcode_found = uncode_woocommerce_activate_wc_constants( $uncode_block );

					if ( $shortcode_found ) {
						return;
					}
				}
			}

			// Check content blocks in footer
			if ( isset( $metabox_data[ '_uncode_specific_footer_block' ][ 0 ] ) && $metabox_data[ '_uncode_specific_footer_block' ][ 0 ] !== '' ) {
				$cb_id           = $metabox_data[ '_uncode_specific_footer_block' ][ 0 ];
				$uncode_block    = get_post_field( 'post_content', $cb_id );
				$shortcode_found = uncode_woocommerce_activate_wc_constants( $uncode_block );

				if ( $shortcode_found ) {
					return;
				}
			}
		}
	}
}
add_action( 'template_redirect', 'uncode_woocommerce_conditional_functions' );

/**
 * Check if content has a WC shortcode and activate its constants
 */
function uncode_woocommerce_activate_wc_constants( $content ) {
	$found = false;

	if ( strpos( $content, '[uncode_woocommerce_cart' ) !== false ) {
		wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
		$found = true;

	} else if ( strpos( $content, '[uncode_woocommerce_checkout' ) !== false ) {
		wc_maybe_define_constant( 'WOOCOMMERCE_CHECKOUT', true );
		$found = true;
	}

	return $found;
}

/**
 * Remove form tag fom HTML (to avoid nested forms)
 */
function uncode_woocommerce_remove_form_tag( $html ) {
	$html = str_replace( '<form', '<div', $html );
	$html = str_replace( '</form', '</div', $html );

	return $html;
}

/**
 * Parse login and coupon forms and make the following changes:
 *     - No form tag
 *     - IDs with uncode-wc prefix (to avoid duplicate IDs on the same page)
 *     - No nonce (to avoid duplicate IDs on the same page)
 *     - No redirect and referer hidden input
 *     - Add special classes to the button
 */
function uncode_woocommerce_parse_forms( $html, $button_classes ) {
	$html = uncode_woocommerce_remove_form_tag( $html );
	$html = str_replace( 'id="username"', 'id="uncode-wc-input-username"', $html );
	$html = str_replace( 'id="password"', 'id="uncode-wc-input-password"', $html );
	$html = str_replace( 'id="rememberme"', 'id="uncode-wc-input-rememberme"', $html );
	$html = str_replace( 'id="woocommerce-login-nonce"', 'id="uncode-wc-input-woocommerce-login-nonce"', $html );
	$html = str_replace( 'name="redirect"', '', $html );
	$html = str_replace( 'name="_wp_http_referer"', '', $html );
	$html = str_replace( 'class="button', 'class="button ' . implode( ' ', $button_classes ), $html );
	$html = str_replace( 'woocommerce-form-login__submit', 'woocommerce-form-login__submit ' . implode( ' ', $button_classes ), $html );

	return $html;
}

/**
 * Replace carousel cols
 */
function uncode_woocommerce_parse_carousel_cols( $html, $args ) {
	if ( isset( $args[ 'md' ] ) ) {
		$html = str_replace( 'data-md="2"', 'data-md="' . $args[ 'md' ] . '"', $html );
	}

	if ( isset( $args[ 'sm' ] ) ) {
		$html = str_replace( 'data-sm="2"', 'data-sm="' . $args[ 'sm' ] . '"', $html );
	}

	if ( isset( $args[ 'skin' ] ) && $args[ 'skin' ] === 'dark' ) {
		$html = str_replace( 'tmb-light', 'tmb-dark', $html );
	}

	return $html;
}

/**
 * Print single row
 */
function uncode_woocommerce_print_single_row( $settings, $notices, $content, $class ) {
	$override_padding = isset( $settings[ 'override_padding' ] ) ? $settings[ 'override_padding' ] : false;
	$column_padding   = isset( $settings[ 'column_padding' ] ) ? $settings[ 'column_padding' ] : 2;
	$style            = isset( $settings[ 'style' ] ) ? $settings[ 'style' ] : false;
	$back_color       = isset( $settings[ 'back_color' ] ) ? $settings[ 'back_color' ] : false;
	$shadow           = isset( $settings[ 'shadow' ] ) ? $settings[ 'shadow' ] : false;
	$shadow_darker    = isset( $settings[ 'shadow_darker' ] ) ? $settings[ 'shadow_darker' ] : false;
	$radius           = isset( $settings[ 'radius' ] ) ? $settings[ 'radius' ] : false;

	$row = '[vc_column_inner';

	// custom padding
	if ( $override_padding ) {
		$row .= ' override_padding="yes"';
		$row .= ' column_padding="' . absint( $column_padding ) . '"';
	}

	// skin
	if ( $style ) {
		$row .= ' style="' . esc_attr( $style ) . '"';
	}

	// background color
	if ( $back_color ) {
		$row .= ' back_color="' . esc_attr( $back_color ) . '"';
	}

	// shadow
	if ( $shadow ) {
		$row .= ' shadow="' . esc_attr( $shadow ) . '"';

		if ( $shadow_darker ) {
			$row .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $radius ) {
		$row .= ' radius="' . esc_attr( $radius ) . '"';
	}

	$row .= ']';

	// append notices
	$row .= '<div class="uncode-wc-module__notices">';
	$row .= $notices;
	$row .= '</div>';

	if ( $content ) {
		$row .= $content;
	}

	$row .= '[/vc_column_inner]';

	$output = '[vc_row_inner el_class="uncode-wc-module__row '. $class . '"]';
	$output .= $row;
	$output .= '[/vc_row_inner]';

	return $output;
}

/**
 * Get titles conf
 */
function uncode_woocommerce_get_titles_conf( $settings ) {
	$conf = array();

	if ( $settings[ 'font_family' ] ) {
		$conf[] = $settings[ 'font_family' ];
	}

	$conf[] = $settings[ 'font_size' ];

	if ( $settings[ 'font_weight' ] ) {
		$conf[] = 'font-weight-' . $settings[ 'font_weight' ];
	}

	if ( $settings[ 'font_transform' ] ) {
		$conf[] = 'text-' . $settings[ 'font_transform' ];
	}

	if ( $settings[ 'font_height' ] ) {
		$conf[] = $settings[ 'font_height' ];
	}

	if ( $settings[ 'font_space' ] ) {
		$conf[] = $settings[ 'font_space' ];
	}

	return $conf;
}

/**
 * Get buttons conf
 */
function uncode_woocommerce_get_buttons_conf_classes( $settings ) {
	$conf = array();

	if ( isset( $settings[ 'activate_buttons' ] ) && ! $settings[ 'activate_buttons' ] ) {
		$conf[ 'button_color' ] = 'btn-default';

		return $conf;
	}

	foreach ( $settings as $key => $value ) {
		switch ( $key ) {
			case 'button_color':
				$new_value = 'btn-' . $settings[ 'button_color' ];
				break;

			case 'button_wide':
				$new_value = 'btn-block';
				break;

			case 'button_outline':
				$new_value = 'btn-outline';
				break;

			case 'button_text_skin':
				$new_value = 'btn-text-skin';
				break;

			case 'button_shadow':
				$new_value = 'btn-shadow';
				break;

			case 'button_shadow_weight':
				$new_value = 'btn-shadow-'. $settings[ 'button_shadow_weight' ];
				break;

			case 'button_custom_typo':
				$new_value = 'btn-custom-typo';
				break;

			case 'button_font_weight':
				$new_value = 'font-weight-' . $settings[ 'button_font_weight' ];
				break;

			case 'button_text_transform':
				$new_value = 'text-' . $settings[ 'button_text_transform' ];
				break;

			case 'button_border_width':
				$new_value = 'border-width-' . $settings[ 'button_border_width' ];
				break;

			case 'button_hover_fx':
				$new_value = $settings[ 'button_hover_fx' ] === 'full-colored' ? 'btn-flat' : $settings[ 'button_hover_fx' ];
				break;

			default:
				$new_value = $value;
				break;
		}

		$conf[ $key ] = $value ? $new_value : '';
	}

	if ( ! $conf[ 'button_color' ] ) {
		$conf[ 'button_color' ] = 'btn-default';
	}

	if ( ! $settings[ 'button_custom_typo' ] ) {
		$conf[ 'button_font_family' ]    = '';
		$conf[ 'button_font_weight' ]    = '';
		$conf[ 'button_text_transform' ] = '';
		$conf[ 'button_letter_spacing' ] = '';
	}

	return $conf;
}

/**
 * Get derivated buttons conf
 */
function uncode_woocommerce_get_derivated_buttons_conf_classes( $settings ) {
	$conf = array();

	foreach ( $settings as $key => $value ) {
		switch ( $key ) {
			case 'button_color':
			case 'button_size':
			case 'button_link_size':
			case 'button_wide':
			case 'button_hover_fx':
			case 'button_outline':
			case 'button_text_skin':
			case 'button_shadow':
			case 'button_shadow_weight':
			case 'button_border_width':
				continue 2;
				break;
		}

		$conf[ $key ] = $value;
	}

	return $conf;
}

/**
 * Get button classes
 */
function uncode_woocommerce_get_button_classes( $conf ) {
	$classes = array_values( array_filter( $conf ) );

	return $classes;
}

/**
 * Get off grid classes
 */
function uncode_woocommerce_get_off_grid_classes( $shift_x, $shift_y, $shift_y_down ) {
	$classes = array();

	switch ( $shift_x ) {
		case 1:
			$classes[] = 'shift_x_half';
			break;
		case 2:
			$classes[] = 'shift_x_single';
			break;
		case 3:
			$classes[] = 'shift_x_double';
			break;
		case 4:
			$classes[] = 'shift_x_triple';
			break;
		case 5:
			$classes[] = 'shift_x_quad';
			break;
		case -1:
			$classes[] = 'shift_x_neg_half';
			break;
		case -2:
			$classes[] = 'shift_x_neg_single';
			break;
		case -3:
			$classes[] = 'shift_x_neg_double';
			break;
		case -4:
			$classes[] = 'shift_x_neg_triple';
			break;
		case -5:
			$classes[] = 'shift_x_neg_quad';
			break;
	}

	switch ( $shift_y ) {
		case 1:
			$classes[] = 'shift_y_half';
			break;
		case 2:
			$classes[] = 'shift_y_single';
			break;
		case 3:
			$classes[] = 'shift_y_double';
			break;
		case 4:
			$classes[] = 'shift_y_triple';
			break;
		case 5:
			$classes[] = 'shift_y_quad';
			break;
		case -1:
			$classes[] = 'shift_y_neg_half';
			break;
		case -2:
			$classes[] = 'shift_y_neg_single';
			break;
		case -3:
			$classes[] = 'shift_y_neg_double';
			break;
		case -4:
			$classes[] = 'shift_y_neg_triple';
			break;
			case -5:
			$classes[] = 'shift_y_neg_quad';
		break;
	}

	switch ( $shift_y_down ) {
		case 1:
			$classes[] = 'shift_y_down_half';
			break;
		case 2:
			$classes[] = 'shift_y_down_single';
			break;
		case 3:
			$classes[] = 'shift_y_down_double';
			break;
		case 4:
			$classes[] = 'shift_y_down_triple';
			break;
		case 5:
			$classes[] = 'shift_y_down_quad';
			break;
		case -1:
			$classes[] = 'shift_y_down_neg_half';
			break;
		case -2:
			$classes[] = 'shift_y_down_neg_single';
			break;
		case -3:
			$classes[] = 'shift_y_down_neg_double';
			break;
		case -4:
			$classes[] = 'shift_y_down_neg_triple';
			break;
		case -5:
			$classes[] = 'shift_y_down_neg_quad';
			break;
	}

	return $classes;
}
