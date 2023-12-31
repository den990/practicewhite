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
    'bootstrap' => ['log', 'gii'],
    'modules' => [],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'auth' => 'frontend\controllers\AuthController',
        'reg' => 'frontend\controllers\RegisterController',
        'blog' => 'frontend\controllers\BlogsController',
        'comment' => 'frontend\controllers\CommentController',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'charset' => 'UTF-8',
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
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'auth',
                    'pluralize' => false,
                    'only' => ['token', 'authenticate'],
                    'extraPatterns' => [
                        'POST get-access-token' => 'token',
                        'POST <token:[\w-]+>' => 'authenticate',
                    ],
                ],
                'POST api/register' => 'reg/registration',
                'POST createpub' => 'blog/pub',
                'GET publications' => 'blog/get',
                'POST api/addcomment' => 'comment/create',
                'POST api/deletecomment' => 'comment/delete',
                'POST api/get-comments' => 'comment/get-comments'
            ],
        ],
    ],
    'params' => $params,
];
