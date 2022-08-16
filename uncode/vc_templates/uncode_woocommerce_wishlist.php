<?php
extract(
	shortcode_atts(
		array(
			'icon_text_size' => '',
			'text_uppercase' => '',
			'bold_text' => '',
			'css_animation' => '',
			'animation_delay' => '',
			'animation_speed' => '',
			'el_id' => '',
			'el_class' => '',
		),
		$atts
	)
);

$text_lead      = $icon_text_size !== '' ? $icon_text_size : false;
$text_uppercase = $text_uppercase !== '' ? $text_uppercase : false;
$bold_text      = $bold_text === 'yes' ? true : false;

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
$container_classes = array( 'uncode-wrapper', 'uncode-wishlist-module' );

if ( $el_class ) {
	$extra_classes = explode( ' ', $el_class );

	foreach ( $extra_classes as $extra_class ) {
		$container_classes[] = $extra_class;
	}
}

// Bold text
if ( $bold_text ) {
	$container_classes[] = 'bold-text';
}

// Uppercase
if ( $text_uppercase ) {
	$container_classes[] = 'text-uppercase';
}

// Text size class
if ( $text_lead === 'yes' ) {
	$container_classes[] = 'module-text-lead';
} else if ( $text_lead === 'small' ) {
	$container_classes[] = 'module-text-small';
}

$div_data = array();
if ($css_animation !== '') {
	$container_classes[] = $css_animation . ' animate_when_almost_visible';
	if ($animation_delay !== '') {
		$div_data['data-delay'] = $animation_delay;
	}
	if ($animation_speed !== '') {
		$div_data['data-speed'] = $animation_speed;
	}
}

$div_data_attributes = array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $div_data, array_keys($div_data));

global $product;

if ( ! $product ) {
	$product_object = uncode_populate_post_object();
} else {
	$product_object = $product;
}

if ( class_exists( 'WooCommerce' ) ) {
	$product_id = $product_object->get_id();

	if ( ! class_exists( 'YITH_WCWL' ) ) {
		if ( current_user_can( 'administrator' ) ) {
			$output = wp_kses_post( sprintf( __( 'You need to install <a href="%s" target="_blank">YITH WooCommerce Wishlist</a> to use this module.', 'uncode' ), 'https://wordpress.org/plugins/yith-woocommerce-wishlist/' ) );

			echo uncode_remove_p_tag($output);
		}
	} else {
		$output = '<div ' . $container_id . ' class="' . esc_attr( trim( implode( ' ', $container_classes ) ) ) . '" ' . implode( ' ', $div_data_attributes ) . '>';
		$output .= do_shortcode( "[yith_wcwl_add_to_wishlist product_id='" . $product_id . "']" );
		$output .= '</div>';

		echo uncode_remove_p_tag($output);
	}
}
