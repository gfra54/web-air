(function($, undefined) {
	$(function() {
		$('body').on('click', '.vamtam-check-license', function(e) {
			var self = $(this);

			if ( self.hasClass('disabled' ) ) return;

			self.siblings().remove();

			self.css('display', 'inline-block').addClass('disabled');
			self.after('<span class="spinner" style="display:inline-block;float:none" />');

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'wpv-check-license',
					username: $('#envato-username').val(),
					'api-key': $('#envato-api-key').val(),
					'license-key': $('#envato-license-key').val(),
					nonce: $(this).attr('data-nonce')
				},
				success: function(data) {
					self.removeClass('disabled').siblings().remove();
					self.after( $('<p />').addClass('vamtam-check-license-help').append('<hr />').append( self.data('full-info') ) );
					self.after( $('<p />').addClass('vamtam-check-license-response').append('<hr />').append(data) );
				}
			});

			e.preventDefault();
		});

		if (!$('#wpv-colorpicker').length) {
			var picker = $('<div id="wpv-colorpicker"></div>').hide(),
				selected;

			$('body').append(picker);
			var fbt = $.farbtastic('#wpv-colorpicker');

			picker.append(function() {
				return $('<a class="transparent">transparent</a>').click(function() {
					if (selected) {
						$(selected).val('transparent').css({
							background: 'white'
						});
						picker.fadeOut();
					}
				});
			});

			$.fn.wpvColorPicker = function() {
				var self = this;

				$('[type=color], .wpv-color-input', self).not('.wpv-colorpicker').each(function() {
					$(this).prop('type', 'text').addClass('wpv-colorpicker');
					fbt.linkTo(this);
				}).on('focus', null, function() {
					if (selected) $(selected).removeClass('colorwell-selected');

					var self = this;
					fbt.linkTo(function(color) {
						$(self).val(color).change();
					});

					picker.css({
						position: 'absolute',
						left: $(this).offset().left + $(this).outerWidth(),
						top: $(this).offset().top
					}).fadeIn();
					$(selected = this).addClass('colorwell-selected');
				}).on('blur', null, function() {
					picker.fadeOut();
				}).on('change keyup', null, function() {
					$(this).css({
						'background-color': $(this).val()
					});
				});

				return this;
			};
		}

		$('body').wpvColorPicker();

		(function() {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'wpv-get-icon-list'
				},
				success: function(icons) {
					window.VamtamIconsCache = icons;

					$(document).trigger('vamtam-icons-loaded');
				}
			});
		})();

		$.fn.wpvIconsSelector = function() {
			var icons = $('.wpv-config-row.icons');

			(function() {
				var browser = /MSIE (\d+)/.exec(navigator.userAgent);
				if(browser && browser[1] !== 8) return;

				var refresh = function() {
					icons.find(':radio.checked').removeClass('checked');
					icons.find(':checked').addClass('checked');
				};

				icons.find(':radio').unbind('change.wpvicons').bind('change.wpvicons', refresh);
				refresh();
			})();

			(function() {
				var init = function(self, icons) {
					var initial = self.find(':checked'),
						checked = initial.val(),
						id = initial.prop('name'),
						wrapper = self.find('.icons-wrapper');

					initial.remove();

					var single_icon = function(key, icon) {
						var radio = $('<input type="radio" />').attr('name', id).attr('id', id+key).val(key),
							label = $('<label class="single-icon" />').attr('for', id+key).html(icon);

						if(key === checked)
							radio.attr('checked', 'checked');

						return radio.add(label);
					};

					for(var key in icons) {
						wrapper.append(single_icon(key, icons[key]));
					}

					wrapper.removeClass('spinner');

					self.addClass('icons-loaded')
						.find('.icons-filter').bind('change paste keydown keyup search', function() {
						var search = $(this).val().toLowerCase();
						self.find('label:has(span[title])').show().each(function() {
							if(!$(this).find('span').attr('title').toLowerCase().match(search))
								$(this).hide();
						});
					});

					setTimeout(function() {
						self.each(function() {
							$(this).find('.icons-wrapper').scrollTop($(this).find(':checked + label').offset().top - $(this).find('.icons-wrapper').offset().top);
						});
					}, 100);
				};

				icons.filter(':not(.icons-loaded)').each(function() {
					var self = $(this);

					if(window.VamtamIconsCache) {
						init(self, window.VamtamIconsCache);
					} else {
						$(document).one('vamtam-icons-loaded', function() {
							init(self, window.VamtamIconsCache);
						});
					}
				});
			})();

			return this;
		};

		$('body').wpvIconsSelector();

		wpv_upload.init();
		sidebar_management.init();
		skin_management.init();
		template_management.init();
		horizontal_blocks.init();

		$('[data-field-filter]').live('change', 'select', function() {
			var prefix = $(this).attr('data-field-filter');
			var selected = $('select', this).val();
			var others = $(this).closest('.wpv-config-row').siblings().filter('.' + prefix);
			others.show().filter(':not(.' + prefix + '-' + selected + ')').hide();
		});

		$('.wpv-config-row.slider-editor').each(function(i, row) {
			row = $(row);

			row.find('.add-new-slider').click(function() {
				var input = $(this).siblings().filter('.new-slider-name');
				var name = input.val();

				if (name.length) {
					input.removeClass('error').val('');
					createSlider(name);
				} else {
					input.addClass('error');
				}
			});

			var createSlider = function(name) {
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-create-slider',
						title: name
					},
					success: function(id) {
						addSlider(id);
					}
				});
			};

			var addSlider = function(id) {
				var newSlider = $('<div></div>').addClass('loading');
				row.find('.sliders').append(newSlider);

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-get-slider-data',
						id: id
					},
					success: function(data) {
						newSlider.append('<div class="title"><h3>' + data.name + '</h3></div>')
							.append('<div class="slides clearfix"><h4>' + sliderL10n.slides + '</h4><div class="contents"></div></div>')
							.append('<div class="media clearfix"><h4>' + sliderL10n.html_slide + '</h4><div class="contents"></div></div>')
							.append(
						$('<div class="delete-slider" title="' + sliderL10n.delete_slider + '"></div>')
							.click(function() {
							if (confirm(sliderL10n.delete_slider_confirm)) {
								removeSlider(id);
								$(this).closest('.slider').slideUp(400, function() {
									$(this).remove();
								});
							}
						}))
							.attr('data-id', id)
							.addClass('slider')
							.removeClass('loading');
					}
				});
			};

			var removeSlider = function(id) {
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-slider-delete',
						id: id
					},
					success: function() {}
				});
			};

			var navbuttons = function() {
				return '<div class="edit"></div><div class="remove"></div><div class="restore"></div>';
			};

			var createSlide = function(slider, wrapper) {
				var image = wrapper.find('img');

				var sid = slider.attr('data-id');

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-create-slide',
						image: image.attr('data-id'),
						slider: sid
					},
					success: function(id) {
						image.attr('data-id', id);
						$('.overlay', wrapper).html(navbuttons);
						saveOrder(slider);
					}
				});

				return wrapper;
			};

			var saveOrder = function(slider) {
				var data = {};
				$('.slides img', slider).each(function(i, e) {
					data[$(e).attr('data-id')] = i;
				});

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-slider-save-order',
						order: data
					},
					success: function() {}
				});
			};

			var editing_slide = 0;

			$('.slides .edit', row).live('click', function() {
				var wrapper = $(this).closest('.image-wrapper');
				var img = wrapper.find('img');

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-slide-get-config',
						id: img.attr('data-id')
					},
					success: function(settings) {
						editing_slide = img.attr('data-id');

						$.colorbox({
							html: settings,
							width: '80%',
							maxHeight: '95%',
							overlayClose: false
						});

						setTimeout(function() {
							$('[data-field-filter]').change();
							var cbox_content = $('#cboxLoadedContent');
							cbox_content.find('.wpv-range-input').uirange();
							cbox_content.wpvColorPicker();
						}, 200);
					}
				});
			});

			$('.wpv-save-slide-config').live('click', function(e) {
				var data = {};
				$('#cboxContent input, #cboxContent textarea, #cboxContent select').each(function(i, e) {
					e = $(e);
					if (e.is(':not(input[type="button"])')) data[e.attr('name')] = e.val();
				});

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: $.extend({
						action: 'wpv-slide-save-config',
						id: editing_slide
					}, data),
					success: function() {
						$.colorbox.close();
						editing_slide = 0;
					}
				});

				e.preventDefault();
			});

			$('.slides .remove', row).live('click', function() {
				var wrapper = $(this).closest('.image-wrapper');
				var img = wrapper.find('img');
				var action = wrapper.hasClass('trash') ? 'delete' : 'trash';

				if (action == 'delete' && !confirm(sliderL10n.delete_slide_confirm)) return;

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-slide-' + action,
						id: img.attr('data-id')
					},
					success: function() {
						if (action == 'trash') {
							wrapper.addClass('trash');
						} else {
							var slider = img.closest('.slider');
							wrapper.remove();
							saveOrder(slider);
						}
					}
				});
			});

			$('.slides .restore', row).live('click', function() {
				var wrapper = $(this).closest('.image-wrapper');
				var img = wrapper.find('img');

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpv-slide-restore',
						id: img.attr('data-id')
					},
					success: function() {
						wrapper.removeClass('trash');
					}
				});
			});

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'wpv-get-sliders'
				},
				success: function(ids) {
					for(var i in ids) {
						addSlider(ids[i], true);
					}
				}
			});

			$('.slider .title', row).live('click', function() {
				var s = $(this).parent();
				var slides = s.find('.slides .contents');
				var media = s.find('.media .contents');

				if (s.is('.editable')) {
					media.parent().removeClass('ready');
					slides.parent().removeClass('ready');
					media.html('');
					slides.html('');
					s.removeClass('editable');
				} else {
					s.addClass('editable');

					slides.sortable({
						//containment: 'parent',
						forcePlaceholderSize: true,
						opacity: 0.6,
						placeholder: 'sort-placeholder',
						stop: function() {
							saveOrder(s);
						}
					});

					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'wpv-get-attachments'
						},
						success: function(data) {
							function appendSlide(src, id) {
								var img = $('<img/>')
									.attr('src', src)
									.attr('data-id', id);

								var overlay = $('<div class="overlay">+</div>');

								var wrap = $('<div/>')
									.addClass('image-wrapper')
									.append(img)
									.append(overlay)
									.click(function() {
									if (slides.is('.empty')) {
										slides.removeClass('empty').html('');
									}

									slides.append(createSlide(s, $(this).clone()));
									$(this).animate({
										opacity: 0.2
									}, 200, 'swing', function() {
										$(this).animate({
											opacity: 1
										}, 100, 'swing');
									});
								});

								media.append(wrap);
							}

							var html_slides = [-1, -2, -3];
							var i;
							for(i in html_slides) {
								if (data[html_slides[i]]) {
									appendSlide(data[html_slides[i]], html_slides[i]);
									delete data[html_slides[i]];
								}
							}

							media.append('<div class="postbox-like-divider"></div><h4>' + sliderL10n.image_slide + '</h4>');

							var keys = [];
							for(var key in data) {
								keys.push(key);
							}
							keys.sort(function(a, b) {
								return b - a;
							});
							for (i = 0; i < keys.length; i++) {
								appendSlide(data[keys[i]], keys[i]);
							}

							media.parent().addClass('ready');
						}
					});

					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'wpv-get-slides',
							id: s.attr('data-id')
						},
						success: function(data) {
							if (data.length === 0) {
								slides.addClass('empty').html(sliderL10n.please_add_slides);
							} else {
								for (var i in data) {
									var img = $('<img/>')
										.attr('src', data[i].img)
										.attr('data-id', data[i].id);

									var overlay = $('<div class="overlay"></div>').append(navbuttons);

									var wrap = $('<div/>')
										.addClass('image-wrapper')
										.addClass(data[i].status)
										.append(img)
										.append(overlay);

									slides.append(wrap);
								}
							}

							slides.parent().addClass('ready');
						}
					});
				}
			});
		});

		$('.social_icon_select_sites').live('change', function() {
			var wrap = $(this).closest('p').siblings('.social_icon_wrap');
			wrap.children('p').hide();
			$('option:selected', this).each(function() {
				wrap.find('.social_icon_' + $(this).val()).show();
			});
		});

		$('.num_shown').live('change', function() {
			var wrap = $(this).closest('p').siblings('.hidden_wrap');
			wrap.children('div').hide();
			$('.hidden_el:lt(' + $(this).val() + ')', wrap).show();
		});

		$('#header-slider-animationtime, #header-slider-rows, #header-slider-cols').change(function() {
			var animtime = $('#header-slider-animationtime').val(),
				rows = $('#header-slider-rows').val(),
				cols = $('#header-slider-cols').val();

			var maxAnimations = 6;
			var maxSubslideDuration = Math.round(animtime / (cols * rows / maxAnimations));

			var subsl = $('#header-slider-subslideduration');
			subsl.attr('data-max', maxSubslideDuration).val(Math.min(subsl.val(), maxSubslideDuration))
				.siblings('.ui-range-slider').slider('option', 'max', maxSubslideDuration);
		}).change();

		tb_remove = function() {
			$("#TB_imageOff").unbind("click");
			$("#TB_closeWindowButton").unbind("click");
			$("#TB_window").fadeOut("fast", function() {
				$('#TB_window,#TB_overlay,#TB_HideSelect').triggerHandler("unload");
				$('#TB_window,#TB_overlay,#TB_HideSelect').unbind().remove();
			});
			jQuery("#TB_load").remove();

			if (typeof document.body.style.maxHeight == "undefined") { //if IE 6
				jQuery("body", "html").css({
					height: "auto",
					width: "auto"
				});
				jQuery("html").css("overflow", "");
			}
			document.onkeydown = "";
			document.onkeyup = "";
			return false;
		};

		var meta_tabs = $('<ul>');

		$('.metabox .config-separator:first').before(meta_tabs);
		$('.metabox .config-separator').each(function() {
			var id = $(this).text().replace(/[\s\n]+/g, '').toLowerCase();
			$(this).nextUntil('.config-separator').wrapAll('<div class="wpv-meta-part" id="tab-' + id + '"></div>');
			$(this).css('cursor', 'pointer');
			if ($(this).next().is('.wpv-meta-part')) {
				meta_tabs.append('<li class="wpv-meta-tab"><a href="#tab-' + id + '" title="">' + $(this).text() + '</a></li>');
			}
			$(this).remove();
		});

		meta_tabs.closest('.metabox').tabs();

		$('.wpv-range-input').uirange();

		$('#wpv-config').tabs({
			activate: function(event, ui) {
				var hash = ui.newTab.context.hash;
				var element = $(hash);
				element.attr('id', '');
				window.location.hash = hash;
				element.attr('id', hash.replace('#', ''));

				$('.save-wpv-config').show();
				if (ui.newTab.hasClass('nosave')) $('.save-wpv-config').hide();
			},
			create: function(event, ui) {
				if (ui.tab.hasClass('nosave')) $('.save-wpv-config').hide();
			}
		});

		$('body').on('click', '.info-wrapper > a', function(e) {
			$(this).siblings('.desc').slideToggle(200);
			e.preventDefault();
		});

		$('body').on('click', '.wpv-autofill', function() {
			$(this).addClass('selected').siblings().removeClass('selected');

			var fields = $.parseJSON($(this).attr('data-fields'));
			var group = $(this).closest('.wpv-config-group');

			for(var i in fields) {
				var field = group.find('[name="' + i + '"]');

				if (field.is(':checkbox')) {
					if (fields[i] === 1) {
						field.attr('checked', 'checked');
					} else {
						field.attr('checked', false);
					}
				} else {
					field.val(fields[i]);
					if (field.is('.image-upload')) {
						wpv_upload.fill(field.attr('id'), fields[i]);
					}
				}

				field.change();
			}

			return false;
		});

		function autofill_test(autofill) {
			var fields = $.parseJSON($(autofill).attr('data-fields'));

			var selected = true;

			for(var i in fields) {
				var field = $('[name="' + i + '"]');

				if (field.is(':checkbox')) {
					var new_val = !!(fields[i]),
						curr_val = field.is(':checked');
					if(new_val !== curr_val) {
						selected = false;
						break;
					}
				} else if ( !(field.val()) || !(fields[i]) || field.val().toString() !== fields[i].toString()) {
					selected = false;
					break;
				}
			}

			if (selected) {
				$(autofill).addClass('selected');
			}
		}

		$('.wpv-autofill').each(function() {
			autofill_test(this);
			var autofill = this;

			var fields = $.parseJSON($(autofill).attr('data-fields'));

			var doAutofill = function() {
				$(autofill).removeClass('selected');
				autofill_test(autofill);
			};

			for(var i in fields) {
				$('#' + i).change(doAutofill);
			}
		});

		$('.wpv-config-row.body-layout label').click(function() {
			$(this).addClass('selected');
			$(this).parent().siblings().find('label').removeClass('selected');
		});
		$('.wpv-config-row.body-layout input').change(function() {
			if ($(this).is(':checked')) {
				$('label[for="' + $(this).attr('id') + '"]').click();
			}
		});

		// images in label ie fix
		$('label img').live('click', function() {
			$('#' + $(this).parents('label').attr('for')).click();
		});

		function updateFontProps(input) {

			var container = $(input).closest(".wpv-config-row.font");
			var preview = container.find('.font-preview');

			if ($(input).is('.color')) {
				preview.css('color', container.find('.color').val());
			} else {
				var font = container.find('.weight').val() + ' ' + container.find('.size').val() + 'px/' + container.find('.lheight').val() + 'px ' + '"' + container.find('.face').val() + '"';

				if ($(input).is('.face') || $(input).is('.weight')) {
					var link = document.createElement('LINK');
					link.rel = "stylesheet";
					link.type = "text/css";
					container.find('.font-styles').html("")[0].appendChild(link);
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'wpv-font-preview',
							face: container.find('.face').val(),
							weight: container.find('.weight').val()
						},
						//async : false,
						success: function(data) {
							link.href = data;
							preview.css({
								'font': font,
								'color': container.find('.color').val()
							});
						}
					});
				} else {
					preview.css({
						'font': font,
						'color': container.find('.color').val()
					});
				}
			}
		}

		$('.wpv-config-row.font input, .wpv-config-row.font select').bind("change", function() {
			updateFontProps(this);
		});

		setTimeout(function() {
			$(".wpv-config-row.font").each(function() {
				updateFontProps($(".face", this)[0]);
			});
		}, 0);

		$('#wpv-ajax-overlay, #wpv-ajax-content').remove();

		$('.wpv-config-page form').submit(function() {

			$('body').append('<div id="wpv-ajax-overlay"></div><div id="wpv-ajax-content">Saving</div>');

			$.post(ajaxurl, $(this).serialize(), function(data) {
				$('#wpv-ajax-content').html(data);

				setTimeout(function() {
					$('#wpv-ajax-overlay, #wpv-ajax-content').fadeOut(300, function() {
						$('#wpv-ajax-overlay, #wpv-ajax-content').remove();
					});
				}, 1000);
			});

			return false;
		});
	});

	var horizontal_blocks = {
		init: function() {
			$('.horizontal_blocks .wpv-range-input').change(function() {
				horizontal_blocks.set_active($(this).val(), $(this).attr('id'));
			});

			$('.horizontal_blocks select').change(function() {
				horizontal_blocks.resize($(this).parents('.block').parent(), $(this).val());
			});

			$('.horizontal_blocks [name*="last"]').change(function() {
				var block = $(this).parents('.block').parent();

				if (block.is('.last') != $(this).is(':checked')) {
					horizontal_blocks.toggle_last(block);
				}
			});
		},
		set_active: function(number, group) {
			$('[rel="' + group + '"]').removeClass('active');
			$('[rel="' + group + '"]:lt(' + number + ')').addClass('active');
		},
		resize: function(block, new_width) {
			block.removeClass(block.attr('data-width')).addClass(new_width).attr('data-width', new_width);
			if (new_width == 'full') {
				block.find('label').hide();
			} else {
				block.find('label').show();
			}
		},
		toggle_last: function(block) {
			if (block.is('.last')) {
				block.removeClass('last').next().remove();
			} else {
				block.addClass('last').after('<div class="clearboth"></div>');
			}
		}
	};

	var wpv_fill_settings = function(data) {
		for(var i in data) {
			var fixbr = ((typeof data[i]) == 'object') ? '[]' : ''; // if a the data is a object, we probably have to deal with an array
			var el = $('[name="' + i + fixbr + '"]');

			if (!(el.is('.static'))) {
				if (el.is(':radio')) {
					el.filter('[value="' + data[i] + '"]').attr('checked', true).change();
				} else if (el.is(':checkbox')) {
					if (data[i] == 1) {
						el.attr('checked', true);
					} else {
						el.attr('checked', false);
					}
				} else {
					el.val(data[i]).change();

					if (el.is('[type=color]')) {
						el.trigger('keyup');
					}
				}

				if (el.is('.image-upload')) {
					wpv_upload.fill(el.attr('id'), data[i]);
				}
			}
		}
	};
	$.SSS = wpv_fill_settings;

	var wpv_get_settings = function(domain) {
		var data = {};

		domain.each(function() {
			if ($(this).attr('name') && $(this).attr('name').length) {
				var key = $(this).attr('name');
				key = key.replace(/([\[\]])/g, '');

				if (!$(this).is(':checkbox')) {
					if (!$(this).is(':radio') || $(this).is(':checked')) {
						data[key] = $(this).val();
					}
				} else if ($(this).is(':checkbox')) {
					if ($(this).attr('name').match(/\[\]$/)) {
						if (!(key in data)) data[key] = [];

						if ($(this).is(':checked')) data[key].push($(this).val());
					} else {
						data[key] = $(this).is(':checked') ? true : false;
					}
				}
			}
		});

		return data;
	};

	var template_management = {
		init: function() {
			if ($('#wpv-available-templates').length > 0) {
				$('#wpv-templates-save').click(function() {
					template_management.save($('#wpv-templates-name').val());
				});

				$('#wpv-templates-load').click(function() {
					template_management.load($('#wpv-available-templates').val());
				});

				$('#wpv-templates-delete').click(function() {
					if ($('#wpv-available-templates').val().length > 0 && window.confirm("Are you sure you want to delete this? It's permanent")) {
						template_management.del($('#wpv-available-templates :selected').text());
					}
				});

				this.get_available();
			}
		},
		get_available: function() {
			$.post(ajaxurl, {
				action: 'wpv-available-templates'
			}, function(data) {
				$('#wpv-available-templates').html(data);
			});
		},
		save: function(name) {
			if (!name.match(/^\s*$/)) {
				$('#content-tmce').click();

				var update = function() {
					if (!tinymce.editors.content) {
						console.log("wait");
						return;
					}

					var selector = $('  #general-post-options input' + ', #general-post-options textarea' + ', #general-post-options select' + ', [name="post_format"]' + ', #comment_status' + ', #ping_status' + ', #trackback_url' + ', #excerpt');

					var data = {
						post_content: tinymce.editors.content.getContent(),
						options: wpv_get_settings(selector)
					};

					$.post(ajaxurl, {
						action: 'wpv-save-template',
						file: name,
						template: data
					}, function(data) {
						template_management.get_available();

						var container = $('#wpv_templates');
						container.find('.inside').before(data);
						setTimeout(function() {
							container.find('.success, .error').slideUp(300, function() {
								$(this).remove();
							});
						}, 10000);
					});
				};
				update();
			}
		},
		load: function(uri) {
			if (uri.length > 0) {
				$('#content-tmce').click();

				var update = (function() {
					if (!tinymce.editors.content) {
						setTimeout(update, 200);
						return;
					}

					$.get(uri, {}, function(data) {

						tinymce.editors.content.setContent(data.post_content.replace(/\\"/gi, '"').replace(/\\'/gi, "'"));

						wpv_fill_settings(data.options);

						var container = $('#wpv_templates');
						container.find('.inside').before('<span class="success">Success. You can now edit the page to suit your needs</span>');
						setTimeout(function() {
							container.find('.success, .error').slideUp(300, function() {
								$(this).remove();
							});
						}, 10000);
					}, 'json');
				})();
			}
		},
		del: function(name) {
			$.post(ajaxurl, {
				action: 'wpv-delete-template',
				file: name
			}, function(data) {
				template_management.get_available();

				var container = $('#wpv_templates');
				container.find('.inside').before(data);
				setTimeout(function() {
					container.find('.success, .error').slideUp(300, function() {
						$(this).remove();
					});
				}, 10000);
			});
		}
	};

	var skin_management = {
		init: function() {
			$('#export-config').click(function() {
				var name = $('#export-config-name').val().replace(/^\s+/, '').replace(/\s+$/, '');

				if (name.length) skin_management.save($('#export-config-prefix').val() + '_' + name);
			}).parent().append('<span class="result"></span>');

			$('#import-config').click(function() {
				if (window.confirm("Are you sure you want to import a skin? You will lose any changes you've made since you last exported a skin.")) skin_management.load($('#import-config-available').val());
			}).parent().append('<span class="result"></span>');

			$('#delete-config').click(function() {
				if (!$('#import-config-available').val().match(/^\s+$/) && window.confirm("Are you sure you want to delete this? It's permanent")) {
					skin_management.del($('#export-config-prefix').val() + '_' + $('#import-config-available :selected').text());
				}
			});

			this.get_available();
		},

		save: function(name) {
			if (!name.match(/^\s*$/)) {
				var spinner = $('#export-config').closest('.wpv-config-row').find('.spinner').css({
					display: 'inline-block'
				});

				$.post(ajaxurl, {
					action: 'wpv-save-skin',
					file: name
				}, function(result) {
					skin_management.get_available();

					spinner.hide();
					$('#export-config').parent().find('.result').html(result);
					setTimeout(function() {
						$('#export-config').parent().find('.result').fadeOut('fast', function() {
							$(this).html('').show();
						});
					}, 5000);
				});
			}
		},

		get_available: function() {
			$.post(ajaxurl, {
				action: 'wpv-available-skins',
				prefix: $('#export-config-prefix').val()
			}, function(data) {
				$('#import-config-available').html(data);
			});
		},

		del: function(name) {
			var spinner = $('#import-config').closest('.wpv-config-row').find('.spinner').css({
				display: 'inline-block'
			});

			$.post(ajaxurl, {
				action: 'wpv-delete-skin',
				file: name
			}, function(result) {
				skin_management.get_available();

				spinner.hide();
				$('#import-config').parent().find('.result').html(result);
				setTimeout(function() {
					$('#import-config').parent().find('.result').fadeOut('fast', function() {
						$(this).html('').show();
					});
				}, 3000);
			});
		},

		load: function(file) {
			var spinner = $('#import-config').closest('.wpv-config-row').find('.spinner').css({
				display: 'inline-block'
			});

			$.post(ajaxurl, {
				action: 'wpv-load-skin',
				file: file,
				name: $('#import-config-available :selected').text()
			}, function(result) {
				wpv_fill_settings(result.data);

				spinner.hide();
				$('#import-config').parent().find('.result').html(result.text);
				setTimeout(function() {
					$('#import-config').parent().find('.result').fadeOut('fast', function() {
						$(this).html('').show();
					});
				}, 3000);
			}, 'json');
		}
	};

	var sidebar_management = {
		anim: 400,

		trim_sidebars: function() {
			var sidebars = $('#custom-sidebars').val();
			sidebars = sidebars.replace(/,+/, ',');
			sidebars = sidebars.replace(/^,/, '');
			sidebars = sidebars.replace(/,$/, '');
			$('#custom-sidebars').val(sidebars);
		},

		init: function() {
			$('#add-new-sidebar').after('<div id="wpv-sidebars-message"></div>');
			var msg = $('#wpv-sidebars-message');

			$('#add-new-sidebar').click(function() {
				var name = $('#new-sidebar-id').val();

				if (!name.match(/^\s*$/)) {
					$('#registered-sidebars').append('<li data-id="wpv_sidebar-' + name + '" style="display:none">' + name + '<span class="delete-sidebar" title="Delete sidebar"></span></li>');
					$('#custom-sidebars').val($('#custom-sidebars').val() + ',wpv_sidebar-' + name);
					$('#new-sidebar-id').val('');
					sidebar_management.trim_sidebars();

					msg.text('You have to click "Save Changes"');

					$('#registered-sidebars [data-id="wpv_sidebar-' + name + '"]').fadeIn(sidebar_management.anim);
				}
			});

			$('.delete-sidebar').live('click', function() {
				var id = $(this).parent().attr('data-id');

				$('#custom-sidebars').val($('#custom-sidebars').val().replace(id, ''));
				sidebar_management.trim_sidebars();

				msg.text('You have to click "Save Changes"');

				var li = $(this).parent();
				li.fadeOut(sidebar_management.anim, function() {
					li.remove();
				});
			});
		}
	};

	wpv_upload = {
		init: function() {
			var file_frame;

			$(document).on('click', '.wpv-upload-button', function(e) {
				var field_id = $(this).attr('data-target');

				file_frame = wp.media.frames.file_frame = wp.media({
					multiple: false,
					library: {
						type: 'image'
					}
				});

				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').first();
					wpv_upload.fill(field_id, attachment.attributes.url);
				});

				file_frame.open();
				e.preventDefault();
			});

			$(document).on('click', '.wpv-upload-clear', function(e) {
				wpv_upload.remove($(this).attr('data-target'));
				e.preventDefault();
			});

			$(document).on('click', '.wpv-upload-undo', function(e) {
				wpv_upload.undo($(this).attr('data-target'));
				e.preventDefault();
			});
		},

		fill: function(id, str) {
			if (/^\s*$/.test(str)) {
				wpv_upload.remove(id);
				return;
			}

			var target = $('#' + id);
			target.data('undo', target.val());
			target.val(str);
			target.siblings('.wpv-upload-clear, .wpv-upload-undo').css({
				display: 'inline-block'
			});
			wpv_upload.preview(id, str);
		},
		preview: function(id, str) {
			$('#' + id + '_preview').parents('.upload-basic-wrapper').addClass('active');
			$('#' + id + '_preview').find('img').attr('src', str).css({
				display: 'inline-block'
			});
		},
		remove: function(id) {
			var inp = $('#' + id);
			$('#' + id + '_preview').find('img').attr('src', '').hide();
			$('#' + id + '_preview').parents('.upload-basic-wrapper').removeClass('active');
			inp.data('undo', inp.val()).val('')
				.siblings('.wpv-upload-undo').css({
				display: 'inline-block'
			})
				.siblings('.wpv-upload-clear').hide();
		},
		undo: function(id) {
			var inp = $('#' + id);
			this.preview(id, inp.data('undo'));
			inp.val(inp.data('undo'));
			inp.data('undo', '').siblings('.wpv-upload-undo').hide();
			var remove = inp.siblings('.wpv-upload-clear');
			if (inp.val().length === 0 && remove.is(':visible')) {
				remove.hide();
			} else if (inp.val().length > 0 && remove.is(':hidden')) {
				remove.css({
					display: 'inline-block'
				});
			}
		}
	};

})(jQuery);