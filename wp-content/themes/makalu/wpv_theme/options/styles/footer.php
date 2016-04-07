<?php
return array(
		
array(
	'name' => __('Footer', 'wpv'),
	'type' => 'start',	
),

array(
	'name' => __('Where are these options used?', 'wpv'),
	'desc' => __('The footer is the area below the body down to the bottom of your site. It consist of two main areas - the footer and the sub-footer. You can change the style of these areas using the options below.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Backgrounds', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Widget Areas Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'wpv'),
	'id' => 'footer-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size'
),

array(
	'name' => __('Sub-footer Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv'),
	'id' => 'subfooter-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size'
),

array(
	'name' => __('Typography', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Widget Areas Text', 'wpv'),
	'desc' => __('This is the general font used for the footer widgets.', 'wpv'),
	'id' => 'footer-sidebars-font',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Widget Areas Titles', 'wpv'),
	'desc' => __('Please note that this option will override the general headings style set in the General Typography" tab.', 'wpv'),
	'id' => 'footer-sidebars-titles',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Sub-footer', 'wpv'),
	'desc' => __('You can place your text/HTML in the General Settings option page.', 'wpv'),
	'id' => 'sub-footer',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Links', 'wpv'),
	'type' => 'color-row',
	'inputs' => array(
		'css_footer_link_color' => __('Normal:', 'wpv'),
		'css_footer_link_visited_color' => __('Visited:', 'wpv'),
		'css_footer_link_hover_color' => __('Hover:', 'wpv'),
	),
),

	array(
		'type' => 'end'
	),

);