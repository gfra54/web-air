<?php
return array(
	'name' => __('Google Maps', 'wpv') ,
	'desc' => __('In order to enable Google Map you need:<br>
                1.Paste your Google Maps API Key in the General Settings tab . If you need more information on how to set up a map and generate Google Map API Key click here:
               <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" title="Google Maps API key" target="_blank">Google Maps API key</a>


. <br>2. Insert the Google Map element into the editor, open its option panel by clicking on the icon- edit on the right of the element and fill in all fields nesessary.
' , 'wpv'),
		'icon' => array(
		'char' => WPV_Editor::get_icon('location1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'gmap',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Column Title', 'wpv') ,
			'desc' => __('The column title is placed just above the element.', 'wpv'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Column Title Type', 'wpv') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Type 1', 'wpv'),
				'double' => __('Type 2', 'wpv'),
				'no-divider' => __('No Divider', 'wpv'),
			),
		) ,
		array(
			'name' => __('Width (optional)', 'wpv') ,
			'desc' => __('Set to 0 is the full width.', 'wpv') ,
			'id' => 'width',
			'default' => 0,
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Height', 'wpv') ,
			'id' => 'height',
			'default' => '400',
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Address (optional)', 'wpv') ,
			'desc' => __('Unless you\'ve filled in the Latitude and Longitude options, please enter the address that you want to be shown on the map. If you encounter any errors about the maximum number of address translation requests per page, you should either use the latitude/longitude options or upgrade to the paid Google Maps API.', 'wpv'),
			'id' => 'address',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Latitude', 'wpv') ,
			'desc' => __('This option is not necessary if an address is set.', 'wpv'),
			'id' => 'latitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Longitude', 'wpv') ,
			'desc' => __('This option is not necessary if an address is set.', 'wpv'),
			'id' => 'longitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Zoom', 'wpv') ,
			'desc' => __('Default map zoom level.', 'wpv'),
			'id' => 'zoom',
			'default' => '14',
			'min' => 1,
			'max' => 19,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Marker', 'wpv') ,
			'desc' => __('Enable an arrow pointing at the address.', 'wpv'),
			'id' => 'marker',
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('HTML', 'wpv') ,
			'desc' => __('HTML code to be shown in a popup above the marker.', 'wpv'),
			'id' => 'html',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Popup Marker', 'wpv') ,
			'desc' => __('Enable to open the popup above the marker by default.', 'wpv'),
			'id' => 'popup',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Controls (optional)', 'wpv') ,
			'desc' => sprintf(__('This option is intended to be used only by advanced users and is not necessary for most use cases. Please refer to the <a href="%s" title="Google Maps API documentation">API documentation</a> for details.', 'wpv'), 'https://developers.google.com/maps/documentation/javascript/controls'),
			'id' => 'controls',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Scrollwheel', 'wpv') ,
			'id' => 'scrollwheel',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Maptype (optional)', 'wpv') ,
			'id' => 'maptype',
			'default' => 'ROADMAP',
			'options' => array(
				'ROADMAP' => __('Default road map', 'wpv') ,
				'SATELLITE' => __('Google Earth satellite', 'wpv') ,
				'HYBRID' => __('Mixture of normal and satellite', 'wpv') ,
				'TERRAIN' => __('Physical map', 'wpv') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Color (optional)', 'wpv') ,
			'desc' => __('Defines the overall hue for the map. It is advisable that you avoid gray colors, as they are not well-supported by Google Maps.', 'wpv'),
			'id' => 'hue',
			'default' => '',
			'prompt' => __('Default', 'wpv') ,
			'options' => array(
				'accent1' => __('Accent 1', 'wpv'),
				'accent2' => __('Accent 2', 'wpv'),
				'accent3' => __('Accent 3', 'wpv'),
				'accent4' => __('Accent 4', 'wpv'),
				'accent5' => __('Accent 5', 'wpv'),
				'accent6' => __('Accent 6', 'wpv'),
				'accent7' => __('Accent 7', 'wpv'),
				'accent8' => __('Accent 8', 'wpv'),
			) ,
			'type' => 'select',
		) ,
	) ,
);