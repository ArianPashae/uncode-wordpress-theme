<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

$post_type = uncode_get_current_post_type();

if ( ! $product && $post_type == 'uncodeblock' ) {
	$product = uncode_populate_post_object();
}

if ( ! wc_review_ratings_enabled() || ! $product ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( function_exists( 'vc_is_page_editable' ) && vc_is_page_editable() ) {
	$display_count = 1;
	$average = 1;
} else {
	$display_count = $rating_count;
}

if ( $display_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<?php echo wc_get_rating_html( $average, $display_count ); // WPCS: XSS ok. ?>
		<?php if ( comments_open() ) : ?>
			<?php //phpcs:disable ?>
			<<?php if ( ! isset( $vc_no_link ) || $vc_no_link !== 'yes' ) { ?>a href="<?php echo esc_url( apply_filters( 'uncode_woocommerce_get_reviews_anchor_link', '#reviews' ) ); ?>"<?php } else { ?>span<?php } ?> class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</<?php if ( ! isset( $vc_no_link ) || $vc_no_link !== 'yes' ) { ?>a<?php } else { ?>span<?php } ?>>
			<?php // phpcs:enable ?>
		<?php endif ?>
	</div>

<?php endif; ?>
