<?php
global $wpv_slider_effects;

return array(

array(
	'name' => __('General', 'wpv'),
	'type' => 'separator'
),

array(
	'name' => __('Use Global Options', 'wpv'),
	'desc' => __('If this option is enabled, some of the local options which have global equivalents will not be taken into account. Hence, if this option is disabled, these local options will overwrite the global settings for this post.', 'wpv'),
	'id' => 'use-global-options',
	'type' => 'toggle',
	'default' => true,
	'class' => 'top-desc',
),

array(
	'name' => __('Layout and Styles', 'wpv'),
	'type' => 'separator'
),

array(
	'name' => __('Page Layout Type', 'wpv'),
	'desc' => __('The sidebars are placed just below the page title. You can choose one of the predefined layouts.', 'wpv'),
	'id' => 'layout-type',
	'type' => 'body-layout',
	'only' => 'page,post,portfolio,product',
	'default' => wpv_get_option('default-body-layout'),
),
array(
	'name' => __('Custom Sidebars', 'wpv'),
	'desc' => __('This option correlates with the one above. If you have custom sidebars created, you will enable them by selecting them in the drop-down menu. Otherwise the page default sidebars will be used.', 'wpv'),
	'type' => 'select-row',
	'selects' => array(
		'left_sidebar_type' => array(
			'desc' => __('Left:', 'wpv'),
			'prompt' => __('Default', 'wpv'),
			'target' => 'sidebars',
			'default' => false,
		),
		'right_sidebar_type' => array(
			'desc' => __('Right:', 'wpv'),
			'prompt' => __('Default', 'wpv'),
			'target' => 'sidebars',
			'default' => false,
		),
	),
),

array(
	'name' => __('Show Body Top Widget Areas', 'wpv'),
	'desc' => __('These can be configured from "Vamtam" -> "Layout" -> "Body".', 'wpv'),
	'image' => WPV_ADMIN_ASSETS_URI.'images/header-sidebars-1.png',
	'id' => 'show_header_sidebars',
	'type' => 'toggle',
	'default' => wpv_get_option('has-header-sidebars'),
),

array(
	'name' => __('Show Page Title Header', 'wpv'),
	'id' => 'show_page_header',
	'type' => 'toggle',
	'default' => true,
),

array(
	'name' => __('Description', 'wpv'),
	'desc' => __('The text will appear next or bellow the title of the page, only if the option above is enabled.', 'wpv'),
	'id' => 'description',
	'type' => 'textarea',
	'only' => 'page',
	'default' => '',
),

array(
	'name' => __('Page Background', 'wpv'),
	'desc' => __('Please note that this option is used only in boxed layout mode.<br>
In full width layout mode the page background is covered by the header, slider, body and footer backgrounds respectively. If the color opacity of these areas is 1 or an opaque image is used, the page background won\'t be visible.<br>
If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
You can override this option on a page by page basis.', 'wpv'),
	'id' => 'background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

array(
	'name' => __('Page Title Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv'),
	'id' => 'local-title-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size',
),

array(
	'name' => __('Fancy Portfolio', 'wpv'),
	'type' => 'separator'
),

array(
	'name' => __('Type', 'wpv'),
	'desc' => __('If you select any of categories below, the fancy portfolio will be enabled.<br>
Full screen type portfolio will slide the portfolio items in full screen mode without showing the text of the items. It is similar to a gallery.<br>
Ajax portfolio type will open the portfolio item in the top of the  same listing page.', 'wpv'),
	'id' => 'fancy-portfolio-type',
	'type' => 'select',
	'only' => 'page',
	'options' => array(
		'background' => __('Full background', 'wpv'),
		'page' => __('Ajax portfolio', 'wpv'),
	),
	'class' => 'top-desc',
) ,

array(
	'name' => __('Categories', 'wpv'),
	'desc' => __('If you select any of these categories, the fancy portfolio will be enabled.', 'wpv'),
	'id' => 'fancy-portfolio-categories',
	'default' => array(),
	'target' => 'portfolio_category',
	'type' => 'multiselect',
	'only' => 'page',
	'class' => 'top-desc',
	'layout' => 'checkbox',
) ,

array(
	'name' => __('Slider', 'wpv'),
	'type' => 'separator'
),

array(
	'name' => __('Show Slider in Header', 'wpv'),
	'id' => 'show_header_slider',
	'type' => 'toggle',
	'default' => wpv_get_option('has-header-slider'),
),

array(
	'name' => __('Page Slider', 'wpv'),
	'desc' => __('In the drop down you will see the sliders that you have created. If you do not see any, you can create one in Vamtam =>Sliders.', 'wpv'),
	'id' => 'slider-category',
	'type' => 'select',
	'default' => '',
	'options' => array(),
	'target' => 'slideshow_category',
),

array(
	'name' => __('Page Slider Style', 'wpv'),
	'id' => 'slider-effect',
	'type' => 'select',
	'default' => wpv_get_option('header-slider-effect'),
	'options' => $wpv_slider_effects,
),

array(
	'name' => __('Page Slider Height', 'wpv'),
	'desc' => sprintf(__('This option is only used for the Vamtam Slider. If you\'d like to change LayerSlider\'s height, please <a href="%s" title="LayerSlider settings">click here</a>.', 'wpv'), admin_url('admin.php?page=layerslider')),
	'id' => 'slider-height',
	'type' => 'range',
	'min' => 100,
	'max' => 800,
	'unit' => 'px',
	'default' => wpv_get_option('header-slider-height'),
),

array(
	'name' => __('Post Format Settings', 'wpv'),
	'only' => 'post',
	'type' => 'separator',
),

array(
	'name' => __('Link', 'wpv'),
	'desc' => __('Used in the "quote", "link", "audio" and "video" formats', 'wpv'),
	'id' => 'post-link',
	'only' => 'post',
	'type' => 'text',
	'default' => '',
),

array(
	'name' => __('Quote Author', 'wpv'),
	'desc' => __('Used in the "quote" format', 'wpv'),
	'id' => 'quote-author',
	'only' => 'post',
	'type' => 'text',
	'default' => '',
),

array(
	'name' => __('Portfolio', 'wpv'),
	'only' => 'portfolio',
	'type' => 'separator',
),

array(
	'name' => __('Portfolio Data Type', 'wpv'),
	'desc' => __('Image - uses the featured image (default)<br />
				  Gallery - use the featured image as a title image but show additional images too<br />
				  Video/Link - uses the "portfolio data url" setting<br />
				  Document - acts like a normal post<br />
				  HTML - overrides the image with arbitrary HTML when displaying a single portfolio page. Does not work with the ajax portfolio.
				', 'wpv'),
	'id' => 'portfolio_type',
	'only' => 'portfolio',
	'type' => 'select',
	'options' => array(
		'image' => __('Image', 'wpv'),
		'gallery' => __('Gallery', 'wpv'),
		'video' => __('Video', 'wpv'),
		'link' => __('Link', 'wpv'),
		'document' => __('Document', 'wpv'),
		'html' => __('HTML', 'wpv'),
	),
	'default' => 'image',
),
array(
	'name' => __('Portfolio Data Url', 'wpv'),
	'id' => 'portfolio_data_url',
	'type' => 'text',
	'only' => 'portfolio',
	'default' => '',
),

array(
	'name' => __('HTML Content Used for the "HTML" Portfolio Type', 'wpv'),
	'desc' => __('Please note that if you are using the AJAX portfolio, some shortcodes may not work as expected in this field.', 'wpv'),
	'id' => 'portfolio-top-html',
	'type' => 'textarea',
	'only' => 'portfolio',
	'default' => '',
),

array(
	'name' => __('Logo', 'wpv'),
	'id' => 'portfolio-logo',
	'type' => 'upload',
	'only' => 'portfolio',
	'default' => '',
),

array(
	'name' => __('Client', 'wpv'),
	'id' => 'portfolio-client',
	'type' => 'text',
	'only' => 'portfolio',
	'default' => '',
),

);
