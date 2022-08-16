<?php
/**
 * Structure related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'uncode_open_row' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_open_row( $classes = array() ) {

	$row_classes = implode( ' ', $classes );

	echo '<div class="row-container">
			<div class="row row-parent ' . esc_attr( $row_classes ) . '">
				<div class="row-inner">';
}
endif;//uncode_open_row

if ( ! function_exists( 'uncode_close_row' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_close_row() {

	echo '		</div>
			</div>
		</div>';
}
endif;//uncode_close_row

if ( ! function_exists( 'uncode_open_col' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_open_col( $classes = array() ) {

	$col_classes = implode( ' ', $classes );

	echo '<div class="' . $col_classes . '">
				<div class="uncol">
					<div class="uncoltable">
						<div class="uncell">
							<div class="uncont">';
}
endif;//uncode_open_col

if ( ! function_exists( 'uncode_close_col' ) ) :
/**
 * @since Uncode 2.3.0
 */
function uncode_close_col() {

	echo '				</div>
					</div>
				</div>
			</div>
		</div>';
}
endif;//uncode_close_col
