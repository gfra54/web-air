<?php
return array(
	'name' => __('Flickr', 'wpv') ,
	'desc' => __('This element is usefull if you have Flickr account. Use <a href="http://idgettr.com/" target="_blank">idGettr</a> if you don\'t know your ID.<br/><br/>.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('flickr'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'flickr',
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
			'name' => __('Type', 'wpv'),
			'id' => 'type',
			'default' => 'page',
			'options' => array(
				'user' => __('User', 'wpv'),
				'group' => __('Group', 'wpv'),
			),
			'type' => 'select',
		),
		array(
			'name' => __('Flickr ID', 'wpv'),
			'desc' => __('Use <a href="http://idgettr.com/" target="_blank">idGettr</a> if you don\'t know your ID.', 'wpv'),
			'id' => 'id',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Count', 'wpv'),
			'desc' => '',
			'id' => 'count',
			'default' => 4,
			'min' => 0,
			'max' => 20,
			'type' => 'range'
		),
		array(
			'name' => __('Display', 'wpv'),
			'id' => 'display',
			'default' => 'latest',
			'options' => array(
				'latest' => __('Latest', 'wpv'),
				'random' => __('Random', 'wpv'),
			),
			'type' => 'select',
		),
	) ,
);
