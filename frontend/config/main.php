<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [

    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'redactor' => 'yii\redactor\RedactorModule',
    ],
    'components' => [
        'language' => 'ru',
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@backend/views/src/views'
                ],
            ],
        ],

        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'maxSourceLines' => 10,
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
	        'enablePrettyUrl' => true,
	        'showScriptName' => false,
	        //'suffix' => '.html',
	        'rules' => [
		        '' => 'site/index',
//                'deals/page/<page:\d+>' => 'deals/index',
//                'deals' => 'deals/index',
//                'deals/update/<id:\d+>' => 'deals/update',
//                'deals/view/<id:\d+>' => 'deals/view',
//                'doctors' => 'doctors/index',
//                'doctors/update/<id:\d+>' => 'doctors/update',
//                'doctors/view/<id:\d+>' => 'doctors/view',
//                'review/page/<page:\d+>' => 'review/index',
//                'review/page/<page:\d+>' => 'review/index',

                //'<controller:(deals|doctors|review|tasks|branch|tags)>/create' => '<controller>/create',
                '<controller:(deals|doctors|review|tasks|branch|tags|layouts-mail|user)>/<action:(update|delete|view|change-password)>/<id:\d+>' =>
                    '<controller>/<action>',
                '<controller:\w+>/<page:\d+>' => '<controller>/index',
                //'<controller:(deals|doctors|review)>s' => '<controller>/index',
                //'<action>'=>'site<action>',

	        ],
        ],
        'assetManager' => [
	        'basePath' => '@webroot/assets',
	        'baseUrl' => '@web/assets'
        ],
        'request' => [
	        'baseUrl' => ''
        ],


    ],
    'params' => $params,
];
