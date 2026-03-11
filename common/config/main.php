<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@upload' => '@frontend/uploaded',
		'@img' => '@frontend/uploaded/images',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
			'formatter' => [
				'dateFormat' => 'php:d M Y',
				'datetimeFormat' => 'php:D d M Y h:i a',
				'decimalSeparator' => '.',
				'thousandSeparator' => ', ',
				'currencyCode' => 'RM',
		   ],
	
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		
		'workflowSource' => [
          'class' => 'raoul2000\workflow\source\file\WorkflowFileSource',
          'definitionLoader' => [
              'class' => 'raoul2000\workflow\source\file\PhpClassLoader',
              'namespace'  => 'common\models'
           ]
		],
    ],
	
	
];
