<?php
return array(

array(
	'name' => __('Body', 'wpv'),
	'type' => 'start',	
),

array(
	'name' => __('Where are these options used?', 'wpv'),
	'desc' => __('The page body is the area between the header and the footer. The page title, the body top widget areas and the sidebars are located here. You can change the style of these areas using the options below.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Backgrounds', 'wpv'),
	'type' => 'separator',
),
		
array(
	'name' => __('Body Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'wpv'),
	'id' => 'main-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size,attachment'
),

array(
	'name' => __('Page Title Background', 'wpv'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv'),
	'id' => 'title-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size',
),

array(
	'name' => __('Typography', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Body Font', 'wpv'),
	'desc' => __('This is the general font used in the body and the sidebars. Please note that the styles of the heading fonts are located in the general typography tab.', 'wpv'),
	'id' => 'primary-font',
	'type' => 'font',
	'min' => 1,
	'max' => 20,
	'lmin' => 1,
	'lmax' => 40,
),

array(
	'name' => __('Links', 'wpv'),
	'type' => 'color-row',
	'inputs' => array(
		'css_link_color' => __('Normal:', 'wpv'),
		'css_link_visited_color' => __('Visited:', 'wpv'),
		'css_link_hover_color' => __('Hover:', 'wpv'),
	),
),

	array(
		'type' => 'end'
	),

);