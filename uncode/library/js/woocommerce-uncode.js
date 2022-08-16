(function($) {
	"use strict";

	function get_cart() {
		if (window.wc_add_to_cart_params != undefined) {
			$.post({
				url: wc_add_to_cart_params.ajax_url,
				dataType: 'JSON',
				data: {
					action: 'woomenucart_ajax'
				},
				success: function(data, textStatus, XMLHttpRequest) {
					$('.uncode-cart-dropdown').html(data.cart);
					if (data != '') {
						if ($('.uncode-cart .badge, .mobile-shopping-cart .badge').length) {
							if (data.articles > 0) {
								$('.uncode-cart .badge, .mobile-shopping-cart .badge').html(data.articles);
								$('.uncode-cart .badge, .mobile-shopping-cart .badge').show();
							} else {
								$('.uncode-cart .badge, .mobile-shopping-cart .badge').hide();
							}
						} else $('.uncode-cart .cart-icon-container').append('<span class="badge">' + data.articles + '</span>'); //$('.uncode-cart .badge').html(data.articles);
					}
				}
			});
		}

	}

	function remove_from_cart() {
		$(document).on('click', '.uncode-cart-dropdown a.remove', function(e){

			var $remove = $(this),
				product_id = $remove.attr("data-product_id"),
				item_key = $remove.attr("data-item_key"),
				$li = $remove.parents('.cart-item-list').eq(0).addClass('removing-item').animate({
					opacity: .5
				},150);

			$.post({
				dataType: 'json',
				url: wc_add_to_cart_params.ajax_url,
				data: {
					action: "woomenucart_remove_ajax",
					item_key: item_key
				},
				success: function(html){
					$li.slideUp(200, function(){
						get_cart();
					});
				}
			});

			return false;
		});
	}

	function change_images(event, variation) {
		UNCODE.single_product_variation_already_changed = true;
		if (variation.image_src !== '') {
			var $target = event.target,
				$row = $target.closest('.row-parent', $row),
				get_href = $('a.woocommerce-main-image', $row),
				$col_bg = $('.uncol-featured-image .background-inner', $row),
				image_variable = $('> img', get_href),
				image_thumb = variation.image.thumb_src,
				image_srcset = variation.thumb_srcset,
				getLightbox = UNCODE.lightboxArray[get_href.data('lbox')];
			get_href.data('options', "thumbnail: '" + variation.image_src + "'");
			image_variable.attr('src', variation.image_src);
			if ( image_variable.hasClass('async-done') ) {
				image_variable.attr('data-path', variation.uncode_image_path);
				image_variable.attr('data-guid', variation.uncode_image_guid);
				image_variable.removeClass('async-done').addClass('adaptive-async');
				UNCODE.adaptive();
			}
			if (getLightbox != undefined) getLightbox.refresh();
			$(window).trigger('focus');

			if ( $('.woocommerce-product-gallery-nav').length ) {
				var $first_thumb = $('.woocommerce-product-gallery-nav .woocommerce-product-gallery__wrapper-nav li.woocommerce-product-gallery__first-thumb img', $row);
				if ( SiteParameters.uncode_adaptive == true ) {
					var data_crop = $first_thumb.attr('data-crop'),
						data_singlew = $first_thumb.attr('data-singlew'),
						data_singleh = $first_thumb.attr('data-singleh');

					$first_thumb
						.attr('data-path', variation.uncode_image_path)
						.attr('data-guid', variation.uncode_image_guid)
						.attr('data-uniqueid', variation.data_uniqueid)
						.attr('data-width', variation.data_width)
						.attr('data-height', variation.data_height)
						.attr('data-singlew', variation.data_singlew)
						.attr('data-singleh', variation.data_singleh)
						.attr('data-crop', variation.data_crop)
						.removeClass('async-done').addClass('adaptive-async');
					UNCODE.adaptive();
				} else {
					$first_thumb
						.attr('src', image_thumb);
					if ( image_srcset ) {
						$first_thumb.attr('srcset', image_srcset);
					}
					$(window).trigger('woocommerce_variation_has_loaded');
				}
			}

			if ( $col_bg.length ) {
				var objImg = new Image(),
					bg_img_src;
				if ( $col_bg.hasClass( 'async-done') ) {
					bg_img_src = variation.image_link;
				} else {
					bg_img_src = variation.image_src;
				}
				objImg.src = bg_img_src;
				objImg.onload = function() {
					$col_bg.animate({ opacity: 0 }, 100, function(){
						$col_bg.css({'background-image':'url('+bg_img_src+')'});
						$col_bg.animate({ opacity: 1 }, 250);
					});
				}
			}
		}
	}

	function reset_data(event) {
		if ( UNCODE.single_product_variation_already_changed ) {
			var $col_bg = $('.uncol-featured-image .background-inner'),
				$first_thumb = $('.woocommerce-product-gallery__first-thumb img'),
				bg_img_src,
				bg_img_srcset,
				objImg = new Image();

			if ( $col_bg.length ) {
				bg_img_src = $col_bg.attr('data-o_src');
				objImg = new Image();
				objImg.src = bg_img_src;
				objImg.onload = function() {
					$col_bg.animate({ opacity: 0 }, 100, function(){
						$col_bg.css({'background-image':'url('+bg_img_src+')'});
						$col_bg.animate({ opacity: 1 }, 250);
					});
				}
			} else if ( $first_thumb.length ) {
				bg_img_src = $first_thumb.attr('data-o_src');
				bg_img_srcset = $first_thumb.attr('data-o_srcset');
				objImg = new Image();
				objImg.src = bg_img_src;
				objImg.onload = function() {
					$first_thumb
						.attr('src', bg_img_src)
						.attr('srcset', bg_img_srcset);
					$(window).trigger('woocommerce_variation_has_loaded');
				}
			}
		}
	}

	function check_variation_values(event) {
		var $selects = $(event.currentTarget).find('select'),
			checkSelectValues = false;
		$selects.each(function(){
			var $select = $(this);
			if ( $select.val() !== '' ) {
				checkSelectValues = true;
			}
		});

		if ( checkSelectValues ) {
			$(event.currentTarget).removeClass('hide-clear');
		} else {
			$(event.currentTarget).addClass('hide-clear');
		}

		setTimeout(function(){
			$(window).trigger('woocommerce_variation_has_loaded');
		}, 1250);
	}

	function reloadVariations() {
		remove_from_cart();
		$('body').on("added_to_cart wc_fragments_refreshed removed_from_cart", get_cart);
		$('.variations_form')
			.on("show_variation", change_images)
			.on("reset_data", reset_data)
			.on("check_variations", check_variation_values);
	}

	$(document).ready(reloadVariations);
	$(document).on('uncode-quick-view-loaded', reloadVariations);

	function handleRatings() {
		if ( $('#rating').length ) {
			setTimeout(function(){
				$('.comment-form-rating').each(function(){
					var $wrap = $(this),
						$stars = $('p.stars', $wrap).remove();
					$( 'select[name="rating"]', $wrap ).hide().before( '<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>' );
				});
			}, 10);
		}
	}

	$(document).ready(handleRatings);
	$(document).on('vc-uncode_single_product_reviews', handleRatings);

	$(document).on('vc-uncode_single_product_reviews', function(e, el) {
		if ( el !== 'undefined' ) {
			var $tabContainer = $(el).closest('.tab-container');
			$tabContainer.addClass('wootabs');
		}
	} );

	var scrollToReviews = function(){
		if ( $('.wootabs, .wpb_accordion').length ) {

			var hash = window.location.hash,
				url = window.location.href,
				$tabs = $( this ).find( 'ul.nav-tabs' ).first(),
				$accordion = $( this ).find('.panel-group').first(),
				scrollAction = false,
				$tabs_wrapper = $tabs.closest('.wootabs'),
				$both_wrapper,
				$li, $panel, $click_trigger = false;

			var scrollToReviewsInside = function( clicked ){

				if ( $tabs.length && $('#reviews', $tabs_wrapper).length ) {
					var tab_reviews = $('#reviews', $tabs_wrapper).first().closest('.tab-pane').attr('id');
					$('[data-tab-id="' + tab_reviews + '"]', $tabs).addClass('reviews_tab');
					$li = $('.reviews_tab', $tabs);
					$both_wrapper = $tabs_wrapper;
					$click_trigger = true;
				} else if ( $accordion.length && $('#reviews', $accordion).length ) {
					var tab_reviews = $('#reviews', $accordion).first().closest('.tab-pane').attr('id');
					$panel = $('#reviews', $accordion).first().closest('.panel');
					$li = $('.panel-title', $panel);
					$both_wrapper = $accordion;
					$click_trigger = true;
				} else if ( $('div#reviews').length && clicked ) {
					$both_wrapper = $('div#reviews');
					scrollAction = true;
				} else {
					return false;
				}

				if ( $click_trigger && ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' || hash === '#tab-reviews' ) ) {
					$( 'a', $li ).click();
					scrollAction = true;
				} else if ( $click_trigger && ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) ) {
					$( 'a', $li ).click();
					scrollAction = true;
				}

				if ( scrollAction ) {
					var body = $("html, body"),
						bodyTop = document.documentElement['scrollTop'] || document.body['scrollTop'],
						delta = bodyTop - ($both_wrapper.length ? $both_wrapper.offset().top : 0),
						getOffset = UNCODE.get_scroll_offset();
					if ( typeof $both_wrapper.offset() === 'undefined' )
						return;
					scrollTo = $both_wrapper.offset().top - 27;
					scrollTo -= getOffset;

					var scrollSpeed = (SiteParameters.constant_scroll == 'on') ? Math.abs(delta) / parseFloat(SiteParameters.scroll_speed) : SiteParameters.scroll_speed;
					if (scrollSpeed < 1000 && SiteParameters.constant_scroll == 'on') scrollSpeed = 1000;

					if (scrollSpeed == 0) {
						body.scrollTop((delta > 0) ? scrollTo - 0.1 : scrollTo);
					} else {
						body.animate({
							scrollTop: (delta > 0) ? scrollTo - 0.1 : scrollTo
						}, scrollSpeed, 'easeInOutQuad');
					}
				} else {
					return false;
				}
			};

			scrollToReviewsInside( false );

			$('a.woocommerce-review-link').on('click', function(e) {
				e.preventDefault();
				hash = '#reviews';
				scrollToReviewsInside( true );
			});

		}
	}
	$(document).ready(scrollToReviews);

	var qtyPlusMinus = function(){
		$('.qty-inset:not(.qty-inset-active)').each(function(){
			var $qtyInsets = $(this).addClass('qty-inset-active'),
				$input = $('input.qty', $qtyInsets),
				$minus = $('.qty-minus', $qtyInsets),
				$plus = $('.qty-plus', $qtyInsets),
				step = parseFloat( $input.attr('step') ),
				min = parseFloat( $input.attr('min') ),
				max = parseFloat( $input.attr('max') ),
				value = parseFloat( $input.val() );

			if ( isNaN(step) ) {
				step = 1;
			}

			if ( isNaN(min) ) {
				min = 1;
			}

			if ( isNaN(value) ) {
				value = 0;
				$input.val( value );
			}

			$minus.on('click', function(){
				value = parseFloat( $input.val() ) - step;
				if ( value < min ) {
					value = min;
				}
				$input.val( value ).trigger( 'change' );
			});

			$plus.on('click', function(){
				value = parseFloat( $input.val() ) + step;
				if ( isNaN(max) && value > max ) {
					value = max;
				}
				$input.val( value ).trigger( 'change' );
			});
		});
	};

	var resizeCartRow = function(){
		if ($('form.woocommerce-cart-form').length > 0) {
			window.dispatchEvent(new CustomEvent('vc-resize'));
		}
	};

	$(document.body).on('updated_cart_totals', qtyPlusMinus);
	$(document.body).on('updated_cart_totals', resizeCartRow);
	$(document).ready(qtyPlusMinus);
	$(document).on('vc-frontend:vc_button', qtyPlusMinus);

	var woocommerce_product_gallery = function() {
		$( 'body:not(.single-uncodeblock) .woocommerce-product-gallery' ).each( function() {

	  		var $slider = $(this),
				$parent = $slider.closest('.uncode-wrapper').length ? $slider.closest('.uncode-wrapper') : $slider.closest('.uncont'),
				cols = parseFloat( $slider.attr('data-columns') ),
				dots = $parent.attr('data-dots') == 'true',
				gutter = $parent.length && typeof $parent.attr('data-gutter') !== 'undefined' ? parseFloat( $parent.attr('data-gutter') ) : 18,
				$main = $('.woocommerce-product-gallery__wrapper', $parent),
				mainL = $main.find('.woocommerce-product-gallery__image').length,
				$thumbs = $('.woocommerce-product-gallery__wrapper-nav', $parent),
				thumbsL = $thumbs.find('li').length;

			if ( mainL > 1 && $slider.hasClass('owl-carousel-wrapper') ) {
				$main.owlCarousel({
					items: 1,
					autoHeight: true,
					dots: dots,
					responsiveRefreshRate: 200,
				}).on('changed.owl.carousel', function(event) {
					if (event.namespace && event.property.name === 'position') {
						var target = event.relatedTarget.relative(event.property.value, true);
						syncPosition(target);
					}
				});
				$main.on('translate.owl.carousel', function(event) {
					$(event.currentTarget).addClass('owl-translating');
				});
				$main.on('translated.owl.carousel', function(event) {
					$(event.currentTarget).removeClass('owl-translating');
				});
				$thumbs.on('initialized.owl.carousel', function(event) {
					$thumbs.closest('.woocommerce-product-gallery-nav-wrapper').css({
						opacity: 1
					});
				}).owlCarousel({
					items: cols,
					margin: gutter,
					autoHeight: true,
					nav: true,
					mouseDrag: cols < thumbsL,
					navText: ['<div class="owl-nav-container btn-default btn-hover-nobg"><i class="fa fa-fw fa-angle-left"></i></div>', '<div class="owl-nav-container btn-default btn-hover-nobg"><i class="fa fa-fw fa-angle-right"></i></div>'],
					responsiveRefreshRate: 100,
				});
				$(window).on('load uncode-quick-view-first-hover woocommerce_variation_has_loaded', function(){
					$main.trigger('refresh.owl.carousel');
					$thumbs.trigger('refresh.owl.carousel');
				});
			}

			function syncPosition(target){
				var data = $thumbs.data('owl.carousel');
				if ( ! $('.owl-item', $thumbs).eq( target ).hasClass('active') ) {
					$thumbs.owlCarousel( 'to', target, 300, true );
				}
			}

			$thumbs.on( 'click', '.owl-item', function(e){
				e.preventDefault();
				var number = $(this).index();
				$main.owlCarousel( 'to', number, 300, true );
			});


			if ($.fn.zoom && $('body').hasClass('wc-zoom-enabled') ) {
				var $zoomTrgt = $('.woocommerce-product-gallery__image', $slider);

				if ( $('.thumbnails', $slider).length )
					$zoomTrgt = $zoomTrgt.first();

				$zoomTrgt.trigger( 'zoom.destroy' );
				$zoomTrgt.zoom();

				var checkForZoom = function(){
					$('.woocommerce-product-gallery__image').each(function(){
						var $wrap = $(this),
							$zoomImg = $('.zoomImg', $wrap);

						if (UNCODE.isMobile || !$zoomImg.length) {
							$wrap.addClass('mouse-moving');
						}
					});

					var galleryWidth = $zoomTrgt.width(),
						zoom_options = {
							touch: true,
							callback: function(){
								$('.woocommerce-product-gallery__image').each(function(){
									var $wrap = $(this),
										$zoomImg = $('.zoomImg', $wrap),
										$overZoom = $('.zoom-overlay', $wrap),
										$imageIL = $('a[data-lbox]', $wrap),
										$carousel = $wrap.closest('.owl-carousel');

									$wrap.prepend($zoomImg);
									if (UNCODE.isMobile || !$zoomImg.length) {
										$wrap.addClass('mouse-moving');
										$zoomImg.css({
											'visibility':'hidden'
										});
									}

									/* Make work everything on touch events */
									var onlongtouch,
										timer,
										now,
										touchduration = 500,
										startX = 0, startY, newX, newY;

									$wrap.parent().on('mousemove.zoom', function(){
										if ( ! $wrap.hasClass('mouse-moving') ) {
											if ( startX == 0 ) {
												startX = event.clientX;
												startY = event.clientY;
											}
											newX = event.clientX;
											newY = event.clientY;
											if ( Math.abs( newX - startX ) > 50 && Math.abs( newY - startY ) > 50 ) {
												$wrap.addClass('mouse-moving');
											}
										}
									});

									$overZoom.on('touchstart.zoom', function (e) {
										now = new Date().getTime();
									}).on('touchmove.zoom', function (e) {
										setTimeout(function(){
											$zoomImg.css({
												'visibility':'visible'
											});
										}, 100);
									}).on('touchend.zoom', function (e) {
										var newTap = new Date().getTime();
										if ( newTap - now < 75 && ! $('body').hasClass('ilightbox-noscroll') ) {
											$imageIL.trigger('itap.iL');
										}
										if (UNCODE.isMobile) {
											$zoomImg.css({
												'visibility':'hidden'
											});
										}
									});

								});
							}
						};

					if ( 'ontouchstart' in window ) {
						zoom_options.on = 'click';
					}

					$zoomTrgt.trigger( 'zoom.destroy' );
					$zoomTrgt.each(function(){
						var $thisTrgt = $(this),
							$img = $('img', $thisTrgt);

						if ( $img.data( 'large_image_width' ) > galleryWidth ) {
							$thisTrgt.zoom(zoom_options);
						} else {
							$thisTrgt.trigger( 'zoom.destroy' );
						}

					});
				};
				checkForZoom();

				var setCheckForZoom;
				$(window).on( 'resize', function(){
					clearTimeout(setCheckForZoom);
					setCheckForZoom = setTimeout( checkForZoom, 500 );
				});
			}

		} );

		$(window).on('unmodal-open', function(){
			$('#unmodal-content .woocommerce-product-gallery__image').removeClass('mouse-moving');
		})
		$(document).on('unmodal-close', function(){
			$('#unmodal-content .woocommerce-product-gallery__image').removeClass('mouse-moving');
		})
	}

	woocommerce_product_gallery();

	/************************************************************
	 * Redirect to custom empty cart page
	 ************************************************************/

	$(document.body).on('wc_cart_emptied', redirect_to_custom_empty_cart);

	function redirect_to_custom_empty_cart() {
		if (UncodeWCParameters.empty_cart_url !== '') {
			window.location.replace(UncodeWCParameters.empty_cart_url);
		}
	}

	/************************************************************
	 * Make the variation price inherit the font family from main price
	************************************************************/

	function variation_price_font() {

		var $forms = $('form.variations_form');

		$forms.each(function(){
			var $form = $(this);

			$form.on('woocommerce_variation_has_changed wc_variation_form', function(){
				var $var_price = $('.woocommerce-variation-price .woocommerce-Price-amount'),
					$row = $form.closest('.vc_row'),
					$main_price = $('.heading-text .woocommerce-Price-amount', $row);

				if ( $main_price.length ) {
					var $price_wrap = $main_price.closest('.heading-text'),
						$price_nest = $('> *:first-child', $price_wrap),
						font_class = $price_nest.attr('class').split(' '),
						i;

					for ( i = 0; i < font_class.length; i++ ) {
						if ( font_class[i].indexOf('font') !== -1 && font_class[i].indexOf('fontsize') === -1 ) {
							$var_price.addClass( font_class[i] );
						}
					}
				}
			});
		});
	}

	$(document).ready(function() {
		variation_price_font();
	});

	/************************************************************
	 * Show minicart when adding something
	************************************************************/

	var cartShow, cartHover;

	var minicart_notify = function(){
		var $body = $('body');

		if ( ! $body.hasClass('minicart-notification') ) {
			return false;
		}

		var $sidecart = $('#uncode_sidecart'),
			$miniCart = $('.menu-smart .uncode-cart-dropdown'),
			$smartMenu = $miniCart.closest('.menu-smart');

		$miniCart.on('hover', function(){
			clearTimeout(cartHover);
		});

		var show_added_to_cart = function(e){

			clearTimeout(cartShow);
			clearTimeout(cartHover);

			if ( $sidecart.length ) {
				$sidecart.imagesLoaded().done( function( instance ) {
					setTimeout(function(){
						$body.addClass('uncode-sidecart-open');
						$(window).trigger('uncode-sidecart-open');
					}, 500);
				});
			}

			var show_added_to_cart_timeout = function(){
				cartShow = setTimeout(function(){
					$miniCart.imagesLoaded().done( function( instance ) {
						$smartMenu.smartmenus('itemActivate', $('.uncode-cart > a'));
						cartHover = setTimeout(function(){
							$smartMenu.smartmenus('menuHideAll');
						}, 4000);
					});
				}, 500);
			};

			if ( UNCODE.wwidth >= 960 ) {
				if ( e == 'uncode-wc-added-to-cart' ) {
					show_added_to_cart_timeout();
				} else {
					$( document.body ).on( 'wc_fragments_loaded', function(){
						show_added_to_cart_timeout();
					});
				}
			}
		};
		$( document.body ).on( 'added_to_cart', show_added_to_cart );

		$(document).ready(function() {
			if ( $('body').hasClass('uncode-wc-added-to-cart')) {
				show_added_to_cart('uncode-wc-added-to-cart');
			}
		});

	};

	minicart_notify();

	/************************************************************
	 * View Cart Button
	************************************************************/
	$( document.body ).on( 'wc_cart_button_updated', function(e, $button){
		if ( $(document.body).hasClass('minicart-notification') ) {
			return false;
		}

		$button
			.addClass('added_and_noted')
			.removeClass('ajax_add_to_cart')
			.find('.added_to_cart')
			.text( wc_add_to_cart_params.i18n_view_cart )
			.on('click', function(e){
				e.preventDefault();
				window.location.href = wc_add_to_cart_params.cart_url;
				return false;
			});
	});

	/************************************************************
	 * Side Cart
	************************************************************/
	var init_sidecart = function(){
		var $body = $('body.uncode-sidecart-enabled');
		if ( ! $body.length ) {
			return false;
		}

		var $cart_icon = $('.mobile-shopping-cart, .uncode-cart.menu-item-link > a'),
			$sidecart = $('#uncode_sidecart'),
			$view_cart = $('a.wc-forward:not(.checkout)', $sidecart).removeClass('btn-sm'),
			$checkout = $('a.checkout', $sidecart).removeClass('btn-sm').addClass('btn-flat'),
			$overlay = $('#uncode_sidecart_overlay'),
			$close_cart = $('.close-mini-cart', $sidecart),
			sidecart_hover = false;

		$cart_icon.on('click', function( e ){
			if ( $sidecart.length && ! ( $(this).closest('.overlay').length && UNCODE.wwidth > UNCODE.mediaQuery ) && ( ! ( $body.hasClass('uncode-sidecart-mobile-disabled') && UNCODE.wwidth <= UNCODE.mediaQuery ) ) ) {
				e.preventDefault();
				e.stopPropagation();
				$body.addClass('uncode-sidecart-open');
				$(window).trigger('uncode-sidecart-open');
			}
		});

		$sidecart.on('mouseover',function(){
			sidecart_hover = true;
		}).on('mouseout', function(){
			sidecart_hover = false;
		});

		$body.on('click', function( e ){
			if ( $body.hasClass('uncode-sidecart-open') && !sidecart_hover ) {
				$body.removeClass('uncode-sidecart-open');
				$(window).trigger('uncode-sidecart-closed');
			}
		});

		$close_cart.on('click', function( e ){
			e.preventDefault();
			$body.removeClass('uncode-sidecart-open');
			$(window).trigger('uncode-sidecart-closed');
		});
	};
	$(document).ready(function(){
		init_sidecart();
	});
	$( document.body ).on("wc_fragments_refreshed added_to_cart removed_from_cart", function(){
		init_sidecart();
		requestTimeout( init_sidecart, 1 );
	});

	var sidecart_size = function(){
		var $body = $('body.uncode-sidecart-enabled'),
			$widget_cart = $('.widget_shopping_cart_content'),
			$mini_cart_item = $('.mini_cart_item', $widget_cart);

		if ( $widget_cart.length ) {
			$mini_cart_item.each(function(){
				var $this = $(this),
 					$img_product = $('.attachment-woocommerce_thumbnail', $this),
 					imgH = $img_product.height();

 				$this.css({
 					'min-height': imgH+6
 				})

			});
		}
		if ( $body.length ) {

			var $sidecart = $('#uncode_sidecart'),
				$cart_header = $('.woocommerce-mini-cart-header', $sidecart),
				headerH = $cart_header.outerHeight(),
				$cart_footer = $('.woocommerce-mini-cart-footer', $sidecart),
				footerH = $cart_footer.outerHeight(),
				$cart_body = $('.woocommerce-mini-cart-body', $sidecart);

			$cart_body.css({
				'padding-top':headerH,
				'padding-bottom':footerH
			});

		}
	};
	$(document).ready(function(){
		var setCTA;
		sidecart_size();
		requestTimeout(function(){
			$(window).on( 'resize', function(){
				clearRequestTimeout(setCTA);
				setCTA = requestTimeout( sidecart_size, 100 );
			});
		}, 400);
	});
	$( document.body ).on("wc_fragments_refreshed added_to_cart removed_from_cart", function(){
		sidecart_size();
		requestTimeout( sidecart_size, 1 );
	});

	/************************************************************
	 * Quick view
	 ************************************************************/

	var modal_quick_view_content = $('.quick-view-content');
	var last_viewed_product_id;

	$(document).off('click', '.quick-view-button').on('click', '.quick-view-button', function() {
		var _this = $(this);
		var product_id = _this.data('post-id');
		var post_type = _this.data('post-type');

		if (last_viewed_product_id === product_id && modal_quick_view_content.find('#product-' + product_id).length > 0) {
			$(document).trigger('uncode-unmodal-show-content');

			// Re-open the open the modal instead of regenerating it
			return false;
		}

		// Empty modal
		if (modal_quick_view_content.length > 0) {
			modal_quick_view_content.html('');
		}

		// Get quick view content via AJAX
		$.ajax({
			url: woocommerce_params.ajax_url,
			data: {
				action: 'uncode_load_ajax_quick_view',
				post_id: product_id,
				post_type: post_type,
			},
			type: 'post',
			error: function(data) {
				if (SiteParameters.enable_debug == true) {
					// This console log is disabled by default
					// So nothing is printed in a typical installation
					//
					// It can be enabled for debugging purposes setting
					// the 'uncode_enable_debug_on_js_scripts' filter to true
					console.log('AJAX error on quick view response');
				}
			},
			success: function(response) {
				if (response && response.success === false) {
					if (SiteParameters.enable_debug == true) {
						// This console log is disabled by default
						// So nothing is printed in a typical installation
						//
						// It can be enabled for debugging purposes setting
						// the 'uncode_enable_debug_on_js_scripts' filter to true
						if (response.data.error) {
							console.log(response.data.error);
						} else {
							console.log('Unknown error on quick view response');
						}
					}
				} else {
					var html = response.data.html;

					if (modal_quick_view_content.length > 0) {
						modal_quick_view_content.html(html);
					}

					last_viewed_product_id = product_id;

					modal_quick_view_content.imagesLoaded().done( function( instance ) {
						$(document).trigger('uncode-unmodal-show-content');
						$(document).trigger('uncode-quick-view-loaded');
						window.dispatchEvent(new CustomEvent('uncode-quick-view-loaded'));

						setTimeout(function(){
							modal_quick_view_content.one('mousemove', function(){
								window.dispatchEvent(new CustomEvent('uncode-quick-view-first-hover'));
							});
						}, 10);
					});
				}
			}
		});

		return false;
	});

	$(document).on('uncode-quick-view-loaded', function() {
		var form_variation = modal_quick_view_content.find('.variations_form');

		form_variation.each(function() {
			$(this).wc_variation_form();
		});

		form_variation.trigger('check_variations');
		form_variation.trigger('reset_image');

		if( typeof $.fn.wc_product_gallery !== 'undefined' ) {
			modal_quick_view_content.find('.woocommerce-product-gallery').each(function(){
				$(this).wc_product_gallery();
			});
		}

		$( '#unmodal-content' ).on( 'change', '.quantity .qty', function() {
			jQuery( this ).closest('form.cart').find('.add_to_cart_button').attr( 'data-quantity', jQuery( this ).val() );
		});

		woocommerce_product_gallery();
		variation_price_font();
		qtyPlusMinus();

		UNCODE.preventDoubleTransition();
		UNCODE.utils();
		UNCODE.okvideo();
		UNCODE.tapHover();
		UNCODE.isotopeLayout();
		UNCODE.justifiedGallery();
		UNCODE.lightbox();
		UNCODE.carousel($('body'));
		UNCODE.lettering();
		UNCODE.animations();
		UNCODE.stickyElements();
		UNCODE.twentytwenty();
		UNCODE.disableHoverScroll();
		uncode_progress_bar();
		UNCODE.filters();
		UNCODE.widgets();

	});

	/************************************************************
	 * Trigger fragments
	 ************************************************************/
	if ( SiteParameters.update_wc_fragments == true ) {
		$(document).ready(function() {
			$(document.body).trigger('wc_fragment_refresh');
		});
	}

})(jQuery);
