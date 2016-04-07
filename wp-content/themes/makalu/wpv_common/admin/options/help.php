<?php
return array(
	'name' => __('Help', 'wpv'),
	'auto' => true,
	'config' => array(

		array(
			'name' => __('Help', 'wpv'),
			'type' => 'title',
			'desc' => '',
		),

		array(
			'name' => __('Help', 'wpv'),
			'type' => 'start',
			'nosave' => true,
		),
//----
		array(
			'type' => 'docs',
		),

			array(
				'type' => 'end'
			),
		
	)
);