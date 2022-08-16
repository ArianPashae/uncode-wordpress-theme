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

if ( ! class_exists( 'Uncode_Quick_View' ) ) :

/**
 * Uncode_Quick_View Class
 */
class Uncode_Quick_View {

	private $print_modal = false;

	private $fake_singular_product_run = false;

	private $post;

	/**
	 * Construct.
	 */
	public function __construct() {
		// Add quick view button to loops
		add_action( 'uncode_entry_visual_after_image', array( $this, 'add_quick_view_button_loop' ), 1, 3 );

		// Load quick view via AJAX
		add_action( 'wp_ajax_uncode_load_ajax_quick_view', array( $this, 'load_quick_view' ) );
		add_action( 'wp_ajax_nopriv_uncode_load_ajax_quick_view', array( $this, 'load_quick_view' ) );

		// Get quick view content
		add_action( 'uncode_quick_view_content', array( $this, 'get_content_block_content' ), 10 );

		// Append quick view markup in footer
		add_action( 'uncode_after_page_footer', array( $this, 'append_modal_markup' ) );

		// Add quick view element to the Posts Module
		add_filter( 'uncode_sorted_list_product_options', array( $this, 'add_to_post_module' ), 99 );

		// Hide QW meta boxes by default
		add_filter( 'default_hidden_meta_boxes', array( $this, 'hide_meta_boxes' ), 10, 2 );

		// Disable lazy load in QW
		add_action( 'uncode_woocommerce_before_quick_view', array( $this, 'before_quick_view' ) );
	}

	/**
	 * Load WC scripts
	 */
	public function add_scripts() {
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}

			wp_enqueue_script( 'wc-single-product' );
		}

		do_action( 'uncode_quick_view_custom_style_scripts' );
	}

	/**
	 * Check if Quick View is enabled
	 */
	public function is_enabled() {
		$is_enabled = ot_get_option( '_uncode_product_index_quick_view' );
		$is_enabled = $is_enabled === 'on' ? true : false;

		return $is_enabled;
	}

	/**
	 * Get quick view content block ID
	 */
	public function get_quick_view_content_block_id( $post_type = 'product' ) {
		$content_block_id = apply_filters( 'uncode_get_' . $post_type . '_quick_view_content_block_id', ot_get_option( '_uncode_' . $post_type . '_index_quick_view_content_block' ) );
		$content_block_id = absint( apply_filters( 'wpml_object_id', $content_block_id, 'product', true ) );

		return $content_block_id ? $content_block_id : false;
	}

	/**
	 * Add quick view button to the default WC loop
	 */
	public function add_quick_view_button_loop( $block_data, $layout, $is_default_product_content ) {
		$products_archive_content_block = ot_get_option('_uncode_product_index_content_block');
		$quick_view_content_type        = ot_get_option('_uncode_product_index_quick_view_type');
		$quick_view_content_type        = $quick_view_content_type === 'uncodeblock' ? 'uncodeblock' : 'default';

		remove_action( 'uncode_entry_visual_after_image', array( $this, 'print_quick_view_button' ), 10, 2 );
		remove_action( 'uncode_entry_visual_after_image', array( $this, 'print_quick_view_button' ), 11, 2 );

		if ( $this->is_enabled() ) {
			global $post;

			$post_id = isset( $block_data['id'] ) ? absint( $block_data['id'] ) : false;

			if ( ! $post_id ) {
				if ( isset( $post->ID ) ) {
					$post_id = $post->ID;
				} else {
					return;
				}
			}

			if ( ! apply_filters( 'uncode_show_quick_view_button', true, $post_id ) ) {
				return;
			}

			// Return early if the quick view type is a
			// content block  but there isn't one selected
			if ( $quick_view_content_type === 'uncodeblock' && ! ( $this->get_quick_view_content_block_id() > 0 ) ) {
				return;
			}

			$is_shop_archive = ! $products_archive_content_block && ( is_shop() || is_product_category() || is_product_tag() ) ? true : false;

			if ( ( $is_shop_archive ) || isset( $layout['quick-view-button'] ) ) {
				if ( ! $is_shop_archive ) {
					foreach ( $layout as $key => $value ) {
						if ( $key === 'wishlist-button' ) {
							$prior = 11;
							break;
						}
						if ( $key === 'quick-view-button' ) {
							$prior = 10;
							break;
						}
					}

					if ( isset( $prior ) ) {
						// Add quick view button to loops at the right moment
						add_action( 'uncode_entry_visual_after_image', array( $this, 'print_quick_view_button' ), $prior, 2 );
					}
				} else {
					if ( $is_default_product_content ) {
						// Default shop archive, no custom order
						add_action( 'uncode_entry_visual_after_image', array( $this, 'print_quick_view_button' ), 10, 2 );
					}
				}
			}
		}
	}

	/**
	 * Print quick view button
	 */
	public function print_quick_view_button( $block_data, $layout ) {
		global $post;

		$post_id = isset( $block_data['id'] ) ? absint( $block_data['id'] ) : false;

		if ( ! $post_id ) {
			$post_id = $post->ID;
		}

		$post_type = get_post_type( $post_id );
		$label     = __( 'Quick-View', 'uncode' );

		$this->print_modal = true;
		echo '<div class="quick-view-button-overlay icon-badge"><a href="#" class="open-unmodal quick-view-button" data-post-type="' . esc_attr( $post_type ) . '" data-post-id="' . esc_attr( $post_id ) . '">' . esc_html( $label ) . '</a></div>';
	}

	/**
	 * Load quick view via AJAX
	 */
	public function load_quick_view() {
		if ( isset( $_POST['post_id'] ) && isset( $_POST['post_type'] ) ) {
			$post_id   = absint( $_POST['post_id'] );
			$post_type = $_POST['post_type'];

			if ( ! $post_id ) {
				// Invalid post ID
				wp_send_json_error(
					array(
						'error' => esc_html__( 'Ivalid post ID', 'uncode' )
					)
				);
			}

			ob_start();

			$args = array(
				'post_type' => $post_type,
				'p'         => $post_id,
			);

			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					global $post;

					echo '<div id="' . $post_type . '-' . get_the_ID(). '" class="' . esc_attr( implode( " ", get_post_class( $post_type ) ) ) . '">';
					do_action( 'uncode_quick_view_content', $post );
					echo '</div>';
				}
			}

			$html = ob_get_clean();

			if ( ! $html ) {
				// No HTML
				wp_send_json_error(
					array(
						'error' => esc_html__( 'Ivalid HTML data', 'uncode' )
					)
				);
			} else {
				// Success
				wp_send_json_success(
					array(
						'html' => $html
					)
				);
			}
		} else {
			// Invalid data
			wp_send_json_error(
				array(
					'error' => esc_html__( 'Ivalid data', 'uncode' )
				)
			);
		}
	}

	/**
	 * Get default single product hooks
	 */
	public function get_single_product_hooks() {
		$hooks = apply_filters( 'uncode_quick_view_woocommerce_single_product_hooks',
			array(
				'woocommerce_before_single_product',
				'woocommerce_before_single_product_summary',
				'woocommerce_after_single_product_summary',
				'woocommerce_after_single_product',
			)
		);

		return $hooks;
	}

	/**
	 * Show quick view content
	 */
	public function get_content_block_content( $post ) {
		$this->post = $post;
		$post_id    = $post->ID;

		do_action( 'uncode_woocommerce_before_quick_view' );

		$woocommerce_single_product_hooks_enabled = ot_get_option('_uncode_product_index_quick_view_hooks') === 'on' ? true : false;

		if ( $woocommerce_single_product_hooks_enabled && $this->get_single_product_hooks() && is_array( $this->get_single_product_hooks() ) ) {
			if ( in_array( 'woocommerce_before_single_product', $this->get_single_product_hooks() ) ) {
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
				do_action( 'woocommerce_before_single_product' );
			}

			if ( in_array( 'woocommerce_before_single_product_summary', $this->get_single_product_hooks() ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				do_action( 'woocommerce_before_single_product_summary' );
			}
		}

		if ( $post_id ) {
			if ( ot_get_option('_uncode_product_index_quick_view_type') === 'uncodeblock' ) {
				$content_block_id = $this->get_quick_view_content_block_id();

				if ( $content_block_id > 0 ) {
					// Set global $is_cb to true
					global $is_cb;
					$is_cb = true;

					do_action( 'uncode_woocommerce_before_custom_quick_view' );
					$this->run_before_show_content_block();
					$content_block_content = get_post_field( 'post_content', $content_block_id );

					// We need this to map VC shortcodes in AJAX
					WPBMap::addAllMappedShortcodes();

					echo uncode_remove_p_tag( apply_filters( 'the_content', $content_block_content ) );
					$this->run_after_show_content_block();
					do_action( 'uncode_woocommerce_after_custom_quick_view' );

					// Re-set global $is_cb to false
					$is_cb = false;
				}
			} else {

				$this->run_default_hooks();

				?>
				<div class="quick-view-default-content">
					<?php echo uncode_open_row( array( 'col-std-gutter', 'single-top-padding', 'single-bottom-padding', 'limit-width' ) ); ?>
						<?php echo uncode_open_col( array( 'col-lg-6' ) ); ?>
							<div class="woocommerce-product-gallery">
								<?php do_action( 'uncode_quick_view_product_image' ); ?>
							</div>
						<?php echo uncode_close_col(); ?>
						<?php echo uncode_open_col( array( 'col-lg-6' ) ); ?>
							<div class="summary entry-summary">
								<div class="summary-content">
									<?php do_action( 'uncode_quick_view_product_content' ); ?>
								</div>
							</div>
						<?php echo uncode_close_col(); ?>
					<?php echo uncode_close_row(); ?>
				</div>
				<?php
			}
		}

		if ( $woocommerce_single_product_hooks_enabled && $this->get_single_product_hooks() && is_array( $this->get_single_product_hooks() ) ) {
			if ( in_array( 'woocommerce_after_single_product_summary', $this->get_single_product_hooks() ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
				do_action( 'woocommerce_after_single_product_summary' );
			}

			if ( in_array( 'woocommerce_after_single_product', $this->get_single_product_hooks() ) ) {
				do_action( 'woocommerce_after_single_product' );
			}
		}

		do_action( 'uncode_woocommerce_after_quick_view' );
	}

	/**
	 * Append quick view markup in footer
	 */
	public function append_modal_markup() {
		if ( $this->print_modal ) {
			if ( ot_get_option('_uncode_product_index_quick_view_type') === 'uncodeblock' ) {
				$content_block_size = $this->get_content_block_size( $this->get_quick_view_content_block_id() );
			} else {
				$content_block_size = array();
			}

			$this->add_scripts();

			$modal_class = apply_filters( 'uncode_quick_view_container_class', array( 'quick-view-container', 'style-light', 'woocommerce' ) );

			echo uncode_modal_get_wrapper_markup( $content_block_size, $modal_class, array( 'quick-view-content-wrapper' ) );
		}
	}

	/**
	 * Add quick view element to the Posts Module
	 */
	public function add_to_post_module( $options ) {
		if ( $this->is_enabled() && isset( $options['options'] ) ) {
			$options['options'][] = array( 'quick-view-button', esc_html__( 'Quick-View', 'uncode' ) );
		}

		return $options;
	}

	/**
	 * Get content block size
	 */
	public function get_content_block_size( $content_block_id = false ) {
		$sizes = array(
			'max-width'  => '1000px',
			'max-height' => '700px',
		);

		if ( $content_block_id > 0 ) {
			$width_inherit = get_post_meta( $content_block_id, '_uncode_specific_modal_width_inherit', true );

			if ( $width_inherit === 'custom' ) {
				$width = get_post_meta( $content_block_id, '_uncode_specific_modal_width', true );
				$width = $this->calculate_size( $width );

				if ( $width ) {
					$sizes['max-width'] = $width;
				}
			}

			$height_inherit = get_post_meta( $content_block_id, '_uncode_specific_modal_height_inherit', true );

			if ( $height_inherit === 'custom' ) {
				$height = get_post_meta( $content_block_id, '_uncode_specific_modal_height', true );
				$height = $this->calculate_size( $height );

				if ( $height ) {
					$sizes['max-height'] = $height;
				}
			} else if ( $height_inherit === 'auto' ) {
				$sizes['max-height'] = 'none';
				$sizes['height']     = 'auto';
			}
		}

		return $sizes;
	}

	/**
	 * Calculate correct size with some validation
	 */
	public function calculate_size( $size ) {
		$validated_size = false;

		if ( is_array( $size ) && isset( $size[0] ) && $size[0] ) {
			$value = absint( $size[0] );
			$unit  = isset( $size[1] ) && $size[1] === '%' ? '%' : 'px';

			if ( $unit === '%' && $value > 100 ) {
				$value = '100';
			} else if ( $unit === 'px' ) {
				$value += 72;
			}

			$validated_size = $value . $unit;
		}

		return $validated_size;
	}

	/**
	 * When using the default template, run some hooks
	 * to print the product details
	 */
	public function run_default_hooks() {
		add_filter( 'uncode_woocommerce_show_product_thumbnails', '__return_false' );
		add_action( 'uncode_quick_view_product_image', 'woocommerce_show_product_images' );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_title', 5 );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_rating', 10 );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_price', 15 );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_add_to_cart', 25 );
		add_action( 'uncode_quick_view_product_content', 'woocommerce_template_single_meta', 30 );
		add_action( 'uncode_quick_view_product_content', 'uncode_add_wishlist_button_to_single_product', 27 );
		add_filter( 'uncode_woocommerce_get_reviews_anchor_link', array( $this, 'get_reviews_anchor_link' ) );
		add_filter( 'uncode_woocommerce_show_product_thumbnails', '__return_true' );
	}

	/**
	 * Run hooks before showing the QW content block
	 */
	public function run_before_show_content_block() {
		if ( apply_filters( 'uncode_woocommerce_run_fake_singular_product_check', true ) && $this->fake_singular_product_run === false ) {
			global $wp_query;

			$wp_query->is_singular = true;
			$wp_query->queried_object = (object) array( 'post_type' => 'product' );

			$this->fake_singular_product_run = true;
		}

		$quick_view_content_type = ot_get_option('_uncode_product_index_quick_view_type');
		$quick_view_content_type = $quick_view_content_type === 'uncodeblock' ? 'uncodeblock' : 'default';

		if ( $quick_view_content_type === 'uncodeblock' && ( $this->get_quick_view_content_block_id() > 0 ) ) {
			$object_cb = get_post($this->get_quick_view_content_block_id());
			if ( is_object($object_cb) ) {
				$content_cb = $object_cb->post_content;
				uncode_woocommerce_remove_product_summary_hooks( $content_cb );
			}
		}

		add_filter( 'uncode_woocommerce_get_reviews_anchor_link', array( $this, 'get_reviews_anchor_link' ) );
		add_filter( 'uncode_share_button_url', array( $this, 'get_share_url' ) );
	}

	/**
	 * Run hooks after showing the QW content block
	 */
	public function run_after_show_content_block() {
		if ( function_exists( 'uncode_core_unhook' ) ) {
			uncode_core_unhook( 'uncode_woocommerce_get_reviews_anchor_link', array( $this, 'get_reviews_anchor_link' ) );
			uncode_core_unhook( 'uncode_share_button_url', array( $this, 'get_share_url' ) );
		}
	}

	/**
	 * Get share URL
	 */
	public function get_share_url() {
		$url = $this->get_post_url();

		return $url;
	}

	/**
	 * Change reviews link to point it to the
	 * single product page
	 */
	public function get_reviews_anchor_link() {
		$url = $this->get_post_url() . '#reviews';

		return $url;
	}

	/**
	 * Get post URL
	 */
	public function get_post_url() {
		return get_permalink( $this->post );
	}

	/**
	 * Hide meta box by default
	 */
	function hide_meta_boxes( $hidden, $screen ) {
		if ( 'uncodeblock' == $screen->post_type ) {
			$hidden[] = '_uncode_modal_settings';
		}

		return $hidden;
	}

	/**
	 * Run hooks before to show the QW
	 */
	function before_quick_view() {
		add_filter( 'wp_lazy_loading_enabled', '__return_false', 999 );
	}
}
endif;

return new Uncode_Quick_View();
