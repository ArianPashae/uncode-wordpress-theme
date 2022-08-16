<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) :

	$index = 0;
	global $limit_content_width, $page_custom_width;

	$with_builder = false;

	$the_content = get_the_content();
	if (has_shortcode($the_content, 'vc_row')) {
		$with_builder = true;
	}
	?>

	<div class="tab-container wootabs">
		<ul class="nav nav-tabs<?php echo esc_attr($limit_content_width); ?> single-h-padding text-center" <?php echo wp_kses_post( $page_custom_width ); ?>>
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

				<li class="<?php echo esc_attr( $key ); ?>_tab<?php if ($index === 0) { echo ' active'; } ?>" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr($key); ?>-<?php echo esc_attr(get_the_id()); ?>" data-toggle="tab"><span><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', wp_kses_post($product_tab['title']), $key ) ?></span></a>
				</li>

			<?php $index++;
			endforeach; ?>
		</ul>
		<div class="tab-content">
		<?php
			$index = 0;
			foreach ( $product_tabs as $key => $product_tab ) :

				ob_start();
				call_user_func( $product_tab['callback'], $key, $product_tab );
				$tab_content = ob_get_clean();

				if (substr_count($tab_content, 'row-container') || ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) ) { ?>
				<div class="tab-vcomposer tab-pane fade<?php if ($index === 0) { echo ' active in'; } ?>" id="tab-<?php echo esc_attr( $key ) ?>-<?php echo esc_attr(get_the_id()); ?>">
					<?php
					add_filter('woocommerce_product_description_heading', '__return_false' );
					call_user_func( $product_tab['callback'], $key, $product_tab );
					?>
				</div>
				<?php } else { ?>
				<div class="tab-pane fade<?php echo esc_attr( $limit_content_width ); ?> single-h-padding half-internal-gutter single-block-padding<?php if ($index === 0) { echo ' active in'; } ?>" id="tab-<?php echo esc_attr( $key ) ?>-<?php echo esc_attr(get_the_id()); ?>" <?php echo wp_kses_post( $page_custom_width ); ?>>
					<?php echo uncode_remove_p_tag( $tab_content ); ?>
				</div>
			<?php } ?>

		<?php $index++;
		endforeach; ?>
		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
		</div>
	</div>

<?php endif; ?>
