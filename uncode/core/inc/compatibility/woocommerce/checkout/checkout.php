<?php
/**
 * Checkout output (for the Uncode WooCommerce Checkout module)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

uncode_woocommerce_enqueue_checkout_script();

$shortcode_id = rand();

$injector_conf[ 'id' ]    = 'checkout';
$injector_conf[ 'title' ] = array();

// Titles
$titles_conf = array(
	'font_family'    => $titles_font,
	'font_size'      => $titles_size,
	'font_weight'    => $titles_weight,
	'font_transform' => $titles_transform,
	'font_height'    => $titles_height,
	'font_space'     => $titles_space,
);

if ( $custom_titles_typography ) {
	$injector_conf[ 'title' ] = uncode_woocommerce_get_titles_conf( $titles_conf );
}

if ( ! $checkout_form_show_titles ) {
	$container_classes[] = 'no-checkout-form-titles';
}

if ( ! $order_payment_show_titles ) {
	$container_classes[] = 'no-order-payment-titles';
}

// Compact layout
if ( $checkout_form_compact ) {
	$container_classes[] = 'form-compact-layout';
}

if ( $order_payment_form_compact ) {
	$container_classes[] = 'order-payment-compact-layout';
}

// Specific class for this page
$container_classes[] = 'uncode-wc-checkout-page';

// Forms inside forms?
$container_classes[] = $forms_inside_main_area ? 'uncode-wc-checkout--forms-inside' : 'uncode-wc-checkout--forms-outside';

// Layout
$container_classes[] = 'uncode-wc-checkout--' . $checkout_layout;

$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" data-id="' . esc_attr( $shortcode_id ) . '">'; // Open main wrapper

// Flag for the custom class appended to the first row
$first_row_printed = false;

// Check if the notices have been printed
$notices_printed = false;

// Main column settings
$main_column_settings = array(
	'override_padding' => $checkout_form_override_padding,
	'column_padding'   => $checkout_form_column_padding,
	'style'            => $checkout_form_style,
	'back_color'       => $checkout_form_back_color,
	'shadow'           => $checkout_form_shadow,
	'shadow_darker'    => $checkout_form_shadow_darker,
	'radius'           => $checkout_form_radius,
);

// From WC_Shortcode_Checkout::checkout

ob_start(); // edited by Uncode

// Show non-cart errors.
do_action( 'woocommerce_before_checkout_form_cart_notices' );

$notices = ob_get_clean(); // edited by Uncode

if ( $notices === '<div class="woocommerce-notices-wrapper"></div>' ) { // edited by Uncode
	$notices = false;
}

// Check cart has contents.
if ( WC()->cart->is_empty() && ! is_customize_preview() && apply_filters( 'woocommerce_checkout_redirect_empty_cart', true ) ) {
	$output .= '</div>'; // Close main wrapper
	return;
}

// Check cart contents for errors.
do_action( 'woocommerce_check_cart_items' );

// Calc totals.
WC()->cart->calculate_totals();

// Get checkout object.
$checkout = WC()->checkout();

if ( empty( $_POST ) && wc_notice_count( 'error' ) > 0 ) { // WPCS: input var ok, CSRF ok.

	if ( ! $first_row_printed ) {
		$first_row_class   = 'uncode-wc-module__row--first';
		$first_row_printed = true;
	} else {
		$first_row_class = '';
	}

	$row_content = '<div class="woocommerce">' . wc_get_template_html( 'checkout/cart-errors.php', array( 'checkout' => $checkout ) ) . '</div>';

	// Append a row before using the main column settings
	$output .= uncode_woocommerce_print_single_row( $main_column_settings, false, $row_content, $first_row_class );

	wc_clear_notices();

} else {

	if ( $forms_inside_main_area ) {
		// Login
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
		add_action( 'uncode_woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
		add_action( 'woocommerce_after_checkout_form', 'uncode_woocommerce_checkout_login_form' );

		// Coupon
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		add_action( 'uncode_woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}

	if ( ! $forms_inside_main_area || apply_filters( 'uncode_woocommerce_append_row_before_checkout_form', false ) ) {
		// Append a row before the main block (use main column settings)
		if ( $notices ) {
			$notices_printed = true;
		}

		if ( ! $first_row_printed ) {
			$first_row_class   = 'uncode-wc-module__row--first';
			$first_row_printed = true;
		} else {
			$first_row_class = '';
		}

		$row_content = wc_get_template_html( 'checkout/uncode-before-checkout.php', array( 'checkout' => $checkout ) );

		$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_content, $first_row_class );
	} else {
		$output .= wc_get_template_html( 'checkout/uncode-before-checkout.php', array( 'checkout' => $checkout ) );
	}

	$output .= wc_get_template_html( 'checkout/uncode-open-checkout-form.php', array( 'checkout' => $checkout ) );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {

		$output .= esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

	} else {

		/********************************
		 * Checkout Form column
		 ********************************/
		$checkout_form_output = '[vc_column_inner';

		// col classes
		$checkout_form_col_classes   = array();
		$checkout_form_uncol_classes = array();

		// size
		if ( $checkout_layout === 'horizontal' ) {
			$checkout_form_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $checkout_main_area_size ) . '"';
		}

		// custom padding
		if ( $checkout_form_override_padding ) {
			$checkout_form_output .= ' override_padding="yes"';
			$checkout_form_output .= ' column_padding="' . absint( $checkout_form_column_padding ) . '"';
		}

		// skin
		if ( $checkout_form_style ) {
			$checkout_form_output .= ' style="' . esc_attr( $checkout_form_style ) . '"';
		}

		// background color
		if ( $checkout_form_back_color ) {
			$checkout_form_output .= ' back_color="' . esc_attr( $checkout_form_back_color ) . '"';
		}

		// sticky
		if ( $checkout_form_sticky && ! $order_payment_sticky && ! $equal_height ) {
			$checkout_form_output .= ' sticky="yes"';
		}

		// shadow
		if ( $checkout_form_shadow ) {
			$checkout_form_output .= ' shadow="' . esc_attr( $checkout_form_shadow ) . '"';

			if ( $checkout_form_shadow_darker ) {
				$checkout_form_output .= ' shadow_darker="yes"';
			}
		}

		// radius
		if ( $checkout_form_radius ) {
			$checkout_form_output .= ' radius="' . esc_attr( $checkout_form_radius ) . '"';
		}

		// off grid
		if ( $checkout_layout === 'horizontal' && $checkout_form_activate_off_grid ) {
			$checkout_form_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $checkout_form_shift_x, $checkout_form_shift_y, $checkout_form_shift_y_down );

			$checkout_form_uncol_classes = array_merge( $checkout_form_uncol_classes, $checkout_form_off_grid_classes );

			$checkout_form_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $checkout_form_off_grid_classes ) ) ) . '"';

			if ( $checkout_form_shift_y_down ) {
				$checkout_form_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
			}

			if ( $checkout_form_z_index ) {
				$checkout_form_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $checkout_form_z_index );
			}
		}

		// col classes
		if ( count( $checkout_form_uncol_classes ) > 0 && ! empty( $checkout_form_uncol_classes ) ) {
			$checkout_form_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $checkout_form_uncol_classes ) ) ) . '"';
		}

		if ( count( $checkout_form_col_classes ) > 0 && ! empty( $checkout_form_col_classes ) ) {
			$checkout_form_output .= ' el_class="' . esc_attr( trim( implode( ' ', $checkout_form_col_classes ) ) ) . '"';
		}

		$checkout_form_output .= ']';

		if ( $forms_inside_main_area ) {
			$checkout_form_output .= '<div class="uncode-wc-module__notices">';

			// append notices
			if ( $notices && ! $notices_printed ) {
				$checkout_form_output .= $notices;
			}

			$checkout_form_output .= '</div>';
		}

		ob_start();
		do_action( 'uncode_woocommerce_before_checkout_form', $checkout );
		$before_checkout_form = ob_get_clean();

		if ( $forms_inside_main_area || apply_filters( 'uncode_woocommerce_parse_html_inside_forms', false ) ) {
			$before_checkout_form = uncode_woocommerce_parse_forms( $before_checkout_form, $derivated_buttons_classes );
		}

		$checkout_form_output .= $before_checkout_form;

		$checkout_form_output .= wc_get_template_html( 'checkout/uncode-checkout-form.php', array( 'checkout' => $checkout ) );

		ob_start();
		do_action( 'uncode_woocommerce_after_checkout_form', $checkout );
		$after_checkout_form = ob_get_clean();

		if ( $forms_inside_main_area || apply_filters( 'uncode_woocommerce_parse_html_inside_forms', false ) ) {
			$after_checkout_form = uncode_woocommerce_parse_forms( $after_checkout_form, $derivated_buttons_classes );
		}

		$checkout_form_output .= $after_checkout_form;

		$checkout_form_output .= '[/vc_column_inner]';

		/********************************
		 * Order Payment column
		 ********************************/
		$order_payment_output = '[vc_column_inner';

		// col classes
		$order_payment_col_classes   = array();
		$order_payment_uncol_classes = array();

		// size
		if ( $checkout_layout === 'horizontal' ) {
			$order_payment_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $checkout_sidebar_size ) . '"';
		}

		// custom padding
		if ( $order_payment_override_padding ) {
			$order_payment_output .= ' override_padding="yes"';
			$order_payment_output .= ' column_padding="' . absint( $order_payment_column_padding ) . '"';
		}

		// skin
		if ( $order_payment_style ) {
			$order_payment_output .= ' style="' . esc_attr( $order_payment_style ) . '"';
		}

		// background color
		if ( $order_payment_back_color ) {
			$order_payment_output .= ' back_color="' . esc_attr( $order_payment_back_color ) . '"';
		}

		// sticky
		if ( $order_payment_sticky && ! $equal_height ) {
			$order_payment_output .= ' sticky="yes"';
		}

		// shadow
		if ( $order_payment_shadow ) {
			$order_payment_output .= ' shadow="' . esc_attr( $order_payment_shadow ) . '"';

			if ( $order_payment_shadow_darker ) {
				$order_payment_output .= ' shadow_darker="yes"';
			}
		}

		// radius
		if ( $order_payment_radius ) {
			$order_payment_output .= ' radius="' . esc_attr( $order_payment_radius ) . '"';
		}

		// off grid
		if ( $checkout_layout === 'horizontal' && $order_payment_activate_off_grid ) {
			$order_payment_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $order_payment_shift_x, $order_payment_shift_y, $order_payment_shift_y_down );

			$order_payment_uncol_classes = array_merge( $order_payment_uncol_classes, $order_payment_off_grid_classes );

			$order_payment_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $order_payment_off_grid_classes ) ) ) . '"';

			if ( $order_payment_shift_y_down ) {
				$order_payment_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
			}

			if ( $order_payment_z_index ) {
				$order_payment_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $order_payment_z_index );
			}
		}

		// col classes
		if ( count( $order_payment_uncol_classes ) > 0 && ! empty( $order_payment_uncol_classes ) ) {
			$order_payment_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $order_payment_uncol_classes ) ) ) . '"';
		}

		if ( count( $order_payment_col_classes ) > 0 && ! empty( $order_payment_col_classes ) ) {
			$order_payment_output .= ' el_class="' . esc_attr( trim( implode( ' ', $order_payment_col_classes ) ) ) . '"';
		}

		$order_payment_output .= ']';

		$order_payment_output .= wc_get_template_html( 'checkout/uncode-checkout-order-payment.php', array( 'checkout' => $checkout ) );
		$order_payment_output .= '<script type="text/javascript">var uncode_wc_checkout_injector_' . $shortcode_id . ' = UNCODE_INJECTOR_PLACEHOLDER;</script>';

		$order_payment_output .= '[/vc_column_inner]';

		if ( ! $first_row_printed ) {
			$first_row_class   = 'uncode-wc-module__row--first';
			$first_row_printed = true;
		} else {
			$first_row_class = '';
		}

		// Build grid
		if ( $checkout_layout === 'horizontal' ) {

			// Build inner row
			$row_inner = '[vc_row_inner el_class="uncode-wc-module__row '. $first_row_class . '" gutter_size="' . absint( $checkout_columns_gap ) . '"';

			if ( $equal_height ) {
				$row_inner .= ' equal_height="yes"';
			}

			$row_inner .= ']';
			$output .= $row_inner;

			// Checkout Form
			$output .= $checkout_form_output;

			// Order Payment
			$output .= $order_payment_output;

			$output .= '[/vc_row_inner]';

		} else {

			// Checkout Form
			$output .= '[vc_row_inner el_class="uncode-wc-module__row '. $first_row_class . '"]';
			$output .= $checkout_form_output;
			$output .= '[/vc_row_inner]';

			// Order Payment
			$output .= '[vc_row_inner el_class="uncode-wc-module__row"]';
			$output .= $order_payment_output;
			$output .= '[/vc_row_inner]';

		}
	}

	$output .= wc_get_template_html( 'checkout/uncode-close-checkout-form.php', array( 'checkout' => $checkout ) );

	if ( apply_filters( 'uncode_woocommerce_append_row_after_checkout_form', false ) ) {
		// Append a row after the main block (use main column settings)
		if ( ! $first_row_printed ) {
			$first_row_class   = 'uncode-wc-module__row--first';
			$first_row_printed = true;
		} else {
			$first_row_class = '';
		}

		$row_content = wc_get_template_html( 'checkout/uncode-after-checkout.php', array( 'checkout' => $checkout ) );

		$output .= uncode_woocommerce_print_single_row( $main_column_settings, false, $row_content, $first_row_class );
	} else {
		$output .= wc_get_template_html( 'checkout/uncode-after-checkout.php', array( 'checkout' => $checkout ) );
	}
}

$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );

$output .= '</div>';

$output = uncode_woocommerce_inject_classes( $output, $injector_conf );
