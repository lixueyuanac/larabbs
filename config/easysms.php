<?php
return [
	// HTTP 请求的超时时间（秒）
	'timeout' => 5.0,

	// 默认发送配置
	'default' => [
		// 网关调用策略，默认：顺序调用
		'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

		// 默认可用的发送网关
		'gateways' => [
			'tencent_sms',
		],
	],
	// 可用的网关配置
	'gateways' => [
		'errorlog' => [
			'file' => '/tmp/easy-sms.log',
		],
		'tencent_sms' => [
			'sdk_app_id' => env('TENCENT_APP_ID'),
			'app_key' => env('TENCENT_APP_KEY'),
		],
	],
];