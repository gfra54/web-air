<?php
return array(
	'name' => __('Block Quotation', 'wpv') ,
	'value' => 'blockquote',
	'options' => array(
		array(
			"name" => __("Cite (optional)", 'wpv') ,
			"id" => "cite",
			"default" => "",
			"type" => "text",
		) ,
		array(
			"name" => __("Content", 'wpv') ,
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
	) ,
);
