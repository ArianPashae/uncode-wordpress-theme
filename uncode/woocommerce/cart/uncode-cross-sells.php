<?php
/**
 * Cart cross sells template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$cross_sells_columns = isset( $cross_sells_carousel_conf[ 'lg' ] ) ? $cross_sells_carousel_conf[ 'lg' ] : wc_get_loop_prop( 'columns' );

woocommerce_cross_sell_display( '-1', $cross_sells_columns );
