<?php

return array(
	"name" => __("Icon", 'wpv') ,
	"value" => "icon",
	"options" => array(
		array(
			"name" => __("Name", 'wpv') ,
			"id" => "name",
			"default" => 'mail',
			"options" => wpv_get_icons_extended(),
			"type" => "select",
		) ,
		array(
			"name" => __("Color (optional)", 'wpv') ,
			"id" => "color",
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
			"type" => "select",
		) ,
		array(
			'name' => __('Size', 'wpv'),
			'id' => 'size',
			'type' => 'range',
			'default' => 16,
			'min' => 8,
			'max' => 100,
		),
		array(
			"name" => __("Style", 'wpv') ,
			"id" => "style",
			"default" => '',
			"prompt" => __('Default', 'wpv'),
			"options" => array(
				'inverted-colors' => __('Invert colors', 'wpv'),
				'box' => __('Box', 'wpv'),
			) ,
			"type" => "select",
		) ,
	)
);