<?php
/**
 * Visual Composer support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * VC core functions.
 */
require_once get_template_directory() . '/core/inc/compatibility/vc/core-functions.php';

/**
 * Main VC class.
 */
require_once get_template_directory() . '/core/inc/compatibility/vc/class-uncode-vc.php';
