<?php
global $wpv_slider_shortcode_styles, $wpv_shortcode_slider_effects;

return array(
	'name' => __('Vamtam Slider', 'wpv') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('images'),
		'size' => '24px',
		'lheight' => '36px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'slider',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Column Title', 'wpv') ,
			'desc' => __('The column title is placed just above the element.', 'wpv'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Column Title Type', 'wpv') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Type 1', 'wpv'),
				'double' => __('Type 2', 'wpv'),
				'no-divider' => __('No Divider', 'wpv'),
			),
		) ,
		array(
			'name' => __('Slider Name', 'wpv'),
			'id' => 'name',
			'type' => 'select',
			'default' => '',
			'options' => Config_Generator::target_config('slideshow_category_simple'),
		),
		array(
			'name' => __('Width', 'wpv') ,
			'desc' => __('Set it to 0 for maximum width.', 'wpv') ,
			'id' => 'width',
			'min' => 0,
			'max' => 1200,
			'default' => 0,
			'type' => 'range'
		) ,
		array(
			'name' => __('Height', 'wpv') ,
			'desc' => __('If you set it to 0 the slider will be as high as the highest slide. You must have at least on HTML slide in order to use auto height option.', 'wpv') ,
			'id' => 'height',
			'min' => 0,
			'max' => 1200,
			'default' => 225,
			'type' => 'range'
		) ,
		array(
			'name' => __('Effect', 'wpv') ,
			'id' => 'effect',
			'default' => 'random',
			'type' => 'select',
			'options' => $wpv_shortcode_slider_effects,
		) ,
		array(
			'name' => __('Animation Speed', 'wpv') ,
			'id' => 'animspeed',
			'min' => 0,
			'max' => 60000,
			'default' => 1000,
			'type' => 'range'
		) ,
		array(
			'name' => __('Pause Time', 'wpv') ,
			'id' => 'pausetime',
			'min' => 0,
			'max' => 60000,
			'default' => 5000,
			'type' => 'range'
		) ,
		array(
			'name' => __('Pause on Hover', 'wpv') ,
			'id' => 'pauseonhover',
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Slider Style', 'wpv') ,
			'id' => 'style',
			'default' => '1',
			'type' => 'select',
			'options' => $wpv_slider_shortcode_styles
		) ,
		array(
			'name' => __('Maintain Aspect Ratio', 'wpv') ,
			'desc' => __('This is useful if all your slides feature images with the same proportions. If you enable this option your slider will have the same proportions as the original width/height settings, regardless of the screen resolution.', 'wpv'),
			'id' => 'maintain_aspect_ratio',
			'type' => 'toggle',
			'default' => true,
		) ,
	) ,
);
