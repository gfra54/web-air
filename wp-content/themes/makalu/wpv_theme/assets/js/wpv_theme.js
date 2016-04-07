/* jshint trailing: true, multistr: true */

jQuery.WPV = jQuery.WPV || {}; // Namespace

var MEDIA = {
	layout : {}
};

/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT / GPLv2 License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	var ua = navigator.userAgent;
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && /OS [1-5]_[0-9_]* like Mac OS X/i.test(ua) && ua.indexOf( "AppleWebKit" ) > -1 ) ){
		return;
	}

    var doc = w.document;

    if( !doc.querySelector ){ return; }

    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;

    if( !meta ){ return; }

    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true;
    }

    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false;
    }

    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );

		// If portrait orientation and in one of the danger zones
        if( (!w.orientation || w.orientation === 180) && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){
				disableZoom();
			}
        }
		else if( !enabled ){
			restoreZoom();
        }
    }

	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );

})( this );

jQuery.mediaWidth = function() {
	if (this.browser.mozilla || window.opera || (this.browser.msie && parseInt(this.browser.version, 10) >= 9)) {
		return window.innerWidth;
	}
	return (document.body && document.body.clientWidth) ||
			(document.documentElement && document.documentElement.clientWidth) ||
			(window.jQuery && jQuery(window).width()) ||
			window.innerWidth;
};

(function ($, undefined) {
	var DEBUG     = false;
	var J_WIN     = $(window);
	var J_HTML    = $("html");
	var WIN_WIDTH = $.mediaWidth();
	var IS_TOUCH  = 'ontouchstart' in document.documentElement;
	var IS_RESPONSIVE = $("body").hasClass("responsive-layout");

	$.fn.aPosition = function() {
		thisLeft = this.offset().left;
		thisTop = this.offset().top;
		thisParent = this.parent();

		parentLeft = thisParent.offset().left;
		parentTop = thisParent.offset().top;

		return {
			left: thisLeft-parentLeft,
			top: thisTop-parentTop
		};
	};

	// @MEDIA (size only)
	// =========================================================================
	var LAYOUT_SIZES = [
		{ min: 0   , max: 479     , className : "layout-smallest"},
		{ min: 480 , max: 767     , className : "layout-small"   },
		{ min: 768 , max: 959     , className : "layout-medium"  },
		{ min: 1000, max: Infinity, className : "layout-max"     },

		{ min: 0   , max: 767     , className : "layout-below-medium"},
		{ min: 0   , max: 999     , className : "layout-below-max"   }
	];

	if (IS_RESPONSIVE) {
		var lastClass, sizesLength = LAYOUT_SIZES.length, i;
			J_WIN.bind('resize.sizeClass load.sizeClass', function () {
			WIN_WIDTH = $.mediaWidth();

			var toAdd = [],
				toDel = [];
				map   = {};

			for (i = 0; i < sizesLength; i++) {
				if (WIN_WIDTH >= LAYOUT_SIZES[i].min && WIN_WIDTH <= LAYOUT_SIZES[i].max) {
					toAdd.push(LAYOUT_SIZES[i].className);
					map[LAYOUT_SIZES[i].className] = true;
				}
				else {
					toDel.push(LAYOUT_SIZES[i].className);
					map[LAYOUT_SIZES[i].className] = false;
				}
			}

			MEDIA.layout = map;

			toAdd = toAdd.join(" ");
			toDel = toDel.join(" ");
			var title = WIN_WIDTH;
			if (lastClass != toAdd) {
				lastClass = toAdd;

				J_HTML.removeClass(toDel).addClass(toAdd);
				J_WIN.trigger("switchlayout");
			}
			if (DEBUG) document.title = title + " | " + toAdd;
		});
	} else {
		J_HTML.removeClass("layout-smallest layout-small layout-medium layout-below-medium layout-below-max")
			.addClass("layout-max");
		MEDIA.layout = { "layout-max" : true };
	}

	var delayedResizeTimeout;
	function delayedResizeHandler() {
		if (delayedResizeTimeout) {
			window.clearTimeout(delayedResizeTimeout);
		}
		delayedResizeTimeout = setTimeout(function() {
			J_WIN.trigger("delayedResize");
		}, 150);

	}
	J_WIN.bind('resize',  delayedResizeHandler);

	$(function () {
		if ($("body").is(".responsive-layout")) {
			J_WIN.triggerHandler('resize.sizeClass');
		}

		(function() {
			var wrap = $('#header-slider-container.layerslider').find('.layerslider-fixed-wrapper');
				first = wrap.find('>div:first');

			if(!first.length) return;

			var timeout = false,
				wait = 0,
				remove_height = function() {
					if(first.height() > 0 || wait++ > 5) {
						wrap.height('auto');
						return;
					}

					timeout = setTimeout(remove_height, 500);
				};

			timeout = setTimeout(remove_height, 0);
		})();

		// Menu related
		// =====================================================================
		$(".menu-item > .sub-menu").each(function() {
			$(this).parent().addClass("has-submenu");
		});

		$("#search-text-widget, #top-search-submit").bind({
			focus : function() { $(this).closest(".search-extend").addClass("expanded"); },
			click : function() { $(this).closest(".search-extend").addClass("expanded").find('#search-text-widget').focus(); },
			blur  : function() { $(this).closest(".search-extend").removeClass("expanded"); }
		});

		if(IS_RESPONSIVE || !IS_TOUCH) {
			$('#menus').bind($.WPV.Constants.Events.touchstart, function(e) {
				e.stopPropagation();
			});

			$("#main-menu a").bind("click", function(e) {
				e.stopPropagation();
				if ($(this).parent().is('.has-submenu') && $(window).width() - e.pageX < 80) {

				var hideOthers = function(callback) {
						var toHide = $(e.target).parent().siblings().find('.sub-menu');
						if (toHide.length) {
							var hidden = 0;
							toHide.each(function() {
								var h = $(this).height();
								if (h) {
									$(this).css("height", h).setTransition({"height": 0}, 600, "swing", 0, function() {
										if (++hidden >= toHide.length) {
											callback();
										}
									});
								} else {
									hidden++;
								}
							});
							if (hidden >= toHide.length) {
								callback();
							}
						}
						else {
							callback();
						}
					};

					hideOthers(function() {
						var sub = $(e.target).next('.sub-menu');
						if (sub) {
							var h = sub.height();
							if (h) {
								sub.css("height", h).setTransition({ "height": 0 }, 600, "swing");
							}
							else {
								sub.css("height", h).setTransition({"height": sub[0].scrollHeight}, 600, "swing", 0, function() {
									sub.css("height", "auto");
								});
							}
						}
					});

					return false;
				}
			});
		} else {
			$("#main-menu .menu .menu-item").each(function (i, o) {
				$(this).find("ul").css({
					visibility: "hidden",
					display: "none"
				});

				$(this).hover(

				function () {

					$('ul:first', this).stop(1, 1).queue(function () {

						if ($(o).is(".hover")) {
							return;
						}

						var submenu = $('ul:first', o);
						var thisOffset = $(o).offset();
						var vw = $(window).width();
						var isFirst = submenu.is("#main-menu .menu > .menu-item > .sub-menu ");

						submenu.css({
							visibility: "hidden",
							display: "block"
						});

						$(o).addClass("hover");

						if (thisOffset.left + $(o).outerWidth({margin: true}) + submenu.outerWidth({margin: true}) > vw) {
							submenu.css({
								right: isFirst ? 0 : "100%",
								left: "auto"
							});
						} else {
							submenu.css({
								left: isFirst ? 0 : "100%",
								right: "auto"
							});
						}

						$(this).css({
							visibility: "visible",
							'z-index': 500000
						});
					});
				}, function () {
					$('ul:first', this).stop(1, 0).queue(function () {
						$(this).css({
							display: "none"
						});
						$(o).removeClass("hover");
					});
				});
			});
		}

		//infinite scrolling
		if($('body').is('.pagination-infinite-scrolling')) {
			var last_auto_load = 0;
			$(window).bind('resize scroll', function(e) {
				var button = $('.lm-btn');
				if(e.timeStamp - last_auto_load > 500 && button.css('opacity') == 1 && $(window).scrollTop() + $(window).height() >= button.offset().top) {
					last_auto_load = e.timeStamp;
					button.click();
				}
			});
		}

		if($('html').is('.placeholder')) {
			$.rawContentHandler(function() {
				$('.label-to-placeholder label[for]').each(function() {
					$('#' + $(this).prop('for')).attr('placeholder', $(this).text());
					$(this).hide();
				});
			});
		}

		// Video resizing
		// =====================================================================
		J_WIN.bind('resize.video load.video', function() {
			$('.post-video, .portfolio_image_wrapper, .boxed-layout .video_frame').find('iframe, object, embed, video').each(function() {
				var v = $(this);

				if(v.prop('width') == '0' && v.prop('height') == '0') {
					v.css({width: '100%'})
						.css({height: v.width()*9/16});
					} else {
					v.css({height: v.prop('height')*v.width()/v.prop('width')});
				}
			});
		}).triggerHandler("resize.video");

		// Scale HTML in header-slider
		// =====================================================================
		(function() {
			var MIN_WIDTH    = 320,
				MAX_WIDTH    = 960,
				MIN_FONTSIZE = 12,
				MIN_SCALE    = 0.6,
				toScale,
				scale;

			function scaleFonts(toScale, w) {
				var q = Math.max(w, MIN_WIDTH) / MAX_WIDTH;

				toScale.each(function() {
					var baseSize = $(this).data("baseFontSize");
					if (!baseSize) {
						baseSize = parseFloat($(this).css("font-size"));
						$(this).data("baseFontSize", baseSize);
					}

					if (w >= MAX_WIDTH) {
						$(this).css("font-size", baseSize);
					} else {
						$(this).css("font-size", Math.max(baseSize * q, MIN_FONTSIZE));
					}
				});
			}

			// Use transforms to scale
			if ($.WPV.Constants.vendor.transformOrigin && $.WPV.Constants.vendor.transform) {
				scale = function(elem, w) {
					var q = Math.max(Math.min(w / (MAX_WIDTH - MIN_WIDTH), 1), MIN_SCALE);
					$(".table", elem).each(function() {
						var css = {};
						css[$.WPV.Constants.vendor.transform] = "scale(" +
							($(this).is(".layout-below-medium .makalu-slide-2 .table") ? 1 : q) +
							")";
						css[$.WPV.Constants.vendor.transformOrigin] = "50% 100%";
						$(this).css(css);
					});
					scaleFonts($(".caption", elem), w);
				};
			}

			// Use font-size to scale
			else {
				scale = function(elem, w) {
					toScale = $(".slide-wrapper .slide.type-html .scale-font, .caption", elem);
					scaleFonts(toScale, w);
				};
			}

			$("#header-slider").bind("elementResize", function(e, d) {
				scale(this, d.width);
			});
		})();

		// Animated buttons
		// =====================================================================
		$('.animated.flash, .animated.wiggle').live('mouseover focus click', function() {
			$(this).removeClass('animated');
		});

		// Create the full-screen slider and add it's keyboard navigation
		// =====================================================================
		if ($.isArray(window.wpvBgSlides)) {
			var body = $('body');
			body.fastSlider({}, wpvBgSlides);

			$(window).bind('keydown', function(e) {
				switch(e.keyCode || e.which) {
					case 37:
						if(body.data("fastSlider"))
							body.data("fastSlider").prev();
					break;
					case 38:
						if(body.data("fastSlider"))
							body.data("fastSlider").goToPrevGalleryItem();
					break;
					case 39:
						if(body.data("fastSlider"))
							body.data("fastSlider").next();
					break;
					case 40:
						if(body.data("fastSlider"))
							body.data("fastSlider").goToNextGalleryItem();
					break;
				}
			});
		}

		// Print Button in page-header
		// =====================================================================
		// $('<span class="print-btn"/>').insertBefore(".page-header .spacer");

		// Tooltip
		// =====================================================================
		var tooltip_animation = 250;
		$('.shortcode-tooltip').hover(function () {
			var tt = $(this).find('.tooltip').fadeIn(tooltip_animation).animate({
				bottom: 25
			}, tooltip_animation);
			tt.css({ marginLeft: -tt.width() / 2 });
		}, function () {
			$(this).find('.tooltip').animate({
				bottom: 35
			}, tooltip_animation).fadeOut(tooltip_animation);
		});

		$('#commentform, .searchform').validator();

		$('.post-head a img').parent().addClass('a-reset');

		$('.sitemap li:not(:has(.children))').addClass('single');

		jQuery.WPV.initHoverFX = function() {};

		// Starts Portfolio
		// =====================================================================

		function getPortfolioColumnCount($ul) {
			var cnt = 1;
			if ($ul.is(".portfolio_two_columns"))
				cnt = 2;
			else if ($ul.is(".portfolio_three_columns"))
				cnt = 3;
			else if ($ul.is(".portfolio_four_columns"))
				cnt = 4;

			if (MEDIA.layout["layout-smallest"])
				return 1;
			if (MEDIA.layout["layout-small"])
				return Math.min(2, cnt);
			if (MEDIA.layout["layout-medium"])
				return Math.min(3, cnt);

			return Math.min(4, cnt);

		}

		function getPortfolioColumnWidth($ul) { // float

			switch (getPortfolioColumnCount($ul)) {
				case 2:
					return 0.49;
				case 3:
					return 0.32;
				case 4:
					return 0.235;
			}
			return 1;
		}

		function getPortfolioColumnGap($ul) {// stub
			if (getPortfolioColumnCount($ul) === 1) {
				return 0;
			}
			return 0.02;
		}

		jQuery.WPV.initPortFolio = function(context) {

			var portfolioImages = $('.portfolios.sortable:not(.scroll-x)', context || document)
				.find("img.lazy").not(".jail-started");

			portfolioImages.closest(".portfolios.sortable > ul")
				//.css("opacity", 0.01)
				.parent().addClass("loading").css("backgroundPosition", "center 150px");

			function callback() {
				//jQuery.WPV.initHoverFX(portfolioImages);

				setTimeout(function() {
					var portfolios = $(".portfolios.sortable", context || document);
					portfolios.each(function (pi) {

						var list   = $('> ul', this),
							items  = $("> li", list).removeAttr("class"),
							links  = $('.sort_by_cat a', this),
							cat    = "all",
							toShow = items,
							toHide = $();

						// The initial switch to absolute layout
						list.css({
							position: "relative",
							overflow: "visible",
							height  : list.height()
						});

						function updateThumbnailPositions(internal, cb) {//console.log("updateThumbnailPositions");
							list.css("height", list.height());

							var	col       = 0,
								baseLineY = 0,
								baseLineX = 0,
								rowHeight = 0,
								colCount  = getPortfolioColumnCount(list),
								listWidth = list.width(), //Math.min(1200, colCount>1 ? J_WIN.width()-240 : list.width()),
								colWidthF = getPortfolioColumnWidth(list),
								colWidth  = Math.floor(listWidth * colWidthF);

							var colGapF   = getPortfolioColumnGap(list),
								rowGap    = 0,
								len       = toShow.length;

							toShow.each(function (j) {

								var isFirst = j % colCount === 0 || 1 === colWidthF;
								var item    = $(this).css({ height: "auto", width: colWidth, marginBottom : 0}).show();

								$(".vamtam-slider", this).each(function() {
									var inst = $(this).data("vamtamSlider");
									if (inst) {
										$(inst.element).unsetTransition(true, true).css("height", inst._getDisplayHeight());
									}
								});

								var height  = item.outerHeight() + rowGap;

								if (isFirst) {
									baseLineY += rowHeight;
									rowHeight = 0;
									col = 0;
								}

								rowHeight = Math.max(rowHeight, height);
								baseLineX = col * (colWidth + listWidth * colGapF);
								col++;

								var cssFrom = {
									display : "block",
									zIndex  : 200
								};
								var cssTo = {
									top  : baseLineY,
									left : baseLineX,
									avoidTransforms : true
								};

								cssFrom.opacity = 0;
								cssTo.opacity = 1;

								if (internal) {
									$(this).unsetTransition(0, 0).css(cssFrom).css(cssTo);
								}
								else {
									var delay = cat == 'all' ? Math.max(0, (j - 3) * 100) : j * 200;
									list.addClass("animated");
									item.css(cssFrom).setTransition(cssTo, 1000, "easeInOutQuint", delay, function() {
										item.css("zIndex", 2);
										if (j == toShow.length - 1) {
											list.removeClass("animated");
										}
									});
								}

								if (j === len - 1) {
									baseLineY += rowHeight;
								}
							});

							toHide
							.filter(":visible")
							.css({ zIndex: 1 }).animate({ opacity: "hide" }, cat == 'all' ? 1000 : 600, "swing");

							list.animate({
								height : baseLineY
							}, {
								duration : IS_TOUCH ? 1 : 800,
								queue    : false,
								easing   : "swing",
								complete : function() {
									list.parent().addClass("loaded");
									list.trigger("portfolioReflow");
									if ($.isFunction(cb)) {
										cb();
									}
								}
							});
						}

						links.click(function() {
							links.removeClass('active');
							$(this).addClass('active');
							cat = $(this).attr('data-value');
							toShow = cat == 'all' ? items : items.filter('[data-type~=' + cat + ']');
							toHide = cat == 'all' ? $([])   : items.not('[data-type~=' + cat + ']');
							toShow.unsetTransition(1, 1);
							toHide.unsetTransition(1, 1);
							list.trigger("portfolioSortStart", [cat]);
							updateThumbnailPositions(false, function() {
								list.trigger("portfolioSortComplete", [cat]);
							});
							return false;
						});

						setTimeout(function() {
							items.css({
								position: "absolute",
								opacity : 1
							});

							list.addClass("transitionable")
							.animate({ opacity : 1 }, { duration : 600, queue : false })
							.parent().removeClass("loading").addClass("loaded");

							$(window).bind({
								switchlayout : function() {
									updateThumbnailPositions( true );
								},
								delayedResize : function() {
									updateThumbnailPositions( true );
								}
							});

							if ( pi >= portfolios.length - 1) {
								$(window).trigger("loadPortfolio");
							}

							updateThumbnailPositions(true);

						}, 1000);
					});
				}, 0);
			}

			var timer;
			if (portfolioImages.length) {
				timer = setTimeout(callback, 5000);
				portfolioImages.addClass("jail-started").jail({
					speed: 1000,
					event: false,
					callback: function() {
						if (timer) {
							clearTimeout(timer);
						}
						callback();
					}
				});
			}
			else {
				callback();
			}
		};

		jQuery.WPV.initPortFolio(document);
		// Ends Portfolio ------------------------------------------------------

		// Scroll to top button
		// =====================================================================
		$(window).bind('resize scroll', function () {
			$('#scroll-to-top').toggleClass("visible", window.pageYOffset > 0);
		});
		$('#scroll-to-top').click(function () {
			$('html,body').animate({
				scrollTop: 0
			}, 300);
		});

	});

	(function() {
		$(".row:has(> div.nomargin > .slogan)").each(function(i, o) {
			var row = $(o);
			row.addClass('has-nomargin-slogan');

			var slogans = row.find('> div > .slogan'),
				rowWidth = 0;

			function init() {
				var rw = row.width();
				if(rw != rowWidth) {
					rowWidth = rw;
					var h = 0;

					slogans.css("height", "auto").each(function() {
						h = Math.max(h, $(this).height());
					});

					if(!MEDIA.layout["layout-below-medium"])
						slogans.height(h);
				}
			}

			if(slogans.length > 1) {
				J_WIN.bind("resize load", init);
				init();
			}
		});
	})();

	J_WIN.resize(function() {
		$('.row:has(.shrinking-button)').each(function() {
			var fs = parseInt($('.services.has-icon.smallimage .shrinking-button div a').css('font-size'), 10),
				maxfs = Number.POSITIVE_INFINITY;

			$(this).find('.services.has-icon.smallimage .shrinking-button div a').each(function() {
				maxfs = Math.min(maxfs, ($(this).closest('.shrinking-outer').width() - 60) / 6.5);
			}).css('font-size', Math.min(fs, maxfs));
		});

	});

	// Starts New animated services
	// =========================================================================
	(function() {

		var fadeSpeed  = 200,
			fadeEasing = "easeInOutQuad",
			sizeSpeed  = 200,
			sizeEasing = "easeInOutQuad",
			delay      = 100,
			hoverColumn,
			isConverted;

		$(".row:has(> div > .services.has-more)").each(function(i, o) {
			var origRow = $(o),
				row   = origRow.clone().insertAfter(o),
				cols  = row.find("> div").addClass("has-more-col"),
				len   = cols.length;

			if (len < 2) {
				return;
			}

			var rowWidth,
				normalWidth,
				smallWidth,
				bigWidth;

			row.mouseleave(restoreAll);
			$("body").bind("touchstart", function() {
				if (hoverColumn) {
					hoverColumn = null;
					restoreAll();
				}
			});
			cols.bind("touchstart", function(e) { e.stopPropagation(); });

			function convert() {
				cols
				.removeClass("one_half grid-1-2 one_third grid-1-3 one_fourth grid-1-4 one_fifth grid-1-5 one_sixth grid-1-6 two_thirds grid-2-3 two_fourths grid-2-4 two_fifths grid-2-5 two_sixths grid-2-6 three_fourths grid-3-4 three_fifths grid-3-5 three_sixths grid-3-6 four_fifths grid-4-5 four_sixths grid-4-6 five_sixths grid-5-6")
				.css({
					position : "relative",
					"float": "left"
				});

				if (!row.find("> .column-scroller").length) {
					row.wrapInner('<div class="column-scroller"/>');
				}

				isConverted = 1;
			}

			function init() {
				var h = 0;
				if (MEDIA.layout["layout-below-medium"]) {
					row.hide();
					origRow.show();
				}
				else {
					origRow.hide();
					row.show();
					row.css("width", "100%");
					if (rowWidth != row.width()) {
						rowWidth    = row.width();
						var gap     = row.find('>div:first').hasClass('nomargin') ? 0 : Math.floor((rowWidth/100) * 3);
						rowWidth    = Math.floor(rowWidth - (gap * (len-1)));
						normalWidth = rowWidth / len;
						smallWidth  = rowWidth / (len + 1);
						bigWidth    = smallWidth * 2;

						row.css('height', 'auto');
						row.css('height', row.height());

						row.css('overflow', 'hidden');
						cols.removeData("targetHeight").width(normalWidth).css("height", "auto").each(function() {
							h = Math.max(h, $(this).innerHeight());
						}).height(h);
						row.css('overflow', 'visible');

						if (!isConverted)
							convert();

						cols
						.css("margin", "0 " + gap + "px 0 0")
						.eq(cols.length - 1).css("marginRight", 0);
					}
				}
			}
			J_WIN.bind("resize load", init);

			//J_WIN.bind(($.browser.msie && $.browser.version == 9 ? "resize" : "switchlayout") + " load", init);

			function getColumnTargetHeight(col) {
				row.css('overflow', 'hidden');
				var meta = $(col).data("targetHeight");
				if (!meta) {
					var toShow  = $(".open", col).css({
							visibility: "hidden",
							width : bigWidth,
							height : "auto"
						}).addClass("visible");

					meta = toShow.outerHeight();
					toShow.css({
						width : "100%",
						height : 0,
						paddingTop: 0,
						paddingBottom: 0,
						visibility: "visible"
					});
				}
				row.css('overflow', 'visible');
				return meta;
			}

			function restoreAll() {
				cols.stop(1, 1);

				var Q = $({});

				Q.queue(function() {
					var toFadeOut = cols.find(".closed, .open-content"), l = toFadeOut.length;
					if (!l) {
						Q.dequeue();
					}
					else {
						var done = 0;
						toFadeOut.each(function(i, content) {

							$(content).stop(1, 1);

							if (!$(content).is(":visible") || String($(content).css("opacity")) == "0") {
								if (++done >= l) {
									Q.dequeue();
								}
							}
							else {
								$(content).animate({ opacity: 0 }, fadeSpeed, fadeEasing, function() {
									if (++done >= l) {
										Q.dequeue();
									}
								});
							}
						});
					}
				});

				Q.queue(function() {
					cols.find(".open").stop(1, 1).delay(fadeSpeed).animate({ height : 0 }, sizeSpeed, sizeEasing);
					cols.find(".closed").stop(1, 1).delay(fadeSpeed).animate({ opacity: 1 }, fadeSpeed, fadeEasing, function() {
						row.css('overflow', 'hidden');
						cols.delay(fadeSpeed).animate({ width : normalWidth }, {
							duration: sizeSpeed,
							easing : sizeEasing,
							queue : false,
							complete: function() {
								row.css('overflow', 'hidden');
							}
						});
					});
				});
			}

			cols.find(".open").wrapInner('<div class="open-content"></div>');
			cols.each(function(j, item) {
				var $item = $(item);
				$item.mouseenter(function() {
					hoverColumn = this;
					cols.stop(1, 1);
					var otherCols = cols.not(this);

					$item.delay(delay);

					// Fade-out all
					$item.queue(function() {
						var toFadeOut = $item.find(".closed").add(".open-content", cols),
							l         = toFadeOut.length;
						if (!l) {
							$item.dequeue();
						}
						else {
							var done = 0;
							toFadeOut.each(function(i, content) {

								$(content).stop(1, 1);

								if (String($(content).css("opacity")) == "0") {
									if (++done >= l) {
										$item.dequeue();
									}
								}
								else {
									$(content).stop(1, 1).animate({ opacity: 0 }, fadeSpeed, fadeEasing, function() {
										if (++done >= l) {
											$item.dequeue();
										}
									});
								}
							});
						}
					});

					// Resize others to smaller width
					$item.queue(function() {
						row.css('overflow', 'hidden');
						otherCols.find(".open").stop(1, 1).animate({ height : 0 }, sizeSpeed, sizeEasing);
						otherCols.animate({width : smallWidth}, {
							duration: sizeSpeed,
							easing : sizeEasing,
							queue : false
						});

						$item.dequeue();
					});

					$item.queue(function(next) {
						$item.animate({width : bigWidth}, {
							duration: sizeSpeed,
							easing : sizeEasing,
							queue : false,
							complete : next
						});
					});

					$item.queue(function() {
						// row.css('overflow', 'visible');
						$(".open", item).stop(1, 1).animate({ height : getColumnTargetHeight(item) }, sizeSpeed, sizeEasing, function() {
							$item.dequeue();
						});
					});

					$item.queue(function() {
						otherCols.find(".closed").stop(1, 1).animate({ opacity: 1 }, fadeSpeed, fadeEasing);
						$(".open > .open-content", item).stop(1, 1).animate({ opacity: 1 }, fadeSpeed, fadeEasing);
					});

					return false;
				});
			});

			init();
		});
	})();
	// =========================================================================
	// Ends New animated services

	// Portfolio - detail page -------------------------------------------------
	jQuery.WPV.initPortfolioGallery = function(context) {

		var SIZE_FIXED;

		function fixHeight(viewer) {
			if (viewer.css("position") == "static") {
				viewer.css("position", "relative");
			}

			viewer.css("height", "auto").css({
				overflow: "hidden",
				height  : viewer.height()
			});
		}

		$("article.portfolio", context || document).each(function() {
			var viewer = $("> .row > .portfolio_image_wrapper", this),
				thumbs = $("> .row > .portfolio_details a.portfolio-small", this);

			if (!thumbs.length) return;

			thumbs.removeClass("lightbox").unbind("click").bind("click.portfolioGallery", function() {
				if (!SIZE_FIXED) {
					fixHeight(viewer);
					SIZE_FIXED = 1;
				}

				var oldView = $("> a.portfolio_image, > img", viewer).css({ zIndex : 1 }),
					newView = $('<img />').css({
						position : "absolute",
						zIndex   : 3,
						left     : 0,
						top      : 0,
						opacity  : 0
					}).attr({
						alt : $("> img", this).attr("alt")
					})
					.appendTo(viewer);

				newView.bind("load", function() {
					viewer.css("height", viewer.height()).animate({"height": "+=" + (newView.height() - oldView.height())}, 400);
					oldView.animate({opacity:0}, 400);
					newView.animate({opacity:1}, 400, function() {
						newView.css({zIndex: 1, position: "relative"});
						oldView.unbind().remove();
						viewer.css("height", "auto");
					});
				}).attr("src", this.href);

				return false;
			});
		});
	};
	jQuery.WPV.initPortfolioGallery();

	// Internet Explorer fixes -------------------------------------------------
	if ($.browser.msie && $.browser.version < 9) {
		$('p:empty').hide();
		$('*:last-child').addClass('last last-child');

		var logo = $(".main-header .logo");
		if (logo.length) {
			var logoImage = logo.find("> img");
			if (logoImage.length === 1) {
				logo.width(logoImage[0].offsetWidth);
			}
		}
	}

	$('#feedback.slideout').click(function(e) {
		$(this).parent().toggleClass("expanded");
		e.preventDefault();
	});

	// =========================================================================
	// Raw Content Handlers and Live Scripts
	// =========================================================================

	// Equal height for the .shrinking-outer DIV in .services.smallimage
	// =========================================================================
	$.rawContentHandler(function() {
		$(".row > .nomargin:first-child").each(function() {
			var row = $(this).parent();
			if (row.find("img.jail.loading").length) {
				row.bind("jailComplete", function() {
					if (row.find("img.jail.loading").length === 0) {
						row.find(".services.has-image.smallimage .shrinking-outer")
							.css("minHeight", 0).each(function() {
							h = Math.max(h, $(this).height());
						}).css("minHeight", h);
						row.unbind("jailComplete");
					}
				});
			}
		});

		$(".shrinking-outer").each(function() {
			var a = $(this).find("a");
			if (a.length) {
				$(this).css("cursor", "pointer").click(function() {
					a[0].click();
				});
			}
		});
	});

	// Touch control for the sliders
	// =========================================================================
	$.rawContentHandler(function() {

		// Main slider
		$('.vamtam-slider').touchwipe({
			preventDefaultEvents : false,
			canUseEvent : function(e) {
				//console.log($(e.target).is(".slide, .slide *"));
				return $(e.target).is(".slide, .slide *");
			},
			wipeLeft: function(e) {
				e.preventDefault();
				$(this).closest(".vamtam-slider").vamtamSlider("pos", "next");
			},
			wipeRight: function(e) {
				e.preventDefault();
				$(this).closest(".vamtam-slider").vamtamSlider("pos", "prev");
			}
		});

		// BG lider
		$(".fast-slider").touchwipe({
			canUseEvent : function(e) {
				return $(e.target).is("#container");
			},
			wipeLeft: function() {
				if($(this).data("fastSlider"))
					$(this).data("fastSlider").prev();
			},
			wipeRight: function() {
				if($(this).data("fastSlider"))
					$(this).data("fastSlider").next();
			},
			wipeDown: function() {
				if($(this).data("fastSlider"))
					$(this).data("fastSlider").goToPrevGalleryItem();
			},
			wipeUp: function() {
				if($(this).data("fastSlider"))
					$(this).data("fastSlider").goToNextGalleryItem();
			}
		});
	});

	// LINKAREA
	// =========================================================================
	$("body")
	.on("mouseenter", ".linkarea[data-hoverclass]", function() {
		$(this).addClass(this.getAttribute("data-hoverclass"));
	})
	.on("mouseeleave", ".linkarea[data-hoverclass]", function() {
		$(this).removeClass(this.getAttribute("data-hoverclass"));
	})
	.on("mousedown", ".linkarea[data-activeclass]", function() {
		$(this).addClass(this.getAttribute("data-activeclass"));
	})
	.on("mouseup", ".linkarea[data-activeclass]", function() {
		$(this).removeClass(this.getAttribute("data-activeclass"));
	})
	.on("click", ".linkarea[data-href]", function(e) {
		if (e.isDefaultPrevented()) {
			return false;
		}

		var href = this.getAttribute("data-href");
		if (href) {
			e.preventDefault();
			e.stopImmediatePropagation();
			try {
				var target = String(this.getAttribute("data-target") || "self").replace(/^_/, "");
				if (target == "blank" || target == "new") {
					window.open(href);
				}
				else {
					window[target].location = href;
				}
			} catch (ex) {}
		}
	});

	// Print Buttons
	// =========================================================================
	$("body").on("click", ".print-btn", function() { window.print(); });

	// Like menu-button
	// =========================================================================
	$.rawContentHandler(function() {

		var metaHeader = $(".meta-header > .limit-wrapper");

		if (!metaHeader.length)
			return;

		var likeTPL  = $("#like-btns-template", this);
		var btn      = $(".page-header .share-btn");

		if (likeTPL.length) {
			var likeHTML = likeTPL.html();
			if (!btn.length) {
				btn = $('<span class="share-btn">\
					<div class="like-menu-container"></div>\
				</span>').prependTo(metaHeader);
				$("body").addClass("has-share-menu");
			}

			btn.unbind();

			btn.bind("mouseenter", function() {
				var menu = $("#like-menu");
				if (!menu.length) {
					menu = $('<div id="like-menu"/>').appendTo("body");
					menu.hover(
						function() { $("body").addClass("show-like-menu"); },
						function() { $("body").removeClass("show-like-menu"); }
					);
				}
				var container = btn.find(".like-menu-container");
				menu.empty();

				function top(node) {
					var _node = node, out = 0; //$("#wpadminbar").outerHeight();
					while (_node && node.offsetParent) {
						out += _node.offsetTop;
						_node = _node.offsetParent;
					}
					out += parseFloat($("body").css("marginTop"));
					return out;
				}

				menu.css({
					top  : top(container[0]) + container.outerHeight(),// + parseFloat(container.parent().css("margin-bottom")),
					right: $("body").width() - (container.offset().left + container.outerWidth())
				});

				menu.html(likeHTML.replace(/^<\!--/, "").replace(/-->$/, "")).prepend('<div class="like-menu-cover"/>');
				$("body").addClass("show-like-menu");
			});

			btn.bind("mouseleave", function() {
				$("body").removeClass("show-like-menu");
			});
		}
		else
			btn.remove();
	});

	// AJAX Navigation (Prev/Next and LoadMore)
	// =========================================================================
	(function() {
		function stripShareButtons(html) {
			var shareStart = "<!-- Starts share-btns (do not remove this comment) -->";
			var shareEnd = "<!-- Ends share-btns (do not remove this comment) -->";
			var start = html.indexOf(shareStart);
			var end   = html.indexOf(shareEnd);
			if (start > -1 && end > -1) {
				html = html.substring(0, start) + html.substr(end + shareEnd.length);
			}
			return html;
		}

		function parseReducedResponce(text, callback) {
			var data = {};
			$.each(text.split("-----VAMTAM-----SPLIT-----"), function(i, token) {
				var index = token.indexOf("|");
				if (index > -1) {
					data[token.substr(0, index)] = token.substr(index + 1);
				}
			});

			var awaited = 0, ready = 0;
			function commonCallback() {
				if (++ready >= awaited) callback(data);
			}

			if (awaited < 1) {
				callback(data);
			}
			//console.log(data)
			return data;
		}

		// Load More Buttons
		// ---------------------------------------------------------------------
		$("body").on("click.pagination", ".load-more", function() {

			if ((/(Android|BlackBerry)/i).test(navigator.userAgent)) {
				return true;
			}

			var url = $("a.lm-btn", this).attr("href");
			if (!url) {
				return true;
			}

			// Skip if alredy started
			if ($(this).is(":animated")) {
				return false;
			}

			var $currentLink = $(this);
			var $currentList = $currentLink.prev();

			var containerSelector = $currentList.is("section.portfolios > ul") ?
				"section.portfolios > ul" :
					$currentList.is(".loop-wrapper") ?
						".loop-wrapper:first" :
						null;

			if (containerSelector) {
				// Start loading indicator
				$(this).addClass("loading").find("> *").animate({opacity: 0});

				$.ajax({
					url      : url,
					dataType : "text",
					data     : { reduced : 1 },
					cache    : false,
					headers  : { "X-Vamtam" : "reduced-response" },
					success  : function(html) {

						html = stripShareButtons(html);

						var article = $('<div/>').html(
							html.replace(/[\s\S]*?<article\b[^>]*>([\s\S]*)<\/article>[\s\S]*/i, "$1")
							.replace(/<script[^>]*>([\s\S]*?)<\/script>/gi, '<span class="script" style="display:none">$1</span>')
						);

						var newContainer = $(containerSelector, article);
						if (newContainer.length) {

							// get the height to start from
							var startHeight = $currentList.height();

							// Append the new items as transparent ones
							var newItems = newContainer.children().css("opacity", 0);
							$currentList.append(newItems);

							if ($.browser.msie && $.browser.version < 9) {
								$currentList.find('p:empty').hide();
								$currentList.find(".last-child").each(function() {
									if (!$(this).is(":last-child")) {
										$(this).removeClass("last-child");
									}
								});
								$currentList.find('*:last-child').addClass('last-child');
							}

							$("span.script", $currentList).each(function(i, o) {
								$.globalEval($(o).text());
							}).remove();

							$currentList.trigger("rawContent", newItems.get());

							// Get the final height
							var endHeight = $currentList.height();

							// Expand the container
							$currentList.height(endHeight);
							$currentList.css("height", "auto").children().animate({opacity: 1}, 1000);
							jQuery.WPV.initHoverFX($currentList);

							var newPager = $(".load-more", article);

							if (newPager.length) {
								$currentLink
									.html(newPager.html())
									.removeClass("loading")
									.find("> *").animate({opacity: 1}, 600, "linear");
							}
							else {
								$currentLink.slideUp().remove();
							}
							$(window).trigger("resize").trigger("scroll");
							article = newContainer = startHeight = endHeight = newPager = null;
						}
					}
				});
			}
			return false;
		});

		// Prev/Next Pagination
		// ---------------------------------------------------------------------
		$("body").on("click.pagination", ".page-header a[rel=next], .page-header a[rel=prev]", function(e) {

			if ((/(Android|BlackBerry)/i).test(navigator.userAgent)) {
				return true;
			}

			var newUrl = $(this).attr("href");
			if (!newUrl) {
				return true;
			}

			e.preventDefault();
			e.stopPropagation();
			var thisContainer = $("#main").find(".page-wrapper:first");

			if (thisContainer.css("position") == "static") {
				thisContainer.css("position", "relative");
			}

			$(this).addClass("loading").css({
				color : "transparent !important"
			});

			$.ajax({
				url      : newUrl,
				data     : { reduced : 1 },
				headers  : { "X-Vamtam" : "reduced-response" },
				dataType : "text",
				cache    : false,
				success  : function(html) {

					parseReducedResponce(html, function(data) {

						if (data.title) {
							document.title = data.title;
							if(window.history.pushState) {
								history.pushState( { location: newUrl }, data.title, newUrl );
							}
						}

						if (data.ptitle) {
							$("header.page-header").replaceWith(data.ptitle);
						}

						if (data.content) {

							var _html = data.content.replace(
								/<script[^>]*>([\s\S]*?)<\/script>/gi,
								function(all, code) {
									return '<span class="script" style="display:none">' + encodeURIComponent(code) + '</span>';
								}
							);

							_html = stripShareButtons(_html);
							_html = $.trim(_html);

							var oldChildren = thisContainer.children();

							var page = $('<div class="ajax-result"/>').css({
								height : "auto",
								opacity: 0
							}).appendTo(thisContainer).html(_html);

							$(".page-wrapper:first", page).removeClass("page-wrapper");

							$(".load-more, .widget.wpv_flickr", page).remove();

							$("span.script", page).each(function(i, o) {
								$.globalEval(decodeURIComponent($(o).text()));
							}).remove();

							page.trigger("rawContent");

							var _done = 0;
							var commonCallback = function() {
								if (++_done == 2) {
									jQuery.WPV.initPortfolioGallery(page);
									$('#commentform').validator();
									$(window).trigger("resize").trigger("scroll");
								}
							};

							oldChildren.each(function(i) {
								$(this).animate({opacity: 0}, 800, "linear", function() {
									$(this).find("*").unbind().removeData().end().empty().remove();
									if (i >= oldChildren.length - 1)
										commonCallback();
								});
							});

							page.animate({opacity : 1}, 1000, "linear", commonCallback);
						}
					});
				}
			});
		});

	})();

	J_WIN.triggerHandler('resize.sizeClass');

	$(window).bind("load", function() {
		setTimeout(function() {
			$(window).trigger("resize");
		}, 1);
	});

})(jQuery);

// $.fn.vamtamScrollable
// =============================================================================

(function($) {

	var TPL_BTN_LEFT   = '<div class="scrollbar-btn-left"><div /></div>';
	var TPL_BTN_RIGHT  = '<div class="scrollbar-btn-right"><div /></div>';
	// var TPL_BTN_TOP    = '<div class="scrollbar-btn-top"><div /></div>';
	// var TPL_BTN_BOTTOM = '<div class="scrollbar-btn-bottom"><div /></div>';
	var TPL_CENTER     = '<div class="scrollbar-scrollarea">' +
							'<div class="scrollbar-btn-main">' +
							'<div />' +
							'</div>' +
							'</div>';
	function getColCount($elem) {
		if (MEDIA.layout["layout-below-medium"])
			return 1;
		if ($elem.is(".portfolio_four_columns"))
			return 4;
		if ($elem.is(".portfolio_three_columns"))
			return 3;
		if ($elem.is(".portfolio_two_columns"))
			return 2;
		return 1;
	}

	function getPortfolioColumnWidth($ul) { // float
		switch (getColCount($ul)) {
			case 2:
				return 0.49;
			case 3:
				return 0.32;
			case 4:
				return 0.235;
		}
		return 1;
	}

	function initLayout($ul) {
		var lis    = $ul.find(" > li").removeClass("fit"),
			cCount = getColCount($ul);

		if (cCount === 1) {
			$ul.css({ width : "100%" });

			lis.css({
				width       : "100%",
				"float"     : "none",
				display     : "block",
				marginRight : 0
			});
			return;
		}

		var lisLength  = lis.length,
			zoom       = cCount === lisLength ? lisLength : lisLength / cCount,
			colWidth   = getPortfolioColumnWidth($ul) * 100 / zoom,
			totlaWidth = 100 * zoom,
			colGap     = (100 - (lisLength * colWidth)) / (lisLength - 1);

		$ul.css("width", totlaWidth + "%");

		lis.each(function(i, o) {
			$(o).css({
				width       : colWidth + "%",
				"float"     : "left",
				marginRight : i === lisLength - 1 ? 0 : colGap + "%"
			});
		});
	}

	/**
	 * Creates horizontal scroll bar and returs it as jQuery object (It is NOT
	 * yet inserted at the DOM).
	 * @return {jQuery}
	 */
	function createScrollBarX(options) {
		var html = ['<div class="scrollbar-horizontal">'];
		switch (options.arrowButtons) {
			case "left":
				html.push( TPL_BTN_LEFT, TPL_BTN_RIGHT, TPL_CENTER );
			break;
			case "right":
				html.push( TPL_CENTER, TPL_BTN_LEFT, TPL_BTN_RIGHT );
			break;
			case "none":
				html.push( TPL_CENTER );
			break;
			default:
				html.push( TPL_BTN_LEFT, TPL_CENTER, TPL_BTN_RIGHT );
			break;
		}
		html.push('</div>');

		return $( html.join("") );
	}

	/**
	 * This callback function gets called when the scrollable element is resized
	 * or scrolled to update the width and position of the scrollbars.
	 */
	function sync(elem) {
		var scrollBars = $(elem).data("scrollBars");
		if (scrollBars) {
			if (scrollBars.horizontal) {
				var scrollWidth     = elem.scrollWidth,
					scrollbarWidth  = 100 * (elem.clientWidth / scrollWidth),
					scrollbarLeft   = 100 * (elem.scrollLeft  / scrollWidth);

				scrollBars.horizontal.find(".scrollbar-btn-main > div").css({
					width   : scrollbarWidth + "%",
					left    : scrollbarLeft  + "%"
				}).end().toggleClass("disabled", scrollbarWidth >= 100);
			}

			if (scrollBars.vertical) {
				var scrollHeight    = elem.scrollHeight,
					scrollbarHeight = 100 * (elem.clientHeight / scrollHeight),
					scrollbarTop    = 100 * (elem.scrollTop    / scrollHeight);

				scrollBars.vertical.find(".scrollbar-btn-main > div").css({
					height  : scrollbarHeight + "%",
					left    : scrollbarTop    + "%"
				}).end().toggleClass("disabled", scrollbarHeight >= 100);
			}
		}
	}

	/**
	 * This is called once after the given scrollbar (horizontal or vertical)
	 * has been created to attach the event listeners
	 */
	function attachListeners( elem, scrollbarX ) {
		if (scrollbarX) {
			var EVENT_ROOT = $.browser.msie && $.browser.version < 9 ? document : window;

			scrollbarX.find(".scrollbar-scrollarea").bind("mousedown", function(e) {
				var $btnWrap = $(this).find(".scrollbar-btn-main"),
					$btn     = $btnWrap.find(" > div").addClass("active"),
					btnWidth = $btn.width(),
					width    = $btnWrap.width(),
					delta    = $btn.offset().left - e.pageX;

				function set(x) {
					var deltaX = x - $btnWrap.offset().left;
					var left = width * (deltaX / width);
					left += delta;
					left  = Math.max(left, 0);
					left  = Math.min(left, width - btnWidth);
					elem.scrollLeft = Math.ceil(left * (elem.scrollWidth / width));
					$(elem).trigger("scroll");
				}

				// If the mousedown happens on the button - just start moving it
				if (e.target === $btn[0]) {
					set( e.pageX );
				}

				// If the mousedown happens on the button parent - scroll to that point first
				else {
					var l = elem.scrollWidth - elem.clientWidth;
					l *=  (e.pageX - $btnWrap.offset().left) / $btnWrap.width();
					$(elem)
					.originalStop(1, 0)
					.originalAnimate(
						{ scrollLeft : l },
						{
							duration : 300,
							easing   : "easeInOutCirc",
							step     : function() {
								$(elem).trigger("scroll");
							},
							complete : function() {
								delta = $btn.offset().left - e.pageX;
							}
						}
					);
				}

				$(EVENT_ROOT).bind("mousemove.sliderdrag", function(e) {
					set( e.pageX );
					return false;
				});

				$(EVENT_ROOT).bind("mouseup.sliderdrag", function() {
					$(this).unbind(".sliderdrag");
					$btn.removeClass("active");
				});

				return false;
			});

			// Left/Right buttons
			var delay, timer;
			scrollbarX.find(".scrollbar-btn-left, .scrollbar-btn-right")
			.bind("mousedown", function() {

				var step = (function(_step) {
					return function(single) {
						if (single) {
							$(elem)
							.originalStop(1, 0)
							.originalAnimate({ scrollLeft : elem.scrollLeft + _step * 100 }, {
								duration : 200,
								easing : "easeInOutQuad",
								step : function() {
									$(elem).trigger("scroll");
								}
							});
						}
						else {
							elem.scrollLeft += _step * 10;
							$(elem).trigger("scroll");
							timer = setTimeout(step, 0);
						}
					};
				})($(this).is(".scrollbar-btn-left") ? -1 : 1);

				if (delay) clearTimeout(delay);
				if (timer) clearTimeout(timer);

				step(true);

				delay = setTimeout(step, 200);
			})
			.bind("mouseleave mouseup", function() {
				if (delay) clearTimeout(delay);
				if (timer) clearTimeout(timer);
			});
		}
	}

	function getScrollBarX(elem, options) {
		var o = $(elem).data("scrollBars");
		if ( !o ) {
			o = {};
			$(elem).data("scrollBars", o);
		}
		if ( !o.horizontal ) {
			o.horizontal = $(elem).next(":first");
			if (!o.horizontal.length || !o.horizontal.is(".scrollbar-horizontal")) {
				o.horizontal = createScrollBarX(options);
				o.horizontal.insertAfter(elem);
			}
			attachListeners( elem, o.horizontal );
		}
	}

	$.fn.vamtamScrollable = function(options) {
		var hasNativeTouchScroll = !!$.getCssPropertyName("-webkit-overflow-scrolling");
		return this.each(function(i, o) {
			if (!hasNativeTouchScroll)
				getScrollBarX(o, options);

			$(window).bind("resize scroll switchlayout", function(e) {
				if (e.type == "switchlayout") {
					initLayout($("> ul", o));
				}
				if(!hasNativeTouchScroll)
					sync(o);
			});

			initLayout($("> ul", o));
			if(!hasNativeTouchScroll)
				sync(o);
			$(o).addClass("loaded");
		});
	};

})(jQuery);

// Scrollable Portfolio
// =============================================================================
jQuery.rawContentHandler(function(context) {

	var conatiner = jQuery('.portfolios.scroll-x', context || document);

	conatiner.find("img.lazy").not(".jail-started, .loaded").addClass("jail-started").jail({
		speed : 1000,
		event : false
	});

	conatiner.vamtamScrollable({	arrowButtons : "right" });
});

//jQuery(window).bind("load", function() {
//	setTimeout(function() {
//		alert(screen.width + "x" + screen.height + "\n\n" + jQuery(".slider-shortcode-wrapper").html());
//	}, 5000);
//});
