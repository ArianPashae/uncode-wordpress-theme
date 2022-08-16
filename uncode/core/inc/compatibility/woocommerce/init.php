<?php
/**
 * WooCommerce support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * WooCommerce customizations.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/core-functions.php';

/**
 * WooCommerce hooks.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/hooks.php';

/**
 * WooCommerce filters.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/filters.php';

/**
 * WooCommerce settings.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/class-uncode-wc-settings.php';

/**
 * VC shortcodes functions.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/vc-shortcodes-functions.php';

/**
 * Icon menu mini cart.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/icon-cart.php';

/**
 * Sidecart.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/sidecart.php';

/**
 * Checkout functions.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/checkout/functions.php';

/**
 * Cart functions.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/cart/functions.php';

/**
 * My Account functions.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/my-account/functions.php';

/**
 * Sorting menu.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/sorting.php';

/**
 * Up sells.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/upsells.php';

/**
 * Catalog mode.
 */
require_once get_template_directory() . '/core/inc/compatibility/woocommerce/catalog-mode/class-uncode-catalog-mode.php';
