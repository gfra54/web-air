<?php
return array(
	'name' => __('Call Out Box', 'wpv') ,
	'desc' => __('You can place the call out box into а column - color box elemnent in order to have background color.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('font-size'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'slogan',
	'controls' => 'size name clone edit delete handle',
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
			'name' => __('Content', 'wpv') ,
			'id' => 'html-content',
			'default' => __('Click edit to change this text', 'wpv'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Button Text', 'wpv') ,
			'id' => 'button_text',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Link', 'wpv') ,
			'id' => 'link',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Icon', 'wpv'),
			'type' => 'select-row',
			'selects' => array(
				'button_icon' => array(
					'desc' => __('Style:', 'wpv'),
					"default" => '',
					'prompt' => __('No icon', 'wpv'),
					"options" => wpv_get_icons_extended(),
				),
				'button_icon_color' => array(
					'desc' => __('Color:', 'wpv'),
					"default" => "",
					"prompt" => '',
					"options" => array(
						'accent1' => __('Accent 1', 'wpv'),
						'accent2' => __('Accent 2', 'wpv'),
						'accent3' => __('Accent 3', 'wpv'),
						'accent4' => __('Accent 4', 'wpv'),
						'accent5' => __('Accent 5', 'wpv'),
						'accent6' => __('Accent 6', 'wpv'),
						'accent7' => __('Accent 7', 'wpv'),
						'accent8' => __('Accent 8', 'wpv'),
					) ,
				),
				'button_icon_placement' => array(
					'desc' => __('Placement:', 'wpv'),
					"default" => 'left',
					"options" => array(
						'left' => __('Left', 'wpv'),
						'right' => __('Right', 'wpv'),
					) ,
				),
			),
		),
		array(
			'name' => __('Background Color', 'wpv') ,
			'id' => 'background',
			'type' => 'select',
			'default' => 'transparent',
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
			)
		) ,

		array(
			'name' => __('Background Image', 'wpv'),
			'desc' => __('If you are using a full width slogan on a full width website, please note that the left/right positions, as well as the cover option will not work as expected.', 'wpv'),
			'id' => 'background',
			'type' => 'background',
			'only' => 'image,repeat,position,size',
			'sep' => '_',
		),

		array(
			'name' => __('Always Boxed', 'wpv'),
			'desc' => __('Show a boxed slogan evein if you are using the full width site layout.', 'wpv'),
			'id' => 'boxed',
			'type' => 'toggle',
			'default' => false,
		),
	) ,
);
