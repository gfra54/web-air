<?php
return array(
	'name' => __('Vertical Blank Space', 'wpv') ,
	'value' => 'push',
	'options' => array(
		array(
			"name" => __("Height", 'wpv') ,
			"id" => "h",
			"default" => 30,
			'min' => 1,
			'max' => 100,
			"type" => "range",
		) ,
	) ,
);
