<?php
return array(
	'name' => __('Box with a Link', 'wpv') ,
	'desc' => __('You can set a link, background color and hover color to a section of the website and place your content there.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('link5'),
		'size' => '30px',
		'lheight' => '40px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'linkarea',
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
			'name' => __('No Column Margin', 'wpv') ,
			'id' => 'column_nomargin',
			'type' => 'toggle',
		) ,
		array(
			'name' => __('Link', 'wpv') ,
			'id' => 'href',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Image', 'wpv') ,
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
		) ,
		array(
			'name' => __('Contents', 'wpv') ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Background Color', 'wpv') ,
			'id' => 'background_color',
			'default' => '',
			'prompt' => __('No background', 'wpv'),
			'options' => array(
				'accent1' => __('Accent 1', 'wpv'),
				'accent2' => __('Accent 2', 'wpv'),
				'accent3' => __('Accent 3', 'wpv'),
				'accent4' => __('Accent 4', 'wpv'),
				'accent5' => __('Accent 5', 'wpv'),
				'accent6' => __('Accent 6', 'wpv'),
				'accent7' => __('Accent 7', 'wpv'),
				'accent8' => __('Accent 8', 'wpv'),
			),
			'type' => 'select'
		) ,
		array(
			'name' => __('Hover Color', 'wpv') ,
			'id' => 'hover_color',
			'default' => 'accent1',
			'options' => array(
				'accent1' => __('Accent 1', 'wpv'),
				'accent2' => __('Accent 2', 'wpv'),
				'accent3' => __('Accent 3', 'wpv'),
				'accent4' => __('Accent 4', 'wpv'),
				'accent5' => __('Accent 5', 'wpv'),
				'accent6' => __('Accent 6', 'wpv'),
				'accent7' => __('Accent 7', 'wpv'),
				'accent8' => __('Accent 8', 'wpv'),
			),
			'type' => 'select'
		) ,
		array(
			"name" => __("Target", 'wpv') ,
			"id" => "target",
			"default" => '_self',
			"options" => array(
				"_blank" => __('Load in a new window', 'wpv') ,
				"_self" => __('Load in the same frame as it was clicked', 'wpv') ,
				"_parent" => __('Load in the parent frameset', 'wpv') ,
				"_top" => __('Load in the full body of the window', 'wpv') ,
			) ,
			"type" => "select",
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'desc' => __('A class name added to the wrapper element of the shortcode', 'wpv'),
			'id' => 'class',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Hover Class', 'wpv') ,
			'desc' => __('This option is intended only for advanced users. Enter a class name which will be added to the shortcode\'s wrapper element on hover.', 'wpv'),
			'id' => 'hoverclass',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Active Class', 'wpv') ,
			'desc' => __('This option is intended only for advanced users. Enter a class name which will be added to the shortcode\'s wrapper element on click/focus.', 'wpv'),
			'id' => 'activeclass',
			'default' => '',
			'type' => 'text'
		) ,
	) ,
);
