<?php
/**
 * Taxonomy related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'uncode_get_legacy_taxonomies' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_legacy_taxonomies() {
	$legacy_taxonomies = array(
		'category',
		'post_tag',
		'product_cat',
		'product_tag',
		'portfolio_category',
	);

	return $legacy_taxonomies;
}
endif;//uncode_get_legacy_taxonomies

if ( ! function_exists( 'uncode_get_legacy_taxonomy_cpt_labels' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_legacy_taxonomy_cpt_label( $tax, $count ) {
	switch ( $tax ) {
		case 'category':
		case 'post_tag':
			$label = $count !== 1 ? __( 'Posts', 'uncode' ) : __( 'Post', 'uncode' );
			break;

		case 'portfolio_category':
			$label = __( 'Portfolio', 'uncode' );
			break;

		case 'product_cat':
		case 'product_tag':
			$label = $count !== 1 ? __( 'Products', 'uncode' ) : __( 'Product', 'uncode' );
			break;

		default:
			$label = $count !== 1 ? __( 'Items', 'uncode' ) : __( 'Item', 'uncode' );
			break;
	}

	$label = apply_filters( 'uncode_posts_module_tax_query_items_label', $label, $tax, $count );

	return $label;
}
endif;//uncode_get_legacy_taxonomy_cpt_labels
