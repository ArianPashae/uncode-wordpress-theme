<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$post_type = uncode_get_current_post_type();

if ( ! $product && $post_type == 'uncodeblock' ) {
	$product = uncode_populate_post_object();
}

if ( ! $product ) {
	return;
}

$inline = ( isset( $vc_inline_meta ) && $vc_inline_meta == 'yes' ) ? ':' : '';
$text_size = isset ( $vc_text_lead ) ? ' ' . $vc_text_lead : '';

?>
<?php if ( ! isset ( $vc_shortcode ) ) { ?>
<hr />
<?php } ?>
<div class="product_meta<?php echo uncode_switch_stock_string( $text_size ); ?>">
	<p>
	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper detail-container"><span class="detail-label"><?php esc_html_e( 'SKU', 'woocommerce' ); ?><?php echo esc_html( $inline ); ?></span> <span class="sku detail-value" itemprop="sku"><?php echo esc_attr( ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ) ); ?></span></span>

	<?php endif; ?>

	<?php
		$product_categories = wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in detail-container">' . _n( '<span class="detail-label">' . esc_html__('Category','woocommerce') . esc_html( $inline ) . '</span><span class="detail-value">', '<span class="detail-label">' . esc_html__('Categories','woocommerce') . esc_html( $inline ) . '</span><span class="detail-value">', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span></span>' );
		echo wp_kses_post($product_categories);
	?>

	<?php
		$product_tags = wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as detail-container">' . _n( '<span class="detail-label">' . esc_html__('Tag','woocommerce') . esc_html( $inline ) . '</span><span class="detail-value">', '<span class="detail-label">' . esc_html__('Tags','woocommerce') . esc_html( $inline ) . '</span><span class="detail-value">', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span></span>' );
		echo wp_kses_post($product_tags);
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
	</p>
</div>
