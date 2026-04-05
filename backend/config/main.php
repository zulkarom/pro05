<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
	//'@mdm/admin' => 'path/to/your/extracted',
    'bootstrap' => ['log'],
    'modules' => [
		'admin' => [
            'class' => 'mdm\admin\Module'
        ],
        'esiap' => [
            'class' => 'backend\modules\esiap\Module',
        ],
        'project-admin' => [
            'class' => 'backend\modules\project\Module',
        ],
        'gridview' => [
			'class' => 'kartik\grid\Module',
			// other module settings
		]
		//'rbac' => 'dektrium\rbac\RbacWebModule',
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
		
		'authManager' => [
            'class' => 'yii\rbac\DbManager', 
			//'yii\rbac\PhpManager' or use 
        ],
		
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
             'enableSession' => true,
             'authTimeout' => 1800, //30 minutes
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'class' => 'yii\web\Session',
            'timeout' => 1800,
            'name' => 'advanced-backend',
        ],
		
		'view' => [
			'theme' => [
				'pathMap' => [
					'@mdm/admin/views' => '@backend/views/rbac'
				],
			],
		],
		
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	
	'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
			//'user/*',
            //'admin/*',
			'semester/*',
			'component/*',
			'location/*',
			'slider/*',
			'session-time/*',
			'gii/*',
			'test/*',
            'application-group/*',
			//'application/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
	
    'params' => $params,
];
