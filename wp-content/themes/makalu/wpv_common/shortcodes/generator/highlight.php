<?php

return array(
	"name" => __("Highlight", 'wpv') ,
	"value" => "highlight",
	"options" => array(
		array(
			"name" => __("Type", 'wpv') ,
			"id" => "type",
			"default" => '',
			"options" => array(
				"light" => __("light", 'wpv') ,
				"dark" => __("dark", 'wpv') ,
			) ,
			"type" => "select",
		) ,
		array(
			"name" => __("Content", 'wpv') ,
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
	)
);