(function($, undefined) {
	"use strict";

	tinymce.PluginManager.add('wpv_shortcodes', function(editor) {
		var open_shortcode = function(v) {
			if ($('#shortcodes').length === 0) {
				$('body').append('<div id="shortcodes">');
			}

			$('body').attr('data-wpvshortcode', v);

			$.get(WpvTmceShortcodes.url, {
				slug: v,
				nocache: (new Date()).getTime()
			}, function(data) {
				$('#shortcodes').html(data);

				$(window).trigger('wpv_shortcodes_loaded');

				$.colorbox({
					href: '#' + $('#shortcodes > div').attr('id'),
					title: WpvTmceShortcodes.title,
					inline: true,
					width: '80%',
					maxHeight: '95%',
					overlayClose: false
				});

				$('.shortcode_sub_selector select').change(function() {
					$.colorbox.resize({
						width: '80%',
						maxHeight: '95%'
					});
				});
			});
		};

		var menu_items = [];

		var create_menu_item = function(shortcode) {
			return {
				text: shortcode.title,
				onclick: function() {
					open_shortcode(shortcode.slug);
				}
			};
		};

		for(var i = 0; i < WpvTmceShortcodes.shortcodes.length; ++i) {
			menu_items.push( create_menu_item( WpvTmceShortcodes.shortcodes[i] ) );
		}

		editor.addButton('wpv_shortcodes', {
			type: 'menubutton',
			text: '',
			tooltip: WpvTmceShortcodes.title,
			icon: WpvTmceShortcodes.button,
			classes: 'widget btn wpv_shortcodes',
			menu: menu_items
		});
	});
})(jQuery);
