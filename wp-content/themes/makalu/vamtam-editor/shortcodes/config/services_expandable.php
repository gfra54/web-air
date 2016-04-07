<?php
return array(
	'name' => __('Expandable Box ', 'wpv') ,
	'desc' => __('You have open and closed states of the box and you can set diffrenet content and background of each state.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('expand1'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services_expandable',
	'controls' => 'size name clone edit delete',
	'callbacks' => array(
		'init' => 'init-expandable-services',
		'generated-shortcode' => 'generate-expandable-services',
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
			'name' => __('No Column Margin', 'wpv') ,
			'id' => 'column_nomargin',
			'type' => 'toggle',
		) ,
		array(
			'name' => __('Title', 'wpv') ,
			'id' => 'title',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Closed state', 'wpv') ,
			'id' => 'closed',
			'default' => '',
			'type' => 'textarea',
			'class' => 'noattr',
		) ,
		array(
			'name' => __('Expanded state', 'wpv') ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Image', 'wpv') ,
			'id' => 'image',
			'default' => '',
			'type' => 'upload'
		) ,
		array(
			'name' => __('Background', 'wpv') ,
			'id' => 'background',
			'type' => 'select',
			'options' => array(
				'transparent' => __('Transparent', 'wpv'),
				'accent1' => __('Accent 1', 'wpv'),
				'accent2' => __('Accent 2', 'wpv'),
				'accent3' => __('Accent 3', 'wpv'),
				'accent4' => __('Accent 4', 'wpv'),
				'accent5' => __('Accent 5', 'wpv'),
				'accent6' => __('Accent 6', 'wpv'),
				'accent7' => __('Accent 7', 'wpv'),
				'accent8' => __('Accent 8', 'wpv'),
			),
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'desc' => __('A class name added to the wrapper element of the shortcode', 'wpv'),
			'id' => 'class',
			'type' => 'text'
		) ,		
	) ,
);
