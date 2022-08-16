(function($) {
	"use strict";

	function refresh_wishlist_count() {
		if (window.wc_add_to_cart_params != undefined) {
			$.post({
				url: wc_add_to_cart_params.ajax_url,
				dataType: 'JSON',
				data: {
					action: 'get_wishlist_count_ajax'
				},
				success: function(data, textStatus, XMLHttpRequest) {
					if (data != '') {
						if ($('.uncode-wishlist .badge, .mobile-wishlist-icon .badge').length) {
							if (data.count > 0) {
								$('.uncode-wishlist .badge, .mobile-wishlist-icon .badge').html(data.count);
								$('.uncode-wishlist .badge, .mobile-wishlist-icon .badge').show();
							} else {
								$('.uncode-wishlist .badge, .mobile-wishlist-icon .badge').hide();
							}
						} else {
							$('.uncode-wishlist .wishlist-icon-container').append('<span class="badge">' + data.count + '</span>'); //
						}
					}
				}
			});
		}
	}

	function append_skin_to_popup() {
		if ($('.pp_pic_holder').length) {
			$('.pp_pic_holder').addClass('style-light');
		}
	}

	$(document).ready(function() {
		$(document).bind("yith_wcwl_init_after_ajax", refresh_wishlist_count);
		$(document).on("yith_wcwl_popup_opened", append_skin_to_popup);
	});
})(jQuery);
