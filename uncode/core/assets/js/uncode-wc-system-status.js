(function($) {
	"use strict";
	/* global jQuery, uncode_woocommerce_system_status */

	var wc_pages_table = $('th[data-export-label="WC Pages"]').closest('table');
	var wc_pages_rows = wc_pages_table.find('tbody tr');
	var cart_row_cell = wc_pages_rows.eq(1).find('td:last-child');
	var checkout_row_cell = wc_pages_rows.eq(2).find('td:last-child');
	var myaccount_row_cell = wc_pages_rows.eq(3).find('td:last-child');

	check_shortcode(cart_row_cell, 'cart');
	check_shortcode(checkout_row_cell, 'checkout');
	check_shortcode(myaccount_row_cell, 'myaccount');

	function check_shortcode(row, type) {
		var mark = row.find('mark.error');
		var prop = type + '_page_shortcode';

		if (mark.length > 0 && uncode_woocommerce_system_status[prop].found === true) {
			mark.removeClass('error').addClass('yes').text(uncode_woocommerce_system_status[prop].mark);
		}
	}
})(jQuery);
