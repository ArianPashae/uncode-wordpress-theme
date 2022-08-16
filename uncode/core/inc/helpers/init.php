<?php
/**
 * Load helper files
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Post Data functions
 */
require_once get_template_directory() . '/core/inc/helpers/post-data/post-data.php';

/**
 * Dynamic CSS functions
 */
require_once get_template_directory() . '/core/inc/helpers/dynamic-css/load.php';

/**
 * Load image functions
 */
require_once get_template_directory() . '/core/inc/helpers/images/images-functions.php';
require_once get_template_directory() . '/core/inc/helpers/images/srcset-images-functions.php';

/**
 * Load gallery functions
 */
require_once get_template_directory() . '/core/inc/helpers/galleries/galleries-functions.php';

/**
 * Related Posts functions.
 */
require_once get_template_directory() . '/core/inc/helpers/related-posts/related-posts-functions.php';

/**
 * Structure functions.
 */
require_once get_template_directory() . '/core/inc/helpers/structure/structure-functions.php';

/**
 * Account functions.
 */
require_once get_template_directory() . '/core/inc/helpers/account/account-functions.php';

/**
 * Modal functions.
 */
require_once get_template_directory() . '/core/inc/helpers/modal/modal-functions.php';

/**
 * Quick View functions.
 */
require_once get_template_directory() . '/core/inc/helpers/quick-view/quick-view-functions.php';
require_once get_template_directory() . '/core/inc/helpers/quick-view/class-uncode-quick-view.php';

/**
 * BG Changer functions.
 */
require_once get_template_directory() . '/core/inc/helpers/bg-changer/bg-changer-functions.php';

/**
 * Custom Cursor functions.
 */
require_once get_template_directory() . '/core/inc/helpers/custom-cursor/custom-cursor-functions.php';

/**
 * Taxonomy functions.
 */
require_once get_template_directory() . '/core/inc/helpers/taxonomies/taxonomies-functions.php';

/**
 * Parallax functions.
 */
require_once get_template_directory() . '/core/inc/helpers/parallax/parallax-functions.php';

/**
 * Badges functions.
 */
require_once get_template_directory() . '/core/inc/helpers/badge/badge-functions.php';
