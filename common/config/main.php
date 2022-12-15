<?php
return [
    'timeZone' => 'Europe/Samara',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
            'yii\bootstrap4\LinkPager' => [


            ]
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable'       => 'auth_item',
            'itemChildTable'  => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
            'ruleTable'       => 'auth_rule',
            'defaultRoles'    => ['user']
        ],

        'language' => 'ru',
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    // Доступ только авторизованным пользователям
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['api/get-calls'], // Разрешить доступ неавторизованным для экшена (API)
        'rules' => [
            [
                'actions' => ['login'],
                'allow' => true,
            ],
            [

                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
];
