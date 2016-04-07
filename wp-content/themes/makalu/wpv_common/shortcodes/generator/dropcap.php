<?php
return array(
	'name' => __('Drop Cap', 'wpv') ,
	'value' => 'dropcap',
	'options' => array(
		array(
			'name' => __('Type', 'wpv') ,
			'id' => 'type',
			'default' => '1',
			'type' => 'select',
			'options' => array(
				'1' => __('Type 1', 'wpv'),
				'2' => __('Type 2', 'wpv'),
			),
		) ,
		array(
			'name' => __('Text', 'wpv') ,
			'id' => 'text',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
