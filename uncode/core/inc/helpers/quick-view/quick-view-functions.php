<?php
/**
 * Quick View class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Check if it is a quick view action
 */
function uncode_is_quick_view() {
	$actions = apply_filters( 'uncode_check_quick_view_actions', array( 'uncode_load_ajax_quick_view' ) );
	return defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $actions, true );
}
