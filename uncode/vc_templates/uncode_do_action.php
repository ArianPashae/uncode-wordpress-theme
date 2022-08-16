<?php
global $wp_filter;

if ( isset($wp_filter['woocommerce_single_product_summary']) ) {
	$new_woocommerce_single_product_summary = clone $wp_filter['woocommerce_single_product_summary'];
	$woocommerce_single_product_summary     = $wp_filter['woocommerce_single_product_summary'];
}

extract(shortcode_atts(array(
	'hook_type'     => '',
	'hook'          => '',
	'hook_priority' => '',
	'hook_debug'    => '',
) , $atts));

$hook_type     = $hook_type ? $hook_type : 'custom';
$hook          = $hook_type === 'custom' ? $hook : $hook_type;
$hook_debug    = $hook === 'woocommerce_single_product_summary' && $hook_debug === 'yes' ? true : false;
$hook_priority = absint( $hook_priority );

if ( class_exists( 'WooCommerce' ) && $hook === 'woocommerce_single_product_summary' ) {
	if ( $hook_debug ) {
		$uncode_woocommerce_native_funcs = apply_filters( 'uncode_woocommerce_single_product_summary_native_hooks', array(
			'woocommerce_template_single_title',
			'woocommerce_template_single_rating',
			'woocommerce_template_single_price',
			'woocommerce_template_single_excerpt',
			'woocommerce_template_single_meta',
			'woocommerce_template_single_sharing',
			'woocommerce_template_single_add_to_cart',
			'uncode_add_wishlist_button_to_single_product',
			'WC_Structured_Data'
		) );

		$actions_list = array();

		if ( is_array( $woocommerce_single_product_summary ) || is_object( $woocommerce_single_product_summary ) ) {
			foreach ( $woocommerce_single_product_summary as $key => $callback ) {
				foreach ( $callback as $func_name => $func_spec ) {
					if ( isset( $func_spec['function'] ) ) {
						$function_spec = false;

						if ( is_array( $func_spec['function'] ) ) {
							if ( ! in_array( get_class( $func_spec['function'][0] ), $uncode_woocommerce_native_funcs ) ) {
								$function_class = get_class( $func_spec['function'][0] );
								$function_spec  = array( $function_class, $func_spec['function'][1] );
							}
						} else {
							if ( ! in_array( $func_spec['function'], $uncode_woocommerce_native_funcs ) ) {
								$function_spec = $func_spec['function'];
							}
						}

						if ( $function_spec ) {
							$actions_list[] = array(
								'priority' => $key,
								'callback' => $function_spec
							);
						}
					}
				}
			}
		}

		if ( $actions_list ) {
			$pre_list = '<pre>';
			foreach ( $actions_list as $action ) {
				$action_priority = '[' . $action['priority'] . ']';
				$action_name = is_array( $action['callback'] ) ? implode( '/' , $action['callback'] ) : $action['callback'];

				$pre_list .= esc_html( $action_name . ' ' . $action_priority );
				$pre_list .= "\n";
			}
			$pre_list .= '</pre>';
			echo uncode_remove_p_tag( $pre_list );
		}
	}

	if ( is_array( $woocommerce_single_product_summary ) || is_object( $woocommerce_single_product_summary ) ) {
		foreach ( $woocommerce_single_product_summary as $key => $callback ) {
			foreach ( $callback as $func_name => $func_spec ) {
				if ( isset( $func_spec['function'] ) && $hook_priority && $hook_priority != $key ) {
					unset( $wp_filter['woocommerce_single_product_summary']->callbacks[$key][$func_name] );
				}
			}
		}
	}

	if ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
		$action_desc = 'woocommerce_single_product_summary';
		if ( $hook_priority != '' ) {
			$action_desc .= '[' . $hook_priority . ']';
		}
		?>
		<div class="messagebox_text style-accent-bg text-center">
			<code><?php echo esc_html( '<?php do_action("' . $action_desc . '"); ?>' ); ?></code>
		</div>
		<?php
	} else {
		do_action('woocommerce_single_product_summary');

		$wp_filter['woocommerce_single_product_summary'] = $new_woocommerce_single_product_summary;
	}


	if ( $hook_priority === 0 || $hook_priority == 60 ) {
		add_filter( 'uncode_woocommerce_print_product_structured_data_after_page_builder', '__return_false' );
	}

} else if ( $hook !== '' ) {
	$hook = sanitize_title_with_dashes( $hook );
	$hook = str_replace('-', '_', $hook);

	ob_start();
	do_action( $hook );
	$out = ob_get_clean();
	if ( $out == '' && function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
		?>
		<div class="messagebox_text style-accent-bg text-center">
			<code><?php printf( esc_html__( '<?php do_action("%s"); ?>', 'uncode' ), $hook ); ?></code>
		</div>
		<?php
	} else {
		echo uncode_switch_stock_string( $out );
	}
}
