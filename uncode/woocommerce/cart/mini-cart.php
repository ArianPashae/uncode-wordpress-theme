<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="woocommerce-mini-cart-header">
	<div class="close-mini-cart btn btn-link"><?php esc_html_e( 'Close', 'uncode' ); ?></div>
</div>
<div class="woocommerce-mini-cart-body">
	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<?php
				do_action( 'woocommerce_before_mini_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

						$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
						$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="fa fa-cross"></i></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_html__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $cart_item_key ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							);
							?>
							<?php if ( empty( $product_permalink ) ) : ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php else : ?>
								<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>
							<?php endif; ?>
							<?php echo uncode_wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</li>
						<?php
					}
				}
			?>

		<?php else : ?>

			<li class="woocommerce-mini-cart__empty-message empty"><?php echo wp_kses_post( apply_filters( 'uncode_minicart_empty_cart_message', __( 'No products in the cart.', 'woocommerce' ) ) ); ?></li>

		<?php endif; ?>

		<?php do_action( 'woocommerce_mini_cart_contents' ); ?>

	</ul><!-- end product list -->
</div>

<?php if ( ! WC()->cart->is_empty() ) : ?>
<div class="woocommerce-mini-cart-footer">

	<p class="woocommerce-mini-cart__total total"><?php
		/**
		 * Woocommerce_widget_shopping_cart_total hook.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
	?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons">
		<a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-default btn-sm wc-forward"><?php esc_html_e( 'View cart', 'woocommerce' ); ?></a>
		<a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-default btn-sm checkout wc-forward"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
	</p>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
