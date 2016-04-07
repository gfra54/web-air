<?php
return array(
	'name' => __('Blank Space', 'wpv') ,
	'desc' => __('You can increase or decrease the space between elements using this shortcode.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('page-break'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'blank',
	'controls' => 'name clone edit delete',
	'class' => 'slim',
	'options' => array(
		array(
			'name' => __('Height', 'wpv') ,
			'id' => 'h',
			'default' => 30,
			'min' => 0,
			'max' => 200,
			'type' => 'range',
		) ,
	) ,
);