<?php
/**
 * Sidecart functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Print sidecart
 */
function uncode_print_sidecart() {
	if ( apply_filters( 'woocommerce_widget_cart_is_hidden', uncode_is_sidecart_hidden() ) ) {
		return;
	}

	$woo_cart = apply_filters( 'uncode_woo_cart', ot_get_option('_uncode_woocommerce_cart') );
	$woo_icon = apply_filters( 'uncode_woo_icon', ot_get_option('_uncode_woocommerce_cart_icon') );

	if ( $woo_cart !== 'on' || $woo_icon === '' ) {
		return;
	}

	$skin = ot_get_option( '_uncode_woocommerce_sidecart_skin');
	$skin = $skin == '' ? 'light' : $skin;
	$skin_bg = $skin == 'light' ? 'dark' : 'light';
	?>

	<div id="uncode_sidecart" class="uncode-cart woocommerce style-<?php echo esc_attr($skin); ?>">
		<div class="uncode-sidecart-wrapper">
			<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
		</div>
	</div>
	<div id="uncode_sidecart_overlay" class="overlay style-<?php echo esc_attr($skin_bg); ?>-bg"></div>

	<?php
}
add_action( 'wp_footer', 'uncode_print_sidecart' );

/**
 * Check if sidecart is enabled
 */
function uncode_is_sidecart_enabled() {
	$is_sidecart_enabled = ot_get_option('_uncode_woocommerce_minicart_style');
	$is_sidecart_enabled = $is_sidecart_enabled === 'sidecart' ? true : false;

	return apply_filters( 'uncode_woocommerce_sidecart_enabled', $is_sidecart_enabled );
}

/**
 * Check if sidecart is enabled on mobile
 */
function uncode_is_sidecart_mobile_enabled() {
	$is_sidecart_mobile_enabled = ot_get_option('_uncode_woocommerce_activate_sidecart_mobile');
	$is_sidecart_mobile_enabled = $is_sidecart_mobile_enabled === 'on' && uncode_is_sidecart_enabled() ? true : false;

	return apply_filters( 'uncode_woocommerce_sidecart_mobile_enabled', $is_sidecart_mobile_enabled );
}

/**
 * Display Side-Cart
 */
function uncode_is_sidecart_hidden() {
	$return = false;
	if( is_cart() || is_checkout() || ( ! uncode_is_sidecart_enabled() && ! uncode_is_sidecart_mobile_enabled() ) ) {
		$return = true;
	}
	return $return;
}
