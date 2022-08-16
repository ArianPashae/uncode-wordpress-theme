<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract(
	shortcode_atts(
		array(
			'uncode_shortcode_id'                    => '',
			'el_id'                                  => '',
			'el_class'                               => '',
			'equal_height'                           => '',
			'my_account_main_area_size'              => '8',
			'my_account_columns_gap'                 => '3',
			'my_account_vertical_align'              => '',
			'text_lead'                              => '',
			'bold_text'                              => '',
			'form_style'                             => '',
			'my_account_content_override_padding'    => '',
			'my_account_content_column_padding'      => '',
			'my_account_content_style'               => '',
			'my_account_content_back_color'          => '',
			'my_account_content_back_color_type'     => '',
			'my_account_content_back_color_solid'    => '',
			'my_account_content_back_color_gradient' => '',
			'my_account_content_sticky'              => '',
			'my_account_content_shadow'              => '',
			'my_account_content_shadow_darker'       => '',
			'my_account_content_radius'              => '',
			'my_account_nav_override_padding'        => '',
			'my_account_nav_column_padding'          => '',
			'my_account_nav_style'                   => '',
			'my_account_nav_back_color'              => '',
			'my_account_nav_back_color_type'         => '',
			'my_account_nav_back_color_solid'        => '',
			'my_account_nav_back_color_gradient'     => '',
			'my_account_nav_sticky'                  => '',
			'my_account_nav_shadow'                  => '',
			'my_account_nav_shadow_darker'           => '',
			'my_account_nav_radius'                  => '',
		),
		$atts
	)
);

// General settings
$my_account_layout          = 'horizontal';
$equal_height               = $equal_height === 'yes' ? true : false;
$my_account_main_area_size  = $my_account_main_area_size !== '' ? absint( $my_account_main_area_size ) : 8;
$my_account_sidebar_size    = 12 - $my_account_main_area_size;
$my_account_columns_gap     = $my_account_columns_gap !== '' ? absint( $my_account_columns_gap ) : 3;
$my_account_vertical_align  = $my_account_vertical_align === 'top' ? 'top' : 'middle';
$text_lead                  = $text_lead !== '' ? $text_lead : false;
$bold_text                  = $bold_text === 'yes' ? true : false;
$form_style                 = $form_style !== '' ? $form_style : 'default';

// Main column settings
$my_account_content_override_padding = $my_account_content_override_padding === 'yes' ? true : false;
$my_account_content_column_padding   = $my_account_content_column_padding !== '' ? absint( $my_account_content_column_padding ) : 2;
$my_account_content_style            = $my_account_content_style ? $my_account_content_style : false;
$my_account_content_back_color       = $my_account_content_back_color ? $my_account_content_back_color : false;
$my_account_content_sticky           = $my_account_content_sticky === 'yes' ? true : false;
$my_account_content_shadow           = $my_account_content_shadow ? $my_account_content_shadow : false;
$my_account_content_shadow_darker    = $my_account_content_shadow_darker === 'yes' ? true : false;
$my_account_content_radius           = $my_account_content_radius ? $my_account_content_radius : false;

// Nav settings
$my_account_nav_override_padding = $my_account_nav_override_padding === 'yes' ? true : false;
$my_account_nav_column_padding   = $my_account_nav_column_padding !== '' ? absint( $my_account_nav_column_padding ) : 2;
$my_account_nav_style            = $my_account_nav_style ? $my_account_nav_style : false;
$my_account_nav_back_color       = $my_account_nav_back_color ? $my_account_nav_back_color : false;
$my_account_nav_sticky           = $my_account_nav_sticky === 'yes' ? true : false;
$my_account_nav_shadow           = $my_account_nav_shadow ? $my_account_nav_shadow : false;
$my_account_nav_shadow_darker    = $my_account_nav_shadow_darker === 'yes' ? true : false;
$my_account_nav_radius           = $my_account_nav_radius ? $my_account_nav_radius : false;

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
	'type'       => 'uncode_woocommerce_my_account',
	'id'         => $uncode_shortcode_id,
	'attributes' => array(
		'my_account_nav_back_color'              => $my_account_nav_back_color,
		'my_account_nav_back_color_type'         => $my_account_nav_back_color_type,
		'my_account_nav_back_color_solid'        => $my_account_nav_back_color_solid,
		'my_account_nav_back_color_gradient'     => $my_account_nav_back_color_gradient,
		'my_account_content_back_color'          => $my_account_content_back_color,
		'my_account_content_back_color_type'     => $my_account_content_back_color_type,
		'my_account_content_back_color_solid'    => $my_account_content_back_color_solid,
		'my_account_content_back_color_gradient' => $my_account_content_back_color_gradient,
	)
) );

$my_account_nav_back_color = uncode_get_shortcode_color_attribute_value( 'my_account_nav_back_color', $uncode_shortcode_id, $my_account_nav_back_color_type, $my_account_nav_back_color, $my_account_nav_back_color_solid, $my_account_nav_back_color_gradient );
$my_account_content_back_color = uncode_get_shortcode_color_attribute_value( 'my_account_content_back_color', $uncode_shortcode_id, $my_account_content_back_color_type, $my_account_content_back_color, $my_account_content_back_color_solid, $my_account_content_back_color_gradient );

// Custom classes
$container_classes = array( 'uncode-wc-module', 'uncode-wc-my-account', 'woocommerce', 'uncode-wc-my-account--' . $my_account_layout );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

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

// Bold text
if ( $bold_text ) {
	$container_classes[] = 'bold-text';
}

// Vertical align
if ( $my_account_vertical_align ) {
	$container_classes[] = 'vertical-align-' . $my_account_vertical_align;
}

// Text size class
if ( $text_lead === 'yes' ) {
	$container_classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$container_classes[] = 'module-text-small';
}

$shortcode_id = rand();

// Main column settings
$main_column_settings = array(
	'override_padding' => $my_account_content_override_padding,
	'column_padding'   => $my_account_content_column_padding,
	'style'            => $my_account_content_style,
	'back_color'       => $my_account_content_back_color,
	'shadow'           => $my_account_content_shadow,
	'shadow_darker'    => $my_account_content_shadow_darker,
	'radius'           => $my_account_content_radius,
);

$output .= '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" data-id="' . esc_attr( $shortcode_id ) . '">';

// From WC_Shortcode_My_Account::output
global $wp;

// Check cart class is loaded or abort.
if ( is_null( WC()->cart ) ) {
	return;
}

if ( ! is_user_logged_in() ) {
	ob_start(); // edited by Uncode
	$message = apply_filters( 'woocommerce_my_account_message', '' );

	if ( ! empty( $message ) ) {
		wc_add_notice( $message );
	}

	// After password reset, add confirmation message.
	if ( ! empty( $_GET['password-reset'] ) ) { // WPCS: input var ok, CSRF ok.
		wc_add_notice( __( 'Your password has been reset successfully.', 'woocommerce' ) );
	}

	if ( isset( $wp->query_vars['lost-password'] ) ) {
		WC_Shortcode_My_Account::lost_password();
	} else {
		wc_get_template( 'myaccount/form-login.php' );
	}

	$row_content = ob_get_clean(); // edited by Uncode

	// Append a row using the main column settings
	$output .= uncode_woocommerce_print_single_row( $main_column_settings, false, $row_content, 'uncode-wc-module__row--first' );
} else {
	if ( isset( $wp->query_vars['customer-logout'] ) ) {
		/* translators: %s: logout url */
		wc_add_notice( sprintf( __( 'Are you sure you want to log out? <a href="%s">Confirm and log out</a>', 'woocommerce' ), wc_logout_url() ) );
	}

	/********************************
	 * Nav column
	 ********************************/
	$nav_column_output = '[vc_column_inner';

	// size
	$nav_column_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $my_account_sidebar_size ) . '"';

	// custom padding
	if ( $my_account_nav_override_padding ) {
		$nav_column_output .= ' override_padding="yes"';
		$nav_column_output .= ' column_padding="' . absint( $my_account_nav_column_padding ) . '"';
	}

	// skin
	if ( $my_account_nav_style ) {
		$nav_column_output .= ' style="' . esc_attr( $my_account_nav_style ) . '"';
	}

	// background color
	if ( $my_account_nav_back_color ) {
		$nav_column_output .= ' back_color="' . esc_attr( $my_account_nav_back_color ) . '"';
	}

	// sticky
	if ( $my_account_nav_sticky && ! $equal_height ) {
		$nav_column_output .= ' sticky="yes"';
	}

	// shadow
	if ( $my_account_nav_shadow ) {
		$nav_column_output .= ' shadow="' . esc_attr( $my_account_nav_shadow ) . '"';

		if ( $my_account_nav_shadow_darker ) {
			$nav_column_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $my_account_nav_radius ) {
		$nav_column_output .= ' radius="' . esc_attr( $my_account_nav_radius ) . '"';
	}

	$nav_column_output .= ']';

	$nav_column_output .= wc_get_template_html( 'myaccount/uncode-my-account-navigation.php' );

	$nav_column_output .= '[/vc_column_inner]';

	/********************************
	 * Main column
	 ********************************/

	$main_column_output = '[vc_column_inner';

	// size
	$main_column_output .= ' width="' . uncode_woocommerce_get_grid_col_size( $my_account_main_area_size ) . '"';

	// custom padding
	if ( $my_account_content_override_padding ) {
		$main_column_output .= ' override_padding="yes"';
		$main_column_output .= ' column_padding="' . absint( $my_account_content_column_padding ) . '"';
	}

	// skin
	if ( $my_account_content_style ) {
		$main_column_output .= ' style="' . esc_attr( $my_account_content_style ) . '"';
	}

	// background color
	if ( $my_account_content_back_color ) {
		$main_column_output .= ' back_color="' . esc_attr( $my_account_content_back_color ) . '"';
	}

	// sticky
	if ( $my_account_content_sticky && ! $my_account_nav_sticky && ! $equal_height ) {
		$main_column_output .= ' sticky="yes"';
	}

	// shadow
	if ( $my_account_content_shadow ) {
		$main_column_output .= ' shadow="' . esc_attr( $my_account_content_shadow ) . '"';

		if ( $my_account_content_shadow_darker ) {
			$main_column_output .= ' shadow_darker="yes"';
		}
	}

	// radius
	if ( $my_account_content_radius ) {
		$main_column_output .= ' radius="' . esc_attr( $my_account_content_radius ) . '"';
	}

	$main_column_output .= ']';

	$main_column_output .= wc_get_template_html( 'myaccount/uncode-my-account-content.php' );

	$main_column_output .= '[/vc_column_inner]';

	// Build grid

	// Build inner row
	$row_inner = '[vc_row_inner el_class="uncode-wc-module__row uncode-wc-module__row--first" gutter_size="' . absint( $my_account_columns_gap ) . '"';

	if ( $equal_height ) {
		$row_inner .= ' equal_height="yes"';
	}

	$row_inner .= ']';
	$output .= $row_inner;

	// Nav column
	$output .= $nav_column_output;

	// Main column
	$output .= $main_column_output;

	$output .= '[/vc_row_inner]';
}

$output .= uncode_print_dynamic_colors_inline_style( $inline_style_css );

$output .= '</div>';

echo do_shortcode( $output );
