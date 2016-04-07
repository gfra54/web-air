<?php

return array(
	"name" => __("Styled List", 'wpv') ,
	"value" => "list",
	"options" => array(
		array(
			"name" => __("Style", 'wpv') ,
			"id" => "style",
			"default" => '',
			"options" => wpv_get_icons_extended() ,
			"type" => "select",
		) ,
		array(
			"name" => __("Color", 'wpv') ,
			"id" => "color",
			"default" => "",
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
			"name" => __("Content", 'wpv') ,
			"desc" => __("Please insert a valid HTML unordered list", 'wpv') ,
			"id" => "content",
			"default" => "<ul>
				<li>list item</li>
				<li>another item</li>
			</ul>",
			"type" => "textarea"
		) ,
	)
);