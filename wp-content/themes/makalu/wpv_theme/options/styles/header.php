<?php
return array(
		
array(
	'name' => __('Header', 'wpv'),
	'type' => 'start',
	
),

array(
	'name' => __('Where are these options used?', 'wpv'),
	'desc' => __('The header consist of the area above the body up to the top. It is divided in two main areas - the main menu area and the slider area. You can change the style of these areas using the options below.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Backgrounds', 'wpv'),
	'type' => 'separator',
),


array(
	'name' => __('Header Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
	If the color opacity is less than 1 the page background underneath will be visible.', 'wpv'),
	'id' => 'header-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size',
),

array(
	'name' => __('Header Slider Background', 'wpv'),
	'desc' => __('If the color opacity is less than 1 the page background underneath will be visible.', 'wpv'),
	'id' => 'slider-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size',
),

array(
	'name' => __('Typography', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Site Title', 'wpv'),
	'desc' => sprintf(__('You can set the website title in <a href="%s" title="set website background">from here</a>. It is alternative to using an image logo.', 'wpv'), admin_url('options-general.php')),
	'id' => 'logo',
	'type' => 'font',
	'min' => 10,
	'max' => 60,
	'lmin' => 10,
	'lmax' => 90,
	'only' => 'size,face,weight,color',
),

array(
	'name' => __('Main Menu', 'wpv'),
	'desc' => sprintf(__('Please note that you have to use the WordPress custom menu feature located in <a href="%s" title="WordPress menus">Appearance - Menus</a>', 'wpv'), admin_url('nav-menus.php')),
	'id' => 'menu-font',
	'type' => 'font',
	'only' => 'size,face,weight,color',
	'min' => 10,
	'max' => 24,
	'lmin' => 10,
	'lmax' => 300,
	'class' => 'short-border',
),

array(
	'name' => '',
	'type' => 'color-row',
	'inputs' => array(
		'css_menu_hover_color' => __('Text Hover Color:', 'wpv'),
	),
),

array(
	'name' => __('Main Menu Sub-Menus', 'wpv'),
	'type' => 'color-row',
	'inputs' => array(
		'css_menu_background' => __('Background:', 'wpv'),
		'css_submenu_color' => __('Text Normal Color:', 'wpv'),
		'css_submenu_hover_color' => __('Text Hover Color:', 'wpv'),
	),
),

array(
	'name' => __('Top Header Second Menu', 'wpv'),
	'desc' => sprintf(__('Please note that you have to use the WordPress custom menu feature located in <a href="%s" title="WordPress menus">Appearance - Menus</a>', 'wpv'), admin_url('nav-menus.php')),
	'type' => 'color-row',
	'inputs' => array(
		'css_tophead_link_color' => __('Text Normal Color:', 'wpv'),
		'css_tophead_link_hover_color' => __('Text Hover Color:', 'wpv'),
		'css_tophead_current_link_color' => __('Text Active Color:', 'wpv'),
	),
),

	array(
		'type' => 'end'
	),
);