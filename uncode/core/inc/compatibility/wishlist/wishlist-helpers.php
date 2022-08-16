<?php
/**
 * Wishlist functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if Yith Wishlist is active
if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}

/**
 * Add wishlist icon to menu
 */
function uncode_add_wishlist_in_menu( $woo_wishlist_icon, $woo_wishlist_class ) {
	global $menutype;

	$horizontal_menu = ( strpos($menutype ,'hmenu' ) !== false ) ? true : false;
	$vertical = ( strpos($menutype, 'vmenu' ) !== false || $menutype === 'menu-overlay' || $menutype === 'menu-overlay-center' ) ? true : false;

	$wishlist_url  = get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) );
	$wishlist_text = __( 'My Wishlist', 'uncode' );

	$tot_articles_in_wishlist = absint( yith_wcwl_count_all_products() );

	ob_start();
	?>

	<li class="<?php echo esc_attr( $woo_wishlist_class ); ?> uncode-wishlist menu-item-link menu-item">
		<a href="<?php echo esc_url( $wishlist_url ); ?>" data-type="title" title="wishlist">
			<span class="wishlist-icon-container">
				<?php if ( $horizontal_menu ) : ?>
					<i class="<?php echo esc_attr( $woo_wishlist_icon ); ?>"></i><span class="desktop-hidden"><?php echo esc_html( $wishlist_text ); ?></span>
				<?php else : ?>
					<i class="<?php echo esc_attr( $woo_wishlist_icon ); ?>"></i><span><?php echo esc_html( $wishlist_text ); ?></span>
				<?php endif; ?>

				<?php if ( $tot_articles_in_wishlist !== 0 ) : ?>
					<span class="badge"><?php echo esc_html( $tot_articles_in_wishlist ); ?></span>
				<?php else : ?>
					<span class="badge" style="display: none;"></span>
				<?php endif; ?>
			</span>
		</a>
	</li>

	<?php
	$icon = ob_get_clean();

    return $icon;
}

/**
 * Add wishlist button in single product page
 */
function uncode_add_wishlist_button_to_single_product() {
	if ( get_option( 'uncode_yith_wcwl_show_on_single_product', 'no' ) === 'yes' ) {
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
}
add_action( 'woocommerce_single_product_summary', 'uncode_add_wishlist_button_to_single_product', 32 );
