<?php
return array(
	'name' => 'Standard slide',
	'value' => 'slide_standard',
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
			'name' => __('Horizontal alignment', 'wpv') ,
			'id' => 'x_align',
			'default' => 'center',
			'type' => 'select',
			'options' => array(
				'left' => 'left',
				'center' => 'center',
				'right'=> 'right',
			),
		) ,
		array(
			'name' => __('Vertical alignment', 'wpv') ,
			'id' => 'y_align',
			'default' => 'center',
			'type' => 'select',
			'options' => array(
				'top' => 'top',
				'center' => 'center',
				'bottom'=> 'bottom',
			),
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'id' => 'class',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
