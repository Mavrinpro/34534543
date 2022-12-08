<?php

$config = [
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'vf-zNVQN7wpvh-R1Vibv2mJEaSz3zm76',
		],
	],
];

    if (!YII_ENV_TEST) {
        // configuration adjustments for 'dev' environment

        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            'on beforeAction'=>function($event) {
                //суть
                $event->isValid = \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId
                    ())['superadmin']->name == 'superadmin';
            },
            ];

        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = ['class' => 'yii\gii\Module',];
    }

return $config;
