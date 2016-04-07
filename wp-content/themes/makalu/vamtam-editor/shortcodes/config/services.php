<?php
return array(
	'name' => __('Service Box', 'wpv') ,
	'desc' => __('Please note that the service box may not work properly in one half to full width layouts.' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('cog1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services',
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
			'name' => __('Style', 'wpv') ,
			'id' => 'fullimage',
			'default' => 'false',
			'type' => 'select',
			'options' => array(
				'false' => __('Style 1', 'wpv'),
				'true' => __('Style 2', 'wpv'),
			),
		) ,
		array(
			'name' => __('Title', 'wpv') ,
			'id' => 'title',
			'default' => '',
			'type' => 'text',
			'holder' => 'h5',
		) ,
		array(
			'name' => __('Icon', 'wpv') ,
			'desc' => __('This option overrides the "Image" option.', 'wpv'),
			'id' => 'icon',
			'default' => '',
			'type' => 'select',
			'prompt' => '',
			'options' => wpv_get_icons_extended(),
		) ,
		array(
			'name' => __('Image', 'wpv') ,
			'desc' => __('This option can be overridden by the "Icon" option.', 'wpv'),
			'id' => 'image',
			'default' => '',
			'type' => 'upload'
		) ,
		array(
			'name' => __('Description', 'wpv') ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Text Alignment', 'wpv') ,
			'id' => 'text_align',
			'default' => 'justify',
			'type' => 'select',
			'options' => array(
				'justify' => 'justify',
				'left' => 'left',
				'center' => 'center',
				'right' => 'right',
			)
		) ,
		array(
			'name' => __('Link', 'wpv') ,
			'id' => 'button_link',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Text', 'wpv') ,
			'id' => 'button_text',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'id' => 'class',
			'type' => 'text'
		) ,
	) ,
);
