<?php

return array(
	"name" => __("Pre & Code", 'wpv') ,
	"value" => "pre_code",
	"options" => array(
		array(
			"name" => __("Type", 'wpv') ,
			"id" => "type",
			"default" => 'code',
			"options" => array(
				"pre" => 'pre',
				"code" => 'code',
			) ,
			"type" => "select",
		) ,
		array(
			"name" => __("Content", 'wpv') ,
			'desc' => __('Any HTML code entered here will be displayed as-is, with preserved whitespace.', 'wpv'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
	)
);