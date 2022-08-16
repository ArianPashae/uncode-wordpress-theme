<?php
/**
 * Widget related functions.
 *
 * @package uncode
 */

/**
 * Get default widget args.
 */
function uncode_get_default_widget_args( $id ) {
	$args = array(
		'before_widget' => '<aside class="widget widget-style widget_' . esc_attr( $id ) . ' widget-container collapse-init sidebar-widgets">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	return $args;
}

/**
 * Add default title when collpase is active
 * and title is missing
 */
function uncode_add_default_widget_title( $html, $multiple = false, $default_title = false ) {
	if ( $multiple ) {
		$new_html = '';

		$regex = '/<aside\b[^>]*>.*?<\/aside>/ms';
		preg_match_all( $regex, $html, $matches, PREG_SET_ORDER, 0 );

		foreach ( $matches as $key => $value ) {
			if ( isset( $value[0] ) ) {
				$widget = $value[0];

				$new_html .= uncode_add_default_widget_title_element( $widget );
			}
		}

		$html = $new_html;

	} else {
		$html = uncode_add_default_widget_title_element( $html, true, $default_title );
	}

	return $html;
}

/**
 * Helper function that adds an h3 in the content of the widget
 */
function uncode_add_default_widget_title_element( $widget, $is_vc_module = false, $default_title = false ) {
	if ( strpos( $widget, 'widget-title' ) === false ) {
		if ( $is_vc_module ) {
			$default_title = $default_title ? $default_title : esc_html__( 'Widget title', 'uncode' );
		} else {
			$default_title = uncode_get_default_widget_title_from_id( $widget );
		}

		$pattern     = '/<aside\b[^>]*>/i';
		$replacement = '$0<h3 class="widget-title widget-title--hide-desktop">' . $default_title . '</h3>';
		$widget      = preg_replace( $pattern, $replacement, $widget );
	}

	return $widget;
}

/**
 * Find the widget id and get the title from its value
 */
function uncode_get_default_widget_title_from_id( $widget ) {
	$default_title = '';
	$id            = false;

	$regex = '/id="(.*?)"/ms';
	preg_match_all( $regex, $widget, $matches, PREG_SET_ORDER, 0 );

	// Get first entry (we are assuming that the firs id occurrence
	// is the ID of the widget, the <aside> element)
	if ( is_array( $matches ) && isset( $matches[0] ) ) {
		$first_match = $matches[0];

		if ( isset( $first_match[1] ) && $first_match[1] ) {
			$id = $first_match[1];

			$default_title = uncode_get_widget_title_from_id( $id );
		}
	}

	$default_title = $default_title ? $default_title : esc_html__( 'Widget title', 'uncode' );
	$default_title = apply_filters( 'uncode_default_widget_title_from_id', $default_title, $id );

	return $default_title;
}

/**
 * Get widget title from ID
 */
function uncode_get_widget_title_from_id( $id ) {
	global $wp_registered_widgets;

	$title = '';

	if ( isset( $wp_registered_widgets[$id] ) && isset( $wp_registered_widgets[$id]['name'] ) ) {
		$title = $wp_registered_widgets[$id]['name'];
	}

	return $title ? $title : esc_html__( 'Widget title', 'uncode' );
}
