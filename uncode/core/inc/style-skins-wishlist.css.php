/*
----------------------------------------------------------

#Skins-Wishlist

----------------------------------------------------------
*/
.mobile-wishlist-icon .badge,
.uncode-wishlist .badge,
.widget .items-count {
  background-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-dark .yith-wcwl-add-button .add_to_wishlist,
.style-light .style-dark .yith-wcwl-add-button .add_to_wishlist,
.style-dark .widget .items-counter,
.style-light .style-dark .widget .items-counter {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .yith-wcwl-add-button .add_to_wishlist,
.style-dark .style-light .yith-wcwl-add-button .add_to_wishlist,
.style-light .widget .items-counter,
.style-dark .style-light .widget .items-counter {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.uncode-wishlist .badge {
  font-weight: <?php echo sanitize_text_field($btn_font_weight); ?> !important;
}
