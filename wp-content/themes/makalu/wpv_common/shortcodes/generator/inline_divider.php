<?php
return array(
	'name' => __('Divider', 'wpv') ,
	'value' => 'inline_divider',
	'options' => array(
		array(
			'name' => __('Type', 'wpv') ,
			'desc' => __('"Clear floats" is just a div element with <em>clear:both</em> styles. Although it is safe to say that unless you already know how to use it, you will not need this, you can <a href="https://developer.mozilla.org/en-US/docs/CSS/clear">click here for a more detailed description</a>.', 'wpv'),
			'id' => 'type',
			'default' => 1,
			'options' => array(
				1 => __('Divider line (1)', 'wpv') ,
				2 => __('Divider line (2)', 'wpv') ,
				3 => __('Divider line (3)', 'wpv') ,
				'clear' => __('Clear floats', 'wpv') ,
			) ,
			'type' => 'select',
			'class' => 'add-to-container',
		) ,
	) ,
);
