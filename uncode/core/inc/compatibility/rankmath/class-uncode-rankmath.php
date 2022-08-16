<?php
/**
 * Uncode Rank Math support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Return early if Rank Math is not active
if ( ! class_exists( 'RankMath' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_RankMath_Support' ) ) :

/**
 * Uncode_RankMath_Support Class
 */
class Uncode_RankMath_Support {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Add images to sitemap
		add_filter('rank_math/sitemap/urlimages', array( $this, 'add_images_to_sitemap' ), NULL, 2);
	}

	/**
	 * Add images to sitemap
	 */
	public function add_images_to_sitemap( $images, $post_id ) {

		$post = get_post($post_id);
		$content = $post->post_content;

		$image_ids = array();

		//Find uncode_index occurences and match IDs inside them
		preg_match_all( '/\[uncode_index ([^\]]*)by_id:(.*?)[\||"]/', $content, $uncode_index );

		if ( isset( $uncode_index[2] ) && !empty($uncode_index[2]) ) { //If "by_id" values exist
			$uncode_index_ids = $uncode_index[2];
			foreach ( $uncode_index_ids as $uncode_index_ids_occurence ) {
				$uncode_index_ids_occurence_list = explode(',',$uncode_index_ids_occurence);

				foreach ($uncode_index_ids_occurence_list as $uncode_index_id) {
					$thumb_id_here = get_post_thumbnail_id($uncode_index_id);//Get featured image IDs from post ID
					if ( $thumb_id_here !== ''  && $thumb_id_here != 0 ) {
						$image_ids[] = $thumb_id_here; //Store featured image ID
					}
				}
			}
		}

		//Find vc_single_image occurences and match IDs inside them
		preg_match_all( '/\[vc_single_image([^\]]*) media="(.*?)"/', $content, $vc_single_image );

		if ( isset( $vc_single_image[2] ) && !empty($vc_single_image[2]) ) { //If "media" values exist
			$vc_single_image_ids = $vc_single_image[2];
			foreach ( $vc_single_image_ids as $vc_single_image_ids_occurence ) {
				$image_ids[] = $vc_single_image_ids_occurence; //Store single image ID
			}
		}

		//Find vc_gallery occurences and match IDs inside them
		preg_match_all( '/\[vc_gallery([^\]]*) medias="(.*?)"/', $content, $vc_gallery );

		if ( isset( $vc_gallery[2] ) && !empty($vc_gallery[2]) ) { //If "medias" values exist
			$vc_gallery_ids = $vc_gallery[2];
			foreach ( $vc_gallery_ids as $vc_gallery_ids_occurence ) {
				$vc_gallery_ids_occurence_list = explode(',',$vc_gallery_ids_occurence);

				foreach ($vc_gallery_ids_occurence_list as $vc_gallery_id) {
					$image_ids[] = $vc_gallery_id; //Store image ID
				}
			}
		}

		$media = get_post_meta($post->ID, '_uncode_featured_media', 1);
		if ($media !== '') {
			$image_ids = array_merge($image_ids, explode(',', $media));
		}


		foreach ( $image_ids as $image_id ) { //Populate an array with URLs taken from featured image IDs
			$image_url = wp_get_attachment_image_src($image_id, 'large');
			if ( $image_url && is_array( $image_url ) && isset( $image_url[0] ) ) {
				$image_title = get_the_title($image_id);
				$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
				$new_data_img = array( 'src' => $image_url[0], 'title' => esc_html($image_title), 'alt' => $image_alt );
				$images[] = $new_data_img;
			}
		}

		return $images;

	}
}

endif;

return new Uncode_RankMath_Support();
