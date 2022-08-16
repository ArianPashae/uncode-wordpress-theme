<?php
/**
 * Order Received output (for the Uncode WooCommerce Checkout module)
 *
 * Nothing complicated here, we just need to wrap the output in a column
 * that inherits the settings from the "checkout form" column (Checkout module)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

uncode_woocommerce_enqueue_checkout_script();

$shortcode_id = rand();

$injector_conf[ 'id' ]    = 'order-received';
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

$container_classes[] = 'uncode-wc-order-received';

$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" data-id="' . esc_attr( $shortcode_id ) . '">'; // Open main wrapper

// From WC_Shortcode_Checkout::order_received

$order = false;

// Get the order.
$order_id  = apply_filters( 'woocommerce_thankyou_order_id', absint( $order_id ) );
$order_key = apply_filters( 'woocommerce_thankyou_order_key', empty( $_GET['key'] ) ? '' : wc_clean( wp_unslash( $_GET['key'] ) ) ); // WPCS: input var ok, CSRF ok.

if ( $order_id > 0 ) {
	$order = wc_get_order( $order_id );
	if ( ! $order || ! hash_equals( $order->get_order_key(), $order_key ) ) {
		$order = false;
	}
}

// Empty awaiting payment session.
unset( WC()->session->order_awaiting_payment );

// In case order is created from admin, but paid by the actual customer, store the ip address of the payer
// when they visit the payment confirmation page.
if ( $order && $order->is_created_via( 'admin' ) ) {
	$order->set_customer_ip_address( WC_Geolocation::get_ip_address() );
	$order->save();
}

// Empty current cart.
wc_empty_cart();

// Move customer details before the order table
add_filter( 'uncode_woocommerce_show_customer_details', '__return_false' );
add_action( 'uncode_woocommerce_thankyou_before_table', 'uncode_woocommerce_show_customer_details_before_table' );

if ( $enhanced_thankyou_page ) {
	add_filter( 'uncode_woocommerce_print_thankyou_table', '__return_false' );

	/********************************
	 * Details column
	 ********************************/
	$details_output = '[vc_column_inner';

	// col classes
	$details_output_col_classes   = array();
	$details_output_uncol_classes = array();

	// size
	if ( $checkout_layout === 'horizontal' ) {
		$details_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $checkout_main_area_size ) . '"';
	}

	// custom padding
	if ( $checkout_form_override_padding ) {
		$details_output .= ' override_padding="yes"';
		$details_output .= ' column_padding="' . absint( $checkout_form_column_padding ) . '"';
	}

	// skin
	if ( $checkout_form_style ) {
		$details_output .= ' style="' . esc_attr( $checkout_form_style ) . '"';
	}

	// background color
	if ( $checkout_form_back_color ) {
		$details_output .= ' back_color="' . esc_attr( $checkout_form_back_color ) . '"';
	}

	// shadow
	if ( $checkout_form_shadow ) {
		$details_output .= ' shadow="' . esc_attr( $checkout_form_shadow ) . '"';

		if ( $checkout_form_shadow_darker ) {
			$details_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $checkout_form_radius ) {
		$details_output .= ' radius="' . esc_attr( $checkout_form_radius ) . '"';
	}

	// off grid
	if ( $checkout_layout === 'horizontal' && $checkout_form_activate_off_grid ) {
		$details_output_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $checkout_form_shift_x, $checkout_form_shift_y, $checkout_form_shift_y_down );

		$details_output_uncol_classes = array_merge( $details_output_uncol_classes, $details_output_off_grid_classes );

		$details_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $details_output_off_grid_classes ) ) ) . '"';

		if ( $checkout_form_shift_y_down ) {
			$details_output_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
		}

		if ( $checkout_form_z_index ) {
			$details_output_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $checkout_form_z_index );
		}
	}

	// col classes
	if ( count( $details_output_uncol_classes ) > 0 && ! empty( $details_output_uncol_classes ) ) {
		$details_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $details_output_uncol_classes ) ) ) . '"';
	}

	if ( count( $details_output_col_classes ) > 0 && ! empty( $details_output_col_classes ) ) {
		$details_output .= ' el_class="' . esc_attr( trim( implode( ' ', $details_output_col_classes ) ) ) . '"';
	}

	$details_output .= ']';

	$details_output_html = wc_get_template_html( 'checkout/thankyou.php', array( 'order' => $order ) );

	$details_output .= $details_output_html;

	$details_output .= '[/vc_column_inner]';

	/********************************
	 * Table column
	 ********************************/
	$table_output = '[vc_column_inner';

	// col classes
	$table_col_classes   = array();
	$table_uncol_classes = array();

	// size
	if ( $checkout_layout === 'horizontal' ) {
		$table_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $checkout_sidebar_size ) . '"';
	}

	// custom padding
	if ( $order_payment_override_padding ) {
		$table_output .= ' override_padding="yes"';
		$table_output .= ' column_padding="' . absint( $order_payment_column_padding ) . '"';
	}

	// skin
	if ( $order_payment_style ) {
		$table_output .= ' style="' . esc_attr( $order_payment_style ) . '"';
	}

	// background color
	if ( $order_payment_back_color ) {
		$table_output .= ' back_color="' . esc_attr( $order_payment_back_color ) . '"';
	}

	// sticky
	if ( $order_payment_sticky && ! $equal_height ) {
		$table_output .= ' sticky="yes"';
	}

	// shadow
	if ( $order_payment_shadow ) {
		$table_output .= ' shadow="' . esc_attr( $order_payment_shadow ) . '"';

		if ( $order_payment_shadow_darker ) {
			$table_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $order_payment_radius ) {
		$table_output .= ' radius="' . esc_attr( $order_payment_radius ) . '"';
	}

	// off grid
	if ( $checkout_layout === 'horizontal' && $order_payment_activate_off_grid ) {
		$order_payment_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $order_payment_shift_x, $order_payment_shift_y, $order_payment_shift_y_down );

		$table_uncol_classes = array_merge( $table_uncol_classes, $order_payment_off_grid_classes );

		$table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $order_payment_off_grid_classes ) ) ) . '"';

		if ( $order_payment_shift_y_down ) {
			$table_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
		}

		if ( $order_payment_z_index ) {
			$table_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $order_payment_z_index );
		}
	}

	// col classes
	if ( count( $table_uncol_classes ) > 0 && ! empty( $table_uncol_classes ) ) {
		$table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $table_uncol_classes ) ) ) . '"';
	}

	if ( count( $table_col_classes ) > 0 && ! empty( $table_col_classes ) ) {
		$table_output .= ' el_class="' . esc_attr( trim( implode( ' ', $table_col_classes ) ) ) . '"';
	}

	$table_output .= ']';

	ob_start();
	do_action( 'woocommerce_thankyou', $order->get_id() );
	$table_output_html = ob_get_clean();

	$table_output .= $table_output_html;

	$table_output .= '[/vc_column_inner]';

	// Build grid
	if ( $checkout_layout === 'horizontal' ) {

		// Build inner row
		$row_inner = '[vc_row_inner el_class="uncode-wc-module__row uncode-wc-module__row--first" gutter_size="' . absint( $checkout_columns_gap ) . '"';

		if ( $equal_height ) {
			$row_inner .= ' equal_height="yes"';
		}

		$row_inner .= ']';
		$output .= $row_inner;

		// Details
		$output .= $details_output;

		// Table
		$output .= $table_output;

		$output .= '[/vc_row_inner]';

	} else {

		// Details
		$output .= '[vc_row_inner el_class="uncode-wc-module__row uncode-wc-module__row--first"]';
		$output .= $details_output;
		$output .= '[/vc_row_inner]';

		// Table
		$output .= '[vc_row_inner el_class="uncode-wc-module__row"]';
		$output .= $table_output;
		$output .= '[/vc_row_inner]';

	}

} else {
	$row_content = wc_get_template_html( 'checkout/thankyou.php', array( 'order' => $order ) );

	$output .= uncode_woocommerce_print_single_row( array(), false, $row_content, 'uncode-wc-module__row--first' );

}

$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );

$output .= '</div>';
$output = uncode_woocommerce_inject_classes( $output, $injector_conf );
