<?php
global $wpv_slider_effects;

return array(
array(
	'name' => __('General Slider Settings', 'wpv'),
	'type' => 'start'
),

array(
	'name' => __('Where are these options used?', 'wpv'),
	'desc' => sprintf(__('Please note that the LayerSlider slides cannot be configured from here. If you\'ve selected the "LayerSlider" style below, you have to use <a href="%s">this tool</a>.
		<br>
		You can override some of the options in this section on a page by page basis: default slider, slider style. Some of them may not work with all slider types.', 'wpv'), admin_url('?page=layerslider')),
	'type' => 'info',
),

array(
	'name' => __('Header Slider', 'wpv'),
	'type' => 'separator'
),

array(
	'name' => __('Default Slider', 'wpv'),
	'desc' => __('You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'default-header-slider',
	'type' => 'select',
	'default' => '',
	'options' => array(),
	'target' => 'slideshow_category',
),

array(
	'name' => __('Slider Style', 'wpv'),
	'desc' => __('You can override this option on a page-by-page basis.', 'wpv'),
	'id' => 'header-slider-effect',
	'type' => 'select',
	'options' => $wpv_slider_effects,
),

array(
	'name' => __('Caption Queue', 'wpv'),
	'desc' => __('The captions will be animated if you have more than one caption set for a slide.', 'wpv'),
	'id' => 'header-slider-captionqueue',
	'type' => 'toggle',
),

array(
	'name' => __('Pause Time', 'wpv'),
	'id' => 'header-slider-pausetime',
	'type' => 'range',
	'min' => 500,
	'max' => 60000
),
array(
	'name' => __('Pause on Hover', 'wpv'),
	'id' => 'header-slider-pauseonhover',
	'type' => 'toggle',
),
array(
	'name' => __('Animation Time', 'wpv'),
	'desc' => __('This option does not work with multi-image slider types.', 'wpv'),
	'id' => 'header-slider-animationtime',
	'type' => 'range',
	'min' => 0,
	'max' => 10000
),
array(
	'name' => __('Autostart', 'wpv'),
	'id' => 'header-slider-direction',
	'type' => 'select',
	'options' => array(
		'none' => __('Disable autostart', 'wpv'),
		'left' => __('Left (backwards)', 'wpv'),
		'right' => __('Right (forwards)', 'wpv'),
	)
),

array(
	'name' => __('Easing', 'wpv'),
	'desc' => __('Animation easings are most visible with sliding type effects.<br>
This option does not work with multi-image slider types.', 'wpv'),
	'id' => 'header-slider-easing',
	'type' => 'select',
	'options' => array(
		'linear' => 'linear',
		'easeInQuint' => 'easeInQuint',
		'easeOutQuint' => 'easeOutQuint',
		'easeInOutQuint' => 'easeInOutQuint',
		'easeInOutBack' => 'easeInOutBack',
		'easeInOutQuad' => 'easeInOutQuad',
		'easeInOutCubic' => 'easeInOutCubic',
		'easeInOutQuart' => 'easeInOutQuart',
	)
),

array(
	'name' => __('Slide Resizing Method', 'wpv'),
	'desc' => __('This option does not work with multi-image slider types.<br>
None - the images in their real size<br>
Resize and crop - It will cover the slider window regardless of the image sizes.', 'wpv'),
	'id' => 'header-slider-resizing',
	'type' => 'select',
	'options' => array(
		'none' => __('None', 'wpv'),
		'cover-top' => __('Resize and Crop', 'wpv'),
	)
),

array(
	'name' => __('Show Thumbnails in Buttons', 'wpv'),
	'desc' => __('If enabled, some slider effects will display a thumbnail in the previous/next buttons.', 'wpv'),
	'id' => 'header-slider-button-thumbnails',
	'type' => 'toggle',
),

array(
	'name' => __('Ajax Portfolio Slider', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Slide Resizing Method', 'wpv'),
	'desc' => __('None - the images in their real size.<br>
Resize and crop - It will cover the slider window regardless of the image sizes.<br>
Fit - I will fit the image into the slider window keeping the proportions.', 'wpv'),
	'id' => 'portfolio-slider-resizing',
	'type' => 'select',
	'options' => array(
		'none' => __('None', 'wpv'),
		'crop-top' => __('Crop from the Top', 'wpv'),
		'cover-top' => __('Resize and Crop', 'wpv'),
		'fit' => __('Fit', 'wpv'),
	)
),
	array(
		'type' => 'end'
	),
);