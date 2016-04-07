jQuery.WPV = jQuery.WPV || {}; // Namespace

// The equalHeight plugin
jQuery.fn.equalHeight = function() {
	var tallest = 0;
	return this.each(function() {
		var thisHeight = jQuery(this).height();
		if (thisHeight > tallest) {
			tallest = thisHeight;
		}
	}).height(tallest);
};

// The jQuery.rawContentHandler function
(function($) {
	var readyStarted = false;
	var readyEnded = false;

	// This should be the FIRST ready handler to execute
	$(function() {
		readyStarted = true;
	});

	// This should be the LAST ready handler to execute
	$(document).bind("ready", function() {
		readyEnded = true;
	});

	$.rawContentHandler = function(cb) {
		if ($.isFunction(cb)) {
			if (!readyStarted) {
				$(function() {
					$.rawContentHandler(cb);
				});
			} else {
				if (!readyEnded) {
					var tgt = $("body")[0];
					cb.call(tgt, tgt.childNodes);
				}

				$(window).bind("rawContent", function(e, items) {
					cb.call(e.target, items || e.target.childNodes);
				});
			}
		}
	};
})(jQuery);

(function($, undefined) {

	jQuery.WPV.initJailImages = function(context, filter, speed, callback) {
		var images = $("img.lazy[data-href]", context || document).not(".jail-started, :animated");
		if (filter) {
			images.filter(filter);
		}
		if (images.length) {
			var prefs = {
				speed: speed || 1000,
				timeout: 0
			};
			if (callback) {
				prefs.callback = callback;
			}
			images.addClass("jail-started").jail(prefs);
		} else {
			if (callback) {
				callback();
			}
		}
		images = null;
	};

	$(function() {
		// lazy load images
		// The JAIL plugin is written in such a way that makes an error if it's 
		// applied in empty collection!
		var commonImages = $('img.lazy').not(".portfolios.sortable img, .portfolios.isotope img, .portfolios.scroll-x img, :animated, .wpv-wrapper img");
		if (commonImages.length) {
			commonImages.addClass("jail-started").jail({
				speed: 800
			});
		}

		var sliderImages = $('.wpv-wrapper img.lazy');
		if (sliderImages.length) {
			sliderImages.addClass("jail-started").jail({
				speed: 1400,
				event: 'load'
			});
		}

		// lightbox
		$.rawContentHandler(function() {
			$(".colorbox, .lightbox", this)
				.not('.no-lightbox, .size-thumbnail, .cboxElement')
				.each(function() {
				var $link = $(this);
				var isIframe = ($(this).attr('data-iframe') == 'true');

				$link.colorbox({
					opacity: 0.7,
					scalePhotos: true,
					maxWidth: "90%",
					maxHeight: "90%",
					iframe: isIframe,
					width: isIframe ? '90%' : 0,
					height: isIframe ? '90%' : 0,
					title: function() {
						var share = '';

						if ($('body').hasClass('cbox-share-gplus')) {
							share += '<div><div class="g-plusone" data-size="medium"></div> <script type="text/javascript">\
								(function() {\
									var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;\
									po.src = "https://apis.google.com/js/plusone.js";\
									var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);\
								})();\
								</script></div>';
						}

						if ($('body').hasClass('cbox-share-facebook')) {
							share += '<div><iframe src="//www.facebook.com/plugins/like.php?href=' + window.location.href + '&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:auto; height:21px;" allowTransparency="true"></iframe></div>';
						}

						if ($('body').hasClass('cbox-share-twitter')) {
							share += '<div><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html" style="width:auto; height:20px;"></iframe></div>';
						}

						if ($('body').hasClass('cbox-share-pinterest')) {
							share += '<div><a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
						}

						var title = $link.attr('title') || '';

						return '<div id="cboxShare">' + share + '</div><div id="cboxTextTitle">' + title + '</div>';
					},
					onLoad: function() {
						$("#colorbox").removeClass('withVideo');
					}
				});
			});
		});

		var initIsotope = function() {
			if (!$.fn.isotope) return;

			$('.portfolios.isotope > ul').each(function() {
				var container = $(this),
					container_width = container.width(),
					columns = parseInt(container.attr('data-columns'), 10),
					column_width = Math.floor(container_width / columns),
					lis = container.find('>li'),
					firstImg = lis.filter(':has(.thumbnail > a > img):first').find('.thumbnail img'),
					imgHeight = firstImg.attr('height'),
					imgWidth = firstImg.attr('width'),
					thumbHeight = imgHeight * imgWidth / (column_width - container_width * 0.02);


				lis.css({
					width: column_width,
					'padding-left': container_width * 0.01,
					'padding-right': container_width * 0.01
				});

				lis.find('.thumbnail').css({
					height: thumbHeight
				});

				setTimeout(function() {
					lis.find('.thumbnail').css({
						height: 'auto'
					});
					container.isotope('reLayout');
				}, 50);

				container.css({
					'margin-left': -container_width * 0.01,
					'margin-right': -container_width * 0.01
				});

				container.isotope({
					resizable: false,
					layoutMode: 'fitRows',
					masonry: {
						columnWidth: column_width
					}
				});
			});
		};

		// tabs, accordions, isotope
		$.rawContentHandler(function() {
			if ($.fn.tabs) {
				$('.wpv-tabs', this).tabs().each(function() {
					if (Number($(this).attr('data-delay'))) {
						$(this).tabs('rotate', parseInt($(this).attr('data-delay'), 10), true);
					}
				});
			}

			if ($.fn.accordion) {
				$('.accordion', this).accordion({
					heightStyle: 'content'
				}).each(function() {
					if ($(this).attr('data-collapsible') == 'true') $(this).accordion('option', 'collapsible', true).accordion('option', 'active', false);
				});
			}

			initIsotope();

			$('.portfolios.isotope .sort_by_cat a').click(function(e) {
				var filter = $(this).attr('data-value');

				$(this).parent().siblings().find('.active').removeClass('active');
				$(this).addClass('active');

				$(this).closest('.isotope').find('> ul').isotope({
					filter: (filter == 'all' ? '*' : '[data-type~=' + filter + ']')
				});

				e.preventDefault();
			}).each(function() {
				var filter = $(this).attr('data-value'),
					isotope = $(this).closest('.isotope').find('> ul');

				if (filter != 'all' && isotope.children().filter('[data-type~=' + filter + ']').length === 0) $(this).parent().hide();
			});
		});

		if ($.fn.isotope) $(window).smartresize(initIsotope);

		// :before and :after fixes for ie7
		if ($.browser.msie && $.browser.version == 7) {
			$('*').each(function() {
				if ($(this)[0].currentStyle.before) {
					var before = $(this).prepend('<span class="before"></span>').find('span.before');
					before.text($(this)[0].currentStyle.before.replace(/'/g, ''));
				}

				if ($(this)[0].currentStyle.after) {
					var after = $(this).append('<span class="after"></span>').find('span.after');
					after.text($(this)[0].currentStyle.after.replace(/'/g, ''));
				}
			});
		}
	});

})(jQuery);