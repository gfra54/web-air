<?php
return array(
	'name' => __('Accordion', 'wpv'),
	'desc' => __('Adding panes, changing the name of the pane and adding content into the panes is done when the accordion element is toggled.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('menu1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "accordion",
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-accordion',
		'generated-shortcode' => 'generate-accordion',
	),
	"options" => array(
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
			'name' => __('Allow All Panes to be Closed', 'wpv') ,
			'desc' => __('If enabled, the accordion will load with collapsed panes. Clicking on the title of the currently active pane will close it. Clicking on the title of an inactive pane will change the active pane.', 'wpv'),
			'id' => 'collapsible',
			'default' => false,
			'type' => 'toggle'
		) ,
	),
);
