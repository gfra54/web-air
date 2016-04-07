<?php
return array(
	'name' => __('IFrame', 'wpv') ,
	'desc' => __('You can embed a website using this element.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('tablet'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'iframe',
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
			'name' => __('Source', 'wpv') ,
			'desc' => __('The URL of the page you want to display.', 'wpv'),
			'id' => 'src',
			'size' => 30,
			'default' => '',
			'type' => 'text',
			'holder' => 'div',
			'placeholder' => __('Click edit to set iframe source url', 'wpv'),
		) ,
		array(
			'name' => __('Width', 'wpv') ,
			'desc' => __('You can use % or px as units for width.', 'wpv') ,
			'id' => 'width',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Height', 'wpv') ,
			'desc' => __('You can use % or px as units for height.', 'wpv') ,
			'id' => 'height',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
