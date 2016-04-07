<?php
return array(
	'name' => __('Text Divider', 'wpv') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('minus'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text_divider',
	'controls' => 'name clone edit delete',
	'options' => array(
		array(
			'name' => __('Type', 'wpv') ,
			'id' => 'type',
			'default' => 'single',
			'options' => array(
				'single' => __('Type 1', 'wpv') ,
				'double' => __('Type 2', 'wpv') ,
			) ,
			'type' => 'select',
			'class' => 'add-to-container',
			'field_filter' => 'ftds',
		) ,
		array(
			'name' => __('Text', 'wpv') ,
			'id' => 'html-content',
			'default' => __('Click edit to change this text', 'wpv'),
			'type' => 'editor',
			'class' => 'ftds ftds-single ftds-double',
		) ,
		array(
			'name' => __('"More Info" Link', 'wpv'),
			'id' => 'more',
			'default' => '',
			'placeholder' => __('No link', 'wpv'),
			'type' => 'text',
			'class' => 'ftds ftds-single',
		),
	) ,
);
