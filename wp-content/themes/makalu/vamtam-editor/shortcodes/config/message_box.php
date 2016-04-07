<?php
return array(
	'name' => __('Message box', 'wpv') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('notification'),
		'size' => '24px',
		'lheight' => '36px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'message_box',
	'controls' => 'size name clone edit delete handle',
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
			'name' => __('Type', 'wpv') ,
			'id' => 'type',
			'default' => 'info',
			'class' => 'add-to-container',
			'options' => array(
				'info' => __('Info', 'wpv') ,
				'success' => __('Success', 'wpv') ,
				'error' => __('Error', 'wpv') ,
				'notice' => __('Notice', 'wpv') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Content', 'wpv') ,
			'id' => 'html-content',
			'default' => __('Click edit to change this text', 'wpv'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
	) ,
);
