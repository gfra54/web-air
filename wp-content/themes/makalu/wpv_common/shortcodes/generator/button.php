<?php
return array(
	'name' => __('Buttons', 'wpv') ,
	'value' => 'button',
	'options' => array(
		array(
			'name' => __('Text', 'wpv') ,
			'id' => 'text',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Font size', 'wpv') ,
			'id' => 'font',
			'default' => 24,
			'type' => 'range',
			'min' => 10,
			'max' => 64,
		) ,
		array(
			'name' => __('Background', 'wpv') ,
			'id' => 'bgColor',
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
			'name' => __('Alignment', 'wpv') ,
			'id' => 'align',
			'default' => '',
			'prompt' => '',
			'options' => array(
				'left' => __('Left', 'wpv') ,
				'right' => __('Right', 'wpv') ,
				'center' => __('Center', 'wpv') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Link', 'wpv') ,
			'id' => 'link',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Link Target', 'wpv') ,
			'id' => 'linkTarget',
			'default' => '_self',
			'options' => array(
				'_blank' => __('Load in a new window', 'wpv') ,
				'_self' => __('Load in the same frame as it was clicked', 'wpv') ,
				'_parent' => __('Load in the parent frameset', 'wpv') ,
				'_top' => __('Load in the full body of the window', 'wpv') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Icon', 'wpv'),
			'type' => 'select-row',
			'selects' => array(
				'icon' => array(
					'desc' => __('Style:', 'wpv'),
					"default" => '',
					'prompt' => __('No icon', 'wpv'),
					"options" => wpv_get_icons_extended(),
				),
				'icon_color' => array(
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
				'icon_placement' => array(
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
			'name' => __('ID', 'wpv') ,
			'desc' => __('ID attribute added to the button element.', 'wpv'),
			'id' => 'id',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'desc' => __('Class attribute added to the button element.', 'wpv'),
			'id' => 'class',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
