<?php
/**
 * Related Posts functions
 */

/**
 * A super simple function that gets the IDs of related posts
 * based on the current post categories (or tags). Uses
 * Related Posts for WordPress instead if active.
 */
function uncode_get_related_post_ids( $post_id, $count = 3 ) {
	$related_ids = array();
	$post_type   = get_post_type( $post_id );

	if ( ! $post_type ) {
		return $related_ids;
	}

	if ( class_exists( 'RP4WP_Post_Link_Manager' ) ) {
		$uncode_related = new RP4WP_Post_Link_Manager();
		$related_posts  = $uncode_related->get_children($post_id,false);
		foreach ($related_posts as $key => $value) {
			if (isset($value->ID)) {
				$related_ids[] = $value->ID;
			}
		}
	} else {
		$args = array(
			'post_type'      => $post_type,
			'post__not_in'   => array( $post_id ),
			'posts_per_page' => -1,
		);

		switch ( $post_type ) {
			case 'post':
				$taxonomy = apply_filters( 'uncode_use_cat_in_posts_for_related_posts', true ) ? 'category' : 'post_tag';
				break;

			case 'page':
				$taxonomy = 'page_category';
				break;

			case 'portfolio':
				$taxonomy = 'portfolio_category';
				break;

			case 'product':
				$taxonomy = apply_filters( 'uncode_use_cat_in_products_for_related_posts', true ) ? 'product_cat' : 'product_tag';

				// Related products are random
				$args['orderby'] = apply_filters( 'uncode_related_posts_query_products_order', 'rand' );
				break;

			default:
				$taxonomy = apply_filters( 'uncode_cpt_taxonomy_for_related_posts', "{$post_type}_category" );
				break;
		}

		$cat_ids = get_the_terms( $post_id, $taxonomy );

		if ( is_array( $cat_ids ) && ! is_wp_error( $cat_ids ) ) {
			$cats_array = array();
			foreach ( $cat_ids as $cat ) {
				$cats_array[] = $cat->term_id;
			}

			$args[ 'tax_query' ] = array(
				array(
					'taxonomy' => $taxonomy,
					'terms'    => $cats_array
				)
			);
		}

		$args = apply_filters( 'uncode_related_posts_query', $args, $post_id );

		$related_query = new WP_Query( $args );

		if ( $related_query->have_posts() ) {
			while ( $related_query->have_posts() ) {
				$related_query->the_post();
				global $post;

				$related_ids[] = $post->ID;
			}

			wp_reset_postdata();
		}

		if ( ! apply_filters( 'uncode_disable_random_posts_on_related', false ) && $count > 0 ) {
			$missing_ids = $count - count( $related_ids );

			if ( $missing_ids > 0 ) {
				$ids_to_skip = $related_ids;
				$ids_to_skip[] = $post_id;

				// Get missing posts randomly
				$args = array(
					'post_type'      => $post_type,
					'post__not_in'   => $ids_to_skip,
					'posts_per_page' => $missing_ids,
				);

				$related_query = new WP_Query( $args );

				if ( $related_query->have_posts() ) {
					while ( $related_query->have_posts() ) {
						$related_query->the_post();
						global $post;

						$related_ids[] = $post->ID;
					}

					wp_reset_postdata();
				}
			}
		}
	}

	return $related_ids;
}
