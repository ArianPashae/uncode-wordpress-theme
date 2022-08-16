<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package uncode
 */

$metabox_data = get_post_custom($post->ID);
$sidebar = (isset($metabox_data['_uncode_page_sidebar'][0])) ? 'uncode-' . $metabox_data['_uncode_page_sidebar'][0] : 'sidebar-1';
$mobile_collapse = (isset($metabox_data['_uncode_sidebar_widget_collapse'][0])) ? 'uncode-' . $metabox_data['_uncode_sidebar_widget_collapse'][0] : '';

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}

?>

<div id="secondary" class="widget-area <?php echo esc_attr( $mobile_collapse ? 'widget-mobile-collapse' : '' ); ?>" role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</div><!-- #secondary -->
