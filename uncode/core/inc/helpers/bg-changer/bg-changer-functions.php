<?php

if ( ! function_exists( 'uncode_bg_changer' ) ) :
/**
 * @since Uncode 2.3.4
 */
function uncode_bg_changer() {

	global $changer_back_color_div, $changer_back_first;
	if ( $changer_back_color_div != '' && ( ! function_exists('vc_is_page_editable') || ! vc_is_page_editable() ) ) {
		echo '<div id="changer-back-color" class="' . esc_attr( $changer_back_first ) . '"></div>';
	}

}
endif; //uncode_bg_changer
add_action( 'uncode_after_page_footer', 'uncode_bg_changer', 1000 );
