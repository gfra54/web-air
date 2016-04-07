<?php
return array(
	'name' => __('Video', 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('play'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'video',
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
			'name' => __('General', 'wpv'),
			'type' => 'separator',
		),
			array(
				'name' => __('Video URL', 'wpv'),
				'desc' => __('Enter the url to your video. We support youtube, vimeo, dailymotion, as well as MP4, OGG, WebM and SWF files.', 'wpv'),
				'id' => 'src',
				'default' => '',
				'type' => 'text',
				'holder' => 'div',
			),
			array(
				'name' => __('Maximum Width', 'wpv'),
				'id' => 'width',
				'default' => 0,
				'min' => 0,
				'max' => 960,
				'type' => 'range'
			),
			array(
				'name' => __('Maximum Height', 'wpv'),
				'id' => 'height',
				'default' => 0,
				'min' => 0,
				'max' => 960,
				'type' => 'range'
			),
			array(
				'name' => __('Start Automatically', 'wpv'),
				'desc' => __('Select this if you want the video to start playing as soon as the page is loaded.', 'wpv'),
				'id' => 'autoplay',
				'default' => false,
				'type' => 'toggle'
			),

		array(
			'name' => __('HTML5-specific', 'wpv'),
			'type' => 'separator',
		),
			array(
				'name' => __('Poster Image', 'wpv'),
				'desc' => __("The poster image is placeholder for the video before it plays. It's also used as the image fallback for devices that don't support HTML5 Video or Flash.", 'wpv'),
				'id' => 'poster',
				'size' => 30,
				'default' => '',
				'type' => 'upload',
			),
			array(
				'name' => __('Preload', 'wpv'),
				'desc' => __('Select this if you want the video to start downloading as soon the user loads the page.', 'wpv'),
				'id' => 'preload',
				'default' => false,
				'type' => 'toggle'
			),

		array(
			'name' => __('Flash-specific', 'wpv'),
			'type' => 'separator',
		),
			array(
				'name' => __('Flashvars (optional)', 'wpv'),
				'desc' => __('Variables to pass to Flash Player.', 'wpv'),
				'id' => 'flashvars',
				'size' => 30,
				'default' => '',
				'type' => 'text',
			),
	),
);
