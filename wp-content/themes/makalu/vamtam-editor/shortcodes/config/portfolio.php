<?php
return array(
	'name' => __('Portfolio', 'wpv') ,
	'desc' => __('Please note that this element shows already created portfolio posts. To create one go to the Portfolios tab in the WordPress main navigation menu on the left - Add New. ' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('grid2'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'portfolio',
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
			'name' => __('Columns', 'wpv') ,
			'id' => 'column',
			'default' => 4,
			'type' => 'range',
			'min' => 1,
			'max' => 4,
		) ,
		array(
			'name' => __('No Paging', 'wpv') ,
			'id' => 'nopaging',
			'desc' => __('If the option is on, it will disable pagination.', 'wpv') ,
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Limit', 'wpv') ,
			'desc' => __('Number of item to show per page. If you set it to -1, it will display all portfolio items.', 'wpv') ,
			'id' => 'max',
			'default' => '8',
			'min' => -1,
			'max' => 100,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Image Height', 'wpv') ,
			'id' => 'height',
			'default' => '400',
			'min' => 0,
			'max' => 1200,
			'type' => 'range'
		) ,
		array(
			'name' => __('Sortable', 'wpv') ,
			'id' => 'sortable',
			'desc' => __('If the option is on, it will disable pagination, displaying all posts by category with sortable.', 'wpv') ,
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Categories (optional)', 'wpv') ,
			'id' => 'cat',
			'default' => array() ,
			'target' => 'portfolio_category',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __('IDs (optional)', 'wpv') ,
			'desc' => __('The specific portfolios you want to display.', 'wpv') ,
			'id' => 'ids',
			'default' => array() ,
			'target' => 'portfolio',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __('Display Title', 'wpv') ,
			'id' => 'title',
			'desc' => __('If the option is on, it will display title of portfolio.', 'wpv') ,
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Display Description', 'wpv') ,
			'id' => 'desc',
			'desc' => __('If the option is on, it will display description of portfolio.', 'wpv') ,
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('More Button Text', 'wpv') ,
			'id' => 'more',
			'default' => __('Read more', 'wpv') ,
			'type' => 'text',
		) ,
		array(
			'name' => __('Group', 'wpv') ,
			'id' => 'group',
			'desc' => __('If the option is on, the lightbox will display left and right arrow.', 'wpv') ,
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Long Description', 'wpv') ,
			'id' => 'long',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Scrollable', 'wpv'),
			'id' => 'scrollable',
			'type' => 'toggle',
			'default' => false,
		),
	) ,
);
