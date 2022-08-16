<?php
/**
 * Third-party related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Uncode Privacy plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/gdpr/class-uncode-gdpr.php';

/**
 * Gutenberg plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/gutenberg/class-uncode-gutenberg.php';
require_once get_template_directory() . '/core/inc/compatibility/gutenberg/gutenberg-helpers.php';

/**
 * Visual Composer plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/vc/init.php';

/**
 * UpdraftPlus plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/updraftplus/class-uncode-updraftplus.php';

/**
 * ShortPixel plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/shortpixel/class-uncode-shortpixel.php';

/**
 * Related Posts for WordPress plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/rp4wp/class-uncode-rp4wp.php';

/**
 * CF7 plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/cf7/class-uncode-cf7.php';

/**
 * WooCommerce plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/init.php';

/**
 * Yith Wishlist plugin.
 */
require_once get_template_directory() . '/core/inc/compatibility/wishlist/class-uncode-wishlist.php';
require_once get_template_directory() . '/core/inc/compatibility/wishlist/wishlist-helpers.php';

/**
 * WP Rocket.
 */
require_once get_template_directory() . '/core/inc/compatibility/wp-rocket/class-uncode-wp-rocket.php';

/**
 * WooCommerce Opening Hours.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce-opening-hours/class-uncode-woocommerce-opening-hours.php';

/**
 * WordPress SEO (Yoast).
 */
require_once get_template_directory() . '/core/inc/compatibility/yoast/class-uncode-yoast.php';

/**
 * Rank Math SEO.
 */
require_once get_template_directory() . '/core/inc/compatibility/rankmath/class-uncode-rankmath.php';
