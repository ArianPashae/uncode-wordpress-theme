<?php
/**
 * Custom Woocommerce settings
 *
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Uncode_WooCommerce_Settings' ) ) :

/**
 * Uncode_WooCommerce_Settings Class
 */
class Uncode_WooCommerce_Settings {
	/**
	 * Constructor.
	 */
	public function __construct() {
		// Add WooCommerce settings
		add_filter( 'woocommerce_settings_pages', array( $this, 'wc_pages' ) );

		// Admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Add WooCommerce pages for thankyou, etc.
	 */
	public function wc_pages( $settings ) {
		$new_settings = array(
			array(
				'title' => __( 'Custom templates', 'uncode' ),
				'desc'  => __( 'These optional pages ovverride the default WooCommerce templates, allowing you to create advanced layouts.', 'woocommerce' ),
				'type'  => 'title',
				'id'    => 'uncode_wc_page_templates',
			),

			array(
				'title'    => __( 'Empty cart', 'uncode' ),
				'id'       => 'uncode_woocommerce_empty_cart_page_id',
				'type'     => 'select',
				'default'  => '',
				'options'  => $this->get_pages()
			),

			array(
				'title'    => __( 'Account login', 'uncode' ),
				'id'       => 'uncode_woocommerce_my_account_login_page_id',
				'type'     => 'select',
				'default'  => '',
				'options'  => $this->get_pages()
			),

			array(
				'type' => 'sectionend',
				'id'   => 'uncode_wc_page_templates',
			),
		);

		return array_merge( $settings, $new_settings );
	}

	/**
	 * Get all pages
	 */
	public function get_pages() {
		$pages = array( '' => '' );

		$pages_query = new WP_Query( 'post_type=page&posts_per_page=-1&post_status=publish&orderby=title&order=ASC' );

		foreach ( $pages_query->posts as $page ) {
			$pages[ $page->ID ] = $page->post_title;
		}

		return $pages;
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';
		$wc_screen_id = sanitize_title( __( 'WooCommerce', 'woocommerce' ) );

		// System status.
		if ( $wc_screen_id . '_page_wc-status' === $screen_id ) {
			wp_register_script( 'uncode-wc-system-status', get_template_directory_uri() . '/core/assets/js/min/uncode-wc-system-status.min.js', array( 'jquery' ), UNCODE_VERSION, true );
			wp_enqueue_script( 'uncode-wc-system-status' );
			wp_localize_script(
				'uncode-wc-system-status',
				'uncode_woocommerce_system_status',
				array(
					'cart_page_shortcode'      => $this->check_shortcode( 'woocommerce_cart_page_id', '[uncode_woocommerce_cart' ),
					'checkout_page_shortcode'  => $this->check_shortcode( 'woocommerce_checkout_page_id', '[uncode_woocommerce_checkout' ),
					'myaccount_page_shortcode' => $this->check_shortcode( 'woocommerce_myaccount_page_id', '[uncode_woocommerce_my_account' ),
				)
			);
		}
	}

	/**
	 * Check if a WC shortcode is present.
	 */
	private function check_shortcode( $option, $shortcode ) {
		$found = array(
			'found' => false,
			'mark'  => '',
		);

		$shortcode_present = false;
		$page_id           = get_option( $option );
		$page              = get_post( $page_id );

		if ( strstr( $page->post_content, $shortcode ) ) {
			$found = array(
				'found' => true,
				'mark'  => '#' . absint( $page_id ) . ' - ' . esc_html( str_replace( home_url(), '', get_permalink( $page_id ) ) ),
			);
		}

		return $found;
	}
}

endif;

return new Uncode_WooCommerce_Settings();
