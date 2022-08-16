<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract(
	shortcode_atts(
		array(
			'el_id'                                    => '',
			'el_class'                                 => '',
			'account_forms_form_type'                  => 'login',
			'account_forms_show_titles'                => 'yes',
			'custom_titles_typography'                 => '',
			'titles_font'                              => '',
			'titles_size'                              => '',
			'titles_weight'                            => '',
			'titles_transform'                         => '',
			'titles_height'                            => '',
			'titles_space'                             => '',
			'text_lead'                                => '',
			'bold_text'                                => '',
			'form_style'                               => '',
			'account_forms_activate_custom_buttons'    => '',
			'account_forms_button_button_color'        => '',
			'account_forms_button_size'                => '',
			'account_forms_button_btn_link_size'       => '',
			'account_forms_button_radius'              => '',
			'account_forms_button_border_animation'    => '',
			'account_forms_button_wide'                => '',
			'account_forms_button_hover_fx'            => '',
			'account_forms_button_outline'             => '',
			'account_forms_button_text_skin'           => '',
			'account_forms_button_shadow'              => '',
			'account_forms_button_shadow_weight'       => '',
			'account_forms_button_custom_typo'         => '',
			'account_forms_button_font_family'         => '',
			'account_forms_button_font_weight'         => '',
			'account_forms_button_text_transform'      => '',
			'account_forms_button_letter_spacing'      => '',
			'account_forms_button_border_width'        => '',
			'account_forms_manual_button_adjust'       => '',
			'account_forms_manual_button_adjust_value' => '',
		),
		$atts
	)
);

// General settings
$account_forms_form_type   = $account_forms_form_type ? $account_forms_form_type : 'login';
$account_forms_show_titles = $account_forms_show_titles === 'yes' ? true : false;
$custom_titles_typography  = $custom_titles_typography === 'yes' ? true : false;
$titles_font               = $titles_font ? $titles_font : false;
$titles_size               = $titles_size ? $titles_size : 'h2';
$titles_weight             = $titles_weight ? $titles_weight : false;
$titles_transform          = $titles_transform ? $titles_transform : false;
$titles_height             = $titles_height ? $titles_height : false;
$titles_space              = $titles_space ? $titles_space : false;
$text_lead                 = $text_lead !== '' ? $text_lead : false;
$bold_text                 = $bold_text === 'yes' ? true : false;
$form_style                = $form_style !== '' ? $form_style : 'default';

// Button settings
$account_forms_activate_custom_buttons    = $account_forms_activate_custom_buttons === '' ? false : true;
$account_forms_button_button_color        = $account_forms_button_button_color ? $account_forms_button_button_color : false;
$account_forms_button_size                = $account_forms_button_size ? $account_forms_button_size : false;
$account_forms_button_btn_link_size       = $account_forms_button_btn_link_size ? $account_forms_button_btn_link_size : false;
$account_forms_button_radius              = $account_forms_button_radius !== '' ? $account_forms_button_radius : false;
$account_forms_button_border_animation    = $account_forms_button_border_animation !== '' ? $account_forms_button_border_animation : false;
$account_forms_button_wide                = $account_forms_button_wide === 'yes' ? true : false;
$account_forms_button_hover_fx            = $account_forms_button_hover_fx !== '' ? $account_forms_button_hover_fx : false;
$account_forms_button_outline             = $account_forms_button_outline === 'yes' ? true : false;
$account_forms_button_text_skin           = $account_forms_button_text_skin === 'yes' ? true : false;
$account_forms_button_shadow              = $account_forms_button_shadow === 'yes' ? true : false;
$account_forms_button_shadow_weight       = $account_forms_button_shadow_weight !== '' ? $account_forms_button_shadow_weight : false;
$account_forms_button_custom_typo         = $account_forms_button_custom_typo === 'yes' ? true : false;
$account_forms_button_font_family         = $account_forms_button_font_family !== '' ? $account_forms_button_font_family : false;
$account_forms_button_font_weight         = $account_forms_button_font_weight !== '' ? $account_forms_button_font_weight : false;
$account_forms_button_text_transform      = $account_forms_button_text_transform !== '' ? $account_forms_button_text_transform : 'initial';
$account_forms_button_letter_spacing      = $account_forms_button_letter_spacing !== '' ? $account_forms_button_letter_spacing : 'no-letterspace';
$account_forms_button_border_width        = $account_forms_button_border_width !== '' ? absint( $account_forms_button_border_width ) : 0;
$account_forms_manual_button_adjust       = $account_forms_manual_button_adjust === 'yes' ? true : false;
$account_forms_manual_button_adjust_value = $account_forms_manual_button_adjust && $account_forms_manual_button_adjust_value !== '' ? absint( $account_forms_manual_button_adjust_value ) : 0;

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
$container_classes = array( 'uncode-wc-module', 'uncode-wc-account-forms', 'woocommerce' );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

// Inject HTML classes
$injector_conf = array(
	'title'   => array(),
	'button'  => array()
);

// Hide title class
if ( ! $account_forms_show_titles ) {
	$container_classes[] = 'no-account-forms-titles';
}

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

// Bold text
if ( $bold_text ) {
	$container_classes[] = 'bold-text';
}

// Text size class
if ( $text_lead === 'yes' ) {
	$container_classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$container_classes[] = 'module-text-small';
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

// Button adjust
if ( $account_forms_manual_button_adjust && $account_forms_manual_button_adjust_value ) {
	$container_classes[] = 'with-button-adjust';
}

// Buttons
$buttons_conf = array(
	'activate_buttons'        => $account_forms_activate_custom_buttons,
	'button_color'            => $account_forms_button_button_color,
	'button_size'             => $account_forms_button_size,
	'button_link_size'        => $account_forms_button_btn_link_size,
	'button_radius'           => $account_forms_button_radius,
	'button_border_animation' => $account_forms_button_border_animation,
	'button_wide'             => $account_forms_button_wide,
	'button_hover_fx'         => $account_forms_button_hover_fx,
	'button_outline'          => $account_forms_button_outline,
	'button_text_skin'        => $account_forms_button_text_skin,
	'button_shadow'           => $account_forms_button_shadow,
	'button_shadow_weight'    => $account_forms_button_shadow_weight,
	'button_custom_typo'      => $account_forms_button_custom_typo,
	'button_font_family'      => $account_forms_button_font_family,
	'button_font_weight'      => $account_forms_button_font_weight,
	'button_text_transform'   => $account_forms_button_text_transform,
	'button_letter_spacing'   => $account_forms_button_letter_spacing,
	'button_border_width'     => $account_forms_button_border_width,
);

// Main buttons
$buttons_conf_classes = uncode_woocommerce_get_buttons_conf_classes( $buttons_conf );
$main_buttons_classes = uncode_woocommerce_get_button_classes( $buttons_conf_classes );

$injector_conf[ 'button' ] = $main_buttons_classes;

$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '">';

if ( $account_forms_form_type === 'login' ) {
	$output .= wc_get_template_html( 'myaccount/uncode-my-account-form-login.php', array( 'form_classes' => $injector_conf, 'button_adjust_value' => $account_forms_manual_button_adjust_value ) );
} else if ( $account_forms_form_type === 'register' ) {
	$output .= wc_get_template_html( 'myaccount/uncode-my-account-form-register.php', array( 'form_classes' => $injector_conf, 'button_adjust_value' => $account_forms_manual_button_adjust_value ) );
} else if ( $account_forms_form_type === 'tracking' ) {
	$output .= wc_get_template_html( 'order/uncode-form-tracking.php', array( 'form_classes' => $injector_conf, 'button_adjust_value' => $account_forms_manual_button_adjust_value ) );
}

$output .= '</div>';

echo do_shortcode( $output );
