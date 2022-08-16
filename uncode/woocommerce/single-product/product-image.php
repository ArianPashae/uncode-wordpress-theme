<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product, $vc_column_inner_width, $adaptive_images, $adaptive_images_async, $adaptive_images_async_blur;

$post_type = uncode_get_current_post_type();

if ( ! $product ) {
	$product = uncode_populate_post_object();
}

$product_id = $product->get_id();

$woocommerce_gallery_thumbnail = wc_get_image_size('woocommerce_gallery_thumbnail');
$th_crop = $woocommerce_gallery_thumbnail['crop'];
if ( isset($vc_ratio) ) {
	if ( $vc_ratio !== '' ) {
		$th_crop = true;
	} else {
		$th_crop = false;
	}
}
$wc_height = $woocommerce_gallery_thumbnail['height'];
$wc_width = $woocommerce_gallery_thumbnail['width'];
$thumb_ratio = $th_crop ? $wc_width / $wc_height : null;

$_uncode_thumb_layout = ot_get_option('_uncode_product_image_layout');
$_uncode_thumb_layout = get_post_meta($product_id, '_uncode_product_image_layout', 1) !== '' ? get_post_meta($product_id, '_uncode_product_image_layout', 1) : $_uncode_thumb_layout;
$_uncode_thumb_layout = isset( $vc_thumb_layout ) ? $vc_thumb_layout : $_uncode_thumb_layout;

$_uncode_product_thumb_cols = ot_get_option('_uncode_product_thumb_cols');
$_uncode_product_thumb_cols = get_post_meta($product_id, '_uncode_thumb_cols', 1) !== '' ? get_post_meta($product_id, '_uncode_thumb_cols', 1) : $_uncode_product_thumb_cols;
$_uncode_product_thumb_cols = isset( $vc_columns ) ? $vc_columns : $_uncode_product_thumb_cols;
$_uncode_product_thumb_margin = $_uncode_thumb_layout == 'stack' ? ' single-bottom-margin' : '';
$_uncode_product_thumb_margin = isset( $vc_margin ) ? ' ' . $vc_margin : $_uncode_product_thumb_margin;

$col_size = ot_get_option('_uncode_product_media_size') == '' ? 6 : ot_get_option('_uncode_product_media_size');
$col_size = isset($vc_column_inner_width) && $vc_column_inner_width !== '' ? $vc_column_inner_width : $col_size;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', $_uncode_product_thumb_cols == '' ? 3 : $_uncode_product_thumb_cols );
$post_thumbnail_id = apply_filters( 'uncode_product_image_id', $product->get_image_id(), $product_id );
$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
$placeholder       = $post_thumbnail_id ? 'with-images' : 'without-images';

$wrapper_classes = array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'woocommerce-layout-images-' . $_uncode_thumb_layout,
	'images',
);

$woo_carousel = false;
$gallery_images_ids = apply_filters( 'uncode_product_gallery_thumb_ids', $product->get_gallery_image_ids(), $product_id );

if ( uncode_woocommerce_single_product_slider_enabled(true) && $_uncode_thumb_layout === '' && is_array( $gallery_images_ids ) && !empty( $gallery_images_ids ) ) {
	foreach( $gallery_images_ids as $_gallery_img_id ) {
		if ( get_post($_gallery_img_id) ) {
			$woo_carousel = true;
			$wrapper_classes[] = 'owl-carousel-wrapper';
		}
	}

}

$wrapper_classes = apply_filters( 'woocommerce_single_product_image_gallery_classes', $wrapper_classes);

?>
	<?php
		if ( $post_thumbnail_id ) {
			$media_id = $post_thumbnail_id;
			$image_title = esc_attr( get_the_title( $media_id ) );
			$image_attributes = uncode_get_media_info($media_id);
			$image_metavalues = unserialize($image_attributes->metadata);
			$image_resized = uncode_resize_image($image_attributes->id, $image_attributes->guid, $image_attributes->path, $image_metavalues['width'], $image_metavalues['height'], $col_size, null, false);
			$small_image_resized = uncode_resize_image($image_attributes->id, $image_attributes->guid, $image_attributes->path, $image_metavalues['width'], $image_metavalues['height'], 1, 1, true); //lightbox thumbs

			$image_link = wp_get_attachment_image_src( $media_id, 'full' )[0];

			$attributes = array(
				//'title'                   => $image_title,
				'data-src'                => $image_link,
	            'data-caption'            => $image_title,
				'data-large_image'        => $image_link,
				'data-large_image_width'  => $image_metavalues['width'],
				'data-large_image_height' => $image_metavalues['height'],
			);

			if ( $adaptive_images === 'on' && uncode_woocommerce_single_product_slider_enabled(true) && $_uncode_thumb_layout === '' && is_array( $gallery_images_ids ) && !empty( $gallery_images_ids ) ) {
				$attributes['src'] = $image_resized['url'];
			}

			if ($adaptive_images === 'on') {
				$attributes['data-singlew'] = $col_size;
				$attributes['data-singleh'] = null;
				$attributes['data-crop'] = false;
			}

			if ($adaptive_images === 'on' && $adaptive_images_async === 'on') {
				$adaptive_async_class = uncode_get_adaptive_async_class();
				if ( $adaptive_async_class ) {
					$attributes['class']         = $adaptive_async_class;
					$attributes['data-uniqueid'] = $media_id.'-'.uncode_big_rand();
					$attributes['data-guid']     = $image_attributes->guid;
					$attributes['data-path']     = $image_attributes->path;
					$attributes['data-width']    = $image_metavalues['width'];
					$attributes['data-height']   = $image_metavalues['height'];
				}
			}

			global $gallery_id;
			$gallery_id = uncode_big_rand();

			$data_lbox = isset( $vc_lightbox ) && $vc_lightbox === 'yes' ? '' : ' data-lbox="ilightbox_gallery-' . $gallery_id . '" data-lb-index="0"';
			$lb_disabled = $data_lbox == '' ? ' lb-disabled' : '';

			$html = '<div class="woocommerce-product-gallery__image woocommerce-product-gallery__image-first' . $_uncode_product_thumb_margin . '"><span class="zoom-overlay"></span><a href="' . esc_url( $image_link ) . '" itemprop="image" class="woocommerce-main-image' . $lb_disabled . '" data-caption="' . get_post_field( 'post_excerpt', $post_thumbnail_id ) . '" data-options="thumbnail: \''.$small_image_resized['url'].'\'"' . $data_lbox . '>';
			$html .= get_the_post_thumbnail( $product_id, 'full', $attributes );
			$html .= '</a></div>';

		} else {

			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';

		}

	?>

<?php if ( ! isset( $vc_thumb_layout ) ) { ?>
<div class="uncode-wrapper uncode-single-product-gallery">
<?php } ?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>"<?php if ( ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) && $post_type !== 'uncodeblock' ) { ?> style="opacity: 0; transition: opacity .05s ease-in-out;"<?php } ?>>
	<figure class="woocommerce-product-gallery__wrapper<?php if ( $woo_carousel ) { echo ' owl-carousel'; } ?>">

	<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); ?>

	<?php if ( ! isset( $vc_thumb_layout ) ) {
		do_action( 'woocommerce_product_thumbnails' );
	} else {
		$images_arr = array(
			'vc_thumb_layout' => $vc_thumb_layout,
			'vc_nav' => $vc_nav,
			'vc_lightbox' => $vc_lightbox,
			'vc_ratio' => $vc_ratio,
			'vc_padding' => $vc_padding,
		);
		if ( $vc_thumb_layout == 'stack' && isset( $vc_margin ) ) {
			$images_arr['vc_margin'] = $vc_margin;
		}
		if ( apply_filters( 'uncode_woocommerce_show_product_thumbnails', true ) ) {
			wc_get_template( 'single-product/product-thumbnails.php', $images_arr );
		}
	} ?>

	</figure>
</div>

<?php
	if ( isset( $vc_thumb_layout ) && $vc_nav !== 'thumbs' ) {
		$woo_carousel = false;
	}

	if ( $woo_carousel ) {
?>

<?php if ( apply_filters( 'uncode_woocommerce_show_product_thumbnails', true ) ) : ?>

<div class="woocommerce-product-gallery-nav-wrapper" <?php if ( ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) && $post_type !== 'uncodeblock' ) { ?> style="opacity: 0; transition: opacity .05s ease-in-out;"<?php } ?>>
	<div class="woocommerce-product-gallery-nav owl-carousel-wrapper">
		<ul class="woocommerce-product-gallery__wrapper-nav owl-carousel">

		<?php

			if ( $post_thumbnail_id ) {
				$media_id = $post_thumbnail_id;
				$image_title = esc_attr( get_the_title( $media_id ) );
				$image_attributes = uncode_get_media_info($media_id);
				$image_metavalues = unserialize($image_attributes->metadata);
				if ($image_attributes->post_mime_type === 'image/gif' || $image_attributes->post_mime_type === 'image/url') {
					$th_crop = false;
				}
				$carousel_thumb_cols = ( 12 / $columns ) / ( 12 / $col_size );
				$image_resized = uncode_resize_image($image_attributes->id, $image_attributes->guid, $image_attributes->path, $image_metavalues['width'], $image_metavalues['height'], $carousel_thumb_cols, ($th_crop ? $carousel_thumb_cols / $thumb_ratio : null), $th_crop);

				$image_link = wp_get_attachment_image_src( $media_id, 'full' )[0];
				$image_srcset = wp_get_attachment_image_srcset( $media_id, 'full' );

				$attributes = array(
					'data-src'                => $image_link,
		            'data-caption'            => $image_title,
					'data-large_image'        => $image_link,
					'data-large_image_width'  => $image_metavalues['width'],
					'data-large_image_height' => $image_metavalues['height'],
					'sizes'					  => 'false',
				);

				if ( isset($vc_ratio) ) {
					$attach_size = 'full';
				} else {
					$attach_size = 'woocommerce_gallery_thumbnail';
				}

				if ( $adaptive_images === 'on' && $_uncode_thumb_layout !== 'stack' ) {
					$attach_size = 'full';
					$attributes['src'] = $image_resized['url'];
				}

				if ($adaptive_images === 'on') {
					$attributes['data-singlew'] = $col_size;
					$attributes['data-singleh'] = ($th_crop ? $col_size / $thumb_ratio : null);
					$attributes['data-crop'] = $th_crop;
				}

				if ($adaptive_images === 'on' && $adaptive_images_async === 'on') {
					$adaptive_async_class = uncode_get_adaptive_async_class();
					if ( $adaptive_async_class ) {
						$attributes['class']         = $adaptive_async_class;
						$attributes['data-uniqueid'] = $media_id.'-'.uncode_big_rand();
						$attributes['data-guid']     = $image_attributes->guid;
						$attributes['data-path']     = $image_attributes->path;
						$attributes['data-width']    = $image_metavalues['width'];
						$attributes['data-height']   = $image_metavalues['height'];
					}
				}

				$attributes['data-o_src'] = $image_link;
				$attributes['data-o_srcset'] = $image_srcset;

				global $gallery_id;
				$gallery_id = uncode_big_rand();

				$html = '<li class="woocommerce-product-gallery__thumb woocommerce-product-gallery__first-thumb">';
				$html .= wp_get_attachment_image( $post_thumbnail_id, $attach_size, false, $attributes );
				$html .= '</li>';

			} else {

				$html  = '<li class="woocommerce-product-gallery__thumb">';
				$html .= sprintf( '<img src="%s" alt="%s">', esc_url( wc_placeholder_img_src( $attach_size ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</li>';

			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html_nav', $html, $post_thumbnail_id );

			if ( isset( $vc_thumb_layout ) ) {
				$images_arr = array(
					'slider_nav' => true,
					'vc_thumb_layout' => $vc_thumb_layout,
					'vc_columns' => $vc_columns,
					'vc_nav' => $vc_nav,
					'vc_lightbox' => $vc_lightbox,
					'vc_ratio' => $vc_ratio,
				);
			} else {
				$images_arr = array(
					'slider_nav' => true,
				);
			}
			wc_get_template( 'single-product/product-thumbnails.php', $images_arr );
		?>

		</ul>

	</div>

</div>

<?php endif; ?>

<?php
	}
?>

<?php if ( ! isset( $vc_thumb_layout ) ) {
echo '</div>'; // .uncode-wrapper.uncode-single-product-gallery
} ?>

