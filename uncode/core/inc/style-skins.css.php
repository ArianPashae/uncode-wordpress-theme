/*
----------------------------------------------------------
[Table of contents]

#Skins-General
#Skins-Buttons
#Skins-Alerts
#Skins-Menus
#Skins-Thumbs

----------------------------------------------------------
*/
/*
----------------------------------------------------------

#Skins-General

----------------------------------------------------------
*/
/* #GENERAL */
body {
  font-weight: <?php echo sanitize_text_field($cs_body_font_weight); ?>;
  font-family: <?php echo sanitize_text_field($font_family_base); ?>;
}
::selection {
  background: <?php echo sanitize_text_field($color_primary); ?>;
  color: #ffffff !important;
}
::-moz-selection {
  background: <?php echo sanitize_text_field($color_primary); ?>;
  color: #ffffff !important;
}
/* #Font-ui-fixed */
.font-ui-fixed,
.post-info,
.widget-container .widget-title,
#comments .comments-title,
#respond .comments-title,
#comments #reply-title,
#respond #reply-title,
.uncode-share h6 {
  font-family: <?php echo sanitize_text_field($font_family_ui); ?>;
  font-weight: <?php echo sanitize_text_field($ui_font_weight); ?>;
  letter-spacing: <?php echo sanitize_text_field($ui_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($ui_text_transform); ?>;
  font-size: <?php echo sanitize_text_field($ui_font_size); ?>px;
}
.font-ui,
#main-logo .text-logo,
.comment-content .comment-reply-link span,
.comment-content .comment-reply-link {
  font-family: <?php echo sanitize_text_field($font_family_ui); ?>;
  font-weight: <?php echo sanitize_text_field($ui_font_weight); ?>;
  letter-spacing: <?php echo sanitize_text_field($ui_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($ui_text_transform); ?>;
}
.filter-menu,
.isotope-filters ul.menu-smart a:not(.social-menu-link),
.isotope-filters .mobile-toggle-trigger:not(.social-menu-link),
.isotope-filters .extra-filters-wrapper .menu-smart > li > a:not(.social-menu-link),
.isotope-filters .uncode-woocommerce-sorting__link,
.isotope-filters .uncode-woocommerce-toggle-widgetized-cb__link {
  font-family: <?php echo sanitize_text_field($filter_menu_font_family); ?>;
  font-weight: <?php echo sanitize_text_field($filter_menu_font_weight); ?>;
  letter-spacing: <?php echo sanitize_text_field($filter_menu_letter_spacing); ?>;
  text-transform: uppercase;
  font-size: <?php echo sanitize_text_field($filter_menu_font_size); ?>px;
}
/* #Body-color-light */
.style-light {
  color: <?php echo sanitize_text_field($color_text); ?>;
}
/* #Body-color-dark */
.style-dark {
  color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
/* #Divider-break */
hr.separator-break {
  width: 90px;
  border-top-width: 2px;
}
hr.separator-break.separator-accent {
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
/* #Paragraph-color */
.style-dark .body-color,
.style-light .style-dark .body-color {
  color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
.style-light .body-color,
.style-dark .style-light .body-color {
  color: <?php echo sanitize_text_field($color_text); ?>;
}
.style-dark .body-color-light,
.style-light .style-dark .body-color-light {
  color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_text_inverted, 90 ) : sanitize_text_field($color_text_inverted); ?>;
}
.style-light .body-color-light,
.style-dark .style-light .body-color-light {
  color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field($color_text); ?>;
}
/* #Link-color */
.style-dark .link,
.style-light .style-dark .link,
.style-dark a,
.style-light .style-dark a,
.style-dark input[type=checkbox]:checked:before,
.style-light .style-dark input[type=checkbox]:checked:before {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .link,
.style-dark .style-light .link,
.style-light a,
.style-dark .style-light a,
.style-light input[type=checkbox]:checked:before,
.style-dark .style-light input[type=checkbox]:checked:before {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
/* #Link-color-hover */
.style-dark .link-hover,
.style-light .style-dark .link-hover,
.style-dark a:not(.btn-text-skin):hover,
.style-light .style-dark a:not(.btn-text-skin):hover,
.style-dark a:not(.btn-text-skin):focus,
.style-light .style-dark a:not(.btn-text-skin):focus,
.style-dark a.active,
.style-light .style-dark a.active,
.style-dark .tmb .t-entry-text .t-entry-title a:hover,
.style-light .style-dark .tmb .t-entry-text .t-entry-title a:hover,
.style-dark .tmb .t-entry-text .t-entry-title a:focus,
.style-light .style-dark .tmb .t-entry-text .t-entry-title a:focus,
.style-dark .tmb-content-under.tmb .t-entry p.t-entry-author a:hover span,
.style-light .style-dark .tmb-content-under.tmb .t-entry p.t-entry-author a:hover span,
.style-dark .tmb-content-lateral.tmb .t-entry p.t-entry-author a:hover span,
.style-light .style-dark .tmb-content-lateral.tmb .t-entry p.t-entry-author a:hover span,
.style-dark .tmb .t-entry p.t-entry-comments .extras a:hover i,
.style-light .style-dark .tmb .t-entry p.t-entry-comments .extras a:hover i,
.style-dark .tmb .t-entry p.t-entry-comments .extras a.active i,
.style-light .style-dark .tmb .t-entry p.t-entry-comments .extras a.active i,
.style-dark .tmb .t-entry p.t-entry-comments .extras a:focus i,
.style-light .style-dark .tmb .t-entry p.t-entry-comments .extras a:focus i,
.style-dark .widget_nav_menu li.active > a,
.style-light .style-dark .widget_nav_menu li.active > a,
.style-dark div[class*=sharer-].share-button label:hover,
.style-light .style-dark div[class*=sharer-].share-button label:hover,
.style-dark div[class*=sharer-].share-button label:focus,
.style-light .style-dark div[class*=sharer-].share-button label:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .link-hover,
.style-dark .style-light .link-hover,
.style-light a:not(.btn-text-skin):hover,
.style-dark .style-light a:not(.btn-text-skin):hover,
.style-light a:not(.btn-text-skin):focus,
.style-dark .style-light a:not(.btn-text-skin):focus,
.style-light a.active,
.style-dark .style-light a.active,
.style-light .tmb .t-entry-text .t-entry-title a:hover,
.style-dark .style-light .tmb .t-entry-text .t-entry-title a:hover,
.style-light .tmb .t-entry-text .t-entry-title a:focus,
.style-dark .style-light .tmb .t-entry-text .t-entry-title a:focus,
.style-light .tmb-content-under.tmb .t-entry p.t-entry-author a:hover span,
.style-dark .style-light .tmb-content-under.tmb .t-entry p.t-entry-author a:hover span,
.style-light .tmb-content-lateral.tmb .t-entry p.t-entry-author a:hover span,
.style-dark .style-light .tmb-content-lateral.tmb .t-entry p.t-entry-author a:hover span,
.style-light .tmb .t-entry p.t-entry-comments .extras a:hover i,
.style-dark .style-light .tmb .t-entry p.t-entry-comments .extras a:hover i,
.style-light .tmb .t-entry p.t-entry-comments .extras a.active i,
.style-dark .style-light .tmb .t-entry p.t-entry-comments .extras a.active i,
.style-light .tmb .t-entry p.t-entry-comments .extras a:focus i,
.style-dark .style-light .tmb .t-entry p.t-entry-comments .extras a:focus i,
.style-light .widget_nav_menu li.active > a,
.style-dark .style-light .widget_nav_menu li.active > a,
.style-light div[class*=sharer-].share-button label:hover,
.style-dark .style-light div[class*=sharer-].share-button label:hover,
.style-light div[class*=sharer-].share-button label:focus,
.style-dark .style-light div[class*=sharer-].share-button label:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
/* #Link-color-background */
.style-dark .link-bg,
.style-light .style-dark .link-bg {
  background-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .link-bg,
.style-dark .style-light .link-bg {
  background-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-dark .text-default-color,
.style-light .style-dark .text-default-color {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .text-default-color,
.style-dark .style-light .text-default-color {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.color-accent-border,
blockquote {
  border-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.color-accent-background,
mark,
.mejs-controls .mejs-time-rail .mejs-time-loaded {
  background-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.color-accent-color,
body.textual-accent-color .post-content > div p:not(.entry-small):not(.panel-title):not(.t-entry-member-social) a:not(.btn),
body.textual-accent-color .post-content > div ul:not(.menu-smart):not(.nav-tabs):not(.pagination) a:not(.btn),
body.textual-accent-color .post-content > div dt a:not(.btn),
body.textual-accent-color .post-content > div dd a:not(.btn),
body.textual-accent-color .post-content > div dl a:not(.btn),
body.textual-accent-color .post-content > div address a:not(.btn),
body.textual-accent-color .post-content > div label a:not(.btn),
body.textual-accent-color .post-content > div small a:not(.btn),
body.textual-accent-color .row-container .post-content p:not(.entry-small):not(.panel-title):not(.t-entry-member-social) a:not(.btn),
body.textual-accent-color .row-container .post-content ul:not(.menu-smart):not(.nav-tabs):not(.pagination) a:not(.btn),
body.textual-accent-color .row-container .post-content dt a:not(.btn),
body.textual-accent-color .row-container .post-content dd a:not(.btn),
body.textual-accent-color .row-container .post-content dl a:not(.btn),
body.textual-accent-color .row-container .post-content address a:not(.btn),
body.textual-accent-color .row-container .post-content label a:not(.btn),
body.textual-accent-color .row-container .post-content small a:not(.btn),
.wpcf7 .wpcf7-mail-sent-ok,
.wpcf7 .wpcf7-validation-errors,
.wpcf7 span.wpcf7-not-valid-tip,
.nav-tabs > li.active > a,
.panel-title.active > a,
.panel-title.active > a span:after,
.plan-accent.plan .plan-title > h3,
.plan-accent.plan .plan-price .price {
  color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.color-accent-darker,
body.textual-accent-color .post-content p:not(.entry-small):not(.panel-title):not(.t-entry-member-social) a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content p:not(.entry-small):not(.panel-title):not(.t-entry-member-social) a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content p:not(.entry-small):not(.panel-title):not(.t-entry-member-social) a.active:not(.btn),
body.textual-accent-color .post-content ul:not(.menu-smart):not(.nav-tabs):not(.pagination) a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content ul:not(.menu-smart):not(.nav-tabs):not(.pagination) a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content ul:not(.menu-smart):not(.nav-tabs):not(.pagination) a.active:not(.btn),
body.textual-accent-color .post-content dt a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content dt a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content dt a.active:not(.btn),
body.textual-accent-color .post-content dd a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content dd a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content dd a.active:not(.btn),
body.textual-accent-color .post-content dl a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content dl a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content dl a.active:not(.btn),
body.textual-accent-color .post-content address a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content address a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content address a.active:not(.btn),
body.textual-accent-color .post-content label a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content label a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content label a.active:not(.btn),
body.textual-accent-color .post-content small a:not(.btn-text-skin):hover:not(.btn),
body.textual-accent-color .post-content small a:not(.btn-text-skin):focus:not(.btn),
body.textual-accent-color .post-content small a.active:not(.btn) {
  color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_primary, -25 ) : sanitize_text_field($color_primary); ?> !important;
}
/* #Heading-style */
.headings-style,
h1,
h2,
h3,
h4,
h5,
h6,
.heading-text > p,
.tmb .t-entry .t-entry-cat,
.tmb .t-entry .t-entry-title,
:not(.enhanced-atc).tmb-woocommerce.tmb .t-entry-visual .add-to-cart-overlay a,
.author-details-data .author-heading span,
.vc_pie_chart .vc_pie_chart_value,
ul.dwls_search_results .daves-wordpress-live-search_title .search-title {
  letter-spacing: <?php echo sanitize_text_field($heading_letter_spacing); ?>em;
  font-weight: <?php echo sanitize_text_field($heading_font_weight); ?>;
  font-family: <?php echo sanitize_text_field($font_family_headings); ?>;
}
/* #Headings-color */
.style-dark .headings-color,
.style-light .style-dark .headings-color,
.style-dark .detail-container .detail-label,
.style-light .style-dark .detail-container .detail-label,
.style-dark h1,
.style-light .style-dark h1,
.style-dark h2,
.style-light .style-dark h2,
.style-dark h3,
.style-light .style-dark h3,
.style-dark h4,
.style-light .style-dark h4,
.style-dark h5,
.style-light .style-dark h5,
.style-dark h6,
.style-light .style-dark h6,
.style-dark .heading-text > p,
.style-light .style-dark .heading-text > p,
.style-dark p b,
.style-light .style-dark p b,
.style-dark p strong,
.style-light .style-dark p strong,
.style-dark dl dt,
.style-light .style-dark dl dt,
.style-dark dl.variation dt,
.style-light .style-dark dl.variation dt,
.style-dark dl.variation dd,
.style-light .style-dark dl.variation dd,
.style-dark blockquote p,
.style-light .style-dark blockquote p,
.style-dark table thead,
.style-light .style-dark table thead,
.style-dark form p,
.style-light .style-dark form p,
.style-dark .panel-title > a > span:after,
.style-light .style-dark .panel-title > a > span:after,
.style-dark .plan .plan-price .price,
.style-light .style-dark .plan .plan-price .price,
.style-dark .detail-label,
.style-light .style-dark .detail-label,
.style-dark .countdown,
.style-light .style-dark .countdown,
.style-dark .counter,
.style-light .style-dark .counter,
.style-dark .counter-suffix,
.style-light .style-dark .counter-suffix,
.style-dark .counter-prefix,
.style-light .style-dark .counter-prefix,
.style-dark .header-wrapper .header-scrolldown i,
.style-light .style-dark .header-wrapper .header-scrolldown i,
.style-dark .header-wrapper .header-content-inner blockquote.pullquote p:first-child,
.style-light .style-dark .header-wrapper .header-content-inner blockquote.pullquote p:first-child,
.style-dark .header-main-container .post-info,
.style-light .style-dark .header-main-container .post-info,
.style-dark .header-main-container .post-info a,
.style-light .style-dark .header-main-container .post-info a,
.style-dark .widget-container.widget_top_rated_products li:before,
.style-light .style-dark .widget-container.widget_top_rated_products li:before,
.style-dark .widget-container.widget_recent_reviews li:before,
.style-light .style-dark .widget-container.widget_recent_reviews li:before,
.style-dark .widget-container.widget_latest_tweets_widget .tweet-text:before,
.style-light .style-dark .widget-container.widget_latest_tweets_widget .tweet-text:before,
.style-dark .widget-container.widget_latest_tweets .tweet-text:before,
.style-light .style-dark .widget-container.widget_latest_tweets .tweet-text:before,
.style-dark .comment-content .comment-author a,
.style-light .style-dark .comment-content .comment-author a,
.style-dark .comment-content .comment-author span,
.style-light .style-dark .comment-content .comment-author span,
.style-dark .author-details-data .author-name a,
.style-light .style-dark .author-details-data .author-name a,
.style-dark div[class*=sharer-].share-button label,
.style-light .style-dark div[class*=sharer-].share-button label,
.style-dark .share-button.share-inline .social.top li,
.style-light .style-dark .share-button.share-inline .social.top li,
.style-dark .vc_progress_bar .vc_progress_label,
.style-light .style-dark .vc_progress_bar .vc_progress_label,
.style-dark .vc_pie_chart .vc_pie_chart_value,
.style-light .style-dark .vc_pie_chart .vc_pie_chart_value,
.style-dark ul.dwls_search_results .daves-wordpress-live-search_title .search-title,
.style-light .style-dark ul.dwls_search_results .daves-wordpress-live-search_title .search-title,
.style-dark ul.dwls_search_results .daves-wordpress-live-search_author,
.style-light .style-dark ul.dwls_search_results .daves-wordpress-live-search_author {
  color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .headings-color,
.style-dark .style-light .headings-color,
.style-light .detail-container .detail-label,
.style-dark .style-light .detail-container .detail-label,
.style-light h1,
.style-dark .style-light h1,
.style-light h2,
.style-dark .style-light h2,
.style-light h3,
.style-dark .style-light h3,
.style-light h4,
.style-dark .style-light h4,
.style-light h5,
.style-dark .style-light h5,
.style-light h6,
.style-dark .style-light h6,
.style-light .heading-text > p,
.style-dark .style-light .heading-text > p,
.style-light p b,
.style-dark .style-light p b,
.style-light p strong,
.style-dark .style-light p strong,
.style-light dl dt,
.style-dark .style-light dl dt,
.style-light dl.variation dt,
.style-dark .style-light dl.variation dt,
.style-light dl.variation dd,
.style-dark .style-light dl.variation dd,
.style-light blockquote p,
.style-dark .style-light blockquote p,
.style-light table thead,
.style-dark .style-light table thead,
.style-light form p,
.style-dark .style-light form p,
.style-light .panel-title > a > span:after,
.style-dark .style-light .panel-title > a > span:after,
.style-light .plan .plan-price .price,
.style-dark .style-light .plan .plan-price .price,
.style-light .detail-label,
.style-dark .style-light .detail-label,
.style-light .countdown,
.style-dark .style-light .countdown,
.style-light .counter,
.style-dark .style-light .counter,
.style-light .counter-suffix,
.style-dark .style-light .counter-suffix,
.style-light .counter-prefix,
.style-dark .style-light .counter-prefix,
.style-light .header-wrapper .header-scrolldown i,
.style-dark .style-light .header-wrapper .header-scrolldown i,
.style-light .header-wrapper .header-content-inner blockquote.pullquote p:first-child,
.style-dark .style-light .header-wrapper .header-content-inner blockquote.pullquote p:first-child,
.style-light .header-main-container .post-info,
.style-dark .style-light .header-main-container .post-info,
.style-light .header-main-container .post-info a,
.style-dark .style-light .header-main-container .post-info a,
.style-light .widget-container.widget_top_rated_products li:before,
.style-dark .style-light .widget-container.widget_top_rated_products li:before,
.style-light .widget-container.widget_recent_reviews li:before,
.style-dark .style-light .widget-container.widget_recent_reviews li:before,
.style-light .widget-container.widget_latest_tweets_widget .tweet-text:before,
.style-dark .style-light .widget-container.widget_latest_tweets_widget .tweet-text:before,
.style-light .widget-container.widget_latest_tweets .tweet-text:before,
.style-dark .style-light .widget-container.widget_latest_tweets .tweet-text:before,
.style-light .comment-content .comment-author a,
.style-dark .style-light .comment-content .comment-author a,
.style-light .comment-content .comment-author span,
.style-dark .style-light .comment-content .comment-author span,
.style-light .author-details-data .author-name a,
.style-dark .style-light .author-details-data .author-name a,
.style-light div[class*=sharer-].share-button label,
.style-dark .style-light div[class*=sharer-].share-button label,
.style-light .share-button.share-inline .social.top li,
.style-dark .style-light .share-button.share-inline .social.top li,
.style-light .vc_progress_bar .vc_progress_label,
.style-dark .style-light .vc_progress_bar .vc_progress_label,
.style-light .vc_pie_chart .vc_pie_chart_value,
.style-dark .style-light .vc_pie_chart .vc_pie_chart_value,
.style-light ul.dwls_search_results .daves-wordpress-live-search_title .search-title,
.style-dark .style-light ul.dwls_search_results .daves-wordpress-live-search_title .search-title,
.style-light ul.dwls_search_results .daves-wordpress-live-search_author,
.style-dark .style-light ul.dwls_search_results .daves-wordpress-live-search_author {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.style-dark .headings-bg,
.style-light .style-dark .headings-bg,
.style-dark input[type=radio]:checked:before,
.style-light .style-dark input[type=radio]:checked:before {
  background-color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .headings-bg,
.style-dark .style-light .headings-bg,
.style-light input[type=radio]:checked:before,
.style-dark .style-light input[type=radio]:checked:before {
  background-color: <?php echo sanitize_text_field($color_heading); ?>;
}
/* #Button-style */
.buttons-style,
input[type="submit"]:not(.btn-custom-typo):not(.btn-inherit),
input[type="reset"]:not(.btn-custom-typo):not(.btn-inherit),
input[type="button"]:not(.btn-custom-typo):not(.btn-inherit),
button[type="submit"]:not(.btn-custom-typo):not(.btn-inherit),
.btn:not(.btn-custom-typo):not(.btn-inherit),
.btn-link:not(.btn-custom-typo):not(.btn-inherit),
.tab-container:not(.default-typography) .nav-tabs,
.uncode-accordion:not(.default-typography) .panel-title > a > span,
.enhanced-atc.tmb-woocommerce.tmb .t-entry-visual .add-to-cart-overlay a,
.search_footer {
  font-weight: <?php echo sanitize_text_field($btn_font_weight); ?> !important;
  font-family: <?php echo sanitize_text_field($font_family_btn); ?> !important;
  letter-spacing: <?php echo sanitize_text_field($btn_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($btn_text_transform); ?>;
}
.btn-inherit {
  font-family: inherit !important;
  letter-spacing: <?php echo sanitize_text_field($btn_letter_spacing); ?>;
  text-transform: <?php echo sanitize_text_field($btn_text_transform); ?>;
}
.btn-inherit:not([class*="font-weight-"]) {
  font-weight: <?php echo sanitize_text_field($cs_body_font_weight); ?> !important;
}
.tmb-woocommerce.tmb .t-entry-visual .add-to-cart-overlay a.default-typography {
  font-weight: 500 !important;
  font-family: inherit !important;
  letter-spacing: inherit !important;
}
/* #Button-weight */
.buttons-weight {
  font-weight: <?php echo sanitize_text_field($btn_font_weight); ?> !important;
}
/* #Font-Serif */
.serif-family,
.post-content .post-media blockquote.pullquote p:first-child,
.tmb-entry-title-serif.tmb .t-entry .t-entry-title,
.isotope-system .isotope-container .tmb .regular-text .pullquote p:first-child,
.isotope-system .isotope-container .tmb .fluid-object.tweet .twitter-footer span {
  font-family: Georgia, "Times New Roman", Times, serif;
}
/* #UI-border-width */
.ui-br-w,
input:focus,
textarea:focus,
select:focus,
input[type="submit"],
input[type="reset"],
input[type="button"],
button[type="submit"] {
  border-width: <?php echo sanitize_text_field($btn_border_width); ?>px;
}
/* #UI-border-color */
.style-dark .ui-br,
.style-light .style-dark .ui-br,
.style-dark hr,
.style-light .style-dark hr,
.style-dark pre,
.style-light .style-dark pre,
.style-dark table,
.style-light .style-dark table,
.style-dark table td,
.style-light .style-dark table td,
.style-dark table th,
.style-light .style-dark table th,
.style-dark input,
.style-light .style-dark input,
.style-dark textarea,
.style-light .style-dark textarea,
.style-dark select,
.style-light .style-dark select,
.style-dark .seldiv,
.style-light .style-dark .seldiv,
.style-dark .select2-choice,
.style-light .style-dark .select2-choice,
.style-dark .select2-selection--single,
.style-light .style-dark .select2-selection--single,
.style-dark fieldset,
.style-light .style-dark fieldset,
.style-dark .seldiv:before,
.style-light .style-dark .seldiv:before,
.style-dark .tab-container .nav-tabs,
.style-light .style-dark .tab-container .nav-tabs,
.style-dark .nav-tabs > li.active > a,
.style-light .style-dark .nav-tabs > li.active > a,
.style-dark .border-100 .tab-content::before,
.style-light .style-dark .border-100 .tab-content::before,
.style-dark .vertical-tab-menu .nav-tabs,
.style-light .style-dark .vertical-tab-menu .nav-tabs,
.style-dark .tab-content.vertical,
.style-light .style-dark .tab-content.vertical,
.style-dark .panel,
.style-light .style-dark .panel,
.style-dark .panel-group .panel-heading + .panel-collapse .panel-body,
.style-light .style-dark .panel-group .panel-heading + .panel-collapse .panel-body,
.style-dark .divider:before,
.style-light .style-dark .divider:before,
.style-dark .divider:after,
.style-light .style-dark .divider:after,
.style-dark .plan,
.style-light .style-dark .plan,
.style-dark .plan .plan-title,
.style-light .style-dark .plan .plan-title,
.style-dark .plan .item-list > li,
.style-light .style-dark .plan .item-list > li,
.style-dark .plan .plan-button,
.style-light .style-dark .plan .plan-button,
.style-dark .uncode-single-media-wrapper.img-thumbnail:not(.single-advanced),
.style-light .style-dark .uncode-single-media-wrapper.img-thumbnail:not(.single-advanced),
.style-dark .post-share,
.style-light .style-dark .post-share,
.style-dark .post-tag-share-container,
.style-light .style-dark .post-tag-share-container,
.style-dark .widget-container .widget-title,
.style-light .style-dark .widget-container .widget-title,
.style-dark .widget-container .tagcloud a,
.style-light .style-dark .widget-container .tagcloud a,
.style-dark .widget-container.widget_calendar #wp-calendar caption,
.style-light .style-dark .widget-container.widget_calendar #wp-calendar caption,
.style-dark .widget-container.widget_calendar .wp-calendar-nav,
.style-light .style-dark .widget-container.widget_calendar .wp-calendar-nav,
.style-dark .widget-collapse-content:after,
.style-light .style-dark .widget-collapse-content:after,
.style-dark #comments .comment-list .comments-list:first-child,
.style-light .style-dark #comments .comment-list .comments-list:first-child,
.style-dark #respond .comment-list .comments-list:first-child,
.style-light .style-dark #respond .comment-list .comments-list:first-child,
.style-dark #comments .comments-list .comment-content,
.style-light .style-dark #comments .comments-list .comment-content,
.style-dark #respond .comments-list .comment-content,
.style-light .style-dark #respond .comments-list .comment-content,
.style-dark .author-details,
.style-light .style-dark .author-details,
.style-dark ul.dwls_search_results,
.style-light .style-dark ul.dwls_search_results,
.style-dark ul.dwls_search_results li,
.style-light .style-dark ul.dwls_search_results li {
  border-color: rgba(255, 255, 255, 0.25);
}
.style-light .ui-br,
.style-dark .style-light .ui-br,
.style-light hr,
.style-dark .style-light hr,
.style-light pre,
.style-dark .style-light pre,
.style-light table,
.style-dark .style-light table,
.style-light table td,
.style-dark .style-light table td,
.style-light table th,
.style-dark .style-light table th,
.style-light input,
.style-dark .style-light input,
.style-light textarea,
.style-dark .style-light textarea,
.style-light select,
.style-dark .style-light select,
.style-light .seldiv,
.style-dark .style-light .seldiv,
.style-light .select2-choice,
.style-dark .style-light .select2-choice,
.style-light .select2-selection--single,
.style-dark .style-light .select2-selection--single,
.style-light fieldset,
.style-dark .style-light fieldset,
.style-light .seldiv:before,
.style-dark .style-light .seldiv:before,
.style-light .tab-container .nav-tabs,
.style-dark .style-light .tab-container .nav-tabs,
.style-light .nav-tabs > li.active > a,
.style-dark .style-light .nav-tabs > li.active > a,
.style-light .border-100 .tab-content::before,
.style-dark .style-light .border-100 .tab-content::before,
.style-light .vertical-tab-menu .nav-tabs,
.style-dark .style-light .vertical-tab-menu .nav-tabs,
.style-light .tab-content.vertical,
.style-dark .style-light .tab-content.vertical,
.style-light .panel,
.style-dark .style-light .panel,
.style-light .panel-group .panel-heading + .panel-collapse .panel-body,
.style-dark .style-light .panel-group .panel-heading + .panel-collapse .panel-body,
.style-light .divider:before,
.style-dark .style-light .divider:before,
.style-light .divider:after,
.style-dark .style-light .divider:after,
.style-light .plan,
.style-dark .style-light .plan,
.style-light .plan .plan-title,
.style-dark .style-light .plan .plan-title,
.style-light .plan .item-list > li,
.style-dark .style-light .plan .item-list > li,
.style-light .plan .plan-button,
.style-dark .style-light .plan .plan-button,
.style-light .uncode-single-media-wrapper.img-thumbnail:not(.single-advanced),
.style-dark .style-light .uncode-single-media-wrapper.img-thumbnail:not(.single-advanced),
.style-light .post-share,
.style-dark .style-light .post-share,
.style-light .post-tag-share-container,
.style-dark .style-light .post-tag-share-container,
.style-light .widget-container .widget-title,
.style-dark .style-light .widget-container .widget-title,
.style-light .widget-container .tagcloud a,
.style-dark .style-light .widget-container .tagcloud a,
.style-light .widget-container.widget_calendar #wp-calendar caption,
.style-dark .style-light .widget-container.widget_calendar #wp-calendar caption,
.style-light .widget-container.widget_calendar .wp-calendar-nav,
.style-dark .style-light .widget-container.widget_calendar .wp-calendar-nav,
.style-light .widget-collapse-content:after,
.style-dark .style-light .widget-collapse-content:after,
.style-light #comments .comment-list .comments-list:first-child,
.style-dark .style-light #comments .comment-list .comments-list:first-child,
.style-light #respond .comment-list .comments-list:first-child,
.style-dark .style-light #respond .comment-list .comments-list:first-child,
.style-light #comments .comments-list .comment-content,
.style-dark .style-light #comments .comments-list .comment-content,
.style-light #respond .comments-list .comment-content,
.style-dark .style-light #respond .comments-list .comment-content,
.style-light .author-details,
.style-dark .style-light .author-details,
.style-light ul.dwls_search_results,
.style-dark .style-light ul.dwls_search_results,
.style-light ul.dwls_search_results li,
.style-dark .style-light ul.dwls_search_results li {
  border-color: #eaeaea;
}
.style-light input[type=radio],
.style-dark .style-light input[type=radio] {
  border-color: #eaeaea;
}
.style-dark input[type=radio],
.style-light .style-dark input[type=radio] {
  border-color: rgba(255, 255, 255, 0.5);
}
/* #UI-border-color-accent */
.ui-br-accent,
.nav-tabs > li.active > a,
.tabs-left > li.active > a {
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
/* break */
.style-dark .ui-br-break,
.style-light .style-dark .ui-br-break,
.style-dark hr.separator-break,
.style-light .style-dark hr.separator-break {
  border-color: #ffffff;
}
.style-light .ui-br-break,
.style-dark .style-light .ui-br-break,
.style-light hr.separator-break,
.style-dark .style-light hr.separator-break {
  border-color: #eaeaea;
}
/* #UI-border-headings-color */
.style-dark .ui-br-headings,
.style-light .style-dark .ui-br-headings,
.style-dark .header-content hr,
.style-light .style-dark .header-content hr {
  border-color: #ffffff;
}
.style-light .ui-br-headings,
.style-dark .style-light .ui-br-headings,
.style-light .header-content hr,
.style-dark .style-light .header-content hr {
  border-color: <?php echo sanitize_text_field($color_heading); ?>;
}
/* #UI-border-underline-color */
.input-background .style-dark .input-underline .ui-br-underline,
.input-background .input-underline .style-dark .ui-br-underline,
.input-background .style-light .style-dark .input-underline .ui-br-underline,
.input-background .style-light .input-underline .style-dark .ui-br-underline,
.input-background .style-dark .input-underline input[type="text"],
.input-background .input-underline .style-dark input[type="text"],
.input-background .style-light .style-dark .input-underline input[type="text"],
.input-background .style-light .input-underline .style-dark input[type="text"],
.input-background .style-dark .input-underline input[type="email"],
.input-background .input-underline .style-dark input[type="email"],
.input-background .style-light .style-dark .input-underline input[type="email"],
.input-background .style-light .input-underline .style-dark input[type="email"],
.input-background .style-dark .input-underline input[type="number"],
.input-background .input-underline .style-dark input[type="number"],
.input-background .style-light .style-dark .input-underline input[type="number"],
.input-background .style-light .input-underline .style-dark input[type="number"],
.input-background .style-dark .input-underline input[type="url"],
.input-background .input-underline .style-dark input[type="url"],
.input-background .style-light .style-dark .input-underline input[type="url"],
.input-background .style-light .input-underline .style-dark input[type="url"],
.input-background .style-dark .input-underline input[type="tel"],
.input-background .input-underline .style-dark input[type="tel"],
.input-background .style-light .style-dark .input-underline input[type="tel"],
.input-background .style-light .input-underline .style-dark input[type="tel"],
.input-background .style-dark .input-underline input[type="search"],
.input-background .input-underline .style-dark input[type="search"],
.input-background .style-light .style-dark .input-underline input[type="search"],
.input-background .style-light .input-underline .style-dark input[type="search"],
.input-background .style-dark .input-underline input[type="password"],
.input-background .input-underline .style-dark input[type="password"],
.input-background .style-light .style-dark .input-underline input[type="password"],
.input-background .style-light .input-underline .style-dark input[type="password"],
.input-background .style-dark .input-underline input[type="date"],
.input-background .input-underline .style-dark input[type="date"],
.input-background .style-light .style-dark .input-underline input[type="date"],
.input-background .style-light .input-underline .style-dark input[type="date"],
.input-background .style-dark .input-underline textarea,
.input-background .input-underline .style-dark textarea,
.input-background .style-light .style-dark .input-underline textarea,
.input-background .style-light .input-underline .style-dark textarea,
.input-background .style-dark .input-underline select,
.input-background .input-underline .style-dark select,
.input-background .style-light .style-dark .input-underline select,
.input-background .style-light .input-underline .style-dark select,
.input-background .style-dark .input-underline .select2-selection--single,
.input-background .input-underline .style-dark .select2-selection--single,
.input-background .style-light .style-dark .input-underline .select2-selection--single,
.input-background .style-light .input-underline .style-dark .select2-selection--single {
  border-bottom: 1px solid rgba(255, 255, 255, 0.25);
}
.input-background .style-light .input-underline .ui-br-underline,
.input-background .input-underline .style-light .ui-br-underline,
.input-background .style-dark .style-light .input-underline .ui-br-underline,
.input-background .style-dark .input-underline .style-light .ui-br-underline,
.input-background .style-light .input-underline input[type="text"],
.input-background .input-underline .style-light input[type="text"],
.input-background .style-dark .style-light .input-underline input[type="text"],
.input-background .style-dark .input-underline .style-light input[type="text"],
.input-background .style-light .input-underline input[type="email"],
.input-background .input-underline .style-light input[type="email"],
.input-background .style-dark .style-light .input-underline input[type="email"],
.input-background .style-dark .input-underline .style-light input[type="email"],
.input-background .style-light .input-underline input[type="number"],
.input-background .input-underline .style-light input[type="number"],
.input-background .style-dark .style-light .input-underline input[type="number"],
.input-background .style-dark .input-underline .style-light input[type="number"],
.input-background .style-light .input-underline input[type="url"],
.input-background .input-underline .style-light input[type="url"],
.input-background .style-dark .style-light .input-underline input[type="url"],
.input-background .style-dark .input-underline .style-light input[type="url"],
.input-background .style-light .input-underline input[type="tel"],
.input-background .input-underline .style-light input[type="tel"],
.input-background .style-dark .style-light .input-underline input[type="tel"],
.input-background .style-dark .input-underline .style-light input[type="tel"],
.input-background .style-light .input-underline input[type="search"],
.input-background .input-underline .style-light input[type="search"],
.input-background .style-dark .style-light .input-underline input[type="search"],
.input-background .style-dark .input-underline .style-light input[type="search"],
.input-background .style-light .input-underline input[type="password"],
.input-background .input-underline .style-light input[type="password"],
.input-background .style-dark .style-light .input-underline input[type="password"],
.input-background .style-dark .input-underline .style-light input[type="password"],
.input-background .style-light .input-underline input[type="date"],
.input-background .input-underline .style-light input[type="date"],
.input-background .style-dark .style-light .input-underline input[type="date"],
.input-background .style-dark .input-underline .style-light input[type="date"],
.input-background .style-light .input-underline textarea,
.input-background .input-underline .style-light textarea,
.input-background .style-dark .style-light .input-underline textarea,
.input-background .style-dark .input-underline .style-light textarea,
.input-background .style-light .input-underline select,
.input-background .input-underline .style-light select,
.input-background .style-dark .style-light .input-underline select,
.input-background .style-dark .input-underline .style-light select,
.input-background .style-light .input-underline .select2-selection--single,
.input-background .input-underline .style-light .select2-selection--single,
.input-background .style-dark .style-light .input-underline .select2-selection--single,
.input-background .style-dark .input-underline .style-light .select2-selection--single {
  border-bottom: 1px solid #eaeaea;
}
/* #UI-border-color-darker */
.style-dark .ui-br-darker,
.style-light .style-dark .ui-br-darker {
  border-color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
.style-light .ui-br-darker,
.style-dark .style-light .ui-br-darker {
  border-color: <?php echo sanitize_text_field($color_text); ?>;
}
/* #UI-background-color */
.style-dark .ui-bg,
.style-light .style-dark .ui-bg,
.style-dark code,
.style-light .style-dark code,
.style-dark kbd,
.style-light .style-dark kbd,
.style-dark pre,
.style-light .style-dark pre,
.style-dark samp,
.style-light .style-dark samp,
.style-dark input[type="submit"],
.style-light .style-dark input[type="submit"],
.style-dark input[type="reset"],
.style-light .style-dark input[type="reset"],
.style-dark input[type="button"],
.style-light .style-dark input[type="button"],
.style-dark button[type="submit"],
.style-light .style-dark button[type="submit"],
.style-dark .divider .divider-icon,
.style-light .style-dark .divider .divider-icon {
  background-color: #191b1e;
}
.style-light .ui-bg,
.style-dark .style-light .ui-bg,
.style-light code,
.style-dark .style-light code,
.style-light kbd,
.style-dark .style-light kbd,
.style-light pre,
.style-dark .style-light pre,
.style-light samp,
.style-dark .style-light samp,
.style-light input[type="submit"],
.style-dark .style-light input[type="submit"],
.style-light input[type="reset"],
.style-dark .style-light input[type="reset"],
.style-light input[type="button"],
.style-dark .style-light input[type="button"],
.style-light button[type="submit"],
.style-dark .style-light button[type="submit"],
.style-light .divider .divider-icon,
.style-dark .style-light .divider .divider-icon {
  background-color: #f7f7f7;
}
/* #UI-background-color-alpha */
.style-dark .ui-bg-alpha,
.style-light .style-dark .ui-bg-alpha,
.style-dark .plan,
.style-light .style-dark .plan {
  background-color: rgba(26, 27, 28, 0.5);
}
.style-light .ui-bg-alpha,
.style-dark .style-light .ui-bg-alpha,
.style-light .plan,
.style-dark .style-light .plan {
  background-color: #ffffff;
}
.style-dark .ui-bg-alpha-pricing-tables,
.style-light .style-dark .ui-bg-alpha-pricing-tables {
  background-color: rgba(20, 22, 24, 0.5);
}
.style-light .ui-bg-alpha-pricing-tables,
.style-dark .style-light .ui-bg-alpha-pricing-tables {
  background-color: #ffffff;
}
.style-dark .ui-bg-alpha-progress-bar,
.style-light .style-dark .ui-bg-alpha-progress-bar,
.style-dark .vc_progress_bar .vc_single_bar:not(.style-override),
.style-light .style-dark .vc_progress_bar .vc_single_bar:not(.style-override) {
  background-color: rgba(255, 255, 255, 0.2);
}
.style-light .ui-bg-alpha-progress-bar,
.style-dark .style-light .ui-bg-alpha-progress-bar,
.style-light .vc_progress_bar .vc_single_bar:not(.style-override),
.style-dark .style-light .vc_progress_bar .vc_single_bar:not(.style-override) {
  background-color: rgba(119, 119, 119, 0.1);
}
.style-dark .ui-text-alpha-progress-bar,
.style-light .style-dark .ui-text-alpha-progress-bar,
.style-dark .vc_pie_chart_back,
.style-light .style-dark .vc_pie_chart_back {
  color: rgba(255, 255, 255, 0.2);
}
.style-light .ui-text-alpha-progress-bar,
.style-dark .style-light .ui-text-alpha-progress-bar,
.style-light .vc_pie_chart_back,
.style-dark .style-light .vc_pie_chart_back {
  color: rgba(119, 119, 119, 0.1);
}
.style-dark .ui-bg-dots,
.style-light .style-dark .ui-bg-dots,
.style-dark .owl-dots-outside .owl-dots .owl-dot span,
.style-light .style-dark .owl-dots-outside .owl-dots .owl-dot span {
  background-color: rgba(247, 247, 247, 0.75);
}
.style-light .ui-bg-dots,
.style-dark .style-light .ui-bg-dots,
.style-light .owl-dots-outside .owl-dots .owl-dot span,
.style-dark .style-light .owl-dots-outside .owl-dots .owl-dot span {
  background-color: rgba(25, 27, 30, 0.25);
}
/* #UI-background-color */
/* #UI-background-color-active */
/* #UI-link-color */
.style-dark .ui-link,
.style-light .style-dark .ui-link,
.style-dark .nav-tabs > li > a,
.style-light .style-dark .nav-tabs > li > a,
.style-dark .panel-title > a,
.style-light .style-dark .panel-title > a,
.style-dark .widget-container a,
.style-light .style-dark .widget-container a {
  color: #ffffff;
}
.style-dark .ui-link:hover,
.style-light .style-dark .ui-link:hover,
.style-dark .ui-link:focus,
.style-light .style-dark .ui-link:focus,
.style-dark .nav-tabs > li > a:hover,
.style-light .style-dark .nav-tabs > li > a:hover,
.style-dark .nav-tabs > li > a:focus,
.style-light .style-dark .nav-tabs > li > a:focus,
.style-dark .panel-title > a:hover,
.style-light .style-dark .panel-title > a:hover,
.style-dark .panel-title > a:focus,
.style-light .style-dark .panel-title > a:focus,
.style-dark .widget-container a:hover,
.style-light .style-dark .widget-container a:hover,
.style-dark .widget-container a:focus,
.style-light .style-dark .widget-container a:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .ui-link,
.style-dark .style-light .ui-link,
.style-light .nav-tabs > li > a,
.style-dark .style-light .nav-tabs > li > a,
.style-light .panel-title > a,
.style-dark .style-light .panel-title > a,
.style-light .widget-container a,
.style-dark .style-light .widget-container a {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.style-light .ui-link:hover,
.style-dark .style-light .ui-link:hover,
.style-light .ui-link:focus,
.style-dark .style-light .ui-link:focus,
.style-light .nav-tabs > li > a:hover,
.style-dark .style-light .nav-tabs > li > a:hover,
.style-light .nav-tabs > li > a:focus,
.style-dark .style-light .nav-tabs > li > a:focus,
.style-light .panel-title > a:hover,
.style-dark .style-light .panel-title > a:hover,
.style-light .panel-title > a:focus,
.style-dark .style-light .panel-title > a:focus,
.style-light .widget-container a:hover,
.style-dark .style-light .widget-container a:hover,
.style-light .widget-container a:focus,
.style-dark .style-light .widget-container a:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
/* #UI-link-color-text */
.style-dark .ui-text,
.style-light .style-dark .ui-text,
.style-dark .breadcrumb,
.style-light .style-dark .breadcrumb,
.style-dark .post-info,
.style-light .style-dark .post-info {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_dark); ?>;
}
.style-light .ui-text,
.style-dark .style-light .ui-text,
.style-light .breadcrumb,
.style-dark .style-light .breadcrumb,
.style-light .post-info,
.style-dark .style-light .post-info {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_light); ?>;
}
.style-dark .ui-link-text,
.style-light .style-dark .ui-link-text,
.style-dark .breadcrumb > li a,
.style-light .style-dark .breadcrumb > li a,
.style-dark .post-info a,
.style-light .style-dark .post-info a {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_dark); ?>;
}
.style-dark .ui-link-text:hover,
.style-light .style-dark .ui-link-text:hover,
.style-dark .ui-link-text:focus,
.style-light .style-dark .ui-link-text:focus,
.style-dark .breadcrumb > li a:hover,
.style-light .style-dark .breadcrumb > li a:hover,
.style-dark .breadcrumb > li a:focus,
.style-light .style-dark .breadcrumb > li a:focus,
.style-dark .post-info a:hover,
.style-light .style-dark .post-info a:hover,
.style-dark .post-info a:focus,
.style-light .style-dark .post-info a:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light .ui-link-text,
.style-dark .style-light .ui-link-text,
.style-light .breadcrumb > li a,
.style-dark .style-light .breadcrumb > li a,
.style-light .post-info a,
.style-dark .style-light .post-info a {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_light); ?>;
}
.style-light .ui-link-text:hover,
.style-dark .style-light .ui-link-text:hover,
.style-light .ui-link-text:focus,
.style-dark .style-light .ui-link-text:focus,
.style-light .breadcrumb > li a:hover,
.style-dark .style-light .breadcrumb > li a:hover,
.style-light .breadcrumb > li a:focus,
.style-dark .style-light .breadcrumb > li a:focus,
.style-light .post-info a:hover,
.style-dark .style-light .post-info a:hover,
.style-light .post-info a:focus,
.style-dark .style-light .post-info a:focus {
  color: <?php echo sanitize_text_field($color_primary); ?>;
}
/* #Pre-and-code */
.style-dark .ui-inverted,
.style-light .style-dark .ui-inverted {
  color: #191b1e;
  background-color: #f7f7f7;
}
.style-light .ui-inverted,
.style-dark .style-light .ui-inverted {
  color: #f7f7f7;
  background-color: #191b1e;
}
/* #Button-social-color */
.style-dark .btn-social,
.style-light .style-dark .btn-social {
  color: #ffffff !important;
}
.style-light .btn-social,
.style-dark .style-light .btn-social {
  color: <?php echo sanitize_text_field($color_text); ?> !important;
}
@media (min-width: 960px) {
  .overlay.style-light-bg {
    background-color: rgba(255, 255, 255, 0.95) !important;
  }
  .overlay.style-dark-bg {
    background-color: rgba(20, 22, 24, 0.95) !important;
  }
}
/* #Form-focus-color */
.style-dark input:not([type='submit']):not([type='button']):not([type='number']):not([type='checkbox']):not([type='radio']):focus,
.style-dark textarea:focus,
.style-light .style-dark input:not([type='submit']):not([type='button']):not([type='number']):not([type='checkbox']):not([type='radio']):focus,
.style-light .style-dark textarea:focus {
  border-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-light input:not([type='submit']):not([type='button']):not([type='number']):not([type='checkbox']):not([type='radio']):focus,
.style-light textarea:focus,
.style-dark .style-light input:not([type='submit']):not([type='button']):not([type='number']):not([type='checkbox']):not([type='radio']):focus,
.style-dark .style-light textarea:focus {
  border-color: <?php echo sanitize_text_field($color_primary); ?>;
}
.style-dark .ui-form-placeholder,
.style-light .style-dark .ui-form-placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
  text-transform: capitalize;
}
.style-light .ui-form-placeholder,
.style-dark .style-light .ui-form-placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
  text-transform: capitalize;
}
/* #Form-inset-shadow */
.shadow-inset-form,
input,
textarea,
select,
.seldiv,
.select2-choice,
.select2-selection--single {
  box-shadow: inset 0 2px 1px rgba(0, 0, 0, 0.025);
}
/* #Form-xl */
.style-dark .uncode-live-search input.form-xl,
.style-light .style-dark .uncode-live-search input.form-xl {
  box-shadow: 0px 0px 0px 6px rgba(0, 0, 0, 0.2);
}
.style-light .uncode-live-search input.form-xl,
.style-dark .style-light .uncode-live-search input.form-xl {
  box-shadow: 0px 0px 0px 6px rgba(255, 255, 255, 0.2);
}
/* #Form-input-background */
.input-background .style-dark input[type="text"],
.input-background .style-light .style-dark input[type="text"],
.input-background .style-dark input[type="email"],
.input-background .style-light .style-dark input[type="email"],
.input-background .style-dark input[type="number"],
.input-background .style-light .style-dark input[type="number"],
.input-background .style-dark input[type="url"],
.input-background .style-light .style-dark input[type="url"],
.input-background .style-dark input[type="tel"],
.input-background .style-light .style-dark input[type="tel"],
.input-background .style-dark input[type="search"],
.input-background .style-light .style-dark input[type="search"],
.input-background .style-dark input[type="password"],
.input-background .style-light .style-dark input[type="password"],
.input-background .style-dark input[type="date"],
.input-background .style-light .style-dark input[type="date"],
.input-background .style-dark textarea,
.input-background .style-light .style-dark textarea,
.input-background .style-dark select,
.input-background .style-light .style-dark select,
.input-background .style-dark .select2-selection--single,
.input-background .style-light .style-dark .select2-selection--single {
  background-color: rgba(0, 0, 0, 0.15) !important;
}
.input-background .style-light input[type="text"],
.input-background .style-dark .style-light input[type="text"],
.input-background .style-light input[type="email"],
.input-background .style-dark .style-light input[type="email"],
.input-background .style-light input[type="number"],
.input-background .style-dark .style-light input[type="number"],
.input-background .style-light input[type="url"],
.input-background .style-dark .style-light input[type="url"],
.input-background .style-light input[type="tel"],
.input-background .style-dark .style-light input[type="tel"],
.input-background .style-light input[type="search"],
.input-background .style-dark .style-light input[type="search"],
.input-background .style-light input[type="password"],
.input-background .style-dark .style-light input[type="password"],
.input-background .style-light input[type="date"],
.input-background .style-dark .style-light input[type="date"],
.input-background .style-light textarea,
.input-background .style-dark .style-light textarea,
.input-background .style-light select,
.input-background .style-dark .style-light select,
.input-background .style-light .select2-selection--single,
.input-background .style-dark .style-light .select2-selection--single {
  background-color: #f7f7f7 !important;
}
.style-dark .input-background input[type="text"],
.style-light .style-dark .input-background input[type="text"],
.style-dark .input-background input[type="email"],
.style-light .style-dark .input-background input[type="email"],
.style-dark .input-background input[type="number"],
.style-light .style-dark .input-background input[type="number"],
.style-dark .input-background input[type="url"],
.style-light .style-dark .input-background input[type="url"],
.style-dark .input-background input[type="tel"],
.style-light .style-dark .input-background input[type="tel"],
.style-dark .input-background input[type="search"],
.style-light .style-dark .input-background input[type="search"],
.style-dark .input-background input[type="password"],
.style-light .style-dark .input-background input[type="password"],
.style-dark .input-background input[type="date"],
.style-light .style-dark .input-background input[type="date"],
.style-dark .input-background textarea,
.style-light .style-dark .input-background textarea,
.style-dark .input-background select,
.style-light .style-dark .input-background select,
.style-dark .input-background .select2-selection--single,
.style-light .style-dark .input-background .select2-selection--single {
  background-color: rgba(0, 0, 0, 0.15) !important;
}
.style-light .input-background input[type="text"],
.style-dark .style-light .input-background input[type="text"],
.style-light .input-background input[type="email"],
.style-dark .style-light .input-background input[type="email"],
.style-light .input-background input[type="number"],
.style-dark .style-light .input-background input[type="number"],
.style-light .input-background input[type="url"],
.style-dark .style-light .input-background input[type="url"],
.style-light .input-background input[type="tel"],
.style-dark .style-light .input-background input[type="tel"],
.style-light .input-background input[type="search"],
.style-dark .style-light .input-background input[type="search"],
.style-light .input-background input[type="password"],
.style-dark .style-light .input-background input[type="password"],
.style-light .input-background input[type="date"],
.style-dark .style-light .input-background input[type="date"],
.style-light .input-background textarea,
.style-dark .style-light .input-background textarea,
.style-light .input-background select,
.style-dark .style-light .input-background select,
.style-light .input-background .select2-selection--single,
.style-dark .style-light .input-background .select2-selection--single {
  background-color: #f7f7f7 !important;
}
/* #UI-transition-normal */
.ui-transition-normal,
input,
button,
select,
textarea,
.img-thumbnail {
  transition: color 400ms cubic-bezier(0.785, 0.135, 0.15, 0.86), background-color 400ms cubic-bezier(0.785, 0.135, 0.15, 0.86), border-color 400ms cubic-bezier(0.785, 0.135, 0.15, 0.86);
}
/*  */
.ui-transition-slow {
  transition: color 600ms cubic-bezier(0.785, 0.135, 0.15, 0.86), background-color 600ms cubic-bezier(0.785, 0.135, 0.15, 0.86), border-color 600ms cubic-bezier(0.785, 0.135, 0.15, 0.86);
}
.ui-transition-fast,
.main-wrapper a,
.tmb-content-under.tmb .t-entry p.t-entry-author a:hover span,
.tmb-content-lateral.tmb .t-entry p.t-entry-author a:hover span {
  transition: color 200ms cubic-bezier(0.785, 0.135, 0.15, 0.86), background-color 200ms cubic-bezier(0.785, 0.135, 0.15, 0.86), border-color 200ms cubic-bezier(0.785, 0.135, 0.15, 0.86);
}
/* #Cart dropdown */
.submenu-light ul.uncode-cart-dropdown a,
.submenu-light ul.uncode-cart-dropdown span {
  color: <?php echo sanitize_text_field($color_menu_text); ?> !important;
}
.submenu-dark ul.uncode-cart-dropdown a,
.submenu-dark ul.uncode-cart-dropdown span {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?> !important;
}
/* #Woo Headings */
.headings-style-woo {
  font-size: 17px;
  line-height: 1.2;
  margin: 27px 0 0;
}
.row-breadcrumb.row-breadcrumb-light .breadcrumb-title {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_light); ?>;
}
.row-breadcrumb.row-breadcrumb-dark .breadcrumb-title {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_dark); ?>;
}
.row-navigation.row-navigation-light {
  outline-color: #eaeaea;
  background-color: #f7f7f7;
}
.row-navigation.row-navigation-light .btn-disable-hover {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_light); ?>;
}
.row-navigation.row-navigation-dark {
  outline-color: #303133;
  background-color: #191b1e;
}
.row-navigation.row-navigation-dark .btn-disable-hover {
  color: <?php echo sanitize_text_field($color_ui_text_alpha_dark); ?>;
}
.style-dark .wp-caption-text,
.style-light .style-dark .wp-caption-text {
  color: <?php echo sanitize_text_field($color_text_inverted); ?>;
}
.style-light .wp-caption-text,
.style-dark .style-light .wp-caption-text {
  color: <?php echo sanitize_text_field($color_text); ?>;
}
.btn-form-border-style,
input,
textarea,
select,
.seldiv,
.select2-choice,
.select2-selection--single,
input[type="submit"],
input[type="reset"],
input[type="button"],
button[type="submit"],
.seldiv:before,
.btn,
.btn-link,
.btn:not(.btn-custom-typo),
.btn-link:not(.btn-custom-typo),
.panel-title > a > span,
.divider .divider-icon,
.overlay input,
.search_footer {
  border-width: <?php echo sanitize_text_field($btn_border_width); ?>px;
}
.style-dark .icon-automatic-video .icon-automatic-video-inner-bg,
.style-light .style-dark .icon-automatic-video .icon-automatic-video-inner-bg {
  background-color: <?php echo sanitize_text_field($color_heading); ?>;
}
.style-dark .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg,
.style-light .style-dark .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg {
  box-shadow: 0 0 0 0.25em <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-dark .icon-box:hover .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg,
.style-light .style-dark .icon-box:hover .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg {
  box-shadow: 0 0 0 0.5em <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .icon-automatic-video .icon-automatic-video-inner-bg,
.style-dark .style-light .icon-automatic-video .icon-automatic-video-inner-bg {
  background-color: <?php echo sanitize_text_field($color_heading_inverted); ?>;
}
.style-light .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg,
.style-dark .style-light .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg {
  box-shadow: 0 0 0 0.25em <?php echo sanitize_text_field($color_heading); ?>;
}
.style-light .icon-box:hover .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg,
.style-dark .style-light .icon-box:hover .icon-automatic-video.btn-shadow .icon-automatic-video-outer-bg {
  box-shadow: 0 0 0 0.5em <?php echo sanitize_text_field($color_heading); ?>;
}
.style-light ::-webkit-input-placeholder,
.style-dark .style-light ::-webkit-input-placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-light ::-moz-placeholder,
.style-dark .style-light ::-moz-placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-light :-ms-input-placeholder,
.style-dark .style-light :-ms-input-placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-light :-moz-placeholder,
.style-dark .style-light :-moz-placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-light :placeholder,
.style-dark .style-light :placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-light .select2-selection__placeholder,
.style-dark .style-light .select2-selection__placeholder {
  color: <?php echo function_exists( 'uncode_darken_color' ) ? uncode_darken_color( $color_text, 50 ) : sanitize_text_field( $color_text ); ?>;
}
.style-dark ::-webkit-input-placeholder,
.style-light .style-dark ::-webkit-input-placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.style-dark ::-moz-placeholder,
.style-light .style-dark ::-moz-placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.style-dark :-ms-input-placeholder,
.style-light .style-dark :-ms-input-placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.style-dark :-moz-placeholder,
.style-light .style-dark :-moz-placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.style-dark :placeholder,
.style-light .style-dark :placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.style-dark .select2-selection__placeholder,
.style-light .style-dark .select2-selection__placeholder {
  color: <?php echo sanitize_text_field( $color_text_inverted ); ?>;
}
.uncode-noconsent-gdpr-text {
  font-weight: <?php echo sanitize_text_field($cs_body_font_weight); ?>;
  font-family: <?php echo sanitize_text_field($font_family_base); ?>;
}
@media (min-width: 960px) {
  #uncode-custom-cursor.basic-style span:first-child,
  #uncode-custom-cursor-pilot.basic-style span:first-child,
  #uncode-custom-cursor.async-style span:first-child,
  #uncode-custom-cursor-pilot.async-style span:first-child {
    background-color: <?php echo sanitize_text_field($color_heading); ?>;
  }
  body:not(.disable-hover) [data-cursor="pointer"]#uncode-custom-cursor.basic-style span:first-child,
  body:not(.disable-hover) [data-cursor="pointer"]#uncode-custom-cursor-pilot.basic-style span:first-child,
  body:not(.disable-hover) [data-cursor="pointer"]#uncode-custom-cursor.async-style span:first-child,
  body:not(.disable-hover) [data-cursor="pointer"]#uncode-custom-cursor-pilot.async-style span:first-child {
    background-color: <?php echo sanitize_text_field($color_primary); ?>;
  }
  #uncode-custom-cursor.accent-style span:first-child,
  #uncode-custom-cursor-pilot.accent-style span:first-child {
    background-color: <?php echo sanitize_text_field($color_primary); ?>;
  }
  #uncode-custom-cursor.diff-style span:first-child,
  #uncode-custom-cursor-pilot.diff-style span:first-child {
    background-color: #ffffff;
  }
  body:not(.disable-hover) [data-cursor^="icon-"]#uncode-custom-cursor span:first-child {
    background-color: <?php echo sanitize_text_field($color_heading); ?>;
  }
  body:not(.disable-hover) [data-cursor^="icon-"]#uncode-custom-cursor::after {
    color: #ffffff;
  }
  body:not(.disable-hover) [data-cursor="icon-light"]#uncode-custom-cursor span:first-child {
    background-color: #ffffff;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.075);
  }
  body:not(.disable-hover) [data-cursor="icon-light"]#uncode-custom-cursor::after {
    color: <?php echo sanitize_text_field($color_heading); ?>;
  }
  body:not(.disable-hover) [data-cursor="icon-accent"]#uncode-custom-cursor span:first-child {
    background-color: <?php echo sanitize_text_field($color_primary); ?>;
  }
  body:not(.disable-hover) [data-cursor="icon-accent"]#uncode-custom-cursor::after {
    color: #ffffff;
  }
  body:not(.disable-hover) [data-cursor="icon-diff"]#uncode-custom-cursor span:first-child {
    background-color: #ffffff;
  }
  #uncode-custom-cursor-pilot.async-style > span:first-child {
    background-color: <?php echo sanitize_text_field($color_primary); ?>;
  }
}
/*
----------------------------------------------------------

#Skins-Buttons

----------------------------------------------------------
*/
input[type="submit"],
input[type="reset"],
input[type="button"],
button[type="submit"] {
  font-size: <?php echo sanitize_text_field($btn_font_size); ?>px;
  padding: <?php echo sanitize_text_field($btn_padding_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_lateral); ?>px;
}
.btn,
.btn-link {
  font-size: <?php echo sanitize_text_field($btn_font_size); ?>px;
}
.btn {
  padding: <?php echo sanitize_text_field($btn_padding_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_lateral); ?>px !important;
}
.btn-link {
  padding: 0 !important;
}
.btn-sm {
  font-size: <?php echo sanitize_text_field($btn_font_size_sm); ?>px !important;;
  padding: <?php echo sanitize_text_field($btn_padding_sm_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_sm_lateral); ?>px !important;
}
.btn-lg {
  font-size: <?php echo sanitize_text_field($btn_font_size_lg); ?>px !important;;
  padding: <?php echo sanitize_text_field($btn_padding_lg_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_lg_lateral); ?>px !important;
}
.btn-xl {
  font-size: <?php echo sanitize_text_field($btn_font_size_xl); ?>px !important;;
  padding: <?php echo sanitize_text_field($btn_padding_xl_top_bottom); ?>px <?php echo sanitize_text_field($btn_padding_xl_lateral); ?>px !important;
}
.widget-container button,
.widget-container .btn {
  padding: <?php echo sanitize_text_field($btn_wgt_padding_top_bottom); ?>px <?php echo sanitize_text_field($btn_wgt_padding_lateral); ?>px !important;
}
.btn-dark {
  color: #ffffff !important;
  background-color: #000000 !important;
  border-color: #000000 !important;
}
.btn-dark:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-dark.active {
  color: #000000 !important;
  background-color: transparent !important;
  border-color: #000000 !important;
}
.btn-dark.btn-outline {
  color: #000000 !important;
  background-color: transparent !important;
  border-color: #000000 !important;
}
.btn-dark.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-dark.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: #000000 !important;
  border-color: #000000 !important;
}
.btn-dark.btn-flat:hover {
  color: #ffffff !important;
  background-color: #000000 !important;
  border-color: #000000 !important;
}
.btn-light {
  color: #000000 !important;
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
.btn-light:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-light.active {
  color: #ffffff !important;
  background-color: transparent !important;
  border-color: #ffffff !important;
}
.btn-light.btn-outline {
  color: #ffffff !important;
  background-color: transparent !important;
  border-color: #ffffff !important;
}
.btn-light.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-light.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #000000 !important;
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
.btn-light.btn-flat:hover {
  color: #000000 !important;
  background-color: #f2f2f2 !important;
  border-color: #f2f2f2 !important;
}
.btn-success {
  color: #ffffff !important;
  background-color: #28de72 !important;
  border-color: #28de72 !important;
}
.btn-success:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-success.active {
  color: #28de72 !important;
  background-color: transparent !important;
  border-color: #28de72 !important;
}
.btn-success.btn-outline {
  color: #28de72 !important;
  background-color: transparent !important;
  border-color: #28de72 !important;
}
.btn-success.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-success.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: #28de72 !important;
  border-color: #28de72 !important;
}
.btn-info {
  color: #ffffff !important;
  background-color: <?php echo sanitize_text_field($color_primary); ?> !important;
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.btn-info:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-info.active {
  color: <?php echo sanitize_text_field($color_primary); ?> !important;
  background-color: transparent !important;
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.btn-info.btn-outline {
  color: <?php echo sanitize_text_field($color_primary); ?> !important;
  background-color: transparent !important;
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.btn-info.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-info.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: <?php echo sanitize_text_field($color_primary); ?> !important;
  border-color: <?php echo sanitize_text_field($color_primary); ?> !important;
}
.btn-warning {
  color: #ffffff !important;
  background-color: #ffc42e !important;
  border-color: #ffc42e !important;
}
.btn-warning:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-warning.active {
  color: #ffc42e !important;
  background-color: transparent !important;
  border-color: #ffc42e !important;
}
.btn-warning.btn-outline {
  color: #ffc42e !important;
  background-color: transparent !important;
  border-color: #ffc42e !important;
}
.btn-warning.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-warning.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: #ffc42e !important;
  border-color: #ffc42e !important;
}
.btn-danger {
  color: #ffffff !important;
  background-color: #ff3100 !important;
  border-color: #ff3100 !important;
}
.btn-danger:not(.btn-hover-nobg):not(.icon-animated):hover,
.btn-danger.active {
  color: #ff3100 !important;
  background-color: transparent !important;
  border-color: #ff3100 !important;
}
.btn-danger.btn-outline {
  color: #ff3100 !important;
  background-color: transparent !important;
  border-color: #ff3100 !important;
}
.btn-danger.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.btn-danger.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: #ff3100 !important;
  border-color: #ff3100 !important;
}
/* #Button-skins */
.style-light .btn-default,
.style-dark .style-light .btn-default,
.tmb-light .t-entry-text .btn-default,
.style-dark .tmb-light .t-entry-text .btn-default,
.tmb-dark .t-overlay-inner .btn-default {
  color: #ffffff !important;
  background-color: <?php echo sanitize_text_field($color_heading); ?> !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-light .btn-default:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.style-dark .style-light .btn-default:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.tmb-light .t-entry-text .btn-default:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.style-dark .tmb-light .t-entry-text .btn-default:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.tmb-dark .t-overlay-inner .btn-default:not(.btn-hover-nobg):not(.icon-animated):not(.btn-flat):hover,
.style-light .btn-default.active,
.style-dark .style-light .btn-default.active,
.tmb-light .t-entry-text .btn-default.active,
.style-dark .tmb-light .t-entry-text .btn-default.active,
.tmb-dark .t-overlay-inner .btn-default.active {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: transparent !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-light .btn-default.btn-outline,
.style-dark .style-light .btn-default.btn-outline,
.tmb-light .t-entry-text .btn-default.btn-outline,
.style-dark .tmb-light .t-entry-text .btn-default.btn-outline,
.tmb-dark .t-overlay-inner .btn-default.btn-outline {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: transparent !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-light .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-dark .style-light .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.tmb-light .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-dark .tmb-light .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.tmb-dark .t-overlay-inner .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-light .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.style-dark .style-light .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.tmb-light .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.style-dark .tmb-light .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.tmb-dark .t-overlay-inner .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: #ffffff !important;
  background-color: <?php echo sanitize_text_field($color_heading); ?> !important;
  border-color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.style-light .btn-default.btn-flat:hover,
.style-dark .style-light .btn-default.btn-flat:hover,
.tmb-light .t-entry-text .btn-default.btn-flat:hover,
.style-dark .tmb-light .t-entry-text .btn-default.btn-flat:hover,
.tmb-dark .t-overlay-inner .btn-default.btn-flat:hover {
  color: #ffffff !important;
  background-color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_heading ) : sanitize_text_field($color_heading); ?> !important;
  border-color: <?php echo function_exists('uncode_darken_color') ? uncode_darken_color( $color_heading ) : sanitize_text_field($color_heading); ?> !important;
}
.style-dark .btn-default,
.style-light .style-dark .btn-default,
.tmb-dark .t-entry-text .btn-default,
.style-light .tmb-dark .t-entry-text .btn-default,
.tmb-light .t-overlay-inner .btn-default {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
.style-dark .btn-default:not(.btn-hover-nobg):not(.icon-animated):hover,
.style-light .style-dark .btn-default:not(.btn-hover-nobg):not(.icon-animated):hover,
.tmb-dark .t-entry-text .btn-default:not(.btn-hover-nobg):not(.icon-animated):hover,
.style-light .tmb-dark .t-entry-text .btn-default:not(.btn-hover-nobg):not(.icon-animated):hover,
.tmb-light .t-overlay-inner .btn-default:not(.btn-hover-nobg):not(.icon-animated):hover,
.style-dark .btn-default.active,
.style-light .style-dark .btn-default.active,
.tmb-dark .t-entry-text .btn-default.active,
.style-light .tmb-dark .t-entry-text .btn-default.active,
.tmb-light .t-overlay-inner .btn-default.active {
  color: #ffffff !important;
  background-color: transparent !important;
  border-color: #ffffff !important;
}
.style-dark .btn-default.btn-outline,
.style-light .style-dark .btn-default.btn-outline,
.tmb-dark .t-entry-text .btn-default.btn-outline,
.style-light .tmb-dark .t-entry-text .btn-default.btn-outline,
.tmb-light .t-overlay-inner .btn-default.btn-outline {
  color: #ffffff !important;
  background-color: transparent !important;
  border-color: #ffffff !important;
}
.style-dark .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-light .style-dark .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.tmb-dark .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-light .tmb-dark .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.tmb-light .t-overlay-inner .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video):hover,
.style-dark .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.style-light .style-dark .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.tmb-dark .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.style-light .tmb-dark .t-entry-text .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active,
.tmb-light .t-overlay-inner .btn-default.btn-outline:not(.icon-animated):not(.icon-automatic-video).active {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
.style-dark .btn-default.btn-flat:hover,
.style-light .style-dark .btn-default.btn-flat:hover,
.tmb-dark .t-entry-text .btn-default.btn-flat:hover,
.style-light .tmb-dark .t-entry-text .btn-default.btn-flat:hover,
.tmb-light .t-overlay-inner .btn-default.btn-flat:hover {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: #f2f2f2 !important;
  border-color: #f2f2f2 !important;
}
#uncode_sidecart.style-light .btn-default.wc-forward:first-child {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
#uncode_sidecart.style-light .btn-default.wc-forward:first-child:hover {
  color: <?php echo sanitize_text_field($color_text); ?> !important;
}
#uncode_sidecart.style-dark .btn-default.wc-forward:first-child {
  color: #ffffff !important;
}
#uncode_sidecart.style-dark .btn-default.wc-forward:first-child:hover {
  color: #cccccc !important;
}
/*
----------------------------------------------------------

#Skins-Menus: Font Family & Weights

----------------------------------------------------------
*/
/* #Font-family-menu */
.font-family-menu,
.menu-container:not(.isotope-filters) ul.menu-smart,
.menu-container:not(.isotope-filters) ul.menu-smart a:not(.social-menu-link):not(.vc_control-btn),
.burger-label {
  font-family: <?php echo sanitize_text_field($font_family_menu); ?>;
}
@media (max-width: 959px) {
  .menu-primary ul.menu-smart a {
    font-family: <?php echo sanitize_text_field($font_family_menu); ?>;
    font-weight: <?php echo sanitize_text_field($menu_font_weight); ?>;
  }
}
/* #Font-size-menu */
.font-size-menu,
.menu-container:not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link),
.menu-container:not(.vmenu-container):not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link):not(.vc_control-btn),
.menu-smart > li > a > div > div > div.btn,
.burger-label {
  font-size: 12px;
}
@media (min-width: 960px) {
  .font-size-menu,
  .menu-container:not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link),
  .menu-container:not(.vmenu-container):not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link):not(.vc_control-btn),
  .menu-smart > li > a > div > div > div.btn,
  .burger-label {
    font-size: <?php echo sanitize_text_field($menu_font_size); ?>px;
  }
  .font-size-submenu,
  .menu-horizontal ul ul a,
  .vmenu-container ul ul a {
    font-size: <?php echo sanitize_text_field($submenu_font_size); ?>px;
  }
}
@media (max-width: 959px) {
  .font-size-menu-mobile,
  .menu-container:not(.isotope-filters) ul.menu-smart a:not(.social-menu-link):not(.vc_control-btn) {
    font-size: <?php echo sanitize_text_field($menu_mobile_font_size); ?>px !important;
  }
}
/* #Font-weight-menu */
.font-weight-menu,
.menu-container:not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link),
.menu-container:not(.isotope-filters) ul.menu-smart li.dropdown > a,
.menu-container:not(.isotope-filters) ul.menu-smart li.mega-menu > a,
.menu-container:not(.vmenu-container):not(.isotope-filters) ul.menu-smart > li > a:not(.social-menu-link):not(.vc_control-btn),
.menu-smart i.fa-dropdown,
.vmenu-container a {
  font-weight: <?php echo sanitize_text_field($menu_font_weight); ?>;
  letter-spacing: <?php echo sanitize_text_field($menu_letter_spacing); ?>em;
}
/*
----------------------------------------------------------

#Skins-Menus: Colors

----------------------------------------------------------
*/
/* Menu colors */
.menu-light.top-menu p {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
.menu-light .menu-smart a {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
@media (max-width: 959px) {
  .submenu-dark.isotope-filters.menu-light .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text); ?>;
  }
}
.menu-light .menu-smart a:hover,
.menu-light .menu-smart a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
}
@media (min-width: 960px) {
  .isotope-filters.menu-light .menu-smart a:hover,
  .isotope-filters.menu-light .menu-smart a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_hover_static); ?>;
  }
}
.menu-light .mobile-additional-icon {
  color: <?php echo sanitize_text_field($color_logo); ?>;
}
.menu-dark.top-menu p {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
.menu-dark a.menu-smart-toggle,
.menu-dark .menu-smart a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
@media (max-width: 959px) {
  .submenu-light.isotope-filters.menu-dark a.menu-smart-toggle,
  .submenu-light.isotope-filters.menu-dark .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
  }
}
.menu-dark a.menu-smart-toggle:hover,
.menu-dark .menu-smart a:hover,
.menu-dark a.menu-smart-toggle:focus,
.menu-dark .menu-smart a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
}
.isotope-filters.menu-dark a.menu-smart-toggle:hover,
.isotope-filters.menu-dark .menu-smart a:hover,
.isotope-filters.menu-dark a.menu-smart-toggle:focus,
.isotope-filters.menu-dark .menu-smart a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover_static); ?>;
}
.menu-dark .mobile-additional-icon {
  color: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a {
  color: <?php echo sanitize_text_field($color_menu_text); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a:hover,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .mobile-additional-icon {
  color: <?php echo sanitize_text_field($color_menu_text); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a:hover,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li > a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .mobile-additional-icon {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?> !important;
}
/* Menu colors active */
.menu-light .menu-smart > li.active > a,
.menu-light .menu-smart > li a.active,
.menu-light .menu-smart > li.current-menu-ancestor > a,
.menu-light .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
}
.isotope-filters .menu-light .menu-smart > li.active > a,
.isotope-filters .menu-light .menu-smart > li a.active,
.isotope-filters .menu-light .menu-smart > li.current-menu-ancestor > a,
.isotope-filters .menu-light .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_hover_static); ?>;
}
.menu-dark .menu-smart > li.active > a,
.menu-dark .menu-smart > li a.active,
.menu-dark .menu-smart > li.current-menu-ancestor > a,
.menu-dark .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
}
.isotope-filters .menu-dark .menu-smart > li.active > a,
.isotope-filters .menu-dark .menu-smart > li a.active,
.isotope-filters .menu-dark .menu-smart > li.current-menu-ancestor > a,
.isotope-filters .menu-dark .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover_static); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.active > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li a.active,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-parent > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-ancestor > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.active > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li a.active,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-parent > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-ancestor > a,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-horizontal-inner > .nav > .menu-smart > li.current-menu-item:not(.menu-item-type-custom) > a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?> !important;
}
/* Menu submenu colors */
.submenu-light .menu-smart ul a {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
@media (min-width: 960px) {
  .submenu-light .menu-sub-enhanced .menu-smart ul a {
    color: <?php echo sanitize_text_field($color_submenu_enhanced); ?>;
  }
  .submenu-light .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:hover,
  .submenu-light .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_hover); ?> !important;
    background-color: rgba(0, 0, 0, 0.03) !important;
  }
  .submenu-light .menu-horizontal.menu-sub-enhanced .menu-smart ul a:hover,
  .submenu-light .menu-horizontal.menu-sub-enhanced .menu-smart ul a:focus {
    color: <?php echo sanitize_text_field($color_submenu_hover_enhanced); ?> !important;
  }
}
.main-container .style-light .menu-advanced ul a {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
.main-container .style-light .menu-advanced ul li:not(.menu-item-button) > a:hover,
.main-container .style-light .menu-advanced ul li:not(.menu-item-button) > a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?> !important;
  background-color: rgba(0, 0, 0, 0.03) !important;
}
.submenu-light .menu-smart.menu-cta-inner ul a {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
@media (min-width: 960px) {
  body[class*=vmenu-] .submenu-light .menu-smart.menu-cta-inner ul a:hover,
  body[class*=vmenu-] .submenu-light .menu-smart.menu-cta-inner ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
    background-color: rgba(0, 0, 0, 0.03);
  }
}
.submenu-dark .menu-smart ul a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
@media (min-width: 960px) {
  .submenu-dark .menu-sub-enhanced .menu-smart ul a {
    color: <?php echo sanitize_text_field($color_submenu_enhanced_inverted); ?>;
  }
  .submenu-dark .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:hover,
  .submenu-dark .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?> !important;
    background-color: rgba(255, 255, 255, 0.03) !important;
  }
  .submenu-dark .menu-horizontal.menu-sub-enhanced .menu-smart ul a:hover,
  .submenu-dark .menu-horizontal.menu-sub-enhanced .menu-smart ul a:focus {
    color: <?php echo sanitize_text_field($color_submenu_enhanced_hover_inverted); ?> !important;
  }
  .submenu-dark .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:hover,
  .submenu-dark .menu-horizontal:not(.menu-sub-enhanced) .menu-smart ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?> !important;
    background-color: rgba(255, 255, 255, 0.03) !important;
  }
}
.main-container .style-dark .menu-advanced ul a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
.main-container .style-dark .menu-advanced ul li:not(.menu-item-button) > a:hover,
.main-container .style-dark .menu-advanced ul li:not(.menu-item-button) > a:focus {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
  background-color: rgba(255, 255, 255, 0.03);
}
.submenu-dark .menu-smart.menu-cta-inner ul a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
@media (min-width: 960px) {
  body[class*=vmenu-] .submenu-dark .menu-smart.menu-cta-inner ul a:hover,
  body[class*=vmenu-] .submenu-dark .menu-smart.menu-cta-inner ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
    background-color: rgba(255, 255, 255, 0.03);
  }
}
@media (max-width: 959px) {
  .submenu-light:not(.isotope-filters) .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text); ?>;
  }
  .submenu-light:not(.isotope-filters) .menu-smart a:hover,
  .submenu-light:not(.isotope-filters) .menu-smart a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
  }
  .submenu-dark:not(.isotope-filters) .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
  }
  .submenu-dark:not(.isotope-filters) .menu-smart a:hover,
  .submenu-dark:not(.isotope-filters) .menu-smart a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
  }
}
/* Menu submenu colors active*/
.submenu-light .menu-smart ul li.current-menu-parent > a,
.submenu-light .menu-smart ul li.active > a {
  color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
}
@media (min-width: 960px) {
  .submenu-light .menu-horizontal.menu-sub-enhanced .menu-smart ul li.current-menu-parent > a,
  .submenu-light .menu-horizontal.menu-sub-enhanced .menu-smart ul li.active > a {
    color: <?php echo sanitize_text_field($color_submenu_hover_enhanced); ?> !important;
  }
}
.submenu-dark .menu-smart ul li.current-menu-parent > a,
.submenu-dark .menu-smart ul li.active > a {
  color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
}
@media (min-width: 960px) {
  .submenu-dark .menu-horizontal.menu-sub-enhanced .menu-smart ul li.current-menu-parent > a,
  .submenu-dark .menu-horizontal.menu-sub-enhanced .menu-smart ul li.active > a {
    color: <?php echo sanitize_text_field($color_submenu_enhanced_hover_inverted); ?> !important;
  }
}
@media (max-width: 959px) {
  .submenu-light .menu-smart li.active > a,
  .submenu-light .menu-smart li.current-menu-ancestor > a,
  .submenu-light .menu-smart li.current-menu-item:not(.menu-item-type-custom) > a {
    color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
  }
  .submenu-dark .menu-smart li.active > a,
  .submenu-dark .menu-smart li.current-menu-ancestor > a,
  .submenu-dark .menu-smart li.current-menu-item:not(.menu-item-type-custom) > a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
  }
}
/* Menu megamenu title colors */
@media (min-width: 960px) {
  .submenu-light .menu-horizontal .menu-smart > .mega-menu .mega-menu-inner > li > a {
    color: <?php echo sanitize_text_field($color_menu_text); ?>;
  }
  .submenu-dark .menu-horizontal .menu-smart > .mega-menu .mega-menu-inner > li > a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
  }
}
/* Menu colors mobile */
@media (max-width: 959px) {
  .submenu-light:not(.isotope-filters) .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text); ?>;
  }
  .submenu-dark:not(.isotope-filters) .menu-smart a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
  }
}
/*
----------------------------------------------------------

#Skins-Menus: Borders

----------------------------------------------------------
*/
/* Menu borders colors */
.menu-light .menu-smart,
.menu-light .menu-smart li,
.submenu-light .menu-smart ul,
.menu-smart.submenu-light li ul li,
.menu-light .menu-accordion-dividers,
.menu-light .menu-borders:not(.needs-after),
.menu-light .menu-borders.needs-after::after,
.menu-light.vmenu-borders,
.menu-light .main-menu-container {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?>;
}
.menu-dark .menu-smart,
.menu-dark .menu-smart li,
.submenu-dark .menu-smart ul,
.menu-smart.submenu-dark li ul li,
.menu-dark .menu-accordion-dividers,
.menu-dark .menu-borders:not(.needs-after),
.menu-dark .menu-borders.needs-after::after,
.menu-dark.vmenu-borders,
.menu-dark .main-menu-container {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?>;
}
/* Submenu borders colors */
@media (min-width: 960px) {
  .menu-horizontal.menu-sub-enhanced.submenu-light .menu-smart > .mega-menu .mega-menu-inner,
  .submenu-light .menu-smart li ul li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_light); ?>;
  }
  .menu-horizontal.menu-sub-enhanced.submenu-dark .menu-smart > .mega-menu .mega-menu-inner,
  .submenu-dark .menu-smart li ul li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_dark); ?>;
  }
}
@media (max-width: 959px) {
  .menu-light .row-brand,
  .menu-light .row-menu .row-menu-inner {
    border-bottom: 1px solid <?php echo sanitize_text_field($color_menu_border_light); ?>;
  }
  .submenu-light .menu-smart,
  .submenu-light .menu-smart li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_light); ?>;
  }
  .menu-dark .row-brand,
  .menu-dark .row-menu .row-menu-inner {
    border-bottom: 1px solid <?php echo sanitize_text_field($color_menu_border_dark); ?>;
  }
  .submenu-dark .menu-smart,
  .submenu-dark .menu-smart li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_dark); ?>;
  }
  .menu-mobile-transparent .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .row-menu .row-menu-inner {
    border-color: transparent !important;
  }
}
/* Menu transparent borders colors */
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .menu-borders.needs-after::after,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .menu-smart,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .menu-smart > li,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-light .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .menu-borders.needs-after::after,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .menu-smart,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .menu-smart > li,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-transparent.menu-dark .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-borders.needs-after::after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-smart,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-smart > li,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_light_transparent); ?> !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-borders.needs-after::after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-smart,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .menu-smart > li,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark_transparent); ?> !important;
}
body:not(.menu-force-opacity) .menu-light .menu-borders.needs-after .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity) .menu-light .menu-borders.needs-after .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?>;
}
body:not(.menu-force-opacity) .menu-dark .menu-borders.needs-after .navbar-nav-last > *:first-child::after,
body:not(.menu-force-opacity) .menu-dark .menu-borders.needs-after .navbar-nav-first > *:first-child::after {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?>;
}
/** fix menu overlay **/
body:not(.menu-force-opacity):not(.navbar-hover) .menu-overlay .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover).menu-overlay .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .menu-borders:not(.needs-after),
body:not(.menu-force-opacity):not(.navbar-hover) .menu-overlay .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .menu-borders.needs-after::after,
body:not(.menu-force-opacity):not(.navbar-hover).menu-overlay .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .menu-borders.needs-after::after {
  border: none;
}
/* Submenu borders transparent  */
@media (min-width: 960px) {
  .submenu-transparent.submenu-light .menu-smart ul,
  .submenu-transparent.submenu-light .menu-smart li ul li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_light); ?>;
  }
  .submenu-transparent.submenu-dark .menu-smart ul,
  .submenu-transparent.submenu-dark .menu-smart li ul li {
    border-color: <?php echo sanitize_text_field($color_submenu_border_dark); ?>;
  }
}
/*
----------------------------------------------------------

#Skins-Menus: Backgrounds

----------------------------------------------------------
*/
/* Menu backgrounds colors */
.main-header .style-light-bg,
.menu-wrapper .style-light-bg {
  background-color: <?php echo (((strpos($color_menu_background_light, 'background') === false) ? sanitize_text_field($color_menu_background_light) : 'initial; ' . substr(sanitize_text_field($color_menu_background_light), 0, -1))); ?>;
}
.main-header .style-dark-bg,
.menu-wrapper .style-dark-bg {
  background-color: <?php echo (((strpos($color_menu_background_dark, 'background') === false) ? sanitize_text_field($color_menu_background_dark) : 'initial; ' . substr(sanitize_text_field($color_menu_background_dark), 0, -1))); ?>;
}
/* Menu submenu backgrounds colors */
.submenu-light .menu-horizontal .menu-smart ul,
#uncode_sidecart.style-light {
  background-color: <?php echo (((strpos($color_submenu_background_light, 'background') === false) ? sanitize_text_field($color_submenu_background_light) : 'initial; ' . sanitize_text_field($color_submenu_background_light))); ?>;
}
.submenu-dark .menu-horizontal .menu-smart ul,
#uncode_sidecart.style-dark {
  background-color: <?php echo (((strpos($color_submenu_background_dark, 'background') === false) ? sanitize_text_field($color_submenu_background_dark) : 'initial; ' . sanitize_text_field($color_submenu_background_dark))); ?>;
}
/* Menu submenu mobile backgrounds colors */
@media (max-width: 959px) {
  .submenu-light:not(.isotope-filters) .menu-smart,
  .submenu-light:not(.isotope-filters) .menu-sidebar-inner,
  .submenu-light:not(.isotope-filters) .main-menu-container {
    background-color: <?php echo (((strpos($color_submenu_background_light, 'background') === false) ? sanitize_text_field($color_submenu_background_light) : 'initial; ' . sanitize_text_field($color_submenu_background_light))); ?>;
  }
  .submenu-dark:not(.isotope-filters) .menu-smart,
  .submenu-dark:not(.isotope-filters) .menu-sidebar-inner,
  .submenu-dark:not(.isotope-filters) .main-menu-container {
    background-color: <?php echo (((strpos($color_submenu_background_dark, 'background') === false) ? sanitize_text_field($color_submenu_background_dark) : 'initial; ' . sanitize_text_field($color_submenu_background_dark))); ?>;
  }
}
/* Menu transparent backgrounds colors */
body:not(.menu-overlay):not(.hmenu-center):not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-light-original,
body:not(.menu-overlay):not(.hmenu-center):not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-dark-original.style-light-override {
  opacity: 0;
}
body:not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-light-original > *,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-dark-original.style-light-override > * {
  background: transparent;
  background-color: <?php echo sanitize_text_field($color_menu_background_alpha_light); ?>;
}
body:not(.menu-overlay):not(.hmenu-center):not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-dark-original,
body:not(.menu-overlay):not(.hmenu-center):not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-light-original.style-dark-override {
  opacity: 0;
}
body:not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-dark-original > *,
body:not(.menu-force-opacity):not(.navbar-hover) .menu-wrapper:not(.no-header) .menu-transparent:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent.style-light-original.style-dark-override > * {
  background: transparent;
  background-color: <?php echo sanitize_text_field($color_menu_background_alpha_dark); ?>;
}
/*
----------------------------------------------------------

#Skins-Menus: Scroll Arrows

----------------------------------------------------------
*/
/* Menu scroll arrows */
.submenu-light .menu-smart span.scroll-up,
.submenu-light .menu-smart span.scroll-down {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?>;
  background-color: <?php echo (((strpos($color_menu_background_light, 'background') === false) ? sanitize_text_field($color_menu_background_light) : 'initial; ' . substr(sanitize_text_field($color_menu_background_light), 0, -1))); ?>;
}
.submenu-dark .menu-smart span.scroll-up,
.submenu-dark .menu-smart span.scroll-down {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?>;
  background-color: <?php echo (((strpos($color_menu_background_dark, 'background') === false) ? sanitize_text_field($color_menu_background_dark) : 'initial; ' . substr(sanitize_text_field($color_menu_background_dark), 0, -1))); ?>;
}
.submenu-light .menu-smart span.scroll-up-arrow,
.submenu-light .menu-smart span.scroll-down-arrow {
  border-color: transparent transparent <?php echo sanitize_text_field($color_menu_border_light); ?> transparent !important;
}
.submenu-dark .menu-smart span.scroll-up-arrow,
.submenu-dark .menu-smart span.scroll-down-arrow {
  border-color: transparent transparent <?php echo sanitize_text_field($color_menu_border_dark); ?> transparent !important;
}
.submenu-light .menu-smart span.scroll-down-arrow {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?> transparent transparent transparent !important;
}
.submenu-dark .menu-smart span.scroll-down-arrow {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?> transparent transparent transparent !important;
}
/*
----------------------------------------------------------

#Skins-Menus: Toggle

----------------------------------------------------------
*/
/* Menu mobile toggle */
.mobile-menu-button-dark .lines,
.mobile-menu-button-dark .lines:before,
.mobile-menu-button-dark .lines:after,
.mobile-menu-button-dark .lines > span {
  background: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
.mobile-menu-button-light .lines,
.mobile-menu-button-light .lines:before,
.mobile-menu-button-light .lines:after,
.mobile-menu-button-light .lines > span {
  background: <?php echo sanitize_text_field($color_menu_text); ?>;
}
.mobile-menu-button-dark .burger-label {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
.mobile-menu-button-light .burger-label {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines:before,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines:after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines > span {
  background: <?php echo sanitize_text_field($color_menu_text); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines:before,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines:after,
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .lines > span {
  background: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck):not(.is_mobile_open).menu-transparent .burger-label {
  color: <?php echo sanitize_text_field($color_menu_text); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck):not(.is_mobile_open).menu-transparent .burger-label {
  color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
}
/*
----------------------------------------------------------

#Skins-Menus: Shadows

----------------------------------------------------------
*/
/* Menu shadows */
@media (max-width: 959px) {
  [class*="menu-dd-shadow-"].menu-horizontal .menu-smart ul,
  [class*="menu-dd-shadow-"].menu-horizontal .menu-smart li.menu-item > .vc_row {
    box-shadow: none !important;
  }
}
@media (min-width: 960px) {
  .menu-shadows {
    box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 4px 10px -10px rgba(0, 0, 0, 0.6)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
  }
  body[class*=vmenu-] .menu-shadows {
    box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 0px 7px -1px rgba(0, 0, 0, 0.1)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
  }
}
body:not(.menu-force-opacity) .menu-primary:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open) .menu-shadows.force-no-shadows {
  box-shadow: none;
}
body:not(.menu-force-opacity)[class*=hmenu-] .menu-primary.is_stuck .menu-container {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 4px 10px -10px rgba(0, 0, 0, 0.6)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
}
/* #Menu-mobile-colors */
/* Menu Accordion */
.submenu-light .menu-accordion .menu-smart ul {
  background-color: <?php echo (((strpos($color_menu_background_light, 'background') === false) ? sanitize_text_field($color_menu_background_light) : 'initial; ' . substr(sanitize_text_field($color_menu_background_light), 0, -1))); ?>;
}
.submenu-dark .menu-accordion .menu-smart ul {
  background-color: <?php echo (((strpos($color_menu_background_dark, 'background') === false) ? sanitize_text_field($color_menu_background_dark) : 'initial; ' . substr(sanitize_text_field($color_menu_background_dark), 0, -1))); ?>;
}
/* Menu Overlay */
.menu-overlay .menu-accordion .menu-smart:not(.menu-cta-inner) ul {
  background-color: transparent !important;
}
@media (min-width: 960px) {
  .menu-overlay .menu-dark.submenu-light .menu-smart:not(.menu-cta-inner) ul a {
    color: <?php echo sanitize_text_field($color_menu_text_inverted); ?>;
  }
  .menu-overlay .menu-dark.submenu-light .menu-smart:not(.menu-cta-inner) ul a:hover,
  .menu-overlay .menu-dark.submenu-light .menu-smart:not(.menu-cta-inner) ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_inverted_hover); ?>;
  }
}
@media (min-width: 960px) {
  .menu-overlay .menu-light.submenu-dark .menu-smart:not(.menu-cta-inner) ul a {
    color: <?php echo sanitize_text_field($color_menu_text); ?>;
  }
  .menu-overlay .menu-light.submenu-dark .menu-smart:not(.menu-cta-inner) ul a:hover,
  .menu-overlay .menu-light.submenu-dark .menu-smart:not(.menu-cta-inner) ul a:focus {
    color: <?php echo sanitize_text_field($color_menu_text_hover); ?>;
  }
}
.overlay .overlay-bg {
  opacity: <?php echo sanitize_text_field($overlay_bg_opacity/100); ?>;
}
/* Logo */
.style-light .navbar-brand .logo-skinnable {
  color: <?php echo sanitize_text_field($color_logo); ?>;
}
.style-light .navbar-brand .logo-skinnable > * {
  color: <?php echo sanitize_text_field($color_logo); ?>;
}
.style-light .navbar-brand .logo-skinnable svg * {
  fill: <?php echo sanitize_text_field($color_logo); ?>;
}
.style-dark .navbar-brand .logo-skinnable {
  color: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
.style-dark .navbar-brand .logo-skinnable > * {
  color: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
.style-dark .navbar-brand .logo-skinnable svg * {
  fill: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable {
  color: <?php echo sanitize_text_field($color_logo); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable > * {
  color: <?php echo sanitize_text_field($color_logo); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable svg * {
  fill: <?php echo sanitize_text_field($color_logo); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable {
  color: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable > * {
  color: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-skinnable svg * {
  fill: <?php echo sanitize_text_field($color_logo_inverted); ?>;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-dark {
  display: none !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-light-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-light {
  display: block !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-dark {
  display: block !important;
}
body:not(.menu-force-opacity):not(.navbar-hover) .style-dark-override:not(.is_stuck:not(.menu-desktop-transparent)):not(.is_mobile_open).menu-transparent .navbar-brand .logo-light {
  display: none !important;
}
/* SubMenu Cart */
.submenu-light .menu-accordion .menu-smart .uncode-cart li {
  border-color: <?php echo sanitize_text_field($color_menu_border_light); ?>;
}
.submenu-dark .menu-accordion .menu-smart .uncode-cart li {
  border-color: <?php echo sanitize_text_field($color_menu_border_dark); ?>;
}
/* #Menu-vertical */
/* Menu builder */
.row-inner.col-w-borders > div:not(:first-child) > .uncol.style-light:before {
  background-color: <?php echo sanitize_text_field($color_submenu_border_light); ?>;
}
.row-inner.col-w-borders > div:not(:first-child) > .uncol.style-dark:before {
  background-color: <?php echo sanitize_text_field($color_submenu_border_dark); ?>;
}
/*
----------------------------------------------------------

#Skins-Thumbs

----------------------------------------------------------
*/
/* #Thumbs text overlay color */
.tmb-light.tmb-color-overlay-text,
.tmb-light.tmb .t-entry-visual *:not(.add_to_cart_text):not(.view-cart),
.tmb-light.tmb .t-entry-visual a:not(.add_to_cart_text):not(.view-cart),
.tmb-light.tmb .t-entry-visual .t-entry-title a:not(.add_to_cart_text):not(.view-cart),
.tmb-light.tmb .t-entry-visual .t-entry-meta span:not(.add_to_cart_text):not(.view-cart) {
  color: #ffffff;
}
.tmb-dark.tmb-color-overlay-text,
.tmb-dark.tmb .t-entry-visual *:not(.add_to_cart_text):not(.view-cart),
.tmb-dark.tmb .t-entry-visual a:not(.add_to_cart_text):not(.view-cart),
.tmb-dark.tmb .t-entry-visual .t-entry-title a:not(.add_to_cart_text):not(.view-cart),
.tmb-dark.tmb .t-entry-visual .t-entry-meta span:not(.add_to_cart_text):not(.view-cart) {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.tmb-color-colored-ui,
.tmb .t-cat-over a.bordered-cat,
.tmb .t-cat-over span.bordered-cat,
.tmb a.tmb-term-evidence:not(.bordered-cat),
.uncode-info-box a.tmb-term-evidence:not(.bordered-cat),
.tmb span.tmb-term-evidence:not(.bordered-cat),
.uncode-info-box span.tmb-term-evidence:not(.bordered-cat),
.t-cat-over .tmb a.bordered-cat,
.t-cat-over .uncode-info-box a.bordered-cat,
.t-cat-over .tmb span.bordered-cat,
.t-cat-over .uncode-info-box span.bordered-cat {
  color: #ffffff !important;
}
/* #Thumbs title color */
.tmb-light.tmb-color-title,
.tmb-light.tmb .t-entry-text .t-entry-title a,
.tmb-light.tmb .t-entry-text .t-entry-title,
.tmb-light.tmb-content-under.tmb .t-entry p.t-entry-meta span,
.tmb-light.tmb-content-lateral.tmb .t-entry p.t-entry-meta span,
.tmb-light.tmb-content-under.tmb .t-entry p.t-entry-meta a:not(:hover),
.tmb-light.tmb-content-lateral.tmb .t-entry p.t-entry-meta a:not(:hover) {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.tmb-dark.tmb-color-title,
.tmb-dark.tmb .t-entry-text .t-entry-title a,
.tmb-dark.tmb .t-entry-text .t-entry-title,
.tmb-dark.tmb-content-under.tmb .t-entry p.t-entry-meta span,
.tmb-dark.tmb-content-lateral.tmb .t-entry p.t-entry-meta span,
.tmb-dark.tmb-content-under.tmb .t-entry p.t-entry-meta a:not(:hover),
.tmb-dark.tmb-content-lateral.tmb .t-entry p.t-entry-meta a:not(:hover) {
  color: #ffffff;
}
/* #Thumbs text color */
.tmb-light.tmb-color-text,
.tmb-light.tmb .t-entry-text,
.tmb-light.tmb .t-entry-text p,
.tmb-light.tmb .t-entry p.t-entry-comments .extras a,
.tmb-light.tmb-woocommerce.tmb .t-entry .t-entry-category a,
.tmb-light.tmb-woocommerce.tmb .t-entry .t-entry-category .cat-comma {
  color: <?php echo sanitize_text_field($color_text); ?>;
}
.tmb-dark.tmb-color-text,
.tmb-dark.tmb .t-entry-text,
.tmb-dark.tmb .t-entry-text p,
.tmb-dark.tmb .t-entry p.t-entry-comments .extras a,
.tmb-dark.tmb-woocommerce.tmb .t-entry .t-entry-category a,
.tmb-dark.tmb-woocommerce.tmb .t-entry .t-entry-category .cat-comma {
  color: #ffffff;
}
/* #Thumbs hr color */
.tmb-light.tmb-color-hr,
.tmb-light.el-text hr.separator-reduced,
.tmb-light.tmb .t-entry-visual hr,
.tmb-light.tmb .t-entry-text hr {
  border-color: #eaeaea;
}
.tmb-dark.tmb-color-hr,
.tmb-dark.el-text hr.separator-reduced,
.tmb-dark.tmb .t-entry-visual hr,
.tmb-dark.tmb .t-entry-text hr {
  border-color: rgba(255, 255, 255, 0.25);
}
/* #Thumbs hr color */
.tmb-light.tmb-color-a,
.tmb-light.tmb-content-under.tmb .t-entry p.t-entry-author a:not(:hover) span,
.tmb-light.tmb-content-lateral.tmb .t-entry p.t-entry-author a:not(:hover) span {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.tmb-dark.tmb-color-a,
.tmb-dark.tmb-content-under.tmb .t-entry p.t-entry-author a:not(:hover) span,
.tmb-dark.tmb-content-lateral.tmb .t-entry p.t-entry-author a:not(:hover) span {
  color: #ffffff;
}
/* #Thumbs background color */
.tmb-light.tmb-color-addcart,
.tmb-light.tmb-woocommerce.tmb .t-entry-visual .add-to-cart-overlay a {
  background-color: #262729;
}
.tmb-dark.tmb-color-addcart,
.tmb-dark.tmb-woocommerce.tmb .t-entry-visual .add-to-cart-overlay a {
  background-color: #ffffff;
}
.tmb-light.tmb-color-addcart-half,
.tmb-light.tmb .icon-badge > div,
.tmb-light.tmb .icon-badge > a {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
  background-color: rgba(255, 255, 255, 0.75);
}
.tmb-dark.tmb-color-addcart-half,
.tmb-dark.tmb .icon-badge > div,
.tmb-dark.tmb .icon-badge > a {
  color: #ffffff !important;
  background-color: rgba(38, 39, 41, 0.75);
}
/* #Thumbs background color */
/* #Thumbs overlay */
/* #Thumbs overlay gradient*/
.tmb.tmb-light.tmb-overlay-gradient-bottom .t-entry-visual .t-entry-visual-overlay-in {
  background-image: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, transparent 50%);
}
.tmb.tmb-dark.tmb-overlay-gradient-bottom .t-entry-visual .t-entry-visual-overlay-in {
  background-image: linear-gradient(to top, rgba(255, 255, 255, 0.5) 0%, transparent 50%);
}
.tmb.tmb-light.tmb-overlay-gradient-top .t-entry-visual .t-entry-visual-overlay-in {
  background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.75) 0%, transparent 50%);
}
.tmb.tmb-dark.tmb-overlay-gradient-top .t-entry-visual .t-entry-visual-overlay-in {
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5) 0%, transparent 50%);
}
/* #Thumbs elements border width*/
.tmb-border-width {
  border-width: 1px;
}
.tmb-border-reduced-width,
.el-text hr.separator-reduced {
  border-width: 2px;
}
/* #Thumbs shadow */
.tmb-with-shadow,
.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed.tmb .t-entry-visual,
.uncode-single-media-wrapper.tmb-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 5px 15px rgba(0, 0, 0, 0.05)' : '0px 7px 20px rgba(0, 0, 0, 0.05)' ; ?>;
}
/* #Thumbs border */
.tmb-light.tmb-border,
.tmb-light.tmb-bordered:not(.tmb-no-bg):not(.tmb-shadowed).tmb > .t-inside,
.tmb-light.tmb-bordered.tmb-no-bg.tmb > .t-inside .t-entry-visual {
  border: 1px solid #eaeaea;
}
.tmb-dark.tmb-border,
.tmb-dark.tmb-bordered:not(.tmb-no-bg):not(.tmb-shadowed).tmb > .t-inside,
.tmb-dark.tmb-bordered.tmb-no-bg.tmb > .t-inside .t-entry-visual {
  border: 1px solid #7a7d82;
}
.tmb-light.tmb-border-under {
  border-color: #eaeaea;
}
.tmb-dark.tmb-border-under {
  border-color: #ffffff;
}
.post-media .tmb-light .regular-text p,
.post-media .tmb-light .regular-text a,
.post-media .tmb-light .regular-text * {
  color: <?php echo sanitize_text_field($color_heading); ?>;
}
.post-media .tmb-light .regular-text .pullquote * {
  color: <?php echo sanitize_text_field($color_heading); ?> !important;
}
.post-media .tmb-dark .regular-text p,
.post-media .tmb-dark .regular-text a,
.post-media .tmb-dark .regular-text * {
  color: #ffffff;
}
.post-media .tmb-dark .regular-text .pullquote * {
  color: #ffffff !important;
}
/*
----------------------------------------------------------

#Shadows

----------------------------------------------------------
*/
.body-borders .body-border-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 0px 14px 0px rgba(0, 0, 0, 0.1)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
}
@media (min-width: 960px) {
  .menu-shadows {
    box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 4px 10px -10px rgba(0, 0, 0, 0.6)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
  }
  body[class*=vmenu-] .menu-shadows {
    box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 0px 7px -1px rgba(0, 0, 0, 0.1)' : '0px 0px 30px rgba(0, 0, 0, 0.075)' ; ?>;
  }
}
.btn-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 4px 10px -5px rgba(0, 0, 0, 0.6)' : '0px 4px 10px rgba(0, 0, 0, .1)' ; ?> !important;
}
.btn-shadow-sm.btn-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 4px 18px -4px rgba(0, 0, 0, 0.6)' : '0px 4px 20px rgba(0, 0, 0, 0.15)' ; ?> !important;
}
.btn-shadow-std.btn-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 8px 30px -6px rgba(0, 0, 0, 0.6)' : '0px 8px 30px rgba(0, 0, 0, 0.15)' ; ?> !important;
}
.btn-shadow-lg.btn-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 13px 34px -9px rgba(0, 0, 0, 0.6)' : '0px 12px 40px rgba(0, 0, 0, 0.20)' ; ?> !important;
}
.btn-shadow-xl.btn-shadow {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0 20px 50px -12px rgba(0, 0, 0, 0.6)' : '0px 16px 50px rgba(0,0,0,0.25)' ; ?> !important;
}
.unshadow-xs,
.uncell.unshadow-xs,
.uncont.unshadow-xs,
.menu-dd-shadow-xs.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-xs.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-xs.menu-horizontal .menu-smart > li.menu-item > .vc_row {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 5px 15px rgba(0, 0, 0, 0.05)' : '0px 7px 20px rgba(0, 0, 0, 0.05)' ; ?>;
}
.unshadow-darker-xs,
.menu-dd-shadow-darker-xs.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-darker-xs.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-darker-xs.menu-horizontal .menu-smart > li.menu-item > .vc_row {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 5px 15px rgba(0, 0, 0, 0.5)' : '0px 10px 20px rgba(0, 0, 0, 0.25)' ; ?>;
}
.unshadow-sm,
.uncell.unshadow-sm,
.uncont.unshadow-sm,
.tmb-shadowed-sm.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-sm.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-sm.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-sm.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-sm.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-sm.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-sm.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-sm.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-sm.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-sm.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-sm.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 20px 60px -30px rgba(0, 0, 0, 0.45)' : '0px 15px 30px rgba(0, 0, 0, 0.075)' ; ?>;
}
.unshadow-darker-sm,
.uncell.unshadow-darker-sm,
.uncont.unshadow-darker-sm,
.tmb-shadowed-darker-sm.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-darker-sm.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-darker-sm.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-sm.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-darker-sm.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-sm.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-darker-sm.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-darker-sm.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-darker-sm.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-darker-sm.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-darker-sm.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 20px 60px -30px rgba(0, 0, 0, 1)' : '0px 20px 40px rgba(0, 0, 0, 0.35)' ; ?>;
}
.unshadow-std,
.uncell.unshadow-std,
.uncont.unshadow-std,
.tmb-shadowed-std.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-std.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-std.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-std.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-std.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-std.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-std.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-std.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-std.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-std.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-std.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 30px 60px -30px rgba(0,0,0,.45)' : '0px 30px 60px rgba(0, 0, 0, 0.10)' ; ?>;
}
.unshadow-darker-std,
.uncell.unshadow-darker-std,
.uncont.unshadow-darker-std,
.tmb-shadowed-darker-std.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-darker-std.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-darker-std.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-std.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-darker-std.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-std.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-darker-std.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-darker-std.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-darker-std.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-darker-std.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-darker-std.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 30px 60px -30px rgba(0, 0, 0, 1)' : '0px 30px 60px rgba(0, 0, 0, 0.50)' ; ?>;
}
.unshadow-lg,
.uncell.unshadow-lg,
.uncont.unshadow-lg,
.tmb-shadowed-lg.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-lg.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-lg.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-lg.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-lg.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-lg.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-lg.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-lg.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-lg.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-lg.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-lg.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 55px 80px -40px rgba(0,0,0,.45)' : '0px 50px 100px rgba(0, 0, 0, 0.10)' ; ?>;
}
.unshadow-darker-lg,
.uncell.unshadow-darker-lg,
.uncont.unshadow-darker-lg,
.tmb-shadowed-darker-lg.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-darker-lg.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-darker-lg.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-lg.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-darker-lg.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-lg.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-darker-lg.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-darker-lg.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-darker-lg.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-darker-lg.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-darker-lg.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 55px 80px -40px rgba(0, 0, 0, 1)' : '0px 70px 140px rgba(0, 0, 0, 0.20)' ; ?>;
}
.unshadow-xl,
.uncell.unshadow-xl,
.uncont.unshadow-xl,
.tmb-shadowed-xl.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-xl.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-xl.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-xl.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-xl.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-xl.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-xl.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-xl.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-xl.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-xl.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-xl.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 70px 100px -40px rgba(0, 0, 0, 0.5)' : '0px 70px 140px rgba(0, 0, 0, 0.20)' ; ?>;
}
.unshadow-darker-xl,
.uncell.unshadow-darker-xl,
.uncont.unshadow-darker-xl,
.tmb-shadowed-darker-xl.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-darker-xl.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-darker-xl.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-xl.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-darker-xl.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-media-shadowed-darker-xl.tmb-media-shadowed.tmb .t-entry-visual,
.menu-dd-shadow-darker-xl.menu-horizontal .menu-smart > li.menu-item > ul,
.menu-dd-shadow-darker-xl.menu-horizontal .menu-smart > li.menu-item:not(.mega-menu) > ul ul,
.menu-dd-shadow-darker-xl.menu-horizontal .menu-smart > li.menu-item > .vc_row,
.uncell.tmb-media-shadowed-darker-xl.tmb-media-shadowed.tmb .t-entry-visual,
.uncont.tmb-media-shadowed-darker-xl.tmb-media-shadowed.tmb .t-entry-visual {
  box-shadow: <?php echo ( empty( $shadow_type ) ) ? '0px 70px 100px -40px rgba(0, 0, 0, 1)' : '0px 70px 140px rgba(0, 0, 0, 0.50)' ; ?>;
}
.unshadow-none,
.uncell.unshadow-hover-none:hover,
.uncont.unshadow-hover-none:hover,
.tmb-shadowed-none.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-none.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-darker-none.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-media-shadowed-darker-none.tmb-shadowed:not(.tmb-no-bg).tmb > .t-inside,
.tmb-shadowed-none.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-darker-none.tmb-shadowed.tmb-no-bg.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-none.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual,
.tmb-shadowed-hover-darker-none.tmb-shadowed.tmb-shadowed-hover.tmb-no-bg:hover.tmb > .t-inside .t-entry-visual {
  box-shadow: none;
}
/*
----------------------------------------------------------

#Corners

----------------------------------------------------------
*/
.unradius-xs,
.img-round-xs.img-round,
.img-round-xs.tmb-round,
.img-round-xs.img-round > img,
.img-round-xs.tmb-round > img,
.img-round-xs.img-round > .t-inside,
.img-round-xs.tmb-round > .t-inside,
.img-round-xs.img-round .t-entry-visual-cont > a,
.img-round-xs.tmb-round .t-entry-visual-cont > a,
.uncell.unradius-xs,
.uncont.unradius-xs,
.img-round-xs.img-round.tmb > .t-inside .t-entry-visual,
.img-round-xs.img-round.tmb > .t-inside .t-entry-visual-cont {
  border-radius: 2px;
  background-clip: padding-box;
}
.unradius-sm,
.img-round,
.tmb-round,
.img-round > .t-inside,
.tmb-round > .t-inside,
.img-round > img,
.tmb-round > img,
.img-round .t-entry-visual-cont > a,
.tmb-round .t-entry-visual-cont > a,
.img-round .t-entry-visual-cont > .dummy,
.tmb-round .t-entry-visual-cont > .dummy,
.uncell.unradius-sm,
.uncont.unradius-sm,
.img-round.tmb > .t-inside .t-entry-visual,
.img-round.tmb > .t-inside .t-entry-visual-cont {
  border-radius: 4px;
  background-clip: padding-box;
}
.unradius-std,
.img-round-std.img-round,
.img-round-std.tmb-round,
.img-round-std.img-round > img,
.img-round-std.tmb-round > img,
.img-round-std.img-round > .t-inside,
.img-round-std.tmb-round > .t-inside,
.img-round-std.img-round .t-entry-visual-cont > a,
.img-round-std.tmb-round .t-entry-visual-cont > a,
.uncell.unradius-std,
.uncont.unradius-std,
.img-round-std.img-round.tmb > .t-inside .t-entry-visual,
.img-round-std.img-round.tmb > .t-inside .t-entry-visual-cont {
  border-radius: 8px;
  background-clip: padding-box;
}
.unradius-lg,
.img-round-lg.img-round,
.img-round-lg.tmb-round,
.img-round-lg.img-round > img,
.img-round-lg.tmb-round > img,
.img-round-lg.img-round > .t-inside,
.img-round-lg.tmb-round > .t-inside,
.img-round-lg.img-round .t-entry-visual-cont > a,
.img-round-lg.tmb-round .t-entry-visual-cont > a,
.uncell.unradius-lg,
.uncont.unradius-lg,
.img-round-lg.img-round.tmb > .t-inside .t-entry-visual,
.img-round-lg.img-round.tmb > .t-inside .t-entry-visual-cont {
  border-radius: 12px;
  background-clip: padding-box;
}
.unradius-xl,
.img-round-xl.img-round,
.img-round-xl.tmb-round,
.img-round-xl.img-round > img,
.img-round-xl.tmb-round > img,
.img-round-xl.img-round > .t-inside,
.img-round-xl.tmb-round > .t-inside,
.img-round-xl.img-round .t-entry-visual-cont > a,
.img-round-xl.tmb-round .t-entry-visual-cont > a,
.uncell.unradius-xl,
.uncont.unradius-xl,
.img-round-xl.img-round.tmb > .t-inside .t-entry-visual,
.img-round-xl.img-round.tmb > .t-inside .t-entry-visual-cont {
  border-radius: 16px;
  background-clip: padding-box;
}
