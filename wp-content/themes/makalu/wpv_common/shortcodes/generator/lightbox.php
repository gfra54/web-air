<?php
return array(
	"name" => "Lightbox",
	"value" => "lightbox",
	"options" => array(
		array(
			"name" => __("Trigger Source", 'wpv') ,
			'desc' => __('You can put any HTML in here, except for links. Try putting some text or an image. When someone click on the text/image the lightbox will open.', 'wpv'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
		array(
			"name" => __("Lightbox Source", 'wpv') ,
			'desc' => __('Put here a link to what is to be displayed in the lightbox.', 'wpv'),
			"id" => "href",
			"size" => 30,
			"default" => "",
			"type" => "text",
		) ,
		array(
			"name" => __("Title", 'wpv') ,
			"desc" => __("The title you want to display on the bottom of the lightbox.", 'wpv') ,
			"id" => "title",
			"size" => 30,
			"default" => "",
			"type" => "text",
		) ,
		array(
			"name" => __("Group (optional)", 'wpv') ,
			"desc" => __("This allows the user to group any combination of elements together for a gallery.", 'wpv') ,
			"id" => "group",
			"default" => '',
			"type" => "text"
		) ,
		array(
			"name" => __("Force Iframe", 'wpv') ,
			"desc" => __("If your source is a embeddable video or a site, you will have to enable this option." , 'wpv') ,
			"id" => "iframe",
			"default" => '',
			"type" => "toggle"
		) ,
	) ,
);
