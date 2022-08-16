(function($) {
	"use strict";
	/* global UncodeCartParameters */

	/************************************************************
	 * Inject HTML classes when the cart totals updates
	 ************************************************************/

	$(document.body).on('updated_shipping_method', update_cart_totals_classes);

	function update_cart_totals_classes() {
		$('.uncode-wc-cart').each(function() {
			var container = $(this);
			var cart_totals = container.find('.cart_totals');
			var injector_id = container.attr('data-id');

			if (typeof window['uncode_wc_cart_injector_' + injector_id] !== 'undefined') {
				var injector = window['uncode_wc_cart_injector_' + injector_id];
				var title = cart_totals.find('h2');
				var button = cart_totals.find('.checkout-button');

				button.removeClass('btn-default');
				title.addClass(injector['title'].join(" "));
				button.addClass(injector['button'].join(" "));
			}
		});
	}

	/************************************************************
	 * Inject HTML classes when shipping calculator form is open
	 ************************************************************/

	$('.shipping-calculator-button').on('click', function () {
		var _this = $(this);
		var form = _this.closest('form');
		var container = _this.closest('.uncode-wc-cart');
		var button = form.find('button');
		var injector_id = container.attr('data-id');

		if (typeof window['uncode_wc_cart_injector_' + injector_id] !== 'undefined') {
			var injector = window['uncode_wc_cart_injector_' + injector_id];

			button.addClass(injector['derivated_button'].join(" "));
		}
	});

	/************************************************************
	 * Resize thumbs on mobile when we have the compact layout
	 ************************************************************/

	var cart_tables_compact = $('.uncode-wc-cart').find('table.cart.compact-layout');
	var needed_padding = 27;

	cart_tables_compact.each(function() {
		var _this = $(this),
			setCTA;

		calculate_els_height(_this);

		$(window).on( 'resize', function(){
			clearRequestTimeout(setCTA);
			setCTA = requestTimeout( function(){
				calculate_els_height(_this);
			}, 100 );
		});
	});

	function calculate_els_height(table) {
		var rows = table.find('tr.cart_item');

		rows.each(function() {
			var _this = $(this);
			var row_height = _this.outerHeight();
			var img_height = _this.find('td.product-thumbnail').find('img').outerHeight();
			var min_height = row_height - (needed_padding * 2);

			if (img_height > min_height) {
				var diff = img_height - min_height;

				_this.find('td.product-subtotal').css('padding-bottom', diff + needed_padding);
			}
		});
	}
})(jQuery);
