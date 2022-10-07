<?php
return [
    'timeZone' => 'Europe/Samara',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'language' => 'ru',
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
