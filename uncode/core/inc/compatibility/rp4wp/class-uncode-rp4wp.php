<?php
/**
 * Related Posts for WordPress support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Uncode_RP4WP_Functions' ) ) :

/**
 * Uncode_RP4WP_Functions Class
 */
class Uncode_RP4WP_Functions {

	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'init' ) );
	}

	/**
	 * Init functions.
	 */
	public function init() {
		add_filter( 'rp4wp_supported_post_types', array( $this, 'uncode_rp4wp_filter_supported_post_types' ) );
		add_filter( 'rp4wp_settings_sections', array( $this, 'uncode_rp4wp_alter_settings' ) );

		// Don't automatically append posts
		add_filter( 'rp4wp_append_content', '__return_false' );

		// Don't append CSS, theme will handle CSS
		add_filter( 'rp4wp_disable_css', '__return_true' );
	}

	/**
	 * Get supported related CPTs.
	 */
	private function uncode_get_related_post_types() {
		$args                      = array(
			'public'   => true,
			'_builtin' => false
		);
		$output                    = 'names'; // names or objects, note names is the default
		$operator                  = 'and'; // 'and' or 'or'
		$get_post_types            = get_post_types( $args, $output, $operator );
		$uncode_related_post_types = array();
		if ( ( $key = array_search( 'uncodeblock', $get_post_types ) ) !== false ) {
			unset( $get_post_types[ $key ] );
		}

		if ( ( $key = array_search( 'uncode_gallery', $get_post_types ) ) !== false ) {
			unset( $get_post_types[ $key ] );
		}
		$uncode_related_post_types[] = 'post';
		$uncode_related_post_types[] = 'page';
		foreach ( $get_post_types as $key => $value ) {
			$uncode_related_post_types[] = $key;
		}
		$uncode_related_post_types = apply_filters( 'uncode_related_post_types', $uncode_related_post_types );
		return $uncode_related_post_types;
	}

	/**
	 * Filter related CPTs.
	 */
	public function uncode_rp4wp_filter_supported_post_types() {
		return $this->uncode_get_related_post_types();
	}

	/**
	 * Filter settings.
	 */
	public function uncode_rp4wp_alter_settings( $sections ) {
		unset( $sections['styling'] );
		unset( $sections['general']['fields']['heading_text'] );
		unset( $sections['general']['fields']['excerpt_length'] );
		unset( $sections['misc']['fields']['show_love'] );
		return $sections;
	}
}

endif;

return new Uncode_RP4WP_Functions();
