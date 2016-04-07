<?php
return array(
	'name' => 'Slide type 1',
	'value' => 'slide_1',
	'options' => array(
		array(
			'name' => __('Background color', 'wpv') ,
			'id' => 'bg_color',
			'default' => 'transparent',
			'type' => 'color',
		) ,
		array(
			'name' => __('Background image', 'wpv') ,
			'id' => 'bg_image',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Background opacity', 'wpv') ,
			'id' => 'bg_opacity',
			'default' => 1,
			'type' => 'range',
			'min' => 0,
			'max' => 1,
			'step' => 0.05,
		) ,
		array(
			'name' => __('Big image', 'wpv') ,
			'id' => 'big_image',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Small image', 'wpv') ,
			'id' => 'small_image',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Text 1', 'wpv') ,
			'id' => 'text1',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Text 2', 'wpv') ,
			'id' => 'text2',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Button text', 'wpv') ,
			'id' => 'btn_text',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Button link', 'wpv') ,
			'id' => 'btn_href',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Button target', 'wpv') ,
			'id' => 'btn_target',
			'default' => '_self',
			'type' => 'select',
			'options' => array(
				'_self' => __('Same window', 'wpv'),
				'_blank' => __('New window', 'wpv'),
			),
		) ,
		array(
			'name' => __('Additional image 1', 'wpv') ,
			'id' => 'add_image_1',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Additional image 2', 'wpv') ,
			'id' => 'add_image_2',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'id' => 'class',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
