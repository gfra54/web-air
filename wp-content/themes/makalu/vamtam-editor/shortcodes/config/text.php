<?php
return array(
	'name' => __('Text Block', 'wpv') ,
	'desc' => __('Please note that you can style your text with the help of the VamTam shortcodes found in the editor icon board at the top. Look for the V button. <br/>
		You can insert an image by the button -Add Media- found above the editor when you open the element option panel.<br/>
		You can toggle the element and insert plane text if you are in a rush.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('file3'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text',
	'controls' => 'size name edit delete clone handle',
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
			'name' => __('Column Divider', 'wpv') ,
			'desc' => __('If enabled, the column will have a vertical divider on the left.', 'wpv'),
			'id' => 'column_divider',
			'default' => false,
			'type' => 'toggle'
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
