<?php
/**
 * Theme/Plugins Updater Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Uncode_Updater' ) ) :

/**
 * Uncode_Updater Class
 */
class Uncode_Updater {

	/**
	 * Get things going
	 */
	function __construct() {
		// Premium plugins updates
		add_action( 'init', array( $this, 'update_premium_plugins' ) );

		// Theme update
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'update_theme' ) );
		add_filter( 'pre_set_transient_update_themes', array( $this, 'update_theme' ) );

		if ( apply_filters( 'uncode_enable_core_updates_icon_notification', true ) ) {
			// Print updates icon in Uncode admin menu
			add_filter( 'uncode_system_status_menu_after_text', array( $this, 'print_updates_icon_main_menu' ) );
			add_filter( 'tgmpa_admin_menu_args', array( $this, 'print_updates_icon_plugins_page' ) );
		}
	}

	/**
	 * Update premium plugins
	 */
	public function update_premium_plugins() {
		// Return early if not in the admin.
		if ( ! is_admin() ) {
			return;
		}

		$premium_plugins = uncode_get_premium_plugins();

		foreach ( $premium_plugins as $slug => $plugin_info ) {
			// The plugin must be installed of course
			if ( ! file_exists( trailingslashit( WP_PLUGIN_DIR ) . $plugin_info[ 'plugin_path' ] ) ) {
				continue;
			}

			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . $plugin_info[ 'plugin_path' ] );

			$args = array(
				'plugin_name' => $plugin_info[ 'plugin_name' ],
				'plugin_slug' => $plugin_info[ 'plugin_slug' ],
				'plugin_path' => $plugin_info[ 'plugin_path' ],
				'plugin_url'  => $plugin_info[ 'plugin_url' ],
				'remote_url'  => apply_filters( 'uncode_api_update_remote_json_url' , $plugin_info[ 'remote_url' ], $plugin_info ),
				'version'     => $plugin_data[ 'Version' ],
				'key'         => ''
			);

			$tgm_updater = new TGM_Updater( $args );
		}
	}

	/**
	 * Update theme
	 */
	public function update_theme( $transient ) {
		// Return early if not in the admin.
		if ( ! is_admin() ) {
			return;
		}

		// Check new versions
		$response = wp_remote_post(
			apply_filters( 'uncode_api_theme_update_remote_json_url' , 'https://api.undsgn.com/downloads/uncode/theme/api.json' ),
			array(
				'timeout' => 45
			)
		);

		// Return early on WP Error
		if ( is_wp_error( $response ) ) {
			return $transient;
		}

		// Get response data
		$response_data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Return early on WP Error
		if ( is_wp_error( $response_data ) ) {
			return $transient;
		}

		// Check JSON content
		if ( ! isset( $response_data[ 'new_version' ] ) || ! isset( $response_data[ 'wp_version' ] ) || ! isset( $response_data[ 'url' ] ) || ! isset( $response_data[ 'package' ] ) ) {
			return $transient;
		}

		global $wp_version;

		// Check WP version
		if ( version_compare( $wp_version, $response_data[ 'wp_version' ], '<' ) ) {
			return $transient;
		}

		// Get theme data
		$theme_data = wp_get_theme( 'uncode' );

		// Check if we have a newer version
		if ( version_compare( $theme_data->get( 'Version' ), $response_data[ 'new_version' ], '<' ) ) {
			$transient->response[ 'uncode' ] = array(
				'theme'       => 'uncode',
				'new_version' => $response_data[ 'new_version' ],
				'url'         => $response_data[ 'url' ],
				'package'     => $response_data[ 'package' ],
			);
		}

		return $transient;
	}

	/**
	 * Array of core plugins with the notification enabled
	 *
	 * (ie. plugins included in the zip)
	 */
	public function core_plugins_with_notification() {
		$core_plugins = array(
			'uncode-core' => 'uncode-core/uncode-core.php',
		);

		$plugins = array();

		foreach ( $core_plugins as $plugin_id => $plugin ) {
			if ( uncode_check_for_dependency( $plugin ) ) {
				$plugins[] = $plugin_id;
			}
		}

		return apply_filters( 'uncode_get_core_plugins_with_notification', $plugins );
	}

	/**
	 * Array of premium plugins with the notification enabled
	 *
	 * (ie. plugins not included in the zip)
	 */
	public function premium_plugins_with_notification() {
		$premium_plugins = array(
			'uncode-js_composer' => 'uncode-js_composer/js_composer.php',
			'uncode-privacy'     => 'uncode-privacy/uncode-privacy.php',
			'uncode-wireframes'  => 'uncode-wireframes/uncode-wireframes.php',
		);

		if ( apply_filters( 'uncode_enable_remote_uncode_core', false ) ) {
			$premium_plugins['uncode-core'] = 'uncode-core/uncode-core.php';
		}

		$plugins = array();

		foreach ( $premium_plugins as $plugin_id => $plugin ) {
			if ( uncode_check_for_dependency( $plugin ) ) {
				$plugins[] = $plugin_id;
			}
		}

		return apply_filters( 'uncode_get_premium_plugins_with_notification', $plugins );
	}

	/**
	 * Collect counts for available updates
	 */
	public function get_update_data() {
		$premium_plugins_with_notification = $this->premium_plugins_with_notification();

		$plugins_to_update = 0;

		$plugins = current_user_can( 'update_plugins' );
		if ( $plugins ) {
			// premium plugins
			$update_plugins = get_site_transient( 'update_plugins' );
			if ( ! empty( $update_plugins->response ) ) {
				foreach ( $update_plugins->response as $key => $plugin ) {
					if ( isset( $plugin->slug ) && in_array( $plugin->slug, $premium_plugins_with_notification ) ) {
						$plugins_to_update++;
					}
				}
			}

			if ( ! apply_filters( 'uncode_enable_remote_uncode_core', false ) ) {
				$core_plugins_with_notification    = $this->core_plugins_with_notification();

				// core plugins
				if ( isset( $GLOBALS['tgmpa'] ) ) {
					$tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

					foreach ( $core_plugins_with_notification as $core_plugin ) {
						if ( $tgmpa_instance->does_plugin_require_update( $core_plugin ) ) {
							$plugins_to_update++;
						}
					}
				}
			}
		}

		return apply_filters( 'uncode_plugins_with_notification_counts', $plugins_to_update );
	}

	/**
	 * Print updates icon in Uncode menu
	 */
	public function print_updates_icon_main_menu() {
		$count = $this->get_update_data();

		if ( $count > 0 ) {
			return sprintf(
				' <span class="update-plugins %1$d"><span class="plugin-count">%2$s</span></span>',
				$count,
				esc_html( number_format_i18n( $count ) )
			);
		}

		return '';
	}

	/**
	 * Print updates icon in Install Plugins page
	 */
	public function print_updates_icon_plugins_page( $args ) {
		$count = $this->get_update_data();

		if ( $count > 0 ) {
			$count_string = sprintf(
				' <span class="update-plugins %1$d"><span class="plugin-count">%2$s</span></span>',
				$count,
				esc_html( number_format_i18n( $count ) )
			);

			if ( is_array( $args ) && isset( $args['page_title'] ) ) {
				$args['menu_title'] = $args['menu_title'] . $count_string;
			}
		}

		return $args;
	}
}

endif;

return new Uncode_Updater();
