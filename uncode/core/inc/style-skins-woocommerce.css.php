/*
----------------------------------------------------------

#Skins-WooCommerce

----------------------------------------------------------
*/
.wc-backward {
  display: inline-block;
  font-style: normal !important;
  text-align: center;
  vertical-align: middle;
  margin-top: 1px;
  margin-bottom: 1px;
  cursor: pointer;
  background-image: none;
  border-style: solid;
  border-radius: 2px;
  outline: none;
  -webkit-text-stroke: 0px;
  transition: color 200ms ease-in-out, background-color 200ms ease-in-out, border-color 200ms ease-in-out;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
}
@media (max-width: 569px) {
  .wc-backward {
    transform: scale(0.8);
    transform-origin: left;
  }
  .navbar .wc-backward,
  .menu-accordion .wc-backward {
    transform: none;
  }
}
.wc-stripe-error .wc-backward,
.wc-notice .wc-backward {
  margin-left: 18px;
}
.widget .star-rating span:before {
  font-size: 11px;
}
.woocommerce-session-expired-wrapper .wc-backward {
  margin-left: 18px;
}
#reviews .woocomments .woocomments-title,
.products.related .related-title,
#review_form #respond #reply-title,
.wootabs .tab-content:not(.vertical) .tab-pane:not(.tab-vcomposer) .product-tab-title {
  font-family: <?php echo sanitize_text_field($font_family_ui); ?>;
  font-weight: <?php echo sanitize_text_field($ui_font_weight); ?>;
  letter-spacing: <?php echo sanitize_text_field($ui_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($ui_text_transform); ?>;
  font-size: <?php echo sanitize_text_field($ui_font_size); ?>px;
}
.style-dark .shop_table.cart tbody td:before,
.style-light .style-dark .shop_table.cart tbody td:before,
.style-dark .widget_product_categories .current-cat > a,
.style-light .style-dark .widget_product_categories .current-cat > a,
.style-dark .widget_sorting a.active,
.style-light .style-dark .widget_sorting a.active,
.style-dark .woocommerce-MyAccount-navigation a:before,
.style-light .style-dark .woocommerce-MyAccount-navigation a:before {
  color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
.style-light .shop_table.cart tbody td:before,
.style-dark .style-light .shop_table.cart tbody td:before,
.style-light .widget_product_categories .current-cat > a,
.style-dark .style-light .widget_product_categories .current-cat > a,
.style-light .widget_sorting a.active,
.style-dark .style-light .widget_sorting a.active,
.style-light .woocommerce-MyAccount-navigation a:before,
.style-dark .style-light .woocommerce-MyAccount-navigation a:before {
  color: <?php echo sanitize_text_field($color_text); ?>;
}
.style-dark td.actions > button[disabled],
.style-light .style-dark td.actions > button[disabled] {
  color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_text_inverted, 90 ) : sanitize_text_field($color_text_inverted); ?>;
}
.style-light td.actions > button[disabled],
.style-dark .style-light td.actions > button[disabled] {
  color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field($color_text); ?>;
}
.style-dark .quantity .qty-inset .qty-minus:hover,
.style-light .style-dark .quantity .qty-inset .qty-minus:hover,
.style-dark .quantity .qty-inset .qty-plus:hover,
.style-light .style-dark .quantity .qty-inset .qty-plus:hover,
.style-dark .woocommerce-MyAccount-navigation a:hover:before,
.style-light .style-dark .woocommerce-MyAccount-navigation a:hover:before,
.style-dark .woocommerce-MyAccount-navigation li.is-active a,
.style-light .style-dark .woocommerce-MyAccount-navigation li.is-active a,
.style-dark .woocommerce-MyAccount-content mark,
.style-light .style-dark .woocommerce-MyAccount-content mark {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .quantity .qty-inset .qty-minus:hover,
.style-dark .style-light .quantity .qty-inset .qty-minus:hover,
.style-light .quantity .qty-inset .qty-plus:hover,
.style-dark .style-light .quantity .qty-inset .qty-plus:hover,
.style-light .woocommerce-MyAccount-navigation a:hover:before,
.style-dark .style-light .woocommerce-MyAccount-navigation a:hover:before,
.style-light .woocommerce-MyAccount-navigation li.is-active a,
.style-dark .style-light .woocommerce-MyAccount-navigation li.is-active a,
.style-light .woocommerce-MyAccount-content mark,
.style-dark .style-light .woocommerce-MyAccount-content mark {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.woocommerce span.onsale,
.widget_price_filter .ui-slider .ui-slider-range,
.uncode-cart .badge,
.mobile-shopping-cart .badge,
.order-table-with-thumbs .order_details strong.product-quantity,
.order-table-with-thumbs .woocommerce-checkout-review-order-table strong.product-quantity {
  background-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.tmb-woocommerce span.price,
span.price,
p.price {
  letter-spacing: <?php echo sanitize_text_field($heading_letter_spacing); ?>em;
  font-weight: <?php echo sanitize_text_field($heading_font_weight); ?>;
  font-family: <?php echo sanitize_text_field($font_family_headings); ?>;
}
.style-dark .shop_attributes th,
.style-light .style-dark .shop_attributes th,
.style-dark .shop_attributes td,
.style-light .style-dark .shop_attributes td,
.style-dark .shop_table th,
.style-light .style-dark .shop_table th,
.style-dark .shop_table tr > td:last-child .amount,
.style-light .style-dark .shop_table tr > td:last-child .amount,
.style-dark .shop_table td.product-name,
.style-light .style-dark .shop_table td.product-name,
.style-dark .shop_table.compact-layout .price-wrapper,
.style-light .style-dark .shop_table.compact-layout .price-wrapper,
.style-dark .shop_table.cart tbody td.product-price .amount,
.style-light .style-dark .shop_table.cart tbody td.product-price .amount,
.style-dark #shipping_method label,
.style-light .style-dark #shipping_method label,
.style-dark .quantity .qty-inset,
.style-light .style-dark .quantity .qty-inset,
.style-dark .woocommerce-pagination ul li a,
.style-light .style-dark .woocommerce-pagination ul li a,
.style-dark .woocommerce-pagination ul li span,
.style-light .style-dark .woocommerce-pagination ul li span,
.style-dark .widget ul.product_list_widget li .quantity,
.style-light .style-dark .widget ul.product_list_widget li .quantity,
.style-dark .widget ul.product_list_widget li .amount,
.style-light .style-dark .widget ul.product_list_widget li .amount,
.style-dark .widget_shopping_cart .total,
.style-light .style-dark .widget_shopping_cart .total,
.style-dark .widget_price_filter .price_slider_amount,
.style-light .style-dark .widget_price_filter .price_slider_amount,
.style-dark .star-rating,
.style-light .style-dark .star-rating,
.style-dark span.price,
.style-light .style-dark span.price,
.style-dark p.price,
.style-light .style-dark p.price,
.style-dark form.cart .group_table,
.style-light .style-dark form.cart .group_table,
.style-dark form.cart .variations select,
.style-light .style-dark form.cart .variations select,
.style-dark form.cart .variations td.label label,
.style-light .style-dark form.cart .variations td.label label,
.style-dark #payment label,
.style-light .style-dark #payment label,
.style-dark .woocommerce-form-coupon-toggle,
.style-light .style-dark .woocommerce-form-coupon-toggle,
.style-dark .woocommerce-form-login-toggle,
.style-light .style-dark .woocommerce-form-login-toggle,
.style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .amount,
.style-light .style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .amount,
.style-dark .woocommerce-MyAccount-content > a.button,
.style-light .style-dark .woocommerce-MyAccount-content > a.button,
.style-dark .woocommerce-MyAccount-content p > a.button,
.style-light .style-dark .woocommerce-MyAccount-content p > a.button {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .shop_attributes th,
.style-dark .style-light .shop_attributes th,
.style-light .shop_attributes td,
.style-dark .style-light .shop_attributes td,
.style-light .shop_table th,
.style-dark .style-light .shop_table th,
.style-light .shop_table tr > td:last-child .amount,
.style-dark .style-light .shop_table tr > td:last-child .amount,
.style-light .shop_table td.product-name,
.style-dark .style-light .shop_table td.product-name,
.style-light .shop_table.compact-layout .price-wrapper,
.style-dark .style-light .shop_table.compact-layout .price-wrapper,
.style-light .shop_table.cart tbody td.product-price .amount,
.style-dark .style-light .shop_table.cart tbody td.product-price .amount,
.style-light #shipping_method label,
.style-dark .style-light #shipping_method label,
.style-light .quantity .qty-inset,
.style-dark .style-light .quantity .qty-inset,
.style-light .woocommerce-pagination ul li a,
.style-dark .style-light .woocommerce-pagination ul li a,
.style-light .woocommerce-pagination ul li span,
.style-dark .style-light .woocommerce-pagination ul li span,
.style-light .widget ul.product_list_widget li .quantity,
.style-dark .style-light .widget ul.product_list_widget li .quantity,
.style-light .widget ul.product_list_widget li .amount,
.style-dark .style-light .widget ul.product_list_widget li .amount,
.style-light .widget_shopping_cart .total,
.style-dark .style-light .widget_shopping_cart .total,
.style-light .widget_price_filter .price_slider_amount,
.style-dark .style-light .widget_price_filter .price_slider_amount,
.style-light .star-rating,
.style-dark .style-light .star-rating,
.style-light span.price,
.style-dark .style-light span.price,
.style-light p.price,
.style-dark .style-light p.price,
.style-light form.cart .group_table,
.style-dark .style-light form.cart .group_table,
.style-light form.cart .variations select,
.style-dark .style-light form.cart .variations select,
.style-light form.cart .variations td.label label,
.style-dark .style-light form.cart .variations td.label label,
.style-light #payment label,
.style-dark .style-light #payment label,
.style-light .woocommerce-form-coupon-toggle,
.style-dark .style-light .woocommerce-form-coupon-toggle,
.style-light .woocommerce-form-login-toggle,
.style-dark .style-light .woocommerce-form-login-toggle,
.style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .amount,
.style-dark .style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .amount,
.style-light .woocommerce-MyAccount-content > a.button,
.style-dark .style-light .woocommerce-MyAccount-content > a.button,
.style-light .woocommerce-MyAccount-content p > a.button,
.style-dark .style-light .woocommerce-MyAccount-content p > a.button {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.wc-forward,
.wc-forward a,
.wc-backward,
.woocommerce-MyAccount-content > a.button,
.woocommerce-MyAccount-content p > a.button,
.wc-backward {
  font-weight: <?php echo sanitize_text_field($btn_font_weight); ?> !important;
  font-family: <?php echo sanitize_text_field($font_family_btn); ?> !important;
  letter-spacing: <?php echo sanitize_text_field($btn_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($btn_text_transform); ?>;
}
.uncode-cart .badge,
.uncode-cart .btn {
  font-weight: <?php echo sanitize_text_field($btn_font_weight); ?> !important;
}
.select2-container .select2-choice,
.select2-container--default .select2-selection--single,
.woocommerce-MyAccount-content > a.button,
.woocommerce-MyAccount-content p > a.button {
  border-width: <?php echo sanitize_text_field($btn_border_width); ?>px;
}
.style-dark .shop_table,
.style-light .style-dark .shop_table,
.style-dark .woocommerce-pagination,
.style-light .style-dark .woocommerce-pagination,
.style-dark .woocommerce .woocommerce-breadcrumb,
.style-light .style-dark .woocommerce .woocommerce-breadcrumb,
.style-dark .widget ul.product_list_widget li,
.style-light .style-dark .widget ul.product_list_widget li,
.style-dark .widget_shopping_cart .total,
.style-light .style-dark .widget_shopping_cart .total,
.style-dark .widget_shopping_cart .buttons,
.style-light .style-dark .widget_shopping_cart .buttons,
.style-dark .widget_layered_nav_filters ul li a,
.style-light .style-dark .widget_layered_nav_filters ul li a,
.style-dark .widget_price_filter .ui-slider .ui-slider-handle,
.style-light .style-dark .widget_price_filter .ui-slider .ui-slider-handle,
.style-dark .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-light .style-dark .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-dark .row-related,
.style-light .style-dark .row-related,
.style-dark .payment_methods .about_paypal,
.style-light .style-dark .payment_methods .about_paypal,
.style-dark .wootabs .tab-content:not(.vertical),
.style-light .style-dark .wootabs .tab-content:not(.vertical),
.style-dark .woocommerce-checkout-review-order-table,
.style-light .style-dark .woocommerce-checkout-review-order-table,
.style-dark .woocommerce-billing-fields__field-wrapper,
.style-light .style-dark .woocommerce-billing-fields__field-wrapper,
.style-dark .woocommerce-shipping-fields,
.style-light .style-dark .woocommerce-shipping-fields,
.style-dark #payment,
.style-light .style-dark #payment,
.style-dark .form-row.place-order,
.style-light .style-dark .form-row.place-order,
.style-dark .woocommerce-form-login,
.style-light .style-dark .woocommerce-form-login,
.style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-number a,
.style-light .style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-number a,
.style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-actions a,
.style-light .style-dark .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-actions a,
.style-dark .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-product a,
.style-light .style-dark .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-product a,
.style-dark .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-file a,
.style-light .style-dark .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-file a,
.style-dark .woocommerce-MyAccount-content table.account-payment-methods-table .payment-method-actions a,
.style-light .style-dark .woocommerce-MyAccount-content table.account-payment-methods-table .payment-method-actions a,
.style-dark .woocommerce-Addresses,
.style-light .style-dark .woocommerce-Addresses,
.style-dark .uncode-sidecart-wrapper li.mini_cart_item,
.style-light .style-dark .uncode-sidecart-wrapper li.mini_cart_item,
.style-dark .uncode-sidecart-wrapper .woocommerce-mini-cart-header,
.style-light .style-dark .uncode-sidecart-wrapper .woocommerce-mini-cart-header {
  border-color: rgba(255, 255, 255, 0.25);
}
.style-light .shop_table,
.style-dark .style-light .shop_table,
.style-light .woocommerce-pagination,
.style-dark .style-light .woocommerce-pagination,
.style-light .woocommerce .woocommerce-breadcrumb,
.style-dark .style-light .woocommerce .woocommerce-breadcrumb,
.style-light .widget ul.product_list_widget li,
.style-dark .style-light .widget ul.product_list_widget li,
.style-light .widget_shopping_cart .total,
.style-dark .style-light .widget_shopping_cart .total,
.style-light .widget_shopping_cart .buttons,
.style-dark .style-light .widget_shopping_cart .buttons,
.style-light .widget_layered_nav_filters ul li a,
.style-dark .style-light .widget_layered_nav_filters ul li a,
.style-light .widget_price_filter .ui-slider .ui-slider-handle,
.style-dark .style-light .widget_price_filter .ui-slider .ui-slider-handle,
.style-light .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-dark .style-light .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-light .row-related,
.style-dark .style-light .row-related,
.style-light .payment_methods .about_paypal,
.style-dark .style-light .payment_methods .about_paypal,
.style-light .wootabs .tab-content:not(.vertical),
.style-dark .style-light .wootabs .tab-content:not(.vertical),
.style-light .woocommerce-checkout-review-order-table,
.style-dark .style-light .woocommerce-checkout-review-order-table,
.style-light .woocommerce-billing-fields__field-wrapper,
.style-dark .style-light .woocommerce-billing-fields__field-wrapper,
.style-light .woocommerce-shipping-fields,
.style-dark .style-light .woocommerce-shipping-fields,
.style-light #payment,
.style-dark .style-light #payment,
.style-light .form-row.place-order,
.style-dark .style-light .form-row.place-order,
.style-light .woocommerce-form-login,
.style-dark .style-light .woocommerce-form-login,
.style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-number a,
.style-dark .style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-number a,
.style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-actions a,
.style-dark .style-light .woocommerce-MyAccount-content table.woocommerce-MyAccount-orders .woocommerce-orders-table__cell-order-actions a,
.style-light .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-product a,
.style-dark .style-light .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-product a,
.style-light .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-file a,
.style-dark .style-light .woocommerce-MyAccount-content table.woocommerce-table--order-downloads .download-file a,
.style-light .woocommerce-MyAccount-content table.account-payment-methods-table .payment-method-actions a,
.style-dark .style-light .woocommerce-MyAccount-content table.account-payment-methods-table .payment-method-actions a,
.style-light .woocommerce-Addresses,
.style-dark .style-light .woocommerce-Addresses,
.style-light .uncode-sidecart-wrapper li.mini_cart_item,
.style-dark .style-light .uncode-sidecart-wrapper li.mini_cart_item,
.style-light .uncode-sidecart-wrapper .woocommerce-mini-cart-header,
.style-dark .style-light .uncode-sidecart-wrapper .woocommerce-mini-cart-header {
  border-color: #eaeaea;
}
span.review-count {
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.style-dark .shop_table .shipping-calculator-button,
.style-light .style-dark .shop_table .shipping-calculator-button,
.style-dark .woocommerce-Address .edit,
.style-light .style-dark .woocommerce-Address .edit {
  border-color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
.style-light .shop_table .shipping-calculator-button,
.style-dark .style-light .shop_table .shipping-calculator-button,
.style-light .woocommerce-Address .edit,
.style-dark .style-light .woocommerce-Address .edit {
  border-color: <?php echo sanitize_text_field($color_text); ?>;
}
.style-dark .quantity .qty-inset,
.style-light .style-dark .quantity .qty-inset,
.style-dark .widget_price_filter .ui-slider .ui-slider-handle,
.style-light .style-dark .widget_price_filter .ui-slider .ui-slider-handle,
.style-dark .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-light .style-dark .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-dark .woocommerce-MyAccount-content > a.button,
.style-light .style-dark .woocommerce-MyAccount-content > a.button,
.style-dark .woocommerce-MyAccount-content p > a.button,
.style-light .style-dark .woocommerce-MyAccount-content p > a.button {
  background-color: #191b1e;
}
.style-light .quantity .qty-inset,
.style-dark .style-light .quantity .qty-inset,
.style-light .widget_price_filter .ui-slider .ui-slider-handle,
.style-dark .style-light .widget_price_filter .ui-slider .ui-slider-handle,
.style-light .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-dark .style-light .widget_price_filter .price_slider_wrapper .ui-widget-content,
.style-light .woocommerce-MyAccount-content > a.button,
.style-dark .style-light .woocommerce-MyAccount-content > a.button,
.style-light .woocommerce-MyAccount-content p > a.button,
.style-dark .style-light .woocommerce-MyAccount-content p > a.button {
  background-color: #f7f7f7;
}
.style-dark .woocommerce .woocommerce-breadcrumb a,
.style-light .style-dark .woocommerce .woocommerce-breadcrumb a,
.style-dark .woocommerce-review-link,
.style-light .style-dark .woocommerce-review-link {
  color: #ffffff;
}
.style-dark .woocommerce .woocommerce-breadcrumb a:hover,
.style-light .style-dark .woocommerce .woocommerce-breadcrumb a:hover,
.style-dark .woocommerce .woocommerce-breadcrumb a:focus,
.style-light .style-dark .woocommerce .woocommerce-breadcrumb a:focus,
.style-dark .woocommerce-review-link:hover,
.style-light .style-dark .woocommerce-review-link:hover,
.style-dark .woocommerce-review-link:focus,
.style-light .style-dark .woocommerce-review-link:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .woocommerce .woocommerce-breadcrumb a,
.style-dark .style-light .woocommerce .woocommerce-breadcrumb a,
.style-light .woocommerce-review-link,
.style-dark .style-light .woocommerce-review-link {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.style-light .woocommerce .woocommerce-breadcrumb a:hover,
.style-dark .style-light .woocommerce .woocommerce-breadcrumb a:hover,
.style-light .woocommerce .woocommerce-breadcrumb a:focus,
.style-dark .style-light .woocommerce .woocommerce-breadcrumb a:focus,
.style-light .woocommerce-review-link:hover,
.style-dark .style-light .woocommerce-review-link:hover,
.style-light .woocommerce-review-link:focus,
.style-dark .style-light .woocommerce-review-link:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.wc-forward,
.wc-forward a,
.wc-backward,
.woocommerce-MyAccount-content > a.button,
.woocommerce-MyAccount-content p > a.button,
.wc-backward {
  border-width: <?php echo sanitize_text_field($btn_border_width); ?>px;
}
.tmb-light.tmb-woocommerce span.price {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.tmb-dark.tmb-woocommerce span.price {
  color: #ffffff;
}
form.uncode-wc-form .style-dark p,
form.uncode-wc-form .style-light .style-dark p,
form.uncode-wc-form .style-dark #payment label,
form.uncode-wc-form .style-light .style-dark #payment label {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
form.uncode-wc-form .style-light p,
form.uncode-wc-form .style-dark .style-light p,
form.uncode-wc-form .style-light #payment label,
form.uncode-wc-form .style-dark .style-light #payment label {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.uncode-wc-checkout.order-table-with-thumbs.count-icon-no-accent .style-dark .woocommerce-checkout-review-order-table strong.product-quantity {
  background-color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.uncode-wc-checkout.order-table-with-thumbs.count-icon-no-accent .style-light .woocommerce-checkout-review-order-table strong.product-quantity {
  background-color: <?php echo sanitize_text_field($color_heading); ?>;
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.select2-results__options,
.select2-search--dropdown:after {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.select2-drop-active,
.select2-search input,
.select2-dropdown {
  border-color: #eaeaea !important;
}
.style-light .wc-backward,
.style-dark .style-light .wc-backward,
.style-light .wc-backward,
.style-dark .style-light .wc-backward {
  color: #ffffff !important;
  background-color: <?php echo sanitize_text_field($color_heading); ?> !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-light .wc-backward:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.style-dark .style-light .wc-backward:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.style-light .wc-backward.active,
.style-dark .style-light .wc-backward.active {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: transparent !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-dark .wc-backward,
.style-light .style-dark .wc-backward,
.style-dark .wc-backward,
.style-light .style-dark .wc-backward {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
.style-dark .wc-backward:not(.btn-hover-nobg):not(.icon-animated):hover,
.style-light .style-dark .wc-backward:not(.btn-hover-nobg):not(.icon-animated):hover,
.style-dark .wc-backward.active,
.style-light .style-dark .wc-backward.active {
  color: #ffffff !important;
  background-color: transparent !important;
  border-color: #ffffff !important;
}
.wc-backward,
.wc-backward {
  font-size: <?php echo sanitize_text_field($btn_font_size); ?>px;
}
.uncode-sidecart-wrapper .buttons a.wc-forward {
  font-size: <?php echo sanitize_text_field($btn_font_size); ?>px !important;
}
.wc-backward,
.uncode-sidecart-wrapper .buttons a.wc-forward.checkout,
.wc-backward {
  padding: <?php echo sanitize_text_field($btn_padding_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_lateral); ?>px !important;
}
.woocommerce-MyAccount-content > a.button,
.woocommerce-MyAccount-content p > a.button {
  font-size: <?php echo sanitize_text_field($btn_font_size); ?>px;
  padding: <?php echo sanitize_text_field($btn_padding_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_lateral); ?>px;
}
