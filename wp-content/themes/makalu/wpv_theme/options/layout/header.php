<?php

return array(
array(
	'name' => __('Header', 'wpv'),
	'type' => 'start',
),

array(
	'name' => __('Header Layout', 'wpv'),
	'desc' => __('Below you can set the height of the header and slider areas.<br>
You can enable or disable the slider.<br>
This will be the default layout for all pages<br>
Note: You can override some of the options on a page by page basis: enable/disable header slider.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Enable Header Slider', 'wpv'),
	'desc' => __('This option only enables the slider. The slider settings are located in "Header Slider" menu item. You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'has-header-slider',
	'type' => 'toggle',
),

array(
	'name' => __('Header Height', 'wpv'),
	'desc' => __('This is the area above the slider.', 'wpv'),
	'id' => 'header-height',
	'type' => 'range',
	'min' => 30,
	'max' => 300,
	'unit' => 'px',
),

array(
	'name' => __('Header Slider Height', 'wpv'),
	'desc' => sprintf(__('This option is only used for the Vamtam Slider. If you\'d like to change LayerSlider\'s height, please <a href="%s" title="LayerSlider settings">click here</a>.', 'wpv'), admin_url('admin.php?page=layerslider')),
	'id' => 'header-slider-height',
	'type' => 'range',
	'min' => 100,
	'max' => 800,
	'unit' => 'px',
),

array(
	'name' => __('Header Slider Height as a Function of the Browser Window Height', 'wpv'),
	'desc' => __('Works only with full width Vamtam sliders. Set to -1 to disable. Values over 200 are not recommended.', 'wpv'),
	'id' => 'header-slider-function-height',
	'type' => 'range',
	'min' => -1,
	'max' => 500,
	'unit' => 'px',
),
		
	array(
		'type' => 'end'
	),
	
);