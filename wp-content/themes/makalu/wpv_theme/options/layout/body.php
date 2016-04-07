<?php

return array(
array(
	'name' => __('Body', 'wpv'),
	'type' => 'start',
	
),

array(
	'name' => __('Body Layout', 'wpv'),
	'desc' => __('You can enable or disable the title, the body top widget areas and the body sidebar areas.<br>
Below you can set the width of the sidebars in the body and the height of the header title area.<br>
This will be the default layout for all pages<br>
Note: You can override some of the options on a page by page basis: enable/disable the title, body sidebars and body top widget areas.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Enable the Page Title', 'wpv'),
	'desc' => __('You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'has-page-header',
	'type' => 'toggle',
),

array(
	'name' => __('Page Title Area Height', 'wpv'),
	'desc' => __('The height of the area where the title is located.', 'wpv'),
	'id' => 'page-header-height',
	'type' => 'range',
	'min' => 30,
	'max' => 300,
	'unit' => 'px',
),

array(
	'name' => __('Enable Breadcrumbs', 'wpv'),
	'desc' => __('Breadcrumbs is yet another navigation menu  just below the page title.', 'wpv'),
	'id' => 'enable-breadcrumbs',
	'type' => 'toggle',
),

array(
	'name' => __('Enable Body Top Widget Areas', 'wpv'),
	'desc' => __('This option only enables the widget areas. You can choose the layout using the two options bellow. In appearance - widgets, you can populate the area with widgets. You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'has-header-sidebars',
	'type' => 'toggle',
),

array(
	'name' => __('Body Top Widget Area Pre-defined Layouts', 'wpv'),
	'desc' => __('The widget areas below are placed just below the page title. You can either choose one of the predefined layouts or configure your own in the "Advanced" section bellow.', 'wpv'),
	'type' => 'autofill',
	'class' => 'no-box',
	'option_sets' => array(
		array(
			'name' => __('1/3 | 1/3 | 1/3', 'wpv'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-sidebars-3.png',
			'values' => array(
				'header-sidebars' => 3,
				'header-sidebars-1-width' => 'cell-1-3',
				'header-sidebars-1-last' => 0,
				'header-sidebars-2-width' => 'cell-1-3',
				'header-sidebars-2-last' => 0,
				'header-sidebars-3-width' => 'cell-1-3',
				'header-sidebars-3-last' => 1,
				'header-sidebars-4-width' => 'full',
				'header-sidebars-4-last' => 0,
				'header-sidebars-5-width' => 'full',
				'header-sidebars-5-last' => 0,
				'header-sidebars-6-width' => 'full',
				'header-sidebars-6-last' => 0,
			),
		),
		array(
			'name' => __('1/4 | 1/4 | 1/4 | 1/4', 'wpv'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-sidebars-4.png',
			'values' => array(
				'header-sidebars' => 4,
				'header-sidebars-1-width' => 'cell-1-4',
				'header-sidebars-1-last' => 0,
				'header-sidebars-2-width' => 'cell-1-4',
				'header-sidebars-2-last' => 0,
				'header-sidebars-3-width' => 'cell-1-4',
				'header-sidebars-3-last' => 0,
				'header-sidebars-4-width' => 'cell-1-4',
				'header-sidebars-4-last' => 1,
				'header-sidebars-5-width' => 'full',
				'header-sidebars-5-last' => 0,
				'header-sidebars-6-width' => 'full',
				'header-sidebars-6-last' => 0,
			),
		),
		
		array(
			'name' => __('1/5 | 1/5 | 1/5 | 1/5 | 1/5', 'wpv'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-sidebars-5.png',
			'values' => array(
				'header-sidebars' => 5,
				'header-sidebars-1-width' => 'cell-1-5',
				'header-sidebars-1-last' => 0,
				'header-sidebars-2-width' => 'cell-1-5',
				'header-sidebars-2-last' => 0,
				'header-sidebars-3-width' => 'cell-1-5',
				'header-sidebars-3-last' => 0,
				'header-sidebars-4-width' => 'cell-1-5',
				'header-sidebars-4-last' => 0,
				'header-sidebars-5-width' => 'cell-1-5',
				'header-sidebars-5-last' => 1,
				'header-sidebars-6-width' => 'full',
				'header-sidebars-6-last' => 0,
			),
		),
	),
),

array(
	'name' => __('Body Top Widget Areas Advanced Layout Builder', 'wpv'),
	'desc' => __("Please choose the number of widget areas and adjust each widget area's settings. You can adjust the width of each widget area from the six options and place them in one to six rows.", 'wpv'),
	'id_prefix' => 'header-sidebars',
	'type' => 'horizontal_blocks',
	'min' => 0,
	'max' => 6,
),

array(
	'name' => __('Default Sidebar Layout', 'wpv'),
	'desc' => __('The sidebars are placed just below the page title.  You can choose one of the predefined layouts.<br>
You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'default-body-layout',
	'type' => 'body-layout',
),

array(
	'name' => __('Left Sidebar Width', 'wpv'),
	'desc' => __('The width is percent of the website width.', 'wpv'),
	'id' => 'left-sidebar-width',
	'type' => 'range',
	'min' => 15,
	'max' => 50,
	'unit' => '%'
),
array(
	'name' => __('Right Sidebar Width', 'wpv'),
	'desc' => __('The width is percent of the website width.', 'wpv'),
	'id' => 'right-sidebar-width',
	'type' => 'range',
	'min' => 15,
	'max' => 50,
	'unit' => '%',
),

	array(
		'type' => 'end'
	),	
);