<?php
return array(
array(
	'name' => __('Global Colors and Backgrounds', 'wpv'),
	'type' => 'start',
),
		
array(
	'name' => __('Global Backgrounds', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Page Background', 'wpv'),
	'desc' => __("Please note that this option is used only in boxed layout mode.<br>
In full width layout mode the page background is covered by the header, slider, body and footer backgrounds respectively. If the color opacity of these areas is 1 or an opaque image is used, the page background won't be visible.<br>
If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
You can override this option on a page by page basis.", 'wpv'),
	'id' => 'body-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size,attachment',
	'class' => 'no-border',
),

array(
	'desc' => __("You can also use some of the preset background patterns we've crafted for you", 'wpv'),
	'type' => 'autofill',
	'class' => 'no-desc',
	'option_sets' => array(
		array(
			'name' => __('Pattern 01', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/01.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/demo/01.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 02', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/02.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/02.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 03', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/03.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/03.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 04', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/04.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/04.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 05', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/05.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/05.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 06', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/06.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/06.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 07', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/07.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/07.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 08', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/08.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/08.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 09', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/09.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/09.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 10', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/10.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/10.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 11', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/11.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/11.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 12', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/12.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/12.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 13', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/13.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/13.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 14', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/14.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/14.png',
				'body-background-repeat' => 'repeat',
			),
		),
		array(
			'name' => __('Pattern 15', 'wpv'),
			'image' => WPV_THEME_IMAGES . 'patterns/demo/15.png',
			'values' => array(
				'body-background-image' => WPV_THEME_IMAGES . 'patterns/15.png',
				'body-background-repeat' => 'repeat',
			),
		),
	),
),

array(
	'name' => __('Global Colors', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Accent Colors', 'wpv'),
	'desc' => __('Most of the design elements are attached to the accent colors below. You can easily create your own skin by changing these colors.', 'wpv'),
	'type' => 'color-row',
	'inputs' => array(
		'accent-color-1' => __('Accent 1', 'wpv'),
		'accent-color-2' => __('Accent 2', 'wpv'),
		'accent-color-3' => __('Accent 3', 'wpv'),
		'accent-color-4' => __('Accent 4', 'wpv'),
		'accent-color-5' => __('Accent 5', 'wpv'),
		'accent-color-6' => __('Accent 6', 'wpv'),
		'accent-color-7' => __('Accent 7', 'wpv'),
		'accent-color-8' => __('Accent 8', 'wpv'),
	),
),

	array(
		'type' => 'end'
	),
	
);