<?php

/**
 * @package uncode
 */


/**
 * Truncate text
 */
function uncode_truncate($text, $length) {
	$text = strip_tags($text, '<img />');
	$length = abs((int)$length);
	if(strlen($text) > $length) {
	    if ( preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) && function_exists('mb_substr') ) {
			$text = preg_replace('/\s+?(\S+)?$/u', '…', mb_substr($text, 0, $length, "utf-8"));
		} else {
			$text = preg_replace('/\s+?(\S+)?$/', '…', substr($text, 0, $length));
		}
	}
	if ( $text !== '' ) {
		return($text);
	}
}

/**
 * Parse Loop data
 */
function uncode_parse_loop_data($value) {
	if (is_array($value)) {
		return $value;
	}
	$data = array();
	$values_pairs = preg_split('/\|/', $value);
	foreach ($values_pairs as $pair)
	{
		if (!empty($pair))
		{
			list($key, $value) = preg_split('/\:/', $pair);
			$data[$key] = $value;
		}
	}
	return $data;
}

/**
 * Parse Loop data
 */
function uncode_unparse_loop_data($values) {
	$data = array();
	foreach ($values as $key => $value)
	{
		$data[] = $key.':'.$value;
	}
	return implode('|',$data);
}

/**
 * Random string
 */
function uncode_randomstring($length = 6)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Flat array
 */
if (!function_exists('uncode_flatArray')) {
	function uncode_flatArray($array)
		{
			$flatArray = array();
			foreach ($array as $key => $value)
			{
				$flatArray[$value[0]] = $value[1];
			}
			return $flatArray;
		}
}


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function uncode_setup_author()
{
	global $wp_query;

	if ($wp_query->is_author() && isset($wp_query->post))
	{
		$GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
	}
}
add_action('wp', 'uncode_setup_author');

/**
 * Adaptive Images Helper, find closest value
 * @param  [int] $search   image size
 * @param  [array] $arr    array with all steps
 * @return [int]     		   closest size for the image
 */
function uncode_getClosest($search, $arr)
{
	$closest = null;
	if (!empty($arr)) {
		foreach ($arr as $item)
		{
			if ($closest == null || abs(intval($search) - intval($closest)) > abs(intval($item) - intval($search)))
			{
				$closest = $item;
			}
		}
	}

	return $closest;
}

/** Add a class to self hosted video */
function uncode_back_video_class($class) {
	return 'background-video-shortcode';
}

if ( ! function_exists( 'uncode_video_data_ignore' ) ):
add_filter( 'wp_video_shortcode', 'uncode_video_data_ignore', 10, 5 );
function uncode_video_data_ignore($output, $atts, $video, $post_id, $library){
	return str_ireplace( '<video ', '<video data-keepplaying ', $output );
}
endif;

if ( ! function_exists( 'uncode_back_video_muted' ) ):
function uncode_back_video_muted($output, $atts, $video, $post_id, $library){
	return str_ireplace( '<video ', '<video muted ', $output );
}
endif;

if ( ! function_exists( 'uncode_strlen' ) ) :
function uncode_strlen( $s ) {
	// Return mb_strlen with encoding UTF-8.
    return mb_strlen( $s, "UTF-8" );
}
endif;

if ( ! function_exists( 'uncode_estimated_reading_time' ) ) {
	function uncode_estimated_reading_time($post_id) {
		$post_id = apply_filters( 'wpml_object_id', $post_id, 'post' );
		$post_content = get_post_field('post_content', $post_id);

		$post_content = strip_tags($post_content);
		$post_content = preg_replace('/\[.*?\]/','', $post_content);
		$string = str_replace( '&#039;', '\'', $post_content );
		$t = array( ' ', "\t", '=', '+', '-', '*', '/', '\\', ',', '.', ';', ':', '[', ']', '{', '}', '(', ')', '<', '>', '&', '%', '$', '@', '#', '^', '!', '?', '~' );
		$post_content = str_replace( $t, ' ', $post_content );
		$post_content = trim( preg_replace( '/\s+/', ' ', $post_content ) );
		$words = 0;

		if ( uncode_strlen( $post_content ) > 0 ) {
			$word_array = explode( ' ', $post_content );
			$words = count( $word_array );
		}

		$minutes = floor( $words / 120 );
		$seconds = floor( $words % 120 / ( 120 / 60 ) );

		if ( 1 <= $minutes ) {
			$estimated_time = $minutes . ' ' . esc_html__('Minutes','uncode');
		} else {
			$estimated_time = '1 '  . esc_html__('Minute','uncode');
		}

		return $estimated_time;

	}
}

/**
 * Resize and store an image
 * @param  [string] $url
 * @param  [string] $path
 * @param  [int] $originalWidth
 * @param  [int] $originalHeight
 * @param  [int] $single_height
 * @param  [boolean] $crop
 * @param  [boolean] $fixed_width
 * @param  [boolean or array] $async
 * @param  [array] $async_data
 * @return [array]
 */

function uncode_resize_image( $media_id, $url, $path, $originalWidth, $originalHeight, $single_width, $single_height = null, $crop = false, $fixed_width = null, $async = false, $async_data = array() )
{
	// Cast to int
	$media_id = intval( $media_id );

	global $adaptive_images, $adaptive_images_async, $ai_bpoints, $dynamic_srcset_active, $register_adaptive_meta, $resize_image_quality;

	if ( $dynamic_srcset_active && ! $crop && ! $async ) {
		$url = apply_filters( 'uncode_url_for_resize', $url );

		// If the file is relative, prepend upload dir
		if ($url && 0 === strpos($url, '/') && !preg_match('|^.:\\\|', $url) && (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
			$url = get_site_url() . $uploads['baseurl'] . "/$path";
		}

		// default output - without resizing
		return array(
			'url'           => $url,
			'width'         => $originalWidth,
			'height'        => $originalHeight,
			'single_width'  => $single_width,
			'single_height' => $single_height,
		);
	}

	$resizing_for_srcset = false;

	// When async is true and we have 'async_srcset_size' in our async_data,
	// it means that dynamic_srcset_active is true and this is the AJAX call
	if ( $async === true && isset( $async_data['async_srcset_size'] ) && $async_data['async_srcset_size'] ) {
		$resizing_for_srcset = true;
		$closest_size        = $async_data['async_srcset_size'];

		// Return early if the breakpoint we are trying to generate
		// is bigger than the original image
		if ( $closest_size >= $originalWidth ) {
			return false;
		}
	} else {
		if ($adaptive_images === 'on' || is_array($async)) {
			if (is_array($async)) {
				$ai_width = (int)$async['images'];
				$ai_screen = (int)$async['screen'];

				if (empty($ai_bpoints)) {
					$ai_sizes = isset( $async_data['ai_breakpoints'] ) ? $async_data['ai_breakpoints'] : '';
					if ($ai_sizes === '') {
						$ai_sizes = uncode_get_default_breakpoint_sizes();
					}
					$ai_sizes = preg_replace('/\s+/', '', $ai_sizes);
					$ai_bpoints = explode(',', $ai_sizes);
				}
			} else {
				if ($adaptive_images_async === 'on') {
					$ai_width = min($ai_bpoints);
					$ai_screen = min($ai_bpoints);
				} else {
					if (isset($_COOKIE['uncodeAI_images']) && isset($_COOKIE['uncodeAI_screen'])) {
						$ai_width = $_COOKIE['uncodeAI_images'];
						$ai_screen = $_COOKIE['uncodeAI_screen'];
					} else {
						$ai_width = min($ai_bpoints);
						$ai_screen = min($ai_bpoints);
						$adaptive_images_async = 'on';
					}
				}
			}

			if ( $single_width === '' && $single_height !== null ) {
				$single_height = $single_height * 1.25;
				$single_width = round( 12 / ( $ai_screen / (($originalWidth / $originalHeight) * $single_height) ) );
			}

			if ($ai_screen < 781) {
				$closest_size = uncode_getClosest($ai_width , $ai_bpoints);
			} else {
				if ($fixed_width === null || $fixed_width === '') {
					if ($crop) {
						$closest_size = uncode_getClosest(($ai_width / (12 / max($single_width, $single_height))) , $ai_bpoints);
					} else {
						$closest_size = uncode_getClosest(($ai_width / (12 / $single_width)) , $ai_bpoints);
					}
				} else {
					if ($crop) {
						$closest_size = uncode_getClosest(max($single_width, $single_height) , $ai_bpoints);
					} else {
						if ($fixed_width === 'width') {
							$get_new_height = ($ai_width * $single_width) / $ai_screen;
							$closest_size = uncode_getClosest($get_new_height , $ai_bpoints);
						} else if ($fixed_width === 'height') {
							$get_new_height = uncode_getClosest($single_height , $ai_bpoints);
							$get_new_width = round(($originalWidth * $get_new_height) / $originalHeight);
							$closest_size = uncode_getClosest($get_new_width , $ai_bpoints);
						} else {
							$closest_size = 10000;
						}
						$single_width = (12 * $closest_size) / $ai_width;
					}
				}
			}

		} else {
			$closest_size = 10000;
		}
	}

	$targetWidth = $originalWidth;
	$targetHeight = $originalHeight;

	if ($crop) {

		$single_height = floatval($single_height);

		if ( $resizing_for_srcset ) {
			$dest_w = $closest_size;
			$dest_h = ($closest_size / $single_width) * $single_height;

			// Return early when the dest height is bigger than the original height
			// because that's basically the full image we already have in the source
			if ( $dest_h > $originalHeight ) {
				return false;
			}
		} else {
			if ($single_width > $single_height) {
				$dest_w = $closest_size;
				$dest_h = ($closest_size / $single_width) * $single_height;
			} else {
				$dest_h = $closest_size;
				$dest_w = $dest_h * ($single_width / $single_height);
			}

			if ($dest_h > $originalHeight) {
				$dest_h = $originalHeight;
				$dest_w = $dest_h * ($single_width / $single_height);
			}

			if ($dest_w > $originalWidth) {
				$dest_w = $originalWidth;
				$dest_h = ($dest_w / $single_width) * $single_height;
			}

			if ($dest_h > $originalHeight || $dest_w > $originalWidth) {
				$closest_size = min($originalWidth, $originalHeight);
				if ($single_width > $single_height) {
					$dest_w = $closest_size;
					$dest_h = ($closest_size / $single_width) * $single_height;
				} else {
					$dest_h = $closest_size;
					$dest_w = $dest_h * ($single_width / $single_height);
				}
			}
		}

		// Don't call image_resize_dimensions() if the dest dimensions are the same
		// Fixes WP 5.3+ image_resize_dimensions() that returns false in this case
		if ( intval( $originalWidth ) === intval( $dest_w ) && ( intval( $originalHeight ) === intval( $dest_h ) || ! $dest_h) ) {
			$new_dimensions = false;
			$targetWidth    = $originalWidth;
			$targetHeight   = $originalHeight;
		} else {
			$new_dimensions = image_resize_dimensions($originalWidth, $originalHeight, $dest_w, $dest_h, $crop);
		}

	} else {
		if ($closest_size > $originalWidth && ($fixed_width === null || $fixed_width === '')) {
			$closest_size = $originalWidth;
		}

		// Don't call image_resize_dimensions() if the dest dimensions are the same
		// Fixes WP 5.3+ image_resize_dimensions() that returns false in this case
		if (intval( $originalWidth ) === intval( $closest_size )) {
			$new_dimensions = false;
			$targetWidth    = $originalWidth;
			$targetHeight   = $originalHeight;
		} else {
			$new_dimensions = image_resize_dimensions($originalWidth, $originalHeight, $closest_size, $originalHeight, $crop);
		}
	}

	$targetWidth  = isset($new_dimensions) && $new_dimensions ? $new_dimensions[4] : $targetWidth;
	$targetHeight = isset($new_dimensions) && $new_dimensions ? $new_dimensions[5] : $targetHeight;

	$basic_error_message = esc_html( 'Error during image generation: %s [ID = ' . $media_id . ', Target Width = ' . $targetWidth . ', Target Height = ' . $targetHeight . ']' );

	// Register metadata
	if ( isset( $async_data['register_metadata'] ) && $async_data['register_metadata'] ) {
		$register_adaptive_meta = true;
	}

	// this is an attachment, so we have the ID
	$image_src = array();

	$remote = false;
	// Check if S3 is deleting local images
	global $as3cf;

	if (isset($as3cf)) {
		if ($as3cf->get_setting('serve-from-s3')) {
			$remote = true;
		}
	}

	if ($remote) {
		$remote_url = $as3cf->get_attachment_url($media_id);
		if (empty($remote_url)) {
			$remote = false;
		} else {
			$url = $remote_url;
		}
		$headers = ($url !== '' && !empty($url)) ? get_headers($url) : array('');
		$media_url = stripos($headers[0],"200 OK") ? $url : '';
		if ($media_url === '') {
			add_filter( 'as3cf_get_attached_file_copy_back_to_local', '__return_true' );
			$media_url = get_attached_file( $media_id );
		}
	}

	$remote_google = false;
	// Check if Google Storage is active
	if ( function_exists('ud_get_stateless_media') ) {
		$remote_google = true;
		global $post;

		if ( !$post ) {
			$post = get_post();
		}

		if ( $post ) {
			$th_id = get_post_thumbnail_id($post->ID);
			$url = wp_get_attachment_url($th_id);
		}
	}

	$url = apply_filters( 'uncode_url_for_resize', $url );

	// If the file is relative, prepend upload dir
	if ($url && 0 === strpos($url, '/') && !preg_match('|^.:\\\|', $url) && (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
		$url = get_site_url() . $uploads['baseurl'] . "/$path";
	}
	if ($path && 0 !== strpos($path, '/') && !preg_match('|^.:\\\|', $path) && (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
		$actual_file_path = $uploads['basedir'] . "/$path";
	}

	$image_src[] = $url;
	$image_src[] = $originalWidth;
	$image_src[] = $originalHeight;

	if (!empty($actual_file_path))
	{
		$file_info = pathinfo($actual_file_path);
		$extension = '.' . $file_info['extension'];

		// the image path without the extension
		$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

		$cropped_img_path = $no_ext_path . '-uai-' . $targetWidth . 'x' . $targetHeight . $extension;

		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ($originalWidth > $targetWidth || $originalHeight > $targetHeight)
		{

			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ($remote) {
				$cropped_img_url = str_replace(basename($url) , basename($cropped_img_path) , $url);
				$headers = ($cropped_img_url !== '' && !empty($cropped_img_url)) ? get_headers($cropped_img_url) : array('');
				$cropped_exists = stripos($headers[0],"200 OK") ? true : false;
				if ($cropped_exists) {
					if ( $dynamic_srcset_active ) {
						uncode_recheck_attachment_meta( $media_id, $targetWidth, $targetHeight, $url, $cropped_img_url );
					}

					$vt_image = array(
						'url' => apply_filters( 'uncode_resized_image_url', $cropped_img_url ),
						'width' => $targetWidth,
						'height' => $targetHeight,
						'single_width' => $single_width,
						'single_height' => $single_height,
					);

					return $vt_image;
				} else {
					$remote_actual_file_path = $actual_file_path;
					$actual_file_path = preg_replace('/\?.*/', '', $url);
				}
			} else {
				if (file_exists($cropped_img_path)) {
					$cropped_img_url = str_replace(basename($url) , basename($cropped_img_path) , $url);

					if ( $dynamic_srcset_active ) {
						uncode_recheck_attachment_meta( $media_id, $targetWidth, $targetHeight, $url, $cropped_img_url );
					}

					$vt_image = array(
						'url' => apply_filters( 'uncode_resized_image_url', $cropped_img_url ),
						'width' => $targetWidth,
						'height' => $targetHeight,
						'single_width' => $single_width,
						'single_height' => $single_height,
					);

					return $vt_image;
				}
			}

			// no cache files - let's finally resize it
			$img_editor = wp_get_image_editor($actual_file_path);

			// check if we have this new image in the (parent) attachment meta
			$has_meta_data = false;

			if ( is_wp_error( $img_editor ) ) {
				$error_message = $img_editor->get_error_message() ? $img_editor->get_error_message() : esc_html__( 'Error when retrieving the image editor.', 'uncode' );
				$error_message = sprintf( $basic_error_message, $error_message );

				return array(
					'url'    => '',
					'width'  => '',
					'height' => '',
					'error'  => $error_message
				);
			}

			// resize the image
			$_resized = $img_editor->resize( $targetWidth, $targetHeight, $crop );

			if ( is_wp_error( $_resized ) ) {
				$error_message = $_resized->get_error_message() ? $_resized->get_error_message() : esc_html__( 'Error when resizing the image', 'uncode' );
				$error_message = sprintf( $basic_error_message, $error_message );

				return array(
					'url'    => '',
					'width'  => '',
					'height' => '',
					'error'  => $error_message
				);
			}

			/** set image compression quality **/
			$img_quality = $resize_image_quality;
			if ( empty( $resize_image_quality ) ) {
				$img_quality = isset( $async_data['resize_quality'] ) ? $async_data['resize_quality'] : '';
				if ( $img_quality === '' ) {
					$img_quality = 90;
				}
			}
			$img_editor->set_quality( $img_quality );

			$suffix = $img_editor->get_suffix();
			if ($remote) {
				$path = pathinfo($remote_actual_file_path);
				$remote_path = pathinfo($actual_file_path);
				$new_img_path = $img_editor->generate_filename('uai-' . $suffix, $path['dirname']);
				$remote_img_path = $img_editor->generate_filename('uai-' . $suffix, $remote_path['dirname']);
			} else {
				$new_img_path = $img_editor->generate_filename('uai-' . $suffix);
			}

			// if (!$remote && file_exists($new_img_path)) {
			// 	$new_img_size = getimagesize($new_img_path);
			// 	$new_img = str_replace(basename($url) , basename($new_img_path) , $url);

			// 	// resized output
			// 	$vt_image = array(
			// 		'url' => apply_filters( 'uncode_resized_image_url', $new_img ),
			// 		'width' => $new_img_size[0],
			// 		'height' => $new_img_size[1],
			// 		'single_width' => $single_width,
			// 		'single_height' => $single_height,
			// 	);

			// 	return $vt_image;
			// }

			$_resize_saved = $img_editor->save( $new_img_path );

			if ( is_wp_error( $_resize_saved ) ) {
				$error_message = $_resize_saved->get_error_message() ? $_resize_saved->get_error_message() : esc_html__( 'Error when saving the image', 'uncode' );
				$error_message = sprintf( $basic_error_message, $error_message );

				return array(
					'url'    => '',
					'width'  => '',
					'height' => '',
					'error'  => $error_message
				);
			} else {
				if ($remote) {
					/** ADD CODE TO SAVE FINAL IMAGE TO S3 **/
					add_filter( 'as3cf_get_attached_file_copy_back_to_local', '__return_true' );
					get_attached_file( $media_id );
					$media_data = wp_get_attachment_metadata($media_id );
					$mime = get_post_mime_type($media_id);

					$media_data_key = $file_info[ 'filename' ] . '-uai_' . $targetWidth . 'x' . $targetHeight . '.' . $file_info[ 'extension' ];
					$media_data_key = apply_filters( 'uncode_ai_meta_data_key_name', $media_data_key );

					$media_data['sizes'][$media_data_key] = array(
						'file' => basename($remote_img_path),
						'width' => $targetWidth,
						'height' => $targetHeight,
						'mime-type' => $mime,
					);
					wp_update_attachment_metadata($media_id, $media_data);

					$has_meta_data = true;
				}
			}

			if (!is_string($new_img_path)) {
				$error_message = esc_html__( 'Path not correct', 'uncode' );
				$error_message = sprintf( $basic_error_message, $error_message );

				return array(
					'url'    => '',
					'width'  => '',
					'height' => '',
					'error'  => $error_message
				);
			}

			$new_img_size = getimagesize($new_img_path);
			$new_img = str_replace(basename($url) , basename($new_img_path) , $url);

			// resized output
			$vt_image = array(
				'url'           => apply_filters( 'uncode_resized_image_url', $new_img ),
				'width'         => $new_img_size[0],
				'height'        => $new_img_size[1],
				'single_width'  => $single_width,
				'single_height' => $single_height,
				'new_crop'      => true,
			);

			// Add this new size entry to the parent image metadata
			if ( ! $has_meta_data && $register_adaptive_meta ) {
				$media_data_key = $file_info[ 'filename' ] . '-uai_' . $new_img_size[ 0 ] . 'x' . $new_img_size[ 1 ] . '.' . $file_info[ 'extension' ];
				$media_data_key = apply_filters( 'uncode_ai_meta_data_key_name', $media_data_key );
				$media_data     = wp_get_attachment_metadata($media_id );
				$mime           = get_post_mime_type($media_id);

				$media_data[ 'sizes' ][ $media_data_key ] = array(
					'file' => basename( $new_img_path ),
					'width' => $new_img_size[0],
					'height' => $new_img_size[1],
					'mime-type' => $mime,
				);
				wp_update_attachment_metadata($media_id, $media_data);

				do_action( 'uncode_after_crop_resize', $media_id, $media_data, $remote );
			}

			//If using Wp Smushit
			if( class_exists('WpSmush') ){
				global $WpSmush;
				if( filesize( $new_img_path ) < WP_SMUSH_MAX_BYTES ){
					$WpSmush->do_smushit($new_img_path, $new_img);
				}
			}

			return $vt_image;
		} else {
			if ($remote) {
				$url = wp_get_attachment_image_src( $media_id, 'full' );
				$url = $url[0];
				$headers = ($url !== '' && !empty($url)) ? get_headers($url) : array('');
				$media_url = stripos($headers[0],"200 OK") ? $url : '';
				if ($media_url === '') {
					$media_data = wp_get_attachment_metadata($media_id );
					$mime = get_post_mime_type($media_id);
					$media_data['sizes']['full'] = array(
						'file' => basename($url),
						'width' => $originalWidth,
						'height' => $originalHeight,
						'mime-type' => $mime,
					);
					wp_update_attachment_metadata($media_id, $media_data);
				}

			}
		}

		// default output - without resizing
		$vt_image = array(
			'url' => apply_filters( 'uncode_resized_image_url', $url ),
			'width' => $originalWidth,
			'height' => $originalHeight,
			'single_width' => $single_width,
			'single_height' => $single_height,
		);

		return $vt_image;
	}
	return false;
}

/**
 * Media library helper
 * @param  [int] $media_id
 * @return [object]
 */
function uncode_get_media_info($media_id)
{
	if ($media_id !== '') {
		global $wpdb;
		$remove_limit = version_compare($wpdb->db_version(), '5.5', '>=') ? 'SET SESSION SQL_BIG_SELECTS = 1;': 'SET SQL_BIG_SELECTS = 1;';
		$wpdb->query($remove_limit);
		$info = $wpdb->get_row($wpdb->prepare("SELECT {$wpdb->posts}.post_content,{$wpdb->posts}.post_title,{$wpdb->posts}.post_excerpt,{$wpdb->posts}.guid,{$wpdb->posts}.post_mime_type,meta1.meta_value as metadata, meta2.meta_value as alt, meta3.meta_value as path, meta4.meta_value as team, meta5.meta_value as team_social, meta6.meta_value as animated_svg, meta7.meta_value as animated_svg_time, meta8.meta_value as social_original FROM {$wpdb->posts} LEFT OUTER JOIN {$wpdb->postmeta} meta1 ON {$wpdb->posts}.ID = meta1.post_id AND meta1.meta_key = '_wp_attachment_metadata' LEFT OUTER JOIN {$wpdb->postmeta} meta2 ON {$wpdb->posts}.ID = meta2.post_id AND meta2.meta_key = '_wp_attachment_image_alt' LEFT OUTER JOIN {$wpdb->postmeta} meta3 ON {$wpdb->posts}.ID = meta3.post_id AND meta3.meta_key = '_wp_attached_file' LEFT OUTER JOIN {$wpdb->postmeta} meta4 ON {$wpdb->posts}.ID = meta4.post_id AND meta4.meta_key = '_uncode_team_member' LEFT OUTER JOIN {$wpdb->postmeta} meta5 ON {$wpdb->posts}.ID = meta5.post_id AND meta5.meta_key = '_uncode_team_member_social' LEFT OUTER JOIN {$wpdb->postmeta} meta6 ON {$wpdb->posts}.ID = meta6.post_id AND meta6.meta_key = '_uncode_animated_svg' LEFT OUTER JOIN {$wpdb->postmeta} meta7 ON {$wpdb->posts}.ID = meta7.post_id AND meta7.meta_key = '_uncode_animated_svg_time' LEFT OUTER JOIN {$wpdb->postmeta} meta8 ON {$wpdb->posts}.ID = meta8.post_id AND meta8.meta_key = '_uncode_social_original' WHERE ID IN (%d)", $media_id ));
		if (isset($info->post_mime_type) && strpos($info->post_mime_type, 'image') !== false && $info->post_mime_type !== 'image/url') {
			$file = $info->path;
			// Get upload directory.
			if ( ( $uploads = wp_upload_dir( null, false ) ) && false === $uploads['error'] ) {
				// Check that the upload base exists in the file location.
				if ( 0 === strpos( $file, $uploads['basedir'] ) ) {
					// Replace file location with url location.
					$url = str_replace($uploads['basedir'], $uploads['baseurl'], $file);
				} elseif ( false !== strpos($file, 'wp-content/uploads') ) {
					// Get the directory name relative to the basedir (back compat for pre-2.7 uploads)
					$url = trailingslashit( $uploads['baseurl'] . '/' . _wp_get_attachment_relative_path( $file ) ) . basename( $file );
				} else {
					// It's a newly-uploaded file, therefore $file is relative to the basedir.
					$url = $uploads['baseurl'] . "/$file";
				}
			}
			if ( !empty($url) ) {
				if ( is_ssl() && ! is_admin() && 'wp-login.php' !== $GLOBALS['pagenow'] ) {
					$url = set_url_scheme( $url );
				}
				$info->guid = $url;
			}
		}

		if ( !empty($info) ) {
			$info->id = $media_id;
		}

		return $info;
	} else return;
}

/**
 * oEmbed helper
 * @param  [int] $id
 * @param  [string] $url
 * @return [array]
 */
function uncode_get_oembed($id, $url, $mime, $with_poster = false, $excerpt = null, $html = null, $lighbox_code = false, $single_width = '', $single_height = null, $single_fixed = null, $is_metro = false, $is_text_carousel = false)
{
	global $front_background_colors;
	$object_class = $poster = $poster_id = '';
	$oembed_size = uncode_get_dummy_size($id);
	$media_type = 'other';

	if ( filter_var($url, FILTER_VALIDATE_EMAIL) ) {
		$media_type = 'email';
	}

	if ($with_poster) {
		$poster = get_post_meta($id, "_uncode_poster_image", true);
		$poster_id = $poster;
	}

	$consent_id = str_replace( 'oembed/', '', $mime );
	uncode_privacy_check_needed( $consent_id );

	switch ($mime) {
		case 'oembed/flickr':
		case 'oembed/Imgur':
		case 'oembed/photobucket':
			$media_type = 'image';
			$media_oembed = wp_oembed_get($url);
			preg_match_all('/src="([^"]*)"/i', $media_oembed, $img_src);
			$media_oembed = (isset($img_src[1][0])) ? str_replace('"', '', $img_src[1][0]) : '';
			if ($mime === 'oembed/flickr') {
				$media_oembed = str_replace(array('_n.','_z.'), '_b.', $media_oembed);
			}
		break;
		case 'oembed/youtube':
			if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
				$get_url = parse_url(wp_specialchars_decode($url));
				if (isset($get_url['query'])) {
					parse_str($get_url['query'], $query);
					if (isset($query['v'])) {
						$get_id = $query['v'];
						unset($query['v']);
					}
					$get_id .= '?' . http_build_query($query);
					$src_id = $get_id;
				}
				else $src_id = basename($url);
				$nocookie = ! apply_filters('uncode_nocookie', false) ? '' : '-nocookie';
				$media_oembed = 'https://www.youtube' . esc_attr( $nocookie ) . '.com/embed/' . $src_id;
			}
			else {
				$get_url = parse_url(wp_specialchars_decode($url));
				if (isset($get_url['query'])) {
					parse_str($get_url['query'], $arguments);
					$media_oembed = wp_oembed_get($url, $arguments);
				} else {
					$media_oembed = wp_oembed_get($url);
				}
			}
			$media_oembed = uncode_replace_disallowed_videos( 'youtube', $id, $media_oembed, $single_width, $single_height, $single_fixed, $is_metro );
			break;

		case 'oembed/vimeo':
			if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
				$media_oembed = 'https://player.vimeo.com/video/' . basename($url);
			} else {
				$get_url = parse_url(wp_specialchars_decode($url));
				if (isset($get_url['query'])) {
					parse_str($get_url['query'], $arguments);
					$arguments['title'] = 0;
					$arguments['byline'] = 0;
					$arguments['portrait'] = 0;
					$arguments['dnt'] = 1;
				} else {
					$arguments = array();
					$arguments['title'] = 0;
					$arguments['byline'] = 0;
					$arguments['portrait'] = 0;
					$arguments['dnt'] = 1;
				}
				$media_oembed = wp_oembed_get($url, $arguments);
			}
			$media_oembed = uncode_replace_disallowed_videos( 'vimeo', $id, $media_oembed, $single_width, $single_height, $single_fixed, $is_metro );
			break;

		case 'oembed/soundcloud':
			if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
				//Get the JSON data of song details with embed code from SoundCloud oEmbed
				$getValues = wp_remote_fopen('http://soundcloud.com/oembed?format=js&url=' . $url . '&iframe=true');
				//Clean the Json to decode
				$decodeiFrame = substr($getValues, 1, -2);
				//json decode to convert it as an array
				$decodeiFrame = json_decode($decodeiFrame);
				preg_match('/src="([^"]+)"/', $decodeiFrame->html, $iframe_src);
				$media_oembed = $iframe_src[1];
			} else {
				$accent_color = $front_background_colors['accent'];
				$accent_color = str_replace('#', '', $accent_color);
				$getValues = wp_remote_fopen('http://soundcloud.com/oembed?format=js&url=' . $url . '&iframe=true');
				$decodeiFrame = substr($getValues, 1, -2);
				$decodeiFrame = json_decode($decodeiFrame);
				if (isset($decodeiFrame->html)) {
					preg_match('/src="([^"]+)"/', $decodeiFrame->html, $iframe_src);
					$iframe_url = str_replace('visual=true', 'visual=false', $iframe_src[1]);
					$media_oembed = '<iframe width="100%" scrolling="no" frameborder="no" src="' . $iframe_url . '&color='.$accent_color.'&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false"></iframe>';
					if (strpos($iframe_url, '%2Fusers%2F') !== false || strpos($iframe_url, '%2Fplaylists%2F') !== false) {
						$object_class = 'soundcloud-playlist';
					} else {
						if ( uncode_privacy_allow_content( $consent_id ) === true ) {
							$object_class = 'soundcloud-single';
						}
					}
				} else {
					$media_oembed = '<img src="https://via.placeholder.com/500x500.png?text=media+not+available&amp;w=500&amp;h=500" />';
				}
			}
			$media_oembed = uncode_replace_disallowed_videos( 'soundcloud', $id, $media_oembed, $single_width, $single_height, $single_fixed, $is_metro );
		break;
		case 'oembed/spotify':
			if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
				$get_url = parse_url($url);
				$break_spotify = explode('/', $get_url['path']);
				$media_oembed = 'https://embed.spotify.com/?uri=spotify' . implode(':', $break_spotify);
			} else {
				$media_oembed = wp_oembed_get($url);
				$media_oembed = preg_replace('#\s(width)="([^"]+)"#', '', $media_oembed);
				$media_oembed = preg_replace('#\s(height)="([^"]+)"#', '', $media_oembed);
				$object_class = 'object-size spotify';
			}
			$media_oembed = uncode_replace_disallowed_videos( 'spotify', $id, $media_oembed, $single_width, $single_height, $single_fixed, $is_metro );
		break;
		case 'oembed/twitter':
			$social_original = get_post_meta($id, "_uncode_social_original", true);
			if ($social_original) {
				$media_oembed = wp_oembed_get($url);
				$media_oembed = uncode_replace_disallowed_videos( 'twitter', $id, $media_oembed, $single_width, $single_height, $single_fixed, $is_metro );
			} else {
				$url = 'https://api.twitter.com/1/statuses/oembed.json?id=' . basename($url);
				$json = wp_remote_fopen($url);
				$json_data = json_decode($json, true);
				$id = basename($json_data['url']);
				$html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $json_data['html']);
				$html = str_replace("&mdash; ", '', $html);
				if (function_exists('mb_convert_encoding')) {
					$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
				}
				$dom = new domDocument;
				$dom->loadHTML($html);
				$dom->preserveWhiteSpace = false;
				$twitter_content = $dom->getElementsByTagname('blockquote');
				$twitter_blockquote = '';
				$twitter_footer = '';
				foreach ($twitter_content as $item) {
					$twitter_content_inner = $item->getElementsByTagname('p');
					foreach ($twitter_content_inner as $item_inner) {
						foreach ($item_inner->childNodes as $child) {
							$twitter_blockquote .= $child->ownerDocument->saveXML( $child );
						}
						$item_inner->parentNode->removeChild($item_inner);
					}
					foreach ($item->childNodes as $child) {
						$twitter_footer .= $child->ownerDocument->saveXML( $child );
					}
					$item->parentNode->removeChild($item);
				}
				$media_oembed = '<div class="twitter-item">
										<div class="twitter-item-data">
											<blockquote class="tweet-text pullquote">';

				if ( $is_text_carousel ) {
					$media_oembed .=			'<span class="pullquote__content">' . $twitter_blockquote . '</span>';
				} else {
					$media_oembed .=			'<p>' . $twitter_blockquote . '</p>';
				}

				if ( $is_text_carousel ) {
					$media_oembed .=		'<span class="twitter-footer"><i class="fa fa-twitter"></i><small>' . $twitter_footer . '</small></span>';
				} else {
					$media_oembed .=		'<p class="twitter-footer"><i class="fa fa-twitter"></i><small>' . $twitter_footer . '</small></p>';
				}

				$media_oembed .= 		'</blockquote>
										</div>
									</div>';
				$width = 1;
				$height = 0;
				$object_class = 'tweet object-size regular-text';
			}
		break;
		case 'oembed/html':
			$author = $author_img = '';
			$width = 1;
			$height = 0;
			$poster = get_post_meta($id, "_uncode_poster_image", true);
			$poster_id = $poster;
			if (($poster !== '' && $with_poster) || $lighbox_code) {
				$attr = array(
					'class' => "avatar",
				);
				$author_img = wp_get_attachment_image($poster, 'thumbnail', false, $attr);
				$author_img = '<figure class="gravatar">' . $author_img . '</figure>';
			}
			if ($excerpt) {
				if ( $is_text_carousel ) {
					$author = '<span><small>' . $excerpt . '</small></span>';
				} else {
					$author = '<p><small>' . $excerpt . '</small></p>';
				}
			}
			if ( $is_text_carousel ) {
				$media_oembed = '<blockquote class="pullquote">' . $author_img . '<span class="pullquote__content">' . esc_html($html) . '</span>' . $author . '</blockquote>';
			} else {
				$media_oembed = '<blockquote class="pullquote">' . $author_img . '<p>' . esc_html($html) . '</p>' . $author . '</blockquote>';
			}

			$object_class = 'regular-text object-size';
			$poster = '';
		break;
		case 'shortcode':
			$media_oembed = do_shortcode($url);
			$object_class = 'object-size shortcode';
		break;
		default:
			if (strpos($mime, 'audio/') !== false) {
				if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
					$media_oembed = $url;
				} else {
					$object_class = 'object-size self-audio';
					$url = apply_filters( 'uncode_self_audio_src', $url );
					$media_oembed = do_shortcode('[audio src="' . $url . '"]');
					$poster = get_post_meta($id, "_uncode_poster_image", true);
					$poster_id = $poster;
				}
			} else if (strpos($mime, 'video/') !== false) {
				if ((isset($poster) && $poster !== '' && $with_poster) || $lighbox_code) {
					$media_oembed = $url;
				}	else {
					$videos = array();
					$exloded_url = explode(".", strtolower($url));
					$ext = end($exloded_url);
					$videos[(String) $ext] = $url;
					$alt_videos = get_post_meta($id, "_uncode_video_alternative", true);

					if (!empty($alt_videos)) {
						foreach ($alt_videos as $key => $value) {
							$value = apply_filters( 'uncode_self_video_src', $value );
							$exloded_url = explode(".", strtolower($value));
							$ext = end($exloded_url);
							$videos[(String) $ext] = $value;
						}
					} else {
						$videos = array(
							'src' => '"' . $url . '"'
						);
					}

					$video_src = '';
					foreach ($videos as $key => $value) {
						$value = apply_filters( 'uncode_self_video_src', $value );
						$video_src.= ' ' . $key . '=' . $value;
					}

					$object_class = 'object-size self-video';

					$poster = get_post_meta($id, "_uncode_poster_image", true);
					$poster_url = '';
					$loop = get_post_meta($id, "_uncode_video_loop", true);
					$autoplay = get_post_meta($id, "_uncode_video_autoplay", true);
					$add_loop = $loop ? ' loop="yes"' : '';
					$add_autoplay = $autoplay ? ' autoplay="yes"' : '';
					if (isset($poster) && $poster !=='') {
						$poster_attributes = uncode_get_media_info($poster);
						if (isset($poster_attributes->metadata)) {
							$media_metavalues = unserialize($poster_attributes->metadata);
							$image_orig_w = $media_metavalues['width'];
							$image_orig_h = $media_metavalues['height'];
							global $adaptive_images, $adaptive_images_async;
							if ($adaptive_images === 'on' && $adaptive_images_async === 'on') {
								$poster_url = $poster_attributes->guid;
							} else {
								$resized_image = uncode_resize_image($poster_attributes->id, $poster_attributes->guid, $poster_attributes->path, $image_orig_w, $image_orig_h, 12, '', false);
								$poster_url = $resized_image['url'];
							}
						}
					}

					if ($poster_url !== '') {
						$poster_url = ' poster="' . $poster_url . '"';
					}
					$media_oembed = do_shortcode('[video' . $video_src . $poster_url . $add_loop . $add_autoplay . ']');
				}
			} else {
				$media_oembed = $media_type === 'email' || ! $url ? '' : wp_oembed_get($url);
			}
		break;
	}

	if ($oembed_size['dummy'] == 0) {
		preg_match_all('/width="([^"]*)"/i', $media_oembed, $iWidth);
		$width = (isset($iWidth[1][0])) ? $iWidth[1][0] : 1;
		preg_match_all('/height="([^"]*)"/i', $media_oembed, $iHeight);
		$height = (isset($iHeight[1][0])) ? $iHeight[1][0] : 1;
		if ( !is_numeric($height) ) {
			$height = (int)$height;
		}
		if ((int)$width !== 0) {
			$oembed_size['dummy'] = round(($height / $width) * 100, 2);
		}
	}

	return array(
		'code' => $media_oembed,
		'width' => $oembed_size['width'],
		'height' => $oembed_size['height'],
		'dummy' => $oembed_size['dummy'],
		'type' => $media_type,
		'class' => $object_class,
		'poster' => $poster,
		'poster_id' => $poster_id,
	);
}

/**
 * Retrieve header info for specific page
 * @param  [type] $metabox_data
 * @param  [type] $post_type
 * @param  [type] $media
 * @return [type]
 */
function uncode_get_specific_header_data($metabox_data, $post_type, $media = '') {
	$show_title = true;
	if (isset($metabox_data['_uncode_header_background'][0])) {
		$metabox_data['_uncode_header_background'] = array(unserialize($metabox_data['_uncode_header_background'][0]));
	} else {
		$metabox_data['_uncode_header_background'][0]['background-color'] = '';
		$metabox_data['_uncode_header_background'][0]['background-image'] = '';
		$metabox_data['_uncode_header_background'][0]['background-repeat'] = '';
		$metabox_data['_uncode_header_background'][0]['background-position'] = '';
		$metabox_data['_uncode_header_background'][0]['background-size'] = '';
		$metabox_data['_uncode_header_background'][0]['background-attachment'] = '';
	}
	if (isset($metabox_data['_uncode_header_container_background'][0])) {
		$metabox_data['_uncode_header_container_background'] = array(unserialize($metabox_data['_uncode_header_container_background'][0]));
	}
	if (isset($metabox_data['_uncode_header_height'][0])) {
		$metabox_data['_uncode_header_height'] = array(unserialize($metabox_data['_uncode_header_height'][0]));
	}

	if (isset($metabox_data['_uncode_header_title'][0]) && $metabox_data['_uncode_header_title'][0] === 'on') {
		$show_title = false;
	}

	if ( ( isset($metabox_data['_uncode_header_type']) && $metabox_data['_uncode_header_type'][0]==='header_uncodeblock' ) || ( isset($metabox_data['_uncode_header_featured']) && $metabox_data['_uncode_header_featured'][0] === 'on' && $metabox_data['_uncode_header_background'][0]['background-image'] === '' ) ) {
		$metabox_data['_uncode_header_background'][0]['background-image'] = $media;
		$media = '';
	}

	return array(
		'meta' => $metabox_data,
		'show_title' => $show_title,
		'media' => $media
	);
}

/**
 * Retrieve header info for general category
 * @param  [type] $metabox_data
 * @param  [type] $post_type
 * @param  [type] $media
 * @return [type]
 */
function uncode_get_general_header_data($metabox_data, $post_type, $media = '', $title = '') {
	$show_title = true;
	$page_header_type = ot_get_option('_uncode_'.$post_type.'_header');

	if ($page_header_type === 'header_basic') {
		$page_header_type = ot_get_option('_uncode_'.$post_type.'_header');
		$metabox_data['_uncode_header_style'] = array(ot_get_option('_uncode_'.$post_type.'_header_style'));
		$metabox_data['_uncode_header_background'] = array(ot_get_option('_uncode_'.$post_type.'_header_background'));
		if (!isset($metabox_data['_uncode_header_background'][0]['background-color']) || $metabox_data['_uncode_header_background'][0]['background-color'] === '') {
			if ( !isset($metabox_data['_uncode_header_background'][0]) || (!is_array($metabox_data['_uncode_header_background'][0]) && $metabox_data['_uncode_header_background'][0] === '') ) {
				$metabox_data['_uncode_header_background'][0] = array();
			}
			$metabox_data['_uncode_header_background'][0]['background-color'] = '';
		}
		$header_title = ot_get_option('_uncode_'.$post_type.'_header_title');
		if (empty($header_title) || $header_title === 'on') {
			$metabox_data['_uncode_header_title'] = array('on');
			$show_title = false;
		} else {
			$metabox_data['_uncode_header_title'] = array('off');
		}

		$metabox_data['_uncode_header_featured'] = array(ot_get_option('_uncode_'.$post_type.'_header_featured'));

		if ($metabox_data['_uncode_header_featured'][0] === 'on' && $media !== '') {
			$metabox_data['_uncode_header_background'][0]['background-image'] = $media;
			$media = '';
		}

		$metabox_data['_uncode_header_title_custom'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_custom'));
		$metabox_data['_uncode_header_text'] = array(ot_get_option('_uncode_'.$post_type.'_header_text'));
		$metabox_data['_uncode_header_text_animation'] = array(ot_get_option('_uncode_'.$post_type.'_header_text_animation'));
		$metabox_data['_uncode_header_animation_speed'] = array(ot_get_option('_uncode_'.$post_type.'_header_animation_speed'));
		$metabox_data['_uncode_header_animation_delay'] = array(ot_get_option('_uncode_'.$post_type.'_header_text_delay'));
		$metabox_data['_uncode_header_title_font'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_font'));
		$metabox_data['_uncode_header_title_size'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_size'));
		$metabox_data['_uncode_header_title_height'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_height'));
		$metabox_data['_uncode_header_title_spacing'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_spacing'));
		$metabox_data['_uncode_header_title_weight'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_weight'));
		$metabox_data['_uncode_header_title_italic'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_italic'));
		$metabox_data['_uncode_header_title_transform'] = array(ot_get_option('_uncode_'.$post_type.'_header_title_transform'));
		$metabox_data['_uncode_header_full_width'] = array(ot_get_option('_uncode_'.$post_type.'_header_width'));
		$metabox_data['_uncode_header_content_width'] = array(ot_get_option('_uncode_'.$post_type.'_header_content_width'));
		$metabox_data['_uncode_header_custom_width'] = array(ot_get_option('_uncode_'.$post_type.'_header_custom_width'));
		$metabox_data['_uncode_header_align'] = array(ot_get_option('_uncode_'.$post_type.'_header_align'));
		$metabox_data['_uncode_header_height'] = array(ot_get_option('_uncode_'.$post_type.'_header_height'));
		$metabox_data['_uncode_header_min_height'] = array(ot_get_option('_uncode_'.$post_type.'_header_min_height'));
		$metabox_data['_uncode_header_position'] = array(ot_get_option('_uncode_'.$post_type.'_header_position'));
		$metabox_data['_uncode_header_breadcrumb'] = array(ot_get_option('_uncode_'.$post_type.'_header_breadcrumb'));
		$metabox_data['_uncode_header_parallax'] = array(ot_get_option('_uncode_'.$post_type.'_header_parallax'));
		$metabox_data['_uncode_header_kburns'] = array(ot_get_option('_uncode_'.$post_type.'_header_kburns'));
		$metabox_data['_uncode_header_overlay_color'] = array(ot_get_option('_uncode_'.$post_type.'_header_overlay_color'));
		$metabox_data['_uncode_header_overlay_color_alpha'] = array(ot_get_option('_uncode_'.$post_type.'_header_overlay_color_alpha'));
		$metabox_data['_uncode_header_overlay_pattern'] = array(ot_get_option('_uncode_'.$post_type.'_header_overlay_pattern'));

	} else if ($page_header_type === 'header_uncodeblock') {
		if ($media !== '') {
			if (isset($metabox_data['_uncode_header_background'][0])) {
				$metabox_data['_uncode_header_background'] = array(unserialize($metabox_data['_uncode_header_background'][0]));
			}
			$metabox_data['_uncode_header_background'][0]['background-image'] = $media;
			$media = '';
		}
		$get_uncodeblock_id = ot_get_option('_uncode_'.$post_type.'_blocks');
		$metabox_data['_uncode_blocks_list'] = array($get_uncodeblock_id);
	} else if ($page_header_type === 'header_revslider') {
		$get_rev_id = ot_get_option('_uncode_'.$post_type.'_revslider');
		$metabox_data['_uncode_revslider_list'] = array($get_rev_id);
	} else if ($page_header_type === 'header_layerslider') {
		$get_layer_id = ot_get_option('_uncode_'.$post_type.'_layerslider');
		$metabox_data['_uncode_layerslider_list'] = array($get_layer_id);
	}

	$metabox_data['_uncode_header_scroll_opacity'] = array(ot_get_option('_uncode_'.$post_type.'_header_scroll_opacity'));
	$metabox_data['_uncode_header_scrolldown'] = array(ot_get_option('_uncode_'.$post_type.'_header_scrolldown'));
	$metabox_data['_uncode_menu_no_padding'] = array(ot_get_option('_uncode_'.$post_type.'_menu_no_padding'));
	$metabox_data['_uncode_menu_no_padding_mobile'] = array(ot_get_option('_uncode_'.$post_type.'_menu_no_padding_mobile'));

	return array(
		'meta' => $metabox_data,
		'show_title' => $show_title,
		'media' => $media
	);
}

function uncode_compress_css_inline($inline_css) {
	// Remove comments
	$inline_css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $inline_css);

	// Remove space after colons
	$inline_css = str_replace(': ', ':', $inline_css);

	// Remove whitespace
	$inline_css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $inline_css);

	// Write everything out
	return $inline_css;
}

if ( ! function_exists( 'uncode_get_twitter_id' ) ) :
/**
 * Check if a Twitter ID or the whole URL is passed.
 * @since Uncode 1.5.0
 */
function uncode_get_twitter_id( $value ) {
	if ( preg_match( '`([A-Za-z0-9_]{1,25})$`', $value, $match ) ) {
		return 'https://twitter.com/' . $match[1];
	}
	else {
		return $value;
	}
}
endif; //uncode_get_twitter_id

if ( ! function_exists( 'uncode_get_allowed_contact_methods' ) ) :
/**
 * Return allowed contact methods.
 * @since Uncode 1.5.0
 */
function uncode_get_allowed_contact_methods( $user='' ) {

	if ( $user=='' ) {
		return;
	}

	$allowed_methods = array(
		'googleplus',
		'facebook',
		'twitter',
		'dribbble',
		'instagram',
		'url',
		'pinterest',
		'xing',
		'youtube',
		'vimeo',
		'linkedin',
		'tumblr',
	);

	$methods = wp_get_user_contact_methods( $user );
	$out = '';

	//socials taken from contact methods
	foreach ( $methods as $method => $value ) {

		if ( in_array( $method, $allowed_methods ) ) {

			if ( $method === 'twitter' ) {
				$tw = get_the_author_meta( $method, $user );
				$href = uncode_get_twitter_id( $tw );
			} else {
				$href = get_the_author_meta( $method, $user );
			}

			$icon = $method == 'googleplus' ? 'google-plus' : $method;
			if ( $href !== '' ) {
				$out .= '<li class="contact-method-' . esc_attr($method) . '"><a href="' . esc_url( $href ) . '" target="_blank"><i class="fa fa-' . esc_attr( $icon ) . '"></i></a></li>';
			}

		}

	}

	//website URL taken from usermeta
	$user_info = get_userdata( $user );
	$href = $user_info->user_url;
	if ( $href !== '' ) {
		$out .= '<li class="contact-method-link"><a href="' . esc_url( $href ) . '" target="_blank"><i class="fa fa-link"></i></a></li>';
	}

	//return
	if ( $out !== '' ) {
		return
			'<div class="contact-methods contact-methods-userid-' . $user . '">
				<ul>
					' . $out . '
				</ul>
			</div>';
	}

}
endif; //uncode_get_allowed_contact_methods

if ( ! function_exists( 'uncode_btn_style' ) ) :
/**
 * @since Uncode 1.6.0
 */
function uncode_btn_style() {
    $hover_class = ot_get_option('_uncode_button_hover');

    if ( $hover_class == '' ) {
    	return false;
    } else {
	    return 'btn-flat';
    }
}
endif;//uncode_btn_style

add_filter( 'paginate_links', 'uncode_filter_paginate_links' );
if ( ! function_exists( 'uncode_filter_paginate_links' ) ) :
/**
 * @since Uncode 2.2.2
 */
function uncode_filter_paginate_links( $link ) {

	$page = preg_replace('/\\?.*/', '', $link);
	$parse = parse_url( $link );

	if ( isset( $parse['query']) && is_archive() && ( !is_front_page() || ( function_exists('is_shop') && is_shop()) ) ) {
	    parse_str($parse['query'], $query);

	    if ( isset($query['upage']) ) {
	        unset( $query['upage'] );
	    }

	    $build_query = http_build_query($query);
	    if ( $build_query != '' ) $build_query = '?' . $build_query;

	    $link = $page . $build_query;

	}

	return $link;
}
endif;//uncode_filter_paginate_links

if ( ! function_exists( 'uncode_replace_disallowed_videos' ) ) :
/**
 * @since Uncode 1.8.2
 */
function uncode_replace_disallowed_videos( $consent_id, $media_id, $media_oembed, $single_width = '', $single_height = null, $single_fixed = null, $is_metro = false ) {
	if ( uncode_privacy_allow_content( $consent_id ) === false ) {

		global $adaptive_images, $adaptive_images_async, $adaptive_images_async_blur, $dynamic_srcset_active, $dynamic_srcset_sizes, $post, $activate_webp;

		$def = get_option( 'uncode_privacy_fallback', esc_html__('This content is blocked. Please review your [uncode_privacy_box]Privacy Settings[/uncode_privacy_box].', 'uncode') );
		$img_url_id = get_post_meta($media_id, "_uncode_poster_image", true);

		if ( $img_url_id ) {
			$img_attributes = uncode_get_media_info($img_url_id);
			$media_metavalues = unserialize($img_attributes->metadata);
			$image_orig_w = $media_metavalues['width'];
			$image_orig_h = $media_metavalues['height'];
			$media_alt = $img_attributes->alt;
			$single_width = $single_width === '' ? 12 : $single_width;
			$crop = $single_width !== '' && $single_height !== null ? true : false;
			$resized_image = uncode_resize_image($img_attributes->id, $img_attributes->guid, $img_attributes->path, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop);
			$item_media = esc_attr($resized_image['url']);

			$adaptive_async_data = $adaptive_async_class = '';

			// Fallback GDPR video poster
			if ($adaptive_images === 'on' && $adaptive_images_async === 'on') {
				$adaptive_async_class = uncode_get_adaptive_async_class();
				if ( $adaptive_async_class ) {
					$adaptive_async_data = uncode_get_adaptive_async_data( $img_url_id, $img_attributes, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed );
				}
			} else if ( $adaptive_images === 'off' && $dynamic_srcset_active ) {
				$adaptive_async_class    = uncode_get_srcset_async_class();
				$adaptive_async_class    .= ' wp-image-' . $img_url_id;
				$adaptive_async_data_all = uncode_get_srcset_async_data( array( 'full_image' => true, 'activate_webp' => $activate_webp ), $dynamic_srcset_sizes, $img_url_id, $img_attributes, $resized_image, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed );
				$adaptive_async_data     = $adaptive_async_data_all['string'];
			}

			if ( $is_metro ) {
				$output_media = '<div class="t-background-cover'.($adaptive_async_class !== '' ? $adaptive_async_class : '').'" style="background-image:url(\''.$item_media.'\')"'.($adaptive_async_data !== '' ? $adaptive_async_data : '').'></div>';
			} else {
				$image_orig_w = $resized_image['width'];
				$image_orig_h = $resized_image['height'];
				$output_media = apply_filters( 'post_thumbnail_html', '<img' . ( $adaptive_async_class !== '' ? ' class="' . trim( $adaptive_async_class ) . '"' : '' ) . ' src="' . $item_media . '" width="' . $image_orig_w . '" height="' . $image_orig_h . '" alt="' . $media_alt . '"' . ( $adaptive_async_data !== '' ? $adaptive_async_data : '' ) . ' />', $post->ID, $media_id, array($single_width, $single_height), '' );
			}

			$media_oembed = '<div class="uncode-noconsent-gdpr-wrap">
				<div class="uncode-noconsent-gdpr-poster">' . $output_media . '</div>
				<div class="uncode-noconsent-gdpr-overlay"></div>
				<div class="uncode-noconsent-gdpr-content-holder">
					<div class="uncode-noconsent-gdpr-content-wrap">
						<div class="uncode-noconsent-gdpr-icon">
							<i class="fa fa-' . esc_attr( $consent_id == 'youtube' ? $consent_id . '-play' : $consent_id ) . '"></i>
						</div>
						<div class="uncode-noconsent-gdpr-text">' . wp_kses_post( do_shortcode ( $def ) ) . '</div>
					</div>
				</div>
			</div>';
		} else {
			$media_oembed = '<div class="uncode-noconsent-gdpr-wrap uncode-noconsent-gdpr-wrap-no-poster">
				<div class="uncode-noconsent-gdpr-overlay"></div>
				<div class="uncode-noconsent-gdpr-content-holder">
					<div class="uncode-noconsent-gdpr-content-wrap">
						<div class="uncode-noconsent-gdpr-icon">
							<i class="fa fa-' . esc_attr( $consent_id == 'youtube' ? $consent_id . '-play' : $consent_id ) . '"></i>
						</div>
						<div class="uncode-noconsent-gdpr-text">' . wp_kses_post( do_shortcode ( $def ) ) . '</div>
					</div>
				</div>
			</div>';
		}
	}

	return $media_oembed;
}
endif;//uncode_replace_disallowed_videos

add_filter( 'oembed_dataparse', 'uncode_nocookie_oembed' );
if ( ! function_exists( 'uncode_nocookie_oembed' ) ) :
/**
 * @since Uncode 1.8.2
 */
function uncode_nocookie_oembed( $return ) {

	if ( apply_filters( 'uncode_nocookie', false ) )
		$return = str_replace( 'youtube', 'youtube-nocookie', $return );

	return $return;
}
endif;//uncode_nocookie_oembed

add_filter( 'wp_kses_allowed_html', 'uncode_wp_kses_allowed_html', 10, 2 );
if ( ! function_exists( 'uncode_wp_kses_allowed_html' ) ) :
/**
 * @since Uncode 1.9.2
 */
function uncode_wp_kses_allowed_html( $allowed, $context ){

	if ( is_array( $context ) ){
	    return $allowed;
	}

	if ( $context === 'post' ){
	    $allowed['div']['data-border'] = true;
	}

	return $allowed;
}
endif;//uncode_wp_kses_allowed_html

if ( ! function_exists( 'uncode_transient_users' ) ) :
/**
 * @since Uncode 1.9.3
 */
function uncode_transient_users( $force = false ) {
    $users = get_transient( 'uncode_transient_users' );
	$role_list = apply_filters( 'uncode_author_profile_role', array('administrator','editor','author') );

    if ( false === $users || $force === true ) {
        $users = get_users( array( 'role__in' => $role_list ) );
        set_transient( 'uncode_transient_users', $users, 0 );
    }

    return $users;
}
endif;//uncode_transient_users

add_action( 'deleted_user', 'uncode_set_transient_users' );
add_action( 'edit_user_profile', 'uncode_set_transient_users' );
add_action( 'profile_update', 'uncode_set_transient_users' );
add_action( 'wpmu_new_user', 'uncode_set_transient_users' );
add_action( 'user_register', 'uncode_set_transient_users' );
if ( ! function_exists( 'uncode_set_transient_users' ) ) :
/**
 * @since Uncode 1.9.3
 */
function uncode_set_transient_users(){
	uncode_transient_users(true);
}
endif;//uncode_set_transient_users

if ( ! function_exists( 'uncode_wpml_object_id' ) ) :
/**
 * @since Uncode 2.1.0
 */
add_filter( 'uncode_wpml_object_id', 'uncode_wpml_object_id', 5 );
function uncode_wpml_object_id( $post_id ) {
	if ( did_action( 'wpml_loaded' ) ) {
		$post_type = get_post_type( $post_id );
		$wpml_setting = apply_filters( 'wpml_setting', array(), 'custom_posts_sync_option' );
		if ( is_array( $wpml_setting ) && array_key_exists( $post_type, $wpml_setting ) ) {
			$return_original = $wpml_setting[ $post_type ] == WPML_CONTENT_TYPE_DISPLAY_AS_IF_TRANSLATED;
			return apply_filters( 'wpml_object_id', $post_id, $post_type, $return_original );
		}
	}
	return $post_id;
}
endif;//uncode_wpml_object_id

if ( ! function_exists( 'uncode_get_product_header_cb' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_product_header_cb(){
	global $post;
	$product_header = false;
	if ( function_exists('is_product') && is_product()) {
		if ( get_post_meta( $post->ID, '_uncode_header_type', true ) !== '' && get_post_meta( $post->ID, '_uncode_header_type', true ) !== 'none') {
			$product_header = get_post_meta( $post->ID, '_uncode_blocks_list', true );
		} else {
			if ( ot_get_option( '_uncode_product_header' ) === 'header_uncodeblock' && get_post_meta( $post->ID, '_uncode_header_type', true ) === '' ) {
				$product_header = ot_get_option('_uncode_product_blocks');
			}
		}

		if ( ! isset( $product_header ) || $product_header === '' || $product_header === 'none' ) {
			$product_header = false;
		}
	}
	return apply_filters( 'uncode_get_product_header_cb', $product_header );
}
endif;//uncode_get_product_header_cb

if ( ! function_exists( 'uncode_get_content_cb' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_content_cb(){
	global $post;
	$content_cb = false;
	$post_type = '';
	if ($post && isset($post->post_type)) {
		$post_type = $post->post_type;
		if ( get_post_meta( $post->ID, '_uncode_specific_select_content', true ) === 'uncodeblock'
			&& get_post_meta( $post->ID, '_uncode_specific_content_block', true ) !== ''
			&& get_post_meta( $post->ID, '_uncode_specific_content_block', true ) !== 'none') {
			$content_cb = get_post_meta( $post->ID, '_uncode_specific_content_block', true );
		} elseif ( ot_get_option('_uncode_' . $post_type . '_select_content') === 'uncodeblock' && ot_get_option('_uncode_' . $post_type . '_content_block') !== '' && get_post_meta( $post->ID, '_uncode_specific_select_content', true ) === '' ) {
			$content_cb = ot_get_option('_uncode_' . $post_type . '_content_block');
		}
	}

	if ( ! isset( $content_cb ) || $content_cb === '' || $content_cb === 'none' ) {
		$content_cb = false;
	}
	return apply_filters( 'uncode_get_content_cb', $content_cb );
}
endif;//uncode_get_content_cb

if ( ! function_exists( 'uncode_custom_dynamic_heading_in_content' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_custom_dynamic_heading_in_content( $type = 'title' ){
	global $post;

	$title = get_the_title();
	$get_subtitle = get_the_excerpt();

	if ( is_archive() ) {
		if ($post && isset($post->post_type)) {
			$post_type = $post->post_type . '_index';
		} else {
			global $wp_taxonomies;
			if ( isset($wp_taxonomies[$wp_query->get_queried_object()->taxonomy]) ) {
				$get_object = $wp_taxonomies[$wp_query->get_queried_object()->taxonomy];
				$post_type = $get_object->object_type[0] . '_index';
			}
		}

		if (is_author()) {
			$post_type = 'author_index';
		}

		$title = uncode_archive_title();
		$get_subtitle = isset(get_queried_object()->description) ? get_queried_object()->description : '';

		if ( ot_get_option('_uncode_' . $post_type . '_custom_title_activate') === 'on' && !is_category() && !is_tax() ) {
			$title = ot_get_option('_uncode_' . $post_type . '_custom_title_text');
			$get_subtitle = ot_get_option('_uncode_' . $post_type . '_custom_subtitle_text');
		}

		$title = apply_filters( 'uncode_archive_title', $title );
		$get_subtitle = apply_filters( 'uncode_archive_subtitle', $get_subtitle );

	}

	if ( $type === 'subtitle' ) {
		return apply_filters( 'uncode_custom_dynamic_heading_in_content', $get_subtitle, $type );
	}

	return apply_filters( 'uncode_custom_dynamic_heading_in_content', $title, $type );

}
endif;//uncode_custom_dynamic_heading_in_content

if ( ! function_exists( 'uncode_get_secondary_featured_thumbnail_id' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_secondary_featured_thumbnail_id( $post_id ) {
	$secondary_featured_image_id = get_post_meta( $post_id, '_uncode_secondary_thumbnail_id', true );
	$secondary_featured_image_id = $secondary_featured_image_id > 0 ? absint( $secondary_featured_image_id ) : false;

	return apply_filters( 'uncode_get_secondary_featured_thumbnail_id', $secondary_featured_image_id, $post_id );
}
endif;//uncode_get_secondary_featured_thumbnail_id

if ( ! function_exists( 'uncode_get_term_secondary_featured_thumbnail_id' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_term_secondary_featured_thumbnail_id( $term_id ) {
	$term_secondary_featured_image_id = get_term_meta( $term_id, 'uncode_term_secondary_thumbnail_id', true );
	$term_secondary_featured_image_id = $term_secondary_featured_image_id > 0 ? absint( $term_secondary_featured_image_id ) : false;

	return apply_filters( 'uncode_get_term_secondary_featured_thumbnail_id', $term_secondary_featured_image_id, $term_id );
}
endif;//uncode_get_term_secondary_featured_thumbnail_id

if ( ! function_exists( 'uncode_get_term_featured_thumbnail_id' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_term_featured_thumbnail_id( $term_id ) {
	$thumb_found    = false;
	$is_product_cat = false;

	// Check custom module thumb ID first
	$term_featured_image_id = absint( get_term_meta( $term_id, 'uncode_term_thumbnail_id', true ) );
	$thumb_found            = $term_featured_image_id > 0 ? true : false;

	// Check product cat thumbnail
	if ( ! $thumb_found ) {
		$term = get_term( $term_id );

		if ( $term->taxonomy && $term->taxonomy === 'product_cat' ) {
			$is_product_cat         = true;
			$term_featured_image_id = absint( get_term_meta( $term_id, 'thumbnail_id', true ) );
			$thumb_found            = $term_featured_image_id > 0 ? true : false;
		}
	}

	// Check legacy "Featured Image" (background)
	if ( ! $thumb_found ) {
		$term_meta = get_option( '_uncode_taxonomy_' . $term_id );

		if ( is_array( $term_meta ) && isset( $term_meta['term_media'] ) && $term_meta['term_media'] > 0 ) {
			$term_featured_image_id = absint( $term_meta['term_media'] );
			$thumb_found            = $term_featured_image_id > 0 ? true : false;
		}
	}

	// Return WC placeholder ID for product cats when we don't find anything
	if ( $is_product_cat && ! $thumb_found ) {
		$term_featured_image_id = absint( get_option( 'woocommerce_placeholder_image', 0 ) );
	}

	return apply_filters( 'uncode_get_term_featured_thumbnail_id', $term_featured_image_id, $term_id );
}
endif;//uncode_get_term_featured_thumbnail_id

if ( ! function_exists( 'uncode_adaptive_secondary_featured_thumbnail' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_adaptive_secondary_featured_image( $post_id, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed, $is_tax_block, $block_data ) {
	global $adaptive_images, $adaptive_images_async, $adaptive_images_async_blur, $dynamic_srcset_active, $dynamic_srcset_sizes, $activate_webp;

	$thumb_id = $is_tax_block ? uncode_get_term_secondary_featured_thumbnail_id( $post_id ) : uncode_get_secondary_featured_thumbnail_id( $post_id );

	if ( $thumb_id === false ) {
		return false;
	}

	// At this level, $image_orig_w and $image_orig_h are the sizes of the
	// real featured image (not the sizes of the secondary featured image)
	// We can use those values to calculate the ratio of the featured image,
	// keeping the same ratio also in the secondary (for regulars).
	if ( $adaptive_images === 'off' && $dynamic_srcset_active && ! $crop ) {
		if ( $image_orig_h > 0 ) {
			$ratio             = $image_orig_h > 0 ? floatval( $image_orig_w ) / floatval( $image_orig_h ) : 1;
			$old_single_height = floatval( $single_height );

			if ( $ratio > 0 ) {
				$new_single_height = floatval( $single_width ) / $ratio;
			}

			if ( $new_single_height !== $old_single_height ) {
				$crop          = true;
				$single_height = $new_single_height;
			}
		}
	}

	$media_attributes = uncode_get_media_info( $thumb_id );
	if ( isset($media_attributes->metadata) ) {
		$media_metavalues = unserialize($media_attributes->metadata);
		$image_orig_w = $media_metavalues['width'];
		$image_orig_h = $media_metavalues['height'];
	}
	if ( isset($media_attributes->post_mime_type) ) {
		$media_mime = $media_attributes->post_mime_type;
	} else {
		return false;
	}

	if ( ! ( strpos($media_mime, 'image/') !== false && $media_mime !== 'image/url' ) ) {
		return false;
	}

	$resized_image = uncode_resize_image($media_attributes->id, $media_attributes->guid, $media_attributes->path, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed);

	if ( $adaptive_images === 'on' && $adaptive_images_async === 'on' ) {
		$resized_image['data_async'] = uncode_get_adaptive_async_data( $thumb_id, $media_attributes, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed );
	} else if ( $adaptive_images === 'off' && $dynamic_srcset_active ) {
		if ( $activate_webp ) {
			$block_data['activate_webp'] = true;
		}
		$resized_image['id']                    = $thumb_id;
		$resized_image['alt']                   = isset( $media_attributes->alt ) ? $media_attributes->alt : '';
		$adaptive_async_data                    = uncode_get_srcset_async_data( $block_data, $dynamic_srcset_sizes, $thumb_id, $media_attributes, $resized_image, $image_orig_w, $image_orig_h, $single_width, $single_height, $crop, $single_fixed );
		$resized_image['data_async']            = $adaptive_async_data['string'];
		$resized_image['srcset']                = $adaptive_async_data['srcset'];
		$resized_image['srcset_placeholder']    = $adaptive_async_data['srcset_placeholder'];
		$resized_image['loading']               = $adaptive_async_data['loading'];
		$resized_image['string_without_srcset'] = $adaptive_async_data['string_without_srcset'];
	}

	return apply_filters( 'uncode_adaptive_secondary_featured_image', $resized_image, $post_id );
}
endif;//uncode_get_secondary_featured_thumbnail_id

if ( ! function_exists( 'uncode_get_header_from_content' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_header_from_content($output = 'header') {
	global $post;

	$post_id = $post->ID;
	$content = $post->post_content;

	if ( $output == 'content' ) {
		$trimmed = preg_replace('#\[vc_row(.*?)\/vc_row]#s', '', $content, 1);
		$return = $trimmed;
	} else {
		$first_row = preg_match('#\[vc_row(.*?)\/vc_row]#s', $content, $matches);
		$return = isset($matches[0]) && $matches[0] !== '' ? $matches[0] : '';
	}

	return $return;
}
endif;//uncode_get_header_from_content

if ( ! function_exists( 'uncode_get_the_content' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_get_the_content($content = false, $check = false) {
	global $post, $metabox_data, $is_cb;

	$content_cb = false;

	if ( $post ) {
		$post_id = $post->ID;
		$post_type = $post->post_type;
		$content_cb = uncode_get_content_cb();

		// If post password required and it doesn't match the cookie.
		if ( post_password_required( $post ) ) {
			return get_the_password_form( $post );
		}

		if ( !$content ) {

			if ( ( ot_get_option('_uncode_' . $post_type . '_select_content') === 'none' && ( !isset($metabox_data['_uncode_specific_select_content'][0]) || $metabox_data['_uncode_specific_select_content'][0] === '' )
				|| ( isset($metabox_data['_uncode_specific_select_content'][0]) && $metabox_data['_uncode_specific_select_content'][0] == 'none' ) ) ) {
				return '';
			}

			if ( $content_cb ) {
				$is_cb = $content_cb;
				$object_cb = get_post($content_cb);
				$content = $object_cb->post_content;
			} else {
				$is_cb = false;
				$content = get_the_content();
			}
		}
		$header_type = get_post_meta( $post_id, '_uncode_header_type', true );

		if ( $header_type === 'first_row' && ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) ) {
			$content = preg_replace('#\[vc_row(.*?)\/vc_row]#s', '', $content, 1);
		}
	}

	if ( $check ) {
		$content = $content_cb;
	}

	return $content;
}
endif;//uncode_get_the_content
add_filter( 'uncode_get_the_content', 'uncode_get_the_content', 1 );

if ( ! function_exists( 'uncode_filter_cpt_content_header' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_filter_cpt_content_header($content) {
	$post_type = get_post_type();
	$post_types = array('post','page','portfolio');
	$post_id = get_the_id();
	$header_type = get_post_meta( $post_id, '_uncode_header_type', true );

	if ( is_singular() && !in_array( $post_type, $post_types ) && $header_type === 'first_row' && ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) ) {
		$content = get_the_content();
		$content = preg_replace('#\[vc_row(.*?)\/vc_row]#s', '', $content, 1);
	}

	return $content;
}
endif;//uncode_filter_cpt_content_header
add_filter( 'the_content', 'uncode_filter_cpt_content_header', 1 );

if ( ! function_exists( 'uncode_populate_post_object' ) ) :
/**
 * Get first post of a given post type.
 * @since Uncode 2.3.0
 */
function uncode_populate_post_object( $post_type = 'product' ) {
	$post = false;
	if ( ! class_exists( 'WooCommerce' ) && $post_type == 'product' ) {
		$post_type = 'post';
	}
	$args = array(
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => '1',
		'orderby'        => 'id',
		'order'          => 'asc',
	);

	$posts = get_posts( $args );

	if( empty($posts) ) {
		return;
	}

	foreach( $posts as $_post ) {
		$post_id = apply_filters( 'uncode_default_frontend_editor_' . $post_type . '_id', $_post->ID );
		if ( class_exists( 'WooCommerce' ) && $post_type === 'product' ) {
			$post = wc_get_product( $post_id );
		} else {
			$post = get_post( $post_id );
		}
	}

	return $post;
}
endif;//uncode_populate_post_object

if ( ! function_exists( 'uncode_menu_overlay_focus' ) ) :
/**
 * @since Uncode 2.4.0
 */
function uncode_menu_overlay_focus( ) {
	$menutype = ot_get_option('_uncode_headers');

	if ( ot_get_option( '_uncode_menu_focus' ) === 'on' && ot_get_option( '_uncode_menu_full' ) === 'on' && ot_get_option( '_uncode_boxed' ) === 'off' && strpos($menutype, 'hmenu') !== false &&  ot_get_option( '_uncode_submenu_style' ) === 'menu-sub-enhanced' ) {
		echo '<div class="overlay-menu-focus style-dark-bg ' . apply_filters( 'uncode_over_focus_menu_classes' , '' ) . '"></div>';
	}
}
endif;//uncode_menu_overlay_focus
add_action( 'uncode_after_page_footer', 'uncode_menu_overlay_focus' );

if ( ! function_exists( 'uncode_get_attachment_image_src' ) ) :
/**
 * Get a specific size (if exists). We can't use wp_get_attachment_image_src()
 * because that function returns the nearest size. We want the exact size instead
 * and false if it doesn't exist.
 * @since Uncode 2.4.0
 */
function uncode_get_attachment_image_src( $id, $size ) {
	$is_image = wp_attachment_is_image( $id );

	/**
	 * Filters whether to preempt the output of image_downsize().
	 *
	 * Returning a truthy value from the filter will effectively short-circuit
	 * down-sizing the image, returning that value instead.
	 *
	 * @since 2.5.0
	 *
	 * @param bool|array   $downsize Whether to short-circuit the image downsize.
	 * @param int          $id       Attachment ID for image.
	 * @param array|string $size     Requested size of image. Image size name, or array of width
	 *                               and height values (in that order).
	 */
	$out = apply_filters( 'image_downsize', false, $id, $size );

	if ( $out ) {
		return $out;
	}

	$img_url          = wp_get_attachment_url( $id );
	$meta             = wp_get_attachment_metadata( $id );
	$width            = 0;
	$height           = 0;
	$is_intermediate  = false;
	$img_url_basename = wp_basename( $img_url );

	if ( ! $size || ! is_array( $meta ) || empty( $meta['sizes'] ) ) {
		return false;
	}

	// If the file isn't an image, attempt to replace its URL with a rendered image from its meta.
	// Otherwise, a non-image type could be returned.
	if ( ! $is_image ) {
		if ( ! empty( $meta['sizes']['full'] ) ) {
			$img_url          = str_replace( $img_url_basename, $meta['sizes']['full']['file'], $img_url );
			$img_url_basename = $meta['sizes']['full']['file'];
			$width            = $meta['sizes']['full']['width'];
			$height           = $meta['sizes']['full']['height'];
		} else {
			return false;
		}
	}

	// Try for a new style intermediate size.
	$data = array();

	$candidates = array();

	foreach ( $meta['sizes'] as $_size => $data ) {
		if ( intval( $data['width'] ) === intval( $size[0] ) ) {
			$candidates[ $data['width'] * $data['height'] ] = $data;
			break;
		}
	}

	if ( ! empty( $candidates ) ) {
		// Sort the array by size if we have more than one candidate.
		if ( 1 < count( $candidates ) ) {
			ksort( $candidates );
		}

		$data = array_shift( $candidates );
		/*
		* When the size requested is smaller than the thumbnail dimensions, we
		* fall back to the thumbnail size to maintain backward compatibility with
		* pre 4.6 versions of WordPress.
		*/
	} else {
		return false;
	}

	// Constrain the width and height attributes to the requested values.
	list( $data['width'], $data['height'] ) = image_constrain_size_for_editor( $data['width'], $data['height'], $size );

	// If we still don't have a match at this point, return false.
	if ( empty( $data ) ) {
		return false;
	}

	// Include the full filesystem path of the intermediate file.
	if ( empty( $data['path'] ) && ! empty( $data['file'] ) && ! empty( $imagedata['file'] ) ) {
		$file_url     = wp_get_attachment_url( $id );
		$data['path'] = path_join( dirname( $imagedata['file'] ), $data['file'] );
		$data['url']  = path_join( dirname( $file_url ), $data['file'] );
	}

	$data = apply_filters( 'image_get_intermediate_size', $data, $id, $size );

	if ( $data ) {
		$img_url         = str_replace( $img_url_basename, $data['file'], $img_url );
		$width           = $data['width'];
		$height          = $data['height'];
		$is_intermediate = true;

		return array( $img_url, $width, $height, $is_intermediate );
	}

	return false;
}
endif;//uncode_get_attachment_image_src

if ( ! function_exists( 'uncode_wp_nav_menu_filter' ) ) :
/**
 * Menu item counter
 * @since Uncode 2.4.0
 */
function uncode_wp_nav_menu_filter( $nav_menu, $args ) {
	global $el_counter;
	$el_counter = 0;
	return $nav_menu;
}
endif;//uncode_wp_nav_menu_filter
add_filter( 'wp_nav_menu', 'uncode_wp_nav_menu_filter', 10, 2 );

if ( ! function_exists( 'uncode_get_button_proportions' ) ) :
/**
 * Get button proportions from the Theme Options.
 * @since Uncode 2.4.0
 */
function uncode_get_button_proportions() {
	$proportions = ot_get_option('_uncode_button_proportions');

	switch ( $proportions ) {
		case 'style2':
			$k = 1;
			$base_height = 1;
			$ratio = 1.65;

			break;

		case 'style3':
			$k = 1.1;
			$base_height = 1.4;
			$ratio = 1.7;
			break;

		default:
			$k = 1.1;
			$base_height = 1;
			$ratio = 2.4;
			break;
	}

	// [0] => top-bottom, [1] => lateral
	$modifiers = array(
		$base_height * $k,
		$base_height * $ratio * $k
	);

	return $modifiers;
}
endif;//uncode_get_button_proportions
