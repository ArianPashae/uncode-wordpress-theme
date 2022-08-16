<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$post_type = uncode_get_current_post_type();

do_action( 'woocommerce_before_add_to_cart_form' );

$dynamic_button = isset ( $vc_shortcode ) ? ' dynamic-button' : '';

?>

<form class="cart<?php echo esc_attr( $dynamic_button ); if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || $post_type == 'uncodeblock' ) { echo ' woocommerce'; } ?>" action="<?php echo esc_url( $product_url ); ?>" method="get">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php // BEGIN UNCODE EDIT
		$button_class = isset( $button_class ) ? $button_class : 'alt btn btn-default';
	?>
	<button type="submit" class="single_add_to_cart_button button <?php echo esc_attr( uncode_btn_style() ); ?> <?php echo esc_attr( $button_class ); ?>"><?php echo esc_html( $button_text ); ?></button>
	<?php // END UNCODE EDIT ?>

	<?php wc_query_string_form_fields( $product_url ); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
