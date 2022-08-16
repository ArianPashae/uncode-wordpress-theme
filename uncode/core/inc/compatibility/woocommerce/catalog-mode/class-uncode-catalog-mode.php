<?php
/**
 * Catalog Mode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Uncode_Catalog_Mode' ) ) :

/**
 * Uncode_Catalog_Mode Class
 */
class Uncode_Catalog_Mode {
	/**
	 * Construct.
	 */
	public function __construct() {
		if ( $this->is_catalog_mode_active() && ( ! is_admin() || $this->is_quick_view() ) ) {
			// Hide cart icon from menu
			add_filter( 'uncode_woo_cart', '__return_false' );

			// Hide sidecart
			add_filter( 'woocommerce_sidecart_enabled', '__return_false' );

			// Hide excluded pages from menu
			add_filter( 'get_pages', array( $this, 'hide_cart_checkout_pages' ) );
			add_filter( 'wp_get_nav_menu_items', array( $this, 'hide_cart_checkout_pages' ) );
			add_filter( 'wp_nav_menu_objects', array( $this, 'hide_cart_checkout_pages' ) );

			// When visiting an excluded page, redirect the user to the home
			add_action( 'template_redirect', array( $this, 'check_pages_redirect' ) );

			// Avoid add to cart
			add_filter( 'woocommerce_add_to_cart_validation', '__return_false' );

			// Hide add to cart in shop pages and post modules
			add_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );

			// Hide add to cart in single product pages
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

			// Hide add to cart when using a custom VC Button
			add_filter( 'uncode_hide_vc_button', '__return_true' );

			// Hide cart widget
			add_filter( 'woocommerce_widget_cart_is_hidden', '__return_true' );
		}
	}

	/**
	 * Check if catalog mode is activated
	 */
	public function is_catalog_mode_active() {
		$is_active = ot_get_option( '_uncode_woocommerce_catalog_mode' ) === 'on' ? true : false;

		return $is_active && $this->is_catalog_mode_active_for_current_user();
	}

	/**
	 * Check if catalog mode is activated for the current user
	 */
	public function is_catalog_mode_active_for_current_user() {
		$is_active_for_current_user = true;

		if ( ( current_user_can( 'administrator' ) ) && is_user_logged_in() && ot_get_option( '_uncode_woocommerce_catalog_mode_disabled_for_admins' ) === 'off' ) {
			$is_active_for_current_user = false;
		}

		return $is_active_for_current_user;
	}

	/**
	 * Check if it is a quick view action
	 */
	public function is_quick_view() {
		return uncode_is_quick_view();
	}

	/**
	 * Get the IDs of custom pages we need to exclude (in this way,
	 * we can exclude cart/checkout pages created with the page builder
	 * that are not selected in Woo's settings - because with Uncode we
	 * can have multiple cart/checkout pages)
	 */
	public function get_pages_to_exclude() {
		$excluded_pages = apply_filters(
			'uncode_catalog_mode_pages_to_exclude',
			array(
				wc_get_page_id( 'cart' ),
				wc_get_page_id( 'checkout' ),
			)
		);

		return $excluded_pages;
	}

	/**
	 * Redirect cart and checkout pages (custom modules included)
	 */
	public function check_pages_redirect() {
		$excluded_pages = $this->get_pages_to_exclude();

		if ( is_array( $excluded_pages ) && count( $excluded_pages ) > 0 ) {
			foreach ( $excluded_pages as $excluded_page_id ) {
				if ( is_page( $excluded_page_id ) ) {
					wp_reset_query();
					wp_redirect( home_url() );
					exit;
				}
			}
		}
	}

	/**
	 * Removes cart and checkout pages from menu
	 */
	public function hide_cart_checkout_pages( $pages ) {
		$excluded_pages = $this->get_pages_to_exclude();

		if ( is_array( $excluded_pages ) && count( $excluded_pages ) > 0 ) {
			foreach ( $pages as $key => $page ) {
				$page_id = ( in_array( current_filter(), array( 'wp_get_nav_menu_items', 'wp_nav_menu_objects' ), true ) ? $page->object_id : $page->ID );

				if ( in_array( (int) $page_id, $excluded_pages, true ) ) {
					unset( $pages[ $key ] );
				}
			}
		}

		return $pages;
	}
}

endif;

return new Uncode_Catalog_Mode();
