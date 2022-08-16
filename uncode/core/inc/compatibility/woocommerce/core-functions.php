<?php

/**
 * Declare WC features support
 */
if ( ! function_exists( 'uncode_woocommerce_support' ) ) :
	/**
	 * @since Uncode 1.6.0
	 */
	function uncode_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif;//uncode_woocommerce_support
add_action( 'after_setup_theme', 'uncode_woocommerce_support' );

/**
 * WC dependent scripts
 */
function uncode_woo_scripts() {
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

    if ( apply_filters( 'uncode_dequeue_prettyphoto', true ) ) {
    	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
    	wp_dequeue_script( 'prettyPhoto' );
    }

    wp_deregister_style( 'select2');
    wp_dequeue_script( 'prettyPhoto-init' );
    wp_dequeue_script( 'wc-chosen');

    if ( ot_get_option( '_uncode_woocommerce_atc_notify' ) == 'minicart' && ot_get_option('_uncode_woocommerce_cart') === 'on' ) {
	    wp_enqueue_script( 'imagesloaded' );
	}
}
add_action( 'wp_enqueue_scripts', 'uncode_woo_scripts', 99 );

/**
 * Dequeue default WC scripts
 */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * When using AJAX, pass the correct quantity when adding a product to the cart
 */
function uncode_wc_loop_add_to_cart_scripts() {
    if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) : ?>

		<script>
			window.addEventListener("load", function(){
				jQuery( document ).on( 'change', '.quantity .qty', function() {
					jQuery( this ).closest('form.cart').find('.add_to_cart_button').attr( 'data-quantity', jQuery( this ).val() );
				});
			}, false);
		</script>

    <?php endif;

	if ( isset( $_REQUEST['add-to-cart'] ) ) : ?>

		<script>
			(function( $ ) {
				$( document.body ).trigger( 'uncode-wc-added-to-cart' );
			})(jQuery);
		</script>

    <?php endif;

}
add_action( 'wp_footer', 'uncode_wc_loop_add_to_cart_scripts' );

/**
 * Add class to body
 */
function uncode_wc_body_classes( $classes ) {
	if ( isset( $_REQUEST['add-to-cart'] ) ) {
		$classes[] = 'uncode-wc-added-to-cart';
	}

	if ( ! uncode_is_sidecart_mobile_enabled() ) {
		$classes[] = 'uncode-sidecart-mobile-disabled';
	}

	if ( is_cart() && WC()->cart->is_empty() ) {
		$classes[] = 'cart-is-empty';
	}

	if ( is_checkout() ) {
		if ( WC()->cart->needs_payment() ) {
			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
			WC()->payment_gateways()->set_current_gateway( $available_gateways );
		} else {
			$available_gateways = array();
		}

		if ( count( $available_gateways ) > 1 ) {
			$classes[] = 'has-multiple-gateways';
		} else {
			$classes[] = 'has-single-gateway';
		}
	}

	return $classes;

}
add_action( 'body_class', 'uncode_wc_body_classes' );

/**
 * Get remove product URL
 */
if ( ! function_exists( 'uncode_wc_get_cart_remove_url' ) ) :
	/**
	 * @since Uncode 1.7.3
	 */
	function uncode_wc_get_cart_remove_url($cart_item_key) {
		if ( function_exists( 'wc_get_cart_remove_url' ) ) {
			return wc_get_cart_remove_url($cart_item_key);
		} else {
			return WC()->cart->get_remove_url( $cart_item_key );
		}
	}
endif;//uncode_wc_get_cart_remove_url

/**
 * Get formatted cart item data
 */
if ( ! function_exists( 'uncode_wc_get_formatted_cart_item_data' ) ) :
	/**
	 * @since Uncode 1.7.3
	 */
	function uncode_wc_get_formatted_cart_item_data($cart_item) {

		if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
			return wc_get_formatted_cart_item_data($cart_item);
		} else {
			return WC()->cart->get_item_data( $cart_item );
		}
	}
endif;//uncode_wc_get_formatted_cart_item_data

/**
 * Hide product title
 */
function uncode_woocommerce_hide_product_title() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}

/**
 * Reset WC loop
 */
function uncode_wc_single_reset_loop() {
	unset( $GLOBALS['woocommerce_loop'] );
}
add_action( 'woocommerce_after_shop_loop_item', 'uncode_wc_single_reset_loop', 999 );

/**
 * Custom checkout button
 */
function woocommerce_button_proceed_to_checkout() {
	$checkout_url = wc_get_checkout_url();

	?>
	<a href="<?php echo esc_url($checkout_url); ?>" class="checkout-button btn btn-default alt wc-forward <?php echo uncode_btn_style(); ?>"><?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?></a>
	<?php
}

/**
 * Custom variation add to cart button get template
 */
function woocommerce_single_variation_add_to_cart_button() {
	$args = apply_filters( 'uncode_woocommerce_single_variation_add_to_cart_button_args', array() );
	wc_get_template( 'single-product/add-to-cart/variation-add-to-cart-button.php', $args );
}

/**
 * Load single product JS in Single Product builder
 */
if ( ! function_exists( 'woocommerce_product_builder_wp_enqueue_scripts' ) ) :
	/**
	 * @since Uncode 1.7.3
	 */
	function woocommerce_product_builder_wp_enqueue_scripts() {
		$post_type = isset( $post->post_type ) ? $post->post_type : 'post';
		if ( ( class_exists( 'WooCommerce' ) && function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) {
			wp_enqueue_script( 'wc-single-product' );
			wp_enqueue_script( 'zoom' );
		}
	}
endif;//woocommerce_product_builder_wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'woocommerce_product_builder_wp_enqueue_scripts', 100 );

/**
 * Track product views.
 *
 * (basically a copy of wc_track_product_view())
 */
function uncode_woocommerce_track_product_view() {
	if ( ! is_singular( 'product' ) || is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) || apply_filters( 'uncode_woocommerce_disable_product_view_tracking', false ) ) {
		return;
	}

	global $post;

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
		$viewed_products = array();
	} else {
		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
	}

	// Unset if already in viewed products list.
	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $post->ID ] ) ) {
		unset( $viewed_products[ $keys[ $post->ID ] ] );
	}

	$viewed_products[] = $post->ID;

	if ( count( $viewed_products ) > 15 ) {
		array_shift( $viewed_products );
	}

	// Store for session only.
	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
add_action( 'template_redirect', 'uncode_woocommerce_track_product_view', 20 );
