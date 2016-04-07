/* jshint trailing: true, multistr: true */

(function($) {

	var DEBUG = 0;

	function debugLog() {
		if (DEBUG && window.console) {
			window.console.log.apply(window.console, arguments);
		}
	}

	/**
	 * Returns the float representation of the first argument or the 
	 * "defaultValue" if the float conversion is not possible.
	 * @param {*} x The argument to convert
	 * @param {*} defaultValue The fall-back return value. This is going to be 
	 *                         converted to float too.
	 * @return {Number} The resulting floating point number.
	 */
	function floatVal( x, defaultValue )
	{
		var out = parseFloat(x);
		if ( isNaN(out) || !isFinite(out) ) {
			out = defaultValue === undefined ? 0 : floatVal( defaultValue );
		}
		return out;
	}

	function TaskQueue( options )
	{
		var cfg = $.extend({
			onChange   : $.noop,
			onComplete : $.noop,
			canProceed : function() { return true; }
		}, options );

		var queue = [];

		function run() {
			if ( !cfg.canProceed() )
				return;

			if ( queue.length ) {
				var task = queue.shift();
				cfg.onChange( task );
				task.worker( run );
			}
			else {
				cfg.onComplete();
			}
		}

		return {
			next : run,
			add : function( description, worker ) {
				queue.push({
					worker      : worker,
					description : description || "Anonimous task"
				});
				return this;
			},
			start : function() {
				run();
				return this;
			}
		};
	}

	$.VamtamSlider.createCaptionEffect = function(settings) {

		var customSettings = $.extend({
			runSettings    : {},
			captionsCssOff : { opacity: 0, left: -500 },
			captionsCssOn  : { opacity: 1, left: 0    },
			wrapperCssOff  : { opacity: 0 },
			wrapperCssOn   : { opacity: 1 }
		}, settings);

		return function(originalCfg) {
			var cfg          = $.extend({}, originalCfg, customSettings.runSettings),
				oldWrapper   = cfg.toHide.data("captionsWarapper"),
				newWrapper   = cfg.toShow.data("captionsWarapper");

				$(oldWrapper).find(".caption").filter(function() { return (/^\s*$/).test(this.innerHTML); }).remove();
				$(newWrapper).find(".caption").filter(function() { return (/^\s*$/).test(this.innerHTML); }).remove();

			var toHide       = $(oldWrapper).find(".caption"),
				toShow       = $(newWrapper).find(".caption"),
				toHideLength = toHide.length,
				toShowLength = toShow.length,
				duration     = "captionFxTime"   in cfg ? cfg.captionFxTime   : cfg.slider.options.captionFxTime   || cfg.duration,
				delay        = "captionFxDelay"  in cfg ? cfg.captionFxDelay  : cfg.slider.options.captionFxDelay  || 0;

			if ( !toHide.length && !toShow.length ) {
				setTimeout(cfg.callback, duration + delay);
				return;
			}

			var easing       = "captionFxEasing" in cfg ? cfg.captionFxEasing : cfg.slider.options.captionFxEasing || cfg.easing,
				queue        = !!cfg.slider.options.captionQueue,
				sliderRoot   = $(cfg.slider.element);

			var hideDuration    = isComplexSlideWrapper(cfg.toHide, cfg.slider) ? cfg.slider.options.complexSlidesDuration : duration;
			var showDuration    = isComplexSlideWrapper(cfg.toShow, cfg.slider) ? cfg.slider.options.complexSlidesDuration : duration;
			var quarterHideTime = Math.ceil(hideDuration / 4),
				quarterShowTime = Math.ceil(showDuration / 4);

			var onOldCaptionsHidden = $.createCountingCallback(toHideLength, function() {
				sliderRoot.dequeue("captions");
			});

			var onNewCaptionsShown = $.createCountingCallback(toShowLength, function() {
				sliderRoot.dequeue("captions");
			});

			function prepareTransition(done) {
				toHide.unsetTransition();
				toShow.unsetTransition().css(customSettings.captionsCssOff).show();
				$(oldWrapper).unsetTransition();
				$(newWrapper).unsetTransition().css(customSettings.wrapperCssOff).show();
				done();
			}

			function finalizeTransition(done) {
				$(oldWrapper).css(customSettings.wrapperCssOff);
				toHide.css(customSettings.captionsCssOff).hide();
				if ($.isFunction(cfg.callback)) {
					cfg.callback();
				}
				done();
			}

			function hideOldCaptions() {
				if (toHideLength) {
					toHide.each(function(i, c) {
						$(c).setTransition(
							customSettings.captionsCssOff,
							quarterHideTime,
							easing,
							(quarterHideTime/toHideLength) * (queue ? i : 0),
							onOldCaptionsHidden
						);
					});
				} else {
					setTimeout(onOldCaptionsHidden, cfg.toHide.length ? quarterHideTime : 0);
				}
			}

			function hideOldCaptionsContainer(next) {
				if (oldWrapper) {
					$(oldWrapper).setTransition(customSettings.wrapperCssOff, quarterHideTime, "linear", 0, next);
				} else {
					setTimeout(next, cfg.toHide.length ? quarterHideTime : 0);
				}
			}

			function showNewCaptionsContainer(next) {
				if (newWrapper) {
					$(newWrapper).setTransition(customSettings.wrapperCssOn, quarterShowTime, "linear", 0, next);
				} else {
					setTimeout(next, quarterShowTime);
				}
			}

			function showNewCaptions() {
				if (toShowLength) {
					toShow.each(function(i, c) {
						$(c).setTransition(
							customSettings.captionsCssOn,
							quarterShowTime,
							easing,
							(quarterShowTime/toShowLength) * (queue ? i : 0),
							onNewCaptionsShown
						);
					});
				} else {
					setTimeout(onNewCaptionsShown, quarterShowTime);
				}
			}


			sliderRoot
			.queue("captions", []) // Reset the caption queue (if any)
			.queue("captions", prepareTransition)
			.queue("captions", hideOldCaptions)
			.queue("captions", hideOldCaptionsContainer)
			.queue("captions", function(next) {	setTimeout( next, delay ); })
			.queue("captions", showNewCaptionsContainer)
			.queue("captions", showNewCaptions)
			.queue("captions", finalizeTransition)
			.dequeue("captions"); // start
		};
	};

	$.VamtamSlider.Effects.zoomIn = {
		init : function(slider) {
			if ($("html").is(".csstransitions.csstransforms")) {
				$(".slide-wrapper", slider.element).eq(0).wpvAddClass(
					"current",
					slider.options.animationTime,
					slider.options.easing
				);
			}
			else {
				$.VamtamSlider.Effects.fade.init(slider);
			}
		},

		run: function (cfg) {
			if ($("html").is(".csstransitions.csstransforms")) {
				cfg.toShow.wpvAddClass(
					"current",
					cfg.slider.options.animationTime,
					cfg.slider.options.easing,
					0,
					cfg.callback
				);
				cfg.toHide.wpvRemoveClass(
					"current",
					cfg.slider.options.animationTime,
					cfg.slider.options.easing
				);
			}
			else if (jQuery.WPV.Constants.vendor.transform) {
				cfg.toHide.stop(1, 0).css("zIndex", 1);
				cfg.toShow.css({
					opacity : 0,
					zIndex  : 3
				}).show().stop(1, 0).css("dummy", 0).animate(
					{ dummy : 1 },
					{
						duration : cfg.slider.options.animationTime,
						easing : "linear", //cfg.slider.options.easing, IE overflow bug :(
						step: function (cur) {
							cfg.toShow.css("opacity", cur)
								.css(jQuery.WPV.Constants.vendor.transform, "scale(" + cur + ")");
							cfg.toHide.css("opacity", 1 - cur)
								.css(jQuery.WPV.Constants.vendor.transform, "scale(" + (1 - cur) + ")");
						},
						complete: function () {
							cfg.toShow.css("zIndex", 2);
							cfg.toHide.hide();
							cfg.callback();
						}
					}
				);
			}
			else {
				$.VamtamSlider.Effects.fade.run(cfg);
			}
		},

		changeCaptions : $.VamtamSlider.createCaptionEffect({
			captionsCssOff : { opacity: 0 },
			captionsCssOn  : { opacity: 1 }
		})
	};

	$.VamtamSlider.Effects.slideAndFade = {
		init : function(slider) {
			var pos = slider.pos();
			$(".slide-wrapper", slider.element).each(function(i) {
				$(this).css({
					opacity: i === pos ? 1 : 0,
					display: i === pos ? "block" : "none"
				});
			});
		},

		run: function (cfg) {
			var shiftX = cfg.toShow.width() * cfg.direction;

			if ($(cfg.slider.element).is(".loaded")) {
				cfg.toShow.css("left", shiftX);
			}

			cfg.toShow.stop(1, 0).css({
				zIndex  : 2,
				opacity : 0,
				display : "block"
			});

			var done = 0;
			function cb() {
				if (++done == 2) cfg.callback();
			}

			if (cfg.toHide.length) {
				cfg.toHide.stop(1, 0).animate({
					left    : -shiftX,
					avoidTransforms : $.browser.mozilla
				}, cfg.duration, cfg.easing, function () {
					$(this).css({ display : "none" });
					cb();
				}).animate({ opacity : 0 }, {
					duration : cfg.duration,
					easing : "easeInCirc",
					queue : false
				});
			}
			else {
				cb();
			}

			cfg.toShow.stop(1, 0).animate({
				left : 0,
				avoidTransforms : $.browser.mozilla
			}, {
				duration : cfg.duration,
				easing : cfg.easing,
				queue : false,
				complete : cb
			}).animate({ opacity : 1 }, {
				duration : cfg.duration,
				easing : "easeInCirc",
				queue : false
			});
		},

		changeCaptions : $.VamtamSlider.createCaptionEffect()
	};




	// Listen for messages from the players
	if (window.addEventListener) {
		window.addEventListener('message', onMessageReceived, false);
	}
	else {
		window.attachEvent('onmessage', onMessageReceived, false);
	}

	function getEmitterFrame(msgEvent, filter) {
		var frame = $("iframe").filter(function() {
			return this.contentWindow == msgEvent.source;
		});

		if (filter) {
			frame.filter(filter);
		}

		return frame[0];
	}

	function getSliderFromVideoEvent(event) {
		var frame = getEmitterFrame(event, ".vimeo");
		if (frame) {
			var sliderDiv = $(frame).closest(".vamtam-slider");
			if (sliderDiv.length) {
				return sliderDiv.data("vamtamSlider");
			}
		}
		return null;
	}

	function onMessageReceived(e) {
		var data = jQuery.parseJSON(e.data || "{}");
		var slider;
		switch (data.event) {

			case "ready":
				var frame = getEmitterFrame(e, ".vimeo");
				if (frame) {
					$(frame).data("loaded", true);
					var P = $f(frame);
					P.addEvent('pause' , $.noop);
					P.addEvent('play'  , $.noop);
					P.addEvent('finish', $.noop);
				}
				break;

			case "play":
				slider = getSliderFromVideoEvent(e);
				if (slider) slider._slideshowController.isWaiting = 1;
				break;

			case "finish":
			case "pause":
				slider = getSliderFromVideoEvent(e);
				if (slider) slider._slideshowController.isWaiting = 0;
				break;
		}
	}



	$.VamtamSlider.prototype._init_videos = function() {
		$(this.element).bind("slidePositionChange", function() {
			$('iframe.vimeo', this).each(function(i, player) {
				if ($(player).data('loaded')) {
					try {
						$f(player).api('pause');
					} catch (ex) {}
				}
			});
		});
	};




	// =========================================================================
	var useTransitions  = !!$.WPV.Constants.vendor.transition,
		useTransforms   = !!$.WPV.Constants.vendor.transform,
		supports3d      = !!$.getCssPropertyName("transform-style"),
		preferTranslate = useTransitions && useTransforms && !$.browser.mozilla,
		prefer3d        = supports3d && !$.browser.mozilla;

	var animateable = {
		top                 : 1,
		right               : 1,
		bottom              : 1,
		left                : 1,
		"margin-top"        : 1,
		"margin-right"      : 1,
		"margin-bottom"     : 1,
		"margin-left"       : 1,
		"padding-top"       : 1,
		"padding-right"     : 1,
		"padding-bottom"    : 1,
		"padding-left"      : 1,
		zoom                : 1,
		opacity             : 1,
		width               : 1,
		height              : 1,
		"font-size"         : 1,
		"transform"         : 1
	};

	function isComplexSlideWrapper( wrapper ) {
		return $(wrapper).find(".transition").length > 0;
	}

	function getTransitionDuration( elem, slider ) {
		return floatVal(
			$(elem).attr("duration"),
			$(elem).is(".slide-wrapper") ?
			getSlideDuration( elem, slider ) :
			slider.option("animationTime")
		);
	}

	function getTransitionDelay(elem) {
		return floatVal( $(elem).attr("delay") );
	}

	function getTransitionEasing(elem, slider) {
		var easing = $.trim($(elem).attr("easing") || slider.option("easing"));
		if (!easing || !(easing in $.WPV.Constants.Esing))
			easing = "swing";
		return easing;
	}

	function getSlideDuration(slideWrapper, slider) {
		var out = slider.option("animationTime");
		if (isComplexSlideWrapper(slideWrapper)) {
			out = Math.max(out, slider.option("complexSlidesDuration"));
		}
		return out;
	}

	function parseCss(css) {
		var style = {},
			pairs = $.trim(String(css)).split(";"),
			len   = pairs.length,
			pair,
			name,
			value;

		for (var i = 0; i < len; i++) {
			pair  = $.trim(pairs[i]);
			if (!pair) continue; // double ";"
			pair = pair.split(":");
			name  = $.trim(pair[0]).toLowerCase();
			if (!(name in animateable)) continue;
			name  = $.getCssPropertyName(name) || name;
			value = $.trim(pair[1]);
			if (name) {
				if (name == "opacity") {
					value = parseFloat(value);
					if (isNaN(value)) {
						continue;
					}
				}
				if ( name == "transform" ) {
					if (useTransforms && useTransitions) {
						style[$.WPV.Constants.vendor.transform] = value;
					}
					continue;
				}
				style[name] = value;
			}
		}

		return style;
	}

	function translateCss(style, setZeros) {
		if (preferTranslate) {

			var map = {
				"bottom" : { axis : "y", q : -1 },
				"top"    : { axis : "y", q :  1 },
				"left"   : { axis : "x", q :  1 },
				"right"  : { axis : "x", q : -1 }
			};

			var t = { x : null, y : null };

			$.each(map, function(name, data) {
				if (name in style) {
					if (setZeros) {
						t[data.axis] = 0;
					}
					else {
						var m     = style[name].match(/\s*(-?\d+(\.d+)?)(.*)?\s*/),
							value = 0,
							unit  = "px";

						if (m) {
							if (m[1]) value = parseFloat(m[1]);
							if (m[3]) unit  = m[3];
						}

						t[data.axis] = data.q === 1 ? value + "" + unit : (value * data.q) + "" + unit;
					}
				}
			});

			if (t.x !== null || t.y !== null) {
				if (prefer3d) {
					style[$.WPV.Constants.vendor.transform] = "translate3d(" + (t.x || 0) + ", " + (t.y || 0) + ", 0)";
				} else {
					style[$.WPV.Constants.vendor.transform] = "translate(" + (t.x || 0) + ", " + (t.y || 0) + ")";
				}
			}
		}
		return style;
	}

	function prepareTransition(elem) {
		var cssFrom = elem.getAttribute("cssfrom");
		var cssTo   = elem.getAttribute("cssto") || elem.getAttribute("style");

		if (cssFrom && cssTo) {

			cssFrom = parseCss(cssFrom);
			cssTo   = parseCss(cssTo);

			cssFrom = translateCss(cssFrom);
			cssTo   = translateCss(cssTo, true);

			$(elem).css(cssFrom);

			$(elem).data("cssFrom", $.isEmptyObject(cssFrom) ? null : cssFrom);
			$(elem).data("cssTo"  , $.isEmptyObject(cssTo  ) ? null : cssTo  );
		}
	}

	function prepareSlide(slideWrapper, slider, multiplier) {

		if (slider.options.forceNestedAnimationTimes) {
			var slideDuration = slider.option("complexSlidesDuration");
			var animated      = slideWrapper.find(".transition");
			var q = 1;

			// Find the slowest one
			var maxTime = 0;
			animated.each(function(j, o) {
				maxTime = Math.max(
					maxTime,
					getTransitionDuration(o, slider) + getTransitionDelay(o, slider)
				);
			});

			// Change all times proportionally to fit into the global duration
			q = slideDuration / maxTime;
			if (multiplier !== undefined) {
				q *= multiplier;
			}

			animated.each(function(j, o) {
				o.setAttribute("duration", Math.ceil(getTransitionDuration(o, slider) * q));
				o.setAttribute("delay"   , Math.ceil(getTransitionDelay   (o, slider) * q));
				prepareTransition(o, slider);
			});
		}

		prepareTransition(slideWrapper[0], slider);
	}

	function runTransition(elem, type, slider, callback, overrideSettings) {
		var cssFrom = $(elem).data(type == "hide" ? "cssFrom" : "cssTo");
		if (cssFrom) {
			var cfg = $.extend({
				duration : getTransitionDuration(elem, slider),
				easing   : getTransitionEasing(elem, slider),
				delay    : getTransitionDelay(elem, slider),
				callback : callback || $.noop
			}, overrideSettings);

			$(elem).setTransition(cssFrom, cfg.duration, cfg.easing, cfg.delay, cfg.callback);
		}
		else {
			(callback || $.noop).call(elem);
		}
	}

	function initNestedFX(slider) {
		var pos = Math.max(slider.pos(), 0);
		$(".slide-wrapper, .slide-bg, .wpcf7-response-output", slider.element).each(function(i, o) {
			$(this)
			.attr({
				cssfrom  : "opacity: 0;",
				cssto    : "opacity: 1;",
				easing   : slider.options.easing,
				duration : getSlideDuration(o, slider),
				delay    : 0
			})
			.addClass("transition")
			.css({
				opacity: i === pos ? 1 : 0,
				display: $(this).is(".slide-wrapper") ? i === pos ? "block" : "none" : ""
			});
			prepareSlide($(this), slider);
		});
	}

	function hideSubElements( wrapper, slider, callback, duration ) {

		var toHide = $(".transition", wrapper);
		var len    = toHide.length;

		if (!len) {
			if ( $.isFunction(callback) )
				callback();
			return;
		}

		var done = 0, delay, o, prefs;
		var time = getSlideDuration( wrapper, slider );
		var arr  = toHide.get().sort(function(a, b) {
			return getTransitionDelay(b, slider) - getTransitionDelay(a, slider);
		});

		var doLoopCallback = function() {
			if ( ++done >= len ) {
				if ( $.isFunction(callback) ) callback();
			}
		};

		for ( var i = 0; i < len; i++ ) {
			o = arr[i];
			delay = Math.max(time - (getTransitionDelay(o, slider) + getTransitionDuration(o, slider)), 0);
			prefs = {
				delay : delay
			};

			if ( duration || duration === 0 ) {
				prefs.duration = duration;
			}

			//$(o).unsetTransition(1,1);
			runTransition(o, "hide", slider, doLoopCallback, prefs);
		}
	}

	function runNestedFX(cfg) {

		if ( cfg.fxUID !== cfg.slider._fxUID ) {
			//console.log("Canceling FX");
			cfg.callback();
			return false;
		}

		// revoke other slides
		$(".slide-wrapper", cfg.slider.element).each(function(i, o) {

			$(o)
			.unsetTransition(1,0)
			.find(".transition")
			.unsetTransition(1,0);

			if (o === cfg.toShow[0] || (cfg.toHide.length && o === cfg.toHide[0]))
				return;

			$(o).css({
				opacity: 0,
				display: "none"
			});
		});

		if ( cfg.fxUID !== cfg.slider._fxUID ) {
			cfg.callback();
			return false;
		}

		var elementsToShow    = cfg.toShow.find(".transition");
		var elementsToHide    = cfg.toHide.find(".transition");
		var elementsToShowLen = elementsToShow.length;
		var elementsToHideLen = elementsToHide.length;
		var toHideLen         = cfg.toHide.length;
		var slideDuration     = cfg.slider.option("animationTime");

		var Q = new TaskQueue({
			onChange : function( task ) {
				debugLog( task.description );
			},
			onComplete : cfg.callback,
			canProceed : function() {
				if ( cfg.fxUID !== cfg.slider._fxUID ) {
					//console.log("Canceling FX");
					cfg.callback();
					return false;
				}
				return true;
			}
		});

		if ( toHideLen ) {
			if ( elementsToHideLen ) {
				Q.add("Hide sub-elements", function( next ) {
					hideSubElements( cfg.toHide, cfg.slider );
					setTimeout( next, cfg.slider.option("complexSlidesDuration") );
				});
			}

			Q.add("Hide old slide", function( next ) {
				runTransition( cfg.toHide[0], "hide", cfg.slider, function() {
					$(this).css("display", "none");
					//next();
				}, { duration : slideDuration });
				next();
			});
		}

		Q.add("Show new slide", function( next ) {
			runTransition(
				cfg.toShow.css("display", "block")[0],
				"show",
				cfg.slider,
				null,
				{ duration : slideDuration }
			);
			setTimeout(next, elementsToShowLen ? slideDuration / 2 : slideDuration );
		});

		if ( elementsToShowLen ) {
			Q.add("Show sub-elements", function( next ) {
				var j = 0;
				elementsToShow.each(function(i, o) {
					runTransition(o, "show", cfg.slider, function() {
						if (++j === elementsToShowLen) {
							next();
						}
					}, {
						//delay : getTransitionDelay(o, cfg.slider) + slideDuration / 2
					});
				});
				//next();
			});
		}

		Q.start();

	}


	// Effect Makalu
	// =========================================================================
	(function() {

		function createTabs( slider ) {
			var thumb,
				slide,
				i,
				container = $("#makalu-tabs-bar .tabs-container");

			var posDummy = function(pos) {
				return function() {
					if (
						// !$(slider.element).is(".animated") && 
						pos !== slider.pos()) {
						slider.pos(pos);
					}
				};
			};

			for ( i = 0; i < slider.slides.length; i++ ) {
				slide = slider.slides[i];
				thumb = $('<div class="tab"/>').bind(
					"ontouchstart" in document.documentElement ? "touchstart" : "click",
					(posDummy)(i)
				).appendTo(container);

				$('<div class="tab-content"/>')
					.html('<span>' + (slide.shortText || "Slide " + (i + 1)) + '</span><div class="tab-bg"/>')
					.appendTo(thumb);
			}

			$("#header-slider").bind("slidePositionChange.makalu", function(e, newIndex) {
				container.find(".tab").removeClass("active").eq(newIndex).addClass("active");
			});


			// Tabs scrolling
			// -----------------------------------------------------------------
			var timer;

			function scrollStart( step ) {

				scrollStop();

				function doStep() {
					var s = container[0].parentNode.scrollLeft;
					container[0].parentNode.scrollLeft += step;
					if ( s === container[0].parentNode.scrollLeft )
						return;
					timer = setTimeout(doStep, 18);
				}

				doStep();
			}

			function scrollStop() {
				if ( timer ) clearTimeout( timer );
			}

			if ("ontouchstart" in document.documentElement) {
				$("#makalu-tabs-bar .btn-prev")
				.bind("touchstart", function() {
					scrollStart(-2);
				})
				.bind("touchend", scrollStop)
				.bind("selectstart", false);

				$("#makalu-tabs-bar .btn-next")
				.bind("touchstart", function() {
					scrollStart(2);
				})
				.bind("touchend", scrollStop)
				.bind("selectstart", false);
			} else {
				$("#makalu-tabs-bar .btn-prev").hover(function() { scrollStart(-2); }, scrollStop).bind("selectstart", false);
				$("#makalu-tabs-bar .btn-next").hover(function() { scrollStart( 2); }, scrollStop).bind("selectstart", false);
			}

			$(window).bind("resize.makaluTabs", function() {
				var hasScroll = container[0].parentNode.scrollWidth > container[0].parentNode.clientWidth;
				$("#makalu-tabs-bar").find(".btn-prev, .btn-next").css(
					"opacity", hasScroll ? 1 : 0
				);
			}).triggerHandler("resize.makaluTabs");
		}

		function getSlideImage( slide ) {
			if ( slide.type == "img" ) {
				return slide.url;
			}

			var bg = $(".slide-bg", slide.element);
			if ( bg.length ) {
				bg = bg.css("backgroundImage");
				if ( bg && bg != "none" ) {
					return String( bg ).replace(/^url\(['"]?/, "").replace(/['"]?\)$/, "");
				}
			}

			return null;
		}

		function initPrevNextButtons( slider ) {
			$("#header-slider").bind("slidePositionChange.makalu", function(e, newIndex) {
				var len = slider.slides.length;
				if (len > 1) {
					var prevSlide = newIndex > 0 ? slider.slides[newIndex - 1] : slider.slides[len - 1];
					var nextSlide = newIndex < len - 1 ? slider.slides[newIndex + 1] : slider.slides[0];
					var prevImage = getSlideImage( prevSlide );
					var nextImage = getSlideImage( nextSlide );
					var prevBtn   = $(".slider-btn-prev", slider.element).empty();
					var nextBtn   = $(".slider-btn-next", slider.element).empty();

					//console.log(prevImage, " | ", nextImage)

					if ( prevImage ) {
						prevBtn.append(
							$('<img />').attr("src", prevImage)
						).addClass("has-image");
					} else {
						prevBtn.removeClass("has-image");
					}

					if ( nextImage ) {
						nextBtn.append(
							$('<img />').attr("src", nextImage)
						).addClass("has-image");
					} else {
						nextBtn.removeClass("has-image");
					}
				}
			});
		}

		$.VamtamSlider.Effects.Makalu = $.VamtamSlider.Effects.makalu = {

			init : function( slider )
			{
				createTabs( slider );
				initPrevNextButtons( slider );
				initNestedFX( slider );
			},

			uninit : function() {},
			run    : runNestedFX,
			changeCaptions : function(cfg) {
				var oldWrapper   = cfg.toHide.data("captionsWarapper"),
					newWrapper   = cfg.toShow.data("captionsWarapper"),
					toHide       = $(oldWrapper).find(".caption"),
					toShow       = $(newWrapper).find(".caption"),
					toHideLength = toHide.length,
					toShowLength = toShow.length,
					duration     = cfg.duration || 1000;

				$.VamtamSlider.Effects.slideAndFade.changeCaptions(
					$.extend({}, cfg, {
						captionFxDelay : toHideLength && toShowLength ? 0 : Math.ceil(duration * 0.75),
						captionFxTime  : Math.ceil(duration / 2)
					})
				);
			}
		};
	})();

	$.VamtamSlider.Effects.slide.changeCaptions = $.VamtamSlider.createCaptionEffect({
		captionsCssOff : { opacity: 0 },
		captionsCssOn  : { opacity: 1 }
	});

	$.VamtamSlider.Effects.fade.changeCaptions = $.VamtamSlider.createCaptionEffect({
		captionsCssOff : { opacity: 0 },
		captionsCssOn  : { opacity: 1 }
	});



})(jQuery);