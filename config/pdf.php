<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => 'Migoda',
	'subject'               => 'Migoda Invoice',
	'keywords'              => '',
	'creator'               => 'Migoda',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'FuturaNDCn' => [
			'R'  => 'FuturaNDCn-Medium.ttf',    // regular font
			'B'  => 'FuturaNDCn-Bold.ttf',       // optional: bold font
			'I'  => 'FuturaNDCn-MediumOblique.ttf',     // optional: italic font
			'BI' => 'FuturaNDCn-BoldOblique.ttf' // optional: bold-italic font
			//'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			//'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
];
