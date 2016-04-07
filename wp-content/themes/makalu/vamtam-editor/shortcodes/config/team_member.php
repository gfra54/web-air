<?php
return 	array(
	'name' => __('Team Member', 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('profile'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'team_member',
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
			'type' => 'text',
			'holder' => 'h5',
		),
		array(
			'name' => __('Position', 'wpv'),
			'id' => 'position',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Link', 'wpv'),
			'id' => 'url',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Email', 'wpv'),
			'id' => 'email',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Phone', 'wpv'),
			'id' => 'phone',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Picture url', 'wpv'),
			'id' => 'picture',
			'default' => '',
			'type' => 'upload'
		),
		array(
			'name' => __('Google+', 'wpv'),
			'id' => 'googleplus',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('LinkedIn', 'wpv'),
			'id' => 'linkedin',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Facebook', 'wpv'),
			'id' => 'facebook',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Twitter', 'wpv'),
			'id' => 'twitter',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('YouTube', 'wpv'),
			'id' => 'youtube',
			'default' => '',
			'type' => 'text'
		),
	),
);
