<?php
/**
 * Setup post data
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Uncode_Setup_Post_Data' ) ) :

/**
 * Uncode_Setup_Post_Data Class
 */
class Uncode_Setup_Post_Data {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'template_redirect', array( $this, 'setup_data' ), 0 );
	}

	/**
	 * Inject post data.
	 */
	public function setup_data() {
		if ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
			return;
		}

		global $uncode_post_data;

		$queried_object = get_queried_object();

		$post_data = array(
			'ID'                   => 0,
			'post_type'            => '',
			'is_singular'          => false,
			'is_home'              => false,
			'is_front_page'        => false,
			'is_archive'           => false,
			'is_category'          => false,
			'is_tag'               => false,
			'is_author'            => false,
			'is_date'              => false,
			'is_post_type_archive' => false,
			'is_tax'               => false,
			'is_404'               => false,
			'is_search'            => false,
			'post_content'         => '',
			'header_cb_id'         => 0,
			'content_cb_id'        => 0,
			'footer_cb_id'         => 0,
			'after_cb_id'          => 0,
			'pre_cb_id'            => 0,
		);

		if ( is_front_page() ) {
			$post_data['is_front_page'] = true;
		}

		if ( is_a( $queried_object, 'WP_Post' ) ) {
			$post_data['ID']           = $queried_object->ID;
			$post_data['post_type']    = $queried_object->post_type;
			$post_data['post_content'] = $queried_object->post_content;
		}

		$post_data = $this->get_page_content_blocks( $queried_object, $post_data );

		$uncode_post_data = $post_data;
	}

	/**
	 * Get associated Content Block IDs.
	 */
	private function get_page_content_blocks( $queried_object, $post_data ) {
		if ( is_singular() ) {
			$post_data['is_singular'] = true;
			$metabox_data             = get_post_meta( $queried_object->ID );

			// Header
			if ( isset( $metabox_data['_uncode_header_type'][0] ) && $metabox_data['_uncode_header_type'][0] !== '' ) {
				$page_header_type = $metabox_data['_uncode_header_type'][0];

				if ( $page_header_type === 'header_uncodeblock' ) {
					if ( isset( $metabox_data['_uncode_blocks_list'][0] ) && $metabox_data['_uncode_blocks_list'][0] !== '' ) {
						$header_cb_id = $metabox_data['_uncode_blocks_list'][0];

						if ( $header_cb_id ) {
							$post_data['header_cb_id'] = absint( $header_cb_id );
						}
					}
				}
			} else {
				$header_cb_id = $this->get_header_content_block( $queried_object->post_type );
				if ( $header_cb_id ) {
					$post_data['header_cb_id'] = absint( $header_cb_id );
				}
			}

			// Footer
			if ( isset( $metabox_data['_uncode_specific_footer_block'][0] ) && $metabox_data['_uncode_specific_footer_block'][0] !== '' ) {
				$footer_block = $metabox_data['_uncode_specific_footer_block'][0];

				if ( $footer_block && $footer_block !== 'none' ) {
					$post_data['footer_cb_id'] = absint( $footer_block );
				}
			} else {
				$footer_block_id = $this->get_footer_content_block( $queried_object->post_type );
				if ( $footer_block_id ) {
					$post_data['footer_cb_id'] = absint( $footer_block_id );
				}
			}

			// Content
			$content_cb = 0;
			if ( get_post_meta( $queried_object->ID, '_uncode_specific_select_content', true ) === 'uncodeblock'
				&& get_post_meta( $queried_object->ID, '_uncode_specific_content_block', true ) !== ''
				&& get_post_meta( $queried_object->ID, '_uncode_specific_content_block', true ) !== 'none') {
				$content_cb = get_post_meta( $queried_object->ID, '_uncode_specific_content_block', true );
			} else if ( ot_get_option('_uncode_' . $queried_object->post_type . '_select_content') === 'uncodeblock' && ot_get_option('_uncode_' . $queried_object->post_type . '_content_block') !== '' && get_post_meta( $queried_object->ID, '_uncode_specific_select_content', true ) === '' ) {
				$content_cb = ot_get_option('_uncode_' . $queried_object->post_type . '_content_block');
			}
			if ( $content_cb && $content_cb !== '' && $content_cb !== 'none' ) {
				$post_data['content_cb_id'] = absint( $content_cb );
			}

			// Content Pre (Posts)
			if ( $queried_object->post_type === 'post' ) {
				$content_block_pre      = 0;
				$page_content_block_pre = isset( $metabox_data['_uncode_specific_content_block_after_pre'][0] ) ? $metabox_data['_uncode_specific_content_block_after_pre'][0] : '';
				if ( $page_content_block_pre === '' ) {
					$generic_content_block_pre = ot_get_option('_uncode_' . $queried_object->post_type . '_content_block_after_pre');
					$content_block_pre = $generic_content_block_pre !== '' ? $generic_content_block_pre : false;
				} else {
					$content_block_pre = $page_content_block_pre !== 'none' ? $page_content_block_pre : false;
				}
				if ( $content_block_pre && $content_block_pre !== '' && $content_block_pre !== 'none' ) {
					$post_data['pre_cb_id'] = absint( $content_block_pre );
				}
			}

			// Content After
			$content_block_after      = 0;
			$page_content_block_after = isset( $metabox_data['_uncode_specific_content_block_after'][0] ) ? $metabox_data['_uncode_specific_content_block_after'][0] : '';
			if ( $page_content_block_after === '' ) {
				$generic_content_block_after = ot_get_option('_uncode_' . $queried_object->post_type . '_content_block_after');
				$content_block_after = $generic_content_block_after !== '' ? $generic_content_block_after : false;
			} else {
				$content_block_after = $page_content_block_after !== 'none' ? $page_content_block_after : false;
			}
			if ( $content_block_after && $content_block_after !== '' && $content_block_after !== 'none' ) {
				$post_data['after_cb_id'] = absint( $content_block_after );
			}
		} else if ( is_404() ) {
			$post_data['is_404'] = true;

			// Header
			$header_cb_id = $this->get_header_content_block( '404' );
			if ( $header_cb_id ) {
				$post_data['header_cb_id'] = absint( $header_cb_id );
			}

			// Footer
			$footer_block_id = $this->get_footer_content_block( '404' );
			if ( $footer_block_id ) {
				$post_data['footer_cb_id'] = absint( $footer_block_id );
			}
		} else if ( is_search() ) {
			$post_data['is_search'] = true;

			// Header
			$header_cb_id = $this->get_header_content_block( 'search_index' );
			if ( $header_cb_id ) {
				$post_data['header_cb_id'] = absint( $header_cb_id );
			}

			// Footer
			$footer_block_id = $this->get_footer_content_block( 'search_index' );
			if ( $footer_block_id ) {
				$post_data['footer_cb_id'] = absint( $footer_block_id );
			}
		} else if ( is_archive() ) {
			global $post;

			$post_data['is_archive'] = true;

			if (isset($post->post_type)) {
				$post_type = $post->post_type . '_index';
			} else {
				global $wp_taxonomies;
				if ( isset($wp_taxonomies[$wp_query->get_queried_object()->taxonomy]) ) {
					$get_object = $wp_taxonomies[$wp_query->get_queried_object()->taxonomy];
					$post_type = $get_object->object_type[0] . '_index';
				}
			}

			if ( is_category() ) {
				$post_data['is_category'] = true;
			} else if ( is_tag() ) {
				$post_data['is_tag'] = true;
			} else if ( is_author() ) {
				$post_data['is_author'] = true;
				$post_type = 'author_index';
			} else if ( is_date() ) {
				$post_data['is_date'] = true;
			} else if ( is_post_type_archive() ) {
				$post_data['is_post_type_archive'] = true;
			} else if ( is_tax() ) {
				$post_data['is_tax'] = true;
			}

			// Header
			$header_cb_id = $this->get_header_content_block( $post_type );
			if ( $header_cb_id ) {
				$post_data['header_cb_id'] = absint( $header_cb_id );
			}

			// Footer
			$footer_block_id = $this->get_footer_content_block( $post_type );
			if ( $footer_block_id ) {
				$post_data['footer_cb_id'] = absint( $footer_block_id );
			}

			// Content
			$content_cb = ot_get_option('_uncode_' . $post_type . '_content_block');
			if ( $content_cb && $content_cb !== '' && $content_cb !== 'none' ) {
				$post_data['content_cb_id'] = absint( $content_cb );
			}
		} else if ( is_home() ) {
			$post_data['is_home'] = true;

			// Header
			$header_cb_id = $this->get_header_content_block( 'post_index' );
			if ( $header_cb_id ) {
				$post_data['header_cb_id'] = absint( $header_cb_id );
			}

			// Footer
			$footer_block_id = $this->get_footer_content_block( 'post_index' );
			if ( $footer_block_id ) {
				$post_data['footer_cb_id'] = absint( $footer_block_id );
			}

			// Content
			$content_cb = ot_get_option('_uncode_post_index_content_block');
			if ( $content_cb && $content_cb !== '' && $content_cb !== 'none' ) {
				$post_data['content_cb_id'] = absint( $content_cb );
			}
		}

		return $post_data;
	}

	/**
	 * Get header Content Block ID from Theme Options.
	 */
	private function get_header_content_block( $post_type ) {
		$content_block_id = 0;
		$page_header_type = ot_get_option( '_uncode_' . $post_type . '_header' );

		if ( $page_header_type === 'header_uncodeblock' ) {
			$content_block_id = ot_get_option( '_uncode_' . $post_type . '_blocks' );
		}

		return $content_block_id;
	}

	/**
	 * Get footer Content Block ID from Theme Options.
	 */
	private function get_footer_content_block( $post_type ) {
		$content_block_id = 0;
		$footer_block     = ot_get_option( '_uncode_' . $post_type . '_footer_block' );

		if ( $footer_block && $footer_block !== 'none' ) {
			$content_block_id = $footer_block;
		} else if ( $footer_block === '' ) {
			$content_block_id = ot_get_option( '_uncode_footer_block' );
		}

		return $content_block_id;
	}
}

endif;

return new Uncode_Setup_Post_Data();
