<?php
return array(
	'name' => __('Column', 'wpv') ,
	'desc' => __('Once inserted into the editor you can change its width using +/- icons on the left.<br/>
	You can insert any element into by draging and dropping it onto the box. <br/> 
	You can drag and drop column into column for complex layouts.<br/>
	You can move any element outside of the column by drag and drop.<br/>
	You can set color/image background on any column.
	' , 'wpv'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('table1'),
		'size' => '30px',
		'lheight' => '40px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'column',
	'controls' => 'size name clone edit delete handle',
	'options' => array(
		array(
			'name' => __('Column Title', 'wpv') ,
			'desc' => __('The column title is placed just above the element.', 'wpv'),
			'id' => 'title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Column Title Type', 'wpv') ,
			'id' => 'title_type',
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
			'id' => 'nomargin',
			'type' => 'toggle',
		) ,
		array(
			'name' => __('Divider', 'wpv') ,
			'desc' => __('If enabled, the column will have a vertical divider on the left.', 'wpv'),
			'id' => 'divider',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Class', 'wpv') ,
			'desc' => __('This field is optional. Use in case you have to modify the appearance of this column.', 'wpv'),
			'id' => 'class',
			'default' => '',
			'type' => 'text'
		) ,
	) ,
);
