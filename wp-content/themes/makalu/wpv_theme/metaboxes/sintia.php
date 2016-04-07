<?php

if(!isset($htmlslide))
	$htmlslide = false;

return apply_filters('wpv_slide_metabox', array(

array(
	'name' => __('Sample Slides', 'wpv'),
	'desc' => __('You can easily import one of our sample slides using these buttons.', 'wpv'),
	'type' => 'autofill',
	'class' => 'no-box',
	'option_sets' => wpv_get_sample_slides(),
),

array(
	'name' => __('Slide Icon', 'wpv'),
	'id' => 'icon',
	'type' => 'upload',
),

array(
	'name' => __('Slide Title', 'wpv'),
	'id' => 'title',
	'type' => 'text',
),

array(
	'name' => __('Layout Type', 'wpv'),
	'id' => 'slide-type',
	'type' => 'select',
	'options' => array(
		1 => __('Type 1', 'wpv'),
		2 => __('Type 2', 'wpv'),
		'standard' => __('Standard', 'wpv'),
	),
	'field_filter' => 'ff',
),

array(
	'name' => __('Content', 'wpv') ,
	'id' => 'content',
	'default' => '',
	'type' => 'textarea',
	'rows' => 15,
	'class' => 'ff ff-1 ff-2 ff-standard',
) ,

array(
	'name' => __('Background Color', 'wpv') ,
	'id' => 'bg_color',
	'default' => 'transparent',
	'type' => 'color',
	'class' => 'ff ff-1 ff-2 ff-standard',
) ,

array(
	'name' => __('Background Image', 'wpv') ,
	'id' => 'bg_image',
	'default' => '',
	'type' => 'upload',
	'class' => 'ff ff-1 ff-2 ff-standard',
) ,

array(
	'name' => __('Background Opacity', 'wpv') ,
	'id' => 'bg_opacity',
	'default' => 1,
	'type' => 'range',
	'min' => 0,
	'max' => 1,
	'step' => 0.05,
	'class' => 'ff ff-1 ff-2 ff-standard',
) ,

array(
	'name' => __('Big Image', 'wpv') ,
	'id' => 'big_image',
	'default' => '',
	'type' => 'upload',
	'class' => 'ff ff-1 ',
) ,

array(
	'name' => __('Small Image', 'wpv') ,
	'id' => 'small_image',
	'default' => '',
	'type' => 'upload',
	'class' => 'ff ff-1',
) ,

array(
	'name' => __('Text Line 1', 'wpv') ,
	'id' => 'text1',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-1 ff-2',
) ,

array(
	'name' => __('Text Line 2', 'wpv') ,
	'id' => 'text2',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-1 ff-2',
) ,

array(
	'name' => __('Text Line 3', 'wpv') ,
	'id' => 'text3',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-2',
) ,

array(
	'name' => __('Button Text', 'wpv') ,
	'id' => 'btn_text',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-1',
) ,
array(
	'name' => __('Button Link', 'wpv') ,
	'id' => 'btn_href',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-1',
) ,

array(
	'name' => __('Button Target', 'wpv') ,
	'id' => 'btn_target',
	'default' => '_self',
	'type' => 'select',
	'options' => array(
		'_self' => __('Same window', 'wpv'),
		'_blank' => __('New window', 'wpv'),
	),
	'class' => 'ff ff-1',
) ,

array(
	'name' => __('Additional Image 1', 'wpv') ,
	'id' => 'add_image_1',
	'default' => '',
	'type' => 'upload',
	'class' => 'ff ff-2',
) ,

array(
	'name' => __('Additional Image 2', 'wpv') ,
	'id' => 'add_image_2',
	'default' => '',
	'type' => 'upload',
	'class' => 'ff ff-2',
) ,

array(
	'name' => __('Class', 'wpv') ,
	'id' => 'class',
	'default' => '',
	'type' => 'text',
	'class' => 'ff ff-1 ff-2 ff-standard',
) ,

array(
	'name' => __('Horizontal Alignment', 'wpv') ,
	'id' => 'x_align',
	'default' => '',
	'type' => 'select',
	'options' => array(
		'left' => __('left', 'wpv'),
		'center' => __('center', 'wpv'),
		'right' => __('right', 'wpv'),
	),
	'class' => 'ff ff-standard',
) ,

array(
	'name' => __('Vertical Vlignment', 'wpv') ,
	'id' => 'y_align',
	'default' => '',
	'type' => 'select',
	'options' => array(
		'top' => __('top', 'wpv'),
		'middle' => __('middle', 'wpv'),
		'bottom' => __('bottom', 'wpv'),
	),
	'class' => 'ff ff-standard',
) ,


));