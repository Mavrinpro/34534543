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
            //'parsers' =>['application/json' => 'yii\web\JsonParser', ],
            'baseUrl' => '',
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
            //'enableStrictParsing' => true,
	        'showScriptName' => false,
	        //'suffix' => '.html',
	        'rules' => [

                //['class' => \yii\rest\UrlRule::class, 'controller' => 'app/frontend/statuses/index'],

                // Правила для API контроллера
                'api/getcalls'   => 'api/get-calls',
                'api/getorders'  => 'api/get-orders',
                'api/statustask'  => 'api/status-task',
                'api/crontask'  => 'api/cron-task',
                'api/getenvibox'  => 'api/get-enxybox',
                //'restApi/users'  => 'rest-api/index',
                /*
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'rest-api',
                    //'restApi/index'  => 'rest-api/index',
                ],
                */

		        //'' => 'site/index',
//                'deals/page/<page:\d+>' => 'deals/index',
//                'deals' => 'deals/index',
//                'deals/update/<id:\d+>' => 'deals/update',
//                'deals/view/<id:\d+>' => 'deals/view',
//                'doctors' => 'doctors/index',
//                'doctors/update/<id:\d+>' => 'doctors/update',
//                'doctors/view/<id:\d+>' => 'doctors/view',
//                'review/page/<page:\d+>' => 'review/index',
//                'review/page/<page:\d+>' => 'review/index',
                //'restApi' => 'restApi/index',

                //'<controller:(deals|doctors|review|tasks|branch|tags)>/create' => '<controller>/create',
                '<controller:(deals|doctors|review|tasks|branch|tags|layouts-mail|user|tracking)>/<action:(index|update|delete|view|change-password)>/<id:\d+>' =>
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


    ],
    'params' => $params,
];
