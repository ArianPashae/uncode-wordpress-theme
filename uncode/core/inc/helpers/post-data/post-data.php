<?php
/**
 * Post Data related functions
 */

/**
 * Get the IDs of each content block attached to the page
 */
function uncode_get_post_data_content_block_ids() {
	global $uncode_post_data;

	$content_block_ids = array();

	// These are the keys inside $uncode_post_data
	// that hold a Content Block ID
	$content_block_keys = array(
		'header_cb_id',
		'content_cb_id',
		'footer_cb_id',
		'after_cb_id',
		'pre_cb_id'
	);

	foreach ( $uncode_post_data as $key => $value ) {
		if ( in_array( $key, $content_block_keys ) && $value > 0 ) {
			$content_block_ids[] = $value;
		}
	}

	$content_block_ids = array_unique( $content_block_ids );

	return $content_block_ids;
}

/**
 * Get an array that contains all the
 * raw content attached to the page
 */
function uncode_get_post_data_content_array() {
	global $uncode_post_data;

	if ( ! is_array( $uncode_post_data ) || ! isset( $uncode_post_data['post_content'] ) ) {
		return array();
	}

	$content_array = array(
		$uncode_post_data['post_content'],
	);

	$content_block_ids = uncode_get_post_data_content_block_ids();

	foreach ( $content_block_ids as $content_block_id ) {
		$content_block_id = apply_filters( 'wpml_object_id', $content_block_id, 'uncodeblock' );
		$content_array[]  = get_post_field( 'post_content', $content_block_id );
	}

	// Find content blocks in content
	$already_processed_ids = array();

	foreach ( $content_array as $content ) {
		// Check content blocks in content
		if ( strpos( $content, '[uncode_block' ) !== false ) {
			$regex = '/\[uncode_block(.*?)\]/';
			$regex_attr = '/(.*?)=\"(.*?)\"/';
			preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );

			foreach ( $matches as $key => $value ) {
				if (isset( $value[1] ) ) {
					preg_match_all( $regex_attr, trim( $value[ 1 ] ), $matches_attr, PREG_SET_ORDER );

					foreach ( $matches_attr as $key_attr => $value_attr ) {
						if ( 'id' === trim( $value_attr[1] ) ) {
							$cb_id = $value_attr[2];
							$cb_id = absint( apply_filters( 'wpml_object_id', $cb_id, 'uncodeblock' ) );

							if ( $cb_id > 0 && ! in_array( $cb_id, $already_processed_ids ) ) {
								$already_processed_ids[] = $cb_id;
								$content_array[] = get_post_field( 'post_content', $cb_id );
							}
						}
					}
				}
			}
		}

		// Check widgetized content blocks in post modules
		if ( strpos( $content, 'widgetized_content_block_id' ) !== false ) {
			$regex = '/widgetized_content_block_id=\"(\d+)\"/';
			preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );

			foreach ( $matches as $key => $value ) {
				if (isset( $value[1] ) ) {
					$cb_id = trim( $value[1] );
					$cb_id = absint( apply_filters( 'wpml_object_id', $cb_id, 'uncodeblock' ) );
					if ( $cb_id > 0 && ! in_array( $cb_id, $already_processed_ids ) ) {
						$already_processed_ids[] = $cb_id;
						$content_array[] = get_post_field( 'post_content', $cb_id );
					}
				}
			}
		}
	}

	return $content_array;
}
