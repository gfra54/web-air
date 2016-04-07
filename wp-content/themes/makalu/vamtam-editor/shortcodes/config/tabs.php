<?php
return array(
	'name' => __('Tabs', 'wpv') ,
	'desc' => __('Adding tabs, changing the name of the tab and adding content into the tabs is done when the tab element is toggled.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('storage1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'tabs',
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-tabs',
		'generated-shortcode' => 'generate-tabs',
	),
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
			'name' => __('Autorotate Delay', 'wpv') ,
			'desc' => __('Set to 0 for manual rotation.', 'wpv') ,
			"id" => "delay",
			'min' => 0,
			'max' => 60000,
			"step" => 200,
			"default" => 0,
			"type" => "range",
			'unit' => 'ms',
		) ,
	) ,
);
