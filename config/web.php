<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nikkie',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    //'@dektrium/user/views' => '@app/views/user'
                    //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                    '@app/views' => '@app/views/yii2-app'
                ],
            ],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
     'modules' => [
               'gridview' =>  [
                    'class' => '\kartik\grid\Module'
                    // enter optional module parameters below - only if you need to  
                    // use your own export download action or custom translation 
                    // message source
                    // 'downloadAction' => 'gridview/export/download',
                    // 'i18n' => []
                ],
                'user' => [
                    'class' => 'dektrium\user\Module',
                    'enableUnconfirmedLogin' => true,
                    'confirmWithin' => 21600,
                    'cost' => 12,
                    //'admins' => ['admin']
                    'modelMap' => [
                      'RegistrationForm' => 'app\models\RegistrationForm',
                      'User' => 'app\models\User',
                    ]
                ],
                'admin' => [
                   'class' => 'mdm\admin\Module',
                   'layout' => 'left-menu',
                   'controllerMap' => [
                        'assignment' => [
                           'class' => 'mdm\admin\controllers\AssignmentController',
                           'userClassName' => 'dektrium\user\models\User',
                           //เรียกใช้โมเดล user ของ dektrium
                       ]
                   ],
               ],

                'redactor' => 'yii\redactor\RedactorModule',
                'class' => 'yii\redactor\RedactorModule',
                'uploadDir' => '@webroot/uploads',
                'uploadUrl' => '/hello/uploads',
            ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
