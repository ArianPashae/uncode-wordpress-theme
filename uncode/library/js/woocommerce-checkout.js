(function($) {
	"use strict";

	/************************************************************
	 * Inject HTML classes when the checkout updates
	 ************************************************************/

	$(document.body).on('update_checkout', update_checkout_classes);
	$(document.body).on('updated_checkout', update_checkout_classes);

	function update_checkout_classes() {
		$('.uncode-wc-checkout').each(function() {
			var container = $(this);
			var order_review = container.find('.woocommerce-checkout-review-order');
			var injector_id = container.attr('data-id');
			var button = order_review.find('.checkout-button');

			if (typeof window['uncode_wc_checkout_injector_' + injector_id] !== 'undefined') {
				var injector = window['uncode_wc_checkout_injector_' + injector_id];

				button.removeClass('btn-default');
				button.removeClass('btn-hidden');
				button.addClass(injector['button'].join(" "));
			}
		});
	}

	/************************************************************
	 * When the login form is inside the main form, the real
	 * login form is appended at the end (outside the form).
	 * And the "form" tags are removed from the visible one.
	 * So we need to pass the values of the fake login form
	 * to the orginal one.
	 ************************************************************/


	var uncode_checkout_login_form = {
		init: function () {
			$(document.body).on('click', 'a.showlogin', this.show_login_form);
			$('div.woocommerce-form-login').find('button[type="submit"]').on('click', this.submit);
		},
		show_login_form: function () {
			$('div.login, div.woocommerce-form--login').slideToggle();
			return false;
		},
		submit: function () {
			var form = $(this).closest('div.woocommerce-form-login');
			var original_form = $('.uncode-wc-hidden-form--login').find('form');
			var inputs = form.find('input');

			inputs.each(function () {
				var _this = $(this);
				var _id = _this.attr('id');

				if (_id) {
					var original_id = _id.replace('uncode-wc-input-', '');
					var original_input = original_form.find('#' + original_id);

					if (original_input) {
						original_input.val(_this.val());

						if (_this.is(':checkbox')) {
							if (_this.prop('checked')) {
								original_input.prop('checked', true);
							} else {
								original_input.prop('checked', false);
							}
						}
					}
				}
			});

			original_form.find('button[type="submit"]').click();

			return false;
		}
	};

	/************************************************************
	 * When the coupon form is inside the main form, the "form"
	 * tags are removed. We can't have a form inside a form.
	 * So we need to adjust the submission.
	 ************************************************************/

	var uncode_checkout_coupons = {
		init: function () {
			$('a.showcoupon').off().on('click', this.show_coupon_form);
			$('div.woocommerce-form-coupon').find('button').on('click', this.submit);
		},
		show_coupon_form: function () {
			$('.checkout_coupon').slideToggle(400, function () {
				$('.checkout_coupon').find(':input:eq(0)').focus();
			});
			return false;
		},
		submit: function () {
			var $form = $(this).closest('div.woocommerce-form-coupon');

			if ($form.is('.processing')) {
				return false;
			}

			$form.addClass('processing').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				security: wc_checkout_params.apply_coupon_nonce,
				coupon_code: $form.find('input[name="coupon_code"]').val()
			};

			$.ajax({
				type: 'POST',
				url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon'),
				data: data,
				success: function (code) {
					$('.woocommerce-error, .woocommerce-message').remove();
					$form.removeClass('processing').unblock();

					if (code) {
						$form.before(code);
						$form.slideUp();

						$(document.body).trigger('applied_coupon_in_checkout', [ data.coupon_code ]);
						$(document.body).trigger('update_checkout', {update_shipping_method: false});
					}
				},
				dataType: 'html'
			});

			return false;
		}
	};

	var has_forms_inside = $('.uncode-wc-checkout--forms-inside').length > 0;

	if (has_forms_inside) {
		uncode_checkout_login_form.init();
		uncode_checkout_coupons.init();
		$(document.body).on('init_checkout', listen_for_checkout_init); // checkout init
	}

	$(document.body).on('update_checkout', listen_for_checkout_updates); // checkout updates
	$(document.body).on('checkout_error', listen_for_checkout_errors); // checkout errors

	/************************************************************
	 * Trigger some functions on checkout init.
	 ************************************************************/

	function listen_for_checkout_init() {
		append_legacy_notices_to_wrapper();
	}

	/************************************************************
	 * When the checkout updates, trigger some functions.
	 ************************************************************/

	function listen_for_checkout_updates() {
		append_notices_to_wrapper();
	}

	/************************************************************
	 * When there is a checkout error, trigger some functions.
	 ************************************************************/

	function listen_for_checkout_errors() {
		append_notices_to_wrapper();
	}

	/************************************************************
	 * Append notices to custom wrapper.
	 ************************************************************/

	function append_legacy_notices_to_wrapper() {
		var notices = $('.woocommerce-notices-wrapper');
		notices.remove();

		$('.uncode-wc-module__notices').append(notices);
	}

	function append_notices_to_wrapper() {
		var notices = $('.woocommerce-NoticeGroup, .wc-notice');

		notices.each(function() {
			var _this = $(this);
			var parent = _this.parent();

			if (parent.hasClass('woocommerce-form-login-toggle') || parent.hasClass('woocommerce-form-coupon-toggle')) {
				return;
			}

			_this.remove();
			$('.uncode-wc-module__notices').append(_this);
		});
	}

	/************************************************************
	 * Change mouse cursor during form submission.
	 ************************************************************/

	$('#order_review').on('submit', during_form_submit);
	$('form.checkout').on('submit', during_form_submit);

	$(document.body).on('updated_checkout', after_form_submit);
	$(document.body).on('checkout_error', after_form_submit);

	function during_form_submit() {
		$(document.body).addClass('uncode-woocommerce-form-submission');
		return true;
	}

	function after_form_submit() {
		$(document.body).removeClass('uncode-woocommerce-form-submission');
		return;
	}
})(jQuery);
