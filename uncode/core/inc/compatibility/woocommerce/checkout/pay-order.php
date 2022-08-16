<?php
/**
 * Pay for Order output (for the Uncode WooCommerce Checkout module)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

uncode_woocommerce_enqueue_checkout_script();

$shortcode_id = rand();

$injector_conf[ 'id' ] = 'pay-order';

$container_classes[] = 'uncode-wc-pay-order';
$container_classes[] = $forms_inside_main_area ? 'uncode-wc-checkout--forms-inside' : 'uncode-wc-checkout--forms-outside';

// Layout
$container_classes[] = 'uncode-wc-checkout--' . $checkout_layout;

// Compact layout
if ( $order_payment_form_compact ) {
	$container_classes[] = 'order-payment-compact-layout';
}

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

// From WC_Shortcode_Checkout::order_pay

ob_start(); // edited by Uncode

do_action( 'before_woocommerce_pay' );

$notices = ob_get_clean(); // edited by Uncode

if ( $notices === '<div class="woocommerce-notices-wrapper"></div>' ) { // edited by Uncode
	$notices = false;
}

$order_id = absint( $order_id );

// Pay for existing order.
if ( isset( $_GET['pay_for_order'], $_GET['key'] ) && $order_id ) { // WPCS: input var ok, CSRF ok.
	try {
		$order_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$order     = wc_get_order( $order_id );

		// Order or payment link is invalid.
		if ( ! $order || $order->get_id() !== $order_id || ! hash_equals( $order->get_order_key(), $order_key ) ) {
			throw new Exception( __( 'Sorry, this order is invalid and cannot be paid for.', 'woocommerce' ) );
		}

		// Logged out customer does not have permission to pay for this order.
		if ( ! current_user_can( 'pay_for_order', $order_id ) && ! is_user_logged_in() ) {
			ob_start(); // edited by Uncode
			echo '<div class="woocommerce-info">' . esc_html__( 'Please log in to your account below to continue to the payment form.', 'woocommerce' ) . '</div>';
			woocommerce_login_form(
				array(
					'redirect' => $order->get_checkout_payment_url(),
				)
			);

			// BEGIN Uncode edit
			$login_form = ob_get_clean(); // edited by Uncode

			// Append a row before the main block (use main column settings)
			$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $login_form, 'uncode-wc-module__row--first' );

			$output .= '</div>'; // close main wrapper

			return $output;
			// END Uncode edit
		}

		// Logged in customer trying to pay for someone else's order.
		if ( ! current_user_can( 'pay_for_order', $order_id ) ) {
			throw new Exception( __( 'This order cannot be paid for. Please contact us if you need assistance.', 'woocommerce' ) );
		}

		// Does not need payment.
		if ( ! $order->needs_payment() ) {
			/* translators: %s: order status */
			throw new Exception( sprintf( __( 'This order&rsquo;s status is &ldquo;%s&rdquo;&mdash;it cannot be paid for. Please contact us if you need assistance.', 'woocommerce' ), wc_get_order_status_name( $order->get_status() ) ) );
		}

		// Ensure order items are still stocked if paying for a failed order. Pending orders do not need this check because stock is held.
		if ( ! $order->has_status( wc_get_is_pending_statuses() ) ) {
			$quantities = array();

			foreach ( $order->get_items() as $item_key => $item ) {
				if ( $item && is_callable( array( $item, 'get_product' ) ) ) {
					$product = $item->get_product();

					if ( ! $product ) {
						continue;
					}

					$quantities[ $product->get_stock_managed_by_id() ] = isset( $quantities[ $product->get_stock_managed_by_id() ] ) ? $quantities[ $product->get_stock_managed_by_id() ] + $item->get_quantity() : $item->get_quantity();
				}
			}

			foreach ( $order->get_items() as $item_key => $item ) {
				if ( $item && is_callable( array( $item, 'get_product' ) ) ) {
					$product = $item->get_product();

					if ( ! $product ) {
						continue;
					}

					if ( ! apply_filters( 'woocommerce_pay_order_product_in_stock', $product->is_in_stock(), $product, $order ) ) {
						/* translators: %s: product name */
						throw new Exception( sprintf( __( 'Sorry, "%s" is no longer in stock so this order cannot be paid for. We apologize for any inconvenience caused.', 'woocommerce' ), $product->get_name() ) );
					}

					// We only need to check products managing stock, with a limited stock qty.
					if ( ! $product->managing_stock() || $product->backorders_allowed() ) {
						continue;
					}

					// Check stock based on all items in the cart and consider any held stock within pending orders.
					$held_stock     = wc_get_held_stock_quantity( $product, $order->get_id() );
					$required_stock = $quantities[ $product->get_stock_managed_by_id() ];

					if ( ! apply_filters( 'woocommerce_pay_order_product_has_enough_stock', ( $product->get_stock_quantity() >= ( $held_stock + $required_stock ) ), $product, $order ) ) {
						/* translators: 1: product name 2: quantity in stock */
						throw new Exception( sprintf( __( 'Sorry, we do not have enough "%1$s" in stock to fulfill your order (%2$s available). We apologize for any inconvenience caused.', 'woocommerce' ), $product->get_name(), wc_format_stock_quantity_for_display( $product->get_stock_quantity() - $held_stock, $product ) ) );
					}
				}
			}
		}

		WC()->customer->set_props(
			array(
				'billing_country'  => $order->get_billing_country() ? $order->get_billing_country() : null,
				'billing_state'    => $order->get_billing_state() ? $order->get_billing_state() : null,
				'billing_postcode' => $order->get_billing_postcode() ? $order->get_billing_postcode() : null,
			)
		);
		WC()->customer->save();

		$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

		if ( count( $available_gateways ) ) {
			current( $available_gateways )->set_current();
		}

		// BEGIN Uncode edit
		if ( apply_filters( 'uncode_woocommerce_append_row_before_checkout_form', false ) ) {
			if ( ! $first_row_printed ) {
				$first_row_class   = 'uncode-wc-module__row--first';
				$first_row_printed = true;
			} else {
				$first_row_class = '';
			}

			$row_before_pay_form = do_action( 'uncode_before_woocommerce_pay' );

			if ( $notices ) {
				$notices_printed = true;
			}

			// Append a row before the main block (use main column settings)
			$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_before_pay_form, $first_row_class );
		}

		$output .= wc_get_template_html( 'checkout/uncode-open-pay-order-form.php' );

		/********************************
		 * Table column
		 ********************************/
		$table_output = '[vc_column_inner';

		// col classes
		$table_output_col_classes   = array();
		$table_output_uncol_classes = array();

		// size
		if ( $checkout_layout === 'horizontal' ) {
			$table_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $checkout_main_area_size ) . '"';
		}

		// custom padding
		if ( $checkout_form_override_padding ) {
			$table_output .= ' override_padding="yes"';
			$table_output .= ' column_padding="' . absint( $checkout_form_column_padding ) . '"';
		}

		// skin
		if ( $checkout_form_style ) {
			$table_output .= ' style="' . esc_attr( $checkout_form_style ) . '"';
		}

		// background color
		if ( $checkout_form_back_color ) {
			$table_output .= ' back_color="' . esc_attr( $checkout_form_back_color ) . '"';
		}

		// shadow
		if ( $checkout_form_shadow ) {
			$table_output .= ' shadow="' . esc_attr( $checkout_form_shadow ) . '"';

			if ( $checkout_form_shadow_darker ) {
				$table_output .= ' shadow_darker="yes"';
			}
		}

		// radius
		if ( $checkout_form_radius ) {
			$table_output .= ' radius="' . esc_attr( $checkout_form_radius ) . '"';
		}

		// off grid
		if ( $checkout_layout === 'horizontal' && $checkout_form_activate_off_grid ) {
			$table_output_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $checkout_form_shift_x, $checkout_form_shift_y, $checkout_form_shift_y_down );

			$table_output_uncol_classes = array_merge( $table_output_uncol_classes, $table_output_off_grid_classes );

			$table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $table_output_off_grid_classes ) ) ) . '"';

			if ( $checkout_form_shift_y_down ) {
				$table_output_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
			}

			if ( $checkout_form_z_index ) {
				$table_output_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $checkout_form_z_index );
			}
		}

		// col classes
		if ( count( $table_output_uncol_classes ) > 0 && ! empty( $table_output_uncol_classes ) ) {
			$table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $table_output_uncol_classes ) ) ) . '"';
		}

		if ( count( $table_output_col_classes ) > 0 && ! empty( $table_output_col_classes ) ) {
			$table_output .= ' el_class="' . esc_attr( trim( implode( ' ', $table_output_col_classes ) ) ) . '"';
		}

		$table_output .= ']';

		if ( $forms_inside_main_area ) {
			$table_output .= '<div class="uncode-wc-module__notices">';

			// append notices
			if ( $notices && ! $notices_printed ) {
				$table_output .= $notices;
			}

			$table_output .= '</div>';
		}

		$table_output .= wc_get_template_html(
			'checkout/uncode-form-pay-table.php',
			array(
				'order'              => $order,
				'available_gateways' => $available_gateways,
				'order_button_text'  => apply_filters( 'woocommerce_pay_order_button_text', __( 'Pay for order', 'woocommerce' ) ),
			)
		);

		$table_output .= '[/vc_column_inner]';

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

		$order_payment_output .= wc_get_template_html(
			'checkout/uncode-form-pay.php',
			array(
				'order'              => $order,
				'available_gateways' => $available_gateways,
				'order_button_text'  => apply_filters( 'woocommerce_pay_order_button_text', __( 'Pay for order', 'woocommerce' ) ),
			)
		);

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

			// Table
			$output .= $table_output;

			// Order Payment
			$output .= $order_payment_output;

			$output .= '[/vc_row_inner]';

		} else {

			// Table
			$output .= '[vc_row_inner el_class="uncode-wc-module__row '. $first_row_class . '"]';
			$output .= $table_output;
			$output .= '[/vc_row_inner]';

			// Order Payment
			$output .= '[vc_row_inner el_class="uncode-wc-module__row"]';
			$output .= $order_payment_output;
			$output .= '[/vc_row_inner]';

		}

		$output .= wc_get_template_html( 'checkout/uncode-close-pay-order-form.php' );

		// END Uncode edit

	} catch ( Exception $e ) {
		// BEGIN Uncode edit
		ob_start();
		wc_print_notice( $e->getMessage(), 'error' );
		$message = ob_get_clean();

		$output .= uncode_woocommerce_print_single_row( $main_column_settings, false, $message, 'uncode-wc-module__row--first' );
		// END Uncode edit
	}
} elseif ( $order_id ) {

	// Pay for order after checkout step.
	$order_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : ''; // WPCS: input var ok, CSRF ok.
	$order     = wc_get_order( $order_id );

	if ( $order && $order->get_id() === $order_id && hash_equals( $order->get_order_key(), $order_key ) ) {

		if ( $order->needs_payment() ) {

			// BEGIN Uncode edit
			if ( ! $first_row_printed ) {
				$first_row_class   = 'uncode-wc-module__row--first';
				$first_row_printed = true;
			} else {
				$first_row_class = '';
			}

			$row_content = wc_get_template_html( 'checkout/order-receipt.php', array( 'order' => $order ) );

			if ( $notices ) {
				$notices_printed = true;
			}

			// Append a row before using the main column settings
			$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_content, $first_row_class );
			// END Uncode edit

		} else {
			// BEGIN Uncode edit
			ob_start();

			/* translators: %s: order status */
			wc_print_notice( sprintf( __( 'This order&rsquo;s status is &ldquo;%s&rdquo;&mdash;it cannot be paid for. Please contact us if you need assistance.', 'woocommerce' ), wc_get_order_status_name( $order->get_status() ) ), 'error' );

			$row_content = ob_get_clean();

			if ( ! $first_row_printed ) {
				$first_row_class   = 'uncode-wc-module__row--first';
				$first_row_printed = true;
			} else {
				$first_row_class = '';
			}

			if ( $notices ) {
				$notices_printed = true;
			}

			// Append a row before using the main column settings
			$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_content, $first_row_class );
			// END Uncode edit
		}
	} else {
		// BEGIN Uncode edit
		ob_start();

		wc_print_notice( __( 'Sorry, this order is invalid and cannot be paid for.', 'woocommerce' ), 'error' );

		$row_content = ob_get_clean();

		if ( ! $first_row_printed ) {
			$first_row_class   = 'uncode-wc-module__row--first';
			$first_row_printed = true;
		} else {
			$first_row_class = '';
		}

		if ( $notices ) {
			$notices_printed = true;
		}

		// Append a row before using the main column settings
		$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_content, $first_row_class );
		// END Uncode edit
	}
} else {
	// BEGIN Uncode edit
	ob_start();

	wc_print_notice( __( 'Invalid order.', 'woocommerce' ), 'error' );

	$row_content = ob_get_clean();

	if ( ! $first_row_printed ) {
		$first_row_class   = 'uncode-wc-module__row--first';
		$first_row_printed = true;
	} else {
		$first_row_class = '';
	}

	if ( $notices ) {
		$notices_printed = true;
	}

	// Append a row before using the main column settings
	$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $row_content, $first_row_class );
	// END Uncode edit
}

ob_start(); // edited by Uncode

do_action( 'after_woocommerce_pay' );

$after_woocommerce_pay = ob_get_clean(); // edited by Uncode

// BEGIN Uncode edit
if ( $after_woocommerce_pay !== '' ) {
	if ( ! $first_row_printed ) {
		$first_row_class   = 'uncode-wc-module__row--first';
		$first_row_printed = true;
	} else {
		$first_row_class = '';
	}

	if ( $notices ) {
		$notices_printed = true;
	}

	// Append a row after the main block (use main column settings)
	$output .= uncode_woocommerce_print_single_row( $main_column_settings, $notices, $after_woocommerce_pay, $first_row_class );
}

$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );

$output .= '</div>';
$output = uncode_woocommerce_inject_classes( $output, $injector_conf );
