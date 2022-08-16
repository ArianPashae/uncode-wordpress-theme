<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$post_type = uncode_get_current_post_type();

$heading = apply_filters( 'woocommerce_product_additional_information_heading', esc_html__( 'Additional information', 'woocommerce' ) );

?>

<?php if ( $heading && ! isset ( $vc_shortcode ) ) { ?>
<div class="product-tab">
<?php if ( $heading ): ?>
	<h5 class="product-tab-title"><?php echo esc_html($heading); ?></h5>
<?php endif; ?>

<?php do_action( 'woocommerce_product_additional_information', $product ); ?>
</div>
<?php } else {
	if ( function_exists('vc_is_page_editable') && vc_is_page_editable() && $post_type === 'uncodeblock' ) {
		uncode_product_additional_information_placeholder();
	} elseif ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
		do_action( 'woocommerce_product_additional_information', $product );
	} else {
		?><div id="no_additional_info"></div><?php
	}
} ?>
