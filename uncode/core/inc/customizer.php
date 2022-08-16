<?php

/**
 * uncode Theme Customizer
 *
 * @package uncode
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function uncode_customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}
add_action('customize_register', 'uncode_customize_register');

function uncode_custom_excerpt_length($length)
{
	return 20;
}
add_filter('excerpt_length', 'uncode_custom_excerpt_length', 999);

function uncode_wpcf7_ajax_loader() {
	return get_template_directory_uri() . '/library/img/fading-squares.gif';
}

add_filter( 'wpcf7_ajax_loader', 'uncode_wpcf7_ajax_loader', 10 );

add_filter( 'rp4wp_append_content', '__return_false' );

function uncode_the_content($the_content) {

	$oembed = new WP_Embed();
	$the_content = $oembed->autoembed($the_content);
	$the_content = wptexturize($the_content);
	$the_content = convert_smilies($the_content);
	$the_content = convert_chars($the_content);
	$the_content = wpautop($the_content);
	$the_content = shortcode_unautop($the_content);
	$the_content = do_shortcode($the_content);
	return $the_content;
}

function uncode_remove_p_tag( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}
	$content = do_shortcode( shortcode_unautop( $content ) );
	$content = preg_replace('/<p[^>]*>\[vc_row(.*?)\/vc_row]<\/p>/', '[vc_row$1/vc_row]', $content);
	$content = preg_replace('/<p[^>]*><div/', '<div', $content);
	$content = preg_replace('/\/div><\/p>/', '/div>', $content);
	$content = preg_replace('|<p><!--(.*?)--></p>|', '<!--$1-->', $content);
	$content = preg_replace('/<p><\/p>/', '', $content);

	if ( function_exists( 'wp_filter_content_tags' ) ) {
		$content = wp_filter_content_tags( $content );
	}

	return $content;
}

add_filter( 'wp_insert_post_data', 'uncode_wp_insert_post_data', 10, 2 );
function uncode_wp_insert_post_data( $data, $postarr ) {

	$content = $data['post_content'];

	$content = preg_replace('/<p[^>]*>\[\/vc_column_text]\[vc_column_text]<\/p>/', '[/vc_column_text][vc_column_text]', $content);
	$content = preg_replace('/<p[^>]*>\[\/uncode_list]\[uncode_list]<\/p>/', '[/uncode_list][uncode_list]', $content);
	$content = preg_replace('/<p[^>]*>\[\/vc_custom_heading]\[vc_custom_heading]<\/p>/', '[/vc_custom_heading][vc_custom_heading]', $content);
	$content = preg_replace('/<p[^>]*>\[\/vc_icon]\[vc_icon]<\/p>/', '[/vc_icon][vc_icon]', $content);
	$content = preg_replace('/<p[^>]*>\[\/vc_message]\[vc_message]<\/p>/', '[/vc_message][vc_message]', $content);
	$content = preg_replace('/<p[^>]*>\[vc_row/', '[vc_row', $content);
	$content = preg_replace('/\[vc_column_text(.*?)\]<\/p>/', '[vc_column_text$1]', $content);
	$content = preg_replace('/\[uncode_list(.*?)\]<\/p>/', '[uncode_list$1]', $content);
	$content = preg_replace('/\[vc_custom_heading(.*?)\]<\/p>/', '[vc_custom_heading$1]', $content);
	$content = preg_replace('/\[vc_icon(.*?)\]<\/p>/', '[vc_icon$1]', $content);
	$content = preg_replace('/\[vc_message(.*?)\]<\/p>/', '[vc_message$1]', $content);
	$content = preg_replace('/<p[^>]*>\[vc_row(.*?)\/vc_row]<\/p>/', '[vc_row$1/vc_row]', $content);
	$data['post_content'] = $content;

	return $data;
}

/**
 * Additional filter to disable default WP filter `wp_lazy_loading_enabled`
 *
 * @since Uncode 2.2.8.2
 */
add_filter( 'wp_lazy_loading_enabled', 'uncode_lazy_loading_enabled' );
if ( ! function_exists( 'uncode_lazy_loading_enabled' ) ) :
	function uncode_lazy_loading_enabled(){
		return apply_filters( 'uncode_lazy_loading_enabled', false );
	}
endif;
