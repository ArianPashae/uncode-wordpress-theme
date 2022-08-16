<?php
/**
 * Mini icon cart on menu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get cart items for minicart in menu
 */
function uncode_get_cart_items() {
	if ( class_exists( 'WooCommerce' ) ) {
		$articles = sizeof( WC()->cart->get_cart() );

		$cart = $tot_articles = '';

		if (  $articles > 0 ) {
			$tot_articles = WC()->cart->get_cart_contents_count();
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					$cart .= '<li class="cart-item-list clearfix">';
					if ( ! $_product->is_visible() ) {
						$cart .= str_replace( array( 'http:', 'https:' ), '', $thumbnail );
					} else {
						$cart .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-item_key="%s" data-product_sku="%s"><i class="fa fa-cross"></i></a>',
							esc_url( uncode_wc_get_cart_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						$cart .= '<a class="cart-thumb" href="'.esc_url(get_permalink( $product_id )).'">
									'.str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '
								</a>';
					}

					$cart .= '<div class="cart-desc"><span class="cart-item">' . $product_name . '</span>';

					$cart .= '<span class="product-quantity">'. apply_filters( 'woocommerce_widget_cart_item_quantity',  '<span class="quantity-container">' . sprintf( '%s &times; %s',$cart_item['quantity'] , '</span>' . $product_price ) , $cart_item, $cart_item_key ) . '</span>';
					$cart .= '</div>';
					$cart .= '</li>';
				}
			}

			$cart .= '<li class="subtotal"><span><strong>' . esc_html__('Subtotal:', 'woocommerce') . '</strong> ' . WC()->cart->get_cart_total() . '</span></li>';

			$cart .= '<li class="buttons clearfix">
									<a href="'.wc_get_cart_url().'" class="wc-forward btn btn-link"><i class="fa fa-bag"></i>'.esc_html__( 'View cart', 'woocommerce' ).'</a>
									<a href="'.wc_get_checkout_url().'" class="checkout wc-forward btn btn-link"><i class="fa fa-square-check"></i>'.esc_html__( 'Checkout', 'woocommerce' ).'</a>
								</li>';

		} else {
			$cart .= "<li><span>" . wp_kses_post( apply_filters( 'uncode_dropdown_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ) . "</span></li>";
		}

		return array('cart' => $cart, 'articles' => $tot_articles);

	}
}

/**
 * Cart icon menu (minicart)
 */
function uncode_woomenucart_ajax() {

	$cart = uncode_get_cart_items();

	echo json_encode($cart);

	die();
}
add_action( 'wp_ajax_woomenucart_ajax', 'uncode_woomenucart_ajax');
add_action( 'wp_ajax_nopriv_woomenucart_ajax', 'uncode_woomenucart_ajax' );

/**
 * Remove product from icon menu (minicart)
 */
if ( ! function_exists( 'uncode_woomenucart_remove_ajax' ) ) :
	/**
	 * @since Uncode 1.6.0
	 */
	function uncode_woomenucart_remove_ajax($return) {
		$cart = WC()->cart;
		$item_key = $_POST['item_key'] ? $_POST['item_key'] : 0;

		if($item_key){
			$cart->remove_cart_item( $item_key );
		}

		echo json_encode($cart);

		die();
	}
endif;//uncode_woomenucart_remove_ajax
add_action( 'wp_ajax_woomenucart_remove_ajax', 'uncode_woomenucart_remove_ajax');
add_action( 'wp_ajax_nopriv_woomenucart_remove_ajax', 'uncode_woomenucart_remove_ajax' );

/**
 * Add product to icon menu (minicart)
 */
function uncode_add_cart_in_menu($woo_icon, $woo_cart_class) {
	global $woocommerce, $menutype;

	$horizontal_menu = (strpos($menutype ,'hmenu') !== false) ? true : false;
	$tot_articles = $woocommerce->cart->cart_contents_count;
	$get_cart_items = uncode_get_cart_items();

	$vertical = (strpos($menutype, 'vmenu') !== false || $menutype === 'menu-overlay' || $menutype === 'menu-overlay-center') ? true : false;

	ob_start();
	?>

	<li class="<?php echo esc_attr( $woo_cart_class ); ?> uncode-cart menu-item-link menu-item menu-item-has-children dropdown">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" data-toggle="dropdown" class="dropdown-toggle" data-type="title" title="cart">
			<span class="cart-icon-container">
				<?php if ( $horizontal_menu ) : ?>
					<i class="<?php echo esc_attr( $woo_icon ); ?>"></i><span class="desktop-hidden"><?php esc_html_e( 'Cart','uncode' ); ?></span>
				<?php else : ?>
					<i class="<?php echo esc_attr( $woo_icon ); ?>"></i><span><?php esc_html_e( 'Cart','uncode' ); ?></span>
				<?php endif; ?>

				<?php if ( $tot_articles !== 0 ) : ?>
					<span class="badge"><?php echo esc_html( $tot_articles ); ?></span>
				<?php else : ?>
					<span class="badge" style="display: none;"></span>
				<?php endif; ?>

				<i class="fa fa-angle-down fa-dropdown <?php echo esc_attr( !$vertical ? ' desktop-hidden' : '' ); ?>"></i>
			</span>
		</a>

		<?php if ( ! uncode_is_sidecart_enabled() ) : ?>
			<ul role="menu" class="drop-menu sm-nowrap cart_list product_list_widget uncode-cart-dropdown">
				<?php if ( isset( $get_cart_items['cart'] ) && $get_cart_items['cart'] !=='' ) : ?>
					<?php echo uncode_switch_stock_string( $get_cart_items['cart'] ); ?>
				<?php else : ?>
					<li><span><?php echo wp_kses_post( apply_filters( 'uncode_dropdown_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ); ?></span></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</li>

	<?php
	$items = ob_get_clean();

    return $items;
}
