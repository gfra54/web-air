<?php

return array(
array(
	'name' => __('General Settings', 'wpv'),
	'type' => 'start'
),

array(
	'name' => __('Custom Logo Picture', 'wpv'),
	'desc' => __('Optional way to replace "heading" and "description" text for your website with an image. Leave blank if none required.', 'wpv'),
	'id' => 'custom-header-logo',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('High Resolution Logo', 'wpv'),
	'desc' => __('Optional way to replace "heading" and "description" text for your website with an image. Leave blank if none required.', 'wpv'),
	'id' => 'custom-header-logo2x',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Header Text Area', 'wpv'),
	'desc' => __('You can place text/HTML or any shortcode in this field. The text will appear in the header on the right hand side.', 'wpv'),
	'id' => 'phone-num-top',
	'type' => 'textarea',
	'static' => true,
),

array(
	'name' => __('Favicon', 'wpv'),
	'desc' => __('Upload your custom "favicon" which is visible in browser favourites and tabs. (Must be .png or .ico file - preferably 16px by 16px ). Leave blank if none required.', 'wpv'),
	'id' => 'favicon_url',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Google Maps API Key', 'wpv'),
	'desc' => __("Paste your Google Maps API Key here. If you don't have one, please sign up for a <a href='https://developers.google.com/maps/documentation/javascript/tutorial#api_key'>Google Maps API key</a>.", 'wpv'),
	'id' => 'gmap_api_key',
	'type' => 'text',
	'static' => true,
),

array(
	'name' => __('Google Analytics Key', 'wpv'),
	'desc' => __("Paste your key here. It should be something like UA-XXXXX-X. We're using the faster asynchronous loader, so you don't need to worry about speed.", 'wpv'),
	'id' => 'analytics_key',
	'type' => 'text',
	'static' => true,
),

array(
	'name' => __('"Scroll to Top" Button', 'wpv'),
	'desc' => __('It is found in the bottom right side. It is sole purpose is help the user scroll a long page quickly to the top.', 'wpv'),
	'id' => 'show_scroll_to_top',
	'type' => 'toggle',
),

array(
	'name' => __('Feedback Button', 'wpv'),
	'desc' => __('It is found on the right hand side of your website. You can chose from a "link" or a slide out form(widget area).The slide out form is configured as a standard widget. You can use the same form you are using for your "contact us" page.', 'wpv'),
	'id' => 'feedback-type',
	'type' => 'select',
	'options' => array(
		'none' => __('None', 'wpv'),
		'link' => __('Link', 'wpv'),
		'sidebar' => __('Slide out widget area', 'wpv'),
	),
),

array(
	'name' => __('Feedback Button Link', 'wpv'),
	'desc' => __('If you have chosen a "link" in the option above, place the link of the button here, usually to your contact us page.', 'wpv'),
	'id' => 'feedback-link',
	'type' => 'text',
),

array(
	'name' => __('RSS Button', 'wpv'),
	'desc' => __('More information on what is RSS and how it works <a href="http://codex.wordpress.org/WordPress_Feeds" title="WordPress Feeds">can be found here</a>.', 'wpv'),
	'id' => 'show_rss_button',
	'type' => 'toggle',
),

array(
	'name' => __('Facebook Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a Facebook button on the right hand side of your website. You can forward your users to your Facebook fan page.', 'wpv'),
	'id' => 'fb-link',
	'type' => 'text',
),

array(
	'name' => __('Google+ Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a Google+ button on the right hand side of your website. You can forward your users to your Google+ profile.', 'wpv'),
	'id' => 'gplus-link',
	'type' => 'text',
),

array(
	'name' => __('Twitter Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a Twitter button on the right hand side of your website. You can forward your users to your Twitter account.', 'wpv'),
	'id' => 'twitter-link',
	'type' => 'text',
),

array(
	'name' => __('YouTube Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a YouTube button on the right hand side of your website. You can forward your users to your YouTube videos.', 'wpv'),
	'id' => 'youtube-link',
	'type' => 'text',
),

array(
	'name' => __('Flickr Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a Flickr button on the right hand side of your website. You can forward your users to your Flickr collection.', 'wpv'),
	'id' => 'flickr-link',
	'type' => 'text',
),

array(
	'name' => __('LinkedIn Link', 'wpv'),
	'desc' => __('If you place a link in this field it will enable a LinkedIn button on the right hand side of your website. You can forward your users to your LinkedIn account.', 'wpv'),
	'id' => 'linkedin-link',
	'type' => 'text',
),

array(
	'name' => __('Footer Phone Area', 'wpv'),
	'desc' => __('You can place text/HTML or any shortcode in this field. Leave empty to disable.', 'wpv'),
	'id' => 'footer-phone',
	'type' => 'textarea',
	'static' => true,
),

array(
	'name' => __('Footer Phone Area Color', 'wpv'),
	'desc' => __("We use accent colors to attach most of the theme's design elements to them. The accent colors are located in styles - global colors/background settings.", 'wpv'),
	'id' => 'footer-phone-color',
	'options' => array(
		'accent1' => 'accent1',
		'accent2' => 'accent2',
		'accent3' => 'accent3',
		'accent4' => 'accent4',
		'accent5' => 'accent5',
		'accent6' => 'accent6',
		'accent7' => 'accent7',
		'accent8' => 'accent8',
	) ,
	'type' => 'select',
) ,

array(
	'name' => __('Text Area in Footer', 'wpv'),
	'desc' => __('You can place text/HTML or any shortcode in this field. The text will appear in the  footer of your website.', 'wpv'),
	'id' => 'credits',
	'type' => 'textarea',
	'static' => true,
),

array(
	'name' => __('Share Icons', 'wpv'),
	'desc' => __('Select the social medias you want enabled and for which parts of the website', 'wpv'),
	'type' => 'social',
	'static' => true,
),

array(
	'name' => __('Custom JavaScript', 'wpv'),
	'desc' => __('If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Option Panel please place your javascript in this field. The contents of this field are placed near the <strong>&lt;/body&gt;</strong> tag, which improves the load times of the page.', 'wpv'),
	'id' => 'custom_js',
	'type' => 'textarea',
	'rows' => 15,
	'static' => true,
),

array(
	'name' => __('Custom CSS', 'wpv'),
	'desc' => __('If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Options Panel please place your CSS in this field.', 'wpv'),
	'id' => 'custom_css',
	'type' => 'textarea',
	'rows' => 15,
	'static' => true,
	'class' => 'top-desc',
),

array(
	'type' => 'end'
)
);