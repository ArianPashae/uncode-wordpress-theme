<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract(
	shortcode_atts(
		array(
			'uncode_shortcode_id'             => '',
			'el_id'                           => '',
			'el_class'                        => '',
			'cart_layout'                     => '',
			'equal_height'                    => '',
			'cart_main_area_size'             => '8',
			'cart_columns_gap'                => '3',
			'cart_table_show_titles'          => 'yes',
			'cart_totals_show_titles'         => 'yes',
			'cross_sells_show_titles'         => 'yes',
			'custom_titles_typography'        => '',
			'titles_font'                     => '',
			'titles_size'                     => '',
			'titles_weight'                   => '',
			'titles_transform'                => '',
			'titles_height'                   => '',
			'titles_space'                    => '',
			'text_lead'                       => '',
			'cart_vertical_align'             => '',
			'bold_text'                       => '',
			'form_style'                      => '',
			'thumb_size'                      => '',
			'cart_table_compact'              => '',
			'cart_table_override_padding'     => '',
			'cart_table_column_padding'       => '',
			'cart_table_style'                => '',
			'cart_table_back_color'           => '',
			'cart_table_back_color_type'      => '',
			'cart_table_back_color_solid'     => '',
			'cart_table_back_color_gradient'  => '',
			'cart_table_sticky'               => '',
			'cart_table_shadow'               => '',
			'cart_table_shadow_darker'        => '',
			'cart_table_radius'               => '',
			'cart_table_activate_off_grid'    => '',
			'cart_table_shift_x'              => '',
			'cart_table_shift_y'              => '',
			'cart_table_shift_y_down'         => '',
			'cart_table_z_index'              => '',
			'main_button_alignment'           => '',
			'cart_totals_override_padding'    => '',
			'cart_totals_column_padding'      => '',
			'cart_totals_style'               => '',
			'cart_totals_back_color'          => '',
			'cart_totals_back_color_type'     => '',
			'cart_totals_back_color_solid'    => '',
			'cart_totals_back_color_gradient' => '',
			'cart_totals_sticky'              => '',
			'cart_totals_shadow'              => '',
			'cart_totals_shadow_darker'       => '',
			'cart_totals_radius'              => '',
			'cart_totals_activate_off_grid'   => '',
			'cart_totals_shift_x'             => '',
			'cart_totals_shift_y'             => '',
			'cart_totals_shift_y_down'        => '',
			'cart_totals_z_index'             => '',
			'cart_hide_table_headers'         => '',
			'show_cross_sells'                => '',
			'cross_sells_after_cart_table'    => '',
			'cross_sells_margin_top'          => '3',
			'cross_sells_override_padding'    => '',
			'cross_sells_column_padding'      => '',
			'cross_sells_style'               => '',
			'cross_sells_back_color'          => '',
			'cross_sells_back_color_type'     => '',
			'cross_sells_back_color_solid'    => '',
			'cross_sells_back_color_gradient' => '',
			'cross_sells_shadow'              => '',
			'cross_sells_shadow_darker'       => '',
			'cross_sells_radius'              => '',
			'cross_sells_carousel_lg'         => '3',
			'cross_sells_carousel_md'         => '3',
			'cross_sells_carousel_sm'         => '1',
			'cart_activate_custom_buttons'    => '',
			'cart_button_button_color'        => '',
			'cart_button_button_color_type' => '',
			'cart_button_button_color_solid' => '',
			'cart_button_button_color_gradient' => '',
			'cart_button_size'                => '',
			'cart_button_btn_link_size'       => '',
			'cart_button_radius'              => '',
			'cart_button_wide'                => '',
			'cart_button_hover_fx'            => '',
			'cart_button_outline'             => '',
			'cart_button_text_skin'           => '',
			'cart_button_shadow'              => '',
			'cart_button_shadow_weight'       => '',
			'cart_button_custom_typo'         => '',
			'cart_button_font_family'         => '',
			'cart_button_font_weight'         => '',
			'cart_button_text_transform'      => '',
			'cart_button_letter_spacing'      => '',
			'cart_button_border_width'        => '',
		),
		$atts
	)
);

uncode_woocommerce_enqueue_cart_script();

// General settings
$cart_layout              = $cart_layout === 'horizontal' ? 'horizontal' : 'vertical';
$equal_height             = $equal_height === 'yes' ? true : false;
$cart_main_area_size      = $cart_main_area_size !== '' ? absint( $cart_main_area_size ) : 8;
$cart_sidebar_size        = 12 - $cart_main_area_size;
$cart_columns_gap         = $cart_columns_gap !== '' ? absint( $cart_columns_gap ) : 3;
$custom_titles_typography = $custom_titles_typography === 'yes' ? true : false;
$titles_font              = $titles_font ? $titles_font : false;
$titles_size              = $titles_size ? $titles_size : 'h2';
$titles_weight            = $titles_weight ? $titles_weight : false;
$titles_transform         = $titles_transform ? $titles_transform : false;
$titles_height            = $titles_height ? $titles_height : false;
$titles_space             = $titles_space ? $titles_space : false;
$cart_vertical_align      = $cart_vertical_align === 'top' ? 'top' : 'middle';
$text_lead                = $text_lead !== '' ? $text_lead : false;
$bold_text                = $bold_text === 'yes' ? true : false;
$thumb_size               = $thumb_size ? $thumb_size : 'small';
$form_style               = $form_style !== '' ? $form_style : 'default';

// Cart table settings
$cart_table_show_titles       = $cart_table_show_titles === '' ? false : true;
$cart_table_compact           = $cart_table_compact === 'yes' ? true : false;
$cart_table_override_padding  = $cart_table_override_padding === 'yes' ? true : false;
$cart_table_column_padding    = $cart_table_column_padding !== '' ? absint( $cart_table_column_padding ) : 2;
$cart_table_style             = $cart_table_style ? $cart_table_style : false;
$cart_table_back_color        = $cart_table_back_color ? $cart_table_back_color : false;
$cart_hide_table_headers      = $cart_hide_table_headers === 'yes' ? true : false;
$cart_table_sticky            = $cart_table_sticky === 'yes' ? true : false;
$cart_table_shadow            = $cart_table_shadow ? $cart_table_shadow : false;
$cart_table_shadow_darker     = $cart_table_shadow_darker === 'yes' ? true : false;
$cart_table_radius            = $cart_table_radius ? $cart_table_radius : false;
$cart_table_activate_off_grid = $cart_table_activate_off_grid === '' ? false : true;
$cart_table_shift_x           = $cart_table_shift_x !== '' ? intval( $cart_table_shift_x ) : 0;
$cart_table_shift_y           = $cart_table_shift_y !== '' ? intval( $cart_table_shift_y ) : 0;
$cart_table_shift_y_down      = $cart_table_shift_y_down !== '' ? intval( $cart_table_shift_y_down ) : 0;
$cart_table_z_index           = $cart_table_z_index !== '' ? absint( $cart_table_z_index ) : 0;

// Cart totals settings
$cart_totals_show_titles       = $cart_totals_show_titles === '' ? false : true;
$cart_totals_override_padding  = $cart_totals_override_padding === 'yes' ? true : false;
$cart_totals_column_padding    = $cart_totals_column_padding !== '' ? absint( $cart_totals_column_padding ) : 2;
$cart_totals_style             = $cart_totals_style ? $cart_totals_style : false;
$cart_totals_back_color        = $cart_totals_back_color ? $cart_totals_back_color : false;
$cart_totals_sticky            = $cart_totals_sticky === 'yes' ? true : false;
$cart_totals_shadow            = $cart_totals_shadow ? $cart_totals_shadow : false;
$cart_totals_shadow_darker     = $cart_totals_shadow_darker === 'yes' ? true : false;
$cart_totals_radius            = $cart_totals_radius ? $cart_totals_radius : false;
$cart_totals_activate_off_grid = $cart_table_activate_off_grid === '' ? false : true;
$cart_totals_shift_x           = $cart_totals_shift_x !== '' ? intval( $cart_totals_shift_x ) : 0;
$cart_totals_shift_y           = $cart_totals_shift_y !== '' ? intval( $cart_totals_shift_y ) : 0;
$cart_totals_shift_y_down      = $cart_totals_shift_y_down !== '' ? intval( $cart_totals_shift_y_down ) : 0;
$cart_totals_z_index           = $cart_totals_z_index !== '' ? absint( $cart_totals_z_index ) : 0;

// Cross sells settings
$cross_sells_show_titles      = $cross_sells_show_titles === '' ? false : true;
$show_cross_sells             = $show_cross_sells === 'yes' ? true : false;
$cross_sells_after_cart_table = $cross_sells_after_cart_table === 'yes' ? true : false;
$cross_sells_margin_top       = $cross_sells_margin_top !== '' ? absint( $cross_sells_margin_top ) : 3;
$cross_sells_override_padding = $cross_sells_override_padding === 'yes' ? true : false;
$cross_sells_column_padding   = $cross_sells_column_padding !== '' ? absint( $cross_sells_column_padding ) : 2;
$cross_sells_style            = $cross_sells_style ? $cross_sells_style : false;
$cross_sells_back_color       = $cross_sells_back_color ? $cross_sells_back_color : false;
$cross_sells_shadow           = $cross_sells_shadow ? $cross_sells_shadow : false;
$cross_sells_shadow_darker    = $cross_sells_shadow_darker === 'yes' ? true : false;
$cross_sells_radius           = $cross_sells_radius ? $cross_sells_radius : false;
$cross_sells_carousel_lg      = $cross_sells_carousel_lg !== '' ? absint( $cross_sells_carousel_lg ) : 3;
$cross_sells_carousel_md      = $cross_sells_carousel_md !== '' ? absint( $cross_sells_carousel_md ) : 3;
$cross_sells_carousel_sm      = $cross_sells_carousel_sm !== '' ? absint( $cross_sells_carousel_sm ) : 1;

// Button settings
$cart_activate_custom_buttons = $cart_activate_custom_buttons === '' ? false : true;
$cart_button_button_color     = $cart_button_button_color ? $cart_button_button_color : false;
$cart_button_size             = $cart_button_size ? $cart_button_size : false;
$cart_button_btn_link_size    = $cart_button_btn_link_size ? $cart_button_btn_link_size : false;
$cart_button_radius           = $cart_button_radius !== '' ? $cart_button_radius : false;
$cart_button_wide             = $cart_button_wide === 'yes' ? true : false;
$cart_button_hover_fx         = $cart_button_hover_fx !== '' ? $cart_button_hover_fx : false;
$cart_button_outline          = $cart_button_outline === 'yes' ? true : false;
$cart_button_text_skin        = $cart_button_text_skin === 'yes' ? true : false;
$cart_button_shadow           = $cart_button_shadow === 'yes' ? true : false;
$cart_button_shadow_weight    = $cart_button_shadow_weight !== '' ? $cart_button_shadow_weight : false;
$cart_button_custom_typo      = $cart_button_custom_typo === 'yes' ? true : false;
$cart_button_font_family      = $cart_button_font_family !== '' ? $cart_button_font_family : false;
$cart_button_font_weight      = $cart_button_font_weight !== '' ? $cart_button_font_weight : false;
$cart_button_text_transform   = $cart_button_text_transform !== '' ? $cart_button_text_transform : 'initial';
$cart_button_letter_spacing   = $cart_button_letter_spacing !== '' ? $cart_button_letter_spacing : 'no-letterspace';
$cart_button_border_width     = $cart_button_border_width !== '' ? absint( $cart_button_border_width ) : 0;
$main_button_alignment        = $main_button_alignment === 'left' ? 'left' : 'right';

// Extra settings
$el_id    = $el_id ? $el_id : false;
$el_class = $el_class ? $el_class : false;

// Custom ID
if ( $el_id ) {
	$container_id = ' id="' . esc_attr( trim( $el_id ) ) . '"';
} else {
	$container_id = '';
}

$inline_style_css = uncode_get_dynamic_colors_css_from_shortcode( array(
	'type'       => 'uncode_woocommerce_cart',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'cart_table_back_color'             => $cart_table_back_color,
		'cart_table_back_color_type'        => $cart_table_back_color_type,
		'cart_table_back_color_solid'       => $cart_table_back_color_solid,
		'cart_table_back_color_gradient'    => $cart_table_back_color_gradient,
		'cart_totals_back_color'            => $cart_totals_back_color,
		'cart_totals_back_color_type'       => $cart_totals_back_color_type,
		'cart_totals_back_color_solid'      => $cart_totals_back_color_solid,
		'cart_totals_back_color_gradient'   => $cart_totals_back_color_gradient,
		'cross_sells_back_color'            => $cross_sells_back_color,
		'cross_sells_back_color_type'       => $cross_sells_back_color_type,
		'cross_sells_back_color_solid'      => $cross_sells_back_color_solid,
		'cross_sells_back_color_gradient'   => $cross_sells_back_color_gradient,
		'cart_button_button_color'          => $cart_button_button_color,
		'cart_button_button_color_type'     => $cart_button_button_color_type,
		'cart_button_button_color_solid'    => $cart_button_button_color_solid,
		'cart_button_button_color_gradient' => $cart_button_button_color_gradient,
	)
) );

$cart_table_back_color = uncode_get_shortcode_color_attribute_value( 'cart_table_back_color', $uncode_shortcode_id, $cart_table_back_color_type, $cart_table_back_color, $cart_table_back_color_solid, $cart_table_back_color_gradient );
$cart_totals_back_color = uncode_get_shortcode_color_attribute_value( 'cart_totals_back_color', $uncode_shortcode_id, $cart_totals_back_color_type, $cart_totals_back_color, $cart_totals_back_color_solid, $cart_totals_back_color_gradient );
$cross_sells_back_color = uncode_get_shortcode_color_attribute_value( 'cross_sells_back_color', $uncode_shortcode_id, $cross_sells_back_color_type, $cross_sells_back_color, $cross_sells_back_color_solid, $cross_sells_back_color_gradient );
$cart_button_button_color = uncode_get_shortcode_color_attribute_value( 'cart_button_button_color', $uncode_shortcode_id, $cart_button_button_color_type, $cart_button_button_color, $cart_button_button_color_solid, $cart_button_button_color_gradient );

// Custom classes
$container_classes = array( 'uncode-wc-module', 'uncode-wc-cart', 'woocommerce', 'uncode-wc-cart--' . $cart_layout );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

// Hide header table class
if ( $cart_hide_table_headers ) {
	$container_classes[] = 'no-cart-table-header';
}

// Text size class
if ( $text_lead === 'yes' ) {
	$container_classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$container_classes[] = 'module-text-small';
}

$shortcode_id = rand();

// Inject HTML classes
$injector_conf = array(
	'id'      => 'cart',
	'title'   => array(),
	'button'  => array()
);

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

if ( ! $cart_table_show_titles ) {
	$container_classes[] = 'no-cart-table-titles';
}

if ( ! $cart_totals_show_titles ) {
	$container_classes[] = 'no-cart-totals-titles';
}

if ( ! $cross_sells_show_titles ) {
	$container_classes[] = 'no-cross-sells-titles';
}

// Bold text
if ( $bold_text ) {
	$container_classes[] = 'bold-text';
}

// Vertical align
if ( $cart_vertical_align ) {
	$container_classes[] = 'vertical-align-' . $cart_vertical_align;
}

// Thumb size
if ( $thumb_size ) {
	$container_classes[] = 'thumb-size-' . $thumb_size;
}

// Inputs style
if ( $form_style === 'default-background' ) {
	$container_classes[] = 'input-background';
} else if ( $form_style === 'default-underline' ) {
	$container_classes[] = 'input-underline';
}

// Main button alignment
$container_classes[] = 'main-button-align-' . $main_button_alignment;

// Cross sells carousel options
$cross_sells_carousel_conf = array(
	'lg'   => $cross_sells_carousel_lg,
	'md'   => $cross_sells_carousel_md,
	'sm'   => $cross_sells_carousel_sm,
	'skin' => $show_cross_sells && $cross_sells_after_cart_table ? $cart_table_style : $cross_sells_style
);

// Buttons
$buttons_conf = array(
	'activate_buttons'        => $cart_activate_custom_buttons,
	'button_color'            => $cart_button_button_color,
	'button_size'             => $cart_button_size,
	'button_link_size'        => $cart_button_btn_link_size,
	'button_radius'           => $cart_button_radius,
	'button_wide'             => $cart_button_wide,
	'button_hover_fx'         => $cart_button_hover_fx,
	'button_outline'          => $cart_button_outline,
	'button_text_skin'        => $cart_button_text_skin,
	'button_shadow'           => $cart_button_shadow,
	'button_shadow_weight'    => $cart_button_shadow_weight,
	'button_custom_typo'      => $cart_button_custom_typo,
	'button_font_family'      => $cart_button_font_family,
	'button_font_weight'      => $cart_button_font_weight,
	'button_text_transform'   => $cart_button_text_transform,
	'button_letter_spacing'   => $cart_button_letter_spacing,
	'button_border_width'     => $cart_button_border_width,
);

// Main buttons
$buttons_conf_classes = uncode_woocommerce_get_buttons_conf_classes( $buttons_conf );
$main_buttons_classes = uncode_woocommerce_get_button_classes( $buttons_conf_classes );

$injector_conf[ 'button' ] = $main_buttons_classes;

// Derivated buttons
$derivated_buttons_conf    = uncode_woocommerce_get_derivated_buttons_conf_classes( $buttons_conf_classes );
$derivated_buttons_classes = uncode_woocommerce_get_button_classes( $derivated_buttons_conf );

$injector_conf[ 'derivated_button' ] = $derivated_buttons_classes;

if ( is_null( WC()->cart ) ) {
	return;
}

// From WC_Shortcode_Cart::output

if ( ! apply_filters( 'woocommerce_output_cart_shortcode_content', true ) ) {
	return;
}

// Constants.
wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );

$atts        = shortcode_atts( array(), $atts, 'woocommerce_cart' );
$nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

// Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) { // WPCS: input var ok.
	WC_Shortcode_Cart::calculate_shipping(); // edited by Uncode

	// Also calc totals before we check items so subtotals etc are up to date.
	WC()->cart->calculate_totals();
}

// Check cart items are valid.
do_action( 'woocommerce_check_cart_items' );

// Calc totals.
WC()->cart->calculate_totals();

if ( WC()->cart->is_empty() ) {
	// Custom class for empty cart
	$container_classes[] = 'uncode-wc-cart--empty';

	$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" data-id="' . esc_attr( $shortcode_id ) . '">';

	// Empty cart column settings (use main column settings)
	$empty_cart_column_settings = array(
		'override_padding' => $cart_table_override_padding,
		'column_padding'   => $cart_table_column_padding,
		'style'            => $cart_table_style,
		'back_color'       => $cart_table_back_color,
		'shadow'           => $cart_table_shadow,
		'shadow_darker'    => $cart_table_shadow_darker,
		'radius'           => $cart_table_radius,
	);

	$row_content = wc_get_template_html( 'cart/cart-empty.php' );
	$output      .= uncode_woocommerce_print_single_row( $empty_cart_column_settings, false, $row_content, 'uncode-wc-module__row--first' );

} else {
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

	if ( function_exists( 'uncode_core_unhook' ) ) {
		uncode_core_unhook( 'woocommerce_cross_sells_columns', 'uncode_woocommerce_cross_sells_columns' );
		uncode_core_unhook( 'woocommerce_cross_sells_total', 'uncode_woocommerce_cross_sells_total' );
	}

	$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" data-id="' . esc_attr( $shortcode_id ) . '">';

	/********************************
	 * Cart Table column
	 ********************************/
	$cart_table_output = '[vc_column_inner';

	// col classes
	$cart_table_col_classes   = array();
	$cart_table_uncol_classes = array();

	// size
	if ( $cart_layout === 'horizontal' ) {
		$cart_table_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $cart_main_area_size ) . '"';
	}

	if ( $show_cross_sells && $cross_sells_after_cart_table ) {
		// vertical space
		$cart_table_output .= ' gutter_size="' . absint( $cross_sells_margin_top ) . '"';
	}

	// custom padding
	if ( $cart_table_override_padding ) {
		$cart_table_output .= ' override_padding="yes"';
		$cart_table_output .= ' column_padding="' . absint( $cart_table_column_padding ) . '"';
	}

	// skin
	if ( $cart_table_style ) {
		$cart_table_output .= ' style="' . esc_attr( $cart_table_style ) . '"';
	}

	// background color
	if ( $cart_table_back_color ) {
		$cart_table_output .= ' back_color="' . esc_attr( $cart_table_back_color ) . '"';
	}

	// sticky
	if ( $cart_table_sticky && ! $cart_totals_sticky && ! $equal_height ) {
		$cart_table_output .= ' sticky="yes"';
	}

	// shadow
	if ( $cart_table_shadow ) {
		$cart_table_output .= ' shadow="' . esc_attr( $cart_table_shadow ) . '"';

		if ( $cart_table_shadow_darker ) {
			$cart_table_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $cart_table_radius ) {
		$cart_table_output .= ' radius="' . esc_attr( $cart_table_radius ) . '"';
	}

	// off grid
	if ( $cart_layout === 'horizontal' && $cart_table_activate_off_grid ) {
		$cart_table_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $cart_table_shift_x, $cart_table_shift_y, $cart_table_shift_y_down );

		$cart_table_uncol_classes = array_merge( $cart_table_uncol_classes, $cart_table_off_grid_classes );

		$cart_table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $cart_table_off_grid_classes ) ) ) . '"';

		if ( $cart_table_shift_y_down ) {
			$cart_table_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
		}

		if ( $cart_table_z_index ) {
			$cart_table_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $cart_table_z_index );
		}
	}

	// col classes
	if ( count( $cart_table_uncol_classes ) > 0 && ! empty( $cart_table_uncol_classes ) ) {
		$cart_table_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $cart_table_uncol_classes ) ) ) . '"';
	}

	if ( count( $cart_table_col_classes ) > 0 && ! empty( $cart_table_col_classes ) ) {
		$cart_table_output .= ' el_class="' . esc_attr( trim( implode( ' ', $cart_table_col_classes ) ) ) . '"';
	}

	$cart_table_output .= ']';

	$before_cart = wc_get_template_html( 'cart/uncode-before-cart.php' );

	$cart_table_output .= $before_cart;

	if ( $cart_table_compact ) {
		$cart_table_output .= wc_get_template_html( 'cart/uncode-cart-table-compact.php', array( 'button_classes' => $derivated_buttons_classes ) );
	} else {
		$cart_table_output .= wc_get_template_html( 'cart/uncode-cart-table.php', array( 'button_classes' => $derivated_buttons_classes ) );
	}

	if ( $show_cross_sells && $cross_sells_after_cart_table ) {
		$cross_sells_html = uncode_woocommerce_parse_carousel_cols( wc_get_template_html( 'cart/uncode-cross-sells.php', array( 'cross_sells_carousel_conf' => $cross_sells_carousel_conf ) ), $cross_sells_carousel_conf );
		$cart_table_output .= $cross_sells_html;
	}

	$cart_table_output .= '[/vc_column_inner]';

	/********************************
	 * Cart Totals column
	 ********************************/
	$cart_totals_output = '[vc_column_inner';

	// col classes
	$cart_totals_col_classes   = array();
	$cart_totals_uncol_classes = array();

	// size
	if ( $cart_layout === 'horizontal' ) {
		$cart_totals_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $cart_sidebar_size ) . '"';
	}

	// custom padding
	if ( $cart_totals_override_padding ) {
		$cart_totals_output .= ' override_padding="yes"';
		$cart_totals_output .= ' column_padding="' . absint( $cart_totals_column_padding ) . '"';
	}

	// skin
	if ( $cart_totals_style ) {
		$cart_totals_output .= ' style="' . esc_attr( $cart_totals_style ) . '"';
	}

	// background color
	if ( $cart_totals_back_color ) {
		$cart_totals_output .= ' back_color="' . esc_attr( $cart_totals_back_color ) . '"';
	}

	// sticky
	if ( $cart_totals_sticky && ! $equal_height ) {
		$cart_totals_output .= ' sticky="yes"';
	}

	// shadow
	if ( $cart_totals_shadow ) {
		$cart_totals_output .= ' shadow="' . esc_attr( $cart_totals_shadow ) . '"';

		if ( $cart_totals_shadow_darker ) {
			$cart_totals_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $cart_totals_radius ) {
		$cart_totals_output .= ' radius="' . esc_attr( $cart_totals_radius ) . '"';
	}

	// off grid
	if ( $cart_layout === 'horizontal' && $cart_totals_activate_off_grid ) {
		$cart_totals_off_grid_classes = uncode_woocommerce_get_off_grid_classes( $cart_totals_shift_x, $cart_totals_shift_y, $cart_totals_shift_y_down );

		$cart_totals_uncol_classes = array_merge( $cart_totals_uncol_classes, $cart_totals_off_grid_classes );

		$cart_totals_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $cart_totals_off_grid_classes ) ) ) . '"';

		if ( $cart_totals_shift_y_down ) {
			$cart_totals_col_classes[] = 'shift-col-wa';//workaround to remove vertical-align on mobile devices when shift bottom is enabled
		}

		if ( $cart_totals_z_index ) {
			$cart_totals_col_classes[] = 'z_index_' . str_replace( '-', 'neg_', $cart_totals_z_index );
		}
	}

	// col classes
	if ( count( $cart_totals_uncol_classes ) > 0 && ! empty( $cart_totals_uncol_classes ) ) {
		$cart_totals_output .= ' el_uncol_class="' . esc_attr( trim( implode( ' ', $cart_totals_uncol_classes ) ) ) . '"';
	}

	if ( count( $cart_totals_col_classes ) > 0 && ! empty( $cart_totals_col_classes ) ) {
		$cart_totals_output .= ' el_class="' . esc_attr( trim( implode( ' ', $cart_totals_col_classes ) ) ) . '"';
	}

	$cart_totals_output .= ']';

	$cart_totals_output .= wc_get_template_html( 'cart/uncode-cart-totals.php' );

	$cart_totals_output .= '<script type="text/javascript">var uncode_wc_cart_injector_' . $shortcode_id . ' = UNCODE_INJECTOR_PLACEHOLDER;</script>';

	$cart_totals_output .= '[/vc_column_inner]';

	/********************************
	 * Cross sells column
	 ********************************/
	if ( $show_cross_sells && ! $cross_sells_after_cart_table ) {
		$cross_sells_output = '[vc_column_inner';

		// custom padding
		if ( $cross_sells_override_padding ) {
			$cross_sells_output .= ' override_padding="yes"';
			$cross_sells_output .= ' column_padding="' . absint( $cross_sells_column_padding ) . '"';
		}

		// skin
		if ( $cross_sells_style ) {
			$cross_sells_output .= ' style="' . esc_attr( $cross_sells_style ) . '"';
		}

		// background color
		if ( $cross_sells_back_color ) {
			$cross_sells_output .= ' back_color="' . esc_attr( $cross_sells_back_color ) . '"';
		}

		// shadow
		if ( $cross_sells_shadow ) {
			$cross_sells_output .= ' shadow="' . esc_attr( $cross_sells_shadow ) . '"';

			if ( $cross_sells_shadow_darker ) {
				$cross_sells_output .= ' shadow_darker="yes"';
			}
		}

		// radius
		if ( $cross_sells_radius ) {
			$cross_sells_output .= ' radius="' . esc_attr( $cross_sells_radius ) . '"';
		}

		$cross_sells_output .= ']';

		$cross_sells_html = uncode_woocommerce_parse_carousel_cols( wc_get_template_html( 'cart/uncode-cross-sells.php', array( 'cross_sells_carousel_conf' => $cross_sells_carousel_conf ) ), $cross_sells_carousel_conf );

		$cross_sells_output .= $cross_sells_html;

		$cross_sells_output .= '[/vc_column_inner]';
	}

	// Build grid
	if ( $cart_layout === 'horizontal' ) {

		// Build inner row
		$row_inner = '[vc_row_inner el_class="uncode-wc-module__row uncode-wc-module__row--first" gutter_size="' . absint( $cart_columns_gap ) . '"';

		if ( $equal_height ) {
			$row_inner .= ' equal_height="yes"';
		}

		$row_inner .= ']';
		$output .= $row_inner;

		// Cart table
		$output .= $cart_table_output;

		// Cart totals
		$output .= $cart_totals_output;

		$output .= '[/vc_row_inner]';

		// Cross sells
		if ( $show_cross_sells && ! $cross_sells_after_cart_table ) {
			$output .= '[vc_row_inner el_class="uncode-wc-module__row" gutter_size="' . absint( $cart_columns_gap ) . '"]';
			$output .= $cross_sells_output;
			$output .= '[/vc_row_inner]';
		}

	} else {

		// Cart table
		$output .= '[vc_row_inner el_class="uncode-wc-module__row uncode-wc-module__row--first"]';
		$output .= $cart_table_output;
		$output .= '[/vc_row_inner]';

		// Cart totals
		$output .= '[vc_row_inner el_class="uncode-wc-module__row"]';
		$output .= $cart_totals_output;
		$output .= '[/vc_row_inner]';

		// Cross sells
		if ( $show_cross_sells && ! $cross_sells_after_cart_table ) {
			$output .= '[vc_row_inner el_class="uncode-wc-module__row"]';
			$output .= $cross_sells_output;
			$output .= '[/vc_row_inner]';
		}
	}

	$output .= wc_get_template_html( 'cart/uncode-after-cart.php' );
}

$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );

$output .= '</div>';

$output = uncode_woocommerce_inject_classes( $output, $injector_conf );

echo do_shortcode( $output );
