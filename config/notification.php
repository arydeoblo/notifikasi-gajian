<?php


return [
	'class' => 'app\src\notification\TelegramNotification',
	'notifier' => [
		'email' => [
			'from' => 'your.email@gmail.com'
		],
		'telegram' => [
			'bot_key' => '',
			'chat_id' => '',
		],
	]
];