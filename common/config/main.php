<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'name' => 'Project Management',
	'language' => 'th_TH',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
	'modules' => [
			// ...
			'gii' => [
					'class' => 'yii\gii\Module',
					'generators' => [
							'mongoDbModel' => [
									'class' => 'yii\mongodb\gii\model\Generator'
							]
					],
			],
	]
];
