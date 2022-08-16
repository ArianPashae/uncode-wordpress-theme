<?php
/**
 * Yith Wishlist support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if Yith Wishlist is active
if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}

if ( ! class_exists( 'Uncode_Wishlist' ) ) :

/**
 * Uncode_Wishlist Class
 */
class Uncode_Wishlist {

	/**
	 * Construct.
	 */
	public function __construct() {
		// Remove options
		add_filter( 'yith_wcwl_settings_options', array( $this, 'remove_general_options' ) );
		add_filter( 'yith_wcwl_add_to_wishlist_options', array( $this, 'remove_wishlist_options' ) );
		add_filter( 'yith_wcwl_wishlist_page_options', array( $this, 'remove_wishlist_page_options' ) );
		add_filter( 'yith_wcwl_ask_an_estimate_options', array( $this, 'ask_an_estimate_options' ) );

		// Remove default loop action (we use the custom module to print the button)
		add_filter( 'yith_wcwl_show_add_to_wishlist', '__return_false' );

		// Add wishlist button to loops
		add_action( 'uncode_entry_visual_after_image', array( $this, 'add_wishlist_button_loop' ), 11, 3 );

		// Remove default icon (we'll use CSS)
		add_filter( 'yith_wcwl_add_to_wishlist_icon_html', array( $this, 'remove_wishlist_icon' ) );

		// Disable notices
		add_filter( 'yith_wcwl_localize_script', array( $this, 'disable_notices' ) );

		// Unqueue default CSS and load a custom one
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 99 );

		// Actions column add to cart
		add_filter( 'yith_wcwl_wishlist_view_cart_heading', array( $this, 'column_add_to_cart_heading' ) );

		// Run actions before/after wishlist table
		add_action( 'yith_wcwl_wishlist_before_wishlist_content', array( $this, 'before_wishlist_content' ) );
		add_action( 'yith_wcwl_wishlist_after_wishlist_content', array( $this, 'after_wishlist_content' ) );

		// Filter wishlist title
		add_filter( 'yith_wcwl_wishlist_title', array( $this, 'change_wishlist_title' ) );

		// Load prettyphoto when Wishlist premium is installed
		if ( defined( 'YITH_WCWL_PREMIUM_INIT' ) ) {
			add_filter( 'uncode_dequeue_prettyphoto', '__return_false' );

			add_action( 'wp_footer', array( $this, 'add_skin_to_popups' ) );
		}

		// Save default options when installing the plugin
		add_action( 'yith_wcwl_installed', array( $this, 'after_install' ) );

		// Get wishlist count via AJAX
		add_action( 'wp_ajax_get_wishlist_count_ajax', array( $this, 'get_wishlist_count' ) );
		add_action( 'wp_ajax_nopriv_get_wishlist_count_ajax', array( $this, 'get_wishlist_count' ) );

		// Add wishlist element to the Posts Module
		add_filter( 'uncode_sorted_list_product_options', array( $this, 'add_to_post_module' ), 99 );

		// Disable mobile views
		add_filter( 'yith_wcwl_is_wishlist_responsive', '__return_false' );
	}

	/**
	 * Remove options in General tab.
	 */
	public function remove_general_options( $options ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			if ( isset( $options['settings'] ) ) {
				unset( $options['settings']['enable_add_to_wishlist_tooltip'] );
				unset( $options['settings']['add_to_wishlist_tooltip_style'] );
			}
		}

		return $options;
	}


	/**
	 * Remove options in Add to Wishlist tab.
	 */
	public function remove_wishlist_options( $options ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			if ( isset( $options['add_to_wishlist'] ) ) {
				unset( $options['add_to_wishlist']['loop_position'] );
				unset( $options['add_to_wishlist']['add_to_wishlist_position'] );
				unset( $options['add_to_wishlist']['style_section_start'] );
				unset( $options['add_to_wishlist']['use_buttons'] );
				unset( $options['add_to_wishlist']['add_to_wishlist_colors'] );
				unset( $options['add_to_wishlist']['rounded_buttons_radius'] );
				unset( $options['add_to_wishlist']['add_to_wishlist_icon'] );
				unset( $options['add_to_wishlist']['add_to_wishlist_custom_icon'] );
				unset( $options['add_to_wishlist']['added_to_wishlist_icon'] );
				unset( $options['add_to_wishlist']['added_to_wishlist_custom_icon'] );
				unset( $options['add_to_wishlist']['custom_css'] );
				unset( $options['add_to_wishlist']['style_section_end'] );
				unset( $options['add_to_wishlist']['already_in_wishlist_text'] );

				if ( isset( $options['add_to_wishlist']['enable_add_to_wishlist_modal'] ) && isset( $options['add_to_wishlist']['enable_add_to_wishlist_modal']['options'] ) ) {
					unset( $options['add_to_wishlist']['enable_add_to_wishlist_modal']['options']['no'] );
				}

				if ( isset( $options['add_to_wishlist']['after_add_to_wishlist_behaviour'] ) && isset( $options['add_to_wishlist']['after_add_to_wishlist_behaviour']['options'] ) ) {
					unset( $options['add_to_wishlist']['after_add_to_wishlist_behaviour']['options']['modal'] );
				}

				$new_options = array();

				foreach ( $options['add_to_wishlist'] as $key => $value ) {
					$new_options[$key] = $value;

					if ( $key === 'product_page_section_start' ) {
						$new_options['show_on_product_page'] = array(
							'name'      => __( 'Show "Add to wishlist" in single product', 'uncode' ),
							'desc'      => __( 'Enable the "Add to wishlist" feature in single product pages when using the default template', 'uncode' ),
							'id'        => 'uncode_yith_wcwl_show_on_single_product',
							'default'   => 'no',
							'type'      => 'yith-field',
							'yith-type' => 'onoff'
						);
					}
				}

				$options['add_to_wishlist'] = $new_options;
			}
		}

		return $options;
	}

	/**
	 * Remove options in Wishlist Page tab.
	 */
	public function remove_wishlist_page_options( $options ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			if ( isset( $options['wishlist_page'] ) ) {
				unset( $options['wishlist_page']['style_section_start'] );
				unset( $options['wishlist_page']['use_buttons'] );
				unset( $options['wishlist_page']['add_to_cart_colors'] );
				unset( $options['wishlist_page']['rounded_buttons_radius'] );
				unset( $options['wishlist_page']['add_to_cart_icon'] );
				unset( $options['wishlist_page']['add_to_cart_custom_icon'] );
				unset( $options['wishlist_page']['style_1_button_colors'] );
				unset( $options['wishlist_page']['style_2_button_colors'] );
				unset( $options['wishlist_page']['wishlist_table_style'] );
				unset( $options['wishlist_page']['headings_style'] );
				unset( $options['wishlist_page']['share_colors'] );
				unset( $options['wishlist_page']['fb_button_icon'] );
				unset( $options['wishlist_page']['fb_button_custom_icon'] );
				unset( $options['wishlist_page']['fb_button_colors'] );
				unset( $options['wishlist_page']['tw_button_icon'] );
				unset( $options['wishlist_page']['tw_button_custom_icon'] );
				unset( $options['wishlist_page']['tw_button_colors'] );
				unset( $options['wishlist_page']['pr_button_icon'] );
				unset( $options['wishlist_page']['pr_button_custom_icon'] );
				unset( $options['wishlist_page']['pr_button_colors'] );
				unset( $options['wishlist_page']['em_button_icon'] );
				unset( $options['wishlist_page']['em_button_custom_icon'] );
				unset( $options['wishlist_page']['em_button_colors'] );
				unset( $options['wishlist_page']['wa_button_icon'] );
				unset( $options['wishlist_page']['wa_button_custom_icon'] );
				unset( $options['wishlist_page']['wa_button_colors'] );
				unset( $options['wishlist_page']['style_section_end'] );
				unset( $options['wishlist_page']['enable_wishlist_share'] );
				unset( $options['wishlist_page']['share_on_facebook'] );
				unset( $options['wishlist_page']['share_on_twitter'] );
				unset( $options['wishlist_page']['share_on_pinterest'] );
				unset( $options['wishlist_page']['share_by_email'] );
				unset( $options['wishlist_page']['share_by_whatsapp'] );
				unset( $options['wishlist_page']['share_by_url'] );
				unset( $options['wishlist_page']['socials_title'] );
				unset( $options['wishlist_page']['socials_text'] );
				unset( $options['wishlist_page']['socials_image'] );
				unset( $options['wishlist_page']['repeat_remove_button'] );
				unset( $options['wishlist_page']['show_manage_rename_wishlist'] );
				unset( $options['wishlist_page']['wishlist_layout'] );
				unset( $options['wishlist_page']['move_to_another_wishlist_type'] );
				unset( $options['wishlist_page']['wishlist_manage_layout'] );
			}
		}

		return $options;
	}

	/**
	 * Remove options in Ask for an estimate tab.
	 */
	public function ask_an_estimate_options( $options ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			if ( isset( $options['ask_an_estimate'] ) ) {
				unset( $options['ask_an_estimate']['style_section_start'] );
				unset( $options['ask_an_estimate']['use_buttons'] );
				unset( $options['ask_an_estimate']['ask_an_estimate_colors'] );
				unset( $options['ask_an_estimate']['rounded_buttons_radius'] );
				unset( $options['ask_an_estimate']['ask_an_estimate_icon'] );
				unset( $options['ask_an_estimate']['ask_an_estimate_custom_icon'] );
				unset( $options['ask_an_estimate']['style_section_end'] );
			}
		}

		return $options;
	}

	/**
	 * Add wishlist button to the default WC loop
	 */
	public function add_wishlist_button_loop( $block_data, $layout, $is_default_product_content ) {
		if ( $is_default_product_content && get_option( 'yith_wcwl_show_on_loop', 'no' ) === 'yes' || isset( $layout['wishlist-button'] ) ) {
			echo '<div class="add-to-wishlist-overlay icon-badge">' . do_shortcode( "[yith_wcwl_add_to_wishlist]" ) . '</div>';
		}
	}

	/**
	 * Remove wishlist icon.
	 */
	public function remove_wishlist_icon( $icon_html ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			return '';
		}

		return $icon_html;
	}

	/**
	 * Disable notices.
	 */
	public function disable_notices( $yith_wcwl_l10n ) {
		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) && ! defined( 'YITH_WCWL_PREMIUM_INIT' ) ) {
			$yith_wcwl_l10n['enable_notices'] = false;
		}

		return $yith_wcwl_l10n;
	}

	/**
	 * Unqueue default CSS and load a custom one
	 */
	public function add_scripts() {
		$scripts_prod_conf = uncode_get_scripts_production_conf();
		$resources_version = isset( $scripts_prod_conf[ 'resources_version' ] ) ? $scripts_prod_conf[ 'resources_version' ] : rand();
		$suffix            = isset( $scripts_prod_conf[ 'suffix' ] ) ? $scripts_prod_conf[ 'suffix' ] : '';
		$folder            = isset( $scripts_prod_conf[ 'folder' ] ) ? $scripts_prod_conf[ 'folder' ] : '';

		if ( apply_filters( 'uncode_use_custom_yith_wishlist', true ) ) {
			wp_deregister_style( 'yith-wcwl-main' );
		}

		wp_enqueue_style( 'uncode-wishlist', get_template_directory_uri() . '/library/css/wishlist.css', array() , $resources_version, 'all');

		wp_enqueue_script( 'uncode-woocommerce-wishlist', get_template_directory_uri() . '/library/js/' . $folder . 'woocommerce-wishlist' . $suffix . '.js', array( 'jquery' ) , $resources_version, true );
	}

	/**
	 * Add column name
	 */
	public function column_add_to_cart_heading() {
		return esc_html__( 'Actions', 'uncode' );
	}

	/**
	 * Run custom actions before wishlist table
	 */
	public function before_wishlist_content() {
		add_filter( 'woocommerce_loop_add_to_cart_args', 'uncode_filter_add_to_cart_button_args' );

		if ( function_exists( 'uncode_core_unhook' ) ) {
			uncode_core_unhook( 'woocommerce_get_price_html', 'uncode_price_html', 10, 2 );
		}
	}

	/**
	 * Run custom actions after wishlist table
	 */
	public function after_wishlist_content() {
		if ( function_exists( 'uncode_core_unhook' ) ) {
			uncode_core_unhook( 'woocommerce_loop_add_to_cart_args', 'uncode_filter_add_to_cart_button_args' );
		}

		add_filter( 'woocommerce_get_price_html', 'uncode_price_html', 10, 2 );
	}

	/**
	 * Add class to wishlist title
	 */
	public function change_wishlist_title( $html ) {
		$html = str_replace( '<h2>', '<h2 class="h3">', $html );

		return $html;
	}

	/**
	 * Add light skin to popups
	 */
	public function add_skin_to_popups() {
		$script = '<script>jQuery(function($){$(".yith-wcwl-popup-content").addClass("style-light");$(".yith-wcwl-popup-footer").find(".button,.popup_button").addClass("btn btn-default");});</script>';

		echo uncode_switch_stock_string( $script );
	}

	/**
	 * Save default options when installing the plugin
	 */
	public function after_install() {
		update_option( 'yith_wcwl_add_to_wishlist_style', 'link' );
		update_option( 'yith_wcwl_wishlist_manage_layout', 'traditional' );
		update_option( 'yith_wcwl_wishlist_layout', 'traditional' );
		update_option( 'yith_wcwl_move_to_another_wishlist_type', 'popup' );
		update_option( 'yith_wcwl_custom_css', false );
		update_option( 'yith_wcwl_enable_share', 'no' );
		update_option( 'yith_wcwl_add_to_cart_style', 'link' );
		update_option( 'yith_wcwl_ask_an_estimate_style', 'button_default' );
		update_option( 'yith_wcwl_tooltip_enable', 'no' );
		// update_option( 'yith_wcwl_repeat_remove_button', 'no' );
		// update_option( 'yith_wcwl_after_add_to_wishlist_behaviour', 'view' );
		// update_option( 'yith_wcwl_show_on_loop', 'yes' );
		// update_option( 'uncode_yith_wcwl_show_on_single_product', 'yes' );
	}

	/**
	 * Get wishlist count
	 */
	public function get_wishlist_count() {
		$count = absint( yith_wcwl_count_all_products() );

		echo json_encode( array( 'count' => $count ) );

		die();
	}

	/**
	 * Add wishlist element to the Posts Module
	 */
	public function add_to_post_module( $options ) {
		if ( isset( $options[ 'options' ] ) ) {
			$options[ 'options' ][] = array( 'wishlist-button', esc_html__('Wishlist', 'uncode') );
		}

		return $options;
	}
}

endif;

return new Uncode_Wishlist();
