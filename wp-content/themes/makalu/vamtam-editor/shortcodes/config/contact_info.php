<?php
return array(
	'name' => __('Contact Info', 'wpv') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('vcard'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'contact_info',
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
			'name' => __('Name', 'wpv'),
			'id' => 'name',
			'default' => '',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __('Color', 'wpv'),
			'id' => 'color',
			'default' => '',
			'prompt' => __('---', 'wpv'),
			'options' => array(
				'accent1' => __('Accent 1', 'wpv'),
				'accent2' => __('Accent 2', 'wpv'),
				'accent3' => __('Accent 3', 'wpv'),
				'accent4' => __('Accent 4', 'wpv'),
				'accent5' => __('Accent 5', 'wpv'),
				'accent6' => __('Accent 6', 'wpv'),
				'accent7' => __('Accent 7', 'wpv'),
				'accent8' => __('Accent 8', 'wpv'),
				
			),
			'type' => 'select',
		),
		array(
			'name' => __('Phone', 'wpv'),
			'id' => 'phone',
			'default' => '',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __('Cell Phone', 'wpv'),
			'id' => 'cellphone',
			'default' => '',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __('Email', 'wpv'),
			'id' => 'email',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Address', 'wpv'),
			'id' => 'address',
			'default' => '',
			'size' => 30,
			'type' => 'textarea'
		),
	) ,
);
