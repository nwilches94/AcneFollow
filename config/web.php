<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'chWW5zBpQEjK00GyfVR505j_e9zPZ9uO',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],
        
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views/admin' => '@app/views/admin'
                ],
            ],
        ],
        
    ],
    'modules' => [
        'rbac' => 'dektrium\rbac\Module',
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['olivercera'],
            'enableRegistration' => true,
            'controllerMap' => [
                'security' => [
                  'class' => 'dektrium\user\controllers\SecurityController',
                  'layout' => '@app/views/layouts/nomenu',
                ],
            ],
            'modelMap' => [
                'User' => [
                    'class' => 'app\models\User',
                ],
            ],
        ],
        'attachments' => [
            'class' => nemmo\attachments\Module::className(),
            'tempPath' => '@app/uploads/temp',
            'storePath' => '@app/uploads/store',
            'rules' => [ // Rules according to the FileValidator
                'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
                //'mimeTypes' => 'image/png', // Only png images
                'maxSize' => 1024 * 1024 * 10 // 1 MB
            ],
            'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
