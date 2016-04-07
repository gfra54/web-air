<?php

return array(
array(
	'name' => __('General', 'wpv'),
	'type' => 'start',
),

array(
	'name' => __('Responsive Layout', 'wpv'),
	'desc' => __('Enabling this option will make the layout respond to the screen resolutions.It is useful mostly on mobile phones.', 'wpv'),
	'id' => 'is-responsive',
	'type' => 'toggle',
),

array(
	'name' => __('Layout Type', 'wpv'),
	'desc' => __('You can choose between boxed and full width layout.', 'wpv'),
	'id' => 'site-layout-type',
	'type' => 'select',
	'options' => array(
		'boxed' => __('Boxed', 'wpv'),
		'full' => __('Full width', 'wpv'),
	),
),

	array(
		'type' => 'end'
	),
	
);