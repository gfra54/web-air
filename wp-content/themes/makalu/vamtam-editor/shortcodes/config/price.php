<?php
return array(
		'name' => __('Price Box', 'wpv') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('basket1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'price',
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
			'name' => __('Title', 'wpv') ,
			'id' => 'title',
			'default' => __('Click edit to change this text', 'wpv'),
			'type' => 'text',
			'holder' => 'h5',
		) ,
		array(
			'name' => __('Price', 'wpv') ,
			'id' => 'price',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Currency', 'wpv') ,
			'id' => 'currency',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Duration', 'wpv') ,
			'id' => 'duration',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Summary', 'wpv') ,
			'id' => 'summary',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Description', 'wpv') ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Button Text', 'wpv') ,
			'id' => 'button_text',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Link', 'wpv') ,
			'id' => 'button_link',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Featured', 'wpv') ,
			'id' => 'featured',
			'default' => 'false',
			'type' => 'toggle'
		) ,
	) ,
);
