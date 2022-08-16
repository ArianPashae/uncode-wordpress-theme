<?php
/**
 * Custom Curso
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'uncode_check_for_custom_cursor' ) ) :
/**
 * @since Uncode 2.3.4
 */
function uncode_check_for_custom_cursor() {
	global $uncode_post_data;

	$content_array = uncode_get_post_data_content_array();


	foreach ( $content_array as $content ) {
		if ( strpos( $content, 'custom_cursor="yes"' ) !== false || strpos( $content, 'custom_cursor=\'yes\'' ) !== false || strpos( $content, 'el_class="custom-cursor"' ) !== false || strpos( $content, 'el_class=\'custom-cursor\'' ) !== false ) {
			return true;
		}
	}
}
endif; //uncode_check_for_custom_cursor

if ( ! function_exists( 'uncode_custom_cursor' ) ) :
/**
 * @since Uncode 2.3.4
 */
function uncode_custom_cursor() {

	global $metabox_data;

	$custom_cursor = ot_get_option( '_uncode_custom_cursor' );
	$link_only = ot_get_option( '_uncode_custom_cursor_links' );

	if ( isset($metabox_data['_uncode_specific_custom_cursor'][0]) && $metabox_data['_uncode_specific_custom_cursor'][0] != '' ) {
		$custom_cursor = $metabox_data['_uncode_specific_custom_cursor'][0];
	}

	if ( isset($metabox_data['_uncode_specific_custom_cursor_links'][0]) && $metabox_data['_uncode_specific_custom_cursor_links'][0] != '' ) {
		$link_only = $metabox_data['_uncode_specific_custom_cursor_links'][0];
	}

	if ( $custom_cursor === '' || $custom_cursor === 'off' ) {
		$custom_cursor = uncode_check_for_custom_cursor();
	}

	if ( ( $custom_cursor !== '' && $custom_cursor !== 'off' ) || ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) ) {

		$custom_cursor .= $link_only === 'on' ? ' link-only' : '';

		?>

		<div id="uncode-custom-cursor" class="<?php echo esc_attr($custom_cursor); ?>" data-cursor="" data-skin="light"><span></span><span></span></div>
		<div id="uncode-custom-cursor-pilot" class="<?php echo esc_attr($custom_cursor); ?>" data-cursor="" data-skin="light"><span></span><span></span></div>
		<script type="text/javascript">UNCODE.initCursor();</script>

<?php }
}
endif; //uncode_custom_cursor
add_action( 'before', 'uncode_custom_cursor' );
