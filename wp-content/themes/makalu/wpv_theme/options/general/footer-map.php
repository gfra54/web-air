<?php

return array(
array(
	'name' => __('Footer Map', 'wpv'),
	'type' => 'start'
),

array(
	'name' => __('How do I enable the footer map?', 'wpv'),
	'desc' => __('Paste your Google Maps API Key in the General Settings tab in order to use the map. The map is located between the sub footer and footer. If you need more information on how to set up a map click here: Google Maps API key.', 'wpv'),
	'type' => 'info',
),

array(
	'name' => __('Enable the Footer Map', 'wpv') ,
	'id' => 'enable-fmap',
	'type' => 'toggle',
	'static' => true,
) ,

array(
	'name' => __('Closed Image', 'wpv') ,
	'desc' => __('Since loading the actual map takes some time, a static image will be shown in its place until the "View Map" button is clicked.', 'wpv'),
	'id' => 'fmap-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size',
) ,

array(
	'name' => __('Address (optional)', 'wpv') ,
	'desc' => __('Unless you\'ve filled in the Latitude and Longitude options, please enter the address that you want to be shown on the map. If you encounter any errors about the maximum number of address translation requests per page, you should either use the latitude/longitude options or upgrade to the paid Google Maps API.', 'wpv'),
	'id' => 'fmap-address',
	'type' => 'text',
	'static' => true,
) ,
array(
	'name' => __('Latitude', 'wpv') ,
	'desc' => __('This option is not necessary if an address is set.', 'wpv'),
	'id' => 'fmap-latitude',
	'type' => 'text',
	'static' => true,
) ,
array(
	'name' => __('Longitude', 'wpv') ,
	'desc' => __('This option is not necessary if an address is set.', 'wpv'),
	'id' => 'fmap-longitude',
	'type' => 'text',
	'static' => true,
) ,
array(
	'name' => __('Zoom', 'wpv') ,
	'desc' => __('Default map zoom level.', 'wpv'),
	'id' => 'fmap-zoom',
	'min' => 1,
	'max' => 19,
	'type' => 'range',
	'static' => true,
) ,
array(
	'name' => __('Marker', 'wpv') ,
	'desc' => __('Enable an arrow pointing at the address.', 'wpv'),
	'id' => 'fmap-marker',
	'type' => 'toggle',
	'static' => true,
) ,
array(
	'name' => __('HTML', 'wpv') ,
	'desc' => __('HTML code to be shown in a popup above the marker.', 'wpv'),
	'id' => 'fmap-html',
	'type' => 'text',
	'static' => true,
) ,
array(
	'name' => __('Popup Marker', 'wpv') ,
	'desc' => __('Enable to open the popup above the marker by default.', 'wpv'),
	'id' => 'fmap-popup',
	'type' => 'toggle',
	'static' => true,
) ,
array(
	'name' => __('Controls (optional)', 'wpv') ,
	'desc' => sprintf(__('This option is intended to be used only by advanced users and is not necessary for most use cases. Please refer to the <a href="%s" title="Google Maps API documentation">API documentation</a> for details.', 'wpv'), 'https://developers.google.com/maps/documentation/javascript/controls'),
	'id' => 'fmap-controls',
	'type' => 'text',
	'static' => true,
) ,
array(
	'name' => __('Maptype', 'wpv') ,
	'id' => 'fmap-maptype',
	'options' => array(
		'ROADMAP' => __('Default road map', 'wpv') ,
		'SATELLITE' => __('Google Earth satellite', 'wpv') ,
		'HYBRID' => __('Mixture of normal and satellite', 'wpv') ,
		'TERRAIN' => __('Physical map', 'wpv') ,
	) ,
	'type' => 'select',
	'static' => true,
) ,

array(
	'name' => __('Scrollwheel', 'wpv') ,
	'id' => 'fmap-scrollwheel',
	'type' => 'toggle',
	'static' => true,
) ,
array(
	'name' => __('Color (optional)', 'wpv') ,
	'desc' => __('Defines the overall hue for the map. It is advisable that you avoid gray colors, as they are not well-supported by Google Maps.', 'wpv'),
	'id' => 'fmap-color',
	'prompt' => __('Default', 'wpv') ,
	'options' => array(
		'accent1' => 'accent1',
		'accent2' => 'accent2',
		'accent3' => 'accent3',
		'accent4' => 'accent4',
	) ,
	'type' => 'select',
) ,


array(
	'type' => 'end'
)
);