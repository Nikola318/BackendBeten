<?php

declare(strict_types=1);

return [
	'languages' => [
		'ar' => 'Arabic',
		'en' => 'English',
		'es' => 'Spaish',
	],
	'adminuser' => 'admin@eogsoft.com',
	'adminusername' => 'admin',
	'contact' => 'Eimad',
	'adminpass' => 'T,W;e0n#4l$QY_',
    
    'gateways'=>[
		'sms'=>[
			'taqnyat'=>[
				'bearer'=>'6ae9a69b9a06dfb7772787c1f1c4dbc4',
				'sender'=>'ArabMotwf',
				'sendsms'=>'taqnyatSendSmsMsg', // find it in helerps/functions.php
			],
		],
    ],
];
