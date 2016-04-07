<?php
return array(
	'name' => 'Slide type 2',
	'value' => 'slide_2',
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
			'name' => __('Text 3', 'wpv') ,
			'id' => 'text3',
			'default' => '',
			'type' => 'text',
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
