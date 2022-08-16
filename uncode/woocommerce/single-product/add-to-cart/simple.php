<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( !$product || ! $product->is_purchasable() ) {
	return;
}

$post_type = uncode_get_current_post_type();

?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo wc_get_stock_html( $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<?php $dynamic_button = isset ( $vc_shortcode ) ? ' dynamic-button' : ''; ?>

	<form class="cart<?php echo esc_attr( $dynamic_button ); if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) { echo ' woocommerce'; } ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>

	 	<?php
			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
			) );
	 	?>

	 	<?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

	 	<?php
	 	$link = array(
			'url'   => '',
			'label' => '',
			'class' => ''
		);

	 	if ( $product->is_purchasable() ) {
			$link['url']      = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
			$link['label']    = $product->single_add_to_cart_text();
			$ajax_add_to_cart = ot_get_option('_uncode_product_enable_ajax_add_to_cart') == 'on' ? ' ajax_add_to_cart' : '';
			$link['class']    = apply_filters( 'add_to_cart_class', 'add_to_cart_button' . $ajax_add_to_cart );
			if ( isset( $button_class ) ) {
				$button_class .= apply_filters( 'add_to_cart_class', ' add_to_cart_button' . $ajax_add_to_cart );
			}
		} else {
			$link['url']    = apply_filters( 'not_purchasable_url', get_permalink( $product->get_id() ) );
			$link['label']  = apply_filters( 'not_purchasable_text', esc_html__( 'Read More', 'woocommerce' ) );
		}

		$link['class'] = isset( $button_class ) ? $button_class : $link['class'] . ' btn-default';

	 	// Display the submit button.
    echo sprintf( '<button type="submit" name="add-to-cart" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s button alt btn product_type_simple ' . uncode_btn_style() . '" value="%s"><span class="add_to_cart_text">%s</span><span class="view-cart added_to_cart"></span></button>', esc_attr( $product->get_id() ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->get_id() ), esc_html( $link['label'] ) );
		do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>



<?php endif; ?>
