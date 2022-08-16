<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract(
	shortcode_atts(
		array(
			'uncode_shortcode_id'                   => '',
			'el_id'                                 => '',
			'el_class'                              => '',
			'checkout_layout'                       => '',
			'equal_height'                          => '',
			'checkout_main_area_size'               => '8',
			'checkout_columns_gap'                  => '3',
			'checkout_form_show_titles'             => 'yes',
			'order_payment_show_titles'             => 'yes',
			'custom_titles_typography'              => '',
			'titles_font'                           => '',
			'titles_size'                           => '',
			'titles_weight'                         => '',
			'titles_transform'                      => '',
			'titles_height'                         => '',
			'titles_space'                          => '',
			'text_lead'                             => '',
			'checkout_vertical_align'               => '',
			'bold_text'                             => '',
			'form_style'                            => '',
			'checkout_form_notices_layout'          => '',
			'checkout_form_compact'                 => '',
			'checkout_form_override_padding'        => '',
			'checkout_form_column_padding'          => '',
			'checkout_form_style'                   => '',
			'checkout_form_back_color'              => '',
			'checkout_form_back_color_type'         => '',
			'checkout_form_back_color_solid'        => '',
			'checkout_form_back_color_gradient'     => '',
			'checkout_form_sticky'                  => '',
			'checkout_form_shadow'                  => '',
			'checkout_form_shadow_darker'           => '',
			'checkout_form_radius'                  => '',
			'checkout_form_activate_off_grid'       => '',
			'checkout_form_shift_x'                 => '',
			'checkout_form_shift_y'                 => '',
			'checkout_form_shift_y_down'            => '',
			'checkout_form_z_index'                 => '',
			'main_button_alignment'                 => '',
			'order_payment_form_compact'            => '',
			'order_payment_override_padding'        => '',
			'order_payment_column_padding'          => '',
			'order_payment_style'                   => '',
			'order_payment_back_color'              => '',
			'order_payment_back_color_type'         => '',
			'order_payment_back_color_solid'        => '',
			'order_payment_back_color_gradient'     => '',
			'order_payment_sticky'                  => '',
			'order_payment_shadow'                  => '',
			'order_payment_shadow_darker'           => '',
			'order_payment_radius'                  => '',
			'order_payment_hide_table_headers'      => '',
			'order_payment_show_thumbs'             => '',
			'order_payment_activate_off_grid'       => '',
			'order_payment_shift_x'                 => '',
			'order_payment_shift_y'                 => '',
			'order_payment_shift_y_down'            => '',
			'order_payment_z_index'                 => '',
			'order_payment_count_icon_style'        => '',
			'checkout_activate_custom_buttons'      => '',
			'checkout_button_button_color'          => '',
			'checkout_button_button_color_type'     => '',
			'checkout_button_button_color_solid'    => '',
			'checkout_button_button_color_gradient' => '',
			'checkout_button_size'                  => '',
			'checkout_button_btn_link_size'         => '',
			'checkout_button_radius'                => '',
			'checkout_button_wide'                  => '',
			'checkout_button_hover_fx'              => '',
			'checkout_button_outline'               => '',
			'checkout_button_text_skin'             => '',
			'checkout_button_shadow'                => '',
			'checkout_button_shadow_weight'         => '',
			'checkout_button_custom_typo'           => '',
			'checkout_button_font_family'           => '',
			'checkout_button_font_weight'           => '',
			'checkout_button_text_transform'        => '',
			'checkout_button_letter_spacing'        => '',
			'checkout_button_border_width'          => '',
			'enhanced_thankyou_page'                => '',
		),
		$atts
	)
);

// General settings
$checkout_layout          = $checkout_layout === 'horizontal' ? 'horizontal' : 'vertical';
$equal_height             = $equal_height === 'yes' ? true : false;
$checkout_main_area_size  = $checkout_main_area_size !== '' ? absint( $checkout_main_area_size ) : 8;
$checkout_sidebar_size    = 12 - $checkout_main_area_size;
$checkout_columns_gap     = $checkout_columns_gap !== '' ? absint( $checkout_columns_gap ) : 3;
$custom_titles_typography = $custom_titles_typography === 'yes' ? true : false;
$titles_font              = $titles_font ? $titles_font : false;
$titles_size              = $titles_size ? $titles_size : 'h2';
$titles_weight            = $titles_weight ? $titles_weight : false;
$titles_transform         = $titles_transform ? $titles_transform : false;
$titles_height            = $titles_height ? $titles_height : false;
$titles_space             = $titles_space ? $titles_space : false;
$text_lead                = $text_lead !== '' ? $text_lead : false;
$checkout_vertical_align  = $checkout_vertical_align === 'top' ? 'top' : 'middle';
$bold_text                = $bold_text === 'yes' ? true : false;
$form_style               = $form_style !== '' ? $form_style : 'default';

// Checkout form settings
$checkout_form_show_titles       = $checkout_form_show_titles === '' ? false : true;
$checkout_form_notices_layout    = $checkout_form_notices_layout ? $checkout_form_notices_layout : 'default';
$checkout_form_compact           = $checkout_form_compact === '' ? false : true;
$checkout_form_override_padding  = $checkout_form_override_padding === 'yes' ? true : false;
$checkout_form_column_padding    = $checkout_form_column_padding !== '' ? absint( $checkout_form_column_padding ) : 2;
$checkout_form_style             = $checkout_form_style ? $checkout_form_style : false;
$checkout_form_back_color        = $checkout_form_back_color ? $checkout_form_back_color : false;
$checkout_form_sticky            = $checkout_form_sticky === 'yes' ? true : false;
$checkout_form_shadow            = $checkout_form_shadow ? $checkout_form_shadow : false;
$checkout_form_shadow_darker     = $checkout_form_shadow_darker === 'yes' ? true : false;
$checkout_form_radius            = $checkout_form_radius ? $checkout_form_radius : false;
$checkout_form_activate_off_grid = $checkout_form_activate_off_grid === '' ? false : true;
$checkout_form_shift_x           = $checkout_form_shift_x !== '' ? intval( $checkout_form_shift_x ) : 0;
$checkout_form_shift_y           = $checkout_form_shift_y !== '' ? intval( $checkout_form_shift_y ) : 0;
$checkout_form_shift_y_down      = $checkout_form_shift_y_down !== '' ? intval( $checkout_form_shift_y_down ) : 0;
$checkout_form_z_index           = $checkout_form_z_index !== '' ? absint( $checkout_form_z_index ) : 0;

// Order payment settings
$order_payment_show_titles        = $order_payment_show_titles === '' ? false : true;
$order_payment_form_compact       = $order_payment_form_compact === '' ? false : true;
$order_payment_override_padding   = $order_payment_override_padding === 'yes' ? true : false;
$order_payment_column_padding     = $order_payment_column_padding !== '' ? absint( $order_payment_column_padding ) : 2;
$order_payment_style              = $order_payment_style ? $order_payment_style : false;
$order_payment_back_color         = $order_payment_back_color ? $order_payment_back_color : false;
$order_payment_sticky             = $order_payment_sticky === 'yes' ? true : false;
$order_payment_shadow             = $order_payment_shadow ? $order_payment_shadow : false;
$order_payment_shadow_darker      = $order_payment_shadow_darker === 'yes' ? true : false;
$order_payment_radius             = $order_payment_radius ? $order_payment_radius : false;
$order_payment_hide_table_headers = $order_payment_hide_table_headers === 'yes' ? true : false;
$order_payment_show_thumbs        = $order_payment_show_thumbs === 'yes' ? true : false;
$order_payment_activate_off_grid  = $order_payment_activate_off_grid === '' ? false : true;
$order_payment_shift_x            = $order_payment_shift_x !== '' ? intval( $order_payment_shift_x ) : 0;
$order_payment_shift_y            = $order_payment_shift_y !== '' ? intval( $order_payment_shift_y ) : 0;
$order_payment_shift_y_down       = $order_payment_shift_y_down !== '' ? intval( $order_payment_shift_y_down ) : 0;
$order_payment_z_index            = $order_payment_z_index !== '' ? absint( $order_payment_z_index ) : 0;
$order_payment_count_icon_style   = $order_payment_count_icon_style === 'no-accent' ? 'no-accent' : 'accent';

// Button settings
$checkout_activate_custom_buttons = $checkout_activate_custom_buttons === '' ? false : true;
$checkout_button_button_color     = $checkout_button_button_color ? $checkout_button_button_color : false;
$checkout_button_size             = $checkout_button_size ? $checkout_button_size : false;
$checkout_button_btn_link_size    = $checkout_button_btn_link_size ? $checkout_button_btn_link_size : false;
$checkout_button_radius           = $checkout_button_radius !== '' ? $checkout_button_radius : false;
$checkout_button_wide             = $checkout_button_wide === 'yes' ? true : false;
$checkout_button_hover_fx         = $checkout_button_hover_fx !== '' ? $checkout_button_hover_fx : false;
$checkout_button_outline          = $checkout_button_outline === 'yes' ? true : false;
$checkout_button_text_skin        = $checkout_button_text_skin === 'yes' ? true : false;
$checkout_button_shadow           = $checkout_button_shadow === 'yes' ? true : false;
$checkout_button_shadow_weight    = $checkout_button_shadow_weight !== '' ? $checkout_button_shadow_weight : false;
$checkout_button_custom_typo      = $checkout_button_custom_typo === 'yes' ? true : false;
$checkout_button_font_family      = $checkout_button_font_family !== '' ? $checkout_button_font_family : false;
$checkout_button_font_weight      = $checkout_button_font_weight !== '' ? $checkout_button_font_weight : false;
$checkout_button_text_transform   = $checkout_button_text_transform !== '' ? $checkout_button_text_transform : 'initial';
$checkout_button_letter_spacing   = $checkout_button_letter_spacing !== '' ? $checkout_button_letter_spacing : 'no-letterspace';
$checkout_button_border_width     = $checkout_button_border_width !== '' ? absint( $checkout_button_border_width ) : 0;
$main_button_alignment            = $main_button_alignment === 'right' ? 'right' : 'left';

// Extra settings
$enhanced_thankyou_page           = $enhanced_thankyou_page === 'yes' ? true : false;
$el_id    = $el_id ? $el_id : false;
$el_class = $el_class ? $el_class : false;

// Custom ID
if ( $el_id ) {
	$container_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$container_id = '';
}

// Custom classes
$container_classes = array( 'uncode-wc-module', 'uncode-wc-checkout', 'woocommerce' );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'uncode_woocommerce_checkout',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'checkout_form_back_color'              => $checkout_form_back_color,
		'checkout_form_back_color_type'         => $checkout_form_back_color_type,
		'checkout_form_back_color_solid'        => $checkout_form_back_color_solid,
		'checkout_form_back_color_gradient'     => $checkout_form_back_color_gradient,
		'order_payment_back_color'              => $order_payment_back_color,
		'order_payment_back_color_type'         => $order_payment_back_color_type,
		'order_payment_back_color_solid'        => $order_payment_back_color_solid,
		'order_payment_back_color_gradient'     => $order_payment_back_color_gradient,
		'checkout_button_button_color'          => $checkout_button_button_color,
		'checkout_button_button_color_type'     => $checkout_button_button_color_type,
		'checkout_button_button_color_solid'    => $checkout_button_button_color_solid,
		'checkout_button_button_color_gradient' => $checkout_button_button_color_gradient,
	)
) );

$checkout_form_back_color = uncode_get_shortcode_color_attribute_value( 'checkout_form_back_color', $uncode_shortcode_id, $checkout_form_back_color_type, $checkout_form_back_color, $checkout_form_back_color_solid, $checkout_form_back_color_gradient );
$order_payment_back_color = uncode_get_shortcode_color_attribute_value( 'order_payment_back_color', $uncode_shortcode_id, $order_payment_back_color_type, $order_payment_back_color, $order_payment_back_color_solid, $order_payment_back_color_gradient );
$checkout_button_button_color = uncode_get_shortcode_color_attribute_value( 'checkout_button_button_color', $uncode_shortcode_id, $checkout_button_button_color_type, $checkout_button_button_color, $checkout_button_button_color_solid, $checkout_button_button_color_gradient );

// Forms and notices inside main form?
$forms_inside_main_area   = $checkout_form_notices_layout === 'default' ? true : false;

// Form style
if ( $form_style === 'no-labels-default' || $form_style === 'no-labels-background' || $form_style === 'no-labels-underline' ) {
	uncode_woocommerce_activate_placeholders_on_inputs();
	$container_classes[] = 'form-no-labels';
}

// Inputs style
if ( $form_style === 'default-background' || $form_style === 'no-labels-background' ) {
	$container_classes[] = 'input-background';
} else if ( $form_style === 'default-underline' || $form_style === 'no-labels-underline' ) {
	$container_classes[] = 'input-underline';
}

// Hide header table class
if ( $order_payment_hide_table_headers ) {
	$container_classes[] = 'no-order-payment-table-header';
}

// Bold text
if ( $bold_text ) {
	$container_classes[] = 'bold-text';
}

// Show thumbs?
if ( $order_payment_show_thumbs ) {
	$container_classes[] = 'order-table-with-thumbs';
}

// Vertical align
if ( $checkout_vertical_align ) {
	$container_classes[] = 'vertical-align-' . $checkout_vertical_align;
}

// Text size class
if ( $text_lead === 'yes' ) {
	$container_classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$container_classes[] = 'module-text-small';
}

// Main button alignment
$container_classes[] = 'main-button-align-' . $main_button_alignment;

// Count icon style
$container_classes[] = 'count-icon-' . $order_payment_count_icon_style;

// Inject HTML classes
$injector_conf = array();

// Buttons
$buttons_conf = array(
	'activate_buttons'        => $checkout_activate_custom_buttons,
	'button_color'            => $checkout_button_button_color,
	'button_size'             => $checkout_button_size,
	'button_link_size'        => $checkout_button_btn_link_size,
	'button_radius'           => $checkout_button_radius,
	'button_wide'             => $checkout_button_wide,
	'button_hover_fx'         => $checkout_button_hover_fx,
	'button_outline'          => $checkout_button_outline,
	'button_text_skin'        => $checkout_button_text_skin,
	'button_shadow'           => $checkout_button_shadow,
	'button_shadow_weight'    => $checkout_button_shadow_weight,
	'button_custom_typo'      => $checkout_button_custom_typo,
	'button_font_family'      => $checkout_button_font_family,
	'button_font_weight'      => $checkout_button_font_weight,
	'button_text_transform'   => $checkout_button_text_transform,
	'button_letter_spacing'   => $checkout_button_letter_spacing,
	'button_border_width'     => $checkout_button_border_width,
);

// Main buttons
$buttons_conf_classes = uncode_woocommerce_get_buttons_conf_classes( $buttons_conf );
$main_buttons_classes = uncode_woocommerce_get_button_classes( $buttons_conf_classes );

$injector_conf[ 'button' ] = $main_buttons_classes;

// Derivated buttons
$derivated_buttons_conf    = uncode_woocommerce_get_derivated_buttons_conf_classes( $buttons_conf_classes );
$derivated_buttons_classes = uncode_woocommerce_get_button_classes( $derivated_buttons_conf );

// From WC_Shortcode_Checkout::output

global $wp;

// Check cart class is loaded or abort.
if ( is_null( WC()->cart ) ) {
	return;
}

// Backwards compatibility with old pay and thanks link arguments.
if ( isset( $_GET['order'] ) && isset( $_GET['key'] ) ) { // WPCS: input var ok, CSRF ok.
	wc_deprecated_argument( __CLASS__ . '->' . __FUNCTION__, '2.1', '"order" is no longer used to pass an order ID. Use the order-pay or order-received endpoint instead.' );

	// Get the order to work out what we are showing.
	$order_id = absint( $_GET['order'] ); // WPCS: input var ok.
	$order    = wc_get_order( $order_id );

	if ( $order && $order->has_status( 'pending' ) ) {
		$wp->query_vars['order-pay'] = absint( $_GET['order'] ); // WPCS: input var ok.
	} else {
		$wp->query_vars['order-received'] = absint( $_GET['order'] ); // WPCS: input var ok.
	}
}

// Handle checkout actions.
if ( ! empty( $wp->query_vars['order-pay'] ) ) {

	$order_id = $wp->query_vars['order-pay'];
	require get_template_directory() . '/core/inc/compatibility/woocommerce/checkout/pay-order.php';

} elseif ( isset( $wp->query_vars['order-received'] ) ) {

	$order_id = $wp->query_vars['order-received'];
	require get_template_directory() . '/core/inc/compatibility/woocommerce/checkout/order-received.php';

} else {

	require get_template_directory() . '/core/inc/compatibility/woocommerce/checkout/checkout.php';

}

echo do_shortcode( $output );
